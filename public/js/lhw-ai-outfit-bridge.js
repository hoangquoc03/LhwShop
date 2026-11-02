/*
 * LHW AI Outfit -> 3D Mix Studio bridge
 * Place this classic script AFTER window.LHW_FITTING_CONFIG is declared
 * and BEFORE <script type="module" src="/js/lhw-fitting-room.js"></script>.
 */
(() => {
    "use strict";

    const params = new URLSearchParams(window.location.search);
    if (params.get("source") !== "ai-outfit") return;

    const config = window.LHW_FITTING_CONFIG;
    if (!config) {
        console.error("[LHW Fitting] Thiếu window.LHW_FITTING_CONFIG. Đặt bridge sau script cấu hình.");
        return;
    }

    function positiveId(value) {
        const id = Number(value);
        return Number.isSafeInteger(id) && id > 0 ? id : null;
    }

    function parseItems() {
        try {
            const parsed = JSON.parse(params.get("items") || "[]");
            return Array.isArray(parsed) ? parsed : [];
        } catch (error) {
            console.error("[LHW Fitting] Query items JSON không hợp lệ:", error);
            return [];
        }
    }

    function normalizeRole(role, fallbackCategory = "generic") {
        const key = String(role || "")
            .trim()
            .toLowerCase()
            .replace(/[đĐ]/g, "d")
            .normalize("NFD")
            .replace(/[\u0300-\u036f]/g, "")
            .replace(/[^a-z0-9]+/g, "");

        const roleMap = {
            top: "top", ao: "top", aokhoac: "top", aosomi: "top", aothun: "top",
            shirt: "top", outerwear: "top", blouse: "top", polo: "top", tshirt: "top",
            bottom: "bottom", quan: "bottom", quanjean: "bottom", pants: "bottom",
            trousers: "bottom", jeans: "bottom", skirt: "bottom", vay: "bottom",
            shoes: "shoes", shoe: "shoes", giay: "shoes", sneaker: "shoes", footwear: "shoes", boot: "shoes",
            hat: "hat", mu: "hat", non: "hat", cap: "hat", beanie: "hat",
            glasses: "glasses", glass: "glasses", kinh: "glasses", sunglass: "glasses", eyeglass: "glasses",
            necklace: "necklace", daychuyen: "necklace", vongco: "necklace", pendant: "necklace", chain: "necklace",
            scarf: "scarf", khan: "scarf", tie: "scarf", cravat: "scarf", cavat: "scarf",
            bag: "bag", tui: "bag", balo: "bag", handbag: "bag", backpack: "bag", purse: "bag", tote: "bag",
            wrist: "wrist", watch: "wrist", dongho: "wrist", vongtay: "wrist", bracelet: "wrist",
            accessory: "accessory", phukien: "accessory",
            generic: "generic", unclassified: "generic", model: "generic"
        };

        if (roleMap[key]) return roleMap[key];

        const allowed = new Set([
            "top", "bottom", "shoes", "hat", "glasses", "necklace",
            "scarf", "bag", "wrist", "accessory", "generic"
        ]);
        const fallback = String(fallbackCategory || "").trim().toLowerCase();
        return allowed.has(fallback) ? fallback : "generic";
    }

    const parsedItems = parseItems();
    const queryIds = [
        ...params.getAll("product_ids[]"),
        ...(params.get("products") || "").split(","),
    ].map(positiveId).filter(Boolean);

    const explicitSlots = {
        top: positiveId(params.get("top_id")),
        bottom: positiveId(params.get("bottom_id")),
        shoes: positiveId(params.get("shoes_id")),
    };

    const itemsById = new Map();
    for (const raw of parsedItems) {
        if (!raw || typeof raw !== "object") continue;
        const id = positiveId(raw.id ?? raw.product_id);
        if (!id || itemsById.has(id)) continue;
        itemsById.set(id, {
            id,
            product_id: id,
            role: String(raw.role || raw.category || ""),
            name: String(raw.name || raw.product_name || `Sản phẩm #${id}`),
            product_name: String(raw.name || raw.product_name || `Sản phẩm #${id}`),
            model_3d: raw.model_3d || raw.model_url || null,
        });
    }

    for (const id of queryIds) {
        if (itemsById.has(id)) continue;
        const explicitRole = Object.entries(explicitSlots)
            .find(([, slotId]) => slotId === id)?.[0] || "";
        itemsById.set(id, {
            id,
            product_id: id,
            role: explicitRole,
            name: `Sản phẩm #${id}`,
            product_name: `Sản phẩm #${id}`,
        });
    }

    const cleanItems = [...itemsById.values()];
    if (!cleanItems.length) {
        console.warn("[LHW Fitting] URL ai-outfit không có product ID hợp lệ.");
        return;
    }

    if (!Array.isArray(config.productCatalog)) config.productCatalog = [];

    function catalogEntriesFor(id) {
        return config.productCatalog.filter((entry) =>
            String(entry.productId ?? entry.product_id ?? "") === String(id)
        );
    }

    function findCatalogEntry(item, category) {
        const candidates = catalogEntriesFor(item.id);
        if (!candidates.length) return null;

        if (category === "shoes") {
            const pair = candidates.find((entry) => entry.leftShoeUrl && entry.rightShoeUrl);
            if (pair) return pair;
        }

        const categoryMatch = candidates.find((entry) => String(entry.category || "").toLowerCase() === category);
        if (categoryMatch) return categoryMatch;

        const standardModel = candidates.find((entry) => /\/product\.(glb|gltf)(?:[?#].*)?$/i.test(String(entry.url || entry.path || "")));
        return standardModel || candidates[0];
    }

    // Resolve product files now, before the Three.js module reads productCatalog.
    // This also gives the engine a catalog entry for products supplied only in productAssets.
    for (const item of cleanItems) {
        let entry = findCatalogEntry(item, normalizeRole(item.role));
        const assets = config.productAssets?.[String(item.id)] || {};
        const category = normalizeRole(item.role, entry?.category);

        if (!entry) {
            if (category === "shoes" && assets.leftShoeUrl && assets.rightShoeUrl) {
                entry = {
                    id: `ai-shoe-pair-${item.id}`,
                    productId: String(item.id),
                    label: item.name,
                    path: `${assets.leftShoeUrl} + ${assets.rightShoeUrl}`,
                    url: `pair:shoes:${item.id}`,
                    category: "shoes",
                    leftShoeUrl: assets.leftShoeUrl,
                    rightShoeUrl: assets.rightShoeUrl,
                };
            } else {
                const url = assets.modelUrl || item.model_3d || `/models/products/${item.id}/product.glb`;
                entry = {
                    id: `ai-product-${item.id}`,
                    productId: String(item.id),
                    label: item.name,
                    path: url,
                    url,
                    category,
                };
            }
            config.productCatalog.push(entry);
        }

        // Keep the AI/database product name and AI role on the catalog entry.
        if (item.name && (!entry.label || /^Sản phẩm #\d+$/u.test(entry.label))) {
            entry.label = item.name;
        }
        entry.category = category;
        item.category = category;
        item.catalogUrl = entry.url;
    }

    const byRole = (role) => cleanItems.find((item) => item.category === role) || null;
    const outfit = {
        outfit_name: params.get("outfit_name") || "Outfit AI đề xuất",
        style: params.get("style") || "",
        occasion: params.get("occasion") || "",
        products: cleanItems,
        top: byRole("top"),
        bottom: byRole("bottom"),
        shoes: byRole("shoes"),
        dress: cleanItems.find((item) => normalizeRole(item.role) === "generic") || null,
    };

    window.LHW_AI_OUTFIT_FROM_QUERY = outfit;
    config.initialOutfitItems = cleanItems;
    config.initialOutfitName = outfit.outfit_name;
    config.outfit = {
        ...(config.outfit || {}),
        ...(outfit.top ? { top: outfit.top.product_id } : {}),
        ...(outfit.bottom ? { bottom: outfit.bottom.product_id } : {}),
        ...(outfit.shoes ? { shoes: outfit.shoes.product_id } : {}),
    };

    console.info("[LHW Fitting] Đã chuẩn bị outfit AI:", {
        products: cleanItems,
        configOutfit: config.outfit,
        catalogEntries: config.productCatalog.length,
    });

    function waitForCatalogEngine(timeoutMs = 30000) {
        return new Promise((resolve, reject) => {
            const startedAt = Date.now();
            const poll = () => {
                const api = window.LHWFittingDebug;
                const avatarReady = Boolean(api?.avatar && api?.anchors?.pelvis);
                const catalogReady = typeof api?.addCatalogItem === "function" &&
                    typeof api?.clearCatalogItems === "function";
                const hiddenAsRequested = config.viewer?.catalogMode !== true || api?.avatar?.visible === false;

                if (avatarReady && catalogReady && hiddenAsRequested) {
                    resolve(api);
                    return;
                }
                if (Date.now() - startedAt >= timeoutMs) {
                    reject(new Error("Hết thời gian chờ Three.js/Avatar. Kiểm tra lỗi tải avatar.glb và lhw-fitting-room.js trong Console."));
                    return;
                }
                window.setTimeout(poll, 120);
            };
            poll();
        });
    }

    async function loadOutfitIntoScene() {
        try {
            const api = await waitForCatalogEngine();
            api.clearCatalogItems();

            const loaded = [];
            const failed = [];

            for (const item of cleanItems) {
                const category = item.category || normalizeRole(item.role);
                const entry = findCatalogEntry(item, category);
                const url = entry?.url;

                if (!url) {
                    failed.push({ id: item.id, name: item.name, reason: "Không tìm thấy URL model trong productCatalog." });
                    continue;
                }

                try {
                    await api.addCatalogItem(url, category, entry.label || item.name);
                    loaded.push({ id: item.id, name: entry.label || item.name, category, url });
                } catch (error) {
                    failed.push({ id: item.id, name: item.name, reason: error?.message || String(error) });
                }
            }

            const summary = { loaded: loaded.length, total: cleanItems.length, failed, items: loaded };
            window.LHW_AI_OUTFIT_LOAD_RESULT = summary;
            console.info("[LHW Fitting] Kết quả nạp outfit AI:", summary);

            const status = document.getElementById("fittingStatus");
            if (status) {
                status.textContent = failed.length
                    ? `Đã nạp ${loaded.length}/${cleanItems.length} sản phẩm. Có ${failed.length} sản phẩm chưa tải được; xem Console để biết chi tiết.`
                    : `Đã nạp đầy đủ ${loaded.length} sản phẩm từ outfit AI: ${outfit.outfit_name}.`;
            }
        } catch (error) {
            console.error("[LHW Fitting] Không thể tự động nạp outfit AI:", error);
            const status = document.getElementById("fittingStatus");
            if (status) status.textContent = `Không thể nạp outfit AI: ${error.message}`;
        }
    }

    if (document.readyState === "complete") {
        loadOutfitIntoScene();
    } else {
        window.addEventListener("load", loadOutfitIntoScene, { once: true });
    }
})();
