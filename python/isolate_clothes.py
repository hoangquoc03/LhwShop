from pathlib import Path
import argparse
import sys
import json

import numpy as np
import torch

from PIL import Image, ImageFilter

from transformers import (
    AutoProcessor,
    AutoModelForZeroShotObjectDetection,
    Sam2Processor,
    Sam2Model,
)


# ============================================================
# MODELS
# ============================================================

GROUNDING_MODEL = "IDEA-Research/grounding-dino-tiny"
SAM_MODEL = "facebook/sam2.1-hiera-tiny"


# ============================================================
# DETECTION
# ============================================================

BOX_THRESHOLD = 0.28
TEXT_THRESHOLD = 0.22

PROMPTS = [
    "a denim jacket.",
    "a blue denim jacket.",
    "a jacket.",
]


# ============================================================
# SAM REFINEMENT
# ============================================================

# Số positive points nằm trên jacket
POSITIVE_POINTS = 8

# Số negative points nằm trên áo trong/người
NEGATIVE_POINTS = 8

# Nới box detection một chút
BOX_PADDING_X = 0.035
BOX_PADDING_Y = 0.035


# ============================================================
# OUTPUT CLEANUP
# ============================================================

MIN_COMPONENT_RATIO = 0.0015

MORPH_CLOSE = 5
MORPH_OPEN = 3

CROP_PADDING = 20


# ============================================================
# DEVICE
# ============================================================

def get_device():
    if torch.cuda.is_available():
        return "cuda"

    return "cpu"


# ============================================================
# IMAGE HELPERS
# ============================================================

def rgb_numpy(image):
    return np.asarray(
        image.convert("RGB")
    ).astype(np.uint8)


def make_hsv(image):
    """
    RGB -> HSV dùng OpenCV.
    """
    import cv2

    arr = rgb_numpy(image)

    return cv2.cvtColor(
        arr,
        cv2.COLOR_RGB2HSV
    )


# ============================================================
# COLOR ANALYSIS
# ============================================================

def denim_candidate_mask(image):
    """
    CHỈ dùng màu để tìm điểm positive/negative.

    Quan trọng:
    Không dùng mask này làm alpha.

    Nó chỉ giúp SAM2 biết:
        - điểm nào chắc chắn nằm trên denim
        - điểm nào có khả năng là áo trong
    """

    hsv = make_hsv(image)

    h = hsv[:, :, 0]
    s = hsv[:, :, 1]
    v = hsv[:, :, 2]

    # OpenCV hue:
    # blue thường khoảng 90-135
    blue = (
        (h >= 85)
        &
        (h <= 135)
    )

    reasonably_saturated = (
        s >= 45
    )

    not_too_dark = (
        v >= 25
    )

    denim = (
        blue
        &
        reasonably_saturated
        &
        not_too_dark
    )

    return denim


def shirt_candidate_mask(image):
    """
    Tìm vùng áo trong màu xám/trắng.

    Một lần nữa:
    chỉ dùng để tạo negative points cho SAM.
    """

    hsv = make_hsv(image)

    s = hsv[:, :, 1]
    v = hsv[:, :, 2]

    low_saturation = (
        s <= 45
    )

    visible = (
        v >= 55
    )

    return (
        low_saturation
        &
        visible
    )


# ============================================================
# SAMPLE POINTS
# ============================================================

def sample_points(
    mask,
    count,
    x1,
    y1,
    x2,
    y2,
    margin=0.12,
):
    """
    Lấy points rải đều trong vùng mask.
    """

    ys, xs = np.where(mask)

    if len(xs) == 0:
        return []

    width = x2 - x1
    height = y2 - y1

    left = x1 + width * margin
    right = x2 - width * margin

    top = y1 + height * margin
    bottom = y2 - height * margin

    valid = (
        (xs >= left)
        &
        (xs <= right)
        &
        (ys >= top)
        &
        (ys <= bottom)
    )

    xs = xs[valid]
    ys = ys[valid]

    if len(xs) == 0:
        return []

    # Chọn các điểm phân bố đều.
    indices = np.linspace(
        0,
        len(xs) - 1,
        min(count, len(xs)),
        dtype=int,
    )

    return [
        [
            int(xs[i]),
            int(ys[i]),
        ]
        for i in indices
    ]


# ============================================================
# GROUNDING DINO
# ============================================================

def detect_jacket(
    image,
    processor,
    model,
):
    print(
        "Detecting denim jacket..."
    )

    device = model.device

    best = None

    for prompt in PROMPTS:

        print(
            f"  Prompt: {prompt}"
        )

        inputs = processor(
            images=image,
            text=prompt,
            return_tensors="pt",
        ).to(device)

        with torch.inference_mode():

            outputs = model(
                **inputs
            )

        results = (
            processor
            .post_process_grounded_object_detection(
                outputs,
                inputs.input_ids,
                threshold=BOX_THRESHOLD,
                text_threshold=TEXT_THRESHOLD,
                target_sizes=[
                    (
                        image.height,
                        image.width,
                    )
                ],
            )
        )

        result = results[0]

        boxes = result.get(
            "boxes",
            []
        )

        scores = result.get(
            "scores",
            []
        )

        labels = result.get(
            "text_labels",
            []
        )

        for i, box in enumerate(boxes):

            score = float(
                scores[i]
            )

            box_values = [
                float(x)
                for x in box.tolist()
            ]

            print(
                f"    score={score:.3f} "
                f"box={box_values}"
            )

            candidate = {
                "box": box_values,
                "score": score,
                "label": (
                    str(labels[i])
                    if len(labels) > i
                    else prompt
                ),
            }

            if (
                best is None
                or candidate["score"]
                > best["score"]
            ):
                best = candidate

    if best is None:
        raise RuntimeError(
            "Không detect được denim jacket."
        )

    print(
        ""
    )

    print(
        "BEST DETECTION:"
    )

    print(
        f"  label: {best['label']}"
    )

    print(
        f"  score: {best['score']:.3f}"
    )

    print(
        f"  box: {best['box']}"
    )

    return best


# ============================================================
# BOX PADDING
# ============================================================

def expand_box(
    box,
    width,
    height,
):
    x1, y1, x2, y2 = box

    bw = x2 - x1
    bh = y2 - y1

    x1 -= bw * BOX_PADDING_X
    x2 += bw * BOX_PADDING_X

    y1 -= bh * BOX_PADDING_Y
    y2 += bh * BOX_PADDING_Y

    x1 = max(
        0,
        int(round(x1))
    )

    y1 = max(
        0,
        int(round(y1))
    )

    x2 = min(
        width - 1,
        int(round(x2))
    )

    y2 = min(
        height - 1,
        int(round(y2))
    )

    return [
        x1,
        y1,
        x2,
        y2,
    ]


# ============================================================
# SAM2
# ============================================================

def segment_jacket(
    image,
    box,
    sam_processor,
    sam_model,
):
    print("")
    print(
        "Building SAM2 prompts..."
    )

    x1, y1, x2, y2 = box

    denim = denim_candidate_mask(
        image
    )

    shirt = shirt_candidate_mask(
        image
    )

    positive_points = sample_points(
        denim,
        POSITIVE_POINTS,
        x1,
        y1,
        x2,
        y2,
        margin=0.08,
    )

    negative_points = sample_points(
        shirt,
        NEGATIVE_POINTS,
        int(x1 + (x2 - x1) * 0.20),
        int(y1 + (y2 - y1) * 0.10),
        int(x1 + (x2 - x1) * 0.80),
        int(y1 + (y2 - y1) * 0.92),
        margin=0.15,
    )

    # --------------------------------------------------------
    # Loại negative point nằm quá gần positive point.
    # --------------------------------------------------------

    filtered_negative = []

    for neg in negative_points:

        too_close = False

        for pos in positive_points:

            dx = neg[0] - pos[0]
            dy = neg[1] - pos[1]

            distance = (
                dx * dx
                + dy * dy
            ) ** 0.5

            if distance < 35:
                too_close = True
                break

        if not too_close:
            filtered_negative.append(
                neg
            )

    negative_points = filtered_negative

    print(
        f"  Positive points: "
        f"{len(positive_points)}"
    )

    print(
        f"  Negative points: "
        f"{len(negative_points)}"
    )

    # --------------------------------------------------------
    # Nếu không tìm được điểm denim:
    # lấy một số điểm an toàn trong box.
    # --------------------------------------------------------

    if len(positive_points) < 3:

        positive_points = [
            [
                int(
                    x1
                    + (x2 - x1) * 0.30
                ),
                int(
                    y1
                    + (y2 - y1) * 0.35
                ),
            ],
            [
                int(
                    x1
                    + (x2 - x1) * 0.70
                ),
                int(
                    y1
                    + (y2 - y1) * 0.35
                ),
            ],
            [
                int(
                    x1
                    + (x2 - x1) * 0.30
                ),
                int(
                    y1
                    + (y2 - y1) * 0.65
                ),
            ],
            [
                int(
                    x1
                    + (x2 - x1) * 0.70
                ),
                int(
                    y1
                    + (y2 - y1) * 0.65
                ),
            ],
        ]

    points = (
        positive_points
        + negative_points
    )

    labels = (
        [1] * len(positive_points)
        + [0] * len(negative_points)
    )

    input_points = [
        [
            points
        ]
    ]

    input_labels = [
        [
            labels
        ]
    ]

    input_boxes = [
        [
            box
        ]
    ]

    device = sam_model.device

    print(
        "Running SAM2..."
    )

    inputs = sam_processor(
        images=image,
        input_points=input_points,
        input_labels=input_labels,
        input_boxes=input_boxes,
        return_tensors="pt",
    ).to(device)

    with torch.inference_mode():

        outputs = sam_model(
            **inputs,
            multimask_output=True,
        )

    masks = (
        sam_processor
        .post_process_masks(
            outputs.pred_masks.cpu(),
            inputs["original_sizes"],
        )[0]
    )

    iou_scores = (
        outputs.iou_scores
        .detach()
        .cpu()
    )

    # ========================================================
    # Normalize output dimensions
    # ========================================================

    masks_np = masks.numpy()

    scores_np = iou_scores.numpy()

    # SAM2 thường trả:
    #
    # [objects, masks, H, W]
    #
    # Với 1 object:
    # [1, 3, H, W]

    if masks_np.ndim == 4:

        object_masks = masks_np[0]

    elif masks_np.ndim == 3:

        object_masks = masks_np

    else:

        raise RuntimeError(
            f"Unexpected SAM2 mask shape: "
            f"{masks_np.shape}"
        )

    scores_flat = (
        scores_np.reshape(-1)
    )

    print(
        f"  SAM masks: "
        f"{len(object_masks)}"
    )

    # ========================================================
    # Chọn mask tốt nhất
    # ========================================================

    best_index = 0

    best_score = -1

    for i, mask in enumerate(
        object_masks
    ):

        mask_bool = (
            mask > 0
        )

        positive_hits = 0

        for x, y in positive_points:

            if (
                0 <= y < mask_bool.shape[0]
                and
                0 <= x < mask_bool.shape[1]
                and
                mask_bool[y, x]
            ):
                positive_hits += 1

        negative_hits = 0

        for x, y in negative_points:

            if (
                0 <= y < mask_bool.shape[0]
                and
                0 <= x < mask_bool.shape[1]
                and
                mask_bool[y, x]
            ):
                negative_hits += 1

        iou = (
            float(scores_flat[i])
            if i < len(scores_flat)
            else 0.0
        )

        # Ưu tiên:
        # - giữ positive
        # - bỏ negative
        # - IoU cao

        score = (
            iou * 2.0
            + positive_hits * 0.25
            - negative_hits * 0.60
        )

        print(
            f"    mask {i}: "
            f"iou={iou:.3f}, "
            f"+={positive_hits}, "
            f"-={negative_hits}, "
            f"score={score:.3f}"
        )

        if score > best_score:

            best_score = score
            best_index = i

    final_mask = (
        object_masks[best_index]
        > 0
    )

    print(
        f"  Selected mask: "
        f"{best_index}"
    )

    return final_mask


# ============================================================
# MASK CLEANUP
# ============================================================

def cleanup_mask(mask):
    """
    Cleanup nhẹ.

    KHÔNG dùng màu để khoét jacket.
    """

    import cv2

    mask_uint8 = (
        mask.astype(np.uint8)
        * 255
    )

    # Close nhỏ để vá lỗ rất nhỏ.
    kernel_close = cv2.getStructuringElement(
        cv2.MORPH_ELLIPSE,
        (
            MORPH_CLOSE,
            MORPH_CLOSE,
        ),
    )

    mask_uint8 = cv2.morphologyEx(
        mask_uint8,
        cv2.MORPH_CLOSE,
        kernel_close,
    )

    # Open rất nhẹ để loại noise.
    kernel_open = cv2.getStructuringElement(
        cv2.MORPH_ELLIPSE,
        (
            MORPH_OPEN,
            MORPH_OPEN,
        ),
    )

    mask_uint8 = cv2.morphologyEx(
        mask_uint8,
        cv2.MORPH_OPEN,
        kernel_open,
    )

    # ========================================================
    # Giữ các component lớn.
    # ========================================================

    num_labels, labels, stats, _ = (
        cv2.connectedComponentsWithStats(
            mask_uint8,
            connectivity=8,
        )
    )

    if num_labels > 1:

        image_area = (
            mask_uint8.shape[0]
            * mask_uint8.shape[1]
        )

        cleaned = np.zeros_like(
            mask_uint8
        )

        for label in range(
            1,
            num_labels
        ):

            area = stats[
                label,
                cv2.CC_STAT_AREA
            ]

            if (
                area
                >= image_area
                * MIN_COMPONENT_RATIO
            ):

                cleaned[
                    labels == label
                ] = 255

        mask_uint8 = cleaned

    return (
        mask_uint8 > 127
    )


# ============================================================
# OUTPUT
# ============================================================

def save_result(
    image,
    mask,
    output_path,
):
    alpha = (
        mask.astype(np.uint8)
        * 255
    )

    result = image.convert(
        "RGBA"
    )

    result.putalpha(
        Image.fromarray(
            alpha,
            mode="L",
        )
    )

    # ========================================================
    # Crop
    # ========================================================

    alpha_image = result.getchannel(
        "A"
    )

    bbox = alpha_image.getbbox()

    if bbox:

        left, top, right, bottom = bbox

        left = max(
            0,
            left - CROP_PADDING
        )

        top = max(
            0,
            top - CROP_PADDING
        )

        right = min(
            result.width,
            right + CROP_PADDING
        )

        bottom = min(
            result.height,
            bottom + CROP_PADDING
        )

        result = result.crop(
            (
                left,
                top,
                right,
                bottom,
            )
        )

    output_path.parent.mkdir(
        parents=True,
        exist_ok=True,
    )

    result.save(
        output_path,
        "PNG",
    )

    return result


# ============================================================
# DEBUG IMAGE
# ============================================================

def save_debug(
    image,
    mask,
    box,
    output_path,
):
    """
    Tạo ảnh debug:
    - jacket mask
    - detection box
    """

    import cv2

    arr = np.asarray(
        image.convert("RGB")
    ).copy()

    mask_uint8 = (
        mask.astype(np.uint8)
        * 255
    )

    # Overlay mask.
    overlay = arr.copy()

    overlay[
        mask_uint8 > 0
    ] = (
        overlay[
            mask_uint8 > 0
        ] * 0.55
        + np.array(
            [255, 255, 255]
        ) * 0.45
    ).astype(np.uint8)

    x1, y1, x2, y2 = box

    cv2.rectangle(
        overlay,
        (x1, y1),
        (x2, y2),
        (255, 0, 0),
        3,
    )

    output_path.parent.mkdir(
        parents=True,
        exist_ok=True,
    )

    Image.fromarray(
        overlay
    ).save(
        output_path
    )


# ============================================================
# PROCESS ONE IMAGE
# ============================================================

def process_image(
    input_path,
    output_path,
    debug_path,
    dino_processor,
    dino_model,
    sam_processor,
    sam_model,
):
    print("")
    print("=" * 70)
    print(
        f"PROCESSING: {input_path.name}"
    )
    print("=" * 70)

    image = Image.open(
        input_path
    ).convert("RGB")

    print(
        f"Image size: "
        f"{image.width}x{image.height}"
    )

    # ========================================================
    # 1. Grounding DINO
    # ========================================================

    detection = detect_jacket(
        image,
        dino_processor,
        dino_model,
    )

    box = expand_box(
        detection["box"],
        image.width,
        image.height,
    )

    print(
        f"Expanded box: {box}"
    )

    # ========================================================
    # 2. SAM2
    # ========================================================

    mask = segment_jacket(
        image,
        box,
        sam_processor,
        sam_model,
    )

    # ========================================================
    # 3. Cleanup
    # ========================================================

    mask = cleanup_mask(
        mask
    )

    # ========================================================
    # 4. Save
    # ========================================================

    result = save_result(
        image,
        mask,
        output_path,
    )

    save_debug(
        image,
        mask,
        box,
        debug_path,
    )

    visible = np.count_nonzero(
        mask
    )

    total = mask.size

    ratio = (
        visible / total * 100
        if total
        else 0
    )

    print("")
    print(
        f"Jacket coverage: "
        f"{ratio:.2f}%"
    )

    print(
        f"OUTPUT: "
        f"{output_path}"
    )

    print(
        f"DEBUG: "
        f"{debug_path}"
    )

    return {
        "input": str(input_path),
        "output": str(output_path),
        "debug": str(debug_path),
        "detection": detection,
        "box": box,
        "coverage": ratio,
    }


# ============================================================
# MAIN
# ============================================================

def main():

    parser = argparse.ArgumentParser()

    parser.add_argument(
        "--input",
        required=True,
    )

    parser.add_argument(
        "--output",
        required=True,
    )

    parser.add_argument(
        "--debug",
        default=None,
    )

    args = parser.parse_args()

    input_path = Path(
        args.input
    )

    output_path = Path(
        args.output
    )

    if not input_path.exists():

        print(
            f"ERROR: Không tìm thấy: "
            f"{input_path}"
        )

        return 1

    if args.debug:

        debug_path = Path(
            args.debug
        )

    else:

        debug_path = (
            output_path.parent
            / "debug"
            / output_path.name
        )

    # ========================================================
    # Device
    # ========================================================

    device = get_device()

    print("")
    print(
        "============================================================"
    )

    print(
        "PROFESSIONAL JACKET ISOLATION"
    )

    print(
        "============================================================"
    )

    print(
        f"Device: {device}"
    )

    print(
        f"Grounding DINO: "
        f"{GROUNDING_MODEL}"
    )

    print(
        f"SAM2: {SAM_MODEL}"
    )

    print("")

    # ========================================================
    # Load Grounding DINO
    # ========================================================

    print(
        "Loading Grounding DINO..."
    )

    dino_processor = (
        AutoProcessor
        .from_pretrained(
            GROUNDING_MODEL
        )
    )

    dino_model = (
        AutoModelForZeroShotObjectDetection
        .from_pretrained(
            GROUNDING_MODEL
        )
        .to(device)
    )

    dino_model.eval()

    print(
        "Grounding DINO loaded."
    )

    # ========================================================
    # Load SAM2
    # ========================================================

    print(
        "Loading SAM2..."
    )

    sam_processor = (
        Sam2Processor
        .from_pretrained(
            SAM_MODEL
        )
    )

    sam_model = (
        Sam2Model
        .from_pretrained(
            SAM_MODEL
        )
        .to(device)
    )

    sam_model.eval()

    print(
        "SAM2 loaded."
    )

    # ========================================================
    # Process
    # ========================================================

    try:

        result = process_image(
            input_path,
            output_path,
            debug_path,
            dino_processor,
            dino_model,
            sam_processor,
            sam_model,
        )

    except Exception as e:

        print("")
        print(
            "ERROR:"
        )

        print(
            repr(e)
        )

        return 1

    # ========================================================
    # Save metadata
    # ========================================================

    metadata_path = (
        output_path.parent
        / "isolation.json"
    )

    with open(
        metadata_path,
        "w",
        encoding="utf-8",
    ) as f:

        json.dump(
            result,
            f,
            ensure_ascii=False,
            indent=2,
        )

    print("")
    print(
        "============================================================"
    )

    print(
        "DONE"
    )

    print(
        f"Metadata: "
        f"{metadata_path}"
    )

    print(
        "============================================================"
    )

    return 0


if __name__ == "__main__":
    sys.exit(
        main()
    )