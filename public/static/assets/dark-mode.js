document.addEventListener("DOMContentLoaded", () => {
    const themeToggleDarkIcon = document.getElementById(
        "theme-toggle-dark-icon"
    );
    const themeToggleLightIcon = document.getElementById(
        "theme-toggle-light-icon"
    );
    const themeToggleBtn = document.getElementById("theme-toggle");

    if (!themeToggleBtn || !themeToggleDarkIcon || !themeToggleLightIcon) {
        console.warn("Dark mode toggle elements not found.");
        return;
    }

    // RESET cả hai icon trước
    themeToggleDarkIcon.classList.add("hidden");
    themeToggleLightIcon.classList.add("hidden");

    // Hiển thị đúng icon theo trạng thái theme
    if (
        localStorage.getItem("color-theme") === "dark" ||
        (!("color-theme" in localStorage) &&
            window.matchMedia("(prefers-color-scheme: dark)").matches)
    ) {
        themeToggleDarkIcon.classList.remove("hidden"); // Hiện icon moon nếu đang dark
    } else {
        themeToggleLightIcon.classList.remove("hidden"); // Hiện icon sun nếu đang light
    }

    const event = new Event("dark-mode");

    themeToggleBtn.addEventListener("click", () => {
        themeToggleDarkIcon.classList.toggle("hidden");
        themeToggleLightIcon.classList.toggle("hidden");

        if (localStorage.getItem("color-theme")) {
            if (localStorage.getItem("color-theme") === "light") {
                document.documentElement.classList.add("dark");
                localStorage.setItem("color-theme", "dark");
            } else {
                document.documentElement.classList.remove("dark");
                localStorage.setItem("color-theme", "light");
            }
        } else {
            if (document.documentElement.classList.contains("dark")) {
                document.documentElement.classList.remove("dark");
                localStorage.setItem("color-theme", "light");
            } else {
                document.documentElement.classList.add("dark");
                localStorage.setItem("color-theme", "dark");
            }
        }

        document.dispatchEvent(event);
    });
});
