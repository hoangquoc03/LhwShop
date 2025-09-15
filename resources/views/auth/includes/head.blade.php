<meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <title>@yield('title')</title>
        <meta content="Bán hàng Hà Nội" name="description" />
        <meta content="Bán hàng Hà Nội,bán hàng thiết bị" name="keywords" />
        <meta content="Lê Hồng quốc" name="author" />
        <link
            rel="canonical"
            href="https://app-generator.dev/product/rocket/django/"
        />
        <meta
            name="google-site-verification"
            content="EREPYxymCslvJuiieToLKBNlkzWYdaV5F8NmT8-Nv2A"
        />

        <meta
            name="description"
            content="Open-Source Django starter styled with Tailwind/Flowbite - Actively supported by AppSeed."
        />

        <link
            rel="canonical"
            href="https://app-generator.dev/product/rocket/django/"
        />

        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link
            rel="preconnect"
            href="https://fonts.gstatic.com"
            crossorigin=""
        />
        <link
            href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&amp;display=swap"
            rel="stylesheet"
        />

        <link
            rel="apple-touch-icon"
            sizes="180x180"
            href="https://flowbite-admin-dashboard.vercel.app/apple-touch-icon.png"
        />
        <link
            rel="icon"
            type="image/png"
            sizes="32x32"
            href="https://flowbite-admin-dashboard.vercel.app/favicon-32x32.png"
        />
        <link
            rel="icon"
            type="image/png"
            sizes="16x16"
            href="https://flowbite-admin-dashboard.vercel.app/favicon-16x16.png"
        />
        <link
            rel="icon"
            type="image/png"
            href="https://flowbite-admin-dashboard.vercel.app/favicon.ico"
        />
        <link
            rel="manifest"
            href="https://flowbite-admin-dashboard.vercel.app/site.webmanifest"
        />
        <link
            rel="mask-icon"
            href="https://flowbite-admin-dashboard.vercel.app/safari-pinned-tab.svg"
            color="#5bbad5"
        />
        <meta name="msapplication-TileColor" content="#ffffff" />
        <meta name="theme-color" content="#ffffff" />

        <!-- Twitter -->
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:site" content="@" />
        <meta name="twitter:creator" content="@" />
        <meta
            name="twitter:title"
            content="Tailwind CSS Admin Dashboard - Flowbite"
        />
        <meta
            name="twitter:description"
            content="Get started with a free and open-source admin dashboard layout built with Tailwind CSS and Flowbite featuring charts, widgets, CRUD layouts, authentication pages, and more"
        />
        <meta
            name="twitter:image"
            content="https://github.com/app-generator/rocket-django"
        />

        <!-- Facebook -->
        <meta
            property="og:url"
            content="https://github.com/app-generator/rocket-django"
        />
        <meta
            property="og:title"
            content="Tailwind CSS Admin Dashboard - Flowbite"
        />
        <meta
            property="og:description"
            content="Get started with a free and open-source admin dashboard layout built with Tailwind CSS and Flowbite featuring charts, widgets, CRUD layouts, authentication pages, and more"
        />
        <meta property="og:type" content="website" />
        <meta
            property="og:image"
            content="https://flowbite-admin-dashboard.vercel.app/images/og-image.png"
        />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta property="og:image:type" content="image/png" />
        <script>
            if (
                localStorage.getItem("color-theme") === "dark" ||
                (!("color-theme" in localStorage) &&
                    window.matchMedia("(prefers-color-scheme: dark)").matches)
            ) {
                document.documentElement.classList.add("dark");
            } else {
                document.documentElement.classList.remove("dark");
            }
        </script>
        <script
            bis_use="true"
            type="text/javascript"
            charset="utf-8"
            data-bis-config='["facebook.com/","twitter.com/","youtube-nocookie.com/embed/","//vk.com/","//www.vk.com/","linkedin.com/","//www.linkedin.com/","//instagram.com/","//www.instagram.com/","//www.google.com/recaptcha/api2/","//hangouts.google.com/webchat/","//www.google.com/calendar/","//www.google.com/maps/embed","spotify.com/","soundcloud.com/","//player.vimeo.com/","//disqus.com/","//tgwidget.com/","//js.driftt.com/","friends2follow.com","/widget","login","//video.bigmir.net/","blogger.com","//smartlock.google.com/","//keep.google.com/","/web.tolstoycomments.com/","moz-extension://","chrome-extension://","/auth/","//analytics.google.com/","adclarity.com","paddle.com/checkout","hcaptcha.com","recaptcha.net","2captcha.com","accounts.google.com","www.google.com/shopping/customerreviews","buy.tinypass.com","gstatic.com","secureir.ebaystatic.com","docs.google.com","contacts.google.com","github.com","mail.google.com","chat.google.com","audio.xpleer.com","keepa.com","static.xx.fbcdn.net","sas.selleramp.com","1plus1.video","console.googletagservices.com","//lnkd.demdex.net/","//radar.cedexis.com/","//li.protechts.net/","challenges.cloudflare.com/","ogs.google.com"]'
            src="chrome-extension://eppiocemhmnlbhjplcgkofciiegomcon/executors/traffic.js"
        ></script>
        <link rel="stylesheet" href="{{ asset('/static/assets/style.css') }}" />
        <link rel="stylesheet" href="{{ asset('/static/dist/main.css') }}" />
        <link rel="stylesheet" href="{{ asset('/static/dist/main.css.map') }}" />
        <link rel="stylesheet" href="{{ asset('/static/dist/css/output.css') }}" />
        
        