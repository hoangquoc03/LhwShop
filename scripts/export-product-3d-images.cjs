const { chromium } = require("playwright");
const fs = require("fs");
const path = require("path");

async function main() {
    const args = process.argv.slice(2);

    const productId = args[0];
    const outputDir = args[1];
    const urlsJson = args[2];

    if (!productId || !outputDir || !urlsJson) {
        console.error(
            "Usage: node export-product-3d-images.cjs <productId> <outputDir> <urlsJson>",
        );
        process.exit(1);
    }

    let urls;

    try {
        urls = JSON.parse(urlsJson);
    } catch (error) {
        console.error("Không thể parse URLs JSON:", error.message);
        process.exit(1);
    }

    fs.mkdirSync(outputDir, { recursive: true });

    console.log(`Product ID: ${productId}`);
    console.log(`Số ảnh: ${urls.length}`);
    console.log("");

    /*
     * Tìm Chrome thật trên Windows.
     */
    const chromeCandidates = [
        process.env.PROGRAMFILES
            ? path.join(
                  process.env.PROGRAMFILES,
                  "Google",
                  "Chrome",
                  "Application",
                  "chrome.exe",
              )
            : null,

        process.env["PROGRAMFILES(X86)"]
            ? path.join(
                  process.env["PROGRAMFILES(X86)"],
                  "Google",
                  "Chrome",
                  "Application",
                  "chrome.exe",
              )
            : null,

        process.env.LOCALAPPDATA
            ? path.join(
                  process.env.LOCALAPPDATA,
                  "Google",
                  "Chrome",
                  "Application",
                  "chrome.exe",
              )
            : null,
    ].filter(Boolean);

    const chromePath = chromeCandidates.find((file) => fs.existsSync(file));

    /*
     * QUAN TRỌNG:
     *
     * Dùng headless: false để Chrome thực sự chạy như
     * Chrome mà bạn đang dùng và mở được ảnh.
     *
     * Sau khi xác nhận hoạt động có thể thử headless.
     */
    const launchOptions = {
        headless: false,

        viewport: {
            width: 1200,
            height: 1200,
        },

        locale: "vi-VN",

        timezoneId: "Asia/Ho_Chi_Minh",

        args: ["--disable-blink-features=AutomationControlled"],
    };

    if (chromePath) {
        launchOptions.executablePath = chromePath;

        console.log("Browser: Chrome");
        console.log(`Path: ${chromePath}`);
    } else {
        console.log("Browser: Playwright Chromium");
    }

    console.log("");

    const browser = await chromium.launch(launchOptions);

    const context = await browser.newContext({
        viewport: {
            width: 1200,
            height: 1200,
        },

        locale: "vi-VN",

        timezoneId: "Asia/Ho_Chi_Minh",

        userAgent:
            "Mozilla/5.0 (Windows NT 10.0; Win64; x64) " +
            "AppleWebKit/537.36 (KHTML, like Gecko) " +
            "Chrome/140.0.0.0 Safari/537.36",

        extraHTTPHeaders: {
            "Accept-Language": "vi-VN,vi;q=0.9,en-US;q=0.8,en;q=0.7",
        },
    });

    const page = await context.newPage();

    /*
     * Theo dõi request/response để debug CDN.
     */
    page.on("response", (response) => {
        const url = response.url();

        if (url.includes("louisvuitton.com/images/")) {
            console.log(`  CDN response: ${response.status()}`);
        }
    });

    const results = [];

    for (let i = 0; i < urls.length; i++) {
        const number = String(i + 1).padStart(2, "0");
        const sourceUrl = urls[i];

        const outputFile = path.join(outputDir, `${number}.png`);

        console.log(`[${number}] Downloading...`);

        try {
            /*
             * QUAN TRỌNG:
             *
             * Không dùng page.setContent + img.src nữa.
             *
             * Chrome sẽ NAVIGATE trực tiếp tới URL ảnh,
             * giống như người dùng paste URL vào Chrome.
             */
            const response = await page.goto(sourceUrl, {
                waitUntil: "domcontentloaded",
                timeout: 60000,
            });

            if (response) {
                console.log(`  HTTP: ${response.status()}`);
            }

            /*
             * Chờ browser render ảnh.
             */
            await page.waitForTimeout(3000);

            /*
             * Lấy kích thước ảnh đang hiển thị.
             */
            const dimensions = await page.evaluate(() => {
                const image = document.querySelector("img");

                if (!image) {
                    return null;
                }

                return {
                    naturalWidth: image.naturalWidth,

                    naturalHeight: image.naturalHeight,

                    clientWidth: image.clientWidth,

                    clientHeight: image.clientHeight,
                };
            });

            /*
             * Một số Chrome image document có thể chưa
             * expose img theo cách thông thường.
             *
             * Vì vậy lấy kích thước viewport/content.
             */
            const bodyInfo = await page.evaluate(() => {
                const body = document.body;

                return {
                    width: body ? body.scrollWidth : 0,

                    height: body ? body.scrollHeight : 0,

                    html: document.documentElement
                        ? document.documentElement.outerHTML.slice(0, 500)
                        : "",
                };
            });

            console.log(
                `  Image: ${
                    dimensions
                        ? `${dimensions.naturalWidth}x${dimensions.naturalHeight}`
                        : "not detected"
                }`,
            );

            console.log(`  Page: ${bodyInfo.width}x${bodyInfo.height}`);

            /*
             * Screenshot toàn bộ page.
             *
             * Nếu CDN trả AVIF/WebP thì Chrome vẫn render,
             * nhưng screenshot đầu ra là PNG.
             */
            await page.screenshot({
                path: outputFile,
                type: "png",
                fullPage: true,
            });

            if (!fs.existsSync(outputFile)) {
                throw new Error("Không tạo được file PNG");
            }

            const stat = fs.statSync(outputFile);

            if (stat.size === 0) {
                throw new Error("File PNG có kích thước 0 bytes");
            }

            /*
             * Nếu page quá nhỏ thì khả năng cao Chrome
             * đang nhận trang lỗi thay vì ảnh.
             */
            if (bodyInfo.width < 100 || bodyInfo.height < 100) {
                throw new Error(
                    `Kích thước trang bất thường: ` +
                        `${bodyInfo.width}x${bodyInfo.height}`,
                );
            }

            console.log(`[${number}] OK: ${stat.size} bytes`);

            results.push({
                index: i + 1,
                filename: `${number}.png`,
                source_url: sourceUrl,
                width: dimensions?.naturalWidth || bodyInfo.width,
                height: dimensions?.naturalHeight || bodyInfo.height,
                size: stat.size,
                status: "success",
            });
        } catch (error) {
            console.log(`[${number}] FAILED: ${error.message}`);

            results.push({
                index: i + 1,
                filename: `${number}.png`,
                source_url: sourceUrl,
                status: "failed",
                error: error.message,
            });
        }
    }

    await browser.close();

    const manifest = {
        product_id: Number(productId),

        exported_at: new Date().toISOString(),

        source_type: "shop_product_images",

        browser: "Chrome + Playwright",

        format: "png",

        count: results.length,

        success_count: results.filter((item) => item.status === "success")
            .length,

        failed_count: results.filter((item) => item.status === "failed").length,

        files: results,
    };

    const manifestPath = path.join(outputDir, "manifest.json");

    fs.writeFileSync(manifestPath, JSON.stringify(manifest, null, 2), "utf8");

    console.log("");
    console.log("Export hoàn tất.");

    console.log(`Thành công: ${manifest.success_count}`);

    console.log(`Thất bại: ${manifest.failed_count}`);

    console.log(`Manifest: ${manifestPath}`);

    if (manifest.failed_count > 0) {
        process.exit(2);
    }

    process.exit(0);
}

main().catch((error) => {
    console.error("");
    console.error("FATAL:", error);
    process.exit(1);
});
