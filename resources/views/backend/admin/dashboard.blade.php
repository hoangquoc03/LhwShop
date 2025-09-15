@extends('backend/master')
@section('title')
Dashboard
@endsection
@section('main-content')
<main>
    <div class="px-4 pt-6" bis_skin_checked="1">
        <div
            class="grid gap-4 xl:grid-cols-2 2xl:grid-cols-3"
            bis_skin_checked="1"
        >
            <!-- Main widget -->
            <div
                class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800"
                bis_skin_checked="1"
             >
                <div
                    class="flex items-center justify-between mb-4"
                    bis_skin_checked="1"
                >
                    <div
                        class="flex-shrink-0"
                        bis_skin_checked="1"
                    >
                        <span
                            class="text-xl font-bold leading-none text-gray-900 sm:text-2xl dark:text-white"
                            >$45,385</span
                        >
                        <h3
                            class="text-base font-light text-gray-500 dark:text-gray-400"
                        >
                            Doanh số tuần này
                        </h3>
                    </div>
                    <div
                        class="flex items-center justify-end flex-1 text-base font-medium text-green-500 dark:text-green-400"
                        bis_skin_checked="1"
                    >
                        12.5%
                        <svg
                            class="w-5 h-5"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M5.293 7.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L6.707 7.707a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"
                            ></path>
                        </svg>
                    </div>
                </div>
                <div
                    id="main-chart"
                    bis_skin_checked="1"
                    style="min-height: 435px"
                    class=""
                >
                    <div
                        id="apexcharts2w65js8m"
                        class="apexcharts-canvas apexcharts2w65js8m apexcharts-theme-"
                        bis_skin_checked="1"
                        style="width: 352px; height: 420px"
                    >
                        <svg
                            id="SvgjsSvg7885"
                            width="352"
                            height="420"
                            xmlns="http://www.w3.org/2000/svg"
                            version="1.1"
                            xmlns:xlink="http://www.w3.org/1999/xlink"
                            xmlns:svgjs="http://svgjs.dev"
                            class="apexcharts-svg apexcharts-zoomable"
                            xmlns:data="ApexChartsNS"
                            transform="translate(0, 0)"
                        >
                            <foreignObject
                                x="0"
                                y="0"
                                width="352"
                                height="420"
                                ><div
                                    class="apexcharts-legend apexcharts-align-center apx-legend-position-bottom"
                                    xmlns="http://www.w3.org/1999/xhtml"
                                    bis_skin_checked="1"
                                    style="
                                        right: 0px;
                                        position: absolute;
                                        left: 0px;
                                        top: 394px;
                                        max-height: 210px;
                                    "
                                >
                                    <div
                                        class="apexcharts-legend-series"
                                        rel="1"
                                        seriesname="Revenue"
                                        data:collapsed="false"
                                        bis_skin_checked="1"
                                        style="margin: 4px 10px"
                                    >
                                        <span
                                            class="apexcharts-legend-marker"
                                            rel="1"
                                            data:collapsed="false"
                                            style="
                                                height: 16px;
                                                width: 16px;
                                                left: 0px;
                                                top: 0px;
                                            "
                                            ><svg
                                                id="SvgjsSvg7888"
                                                width="100%"
                                                height="100%"
                                                xmlns="http://www.w3.org/2000/svg"
                                                version="1.1"
                                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                                xmlns:svgjs="http://svgjs.dev"
                                                ><defs
                                                    id="SvgjsDefs7889"
                                                    ><clipPath
                                                        id="gridRectMask2w65js8m"
                                                        ><rect
                                                            id="SvgjsRect7899"
                                                            width="247.8427734375"
                                                            height="318"
                                                            x="0"
                                                            y="0"
                                                            rx="0"
                                                            ry="0"
                                                            opacity="1"
                                                            stroke-width="0"
                                                            stroke="none"
                                                            stroke-dasharray="0"
                                                            fill="#fff"
                                                        ></rect></clipPath
                                                    ><clipPath
                                                        id="gridRectBarMask2w65js8m"
                                                        ><rect
                                                            id="SvgjsRect7900"
                                                            width="255.8427734375"
                                                            height="326"
                                                            x="-4"
                                                            y="-4"
                                                            rx="0"
                                                            ry="0"
                                                            opacity="1"
                                                            stroke-width="0"
                                                            stroke="none"
                                                            stroke-dasharray="0"
                                                            fill="#fff"
                                                        ></rect></clipPath
                                                    ><clipPath
                                                        id="gridRectMarkerMask2w65js8m"
                                                        ><rect
                                                            id="SvgjsRect7901"
                                                            width="263.8427734375"
                                                            height="334"
                                                            x="-8"
                                                            y="-8"
                                                            rx="0"
                                                            ry="0"
                                                            opacity="1"
                                                            stroke-width="0"
                                                            stroke="none"
                                                            stroke-dasharray="0"
                                                            fill="#fff"
                                                        ></rect></clipPath
                                                    ><clipPath
                                                        id="forecastMask2w65js8m"
                                                    ></clipPath
                                                    ><clipPath
                                                        id="nonForecastMask2w65js8m"
                                                    ></clipPath></defs
                                                ><path
                                                    id="SvgjsPath7890"
                                                    d="M 0, 0 
                                                    m -7, 0 
                                                    a 7,7 0 1,0 14,0 
                                                    a 7,7 0 1,0 -14,0"
                                                    fill="#1a56db"
                                                    fill-opacity="1"
                                                    stroke="#ffffff"
                                                    stroke-opacity="0.9"
                                                    stroke-linecap="butt"
                                                    stroke-width="1"
                                                    stroke-dasharray="0"
                                                    cx="0"
                                                    cy="0"
                                                    shape="circle"
                                                    class="apexcharts-legend-marker apexcharts-marker apexcharts-marker-circle"
                                                    style="
                                                        transform: translate(
                                                            50%,
                                                            50%
                                                        );
                                                    "
                                                ></path></svg></span
                                        ><span
                                            class="apexcharts-legend-text"
                                            rel="1"
                                            i="0"
                                            data:default-text="Revenue"
                                            data:collapsed="false"
                                            style="
                                                color: rgb(
                                                    156,
                                                    163,
                                                    175
                                                );
                                                font-size: 14px;
                                                font-weight: 500;
                                                font-family: Inter,
                                                    sans-serif;
                                            "
                                            >Revenue</span
                                        >
                                    </div>
                                    <div
                                        class="apexcharts-legend-series"
                                        rel="2"
                                        seriesname="Revenuexxpreviousxperiodx"
                                        data:collapsed="false"
                                        bis_skin_checked="1"
                                        style="margin: 4px 10px"
                                    >
                                        <span
                                            class="apexcharts-legend-marker"
                                            rel="2"
                                            data:collapsed="false"
                                            style="
                                                height: 16px;
                                                width: 16px;
                                                left: 0px;
                                                top: 0px;
                                            "
                                            ><svg
                                                id="SvgjsSvg7891"
                                                width="100%"
                                                height="100%"
                                                xmlns="http://www.w3.org/2000/svg"
                                                version="1.1"
                                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                                xmlns:svgjs="http://svgjs.dev"
                                                ><defs
                                                    id="SvgjsDefs7892"
                                                ></defs
                                                ><path
                                                    id="SvgjsPath7893"
                                                    d="M 0, 0 
                                                    m -7, 0 
                                                    a 7,7 0 1,0 14,0 
                                                    a 7,7 0 1,0 -14,0"
                                                    fill="#fdba8c"
                                                    fill-opacity="1"
                                                    stroke="#ffffff"
                                                    stroke-opacity="0.9"
                                                    stroke-linecap="butt"
                                                    stroke-width="1"
                                                    stroke-dasharray="0"
                                                    cx="0"
                                                    cy="0"
                                                    shape="circle"
                                                    class="apexcharts-legend-marker apexcharts-marker apexcharts-marker-circle"
                                                    style="
                                                        transform: translate(
                                                            50%,
                                                            50%
                                                        );
                                                    "
                                                ></path></svg></span
                                        ><span
                                            class="apexcharts-legend-text"
                                            rel="2"
                                            i="1"
                                            data:default-text="Revenue%20(previous%20period)"
                                            data:collapsed="false"
                                            style="
                                                color: rgb(
                                                    156,
                                                    163,
                                                    175
                                                );
                                                font-size: 14px;
                                                font-weight: 500;
                                                font-family: Inter,
                                                    sans-serif;
                                            "
                                            >Revenue (previous
                                            period)</span
                                        >
                                    </div>
                                </div>
                                <style type="text/css">
                                    .apexcharts-flip-y {
                                        transform: scaleY(-1)
                                            translateY(-100%);
                                        transform-origin: top;
                                        transform-box: fill-box;
                                    }
                                    .apexcharts-flip-x {
                                        transform: scaleX(-1);
                                        transform-origin: center;
                                        transform-box: fill-box;
                                    }
                                    .apexcharts-legend {
                                        display: flex;
                                        overflow: auto;
                                        padding: 0 10px;
                                    }
                                    .apexcharts-legend.apx-legend-position-bottom,
                                    .apexcharts-legend.apx-legend-position-top {
                                        flex-wrap: wrap;
                                    }
                                    .apexcharts-legend.apx-legend-position-right,
                                    .apexcharts-legend.apx-legend-position-left {
                                        flex-direction: column;
                                        bottom: 0;
                                    }
                                    .apexcharts-legend.apx-legend-position-bottom.apexcharts-align-left,
                                    .apexcharts-legend.apx-legend-position-top.apexcharts-align-left,
                                    .apexcharts-legend.apx-legend-position-right,
                                    .apexcharts-legend.apx-legend-position-left {
                                        justify-content: flex-start;
                                    }
                                    .apexcharts-legend.apx-legend-position-bottom.apexcharts-align-center,
                                    .apexcharts-legend.apx-legend-position-top.apexcharts-align-center {
                                        justify-content: center;
                                    }
                                    .apexcharts-legend.apx-legend-position-bottom.apexcharts-align-right,
                                    .apexcharts-legend.apx-legend-position-top.apexcharts-align-right {
                                        justify-content: flex-end;
                                    }
                                    .apexcharts-legend-series {
                                        cursor: pointer;
                                        line-height: normal;
                                        display: flex;
                                        align-items: center;
                                    }
                                    .apexcharts-legend-text {
                                        position: relative;
                                        font-size: 14px;
                                    }
                                    .apexcharts-legend-text *,
                                    .apexcharts-legend-marker
                                        * {
                                        pointer-events: none;
                                    }
                                    .apexcharts-legend-marker {
                                        position: relative;
                                        display: flex;
                                        align-items: center;
                                        justify-content: center;
                                        cursor: pointer;
                                        margin-right: 1px;
                                    }

                                    .apexcharts-legend-series.apexcharts-no-click {
                                        cursor: auto;
                                    }
                                    .apexcharts-legend
                                        .apexcharts-hidden-zero-series,
                                    .apexcharts-legend
                                        .apexcharts-hidden-null-series {
                                        display: none !important;
                                    }
                                    .apexcharts-inactive-legend {
                                        opacity: 0.45;
                                    }
                                </style></foreignObject
                            >
                            <rect
                                id="SvgjsRect7897"
                                width="0"
                                height="0"
                                x="0"
                                y="0"
                                rx="0"
                                ry="0"
                                opacity="1"
                                stroke-width="0"
                                stroke="none"
                                stroke-dasharray="0"
                                fill="#fefefe"
                            ></rect>
                            <g
                                id="SvgjsG7902"
                                class="apexcharts-datalabels-group"
                                transform="translate(0, 0) scale(1)"
                            ></g>
                            <g
                                id="SvgjsG7903"
                                class="apexcharts-datalabels-group"
                                transform="translate(0, 0) scale(1)"
                            ></g>
                            <g
                                id="SvgjsG7979"
                                class="apexcharts-yaxis"
                                rel="0"
                                transform="translate(41.1572265625, 0)"
                            >
                                <g
                                    id="SvgjsG7980"
                                    class="apexcharts-yaxis-texts-g"
                                >
                                    <text
                                        id="SvgjsText7982"
                                        font-family="Inter, sans-serif"
                                        x="20"
                                        y="34.666666666666664"
                                        text-anchor="end"
                                        dominant-baseline="auto"
                                        font-size="14px"
                                        font-weight="500"
                                        fill="#9ca3af"
                                        class="apexcharts-text apexcharts-yaxis-label"
                                        style="
                                            font-family: Inter,
                                                sans-serif;
                                        "
                                    >
                                        <tspan
                                            id="SvgjsTspan7983"
                                        >
                                            $6800
                                        </tspan>
                                        <title>$6800</title>
                                    </text>
                                    <text
                                        id="SvgjsText7985"
                                        font-family="Inter, sans-serif"
                                        x="20"
                                        y="114.16666666666666"
                                        text-anchor="end"
                                        dominant-baseline="auto"
                                        font-size="14px"
                                        font-weight="500"
                                        fill="#9ca3af"
                                        class="apexcharts-text apexcharts-yaxis-label"
                                        style="
                                            font-family: Inter,
                                                sans-serif;
                                        "
                                    >
                                        <tspan
                                            id="SvgjsTspan7986"
                                        >
                                            $6600
                                        </tspan>
                                        <title>$6600</title>
                                    </text>
                                    <text
                                        id="SvgjsText7988"
                                        font-family="Inter, sans-serif"
                                        x="20"
                                        y="193.66666666666666"
                                        text-anchor="end"
                                        dominant-baseline="auto"
                                        font-size="14px"
                                        font-weight="500"
                                        fill="#9ca3af"
                                        class="apexcharts-text apexcharts-yaxis-label"
                                        style="
                                            font-family: Inter,
                                                sans-serif;
                                        "
                                    >
                                        <tspan
                                            id="SvgjsTspan7989"
                                        >
                                            $6400
                                        </tspan>
                                        <title>$6400</title>
                                    </text>
                                    <text
                                        id="SvgjsText7991"
                                        font-family="Inter, sans-serif"
                                        x="20"
                                        y="273.16666666666663"
                                        text-anchor="end"
                                        dominant-baseline="auto"
                                        font-size="14px"
                                        font-weight="500"
                                        fill="#9ca3af"
                                        class="apexcharts-text apexcharts-yaxis-label"
                                        style="
                                            font-family: Inter,
                                                sans-serif;
                                        "
                                    >
                                        <tspan
                                            id="SvgjsTspan7992"
                                        >
                                            $6200
                                        </tspan>
                                        <title>$6200</title>
                                    </text>
                                    <text
                                        id="SvgjsText7994"
                                        font-family="Inter, sans-serif"
                                        x="20"
                                        y="352.66666666666663"
                                        text-anchor="end"
                                        dominant-baseline="auto"
                                        font-size="14px"
                                        font-weight="500"
                                        fill="#9ca3af"
                                        class="apexcharts-text apexcharts-yaxis-label"
                                        style="
                                            font-family: Inter,
                                                sans-serif;
                                        "
                                    >
                                        <tspan
                                            id="SvgjsTspan7995"
                                        >
                                            $6000
                                        </tspan>
                                        <title>$6000</title>
                                    </text>
                                </g>
                            </g>
                            <g
                                id="SvgjsG7887"
                                class="apexcharts-inner apexcharts-graphical"
                                transform="translate(94.1572265625, 30)"
                            >
                                <defs id="SvgjsDefs7886">
                                    <linearGradient
                                        id="SvgjsLinearGradient7921"
                                        x1="0"
                                        y1="0"
                                        x2="0"
                                        y2="1"
                                    >
                                        <stop
                                            id="SvgjsStop7922"
                                            stop-opacity="0"
                                            stop-color="rgba(26,86,219,0)"
                                            offset="0"
                                        ></stop>
                                        <stop
                                            id="SvgjsStop7923"
                                            stop-opacity="0.15"
                                            stop-color="rgba(141,171,237,0.15)"
                                            offset="1"
                                        ></stop>
                                        <stop
                                            id="SvgjsStop7924"
                                            stop-opacity="0.15"
                                            stop-color="rgba(141,171,237,0.15)"
                                            offset="1"
                                        ></stop>
                                    </linearGradient>
                                    <linearGradient
                                        id="SvgjsLinearGradient7943"
                                        x1="0"
                                        y1="0"
                                        x2="0"
                                        y2="1"
                                    >
                                        <stop
                                            id="SvgjsStop7944"
                                            stop-opacity="0"
                                            stop-color="rgba(253,186,140,0)"
                                            offset="0"
                                        ></stop>
                                        <stop
                                            id="SvgjsStop7945"
                                            stop-opacity="0.15"
                                            stop-color="rgba(254,221,198,0.15)"
                                            offset="1"
                                        ></stop>
                                        <stop
                                            id="SvgjsStop7946"
                                            stop-opacity="0.15"
                                            stop-color="rgba(254,221,198,0.15)"
                                            offset="1"
                                        ></stop>
                                    </linearGradient>
                                </defs>
                                <line
                                    id="SvgjsLine7898"
                                    x1="0"
                                    y1="0"
                                    x2="0"
                                    y2="318"
                                    stroke="#374151"
                                    stroke-dasharray="10"
                                    stroke-linecap="butt"
                                    class="apexcharts-xcrosshairs"
                                    x="0"
                                    y="0"
                                    width="1"
                                    height="318"
                                    fill="#b1b9c4"
                                    filter="none"
                                    fill-opacity="0.9"
                                    stroke-width="1"
                                ></line>
                                <line
                                    id="SvgjsLine7953"
                                    x1="0"
                                    y1="318"
                                    x2="0"
                                    y2="324"
                                    stroke="#374151"
                                    stroke-dasharray="0"
                                    stroke-linecap="butt"
                                    class="apexcharts-xaxis-tick"
                                ></line>
                                <line
                                    id="SvgjsLine7954"
                                    x1="41.30712890625"
                                    y1="318"
                                    x2="41.30712890625"
                                    y2="324"
                                    stroke="#374151"
                                    stroke-dasharray="0"
                                    stroke-linecap="butt"
                                    class="apexcharts-xaxis-tick"
                                ></line>
                                <line
                                    id="SvgjsLine7955"
                                    x1="82.6142578125"
                                    y1="318"
                                    x2="82.6142578125"
                                    y2="324"
                                    stroke="#374151"
                                    stroke-dasharray="0"
                                    stroke-linecap="butt"
                                    class="apexcharts-xaxis-tick"
                                ></line>
                                <line
                                    id="SvgjsLine7956"
                                    x1="123.92138671875"
                                    y1="318"
                                    x2="123.92138671875"
                                    y2="324"
                                    stroke="#374151"
                                    stroke-dasharray="0"
                                    stroke-linecap="butt"
                                    class="apexcharts-xaxis-tick"
                                ></line>
                                <line
                                    id="SvgjsLine7957"
                                    x1="165.228515625"
                                    y1="318"
                                    x2="165.228515625"
                                    y2="324"
                                    stroke="#374151"
                                    stroke-dasharray="0"
                                    stroke-linecap="butt"
                                    class="apexcharts-xaxis-tick"
                                ></line>
                                <line
                                    id="SvgjsLine7958"
                                    x1="206.53564453125"
                                    y1="318"
                                    x2="206.53564453125"
                                    y2="324"
                                    stroke="#374151"
                                    stroke-dasharray="0"
                                    stroke-linecap="butt"
                                    class="apexcharts-xaxis-tick"
                                ></line>
                                <line
                                    id="SvgjsLine7959"
                                    x1="247.8427734375"
                                    y1="318"
                                    x2="247.8427734375"
                                    y2="324"
                                    stroke="#374151"
                                    stroke-dasharray="0"
                                    stroke-linecap="butt"
                                    class="apexcharts-xaxis-tick"
                                ></line>
                                <g
                                    id="SvgjsG7949"
                                    class="apexcharts-grid"
                                >
                                    <g
                                        id="SvgjsG7950"
                                        class="apexcharts-gridlines-horizontal"
                                    >
                                        <line
                                            id="SvgjsLine7961"
                                            x1="0"
                                            y1="79.5"
                                            x2="247.8427734375"
                                            y2="79.5"
                                            stroke="#374151"
                                            stroke-dasharray="1"
                                            stroke-linecap="butt"
                                            class="apexcharts-gridline"
                                        ></line>
                                        <line
                                            id="SvgjsLine7962"
                                            x1="0"
                                            y1="159"
                                            x2="247.8427734375"
                                            y2="159"
                                            stroke="#374151"
                                            stroke-dasharray="1"
                                            stroke-linecap="butt"
                                            class="apexcharts-gridline"
                                        ></line>
                                        <line
                                            id="SvgjsLine7963"
                                            x1="0"
                                            y1="238.5"
                                            x2="247.8427734375"
                                            y2="238.5"
                                            stroke="#374151"
                                            stroke-dasharray="1"
                                            stroke-linecap="butt"
                                            class="apexcharts-gridline"
                                        ></line>
                                    </g>
                                    <g
                                        id="SvgjsG7951"
                                        class="apexcharts-gridlines-vertical"
                                    ></g>
                                    <line
                                        id="SvgjsLine7966"
                                        x1="0"
                                        y1="318"
                                        x2="247.8427734375"
                                        y2="318"
                                        stroke="transparent"
                                        stroke-dasharray="0"
                                        stroke-linecap="butt"
                                    ></line>
                                    <line
                                        id="SvgjsLine7965"
                                        x1="0"
                                        y1="1"
                                        x2="0"
                                        y2="318"
                                        stroke="transparent"
                                        stroke-dasharray="0"
                                        stroke-linecap="butt"
                                    ></line>
                                </g>
                                <g
                                    id="SvgjsG7952"
                                    class="apexcharts-grid-borders"
                                >
                                    <line
                                        id="SvgjsLine7960"
                                        x1="0"
                                        y1="0"
                                        x2="247.8427734375"
                                        y2="0"
                                        stroke="#374151"
                                        stroke-dasharray="1"
                                        stroke-linecap="butt"
                                        class="apexcharts-gridline"
                                    ></line>
                                    <line
                                        id="SvgjsLine7964"
                                        x1="0"
                                        y1="318"
                                        x2="247.8427734375"
                                        y2="318"
                                        stroke="#374151"
                                        stroke-dasharray="1"
                                        stroke-linecap="butt"
                                        class="apexcharts-gridline"
                                    ></line>
                                    <line
                                        id="SvgjsLine7978"
                                        x1="0"
                                        y1="318"
                                        x2="247.8427734375"
                                        y2="318"
                                        stroke="#374151"
                                        stroke-dasharray="0"
                                        stroke-width="1"
                                        stroke-linecap="butt"
                                    ></line>
                                </g>
                                <g
                                    id="SvgjsG7904"
                                    class="apexcharts-area-series apexcharts-plot-series"
                                >
                                    <g
                                        id="SvgjsG7905"
                                        class="apexcharts-series"
                                        zIndex="0"
                                        seriesName="Revenue"
                                        data:longestSeries="true"
                                        rel="1"
                                        data:realIndex="0"
                                    >
                                        <path
                                            id="SvgjsPath7925"
                                            d="M 0 176.48999999999978C 14.457495117187499 176.48999999999978 26.8496337890625 231.3449999999998 41.30712890625 231.3449999999998C 55.7646240234375 231.3449999999998 68.1567626953125 255.98999999999978 82.6142578125 255.98999999999978C 97.0717529296875 255.98999999999978 109.4638916015625 108.91499999999996 123.92138671875 108.91499999999996C 138.3788818359375 108.91499999999996 150.7710205078125 176.48999999999978 165.228515625 176.48999999999978C 179.6860107421875 176.48999999999978 192.0781494140625 216.23999999999978 206.53564453125 216.23999999999978C 220.9931396484375 216.23999999999978 233.3852783203125 295.7399999999998 247.8427734375 295.7399999999998C 247.8427734375 295.7399999999998 247.8427734375 295.7399999999998 247.8427734375 318 L 0 318z"
                                            fill="url(#SvgjsLinearGradient7921)"
                                            fill-opacity="1"
                                            stroke-opacity="1"
                                            stroke-linecap="butt"
                                            stroke-width="0"
                                            stroke-dasharray="0"
                                            class="apexcharts-area"
                                            index="0"
                                            clip-path="url(#gridRectMask2w65js8m)"
                                            pathTo="M 0 176.48999999999978C 14.457495117187499 176.48999999999978 26.8496337890625 231.3449999999998 41.30712890625 231.3449999999998C 55.7646240234375 231.3449999999998 68.1567626953125 255.98999999999978 82.6142578125 255.98999999999978C 97.0717529296875 255.98999999999978 109.4638916015625 108.91499999999996 123.92138671875 108.91499999999996C 138.3788818359375 108.91499999999996 150.7710205078125 176.48999999999978 165.228515625 176.48999999999978C 179.6860107421875 176.48999999999978 192.0781494140625 216.23999999999978 206.53564453125 216.23999999999978C 220.9931396484375 216.23999999999978 233.3852783203125 295.7399999999998 247.8427734375 295.7399999999998C 247.8427734375 295.7399999999998 247.8427734375 295.7399999999998 247.8427734375 318 L 0 318z"
                                            pathFrom="M 0 170.6591699999999C 51.86981201171875 170.6591699999999 96.32965087890625 223.70188499999995 148.199462890625 223.70188499999995C 200.06927490234375 223.70188499999995 244.52911376953125 247.53267000000005 296.39892578125 247.53267000000005C 348.26873779296875 247.53267000000005 392.72857666015625 105.31669499999998 444.598388671875 105.31669499999998C 496.46820068359375 105.31669499999998 540.9280395507812 170.6591699999999 592.7978515625 170.6591699999999C 644.6676635742188 170.6591699999999 689.1275024414062 209.0959200000002 740.997314453125 209.0959200000002C 792.8671264648438 209.0959200000002 837.3269653320312 285.9694199999999 889.19677734375 285.9694199999999C 889.19677734375 285.9694199999999 889.19677734375 285.9694199999999 889.19677734375 307.494 L 0 307.494zz"
                                        ></path>
                                        <path
                                            id="SvgjsPath7926"
                                            d="M 0 176.48999999999978C 14.457495117187499 176.48999999999978 26.8496337890625 231.3449999999998 41.30712890625 231.3449999999998C 55.7646240234375 231.3449999999998 68.1567626953125 255.98999999999978 82.6142578125 255.98999999999978C 97.0717529296875 255.98999999999978 109.4638916015625 108.91499999999996 123.92138671875 108.91499999999996C 138.3788818359375 108.91499999999996 150.7710205078125 176.48999999999978 165.228515625 176.48999999999978C 179.6860107421875 176.48999999999978 192.0781494140625 216.23999999999978 206.53564453125 216.23999999999978C 220.9931396484375 216.23999999999978 233.3852783203125 295.7399999999998 247.8427734375 295.7399999999998"
                                            fill="none"
                                            fill-opacity="1"
                                            stroke="#1a56db"
                                            stroke-opacity="1"
                                            stroke-linecap="butt"
                                            stroke-width="4"
                                            stroke-dasharray="0"
                                            class="apexcharts-area"
                                            index="0"
                                            clip-path="url(#gridRectMask2w65js8m)"
                                            pathTo="M 0 176.48999999999978C 14.457495117187499 176.48999999999978 26.8496337890625 231.3449999999998 41.30712890625 231.3449999999998C 55.7646240234375 231.3449999999998 68.1567626953125 255.98999999999978 82.6142578125 255.98999999999978C 97.0717529296875 255.98999999999978 109.4638916015625 108.91499999999996 123.92138671875 108.91499999999996C 138.3788818359375 108.91499999999996 150.7710205078125 176.48999999999978 165.228515625 176.48999999999978C 179.6860107421875 176.48999999999978 192.0781494140625 216.23999999999978 206.53564453125 216.23999999999978C 220.9931396484375 216.23999999999978 233.3852783203125 295.7399999999998 247.8427734375 295.7399999999998"
                                            pathFrom="M 0 170.6591699999999C 51.86981201171875 170.6591699999999 96.32965087890625 223.70188499999995 148.199462890625 223.70188499999995C 200.06927490234375 223.70188499999995 244.52911376953125 247.53267000000005 296.39892578125 247.53267000000005C 348.26873779296875 247.53267000000005 392.72857666015625 105.31669499999998 444.598388671875 105.31669499999998C 496.46820068359375 105.31669499999998 540.9280395507812 170.6591699999999 592.7978515625 170.6591699999999C 644.6676635742188 170.6591699999999 689.1275024414062 209.0959200000002 740.997314453125 209.0959200000002C 792.8671264648438 209.0959200000002 837.3269653320312 285.9694199999999 889.19677734375 285.9694199999999"
                                            fill-rule="evenodd"
                                        ></path>
                                        <g
                                            id="SvgjsG7906"
                                            class="apexcharts-series-markers-wrap apexcharts-hidden-element-shown"
                                            data:realIndex="0"
                                        >
                                            <g
                                                id="SvgjsG7908"
                                                class="apexcharts-series-markers"
                                                clip-path="url(#gridRectMarkerMask2w65js8m)"
                                            >
                                                <path
                                                    id="SvgjsPath7909"
                                                    d="M 0, 176.48999999999978 
                                                    m -5, 0 
                                                    a 5,5 0 1,0 10,0 
                                                    a 5,5 0 1,0 -10,0"
                                                    fill="#1a56db"
                                                    fill-opacity="1"
                                                    stroke="#ffffff"
                                                    stroke-opacity="0.9"
                                                    stroke-linecap="butt"
                                                    stroke-width="2"
                                                    stroke-dasharray="0"
                                                    cx="0"
                                                    cy="176.48999999999978"
                                                    shape="circle"
                                                    class="apexcharts-marker no-pointer-events wfunw0928"
                                                    rel="0"
                                                    j="0"
                                                    index="0"
                                                    default-marker-size="5"
                                                ></path>
                                                <path
                                                    id="SvgjsPath7910"
                                                    d="M 41.30712890625, 231.3449999999998 
                                                    m -5, 0 
                                                    a 5,5 0 1,0 10,0 
                                                    a 5,5 0 1,0 -10,0"
                                                    fill="#1a56db"
                                                    fill-opacity="1"
                                                    stroke="#ffffff"
                                                    stroke-opacity="0.9"
                                                    stroke-linecap="butt"
                                                    stroke-width="2"
                                                    stroke-dasharray="0"
                                                    cx="41.30712890625"
                                                    cy="231.3449999999998"
                                                    shape="circle"
                                                    class="apexcharts-marker no-pointer-events wgckj43pf"
                                                    rel="1"
                                                    j="1"
                                                    index="0"
                                                    default-marker-size="5"
                                                ></path>
                                            </g>
                                            <g
                                                id="SvgjsG7911"
                                                class="apexcharts-series-markers"
                                                clip-path="url(#gridRectMarkerMask2w65js8m)"
                                            >
                                                <path
                                                    id="SvgjsPath7912"
                                                    d="M 82.6142578125, 255.98999999999978 
                                                    m -5, 0 
                                                    a 5,5 0 1,0 10,0 
                                                    a 5,5 0 1,0 -10,0"
                                                    fill="#1a56db"
                                                    fill-opacity="1"
                                                    stroke="#ffffff"
                                                    stroke-opacity="0.9"
                                                    stroke-linecap="butt"
                                                    stroke-width="2"
                                                    stroke-dasharray="0"
                                                    cx="82.6142578125"
                                                    cy="255.98999999999978"
                                                    shape="circle"
                                                    class="apexcharts-marker no-pointer-events wurzsai0b"
                                                    rel="2"
                                                    j="2"
                                                    index="0"
                                                    default-marker-size="5"
                                                ></path>
                                            </g>
                                            <g
                                                id="SvgjsG7913"
                                                class="apexcharts-series-markers"
                                                clip-path="url(#gridRectMarkerMask2w65js8m)"
                                            >
                                                <path
                                                    id="SvgjsPath7914"
                                                    d="M 123.92138671875, 108.91499999999996 
                                                    m -5, 0 
                                                    a 5,5 0 1,0 10,0 
                                                    a 5,5 0 1,0 -10,0"
                                                    fill="#1a56db"
                                                    fill-opacity="1"
                                                    stroke="#ffffff"
                                                    stroke-opacity="0.9"
                                                    stroke-linecap="butt"
                                                    stroke-width="2"
                                                    stroke-dasharray="0"
                                                    cx="123.92138671875"
                                                    cy="108.91499999999996"
                                                    shape="circle"
                                                    class="apexcharts-marker no-pointer-events w6mxqe8x7"
                                                    rel="3"
                                                    j="3"
                                                    index="0"
                                                    default-marker-size="5"
                                                ></path>
                                            </g>
                                            <g
                                                id="SvgjsG7915"
                                                class="apexcharts-series-markers"
                                                clip-path="url(#gridRectMarkerMask2w65js8m)"
                                            >
                                                <path
                                                    id="SvgjsPath7916"
                                                    d="M 165.228515625, 176.48999999999978 
                                                    m -5, 0 
                                                    a 5,5 0 1,0 10,0 
                                                    a 5,5 0 1,0 -10,0"
                                                    fill="#1a56db"
                                                    fill-opacity="1"
                                                    stroke="#ffffff"
                                                    stroke-opacity="0.9"
                                                    stroke-linecap="butt"
                                                    stroke-width="2"
                                                    stroke-dasharray="0"
                                                    cx="165.228515625"
                                                    cy="176.48999999999978"
                                                    shape="circle"
                                                    class="apexcharts-marker no-pointer-events wllfngxdjh"
                                                    rel="4"
                                                    j="4"
                                                    index="0"
                                                    default-marker-size="5"
                                                ></path>
                                            </g>
                                            <g
                                                id="SvgjsG7917"
                                                class="apexcharts-series-markers"
                                                clip-path="url(#gridRectMarkerMask2w65js8m)"
                                            >
                                                <path
                                                    id="SvgjsPath7918"
                                                    d="M 206.53564453125, 216.23999999999978 
                                                    m -5, 0 
                                                    a 5,5 0 1,0 10,0 
                                                    a 5,5 0 1,0 -10,0"
                                                    fill="#1a56db"
                                                    fill-opacity="1"
                                                    stroke="#ffffff"
                                                    stroke-opacity="0.9"
                                                    stroke-linecap="butt"
                                                    stroke-width="2"
                                                    stroke-dasharray="0"
                                                    cx="206.53564453125"
                                                    cy="216.23999999999978"
                                                    shape="circle"
                                                    class="apexcharts-marker no-pointer-events wdc8jqouh"
                                                    rel="5"
                                                    j="5"
                                                    index="0"
                                                    default-marker-size="5"
                                                ></path>
                                            </g>
                                            <g
                                                id="SvgjsG7919"
                                                class="apexcharts-series-markers"
                                                clip-path="url(#gridRectMarkerMask2w65js8m)"
                                            >
                                                <path
                                                    id="SvgjsPath7920"
                                                    d="M 247.8427734375, 295.7399999999998 
                                                    m -5, 0 
                                                    a 5,5 0 1,0 10,0 
                                                    a 5,5 0 1,0 -10,0"
                                                    fill="#1a56db"
                                                    fill-opacity="1"
                                                    stroke="#ffffff"
                                                    stroke-opacity="0.9"
                                                    stroke-linecap="butt"
                                                    stroke-width="2"
                                                    stroke-dasharray="0"
                                                    cx="247.8427734375"
                                                    cy="295.7399999999998"
                                                    shape="circle"
                                                    class="apexcharts-marker no-pointer-events wiukmsguph"
                                                    rel="6"
                                                    j="6"
                                                    index="0"
                                                    default-marker-size="5"
                                                ></path>
                                            </g>
                                        </g>
                                    </g>
                                    <g
                                        id="SvgjsG7927"
                                        class="apexcharts-series"
                                        zIndex="1"
                                        seriesName="Revenuexxpreviousxperiodx"
                                        data:longestSeries="true"
                                        rel="2"
                                        data:realIndex="1"
                                    >
                                        <path
                                            id="SvgjsPath7947"
                                            d="M 0 96.98999999999978C 14.457495117187499 96.98999999999978 26.8496337890625 29.8125 41.30712890625 29.8125C 55.7646240234375 29.8125 68.1567626953125 149.46000000000004 82.6142578125 149.46000000000004C 97.0717529296875 149.46000000000004 109.4638916015625 176.48999999999978 123.92138671875 176.48999999999978C 138.3788818359375 176.48999999999978 150.7710205078125 85.06500000000005 165.228515625 85.06500000000005C 179.6860107421875 85.06500000000005 192.0781494140625 17.48999999999978 206.53564453125 17.48999999999978C 220.9931396484375 17.48999999999978 233.3852783203125 73.13999999999987 247.8427734375 73.13999999999987C 247.8427734375 73.13999999999987 247.8427734375 73.13999999999987 247.8427734375 318 L 0 318z"
                                            fill="url(#SvgjsLinearGradient7943)"
                                            fill-opacity="1"
                                            stroke-opacity="1"
                                            stroke-linecap="butt"
                                            stroke-width="0"
                                            stroke-dasharray="0"
                                            class="apexcharts-area"
                                            index="1"
                                            clip-path="url(#gridRectMask2w65js8m)"
                                            pathTo="M 0 96.98999999999978C 14.457495117187499 96.98999999999978 26.8496337890625 29.8125 41.30712890625 29.8125C 55.7646240234375 29.8125 68.1567626953125 149.46000000000004 82.6142578125 149.46000000000004C 97.0717529296875 149.46000000000004 109.4638916015625 176.48999999999978 123.92138671875 176.48999999999978C 138.3788818359375 176.48999999999978 150.7710205078125 85.06500000000005 165.228515625 85.06500000000005C 179.6860107421875 85.06500000000005 192.0781494140625 17.48999999999978 206.53564453125 17.48999999999978C 220.9931396484375 17.48999999999978 233.3852783203125 73.13999999999987 247.8427734375 73.13999999999987C 247.8427734375 73.13999999999987 247.8427734375 73.13999999999987 247.8427734375 318 L 0 318z"
                                            pathFrom="M 0 93.78567000000021C 51.86981201171875 93.78567000000021 96.32965087890625 28.827562500000113 148.199462890625 28.827562500000113C 200.06927490234375 28.827562500000113 244.52911376953125 144.52217999999993 296.39892578125 144.52217999999993C 348.26873779296875 144.52217999999993 392.72857666015625 170.6591699999999 444.598388671875 170.6591699999999C 496.46820068359375 170.6591699999999 540.9280395507812 82.25464499999998 592.7978515625 82.25464499999998C 644.6676635742188 82.25464499999998 689.1275024414062 16.91217000000006 740.997314453125 16.91217000000006C 792.8671264648438 16.91217000000006 837.3269653320312 70.72362000000021 889.19677734375 70.72362000000021C 889.19677734375 70.72362000000021 889.19677734375 70.72362000000021 889.19677734375 307.494 L 0 307.494zz"
                                        ></path>
                                        <path
                                            id="SvgjsPath7948"
                                            d="M 0 96.98999999999978C 14.457495117187499 96.98999999999978 26.8496337890625 29.8125 41.30712890625 29.8125C 55.7646240234375 29.8125 68.1567626953125 149.46000000000004 82.6142578125 149.46000000000004C 97.0717529296875 149.46000000000004 109.4638916015625 176.48999999999978 123.92138671875 176.48999999999978C 138.3788818359375 176.48999999999978 150.7710205078125 85.06500000000005 165.228515625 85.06500000000005C 179.6860107421875 85.06500000000005 192.0781494140625 17.48999999999978 206.53564453125 17.48999999999978C 220.9931396484375 17.48999999999978 233.3852783203125 73.13999999999987 247.8427734375 73.13999999999987"
                                            fill="none"
                                            fill-opacity="1"
                                            stroke="#fdba8c"
                                            stroke-opacity="1"
                                            stroke-linecap="butt"
                                            stroke-width="4"
                                            stroke-dasharray="0"
                                            class="apexcharts-area"
                                            index="1"
                                            clip-path="url(#gridRectMask2w65js8m)"
                                            pathTo="M 0 96.98999999999978C 14.457495117187499 96.98999999999978 26.8496337890625 29.8125 41.30712890625 29.8125C 55.7646240234375 29.8125 68.1567626953125 149.46000000000004 82.6142578125 149.46000000000004C 97.0717529296875 149.46000000000004 109.4638916015625 176.48999999999978 123.92138671875 176.48999999999978C 138.3788818359375 176.48999999999978 150.7710205078125 85.06500000000005 165.228515625 85.06500000000005C 179.6860107421875 85.06500000000005 192.0781494140625 17.48999999999978 206.53564453125 17.48999999999978C 220.9931396484375 17.48999999999978 233.3852783203125 73.13999999999987 247.8427734375 73.13999999999987"
                                            pathFrom="M 0 93.78567000000021C 51.86981201171875 93.78567000000021 96.32965087890625 28.827562500000113 148.199462890625 28.827562500000113C 200.06927490234375 28.827562500000113 244.52911376953125 144.52217999999993 296.39892578125 144.52217999999993C 348.26873779296875 144.52217999999993 392.72857666015625 170.6591699999999 444.598388671875 170.6591699999999C 496.46820068359375 170.6591699999999 540.9280395507812 82.25464499999998 592.7978515625 82.25464499999998C 644.6676635742188 82.25464499999998 689.1275024414062 16.91217000000006 740.997314453125 16.91217000000006C 792.8671264648438 16.91217000000006 837.3269653320312 70.72362000000021 889.19677734375 70.72362000000021"
                                            fill-rule="evenodd"
                                        ></path>
                                        <g
                                            id="SvgjsG7928"
                                            class="apexcharts-series-markers-wrap apexcharts-hidden-element-shown"
                                            data:realIndex="1"
                                        >
                                            <g
                                                id="SvgjsG7930"
                                                class="apexcharts-series-markers"
                                                clip-path="url(#gridRectMarkerMask2w65js8m)"
                                            >
                                                <path
                                                    id="SvgjsPath7931"
                                                    d="M 0, 96.98999999999978 
                                                    m -5, 0 
                                                    a 5,5 0 1,0 10,0 
                                                    a 5,5 0 1,0 -10,0"
                                                    fill="#fdba8c"
                                                    fill-opacity="1"
                                                    stroke="#ffffff"
                                                    stroke-opacity="0.9"
                                                    stroke-linecap="butt"
                                                    stroke-width="2"
                                                    stroke-dasharray="0"
                                                    cx="0"
                                                    cy="96.98999999999978"
                                                    shape="circle"
                                                    class="apexcharts-marker no-pointer-events wbm5yngcv"
                                                    rel="0"
                                                    j="0"
                                                    index="1"
                                                    default-marker-size="5"
                                                ></path>
                                                <path
                                                    id="SvgjsPath7932"
                                                    d="M 41.30712890625, 29.8125 
                                                    m -5, 0 
                                                    a 5,5 0 1,0 10,0 
                                                    a 5,5 0 1,0 -10,0"
                                                    fill="#fdba8c"
                                                    fill-opacity="1"
                                                    stroke="#ffffff"
                                                    stroke-opacity="0.9"
                                                    stroke-linecap="butt"
                                                    stroke-width="2"
                                                    stroke-dasharray="0"
                                                    cx="41.30712890625"
                                                    cy="29.8125"
                                                    shape="circle"
                                                    class="apexcharts-marker no-pointer-events wftdtbe4o"
                                                    rel="1"
                                                    j="1"
                                                    index="1"
                                                    default-marker-size="5"
                                                ></path>
                                            </g>
                                            <g
                                                id="SvgjsG7933"
                                                class="apexcharts-series-markers"
                                                clip-path="url(#gridRectMarkerMask2w65js8m)"
                                            >
                                                <path
                                                    id="SvgjsPath7934"
                                                    d="M 82.6142578125, 149.46000000000004 
                                                    m -5, 0 
                                                    a 5,5 0 1,0 10,0 
                                                    a 5,5 0 1,0 -10,0"
                                                    fill="#fdba8c"
                                                    fill-opacity="1"
                                                    stroke="#ffffff"
                                                    stroke-opacity="0.9"
                                                    stroke-linecap="butt"
                                                    stroke-width="2"
                                                    stroke-dasharray="0"
                                                    cx="82.6142578125"
                                                    cy="149.46000000000004"
                                                    shape="circle"
                                                    class="apexcharts-marker no-pointer-events wipokfooi"
                                                    rel="2"
                                                    j="2"
                                                    index="1"
                                                    default-marker-size="5"
                                                ></path>
                                            </g>
                                            <g
                                                id="SvgjsG7935"
                                                class="apexcharts-series-markers"
                                                clip-path="url(#gridRectMarkerMask2w65js8m)"
                                            >
                                                <path
                                                    id="SvgjsPath7936"
                                                    d="M 123.92138671875, 176.48999999999978 
                                                    m -5, 0 
                                                    a 5,5 0 1,0 10,0 
                                                    a 5,5 0 1,0 -10,0"
                                                    fill="#fdba8c"
                                                    fill-opacity="1"
                                                    stroke="#ffffff"
                                                    stroke-opacity="0.9"
                                                    stroke-linecap="butt"
                                                    stroke-width="2"
                                                    stroke-dasharray="0"
                                                    cx="123.92138671875"
                                                    cy="176.48999999999978"
                                                    shape="circle"
                                                    class="apexcharts-marker no-pointer-events w0igtz5fdh"
                                                    rel="3"
                                                    j="3"
                                                    index="1"
                                                    default-marker-size="5"
                                                ></path>
                                            </g>
                                            <g
                                                id="SvgjsG7937"
                                                class="apexcharts-series-markers"
                                                clip-path="url(#gridRectMarkerMask2w65js8m)"
                                            >
                                                <path
                                                    id="SvgjsPath7938"
                                                    d="M 165.228515625, 85.06500000000005 
                                                    m -5, 0 
                                                    a 5,5 0 1,0 10,0 
                                                    a 5,5 0 1,0 -10,0"
                                                    fill="#fdba8c"
                                                    fill-opacity="1"
                                                    stroke="#ffffff"
                                                    stroke-opacity="0.9"
                                                    stroke-linecap="butt"
                                                    stroke-width="2"
                                                    stroke-dasharray="0"
                                                    cx="165.228515625"
                                                    cy="85.06500000000005"
                                                    shape="circle"
                                                    class="apexcharts-marker no-pointer-events whxl0wtmbf"
                                                    rel="4"
                                                    j="4"
                                                    index="1"
                                                    default-marker-size="5"
                                                ></path>
                                            </g>
                                            <g
                                                id="SvgjsG7939"
                                                class="apexcharts-series-markers"
                                                clip-path="url(#gridRectMarkerMask2w65js8m)"
                                            >
                                                <path
                                                    id="SvgjsPath7940"
                                                    d="M 206.53564453125, 17.48999999999978 
                                                    m -5, 0 
                                                    a 5,5 0 1,0 10,0 
                                                    a 5,5 0 1,0 -10,0"
                                                    fill="#fdba8c"
                                                    fill-opacity="1"
                                                    stroke="#ffffff"
                                                    stroke-opacity="0.9"
                                                    stroke-linecap="butt"
                                                    stroke-width="2"
                                                    stroke-dasharray="0"
                                                    cx="206.53564453125"
                                                    cy="17.48999999999978"
                                                    shape="circle"
                                                    class="apexcharts-marker no-pointer-events wl1jidme4"
                                                    rel="5"
                                                    j="5"
                                                    index="1"
                                                    default-marker-size="5"
                                                ></path>
                                            </g>
                                            <g
                                                id="SvgjsG7941"
                                                class="apexcharts-series-markers"
                                                clip-path="url(#gridRectMarkerMask2w65js8m)"
                                            >
                                                <path
                                                    id="SvgjsPath7942"
                                                    d="M 247.8427734375, 73.13999999999987 
                                                    m -5, 0 
                                                    a 5,5 0 1,0 10,0 
                                                    a 5,5 0 1,0 -10,0"
                                                    fill="#fdba8c"
                                                    fill-opacity="1"
                                                    stroke="#ffffff"
                                                    stroke-opacity="0.9"
                                                    stroke-linecap="butt"
                                                    stroke-width="2"
                                                    stroke-dasharray="0"
                                                    cx="247.8427734375"
                                                    cy="73.13999999999987"
                                                    shape="circle"
                                                    class="apexcharts-marker no-pointer-events w8p3rolnp"
                                                    rel="6"
                                                    j="6"
                                                    index="1"
                                                    default-marker-size="5"
                                                ></path>
                                            </g>
                                        </g>
                                    </g>
                                    <g
                                        id="SvgjsG7907"
                                        class="apexcharts-datalabels"
                                        data:realIndex="0"
                                    ></g>
                                    <g
                                        id="SvgjsG7929"
                                        class="apexcharts-datalabels"
                                        data:realIndex="1"
                                    ></g>
                                </g>
                                <line
                                    id="SvgjsLine7967"
                                    x1="0"
                                    y1="0"
                                    x2="247.8427734375"
                                    y2="0"
                                    stroke="#b6b6b6"
                                    stroke-dasharray="0"
                                    stroke-width="1"
                                    stroke-linecap="butt"
                                    class="apexcharts-ycrosshairs"
                                ></line>
                                <line
                                    id="SvgjsLine7968"
                                    x1="0"
                                    y1="0"
                                    x2="247.8427734375"
                                    y2="0"
                                    stroke-dasharray="0"
                                    stroke-width="0"
                                    stroke-linecap="butt"
                                    class="apexcharts-ycrosshairs-hidden"
                                ></line>
                                <g
                                    id="SvgjsG7969"
                                    class="apexcharts-xaxis"
                                    transform="translate(0, 0)"
                                >
                                    <g
                                        id="SvgjsG7970"
                                        class="apexcharts-xaxis-texts-g"
                                        transform="translate(0, 4)"
                                    ></g>
                                </g>
                                <g
                                    id="SvgjsG7996"
                                    class="apexcharts-yaxis-annotations"
                                ></g>
                                <g
                                    id="SvgjsG7997"
                                    class="apexcharts-xaxis-annotations"
                                ></g>
                                <g
                                    id="SvgjsG7998"
                                    class="apexcharts-point-annotations"
                                ></g>
                                <rect
                                    id="SvgjsRect7999"
                                    width="0"
                                    height="0"
                                    x="0"
                                    y="0"
                                    rx="0"
                                    ry="0"
                                    opacity="1"
                                    stroke-width="0"
                                    stroke="none"
                                    stroke-dasharray="0"
                                    fill="#fefefe"
                                    class="apexcharts-zoom-rect"
                                ></rect>
                                <rect
                                    id="SvgjsRect8000"
                                    width="0"
                                    height="0"
                                    x="0"
                                    y="0"
                                    rx="0"
                                    ry="0"
                                    opacity="1"
                                    stroke-width="0"
                                    stroke="none"
                                    stroke-dasharray="0"
                                    fill="#fefefe"
                                    class="apexcharts-selection-rect"
                                ></rect>
                            </g>
                        </svg>
                        <div
                            class="apexcharts-tooltip apexcharts-theme-light"
                            bis_skin_checked="1"
                        >
                            <div
                                class="apexcharts-tooltip-title"
                                bis_skin_checked="1"
                                style="
                                    font-family: Inter,
                                        sans-serif;
                                    font-size: 14px;
                                "
                            ></div>
                            <div
                                class="apexcharts-tooltip-series-group apexcharts-tooltip-series-group-0"
                                bis_skin_checked="1"
                                style="order: 1"
                            >
                                <span
                                    class="apexcharts-tooltip-marker"
                                    style="
                                        background-color: rgb(
                                            26,
                                            86,
                                            219
                                        );
                                    "
                                ></span>
                                <div
                                    class="apexcharts-tooltip-text"
                                    bis_skin_checked="1"
                                    style="
                                        font-family: Inter,
                                            sans-serif;
                                        font-size: 14px;
                                    "
                                >
                                    <div
                                        class="apexcharts-tooltip-y-group"
                                        bis_skin_checked="1"
                                    >
                                        <span
                                            class="apexcharts-tooltip-text-y-label"
                                        ></span
                                        ><span
                                            class="apexcharts-tooltip-text-y-value"
                                        ></span>
                                    </div>
                                    <div
                                        class="apexcharts-tooltip-goals-group"
                                        bis_skin_checked="1"
                                    >
                                        <span
                                            class="apexcharts-tooltip-text-goals-label"
                                        ></span
                                        ><span
                                            class="apexcharts-tooltip-text-goals-value"
                                        ></span>
                                    </div>
                                    <div
                                        class="apexcharts-tooltip-z-group"
                                        bis_skin_checked="1"
                                    >
                                        <span
                                            class="apexcharts-tooltip-text-z-label"
                                        ></span
                                        ><span
                                            class="apexcharts-tooltip-text-z-value"
                                        ></span>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="apexcharts-tooltip-series-group apexcharts-tooltip-series-group-1"
                                bis_skin_checked="1"
                                style="order: 2"
                            >
                                <span
                                    class="apexcharts-tooltip-marker"
                                    style="
                                        background-color: rgb(
                                            253,
                                            186,
                                            140
                                        );
                                    "
                                ></span>
                                <div
                                    class="apexcharts-tooltip-text"
                                    bis_skin_checked="1"
                                    style="
                                        font-family: Inter,
                                            sans-serif;
                                        font-size: 14px;
                                    "
                                >
                                    <div
                                        class="apexcharts-tooltip-y-group"
                                        bis_skin_checked="1"
                                    >
                                        <span
                                            class="apexcharts-tooltip-text-y-label"
                                        ></span
                                        ><span
                                            class="apexcharts-tooltip-text-y-value"
                                        ></span>
                                    </div>
                                    <div
                                        class="apexcharts-tooltip-goals-group"
                                        bis_skin_checked="1"
                                    >
                                        <span
                                            class="apexcharts-tooltip-text-goals-label"
                                        ></span
                                        ><span
                                            class="apexcharts-tooltip-text-goals-value"
                                        ></span>
                                    </div>
                                    <div
                                        class="apexcharts-tooltip-z-group"
                                        bis_skin_checked="1"
                                    >
                                        <span
                                            class="apexcharts-tooltip-text-z-label"
                                        ></span
                                        ><span
                                            class="apexcharts-tooltip-text-z-value"
                                        ></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div
                            class="apexcharts-xaxistooltip apexcharts-xaxistooltip-bottom apexcharts-theme-light"
                            bis_skin_checked="1"
                        >
                            <div
                                class="apexcharts-xaxistooltip-text"
                                bis_skin_checked="1"
                                style="
                                    font-family: Inter,
                                        sans-serif;
                                    font-size: 12px;
                                "
                            ></div>
                        </div>
                        <div
                            class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-light"
                            bis_skin_checked="1"
                        >
                            <div
                                class="apexcharts-yaxistooltip-text"
                                bis_skin_checked="1"
                            ></div>
                        </div>
                    </div>
                </div>
                <!-- Card Footer -->
                <div
                    class="flex items-center justify-between pt-3 mt-4 border-t border-gray-200 sm:pt-6 dark:border-gray-700"
                    bis_skin_checked="1"
                >
                    <div bis_skin_checked="1">
                        <button
                            class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-500 rounded-lg hover:text-gray-900 dark:text-gray-400 dark:hover:text-white"
                            type="button"
                            data-dropdown-toggle="weekly-sales-dropdown"
                        >
                            Last 7 days
                            <svg
                                class="w-4 h-4 ml-2"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M19 9l-7 7-7-7"
                                ></path>
                            </svg>
                        </button>
                        <!-- Dropdown menu -->
                        <div
                            class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600"
                            id="weekly-sales-dropdown"
                            data-popper-placement="bottom"
                            bis_skin_checked="1"
                            style="
                                position: absolute;
                                inset: 0px auto auto 0px;
                                margin: 0px;
                                transform: translate(
                                    91px,
                                    679px
                                );
                            "
                        >
                            <div
                                class="px-4 py-3"
                                role="none"
                                bis_skin_checked="1"
                            >
                                <p
                                    class="text-sm font-medium text-gray-900 truncate dark:text-white"
                                    role="none"
                                >
                                    Sep 16, 2021 - Sep 22, 2021
                                </p>
                            </div>
                            <ul class="py-1" role="none">
                                <li>
                                    <a
                                        href="#"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                                        role="menuitem"
                                        >Yesterday</a
                                    >
                                </li>
                                <li>
                                    <a
                                        href="#"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                                        role="menuitem"
                                        >Today</a
                                    >
                                </li>
                                <li>
                                    <a
                                        href="#"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                                        role="menuitem"
                                        >Last 7 days</a
                                    >
                                </li>
                                <li>
                                    <a
                                        href="#"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                                        role="menuitem"
                                        >Last 30 days</a
                                    >
                                </li>
                                <li>
                                    <a
                                        href="#"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                                        role="menuitem"
                                        >Last 90 days</a
                                    >
                                </li>
                            </ul>
                            <div
                                class="py-1"
                                role="none"
                                bis_skin_checked="1"
                            >
                                <a
                                    href="#"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                                    role="menuitem"
                                    >Custom...</a
                                >
                            </div>
                        </div>
                    </div>
                    <div
                        class="flex-shrink-0"
                        bis_skin_checked="1"
                    >
                        <a
                            href="#"
                            class="inline-flex items-center p-2 text-xs font-medium uppercase rounded-lg text-primary-700 sm:text-sm hover:bg-gray-100 dark:text-primary-500 dark:hover:bg-gray-700"
                        >
                            Sales Report
                            <svg
                                class="w-4 h-4 ml-1"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 5l7 7-7 7"
                                ></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <!--Tabs widget -->
            <div
                class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800"
                bis_skin_checked="1"
            >
                <h3
                    class="flex items-center mb-4 text-lg font-semibold text-gray-900 dark:text-white"
                >
                    Statistics this month
                    <button
                        data-popover-target="popover-description"
                        data-popover-placement="bottom-end"
                        type="button"
                    >
                        <svg
                            class="w-4 h-4 ml-2 text-gray-400 hover:text-gray-500"
                            aria-hidden="true"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                clip-rule="evenodd"
                            ></path></svg
                        ><span class="sr-only"
                            >Show information</span
                        >
                    </button>
                </h3>
                <div
                    data-popover=""
                    id="popover-description"
                    role="tooltip"
                    class="absolute z-10 invisible inline-block text-sm font-light text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 w-72 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400"
                    data-popper-placement="bottom-end"
                    bis_skin_checked="1"
                    style="
                        position: absolute;
                        inset: 0px 0px auto auto;
                        margin: 0px;
                        transform: translate(-115px, 687px);
                    "
                >
                    <div
                        class="p-3 space-y-2"
                        bis_skin_checked="1"
                    >
                        <h3
                            class="font-semibold text-gray-900 dark:text-white"
                        >
                            Statistics
                        </h3>
                        <p>
                            Statistics is a branch of applied
                            mathematics that involves the
                            collection, description, analysis,
                            and inference of conclusions from
                            quantitative data.
                        </p>
                        <a
                            href="#"
                            class="flex items-center font-medium text-primary-600 dark:text-primary-500 dark:hover:text-primary-600 hover:text-primary-700"
                            >Read more
                            <svg
                                class="w-4 h-4 ml-1"
                                aria-hidden="true"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"
                                ></path></svg
                        ></a>
                    </div>
                    <div
                        data-popper-arrow=""
                        style="
                            position: absolute;
                            left: 0px;
                            transform: translate(218px, 0px);
                        "
                        bis_skin_checked="1"
                    ></div>
                </div>
                <div class="sm:hidden" bis_skin_checked="1">
                    <label for="tabs" class="sr-only"
                        >Select tab</label
                    >
                    <select
                        id="tabs"
                        class="bg-gray-50 border-0 border-b border-gray-200 text-gray-900 text-sm rounded-t-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    >
                        <option>Statistics</option>
                        <option>Services</option>
                        <option>FAQ</option>
                    </select>
                </div>
                <ul
                    class="hidden text-sm font-medium text-center text-gray-500 divide-x divide-gray-200 rounded-lg sm:flex dark:divide-gray-600 dark:text-gray-400"
                    id="fullWidthTab"
                    data-tabs-toggle="#fullWidthTabContent"
                    role="tablist"
                >
                    <li class="w-full">
                        <button
                            id="faq-tab"
                            data-tabs-target="#faq"
                            type="button"
                            role="tab"
                            aria-controls="faq"
                            aria-selected="true"
                            class="inline-block w-full p-4 rounded-tl-lg bg-gray-50 hover:bg-gray-100 focus:outline-none dark:bg-gray-700 dark:hover:bg-gray-600 text-blue-600 hover:text-blue-600 dark:text-blue-500 dark:hover:text-blue-500 border-blue-600 dark:border-blue-500"
                        >
                            Top products
                        </button>
                    </li>
                    <li class="w-full">
                        <button
                            id="about-tab"
                            data-tabs-target="#about"
                            type="button"
                            role="tab"
                            aria-controls="about"
                            aria-selected="false"
                            class="inline-block w-full p-4 rounded-tr-lg bg-gray-50 hover:bg-gray-100 focus:outline-none dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-transparent text-gray-500 hover:text-gray-600 dark:text-gray-400 border-gray-100 hover:border-gray-300 dark:border-gray-700 dark:hover:text-gray-300"
                        >
                            Top Customers
                        </button>
                    </li>
                </ul>
                <div
                    id="fullWidthTabContent"
                    class="border-t border-gray-200 dark:border-gray-600"
                    bis_skin_checked="1"
                >
                    <div
                        class="pt-4"
                        id="faq"
                        role="tabpanel"
                        aria-labelledby="faq-tab"
                        bis_skin_checked="1"
                    >
                        <ul
                            role="list"
                            class="divide-y divide-gray-200 dark:divide-gray-700"
                        >
                            <li class="py-3 sm:py-4">
                                <div
                                    class="flex items-center justify-between"
                                    bis_skin_checked="1"
                                >
                                    <div
                                        class="flex items-center min-w-0"
                                        bis_skin_checked="1"
                                    >
                                        <img
                                            class="flex-shrink-0 w-10 h-10"
                                            src="https://flowbite-admin-dashboard.vercel.app/images/products/iphone.png"
                                            alt="imac image"
                                        />
                                        <div
                                            class="ml-3"
                                            bis_skin_checked="1"
                                        >
                                            <p
                                                class="font-medium text-gray-900 truncate dark:text-white"
                                            >
                                                iPhone 14 Pro
                                            </p>
                                            <div
                                                class="flex items-center justify-end flex-1 text-sm text-green-500 dark:text-green-400"
                                                bis_skin_checked="1"
                                            >
                                                <svg
                                                    class="w-4 h-4"
                                                    fill="currentColor"
                                                    viewBox="0 0 20 20"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    aria-hidden="true"
                                                >
                                                    <path
                                                        clip-rule="evenodd"
                                                        fill-rule="evenodd"
                                                        d="M10 17a.75.75 0 01-.75-.75V5.612L5.29 9.77a.75.75 0 01-1.08-1.04l5.25-5.5a.75.75 0 011.08 0l5.25 5.5a.75.75 0 11-1.08 1.04l-3.96-4.158V16.25A.75.75 0 0110 17z"
                                                    ></path>
                                                </svg>
                                                2.5%
                                                <span
                                                    class="ml-2 text-gray-500"
                                                    >vs last
                                                    month</span
                                                >
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white"
                                        bis_skin_checked="1"
                                    >
                                        $445,467
                                    </div>
                                </div>
                            </li>
                            <li class="py-3 sm:py-4">
                                <div
                                    class="flex items-center justify-between"
                                    bis_skin_checked="1"
                                >
                                    <div
                                        class="flex items-center min-w-0"
                                        bis_skin_checked="1"
                                    >
                                        <img
                                            class="flex-shrink-0 w-10 h-10"
                                            src="https://flowbite-admin-dashboard.vercel.app/images/products/imac.png"
                                            alt="imac image"
                                        />
                                        <div
                                            class="ml-3"
                                            bis_skin_checked="1"
                                        >
                                            <p
                                                class="font-medium text-gray-900 truncate dark:text-white"
                                            >
                                                Apple iMac 27"
                                            </p>
                                            <div
                                                class="flex items-center justify-end flex-1 text-sm text-green-500 dark:text-green-400"
                                                bis_skin_checked="1"
                                            >
                                                <svg
                                                    class="w-4 h-4"
                                                    fill="currentColor"
                                                    viewBox="0 0 20 20"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    aria-hidden="true"
                                                >
                                                    <path
                                                        clip-rule="evenodd"
                                                        fill-rule="evenodd"
                                                        d="M10 17a.75.75 0 01-.75-.75V5.612L5.29 9.77a.75.75 0 01-1.08-1.04l5.25-5.5a.75.75 0 011.08 0l5.25 5.5a.75.75 0 11-1.08 1.04l-3.96-4.158V16.25A.75.75 0 0110 17z"
                                                    ></path>
                                                </svg>
                                                12.5%
                                                <span
                                                    class="ml-2 text-gray-500"
                                                    >vs last
                                                    month</span
                                                >
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white"
                                        bis_skin_checked="1"
                                    >
                                        $256,982
                                    </div>
                                </div>
                            </li>
                            <li class="py-3 sm:py-4">
                                <div
                                    class="flex items-center justify-between"
                                    bis_skin_checked="1"
                                >
                                    <div
                                        class="flex items-center min-w-0"
                                        bis_skin_checked="1"
                                    >
                                        <img
                                            class="flex-shrink-0 w-10 h-10"
                                            src="https://flowbite-admin-dashboard.vercel.app/images/products/watch.png"
                                            alt="watch image"
                                        />
                                        <div
                                            class="ml-3"
                                            bis_skin_checked="1"
                                        >
                                            <p
                                                class="font-medium text-gray-900 truncate dark:text-white"
                                            >
                                                Apple Watch SE
                                            </p>
                                            <div
                                                class="flex items-center justify-end flex-1 text-sm text-red-600 dark:text-red-500"
                                                bis_skin_checked="1"
                                            >
                                                <svg
                                                    class="w-4 h-4"
                                                    fill="currentColor"
                                                    viewBox="0 0 20 20"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    aria-hidden="true"
                                                >
                                                    <path
                                                        clip-rule="evenodd"
                                                        fill-rule="evenodd"
                                                        d="M10 3a.75.75 0 01.75.75v10.638l3.96-4.158a.75.75 0 111.08 1.04l-5.25 5.5a.75.75 0 01-1.08 0l-5.25-5.5a.75.75 0 111.08-1.04l3.96 4.158V3.75A.75.75 0 0110 3z"
                                                    ></path>
                                                </svg>
                                                1.35%
                                                <span
                                                    class="ml-2 text-gray-500"
                                                    >vs last
                                                    month</span
                                                >
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white"
                                        bis_skin_checked="1"
                                    >
                                        $201,869
                                    </div>
                                </div>
                            </li>
                            <li class="py-3 sm:py-4">
                                <div
                                    class="flex items-center justify-between"
                                    bis_skin_checked="1"
                                >
                                    <div
                                        class="flex items-center min-w-0"
                                        bis_skin_checked="1"
                                    >
                                        <img
                                            class="flex-shrink-0 w-10 h-10"
                                            src="https://flowbite-admin-dashboard.vercel.app/images/products/ipad.png"
                                            alt="ipad image"
                                        />
                                        <div
                                            class="ml-3"
                                            bis_skin_checked="1"
                                        >
                                            <p
                                                class="font-medium text-gray-900 truncate dark:text-white"
                                            >
                                                Apple iPad Air
                                            </p>
                                            <div
                                                class="flex items-center justify-end flex-1 text-sm text-green-500 dark:text-green-400"
                                                bis_skin_checked="1"
                                            >
                                                <svg
                                                    class="w-4 h-4"
                                                    fill="currentColor"
                                                    viewBox="0 0 20 20"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    aria-hidden="true"
                                                >
                                                    <path
                                                        clip-rule="evenodd"
                                                        fill-rule="evenodd"
                                                        d="M10 17a.75.75 0 01-.75-.75V5.612L5.29 9.77a.75.75 0 01-1.08-1.04l5.25-5.5a.75.75 0 011.08 0l5.25 5.5a.75.75 0 11-1.08 1.04l-3.96-4.158V16.25A.75.75 0 0110 17z"
                                                    ></path>
                                                </svg>
                                                12.5%
                                                <span
                                                    class="ml-2 text-gray-500"
                                                    >vs last
                                                    month</span
                                                >
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white"
                                        bis_skin_checked="1"
                                    >
                                        $103,967
                                    </div>
                                </div>
                            </li>
                            <li class="py-3 sm:py-4">
                                <div
                                    class="flex items-center justify-between"
                                    bis_skin_checked="1"
                                >
                                    <div
                                        class="flex items-center min-w-0"
                                        bis_skin_checked="1"
                                    >
                                        <img
                                            class="flex-shrink-0 w-10 h-10"
                                            src="https://flowbite-admin-dashboard.vercel.app/images/products/imac.png"
                                            alt="imac image"
                                        />
                                        <div
                                            class="ml-3"
                                            bis_skin_checked="1"
                                        >
                                            <p
                                                class="font-medium text-gray-900 truncate dark:text-white"
                                            >
                                                Apple iMac 24"
                                            </p>
                                            <div
                                                class="flex items-center justify-end flex-1 text-sm text-red-600 dark:text-red-500"
                                                bis_skin_checked="1"
                                            >
                                                <svg
                                                    class="w-4 h-4"
                                                    fill="currentColor"
                                                    viewBox="0 0 20 20"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    aria-hidden="true"
                                                >
                                                    <path
                                                        clip-rule="evenodd"
                                                        fill-rule="evenodd"
                                                        d="M10 3a.75.75 0 01.75.75v10.638l3.96-4.158a.75.75 0 111.08 1.04l-5.25 5.5a.75.75 0 01-1.08 0l-5.25-5.5a.75.75 0 111.08-1.04l3.96 4.158V3.75A.75.75 0 0110 3z"
                                                    ></path>
                                                </svg>
                                                2%
                                                <span
                                                    class="ml-2 text-gray-500"
                                                    >vs last
                                                    month</span
                                                >
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white"
                                        bis_skin_checked="1"
                                    >
                                        $98,543
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div
                        class="hidden pt-4"
                        id="about"
                        role="tabpanel"
                        aria-labelledby="about-tab"
                        bis_skin_checked="1"
                    >
                        <ul
                            role="list"
                            class="divide-y divide-gray-200 dark:divide-gray-700"
                        >
                            <li class="py-3 sm:py-4">
                                <div
                                    class="flex items-center space-x-4"
                                    bis_skin_checked="1"
                                >
                                    <div
                                        class="flex-shrink-0"
                                        bis_skin_checked="1"
                                    >
                                        <img
                                            class="w-8 h-8 rounded-full"
                                            src="https://flowbite-admin-dashboard.vercel.app/images/users/neil-sims.png"
                                            alt="Neil image"
                                        />
                                    </div>
                                    <div
                                        class="flex-1 min-w-0"
                                        bis_skin_checked="1"
                                    >
                                        <p
                                            class="font-medium text-gray-900 truncate dark:text-white"
                                        >
                                            Neil Sims
                                        </p>
                                        <p
                                            class="text-sm text-gray-500 truncate dark:text-gray-400"
                                        >
                                            email@flowbite.com
                                        </p>
                                    </div>
                                    <div
                                        class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white"
                                        bis_skin_checked="1"
                                    >
                                        $3320
                                    </div>
                                </div>
                            </li>
                            <li class="py-3 sm:py-4">
                                <div
                                    class="flex items-center space-x-4"
                                    bis_skin_checked="1"
                                >
                                    <div
                                        class="flex-shrink-0"
                                        bis_skin_checked="1"
                                    >
                                        <img
                                            class="w-8 h-8 rounded-full"
                                            src="https://flowbite-admin-dashboard.vercel.app/images/users/bonnie-green.png"
                                            alt="Neil image"
                                        />
                                    </div>
                                    <div
                                        class="flex-1 min-w-0"
                                        bis_skin_checked="1"
                                    >
                                        <p
                                            class="font-medium text-gray-900 truncate dark:text-white"
                                        >
                                            Bonnie Green
                                        </p>
                                        <p
                                            class="text-sm text-gray-500 truncate dark:text-gray-400"
                                        >
                                            email@flowbite.com
                                        </p>
                                    </div>
                                    <div
                                        class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white"
                                        bis_skin_checked="1"
                                    >
                                        $2467
                                    </div>
                                </div>
                            </li>
                            <li class="py-3 sm:py-4">
                                <div
                                    class="flex items-center space-x-4"
                                    bis_skin_checked="1"
                                >
                                    <div
                                        class="flex-shrink-0"
                                        bis_skin_checked="1"
                                    >
                                        <img
                                            class="w-8 h-8 rounded-full"
                                            src="https://flowbite-admin-dashboard.vercel.app/images/users/michael-gough.png"
                                            alt="Neil image"
                                        />
                                    </div>
                                    <div
                                        class="flex-1 min-w-0"
                                        bis_skin_checked="1"
                                    >
                                        <p
                                            class="font-medium text-gray-900 truncate dark:text-white"
                                        >
                                            Michael Gough
                                        </p>
                                        <p
                                            class="text-sm text-gray-500 truncate dark:text-gray-400"
                                        >
                                            email@flowbite.com
                                        </p>
                                    </div>
                                    <div
                                        class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white"
                                        bis_skin_checked="1"
                                    >
                                        $2235
                                    </div>
                                </div>
                            </li>
                            <li class="py-3 sm:py-4">
                                <div
                                    class="flex items-center space-x-4"
                                    bis_skin_checked="1"
                                >
                                    <div
                                        class="flex-shrink-0"
                                        bis_skin_checked="1"
                                    >
                                        <img
                                            class="w-8 h-8 rounded-full"
                                            src="https://flowbite-admin-dashboard.vercel.app/images/users/thomas-lean.png"
                                            alt="Neil image"
                                        />
                                    </div>
                                    <div
                                        class="flex-1 min-w-0"
                                        bis_skin_checked="1"
                                    >
                                        <p
                                            class="font-medium text-gray-900 truncate dark:text-white"
                                        >
                                            Thomes Lean
                                        </p>
                                        <p
                                            class="text-sm text-gray-500 truncate dark:text-gray-400"
                                        >
                                            email@flowbite.com
                                        </p>
                                    </div>
                                    <div
                                        class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white"
                                        bis_skin_checked="1"
                                    >
                                        $1842
                                    </div>
                                </div>
                            </li>
                            <li class="py-3 sm:py-4">
                                <div
                                    class="flex items-center space-x-4"
                                    bis_skin_checked="1"
                                >
                                    <div
                                        class="flex-shrink-0"
                                        bis_skin_checked="1"
                                    >
                                        <img
                                            class="w-8 h-8 rounded-full"
                                            src="https://flowbite-admin-dashboard.vercel.app/images/users/lana-byrd.png"
                                            alt="Neil image"
                                        />
                                    </div>
                                    <div
                                        class="flex-1 min-w-0"
                                        bis_skin_checked="1"
                                    >
                                        <p
                                            class="font-medium text-gray-900 truncate dark:text-white"
                                        >
                                            Lana Byrd
                                        </p>
                                        <p
                                            class="text-sm text-gray-500 truncate dark:text-gray-400"
                                        >
                                            email@flowbite.com
                                        </p>
                                    </div>
                                    <div
                                        class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white"
                                        bis_skin_checked="1"
                                    >
                                        $1044
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- Card Footer -->
                <div
                    class="flex items-center justify-between pt-3 mt-5 border-t border-gray-200 sm:pt-6 dark:border-gray-700"
                    bis_skin_checked="1"
                >
                    <div bis_skin_checked="1">
                        <button
                            class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-500 rounded-lg hover:text-gray-900 dark:text-gray-400 dark:hover:text-white"
                            type="button"
                            data-dropdown-toggle="stats-dropdown"
                        >
                            Last 7 days
                            <svg
                                class="w-4 h-4 ml-2"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M19 9l-7 7-7-7"
                                ></path>
                            </svg>
                        </button>
                        <!-- Dropdown menu -->
                        <div
                            class="z-50 my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600 hidden"
                            id="stats-dropdown"
                            bis_skin_checked="1"
                            style="
                                position: absolute;
                                inset: 0px auto auto 0px;
                                margin: 0px;
                                transform: translate(
                                    1438px,
                                    701px
                                );
                            "
                            aria-hidden="true"
                            data-popper-placement="bottom"
                        >
                            <div
                                class="px-4 py-3"
                                role="none"
                                bis_skin_checked="1"
                            >
                                <p
                                    class="text-sm font-medium text-gray-900 truncate dark:text-white"
                                    role="none"
                                >
                                    Sep 16, 2021 - Sep 22, 2021
                                </p>
                            </div>
                            <ul class="py-1" role="none">
                                <li>
                                    <a
                                        href="#"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                                        role="menuitem"
                                        >Yesterday</a
                                    >
                                </li>
                                <li>
                                    <a
                                        href="#"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                                        role="menuitem"
                                        >Today</a
                                    >
                                </li>
                                <li>
                                    <a
                                        href="#"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                                        role="menuitem"
                                        >Last 7 days</a
                                    >
                                </li>
                                <li>
                                    <a
                                        href="#"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                                        role="menuitem"
                                        >Last 30 days</a
                                    >
                                </li>
                                <li>
                                    <a
                                        href="#"
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                                        role="menuitem"
                                        >Last 90 days</a
                                    >
                                </li>
                            </ul>
                            <div
                                class="py-1"
                                role="none"
                                bis_skin_checked="1"
                            >
                                <a
                                    href="#"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                                    role="menuitem"
                                    >Custom...</a
                                >
                            </div>
                        </div>
                    </div>
                    <div
                        class="flex-shrink-0"
                        bis_skin_checked="1"
                    >
                        <a
                            href="#"
                            class="inline-flex items-center p-2 text-xs font-medium uppercase rounded-lg text-primary-700 sm:text-sm hover:bg-gray-100 dark:text-primary-500 dark:hover:bg-gray-700"
                        >
                            Full Report
                            <svg
                                class="w-4 h-4 ml-1"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 5l7 7-7 7"
                                ></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div
            class="grid w-full grid-cols-1 gap-4 mt-4 xl:grid-cols-2 2xl:grid-cols-3"
            bis_skin_checked="1"
        >
            <div
                class="items-center justify-between p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:flex dark:border-gray-700 sm:p-6 dark:bg-gray-800"
                bis_skin_checked="1"
            >
                <div class="w-full" bis_skin_checked="1">
                    <h3
                        class="text-base font-normal text-gray-500 dark:text-gray-400"
                    >
                        New products
                    </h3>
                    <span
                        class="text-2xl font-bold leading-none text-gray-900 sm:text-3xl dark:text-white"
                        >2,340</span
                    >
                    <p
                        class="flex items-center text-base font-normal text-gray-500 dark:text-gray-400"
                    >
                        <span
                            class="flex items-center mr-1.5 text-sm text-green-500 dark:text-green-400"
                        >
                            <svg
                                class="w-4 h-4"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg"
                                aria-hidden="true"
                            >
                                <path
                                    clip-rule="evenodd"
                                    fill-rule="evenodd"
                                    d="M10 17a.75.75 0 01-.75-.75V5.612L5.29 9.77a.75.75 0 01-1.08-1.04l5.25-5.5a.75.75 0 011.08 0l5.25 5.5a.75.75 0 11-1.08 1.04l-3.96-4.158V16.25A.75.75 0 0110 17z"
                                ></path>
                            </svg>
                            12.5%
                        </span>
                        Since last month
                    </p>
                </div>
                <div
                    class="w-full"
                    id="new-products-chart"
                    bis_skin_checked="1"
                    style="min-height: 155px"
                >
                    <div
                        id="apexchartssazxz4de"
                        class="apexcharts-canvas apexchartssazxz4de apexcharts-theme-"
                        bis_skin_checked="1"
                        style="width: 352px; height: 140px"
                    >
                        <svg
                            id="SvgjsSvg8001"
                            width="352"
                            height="140"
                            xmlns="http://www.w3.org/2000/svg"
                            version="1.1"
                            xmlns:xlink="http://www.w3.org/1999/xlink"
                            xmlns:svgjs="http://svgjs.dev"
                            class="apexcharts-svg"
                            xmlns:data="ApexChartsNS"
                            transform="translate(0, 0)"
                        >
                            <foreignObject
                                x="0"
                                y="0"
                                width="352"
                                height="140"
                                ><div
                                    class="apexcharts-legend"
                                    xmlns="http://www.w3.org/1999/xhtml"
                                    bis_skin_checked="1"
                                    style="max-height: 70px"
                                ></div>
                                <style type="text/css">
                                    .apexcharts-flip-y {
                                        transform: scaleY(-1)
                                            translateY(-100%);
                                        transform-origin: top;
                                        transform-box: fill-box;
                                    }
                                    .apexcharts-flip-x {
                                        transform: scaleX(-1);
                                        transform-origin: center;
                                        transform-box: fill-box;
                                    }
                                    .apexcharts-legend {
                                        display: flex;
                                        overflow: auto;
                                        padding: 0 10px;
                                    }
                                    .apexcharts-legend.apx-legend-position-bottom,
                                    .apexcharts-legend.apx-legend-position-top {
                                        flex-wrap: wrap;
                                    }
                                    .apexcharts-legend.apx-legend-position-right,
                                    .apexcharts-legend.apx-legend-position-left {
                                        flex-direction: column;
                                        bottom: 0;
                                    }
                                    .apexcharts-legend.apx-legend-position-bottom.apexcharts-align-left,
                                    .apexcharts-legend.apx-legend-position-top.apexcharts-align-left,
                                    .apexcharts-legend.apx-legend-position-right,
                                    .apexcharts-legend.apx-legend-position-left {
                                        justify-content: flex-start;
                                    }
                                    .apexcharts-legend.apx-legend-position-bottom.apexcharts-align-center,
                                    .apexcharts-legend.apx-legend-position-top.apexcharts-align-center {
                                        justify-content: center;
                                    }
                                    .apexcharts-legend.apx-legend-position-bottom.apexcharts-align-right,
                                    .apexcharts-legend.apx-legend-position-top.apexcharts-align-right {
                                        justify-content: flex-end;
                                    }
                                    .apexcharts-legend-series {
                                        cursor: pointer;
                                        line-height: normal;
                                        display: flex;
                                        align-items: center;
                                    }
                                    .apexcharts-legend-text {
                                        position: relative;
                                        font-size: 14px;
                                    }
                                    .apexcharts-legend-text *,
                                    .apexcharts-legend-marker
                                        * {
                                        pointer-events: none;
                                    }
                                    .apexcharts-legend-marker {
                                        position: relative;
                                        display: flex;
                                        align-items: center;
                                        justify-content: center;
                                        cursor: pointer;
                                        margin-right: 1px;
                                    }

                                    .apexcharts-legend-series.apexcharts-no-click {
                                        cursor: auto;
                                    }
                                    .apexcharts-legend
                                        .apexcharts-hidden-zero-series,
                                    .apexcharts-legend
                                        .apexcharts-hidden-null-series {
                                        display: none !important;
                                    }
                                    .apexcharts-inactive-legend {
                                        opacity: 0.45;
                                    }
                                </style></foreignObject
                            >
                            <g
                                id="SvgjsG8013"
                                class="apexcharts-datalabels-group"
                                transform="translate(0, 0) scale(1)"
                            ></g>
                            <g
                                id="SvgjsG8014"
                                class="apexcharts-datalabels-group"
                                transform="translate(0, 0) scale(1)"
                            ></g>
                            <g
                                id="SvgjsG8054"
                                class="apexcharts-yaxis"
                                rel="0"
                                transform="translate(-18, 0)"
                            ></g>
                            <g
                                id="SvgjsG8003"
                                class="apexcharts-inner apexcharts-graphical"
                                transform="translate(12, 30)"
                            >
                                <defs id="SvgjsDefs8002">
                                    <linearGradient
                                        id="SvgjsLinearGradient8005"
                                        x1="0"
                                        y1="0"
                                        x2="0"
                                        y2="1"
                                    >
                                        <stop
                                            id="SvgjsStop8006"
                                            stop-opacity="0.4"
                                            stop-color="rgba(216,227,240,0.4)"
                                            offset="0"
                                        ></stop>
                                        <stop
                                            id="SvgjsStop8007"
                                            stop-opacity="0.5"
                                            stop-color="rgba(190,209,230,0.5)"
                                            offset="1"
                                        ></stop>
                                        <stop
                                            id="SvgjsStop8008"
                                            stop-opacity="0.5"
                                            stop-color="rgba(190,209,230,0.5)"
                                            offset="1"
                                        ></stop>
                                    </linearGradient>
                                    <clipPath
                                        id="gridRectMasksazxz4de"
                                    >
                                        <rect
                                            id="SvgjsRect8010"
                                            width="330"
                                            height="95"
                                            x="0"
                                            y="0"
                                            rx="0"
                                            ry="0"
                                            opacity="1"
                                            stroke-width="0"
                                            stroke="none"
                                            stroke-dasharray="0"
                                            fill="#fff"
                                        ></rect>
                                    </clipPath>
                                    <clipPath
                                        id="gridRectBarMasksazxz4de"
                                    >
                                        <rect
                                            id="SvgjsRect8011"
                                            width="339"
                                            height="104"
                                            x="-4.5"
                                            y="-4.5"
                                            rx="0"
                                            ry="0"
                                            opacity="1"
                                            stroke-width="0"
                                            stroke="none"
                                            stroke-dasharray="0"
                                            fill="#fff"
                                        ></rect>
                                    </clipPath>
                                    <clipPath
                                        id="gridRectMarkerMasksazxz4de"
                                    >
                                        <rect
                                            id="SvgjsRect8012"
                                            width="330"
                                            height="95"
                                            x="0"
                                            y="0"
                                            rx="0"
                                            ry="0"
                                            opacity="1"
                                            stroke-width="0"
                                            stroke="none"
                                            stroke-dasharray="0"
                                            fill="#fff"
                                        ></rect>
                                    </clipPath>
                                    <clipPath
                                        id="forecastMasksazxz4de"
                                    ></clipPath>
                                    <clipPath
                                        id="nonForecastMasksazxz4de"
                                    ></clipPath>
                                </defs>
                                <rect
                                    id="SvgjsRect8009"
                                    width="42.42857142857143"
                                    height="95"
                                    x="0"
                                    y="0"
                                    rx="0"
                                    ry="0"
                                    opacity="1"
                                    stroke-width="0"
                                    stroke-dasharray="3"
                                    fill="url(#SvgjsLinearGradient8005)"
                                    class="apexcharts-xcrosshairs"
                                    y2="95"
                                    filter="none"
                                    fill-opacity="0.9"
                                ></rect>
                                <g
                                    id="SvgjsG8034"
                                    class="apexcharts-grid"
                                >
                                    <g
                                        id="SvgjsG8035"
                                        class="apexcharts-gridlines-horizontal"
                                        style="display: none"
                                    >
                                        <line
                                            id="SvgjsLine8038"
                                            x1="0"
                                            y1="0"
                                            x2="330"
                                            y2="0"
                                            stroke="#e0e0e0"
                                            stroke-dasharray="0"
                                            stroke-linecap="butt"
                                            class="apexcharts-gridline"
                                        ></line>
                                        <line
                                            id="SvgjsLine8039"
                                            x1="0"
                                            y1="47.5"
                                            x2="330"
                                            y2="47.5"
                                            stroke="#e0e0e0"
                                            stroke-dasharray="0"
                                            stroke-linecap="butt"
                                            class="apexcharts-gridline"
                                        ></line>
                                        <line
                                            id="SvgjsLine8040"
                                            x1="0"
                                            y1="95"
                                            x2="330"
                                            y2="95"
                                            stroke="#e0e0e0"
                                            stroke-dasharray="0"
                                            stroke-linecap="butt"
                                            class="apexcharts-gridline"
                                        ></line>
                                    </g>
                                    <g
                                        id="SvgjsG8036"
                                        class="apexcharts-gridlines-vertical"
                                        style="display: none"
                                    ></g>
                                    <line
                                        id="SvgjsLine8042"
                                        x1="0"
                                        y1="95"
                                        x2="330"
                                        y2="95"
                                        stroke="transparent"
                                        stroke-dasharray="0"
                                        stroke-linecap="butt"
                                    ></line>
                                    <line
                                        id="SvgjsLine8041"
                                        x1="0"
                                        y1="1"
                                        x2="0"
                                        y2="95"
                                        stroke="transparent"
                                        stroke-dasharray="0"
                                        stroke-linecap="butt"
                                    ></line>
                                </g>
                                <g
                                    id="SvgjsG8037"
                                    class="apexcharts-grid-borders"
                                    style="display: none"
                                ></g>
                                <g
                                    id="SvgjsG8015"
                                    class="apexcharts-bar-series apexcharts-plot-series"
                                >
                                    <g
                                        id="SvgjsG8016"
                                        class="apexcharts-series"
                                        rel="1"
                                        seriesName="Quantity"
                                        data:realIndex="0"
                                    >
                                        <path
                                            id="SvgjsPath8021"
                                            d="M 4.857142857142858 89.501 L 4.857142857142858 19.751 C 4.857142857142858 18.251 6.357142857142858 16.751 7.857142857142858 16.751 L 39.28571428571429 16.751 C 40.78571428571429 16.751 42.28571428571429 18.251 42.28571428571429 19.751 L 42.28571428571429 89.501 C 42.28571428571429 91.001 40.78571428571429 92.501 39.28571428571429 92.501 L 7.857142857142858 92.501 C 6.357142857142858 92.501 4.857142857142858 91.001 4.857142857142858 89.501 Z "
                                            fill="rgba(26,86,219,1)"
                                            fill-opacity="1"
                                            stroke="transparent"
                                            stroke-opacity="1"
                                            stroke-linecap="round"
                                            stroke-width="5"
                                            stroke-dasharray="0"
                                            class="apexcharts-bar-area undefined"
                                            index="0"
                                            clip-path="url(#gridRectBarMasksazxz4de)"
                                            pathTo="M 4.857142857142858 89.501 L 4.857142857142858 19.751 C 4.857142857142858 18.251 6.357142857142858 16.751 7.857142857142858 16.751 L 39.28571428571429 16.751 C 40.78571428571429 16.751 42.28571428571429 18.251 42.28571428571429 19.751 L 42.28571428571429 89.501 C 42.28571428571429 91.001 40.78571428571429 92.501 39.28571428571429 92.501 L 7.857142857142858 92.501 C 6.357142857142858 92.501 4.857142857142858 91.001 4.857142857142858 89.501 Z "
                                            pathFrom="M 4.857142857142858 92.501 L 4.857142857142858 92.501 L 42.28571428571429 92.501 L 42.28571428571429 92.501 L 42.28571428571429 92.501 L 42.28571428571429 92.501 L 42.28571428571429 92.501 L 4.857142857142858 92.501 Z"
                                            cy="14.25"
                                            cx="47"
                                            j="0"
                                            val="170"
                                            barHeight="80.75"
                                            barWidth="42.42857142857143"
                                        ></path>
                                        <path
                                            id="SvgjsPath8023"
                                            d="M 52 89.501 L 52 15.001 C 52 13.501 53.5 12.001 55 12.001 L 86.42857142857143 12.001 C 87.92857142857143 12.001 89.42857142857143 13.501 89.42857142857143 15.001 L 89.42857142857143 89.501 C 89.42857142857143 91.001 87.92857142857143 92.501 86.42857142857143 92.501 L 55 92.501 C 53.5 92.501 52 91.001 52 89.501 Z "
                                            fill="rgba(26,86,219,1)"
                                            fill-opacity="1"
                                            stroke="transparent"
                                            stroke-opacity="1"
                                            stroke-linecap="round"
                                            stroke-width="5"
                                            stroke-dasharray="0"
                                            class="apexcharts-bar-area undefined"
                                            index="0"
                                            clip-path="url(#gridRectBarMasksazxz4de)"
                                            pathTo="M 52 89.501 L 52 15.001 C 52 13.501 53.5 12.001 55 12.001 L 86.42857142857143 12.001 C 87.92857142857143 12.001 89.42857142857143 13.501 89.42857142857143 15.001 L 89.42857142857143 89.501 C 89.42857142857143 91.001 87.92857142857143 92.501 86.42857142857143 92.501 L 55 92.501 C 53.5 92.501 52 91.001 52 89.501 Z "
                                            pathFrom="M 52 92.501 L 52 92.501 L 89.42857142857143 92.501 L 89.42857142857143 92.501 L 89.42857142857143 92.501 L 89.42857142857143 92.501 L 89.42857142857143 92.501 L 52 92.501 Z"
                                            cy="9.5"
                                            cx="94.14285714285714"
                                            j="1"
                                            val="180"
                                            barHeight="85.5"
                                            barWidth="42.42857142857143"
                                        ></path>
                                        <path
                                            id="SvgjsPath8025"
                                            d="M 99.14285714285714 89.501 L 99.14285714285714 22.600999999999996 C 99.14285714285714 21.100999999999996 100.64285714285714 19.600999999999996 102.14285714285714 19.600999999999996 L 133.57142857142856 19.600999999999996 C 135.07142857142856 19.600999999999996 136.57142857142856 21.100999999999996 136.57142857142856 22.600999999999996 L 136.57142857142856 89.501 C 136.57142857142856 91.001 135.07142857142856 92.501 133.57142857142856 92.501 L 102.14285714285714 92.501 C 100.64285714285714 92.501 99.14285714285714 91.001 99.14285714285714 89.501 Z "
                                            fill="rgba(26,86,219,1)"
                                            fill-opacity="1"
                                            stroke="transparent"
                                            stroke-opacity="1"
                                            stroke-linecap="round"
                                            stroke-width="5"
                                            stroke-dasharray="0"
                                            class="apexcharts-bar-area undefined"
                                            index="0"
                                            clip-path="url(#gridRectBarMasksazxz4de)"
                                            pathTo="M 99.14285714285714 89.501 L 99.14285714285714 22.600999999999996 C 99.14285714285714 21.100999999999996 100.64285714285714 19.600999999999996 102.14285714285714 19.600999999999996 L 133.57142857142856 19.600999999999996 C 135.07142857142856 19.600999999999996 136.57142857142856 21.100999999999996 136.57142857142856 22.600999999999996 L 136.57142857142856 89.501 C 136.57142857142856 91.001 135.07142857142856 92.501 133.57142857142856 92.501 L 102.14285714285714 92.501 C 100.64285714285714 92.501 99.14285714285714 91.001 99.14285714285714 89.501 Z "
                                            pathFrom="M 99.14285714285714 92.501 L 99.14285714285714 92.501 L 136.57142857142856 92.501 L 136.57142857142856 92.501 L 136.57142857142856 92.501 L 136.57142857142856 92.501 L 136.57142857142856 92.501 L 99.14285714285714 92.501 Z"
                                            cy="17.099999999999994"
                                            cx="141.28571428571428"
                                            j="2"
                                            val="164"
                                            barHeight="77.9"
                                            barWidth="42.42857142857143"
                                        ></path>
                                        <path
                                            id="SvgjsPath8027"
                                            d="M 146.28571428571428 89.501 L 146.28571428571428 31.626 C 146.28571428571428 30.126 147.78571428571428 28.626 149.28571428571428 28.626 L 180.71428571428572 28.626 C 182.21428571428572 28.626 183.71428571428572 30.126 183.71428571428572 31.626 L 183.71428571428572 89.501 C 183.71428571428572 91.001 182.21428571428572 92.501 180.71428571428572 92.501 L 149.28571428571428 92.501 C 147.78571428571428 92.501 146.28571428571428 91.001 146.28571428571428 89.501 Z "
                                            fill="rgba(26,86,219,1)"
                                            fill-opacity="1"
                                            stroke="transparent"
                                            stroke-opacity="1"
                                            stroke-linecap="round"
                                            stroke-width="5"
                                            stroke-dasharray="0"
                                            class="apexcharts-bar-area undefined"
                                            index="0"
                                            clip-path="url(#gridRectBarMasksazxz4de)"
                                            pathTo="M 146.28571428571428 89.501 L 146.28571428571428 31.626 C 146.28571428571428 30.126 147.78571428571428 28.626 149.28571428571428 28.626 L 180.71428571428572 28.626 C 182.21428571428572 28.626 183.71428571428572 30.126 183.71428571428572 31.626 L 183.71428571428572 89.501 C 183.71428571428572 91.001 182.21428571428572 92.501 180.71428571428572 92.501 L 149.28571428571428 92.501 C 147.78571428571428 92.501 146.28571428571428 91.001 146.28571428571428 89.501 Z "
                                            pathFrom="M 146.28571428571428 92.501 L 146.28571428571428 92.501 L 183.71428571428572 92.501 L 183.71428571428572 92.501 L 183.71428571428572 92.501 L 183.71428571428572 92.501 L 183.71428571428572 92.501 L 146.28571428571428 92.501 Z"
                                            cy="26.125"
                                            cx="188.42857142857142"
                                            j="3"
                                            val="145"
                                            barHeight="68.875"
                                            barWidth="42.42857142857143"
                                        ></path>
                                        <path
                                            id="SvgjsPath8029"
                                            d="M 193.42857142857142 89.501 L 193.42857142857142 8.350999999999994 C 193.42857142857142 6.850999999999994 194.92857142857142 5.350999999999994 196.42857142857142 5.350999999999994 L 227.85714285714283 5.350999999999994 C 229.35714285714283 5.350999999999994 230.85714285714283 6.850999999999994 230.85714285714283 8.350999999999994 L 230.85714285714283 89.501 C 230.85714285714283 91.001 229.35714285714283 92.501 227.85714285714283 92.501 L 196.42857142857142 92.501 C 194.92857142857142 92.501 193.42857142857142 91.001 193.42857142857142 89.501 Z "
                                            fill="rgba(26,86,219,1)"
                                            fill-opacity="1"
                                            stroke="transparent"
                                            stroke-opacity="1"
                                            stroke-linecap="round"
                                            stroke-width="5"
                                            stroke-dasharray="0"
                                            class="apexcharts-bar-area undefined"
                                            index="0"
                                            clip-path="url(#gridRectBarMasksazxz4de)"
                                            pathTo="M 193.42857142857142 89.501 L 193.42857142857142 8.350999999999994 C 193.42857142857142 6.850999999999994 194.92857142857142 5.350999999999994 196.42857142857142 5.350999999999994 L 227.85714285714283 5.350999999999994 C 229.35714285714283 5.350999999999994 230.85714285714283 6.850999999999994 230.85714285714283 8.350999999999994 L 230.85714285714283 89.501 C 230.85714285714283 91.001 229.35714285714283 92.501 227.85714285714283 92.501 L 196.42857142857142 92.501 C 194.92857142857142 92.501 193.42857142857142 91.001 193.42857142857142 89.501 Z "
                                            pathFrom="M 193.42857142857142 92.501 L 193.42857142857142 92.501 L 230.85714285714283 92.501 L 230.85714285714283 92.501 L 230.85714285714283 92.501 L 230.85714285714283 92.501 L 230.85714285714283 92.501 L 193.42857142857142 92.501 Z"
                                            cy="2.8499999999999943"
                                            cx="235.57142857142856"
                                            j="4"
                                            val="194"
                                            barHeight="92.15"
                                            barWidth="42.42857142857143"
                                        ></path>
                                        <path
                                            id="SvgjsPath8031"
                                            d="M 240.57142857142856 89.501 L 240.57142857142856 19.751 C 240.57142857142856 18.251 242.07142857142856 16.751 243.57142857142856 16.751 L 275 16.751 C 276.5 16.751 278 18.251 278 19.751 L 278 89.501 C 278 91.001 276.5 92.501 275 92.501 L 243.57142857142856 92.501 C 242.07142857142856 92.501 240.57142857142856 91.001 240.57142857142856 89.501 Z "
                                            fill="rgba(26,86,219,1)"
                                            fill-opacity="1"
                                            stroke="transparent"
                                            stroke-opacity="1"
                                            stroke-linecap="round"
                                            stroke-width="5"
                                            stroke-dasharray="0"
                                            class="apexcharts-bar-area undefined"
                                            index="0"
                                            clip-path="url(#gridRectBarMasksazxz4de)"
                                            pathTo="M 240.57142857142856 89.501 L 240.57142857142856 19.751 C 240.57142857142856 18.251 242.07142857142856 16.751 243.57142857142856 16.751 L 275 16.751 C 276.5 16.751 278 18.251 278 19.751 L 278 89.501 C 278 91.001 276.5 92.501 275 92.501 L 243.57142857142856 92.501 C 242.07142857142856 92.501 240.57142857142856 91.001 240.57142857142856 89.501 Z "
                                            pathFrom="M 240.57142857142856 92.501 L 240.57142857142856 92.501 L 278 92.501 L 278 92.501 L 278 92.501 L 278 92.501 L 278 92.501 L 240.57142857142856 92.501 Z"
                                            cy="14.25"
                                            cx="282.7142857142857"
                                            j="5"
                                            val="170"
                                            barHeight="80.75"
                                            barWidth="42.42857142857143"
                                        ></path>
                                        <path
                                            id="SvgjsPath8033"
                                            d="M 287.7142857142857 89.501 L 287.7142857142857 26.876 C 287.7142857142857 25.376 289.2142857142857 23.876 290.7142857142857 23.876 L 322.14285714285717 23.876 C 323.64285714285717 23.876 325.14285714285717 25.376 325.14285714285717 26.876 L 325.14285714285717 89.501 C 325.14285714285717 91.001 323.64285714285717 92.501 322.14285714285717 92.501 L 290.7142857142857 92.501 C 289.2142857142857 92.501 287.7142857142857 91.001 287.7142857142857 89.501 Z "
                                            fill="rgba(26,86,219,1)"
                                            fill-opacity="1"
                                            stroke="transparent"
                                            stroke-opacity="1"
                                            stroke-linecap="round"
                                            stroke-width="5"
                                            stroke-dasharray="0"
                                            class="apexcharts-bar-area undefined"
                                            index="0"
                                            clip-path="url(#gridRectBarMasksazxz4de)"
                                            pathTo="M 287.7142857142857 89.501 L 287.7142857142857 26.876 C 287.7142857142857 25.376 289.2142857142857 23.876 290.7142857142857 23.876 L 322.14285714285717 23.876 C 323.64285714285717 23.876 325.14285714285717 25.376 325.14285714285717 26.876 L 325.14285714285717 89.501 C 325.14285714285717 91.001 323.64285714285717 92.501 322.14285714285717 92.501 L 290.7142857142857 92.501 C 289.2142857142857 92.501 287.7142857142857 91.001 287.7142857142857 89.501 Z "
                                            pathFrom="M 287.7142857142857 92.501 L 287.7142857142857 92.501 L 325.14285714285717 92.501 L 325.14285714285717 92.501 L 325.14285714285717 92.501 L 325.14285714285717 92.501 L 325.14285714285717 92.501 L 287.7142857142857 92.501 Z"
                                            cy="21.375"
                                            cx="329.8571428571429"
                                            j="6"
                                            val="155"
                                            barHeight="73.625"
                                            barWidth="42.42857142857143"
                                        ></path>
                                        <g
                                            id="SvgjsG8018"
                                            class="apexcharts-bar-goals-markers"
                                        >
                                            <g
                                                id="SvgjsG8020"
                                                className="apexcharts-bar-goals-groups"
                                                class="apexcharts-hidden-element-shown"
                                                clip-path="url(#gridRectMarkerMasksazxz4de)"
                                            ></g>
                                            <g
                                                id="SvgjsG8022"
                                                className="apexcharts-bar-goals-groups"
                                                class="apexcharts-hidden-element-shown"
                                                clip-path="url(#gridRectMarkerMasksazxz4de)"
                                            ></g>
                                            <g
                                                id="SvgjsG8024"
                                                className="apexcharts-bar-goals-groups"
                                                class="apexcharts-hidden-element-shown"
                                                clip-path="url(#gridRectMarkerMasksazxz4de)"
                                            ></g>
                                            <g
                                                id="SvgjsG8026"
                                                className="apexcharts-bar-goals-groups"
                                                class="apexcharts-hidden-element-shown"
                                                clip-path="url(#gridRectMarkerMasksazxz4de)"
                                            ></g>
                                            <g
                                                id="SvgjsG8028"
                                                className="apexcharts-bar-goals-groups"
                                                class="apexcharts-hidden-element-shown"
                                                clip-path="url(#gridRectMarkerMasksazxz4de)"
                                            ></g>
                                            <g
                                                id="SvgjsG8030"
                                                className="apexcharts-bar-goals-groups"
                                                class="apexcharts-hidden-element-shown"
                                                clip-path="url(#gridRectMarkerMasksazxz4de)"
                                            ></g>
                                            <g
                                                id="SvgjsG8032"
                                                className="apexcharts-bar-goals-groups"
                                                class="apexcharts-hidden-element-shown"
                                                clip-path="url(#gridRectMarkerMasksazxz4de)"
                                            ></g>
                                        </g>
                                        <g
                                            id="SvgjsG8019"
                                            class="apexcharts-bar-shadows apexcharts-hidden-element-shown"
                                        ></g>
                                    </g>
                                    <g
                                        id="SvgjsG8017"
                                        class="apexcharts-datalabels apexcharts-hidden-element-shown"
                                        data:realIndex="0"
                                    ></g>
                                </g>
                                <line
                                    id="SvgjsLine8043"
                                    x1="0"
                                    y1="0"
                                    x2="330"
                                    y2="0"
                                    stroke="#b6b6b6"
                                    stroke-dasharray="0"
                                    stroke-width="1"
                                    stroke-linecap="butt"
                                    class="apexcharts-ycrosshairs"
                                ></line>
                                <line
                                    id="SvgjsLine8044"
                                    x1="0"
                                    y1="0"
                                    x2="330"
                                    y2="0"
                                    stroke-dasharray="0"
                                    stroke-width="0"
                                    stroke-linecap="butt"
                                    class="apexcharts-ycrosshairs-hidden"
                                ></line>
                                <g
                                    id="SvgjsG8045"
                                    class="apexcharts-xaxis"
                                    transform="translate(0, 0)"
                                >
                                    <g
                                        id="SvgjsG8046"
                                        class="apexcharts-xaxis-texts-g"
                                        transform="translate(0, -4)"
                                    ></g>
                                </g>
                                <g
                                    id="SvgjsG8055"
                                    class="apexcharts-yaxis-annotations"
                                ></g>
                                <g
                                    id="SvgjsG8056"
                                    class="apexcharts-xaxis-annotations"
                                ></g>
                                <g
                                    id="SvgjsG8057"
                                    class="apexcharts-point-annotations"
                                ></g>
                            </g>
                        </svg>
                        <div
                            class="apexcharts-tooltip apexcharts-theme-light"
                            bis_skin_checked="1"
                        >
                            <div
                                class="apexcharts-tooltip-title"
                                bis_skin_checked="1"
                                style="
                                    font-family: Inter,
                                        sans-serif;
                                    font-size: 14px;
                                "
                            ></div>
                            <div
                                class="apexcharts-tooltip-series-group apexcharts-tooltip-series-group-0"
                                bis_skin_checked="1"
                                style="order: 1"
                            >
                                <span
                                    class="apexcharts-tooltip-marker"
                                    style="
                                        background-color: rgb(
                                            26,
                                            86,
                                            219
                                        );
                                    "
                                ></span>
                                <div
                                    class="apexcharts-tooltip-text"
                                    bis_skin_checked="1"
                                    style="
                                        font-family: Inter,
                                            sans-serif;
                                        font-size: 14px;
                                    "
                                >
                                    <div
                                        class="apexcharts-tooltip-y-group"
                                        bis_skin_checked="1"
                                    >
                                        <span
                                            class="apexcharts-tooltip-text-y-label"
                                        ></span
                                        ><span
                                            class="apexcharts-tooltip-text-y-value"
                                        ></span>
                                    </div>
                                    <div
                                        class="apexcharts-tooltip-goals-group"
                                        bis_skin_checked="1"
                                    >
                                        <span
                                            class="apexcharts-tooltip-text-goals-label"
                                        ></span
                                        ><span
                                            class="apexcharts-tooltip-text-goals-value"
                                        ></span>
                                    </div>
                                    <div
                                        class="apexcharts-tooltip-z-group"
                                        bis_skin_checked="1"
                                    >
                                        <span
                                            class="apexcharts-tooltip-text-z-label"
                                        ></span
                                        ><span
                                            class="apexcharts-tooltip-text-z-value"
                                        ></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div
                            class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-light"
                            bis_skin_checked="1"
                        >
                            <div
                                class="apexcharts-yaxistooltip-text"
                                bis_skin_checked="1"
                            ></div>
                        </div>
                    </div>
                </div>
            </div>
            <div
                class="items-center justify-between p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:flex dark:border-gray-700 sm:p-6 dark:bg-gray-800"
                bis_skin_checked="1"
            >
                <div class="w-full" bis_skin_checked="1">
                    <h3
                        class="text-base font-normal text-gray-500 dark:text-gray-400"
                    >
                        Users
                    </h3>
                    <span
                        class="text-2xl font-bold leading-none text-gray-900 sm:text-3xl dark:text-white"
                        >2,340</span
                    >
                    <p
                        class="flex items-center text-base font-normal text-gray-500 dark:text-gray-400"
                    >
                        <span
                            class="flex items-center mr-1.5 text-sm text-green-500 dark:text-green-400"
                        >
                            <svg
                                class="w-4 h-4"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg"
                                aria-hidden="true"
                            >
                                <path
                                    clip-rule="evenodd"
                                    fill-rule="evenodd"
                                    d="M10 17a.75.75 0 01-.75-.75V5.612L5.29 9.77a.75.75 0 01-1.08-1.04l5.25-5.5a.75.75 0 011.08 0l5.25 5.5a.75.75 0 11-1.08 1.04l-3.96-4.158V16.25A.75.75 0 0110 17z"
                                ></path>
                            </svg>
                            3,4%
                        </span>
                        Since last month
                    </p>
                </div>
                <div
                    class="w-full"
                    id="week-signups-chart"
                    bis_skin_checked="1"
                    style="min-height: 155px"
                >
                    <div
                        id="apexchartsoa1tixt6"
                        class="apexcharts-canvas apexchartsoa1tixt6 apexcharts-theme-"
                        bis_skin_checked="1"
                        style="width: 352px; height: 140px"
                    >
                        <svg
                            id="SvgjsSvg8058"
                            width="352"
                            height="140"
                            xmlns="http://www.w3.org/2000/svg"
                            version="1.1"
                            xmlns:xlink="http://www.w3.org/1999/xlink"
                            xmlns:svgjs="http://svgjs.dev"
                            class="apexcharts-svg"
                            xmlns:data="ApexChartsNS"
                            transform="translate(0, 0)"
                        >
                            <foreignObject
                                x="0"
                                y="0"
                                width="352"
                                height="140"
                                ><div
                                    class="apexcharts-legend"
                                    xmlns="http://www.w3.org/1999/xhtml"
                                    bis_skin_checked="1"
                                    style="max-height: 70px"
                                ></div>
                                <style type="text/css">
                                    .apexcharts-flip-y {
                                        transform: scaleY(-1)
                                            translateY(-100%);
                                        transform-origin: top;
                                        transform-box: fill-box;
                                    }
                                    .apexcharts-flip-x {
                                        transform: scaleX(-1);
                                        transform-origin: center;
                                        transform-box: fill-box;
                                    }
                                    .apexcharts-legend {
                                        display: flex;
                                        overflow: auto;
                                        padding: 0 10px;
                                    }
                                    .apexcharts-legend.apx-legend-position-bottom,
                                    .apexcharts-legend.apx-legend-position-top {
                                        flex-wrap: wrap;
                                    }
                                    .apexcharts-legend.apx-legend-position-right,
                                    .apexcharts-legend.apx-legend-position-left {
                                        flex-direction: column;
                                        bottom: 0;
                                    }
                                    .apexcharts-legend.apx-legend-position-bottom.apexcharts-align-left,
                                    .apexcharts-legend.apx-legend-position-top.apexcharts-align-left,
                                    .apexcharts-legend.apx-legend-position-right,
                                    .apexcharts-legend.apx-legend-position-left {
                                        justify-content: flex-start;
                                    }
                                    .apexcharts-legend.apx-legend-position-bottom.apexcharts-align-center,
                                    .apexcharts-legend.apx-legend-position-top.apexcharts-align-center {
                                        justify-content: center;
                                    }
                                    .apexcharts-legend.apx-legend-position-bottom.apexcharts-align-right,
                                    .apexcharts-legend.apx-legend-position-top.apexcharts-align-right {
                                        justify-content: flex-end;
                                    }
                                    .apexcharts-legend-series {
                                        cursor: pointer;
                                        line-height: normal;
                                        display: flex;
                                        align-items: center;
                                    }
                                    .apexcharts-legend-text {
                                        position: relative;
                                        font-size: 14px;
                                    }
                                    .apexcharts-legend-text *,
                                    .apexcharts-legend-marker
                                        * {
                                        pointer-events: none;
                                    }
                                    .apexcharts-legend-marker {
                                        position: relative;
                                        display: flex;
                                        align-items: center;
                                        justify-content: center;
                                        cursor: pointer;
                                        margin-right: 1px;
                                    }

                                    .apexcharts-legend-series.apexcharts-no-click {
                                        cursor: auto;
                                    }
                                    .apexcharts-legend
                                        .apexcharts-hidden-zero-series,
                                    .apexcharts-legend
                                        .apexcharts-hidden-null-series {
                                        display: none !important;
                                    }
                                    .apexcharts-inactive-legend {
                                        opacity: 0.45;
                                    }
                                </style></foreignObject
                            >
                            <g
                                id="SvgjsG8070"
                                class="apexcharts-datalabels-group"
                                transform="translate(0, 0) scale(1)"
                            ></g>
                            <g
                                id="SvgjsG8071"
                                class="apexcharts-datalabels-group"
                                transform="translate(0, 0) scale(1)"
                            ></g>
                            <g
                                id="SvgjsG8118"
                                class="apexcharts-yaxis"
                                rel="0"
                                transform="translate(-18, 0)"
                            ></g>
                            <g
                                id="SvgjsG8060"
                                class="apexcharts-inner apexcharts-graphical"
                                transform="translate(12, 30)"
                            >
                                <defs id="SvgjsDefs8059">
                                    <linearGradient
                                        id="SvgjsLinearGradient8062"
                                        x1="0"
                                        y1="0"
                                        x2="0"
                                        y2="1"
                                    >
                                        <stop
                                            id="SvgjsStop8063"
                                            stop-opacity="0.4"
                                            stop-color="rgba(216,227,240,0.4)"
                                            offset="0"
                                        ></stop>
                                        <stop
                                            id="SvgjsStop8064"
                                            stop-opacity="0.5"
                                            stop-color="rgba(190,209,230,0.5)"
                                            offset="1"
                                        ></stop>
                                        <stop
                                            id="SvgjsStop8065"
                                            stop-opacity="0.5"
                                            stop-color="rgba(190,209,230,0.5)"
                                            offset="1"
                                        ></stop>
                                    </linearGradient>
                                    <clipPath
                                        id="gridRectMaskoa1tixt6"
                                    >
                                        <rect
                                            id="SvgjsRect8067"
                                            width="330"
                                            height="95"
                                            x="0"
                                            y="0"
                                            rx="0"
                                            ry="0"
                                            opacity="1"
                                            stroke-width="0"
                                            stroke="none"
                                            stroke-dasharray="0"
                                            fill="#fff"
                                        ></rect>
                                    </clipPath>
                                    <clipPath
                                        id="gridRectBarMaskoa1tixt6"
                                    >
                                        <rect
                                            id="SvgjsRect8068"
                                            width="334"
                                            height="99"
                                            x="-2"
                                            y="-2"
                                            rx="0"
                                            ry="0"
                                            opacity="1"
                                            stroke-width="0"
                                            stroke="none"
                                            stroke-dasharray="0"
                                            fill="#fff"
                                        ></rect>
                                    </clipPath>
                                    <clipPath
                                        id="gridRectMarkerMaskoa1tixt6"
                                    >
                                        <rect
                                            id="SvgjsRect8069"
                                            width="330"
                                            height="95"
                                            x="0"
                                            y="0"
                                            rx="0"
                                            ry="0"
                                            opacity="1"
                                            stroke-width="0"
                                            stroke="none"
                                            stroke-dasharray="0"
                                            fill="#fff"
                                        ></rect>
                                    </clipPath>
                                    <clipPath
                                        id="forecastMaskoa1tixt6"
                                    ></clipPath>
                                    <clipPath
                                        id="nonForecastMaskoa1tixt6"
                                    ></clipPath>
                                </defs>
                                <rect
                                    id="SvgjsRect8066"
                                    width="11.785714285714286"
                                    height="95"
                                    x="0"
                                    y="0"
                                    rx="0"
                                    ry="0"
                                    opacity="1"
                                    stroke-width="0"
                                    stroke-dasharray="3"
                                    fill="url(#SvgjsLinearGradient8062)"
                                    class="apexcharts-xcrosshairs"
                                    y2="95"
                                    filter="none"
                                    fill-opacity="0.9"
                                ></rect>
                                <g
                                    id="SvgjsG8098"
                                    class="apexcharts-grid"
                                >
                                    <g
                                        id="SvgjsG8099"
                                        class="apexcharts-gridlines-horizontal"
                                        style="display: none"
                                    >
                                        <line
                                            id="SvgjsLine8102"
                                            x1="0"
                                            y1="0"
                                            x2="330"
                                            y2="0"
                                            stroke="#e0e0e0"
                                            stroke-dasharray="0"
                                            stroke-linecap="butt"
                                            class="apexcharts-gridline"
                                        ></line>
                                        <line
                                            id="SvgjsLine8103"
                                            x1="0"
                                            y1="47.5"
                                            x2="330"
                                            y2="47.5"
                                            stroke="#e0e0e0"
                                            stroke-dasharray="0"
                                            stroke-linecap="butt"
                                            class="apexcharts-gridline"
                                        ></line>
                                        <line
                                            id="SvgjsLine8104"
                                            x1="0"
                                            y1="95"
                                            x2="330"
                                            y2="95"
                                            stroke="#e0e0e0"
                                            stroke-dasharray="0"
                                            stroke-linecap="butt"
                                            class="apexcharts-gridline"
                                        ></line>
                                    </g>
                                    <g
                                        id="SvgjsG8100"
                                        class="apexcharts-gridlines-vertical"
                                        style="display: none"
                                    ></g>
                                    <line
                                        id="SvgjsLine8106"
                                        x1="0"
                                        y1="95"
                                        x2="330"
                                        y2="95"
                                        stroke="transparent"
                                        stroke-dasharray="0"
                                        stroke-linecap="butt"
                                    ></line>
                                    <line
                                        id="SvgjsLine8105"
                                        x1="0"
                                        y1="1"
                                        x2="0"
                                        y2="95"
                                        stroke="transparent"
                                        stroke-dasharray="0"
                                        stroke-linecap="butt"
                                    ></line>
                                </g>
                                <g
                                    id="SvgjsG8101"
                                    class="apexcharts-grid-borders"
                                    style="display: none"
                                ></g>
                                <g
                                    id="SvgjsG8072"
                                    class="apexcharts-bar-series apexcharts-plot-series"
                                >
                                    <g
                                        id="SvgjsG8073"
                                        class="apexcharts-series"
                                        rel="1"
                                        seriesName="Users"
                                        data:realIndex="0"
                                    >
                                        <rect
                                            id="SvgjsRect8077"
                                            width="11.785714285714286"
                                            height="95"
                                            x="17.67857142857143"
                                            y="0"
                                            rx="3"
                                            ry="3"
                                            opacity="1"
                                            stroke-width="0"
                                            stroke="none"
                                            stroke-dasharray="0"
                                            fill="#374151"
                                            class="apexcharts-backgroundBar"
                                        ></rect>
                                        <path
                                            id="SvgjsPath8079"
                                            d="M 17.67857142857143 92.001 L 17.67857142857143 66.3185 C 17.67857142857143 64.8185 19.17857142857143 63.3185 20.67857142857143 63.3185 L 26.464285714285715 63.3185 C 27.964285714285715 63.3185 29.464285714285715 64.8185 29.464285714285715 66.3185 L 29.464285714285715 92.001 C 29.464285714285715 93.501 27.964285714285715 95.001 26.464285714285715 95.001 L 20.67857142857143 95.001 C 19.17857142857143 95.001 17.67857142857143 93.501 17.67857142857143 92.001 Z "
                                            fill="rgba(26,86,219,1)"
                                            fill-opacity="1"
                                            stroke-opacity="1"
                                            stroke-linecap="round"
                                            stroke-width="0"
                                            stroke-dasharray="0"
                                            class="apexcharts-bar-area undefined"
                                            index="0"
                                            clip-path="url(#gridRectBarMaskoa1tixt6)"
                                            pathTo="M 17.67857142857143 92.001 L 17.67857142857143 66.3185 C 17.67857142857143 64.8185 19.17857142857143 63.3185 20.67857142857143 63.3185 L 26.464285714285715 63.3185 C 27.964285714285715 63.3185 29.464285714285715 64.8185 29.464285714285715 66.3185 L 29.464285714285715 92.001 C 29.464285714285715 93.501 27.964285714285715 95.001 26.464285714285715 95.001 L 20.67857142857143 95.001 C 19.17857142857143 95.001 17.67857142857143 93.501 17.67857142857143 92.001 Z "
                                            pathFrom="M 11.571428571428571 75.001 L 11.571428571428571 54.988 C 11.571428571428571 53.488 13.071428571428571 51.988 14.571428571428571 51.988 L 16.285714285714285 51.988 C 17.785714285714285 51.988 19.285714285714285 53.488 19.285714285714285 54.988 L 19.285714285714285 75.001 C 19.285714285714285 76.501 17.785714285714285 78.001 16.285714285714285 78.001 L 14.571428571428571 78.001 C 13.071428571428571 78.001 11.571428571428571 76.501 11.571428571428571 75.001 Z  L 17.67857142857143 95.001 L 29.464285714285715 95.001 L 29.464285714285715 95.001 L 29.464285714285715 95.001 L 29.464285714285715 95.001 L 29.464285714285715 95.001 L 17.67857142857143 95.001 Z"
                                            cy="63.3175"
                                            cx="64.82142857142858"
                                            j="0"
                                            val="1334"
                                            barHeight="31.682499999999997"
                                            barWidth="11.785714285714286"
                                        ></path>
                                        <rect
                                            id="SvgjsRect8080"
                                            width="11.785714285714286"
                                            height="95"
                                            x="64.82142857142858"
                                            y="0"
                                            rx="3"
                                            ry="3"
                                            opacity="1"
                                            stroke-width="0"
                                            stroke="none"
                                            stroke-dasharray="0"
                                            fill="#374151"
                                            class="apexcharts-backgroundBar"
                                        ></rect>
                                        <path
                                            id="SvgjsPath8082"
                                            d="M 64.82142857142858 92.001 L 64.82142857142858 40.16975 C 64.82142857142858 38.66975 66.32142857142858 37.16975 67.82142857142858 37.16975 L 73.60714285714288 37.16975 C 75.10714285714288 37.16975 76.60714285714288 38.66975 76.60714285714288 40.16975 L 76.60714285714288 92.001 C 76.60714285714288 93.501 75.10714285714288 95.001 73.60714285714288 95.001 L 67.82142857142858 95.001 C 66.32142857142858 95.001 64.82142857142858 93.501 64.82142857142858 92.001 Z "
                                            fill="rgba(26,86,219,1)"
                                            fill-opacity="1"
                                            stroke-opacity="1"
                                            stroke-linecap="round"
                                            stroke-width="0"
                                            stroke-dasharray="0"
                                            class="apexcharts-bar-area undefined"
                                            index="0"
                                            clip-path="url(#gridRectBarMaskoa1tixt6)"
                                            pathTo="M 64.82142857142858 92.001 L 64.82142857142858 40.16975 C 64.82142857142858 38.66975 66.32142857142858 37.16975 67.82142857142858 37.16975 L 73.60714285714288 37.16975 C 75.10714285714288 37.16975 76.60714285714288 38.66975 76.60714285714288 40.16975 L 76.60714285714288 92.001 C 76.60714285714288 93.501 75.10714285714288 95.001 73.60714285714288 95.001 L 67.82142857142858 95.001 C 66.32142857142858 95.001 64.82142857142858 93.501 64.82142857142858 92.001 Z "
                                            pathFrom="M 42.42857142857143 75.001 L 42.42857142857143 33.5185 C 42.42857142857143 32.0185 43.92857142857143 30.518500000000007 45.42857142857143 30.518500000000007 L 47.142857142857146 30.518500000000007 C 48.642857142857146 30.518500000000007 50.142857142857146 32.0185 50.142857142857146 33.5185 L 50.142857142857146 75.001 C 50.142857142857146 76.501 48.642857142857146 78.001 47.142857142857146 78.001 L 45.42857142857143 78.001 C 43.92857142857143 78.001 42.42857142857143 76.501 42.42857142857143 75.001 Z  L 64.82142857142858 95.001 L 76.60714285714288 95.001 L 76.60714285714288 95.001 L 76.60714285714288 95.001 L 76.60714285714288 95.001 L 76.60714285714288 95.001 L 64.82142857142858 95.001 Z"
                                            cy="37.16875"
                                            cx="111.96428571428572"
                                            j="1"
                                            val="2435"
                                            barHeight="57.83125"
                                            barWidth="11.785714285714286"
                                        ></path>
                                        <rect
                                            id="SvgjsRect8083"
                                            width="11.785714285714286"
                                            height="95"
                                            x="111.96428571428572"
                                            y="0"
                                            rx="3"
                                            ry="3"
                                            opacity="1"
                                            stroke-width="0"
                                            stroke="none"
                                            stroke-dasharray="0"
                                            fill="#374151"
                                            class="apexcharts-backgroundBar"
                                        ></rect>
                                        <path
                                            id="SvgjsPath8085"
                                            d="M 111.96428571428572 92.001 L 111.96428571428572 56.36725 C 111.96428571428572 54.86725 113.46428571428572 53.36725 114.96428571428572 53.36725 L 120.75000000000001 53.36725 C 122.25000000000001 53.36725 123.75000000000001 54.86725 123.75000000000001 56.36725 L 123.75000000000001 92.001 C 123.75000000000001 93.501 122.25000000000001 95.001 120.75000000000001 95.001 L 114.96428571428572 95.001 C 113.46428571428572 95.001 111.96428571428572 93.501 111.96428571428572 92.001 Z "
                                            fill="rgba(26,86,219,1)"
                                            fill-opacity="1"
                                            stroke-opacity="1"
                                            stroke-linecap="round"
                                            stroke-width="0"
                                            stroke-dasharray="0"
                                            class="apexcharts-bar-area undefined"
                                            index="0"
                                            clip-path="url(#gridRectBarMaskoa1tixt6)"
                                            pathTo="M 111.96428571428572 92.001 L 111.96428571428572 56.36725 C 111.96428571428572 54.86725 113.46428571428572 53.36725 114.96428571428572 53.36725 L 120.75000000000001 53.36725 C 122.25000000000001 53.36725 123.75000000000001 54.86725 123.75000000000001 56.36725 L 123.75000000000001 92.001 C 123.75000000000001 93.501 122.25000000000001 95.001 120.75000000000001 95.001 L 114.96428571428572 95.001 C 113.46428571428572 95.001 111.96428571428572 93.501 111.96428571428572 92.001 Z "
                                            pathFrom="M 73.28571428571429 75.001 L 73.28571428571429 46.8175 C 73.28571428571429 45.3175 74.78571428571429 43.8175 76.28571428571429 43.8175 L 78 43.8175 C 79.5 43.8175 81 45.3175 81 46.8175 L 81 75.001 C 81 76.501 79.5 78.001 78 78.001 L 76.28571428571429 78.001 C 74.78571428571429 78.001 73.28571428571429 76.501 73.28571428571429 75.001 Z  L 111.96428571428572 95.001 L 123.75000000000001 95.001 L 123.75000000000001 95.001 L 123.75000000000001 95.001 L 123.75000000000001 95.001 L 123.75000000000001 95.001 L 111.96428571428572 95.001 Z"
                                            cy="53.36625"
                                            cx="159.10714285714286"
                                            j="2"
                                            val="1753"
                                            barHeight="41.63375"
                                            barWidth="11.785714285714286"
                                        ></path>
                                        <rect
                                            id="SvgjsRect8086"
                                            width="11.785714285714286"
                                            height="95"
                                            x="159.10714285714286"
                                            y="0"
                                            rx="3"
                                            ry="3"
                                            opacity="1"
                                            stroke-width="0"
                                            stroke="none"
                                            stroke-dasharray="0"
                                            fill="#374151"
                                            class="apexcharts-backgroundBar"
                                        ></rect>
                                        <path
                                            id="SvgjsPath8088"
                                            d="M 159.10714285714286 92.001 L 159.10714285714286 66.461 C 159.10714285714286 64.961 160.60714285714286 63.461 162.10714285714286 63.461 L 167.89285714285714 63.461 C 169.39285714285714 63.461 170.89285714285714 64.961 170.89285714285714 66.461 L 170.89285714285714 92.001 C 170.89285714285714 93.501 169.39285714285714 95.001 167.89285714285714 95.001 L 162.10714285714286 95.001 C 160.60714285714286 95.001 159.10714285714286 93.501 159.10714285714286 92.001 Z "
                                            fill="rgba(26,86,219,1)"
                                            fill-opacity="1"
                                            stroke-opacity="1"
                                            stroke-linecap="round"
                                            stroke-width="0"
                                            stroke-dasharray="0"
                                            class="apexcharts-bar-area undefined"
                                            index="0"
                                            clip-path="url(#gridRectBarMaskoa1tixt6)"
                                            pathTo="M 159.10714285714286 92.001 L 159.10714285714286 66.461 C 159.10714285714286 64.961 160.60714285714286 63.461 162.10714285714286 63.461 L 167.89285714285714 63.461 C 169.39285714285714 63.461 170.89285714285714 64.961 170.89285714285714 66.461 L 170.89285714285714 92.001 C 170.89285714285714 93.501 169.39285714285714 95.001 167.89285714285714 95.001 L 162.10714285714286 95.001 C 160.60714285714286 95.001 159.10714285714286 93.501 159.10714285714286 92.001 Z "
                                            pathFrom="M 104.14285714285715 75.001 L 104.14285714285715 55.105 C 104.14285714285715 53.605 105.64285714285715 52.105 107.14285714285715 52.105 L 108.85714285714286 52.105 C 110.35714285714286 52.105 111.85714285714286 53.605 111.85714285714286 55.105 L 111.85714285714286 75.001 C 111.85714285714286 76.501 110.35714285714286 78.001 108.85714285714286 78.001 L 107.14285714285715 78.001 C 105.64285714285715 78.001 104.14285714285715 76.501 104.14285714285715 75.001 Z  L 159.10714285714286 95.001 L 170.89285714285714 95.001 L 170.89285714285714 95.001 L 170.89285714285714 95.001 L 170.89285714285714 95.001 L 170.89285714285714 95.001 L 159.10714285714286 95.001 Z"
                                            cy="63.46"
                                            cx="206.25"
                                            j="3"
                                            val="1328"
                                            barHeight="31.54"
                                            barWidth="11.785714285714286"
                                        ></path>
                                        <rect
                                            id="SvgjsRect8089"
                                            width="11.785714285714286"
                                            height="95"
                                            x="206.25"
                                            y="0"
                                            rx="3"
                                            ry="3"
                                            opacity="1"
                                            stroke-width="0"
                                            stroke="none"
                                            stroke-dasharray="0"
                                            fill="#374151"
                                            class="apexcharts-backgroundBar"
                                        ></rect>
                                        <path
                                            id="SvgjsPath8091"
                                            d="M 206.25 92.001 L 206.25 70.56975 C 206.25 69.06975 207.75 67.56975 209.25 67.56975 L 215.03571428571428 67.56975 C 216.53571428571428 67.56975 218.03571428571428 69.06975 218.03571428571428 70.56975 L 218.03571428571428 92.001 C 218.03571428571428 93.501 216.53571428571428 95.001 215.03571428571428 95.001 L 209.25 95.001 C 207.75 95.001 206.25 93.501 206.25 92.001 Z "
                                            fill="rgba(26,86,219,1)"
                                            fill-opacity="1"
                                            stroke-opacity="1"
                                            stroke-linecap="round"
                                            stroke-width="0"
                                            stroke-dasharray="0"
                                            class="apexcharts-bar-area undefined"
                                            index="0"
                                            clip-path="url(#gridRectBarMaskoa1tixt6)"
                                            pathTo="M 206.25 92.001 L 206.25 70.56975 C 206.25 69.06975 207.75 67.56975 209.25 67.56975 L 215.03571428571428 67.56975 C 216.53571428571428 67.56975 218.03571428571428 69.06975 218.03571428571428 70.56975 L 218.03571428571428 92.001 C 218.03571428571428 93.501 216.53571428571428 95.001 215.03571428571428 95.001 L 209.25 95.001 C 207.75 95.001 206.25 93.501 206.25 92.001 Z "
                                            pathFrom="M 135 75.001 L 135 58.478500000000004 C 135 56.978500000000004 136.5 55.478500000000004 138 55.478500000000004 L 139.71428571428572 55.478500000000004 C 141.21428571428572 55.478500000000004 142.71428571428572 56.978500000000004 142.71428571428572 58.478500000000004 L 142.71428571428572 75.001 C 142.71428571428572 76.501 141.21428571428572 78.001 139.71428571428572 78.001 L 138 78.001 C 136.5 78.001 135 76.501 135 75.001 Z  L 206.25 95.001 L 218.03571428571428 95.001 L 218.03571428571428 95.001 L 218.03571428571428 95.001 L 218.03571428571428 95.001 L 218.03571428571428 95.001 L 206.25 95.001 Z"
                                            cy="67.56875"
                                            cx="253.39285714285714"
                                            j="4"
                                            val="1155"
                                            barHeight="27.43125"
                                            barWidth="11.785714285714286"
                                        ></path>
                                        <rect
                                            id="SvgjsRect8092"
                                            width="11.785714285714286"
                                            height="95"
                                            x="253.39285714285714"
                                            y="0"
                                            rx="3"
                                            ry="3"
                                            opacity="1"
                                            stroke-width="0"
                                            stroke="none"
                                            stroke-dasharray="0"
                                            fill="#374151"
                                            class="apexcharts-backgroundBar"
                                        ></rect>
                                        <path
                                            id="SvgjsPath8094"
                                            d="M 253.39285714285714 92.001 L 253.39285714285714 59.241 C 253.39285714285714 57.741 254.89285714285717 56.241 256.39285714285717 56.241 L 262.17857142857144 56.241 C 263.67857142857144 56.241 265.17857142857144 57.741 265.17857142857144 59.241 L 265.17857142857144 92.001 C 265.17857142857144 93.501 263.67857142857144 95.001 262.17857142857144 95.001 L 256.3928571428571 95.001 C 254.8928571428571 95.001 253.39285714285714 93.501 253.39285714285714 92.001 Z "
                                            fill="rgba(26,86,219,1)"
                                            fill-opacity="1"
                                            stroke-opacity="1"
                                            stroke-linecap="round"
                                            stroke-width="0"
                                            stroke-dasharray="0"
                                            class="apexcharts-bar-area undefined"
                                            index="0"
                                            clip-path="url(#gridRectBarMaskoa1tixt6)"
                                            pathTo="M 253.39285714285714 92.001 L 253.39285714285714 59.241 C 253.39285714285714 57.741 254.89285714285717 56.241 256.39285714285717 56.241 L 262.17857142857144 56.241 C 263.67857142857144 56.241 265.17857142857144 57.741 265.17857142857144 59.241 L 265.17857142857144 92.001 C 265.17857142857144 93.501 263.67857142857144 95.001 262.17857142857144 95.001 L 256.3928571428571 95.001 C 254.8928571428571 95.001 253.39285714285714 93.501 253.39285714285714 92.001 Z "
                                            pathFrom="M 165.85714285714286 75.001 L 165.85714285714286 49.177 C 165.85714285714286 47.677 167.35714285714286 46.177 168.85714285714286 46.177 L 170.57142857142858 46.177 C 172.07142857142858 46.177 173.57142857142858 47.677 173.57142857142858 49.177 L 173.57142857142858 75.001 C 173.57142857142858 76.501 172.07142857142858 78.001 170.57142857142858 78.001 L 168.85714285714286 78.001 C 167.35714285714286 78.001 165.85714285714286 76.501 165.85714285714286 75.001 Z  L 253.39285714285714 95.001 L 265.17857142857144 95.001 L 265.17857142857144 95.001 L 265.17857142857144 95.001 L 265.17857142857144 95.001 L 265.17857142857144 95.001 L 253.39285714285714 95.001 Z"
                                            cy="56.24"
                                            cx="300.5357142857143"
                                            j="5"
                                            val="1632"
                                            barHeight="38.76"
                                            barWidth="11.785714285714286"
                                        ></path>
                                        <rect
                                            id="SvgjsRect8095"
                                            width="11.785714285714286"
                                            height="95"
                                            x="300.5357142857143"
                                            y="0"
                                            rx="3"
                                            ry="3"
                                            opacity="1"
                                            stroke-width="0"
                                            stroke="none"
                                            stroke-dasharray="0"
                                            fill="#374151"
                                            class="apexcharts-backgroundBar"
                                        ></rect>
                                        <path
                                            id="SvgjsPath8097"
                                            d="M 300.5357142857143 92.001 L 300.5357142857143 66.271 C 300.5357142857143 64.771 302.0357142857143 63.271 303.5357142857143 63.271 L 309.32142857142856 63.271 C 310.82142857142856 63.271 312.32142857142856 64.771 312.32142857142856 66.271 L 312.32142857142856 92.001 C 312.32142857142856 93.501 310.82142857142856 95.001 309.32142857142856 95.001 L 303.5357142857143 95.001 C 302.0357142857143 95.001 300.5357142857143 93.501 300.5357142857143 92.001 Z "
                                            fill="rgba(26,86,219,1)"
                                            fill-opacity="1"
                                            stroke-opacity="1"
                                            stroke-linecap="round"
                                            stroke-width="0"
                                            stroke-dasharray="0"
                                            class="apexcharts-bar-area undefined"
                                            index="0"
                                            clip-path="url(#gridRectBarMaskoa1tixt6)"
                                            pathTo="M 300.5357142857143 92.001 L 300.5357142857143 66.271 C 300.5357142857143 64.771 302.0357142857143 63.271 303.5357142857143 63.271 L 309.32142857142856 63.271 C 310.82142857142856 63.271 312.32142857142856 64.771 312.32142857142856 66.271 L 312.32142857142856 92.001 C 312.32142857142856 93.501 310.82142857142856 95.001 309.32142857142856 95.001 L 303.5357142857143 95.001 C 302.0357142857143 95.001 300.5357142857143 93.501 300.5357142857143 92.001 Z "
                                            pathFrom="M 196.71428571428572 75.001 L 196.71428571428572 54.949 C 196.71428571428572 53.449 198.21428571428572 51.949 199.71428571428572 51.949 L 201.42857142857144 51.949 C 202.92857142857144 51.949 204.42857142857144 53.449 204.42857142857144 54.949 L 204.42857142857144 75.001 C 204.42857142857144 76.501 202.92857142857144 78.001 201.42857142857144 78.001 L 199.71428571428572 78.001 C 198.21428571428572 78.001 196.71428571428572 76.501 196.71428571428572 75.001 Z  L 300.5357142857143 95.001 L 312.32142857142856 95.001 L 312.32142857142856 95.001 L 312.32142857142856 95.001 L 312.32142857142856 95.001 L 312.32142857142856 95.001 L 300.5357142857143 95.001 Z"
                                            cy="63.27"
                                            cx="347.67857142857144"
                                            j="6"
                                            val="1336"
                                            barHeight="31.729999999999997"
                                            barWidth="11.785714285714286"
                                        ></path>
                                        <g
                                            id="SvgjsG8075"
                                            class="apexcharts-bar-goals-markers"
                                        >
                                            <g
                                                id="SvgjsG8078"
                                                className="apexcharts-bar-goals-groups"
                                                class="apexcharts-hidden-element-shown"
                                                clip-path="url(#gridRectMarkerMaskoa1tixt6)"
                                            ></g>
                                            <g
                                                id="SvgjsG8081"
                                                className="apexcharts-bar-goals-groups"
                                                class="apexcharts-hidden-element-shown"
                                                clip-path="url(#gridRectMarkerMaskoa1tixt6)"
                                            ></g>
                                            <g
                                                id="SvgjsG8084"
                                                className="apexcharts-bar-goals-groups"
                                                class="apexcharts-hidden-element-shown"
                                                clip-path="url(#gridRectMarkerMaskoa1tixt6)"
                                            ></g>
                                            <g
                                                id="SvgjsG8087"
                                                className="apexcharts-bar-goals-groups"
                                                class="apexcharts-hidden-element-shown"
                                                clip-path="url(#gridRectMarkerMaskoa1tixt6)"
                                            ></g>
                                            <g
                                                id="SvgjsG8090"
                                                className="apexcharts-bar-goals-groups"
                                                class="apexcharts-hidden-element-shown"
                                                clip-path="url(#gridRectMarkerMaskoa1tixt6)"
                                            ></g>
                                            <g
                                                id="SvgjsG8093"
                                                className="apexcharts-bar-goals-groups"
                                                class="apexcharts-hidden-element-shown"
                                                clip-path="url(#gridRectMarkerMaskoa1tixt6)"
                                            ></g>
                                            <g
                                                id="SvgjsG8096"
                                                className="apexcharts-bar-goals-groups"
                                                class="apexcharts-hidden-element-shown"
                                                clip-path="url(#gridRectMarkerMaskoa1tixt6)"
                                            ></g>
                                        </g>
                                        <g
                                            id="SvgjsG8076"
                                            class="apexcharts-bar-shadows apexcharts-hidden-element-shown"
                                        ></g>
                                    </g>
                                    <g
                                        id="SvgjsG8074"
                                        class="apexcharts-datalabels apexcharts-hidden-element-shown"
                                        data:realIndex="0"
                                    ></g>
                                </g>
                                <line
                                    id="SvgjsLine8107"
                                    x1="0"
                                    y1="0"
                                    x2="330"
                                    y2="0"
                                    stroke="#b6b6b6"
                                    stroke-dasharray="0"
                                    stroke-width="1"
                                    stroke-linecap="butt"
                                    class="apexcharts-ycrosshairs"
                                ></line>
                                <line
                                    id="SvgjsLine8108"
                                    x1="0"
                                    y1="0"
                                    x2="330"
                                    y2="0"
                                    stroke-dasharray="0"
                                    stroke-width="0"
                                    stroke-linecap="butt"
                                    class="apexcharts-ycrosshairs-hidden"
                                ></line>
                                <g
                                    id="SvgjsG8109"
                                    class="apexcharts-xaxis"
                                    transform="translate(0, 0)"
                                >
                                    <g
                                        id="SvgjsG8110"
                                        class="apexcharts-xaxis-texts-g"
                                        transform="translate(0, -4)"
                                    ></g>
                                </g>
                                <g
                                    id="SvgjsG8119"
                                    class="apexcharts-yaxis-annotations"
                                ></g>
                                <g
                                    id="SvgjsG8120"
                                    class="apexcharts-xaxis-annotations"
                                ></g>
                                <g
                                    id="SvgjsG8121"
                                    class="apexcharts-point-annotations"
                                ></g>
                            </g>
                        </svg>
                        <div
                            class="apexcharts-tooltip apexcharts-theme-light"
                            bis_skin_checked="1"
                        >
                            <div
                                class="apexcharts-tooltip-title"
                                bis_skin_checked="1"
                                style="
                                    font-family: Inter,
                                        sans-serif;
                                    font-size: 14px;
                                "
                            ></div>
                            <div
                                class="apexcharts-tooltip-series-group apexcharts-tooltip-series-group-0"
                                bis_skin_checked="1"
                                style="order: 1"
                            >
                                <span
                                    class="apexcharts-tooltip-marker"
                                    style="
                                        background-color: rgb(
                                            26,
                                            86,
                                            219
                                        );
                                    "
                                ></span>
                                <div
                                    class="apexcharts-tooltip-text"
                                    bis_skin_checked="1"
                                    style="
                                        font-family: Inter,
                                            sans-serif;
                                        font-size: 14px;
                                    "
                                >
                                    <div
                                        class="apexcharts-tooltip-y-group"
                                        bis_skin_checked="1"
                                    >
                                        <span
                                            class="apexcharts-tooltip-text-y-label"
                                        ></span
                                        ><span
                                            class="apexcharts-tooltip-text-y-value"
                                        ></span>
                                    </div>
                                    <div
                                        class="apexcharts-tooltip-goals-group"
                                        bis_skin_checked="1"
                                    >
                                        <span
                                            class="apexcharts-tooltip-text-goals-label"
                                        ></span
                                        ><span
                                            class="apexcharts-tooltip-text-goals-value"
                                        ></span>
                                    </div>
                                    <div
                                        class="apexcharts-tooltip-z-group"
                                        bis_skin_checked="1"
                                    >
                                        <span
                                            class="apexcharts-tooltip-text-z-label"
                                        ></span
                                        ><span
                                            class="apexcharts-tooltip-text-z-value"
                                        ></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div
                            class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-light"
                            bis_skin_checked="1"
                        >
                            <div
                                class="apexcharts-yaxistooltip-text"
                                bis_skin_checked="1"
                            ></div>
                        </div>
                    </div>
                </div>
            </div>
            <div
                class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800"
                bis_skin_checked="1"
            >
                <div class="w-full" bis_skin_checked="1">
                    <h3
                        class="mb-2 text-base font-normal text-gray-500 dark:text-gray-400"
                    >
                        Audience by age
                    </h3>
                    <div
                        class="flex items-center mb-2"
                        bis_skin_checked="1"
                    >
                        <div
                            class="w-16 text-sm font-medium dark:text-white"
                            bis_skin_checked="1"
                        >
                            50+
                        </div>
                        <div
                            class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700"
                            bis_skin_checked="1"
                        >
                            <div
                                class="bg-primary-600 h-2.5 rounded-full dark:bg-primary-500"
                                style="width: 18%"
                                bis_skin_checked="1"
                            ></div>
                        </div>
                    </div>
                    <div
                        class="flex items-center mb-2"
                        bis_skin_checked="1"
                    >
                        <div
                            class="w-16 text-sm font-medium dark:text-white"
                            bis_skin_checked="1"
                        >
                            40+
                        </div>
                        <div
                            class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700"
                            bis_skin_checked="1"
                        >
                            <div
                                class="bg-primary-600 h-2.5 rounded-full dark:bg-primary-500"
                                style="width: 15%"
                                bis_skin_checked="1"
                            ></div>
                        </div>
                    </div>
                    <div
                        class="flex items-center mb-2"
                        bis_skin_checked="1"
                    >
                        <div
                            class="w-16 text-sm font-medium dark:text-white"
                            bis_skin_checked="1"
                        >
                            30+
                        </div>
                        <div
                            class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700"
                            bis_skin_checked="1"
                        >
                            <div
                                class="bg-primary-600 h-2.5 rounded-full dark:bg-primary-500"
                                style="width: 60%"
                                bis_skin_checked="1"
                            ></div>
                        </div>
                    </div>
                    <div
                        class="flex items-center mb-2"
                        bis_skin_checked="1"
                    >
                        <div
                            class="w-16 text-sm font-medium dark:text-white"
                            bis_skin_checked="1"
                        >
                            20+
                        </div>
                        <div
                            class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700"
                            bis_skin_checked="1"
                        >
                            <div
                                class="bg-primary-600 h-2.5 rounded-full dark:bg-primary-500"
                                style="width: 30%"
                                bis_skin_checked="1"
                            ></div>
                        </div>
                    </div>
                </div>
                <div
                    id="traffic-channels-chart"
                    class="w-full"
                    bis_skin_checked="1"
                ></div>
            </div>
        </div>

        <div
            class="p-4 bg-white border mt-4 border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800"
            bis_skin_checked="1"
        >
            <!-- Card header -->
            <div
                class="items-center justify-between lg:flex"
                bis_skin_checked="1"
            >
                <div class="mb-4 lg:mb-0" bis_skin_checked="1">
                    <h3
                        class="mb-2 text-xl font-bold text-gray-900 dark:text-white"
                    >
                        Transactions
                    </h3>
                    <span
                        class="text-base font-normal text-gray-500 dark:text-gray-400"
                        >This is a list of latest
                        transactions</span
                    >
                </div>
                <div
                    class="items-center sm:flex"
                    bis_skin_checked="1"
                >
                    <div
                        class="flex items-center"
                        bis_skin_checked="1"
                    >
                        <button
                            id="dropdownDefault"
                            data-dropdown-toggle="dropdown"
                            class="mb-4 sm:mb-0 mr-4 inline-flex items-center text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-4 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                            type="button"
                        >
                            Filter by status
                            <svg
                                class="w-4 h-4 ml-2"
                                aria-hidden="true"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M19 9l-7 7-7-7"
                                ></path>
                            </svg>
                        </button>
                        <!-- Dropdown menu -->
                        <div
                            id="dropdown"
                            class="z-10 hidden w-56 p-3 bg-white rounded-lg shadow dark:bg-gray-700"
                            data-popper-placement="top"
                            bis_skin_checked="1"
                            style="
                                position: absolute;
                                inset: auto auto 0px 0px;
                                margin: 0px;
                                transform: translate(
                                    111px,
                                    1148px
                                );
                            "
                            data-popper-reference-hidden=""
                            data-popper-escaped=""
                        >
                            <h6
                                class="mb-3 text-sm font-medium text-gray-900 dark:text-white"
                            >
                                Category
                            </h6>
                            <ul
                                class="space-y-2 text-sm"
                                aria-labelledby="dropdownDefault"
                            >
                                <li class="flex items-center">
                                    <input
                                        id="apple"
                                        type="checkbox"
                                        value=""
                                        class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500"
                                    />

                                    <label
                                        for="apple"
                                        class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100"
                                    >
                                        Completed (56)
                                    </label>
                                </li>

                                <li class="flex items-center">
                                    <input
                                        id="fitbit"
                                        type="checkbox"
                                        value=""
                                        checked=""
                                        class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500"
                                    />

                                    <label
                                        for="fitbit"
                                        class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100"
                                    >
                                        Cancelled (56)
                                    </label>
                                </li>

                                <li class="flex items-center">
                                    <input
                                        id="dell"
                                        type="checkbox"
                                        value=""
                                        class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500"
                                    />

                                    <label
                                        for="dell"
                                        class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100"
                                    >
                                        In progress (56)
                                    </label>
                                </li>

                                <li class="flex items-center">
                                    <input
                                        id="asus"
                                        type="checkbox"
                                        value=""
                                        checked=""
                                        class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500"
                                    />

                                    <label
                                        for="asus"
                                        class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100"
                                    >
                                        In review (97)
                                    </label>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div
                        date-rangepicker=""
                        class="flex items-center space-x-4"
                        bis_skin_checked="1"
                    >
                        <div
                            class="relative"
                            bis_skin_checked="1"
                        >
                            <div
                                class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none"
                                bis_skin_checked="1"
                            >
                                <svg
                                    class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true"
                                >
                                    <path
                                        d="M5.25 12a.75.75 0 01.75-.75h.01a.75.75 0 01.75.75v.01a.75.75 0 01-.75.75H6a.75.75 0 01-.75-.75V12zM6 13.25a.75.75 0 00-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 00.75-.75V14a.75.75 0 00-.75-.75H6zM7.25 12a.75.75 0 01.75-.75h.01a.75.75 0 01.75.75v.01a.75.75 0 01-.75.75H8a.75.75 0 01-.75-.75V12zM8 13.25a.75.75 0 00-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 00.75-.75V14a.75.75 0 00-.75-.75H8zM9.25 10a.75.75 0 01.75-.75h.01a.75.75 0 01.75.75v.01a.75.75 0 01-.75.75H10a.75.75 0 01-.75-.75V10zM10 11.25a.75.75 0 00-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 00.75-.75V12a.75.75 0 00-.75-.75H10zM9.25 14a.75.75 0 01.75-.75h.01a.75.75 0 01.75.75v.01a.75.75 0 01-.75.75H10a.75.75 0 01-.75-.75V14zM12 9.25a.75.75 0 00-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 00.75-.75V10a.75.75 0 00-.75-.75H12zM11.25 12a.75.75 0 01.75-.75h.01a.75.75 0 01.75.75v.01a.75.75 0 01-.75.75H12a.75.75 0 01-.75-.75V12zM12 13.25a.75.75 0 00-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 00.75-.75V14a.75.75 0 00-.75-.75H12zM13.25 10a.75.75 0 01.75-.75h.01a.75.75 0 01.75.75v.01a.75.75 0 01-.75.75H14a.75.75 0 01-.75-.75V10zM14 11.25a.75.75 0 00-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 00.75-.75V12a.75.75 0 00-.75-.75H14z"
                                    ></path>
                                    <path
                                        clip-rule="evenodd"
                                        fill-rule="evenodd"
                                        d="M5.75 2a.75.75 0 01.75.75V4h7V2.75a.75.75 0 011.5 0V4h.25A2.75 2.75 0 0118 6.75v8.5A2.75 2.75 0 0115.25 18H4.75A2.75 2.75 0 012 15.25v-8.5A2.75 2.75 0 014.75 4H5V2.75A.75.75 0 015.75 2zm-1 5.5c-.69 0-1.25.56-1.25 1.25v6.5c0 .69.56 1.25 1.25 1.25h10.5c.69 0 1.25-.56 1.25-1.25v-6.5c0-.69-.56-1.25-1.25-1.25H4.75z"
                                    ></path>
                                </svg>
                            </div>
                            <input
                                name="start"
                                type="text"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 datepicker-input"
                                placeholder="From"
                            />
                        </div>
                        <div
                            class="relative"
                            bis_skin_checked="1"
                        >
                            <div
                                class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none"
                                bis_skin_checked="1"
                            >
                                <svg
                                    class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true"
                                >
                                    <path
                                        d="M5.25 12a.75.75 0 01.75-.75h.01a.75.75 0 01.75.75v.01a.75.75 0 01-.75.75H6a.75.75 0 01-.75-.75V12zM6 13.25a.75.75 0 00-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 00.75-.75V14a.75.75 0 00-.75-.75H6zM7.25 12a.75.75 0 01.75-.75h.01a.75.75 0 01.75.75v.01a.75.75 0 01-.75.75H8a.75.75 0 01-.75-.75V12zM8 13.25a.75.75 0 00-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 00.75-.75V14a.75.75 0 00-.75-.75H8zM9.25 10a.75.75 0 01.75-.75h.01a.75.75 0 01.75.75v.01a.75.75 0 01-.75.75H10a.75.75 0 01-.75-.75V10zM10 11.25a.75.75 0 00-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 00.75-.75V12a.75.75 0 00-.75-.75H10zM9.25 14a.75.75 0 01.75-.75h.01a.75.75 0 01.75.75v.01a.75.75 0 01-.75.75H10a.75.75 0 01-.75-.75V14zM12 9.25a.75.75 0 00-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 00.75-.75V10a.75.75 0 00-.75-.75H12zM11.25 12a.75.75 0 01.75-.75h.01a.75.75 0 01.75.75v.01a.75.75 0 01-.75.75H12a.75.75 0 01-.75-.75V12zM12 13.25a.75.75 0 00-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 00.75-.75V14a.75.75 0 00-.75-.75H12zM13.25 10a.75.75 0 01.75-.75h.01a.75.75 0 01.75.75v.01a.75.75 0 01-.75.75H14a.75.75 0 01-.75-.75V10zM14 11.25a.75.75 0 00-.75.75v.01c0 .414.336.75.75.75h.01a.75.75 0 00.75-.75V12a.75.75 0 00-.75-.75H14z"
                                    ></path>
                                    <path
                                        clip-rule="evenodd"
                                        fill-rule="evenodd"
                                        d="M5.75 2a.75.75 0 01.75.75V4h7V2.75a.75.75 0 011.5 0V4h.25A2.75 2.75 0 0118 6.75v8.5A2.75 2.75 0 0115.25 18H4.75A2.75 2.75 0 012 15.25v-8.5A2.75 2.75 0 014.75 4H5V2.75A.75.75 0 015.75 2zm-1 5.5c-.69 0-1.25.56-1.25 1.25v6.5c0 .69.56 1.25 1.25 1.25h10.5c.69 0 1.25-.56 1.25-1.25v-6.5c0-.69-.56-1.25-1.25-1.25H4.75z"
                                    ></path>
                                </svg>
                            </div>
                            <input
                                name="end"
                                type="text"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 datepicker-input"
                                placeholder="To"
                            />
                        </div>
                    </div>
                </div>
            </div>
            <!-- Table -->
            <div
                class="flex flex-col mt-6"
                bis_skin_checked="1"
            >
                <div
                    class="overflow-x-auto rounded-lg"
                    bis_skin_checked="1"
                >
                    <div
                        class="inline-block min-w-full align-middle"
                        bis_skin_checked="1"
                    >
                        <div
                            class="overflow-hidden shadow sm:rounded-lg"
                            bis_skin_checked="1"
                        >
                            <table
                                class="min-w-full divide-y divide-gray-200 dark:divide-gray-600"
                            >
                                <thead
                                    class="bg-gray-50 dark:bg-gray-700"
                                >
                                    <tr>
                                        <th
                                            scope="col"
                                            class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white"
                                        >
                                            Transaction
                                        </th>
                                        <th
                                            scope="col"
                                            class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white"
                                        >
                                            Date &amp; Time
                                        </th>
                                        <th
                                            scope="col"
                                            class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white"
                                        >
                                            Amount
                                        </th>
                                        <th
                                            scope="col"
                                            class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white"
                                        >
                                            Reference number
                                        </th>
                                        <th
                                            scope="col"
                                            class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white"
                                        >
                                            Payment method
                                        </th>
                                        <th
                                            scope="col"
                                            class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white"
                                        >
                                            Status
                                        </th>
                                    </tr>
                                </thead>
                                <tbody
                                    class="bg-white dark:bg-gray-800"
                                >
                                    <tr>
                                        <td
                                            class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white"
                                        >
                                            Payment from
                                            <span
                                                class="font-semibold"
                                                >Bonnie
                                                Green</span
                                            >
                                        </td>
                                        <td
                                            class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400"
                                        >
                                            Apr 23 ,2021
                                        </td>
                                        <td
                                            class="p-4 text-sm font-semibold text-gray-900 whitespace-nowrap dark:text-white"
                                        >
                                            $2300
                                        </td>
                                        <td
                                            class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400"
                                        >
                                            0047568936
                                        </td>
                                        <td
                                            class="inline-flex items-center p-4 space-x-2 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400"
                                        >
                                            <svg
                                                class="w-7 h-7"
                                                aria-hidden="true"
                                                enable-background="new 0 0 780 500"
                                                viewBox="0 0 780 500"
                                                xmlns="http://www.w3.org/2000/svg"
                                            >
                                                <path
                                                    d="m449.01 250c0 99.143-80.371 179.5-179.51 179.5s-179.5-80.361-179.5-179.5c0-99.133 80.362-179.5 179.5-179.5 99.137 0 179.51 80.371 179.51 179.5"
                                                    fill="#d9222a"
                                                ></path>
                                                <path
                                                    d="m510.49 70.496c-46.379 0-88.643 17.596-120.5 46.467-6.49 5.889-12.548 12.237-18.125 18.996h36.267c4.965 6.037 9.536 12.387 13.685 19.012h-63.635c-3.827 6.122-7.281 12.469-10.342 19.008h84.313c2.894 6.185 5.431 12.53 7.601 19.004h-99.513c-2.09 6.234-3.832 12.58-5.217 19.008h109.94c2.689 12.49 4.045 25.231 4.042 38.008 0 19.935-3.254 39.112-9.254 57.021h-99.513c2.164 6.477 4.7 12.824 7.596 19.008h84.316c-3.063 6.541-6.519 12.889-10.347 19.013h-63.625c4.147 6.62 8.719 12.966 13.685 18.996h36.259c-5.57 6.772-11.63 13.127-18.13 19.013 31.857 28.866 74.117 46.454 120.5 46.454 99.139 0 179.51-80.361 179.51-179.5 0-99.129-80.371-179.5-179.51-179.5"
                                                    fill="#ee9f2d"
                                                ></path>
                                                <path
                                                    d="m666.07 350.06c0-3.199 2.592-5.801 5.796-5.801s5.796 2.602 5.796 5.801-2.592 5.801-5.796 5.801-5.796-2.602-5.796-5.801zm5.796 4.408c2.434-.001 4.407-1.974 4.408-4.408 0-2.432-1.971-4.402-4.402-4.404h-.006c-2.429-.003-4.4 1.963-4.404 4.391v.014c-.002 2.433 1.968 4.406 4.4 4.408.001-.001.003-.001.004-.001zm-.783-1.86h-1.187v-5.096h2.149c.45 0 .908 0 1.305.254.413.279.646.771.646 1.279 0 .571-.338 1.104-.884 1.312l.938 2.25h-1.315l-.779-2.017h-.871zm0-2.89h.658c.246 0 .505.021.726-.1.195-.125.296-.359.296-.584-.005-.209-.112-.402-.288-.518-.207-.129-.536-.101-.758-.101h-.634zm-443.5-80.063c-2.046-.238-2.945-.301-4.35-.301-11.046 0-16.638 3.787-16.638 11.268 0 4.611 2.729 7.545 6.987 7.545 7.939 0 13.659-7.559 14.001-18.512zm14.171 32.996h-16.146l.371-7.676c-4.926 6.065-11.496 8.949-20.426 8.949-10.563 0-17.804-8.25-17.804-20.229 0-18.024 12.596-28.541 34.217-28.541 2.208 0 5.042.199 7.941.57.604-2.441.763-3.488.763-4.801 0-4.908-3.396-6.737-12.5-6.737-9.533-.108-17.396 2.271-20.625 3.333.204-1.229 2.7-16.659 2.7-16.659 9.712-2.846 16.116-3.917 23.325-3.917 16.732 0 25.596 7.513 25.579 21.712.033 3.805-.597 8.5-1.579 14.671-1.691 10.734-5.32 33.721-5.816 39.325zm-62.158 0h-19.487l11.162-69.997-24.925 69.997h-13.279l-1.642-69.597-11.733 69.597h-18.242l15.237-91.056h28.021l1.7 50.968 17.092-50.968h31.167zm354.97-32.996c-2.037-.238-2.941-.301-4.342-.301-11.041 0-16.634 3.787-16.634 11.268 0 4.611 2.726 7.545 6.983 7.545 7.94 0 13.664-7.559 13.993-18.512zm14.184 32.996h-16.146l.366-7.676c-4.926 6.065-11.5 8.949-20.422 8.949-10.565 0-17.8-8.25-17.8-20.229 0-18.024 12.588-28.541 34.213-28.541 2.208 0 5.037.199 7.934.57.604-2.441.763-3.488.763-4.801 0-4.908-3.392-6.737-12.496-6.737-9.533-.108-17.387 2.271-20.629 3.333.204-1.229 2.709-16.659 2.709-16.659 9.712-2.846 16.112-3.917 23.313-3.917 16.74 0 25.604 7.513 25.587 21.712.032 3.805-.597 8.5-1.579 14.671-1.684 10.734-5.321 33.721-5.813 39.325zm-220.39-1.125c-5.333 1.679-9.491 2.398-14 2.398-9.962 0-15.399-5.725-15.399-16.267-.142-3.271 1.433-11.88 2.671-19.737 1.125-6.917 8.449-50.529 8.449-50.529h19.371l-2.263 11.208h11.699l-2.642 17.796h-11.742c-2.25 14.083-5.454 31.625-5.491 33.95 0 3.816 2.037 5.483 6.671 5.483 2.221 0 3.94-.227 5.254-.7zm59.392-.6c-6.654 2.034-13.075 3.017-19.879 3-21.684-.021-32.987-11.346-32.987-33.032 0-25.313 14.38-43.947 33.899-43.947 15.971 0 26.171 10.433 26.171 26.796 0 5.429-.7 10.729-2.388 18.212h-38.574c-1.305 10.741 5.57 15.217 16.837 15.217 6.935 0 13.188-1.429 20.142-4.663zm-10.888-43.9c.107-1.543 2.055-13.217-9.013-13.217-6.171 0-10.583 4.704-12.38 13.217zm-123.42-5.017c0 9.367 4.542 15.826 14.842 20.676 7.892 3.709 9.112 4.81 9.112 8.17 0 4.617-3.479 6.701-11.191 6.701-5.813 0-11.221-.908-17.458-2.922 0 0-2.563 16.321-2.68 17.102 4.43.967 8.38 1.861 20.279 2.19 20.563 0 30.059-7.829 30.059-24.75 0-10.175-3.976-16.146-13.737-20.634-8.171-3.75-9.108-4.587-9.108-8.045 0-4.004 3.237-6.046 9.537-6.046 3.825 0 9.05.408 14 1.112l2.775-17.175c-5.046-.8-12.696-1.442-17.15-1.442-21.801.001-29.347 11.388-29.28 25.063m229.09-23.116c5.412 0 10.458 1.421 17.412 4.921l3.188-19.763c-2.854-1.121-12.904-7.7-21.417-7.7-13.041 0-24.065 6.471-31.82 17.15-11.309-3.746-15.958 3.825-21.657 11.367l-5.063 1.179c.383-2.483.729-4.95.612-7.446h-17.896c-2.445 22.917-6.778 46.128-10.171 69.075l-.884 4.976h19.496c3.254-21.143 5.037-34.68 6.121-43.842l7.341-4.084c1.097-4.078 4.529-5.458 11.417-5.291-.926 5.008-1.389 10.091-1.383 15.184 0 24.225 13.07 39.308 34.05 39.308 5.404 0 10.041-.712 17.221-2.658l3.43-20.759c-6.458 3.181-11.759 4.677-16.559 4.677-11.329 0-18.184-8.363-18.184-22.185 0-20.051 10.196-34.109 24.746-34.109"
                                                ></path>
                                                <path
                                                    d="m185.21 297.24h-19.491l11.171-69.988-24.926 69.988h-13.283l-1.642-69.588-11.733 69.588h-18.241l15.237-91.042h28.021l.788 56.362 18.904-56.362h30.267z"
                                                    fill="#fff"
                                                ></path>
                                                <path
                                                    d="m647.52 211.6-4.321 26.309c-5.329-7.013-11.054-12.088-18.612-12.088-9.833 0-18.783 7.455-24.642 18.425-8.158-1.692-16.597-4.563-16.597-4.563l-.004.067c.658-6.134.921-9.875.862-11.146h-17.9c-2.438 22.917-6.771 46.128-10.157 69.075l-.893 4.976h19.492c2.633-17.096 4.648-31.291 6.133-42.551 6.658-6.016 9.992-11.266 16.721-10.916-2.979 7.205-4.725 15.503-4.725 24.017 0 18.513 9.366 30.725 23.533 30.725 7.142 0 12.621-2.462 17.967-8.171l-.913 6.884h18.435l14.842-91.042zm-24.371 73.941c-6.634 0-9.983-4.908-9.983-14.596 0-14.555 6.271-24.875 15.112-24.875 6.695 0 10.32 5.104 10.32 14.509.001 14.679-6.37 24.962-15.449 24.962z"
                                                ></path>
                                                <path
                                                    d="m233.19 264.26c-2.042-.236-2.946-.299-4.346-.299-11.046 0-16.634 3.787-16.634 11.266 0 4.604 2.729 7.547 6.979 7.547 7.947-.001 13.668-7.559 14.001-18.514zm14.178 32.984h-16.146l.367-7.663c-4.921 6.054-11.5 8.95-20.421 8.95-10.567 0-17.805-8.25-17.805-20.229 0-18.032 12.592-28.542 34.217-28.542 2.208 0 5.042.2 7.938.571.604-2.441.763-3.487.763-4.808 0-4.909-3.392-6.729-12.496-6.729-9.537-.108-17.396 2.271-20.629 3.321.204-1.225 2.7-16.637 2.7-16.637 9.708-2.858 16.12-3.929 23.32-3.929 16.737 0 25.604 7.517 25.588 21.704.029 3.821-.604 8.513-1.584 14.675-1.687 10.724-5.319 33.724-5.812 39.316zm261.38-88.592-3.191 19.767c-6.95-3.496-12-4.92-17.407-4.92-14.551 0-24.75 14.058-24.75 34.106 0 13.821 6.857 22.181 18.184 22.181 4.8 0 10.096-1.492 16.554-4.675l-3.421 20.75c-7.184 1.957-11.816 2.67-17.225 2.67-20.977 0-34.051-15.084-34.051-39.309 0-32.55 18.059-55.3 43.888-55.3 8.507.001 18.561 3.609 21.419 4.73m31.443 55.608c-2.041-.236-2.941-.299-4.347-.299-11.041 0-16.633 3.787-16.633 11.266 0 4.604 2.729 7.547 6.983 7.547 7.938-.001 13.663-7.559 13.997-18.514zm14.178 32.984h-16.15l.371-7.663c-4.925 6.054-11.5 8.95-20.421 8.95-10.563 0-17.804-8.25-17.804-20.229 0-18.032 12.596-28.542 34.212-28.542 2.213 0 5.042.2 7.941.571.601-2.441.763-3.487.763-4.808 0-4.909-3.393-6.729-12.495-6.729-9.533-.108-17.396 2.271-20.63 3.321.204-1.225 2.704-16.637 2.704-16.637 9.709-2.858 16.116-3.929 23.316-3.929 16.741 0 25.604 7.517 25.583 21.704.033 3.821-.596 8.513-1.579 14.675-1.682 10.724-5.323 33.724-5.811 39.316zm-220.39-1.121c-5.338 1.679-9.496 2.408-14 2.408-9.962 0-15.399-5.726-15.399-16.268-.138-3.279 1.438-11.88 2.675-19.736 1.12-6.926 8.445-50.534 8.445-50.534h19.368l-2.26 11.212h9.941l-2.646 17.788h-9.975c-2.25 14.092-5.463 31.62-5.496 33.95 0 3.83 2.041 5.482 6.671 5.482 2.221 0 3.938-.216 5.254-.691zm59.391-.592c-6.65 2.033-13.079 3.012-19.879 3-21.685-.021-32.987-11.346-32.987-33.033 0-25.321 14.379-43.95 33.899-43.95 15.971 0 26.171 10.429 26.171 26.8 0 5.434-.7 10.733-2.384 18.212h-38.574c-1.306 10.741 5.569 15.222 16.837 15.222 6.93 0 13.188-1.435 20.138-4.677zm-10.891-43.912c.116-1.538 2.06-13.217-9.013-13.217-6.167 0-10.579 4.717-12.375 13.217zm-123.42-5.005c0 9.367 4.542 15.818 14.842 20.675 7.892 3.709 9.112 4.812 9.112 8.172 0 4.616-3.483 6.699-11.188 6.699-5.816 0-11.225-.908-17.467-2.921 0 0-2.554 16.321-2.671 17.101 4.421.967 8.375 1.85 20.275 2.191 20.566 0 30.059-7.829 30.059-24.746 0-10.18-3.971-16.15-13.737-20.637-8.167-3.759-9.113-4.584-9.113-8.046 0-4 3.246-6.059 9.542-6.059 3.821 0 9.046.421 14.004 1.125l2.771-17.179c-5.042-.8-12.692-1.441-17.146-1.441-21.804 0-29.346 11.379-29.283 25.066m398.45 50.63h-18.438l.917-6.893c-5.347 5.717-10.825 8.18-17.968 8.18-14.166 0-23.528-12.213-23.528-30.726 0-24.63 14.521-45.392 31.708-45.392 7.559 0 13.279 3.087 18.604 10.096l4.325-26.308h19.221zm-28.746-17.109c9.075 0 15.45-10.283 15.45-24.953 0-9.405-3.629-14.509-10.325-14.509-8.837 0-15.115 10.315-15.115 24.875-.001 9.686 3.357 14.587 9.99 14.587zm-56.842-56.929c-2.441 22.917-6.773 46.13-10.162 69.063l-.892 4.976h19.491c6.972-45.275 8.658-54.117 19.588-53.009 1.742-9.267 4.982-17.383 7.399-21.479-8.163-1.7-12.721 2.913-18.688 11.675.471-3.788 1.333-7.467 1.162-11.225zm-160.42 0c-2.446 22.917-6.779 46.13-10.167 69.063l-.888 4.976h19.5c6.963-45.275 8.646-54.117 19.57-53.009 1.75-9.267 4.991-17.383 7.399-21.479-8.154-1.7-12.717 2.913-18.679 11.675.471-3.788 1.324-7.467 1.162-11.225zm254.57 68.241c-.004-3.199 2.586-5.795 5.784-5.799h.012c3.197-.004 5.793 2.586 5.796 5.783v.016c-.001 3.201-2.595 5.795-5.796 5.797-3.201-.002-5.795-2.596-5.796-5.797zm5.796 4.405c2.431.002 4.402-1.969 4.403-4.399v-.004c.003-2.433-1.968-4.406-4.399-4.408h-.004c-2.435.001-4.407 1.974-4.408 4.408.002 2.432 1.975 4.403 4.408 4.403zm-.784-1.871h-1.188v-5.082h2.153c.446 0 .909.009 1.296.254.417.283.654.767.654 1.274 0 .575-.337 1.112-.888 1.317l.941 2.236h-1.32l-.779-2.009h-.87zm0-2.879h.653c.246 0 .513.019.729-.1.196-.125.296-.361.296-.588-.009-.21-.114-.404-.287-.523-.204-.117-.542-.084-.763-.084h-.629z"
                                                    fill="#fff"
                                                ></path>
                                            </svg>
                                            <span>••• 475</span>
                                        </td>
                                        <td
                                            class="p-4 whitespace-nowrap"
                                        >
                                            <span
                                                class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-md dark:bg-gray-700 dark:text-green-400 border border-green-100 dark:border-green-500"
                                                >Completed</span
                                            >
                                        </td>
                                    </tr>
                                    <tr
                                        class="bg-gray-50 dark:bg-gray-700"
                                    >
                                        <td
                                            class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white"
                                        >
                                            Payment refund to
                                            <span
                                                class="font-semibold"
                                                >#00910</span
                                            >
                                        </td>
                                        <td
                                            class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400"
                                        >
                                            Apr 23 ,2021
                                        </td>
                                        <td
                                            class="p-4 text-sm font-semibold text-gray-900 whitespace-nowrap dark:text-white"
                                        >
                                            -$670
                                        </td>
                                        <td
                                            class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400"
                                        >
                                            0078568936
                                        </td>
                                        <td
                                            class="inline-flex items-center p-4 space-x-2 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400"
                                        >
                                            <svg
                                                class="w-6 h-6"
                                                aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 256 83"
                                            >
                                                <defs>
                                                    <linearGradient
                                                        id="logosVisa0"
                                                        x1="45.974%"
                                                        x2="54.877%"
                                                        y1="-2.006%"
                                                        y2="100%"
                                                    >
                                                        <stop
                                                            offset="0%"
                                                            stop-color="#222357"
                                                        ></stop>
                                                        <stop
                                                            offset="100%"
                                                            stop-color="#254AA5"
                                                        ></stop>
                                                    </linearGradient>
                                                </defs>
                                                <path
                                                    fill="url(#logosVisa0)"
                                                    d="M132.397 56.24c-.146-11.516 10.263-17.942 18.104-21.763c8.056-3.92 10.762-6.434 10.73-9.94c-.06-5.365-6.426-7.733-12.383-7.825c-10.393-.161-16.436 2.806-21.24 5.05l-3.744-17.519c4.82-2.221 13.745-4.158 23-4.243c21.725 0 35.938 10.724 36.015 27.351c.085 21.102-29.188 22.27-28.988 31.702c.069 2.86 2.798 5.912 8.778 6.688c2.96.392 11.131.692 20.395-3.574l3.636 16.95c-4.982 1.814-11.385 3.551-19.357 3.551c-20.448 0-34.83-10.87-34.946-26.428m89.241 24.968c-3.967 0-7.31-2.314-8.802-5.865L181.803 1.245h21.709l4.32 11.939h26.528l2.506-11.939H256l-16.697 79.963h-17.665m3.037-21.601l6.265-30.027h-17.158l10.893 30.027m-118.599 21.6L88.964 1.246h20.687l17.104 79.963h-20.679m-30.603 0L53.941 26.782l-8.71 46.277c-1.022 5.166-5.058 8.149-9.54 8.149H.493L0 78.886c7.226-1.568 15.436-4.097 20.41-6.803c3.044-1.653 3.912-3.098 4.912-7.026L41.819 1.245H63.68l33.516 79.963H75.473"
                                                    transform="matrix(1 0 0 -1 0 82.668)"
                                                ></path>
                                            </svg>
                                            <span>••• 924</span>
                                        </td>
                                        <td
                                            class="p-4 whitespace-nowrap"
                                        >
                                            <span
                                                class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-md dark:bg-gray-700 dark:text-green-400 border border-green-100 dark:border-green-500"
                                                >Completed</span
                                            >
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white"
                                        >
                                            Payment failed from
                                            <span
                                                class="font-semibold"
                                                >#087651</span
                                            >
                                        </td>
                                        <td
                                            class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400"
                                        >
                                            Apr 18 ,2021
                                        </td>
                                        <td
                                            class="p-4 text-sm font-semibold text-gray-900 whitespace-nowrap dark:text-white"
                                        >
                                            $234
                                        </td>
                                        <td
                                            class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400"
                                        >
                                            0088568934
                                        </td>
                                        <td
                                            class="inline-flex items-center p-4 space-x-2 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400"
                                        >
                                            <svg
                                                class="w-6 h-6"
                                                aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 256 83"
                                            >
                                                <defs>
                                                    <linearGradient
                                                        id="logosVisa0"
                                                        x1="45.974%"
                                                        x2="54.877%"
                                                        y1="-2.006%"
                                                        y2="100%"
                                                    >
                                                        <stop
                                                            offset="0%"
                                                            stop-color="#222357"
                                                        ></stop>
                                                        <stop
                                                            offset="100%"
                                                            stop-color="#254AA5"
                                                        ></stop>
                                                    </linearGradient>
                                                </defs>
                                                <path
                                                    fill="url(#logosVisa0)"
                                                    d="M132.397 56.24c-.146-11.516 10.263-17.942 18.104-21.763c8.056-3.92 10.762-6.434 10.73-9.94c-.06-5.365-6.426-7.733-12.383-7.825c-10.393-.161-16.436 2.806-21.24 5.05l-3.744-17.519c4.82-2.221 13.745-4.158 23-4.243c21.725 0 35.938 10.724 36.015 27.351c.085 21.102-29.188 22.27-28.988 31.702c.069 2.86 2.798 5.912 8.778 6.688c2.96.392 11.131.692 20.395-3.574l3.636 16.95c-4.982 1.814-11.385 3.551-19.357 3.551c-20.448 0-34.83-10.87-34.946-26.428m89.241 24.968c-3.967 0-7.31-2.314-8.802-5.865L181.803 1.245h21.709l4.32 11.939h26.528l2.506-11.939H256l-16.697 79.963h-17.665m3.037-21.601l6.265-30.027h-17.158l10.893 30.027m-118.599 21.6L88.964 1.246h20.687l17.104 79.963h-20.679m-30.603 0L53.941 26.782l-8.71 46.277c-1.022 5.166-5.058 8.149-9.54 8.149H.493L0 78.886c7.226-1.568 15.436-4.097 20.41-6.803c3.044-1.653 3.912-3.098 4.912-7.026L41.819 1.245H63.68l33.516 79.963H75.473"
                                                    transform="matrix(1 0 0 -1 0 82.668)"
                                                ></path>
                                            </svg>
                                            <span>••• 826</span>
                                        </td>
                                        <td
                                            class="p-4 whitespace-nowrap"
                                        >
                                            <span
                                                class="bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-md border border-red-100 dark:border-red-400 dark:bg-gray-700 dark:text-red-400"
                                                >Cancelled</span
                                            >
                                        </td>
                                    </tr>
                                    <tr
                                        class="bg-gray-50 dark:bg-gray-700"
                                    >
                                        <td
                                            class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white"
                                        >
                                            Payment from
                                            <span
                                                class="font-semibold"
                                                >Lana Byrd</span
                                            >
                                        </td>
                                        <td
                                            class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400"
                                        >
                                            Apr 15 ,2021
                                        </td>
                                        <td
                                            class="p-4 text-sm font-semibold text-gray-900 whitespace-nowrap dark:text-white"
                                        >
                                            $5000
                                        </td>
                                        <td
                                            class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400"
                                        >
                                            0018568911
                                        </td>
                                        <td
                                            class="inline-flex items-center p-4 space-x-2 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400"
                                        >
                                            <svg
                                                class="w-6 h-6"
                                                aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 256 83"
                                            >
                                                <defs>
                                                    <linearGradient
                                                        id="logosVisa0"
                                                        x1="45.974%"
                                                        x2="54.877%"
                                                        y1="-2.006%"
                                                        y2="100%"
                                                    >
                                                        <stop
                                                            offset="0%"
                                                            stop-color="#222357"
                                                        ></stop>
                                                        <stop
                                                            offset="100%"
                                                            stop-color="#254AA5"
                                                        ></stop>
                                                    </linearGradient>
                                                </defs>
                                                <path
                                                    fill="url(#logosVisa0)"
                                                    d="M132.397 56.24c-.146-11.516 10.263-17.942 18.104-21.763c8.056-3.92 10.762-6.434 10.73-9.94c-.06-5.365-6.426-7.733-12.383-7.825c-10.393-.161-16.436 2.806-21.24 5.05l-3.744-17.519c4.82-2.221 13.745-4.158 23-4.243c21.725 0 35.938 10.724 36.015 27.351c.085 21.102-29.188 22.27-28.988 31.702c.069 2.86 2.798 5.912 8.778 6.688c2.96.392 11.131.692 20.395-3.574l3.636 16.95c-4.982 1.814-11.385 3.551-19.357 3.551c-20.448 0-34.83-10.87-34.946-26.428m89.241 24.968c-3.967 0-7.31-2.314-8.802-5.865L181.803 1.245h21.709l4.32 11.939h26.528l2.506-11.939H256l-16.697 79.963h-17.665m3.037-21.601l6.265-30.027h-17.158l10.893 30.027m-118.599 21.6L88.964 1.246h20.687l17.104 79.963h-20.679m-30.603 0L53.941 26.782l-8.71 46.277c-1.022 5.166-5.058 8.149-9.54 8.149H.493L0 78.886c7.226-1.568 15.436-4.097 20.41-6.803c3.044-1.653 3.912-3.098 4.912-7.026L41.819 1.245H63.68l33.516 79.963H75.473"
                                                    transform="matrix(1 0 0 -1 0 82.668)"
                                                ></path>
                                            </svg>
                                            <span>••• 634</span>
                                        </td>
                                        <td
                                            class="p-4 whitespace-nowrap"
                                        >
                                            <span
                                                class="bg-purple-100 text-purple-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-md border border-purple-100 dark:bg-gray-700 dark:border-purple-500 dark:text-purple-400"
                                                >In
                                                progress</span
                                            >
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white"
                                        >
                                            Payment from
                                            <span
                                                class="font-semibold"
                                                >Jese Leos</span
                                            >
                                        </td>
                                        <td
                                            class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400"
                                        >
                                            Apr 15 ,2021
                                        </td>
                                        <td
                                            class="p-4 text-sm font-semibold text-gray-900 whitespace-nowrap dark:text-white"
                                        >
                                            $2300
                                        </td>
                                        <td
                                            class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400"
                                        >
                                            0045568939
                                        </td>
                                        <td
                                            class="inline-flex items-center p-4 space-x-2 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400"
                                        >
                                            <svg
                                                class="w-7 h-7"
                                                aria-hidden="true"
                                                enable-background="new 0 0 780 500"
                                                viewBox="0 0 780 500"
                                                xmlns="http://www.w3.org/2000/svg"
                                            >
                                                <path
                                                    d="m449.01 250c0 99.143-80.371 179.5-179.51 179.5s-179.5-80.361-179.5-179.5c0-99.133 80.362-179.5 179.5-179.5 99.137 0 179.51 80.371 179.51 179.5"
                                                    fill="#d9222a"
                                                ></path>
                                                <path
                                                    d="m510.49 70.496c-46.379 0-88.643 17.596-120.5 46.467-6.49 5.889-12.548 12.237-18.125 18.996h36.267c4.965 6.037 9.536 12.387 13.685 19.012h-63.635c-3.827 6.122-7.281 12.469-10.342 19.008h84.313c2.894 6.185 5.431 12.53 7.601 19.004h-99.513c-2.09 6.234-3.832 12.58-5.217 19.008h109.94c2.689 12.49 4.045 25.231 4.042 38.008 0 19.935-3.254 39.112-9.254 57.021h-99.513c2.164 6.477 4.7 12.824 7.596 19.008h84.316c-3.063 6.541-6.519 12.889-10.347 19.013h-63.625c4.147 6.62 8.719 12.966 13.685 18.996h36.259c-5.57 6.772-11.63 13.127-18.13 19.013 31.857 28.866 74.117 46.454 120.5 46.454 99.139 0 179.51-80.361 179.51-179.5 0-99.129-80.371-179.5-179.51-179.5"
                                                    fill="#ee9f2d"
                                                ></path>
                                                <path
                                                    d="m666.07 350.06c0-3.199 2.592-5.801 5.796-5.801s5.796 2.602 5.796 5.801-2.592 5.801-5.796 5.801-5.796-2.602-5.796-5.801zm5.796 4.408c2.434-.001 4.407-1.974 4.408-4.408 0-2.432-1.971-4.402-4.402-4.404h-.006c-2.429-.003-4.4 1.963-4.404 4.391v.014c-.002 2.433 1.968 4.406 4.4 4.408.001-.001.003-.001.004-.001zm-.783-1.86h-1.187v-5.096h2.149c.45 0 .908 0 1.305.254.413.279.646.771.646 1.279 0 .571-.338 1.104-.884 1.312l.938 2.25h-1.315l-.779-2.017h-.871zm0-2.89h.658c.246 0 .505.021.726-.1.195-.125.296-.359.296-.584-.005-.209-.112-.402-.288-.518-.207-.129-.536-.101-.758-.101h-.634zm-443.5-80.063c-2.046-.238-2.945-.301-4.35-.301-11.046 0-16.638 3.787-16.638 11.268 0 4.611 2.729 7.545 6.987 7.545 7.939 0 13.659-7.559 14.001-18.512zm14.171 32.996h-16.146l.371-7.676c-4.926 6.065-11.496 8.949-20.426 8.949-10.563 0-17.804-8.25-17.804-20.229 0-18.024 12.596-28.541 34.217-28.541 2.208 0 5.042.199 7.941.57.604-2.441.763-3.488.763-4.801 0-4.908-3.396-6.737-12.5-6.737-9.533-.108-17.396 2.271-20.625 3.333.204-1.229 2.7-16.659 2.7-16.659 9.712-2.846 16.116-3.917 23.325-3.917 16.732 0 25.596 7.513 25.579 21.712.033 3.805-.597 8.5-1.579 14.671-1.691 10.734-5.32 33.721-5.816 39.325zm-62.158 0h-19.487l11.162-69.997-24.925 69.997h-13.279l-1.642-69.597-11.733 69.597h-18.242l15.237-91.056h28.021l1.7 50.968 17.092-50.968h31.167zm354.97-32.996c-2.037-.238-2.941-.301-4.342-.301-11.041 0-16.634 3.787-16.634 11.268 0 4.611 2.726 7.545 6.983 7.545 7.94 0 13.664-7.559 13.993-18.512zm14.184 32.996h-16.146l.366-7.676c-4.926 6.065-11.5 8.949-20.422 8.949-10.565 0-17.8-8.25-17.8-20.229 0-18.024 12.588-28.541 34.213-28.541 2.208 0 5.037.199 7.934.57.604-2.441.763-3.488.763-4.801 0-4.908-3.392-6.737-12.496-6.737-9.533-.108-17.387 2.271-20.629 3.333.204-1.229 2.709-16.659 2.709-16.659 9.712-2.846 16.112-3.917 23.313-3.917 16.74 0 25.604 7.513 25.587 21.712.032 3.805-.597 8.5-1.579 14.671-1.684 10.734-5.321 33.721-5.813 39.325zm-220.39-1.125c-5.333 1.679-9.491 2.398-14 2.398-9.962 0-15.399-5.725-15.399-16.267-.142-3.271 1.433-11.88 2.671-19.737 1.125-6.917 8.449-50.529 8.449-50.529h19.371l-2.263 11.208h11.699l-2.642 17.796h-11.742c-2.25 14.083-5.454 31.625-5.491 33.95 0 3.816 2.037 5.483 6.671 5.483 2.221 0 3.94-.227 5.254-.7zm59.392-.6c-6.654 2.034-13.075 3.017-19.879 3-21.684-.021-32.987-11.346-32.987-33.032 0-25.313 14.38-43.947 33.899-43.947 15.971 0 26.171 10.433 26.171 26.796 0 5.429-.7 10.729-2.388 18.212h-38.574c-1.305 10.741 5.57 15.217 16.837 15.217 6.935 0 13.188-1.429 20.142-4.663zm-10.888-43.9c.107-1.543 2.055-13.217-9.013-13.217-6.171 0-10.583 4.704-12.38 13.217zm-123.42-5.017c0 9.367 4.542 15.826 14.842 20.676 7.892 3.709 9.112 4.81 9.112 8.17 0 4.617-3.479 6.701-11.191 6.701-5.813 0-11.221-.908-17.458-2.922 0 0-2.563 16.321-2.68 17.102 4.43.967 8.38 1.861 20.279 2.19 20.563 0 30.059-7.829 30.059-24.75 0-10.175-3.976-16.146-13.737-20.634-8.171-3.75-9.108-4.587-9.108-8.045 0-4.004 3.237-6.046 9.537-6.046 3.825 0 9.05.408 14 1.112l2.775-17.175c-5.046-.8-12.696-1.442-17.15-1.442-21.801.001-29.347 11.388-29.28 25.063m229.09-23.116c5.412 0 10.458 1.421 17.412 4.921l3.188-19.763c-2.854-1.121-12.904-7.7-21.417-7.7-13.041 0-24.065 6.471-31.82 17.15-11.309-3.746-15.958 3.825-21.657 11.367l-5.063 1.179c.383-2.483.729-4.95.612-7.446h-17.896c-2.445 22.917-6.778 46.128-10.171 69.075l-.884 4.976h19.496c3.254-21.143 5.037-34.68 6.121-43.842l7.341-4.084c1.097-4.078 4.529-5.458 11.417-5.291-.926 5.008-1.389 10.091-1.383 15.184 0 24.225 13.07 39.308 34.05 39.308 5.404 0 10.041-.712 17.221-2.658l3.43-20.759c-6.458 3.181-11.759 4.677-16.559 4.677-11.329 0-18.184-8.363-18.184-22.185 0-20.051 10.196-34.109 24.746-34.109"
                                                ></path>
                                                <path
                                                    d="m185.21 297.24h-19.491l11.171-69.988-24.926 69.988h-13.283l-1.642-69.588-11.733 69.588h-18.241l15.237-91.042h28.021l.788 56.362 18.904-56.362h30.267z"
                                                    fill="#fff"
                                                ></path>
                                                <path
                                                    d="m647.52 211.6-4.321 26.309c-5.329-7.013-11.054-12.088-18.612-12.088-9.833 0-18.783 7.455-24.642 18.425-8.158-1.692-16.597-4.563-16.597-4.563l-.004.067c.658-6.134.921-9.875.862-11.146h-17.9c-2.438 22.917-6.771 46.128-10.157 69.075l-.893 4.976h19.492c2.633-17.096 4.648-31.291 6.133-42.551 6.658-6.016 9.992-11.266 16.721-10.916-2.979 7.205-4.725 15.503-4.725 24.017 0 18.513 9.366 30.725 23.533 30.725 7.142 0 12.621-2.462 17.967-8.171l-.913 6.884h18.435l14.842-91.042zm-24.371 73.941c-6.634 0-9.983-4.908-9.983-14.596 0-14.555 6.271-24.875 15.112-24.875 6.695 0 10.32 5.104 10.32 14.509.001 14.679-6.37 24.962-15.449 24.962z"
                                                ></path>
                                                <path
                                                    d="m233.19 264.26c-2.042-.236-2.946-.299-4.346-.299-11.046 0-16.634 3.787-16.634 11.266 0 4.604 2.729 7.547 6.979 7.547 7.947-.001 13.668-7.559 14.001-18.514zm14.178 32.984h-16.146l.367-7.663c-4.921 6.054-11.5 8.95-20.421 8.95-10.567 0-17.805-8.25-17.805-20.229 0-18.032 12.592-28.542 34.217-28.542 2.208 0 5.042.2 7.938.571.604-2.441.763-3.487.763-4.808 0-4.909-3.392-6.729-12.496-6.729-9.537-.108-17.396 2.271-20.629 3.321.204-1.225 2.7-16.637 2.7-16.637 9.708-2.858 16.12-3.929 23.32-3.929 16.737 0 25.604 7.517 25.588 21.704.029 3.821-.604 8.513-1.584 14.675-1.687 10.724-5.319 33.724-5.812 39.316zm261.38-88.592-3.191 19.767c-6.95-3.496-12-4.92-17.407-4.92-14.551 0-24.75 14.058-24.75 34.106 0 13.821 6.857 22.181 18.184 22.181 4.8 0 10.096-1.492 16.554-4.675l-3.421 20.75c-7.184 1.957-11.816 2.67-17.225 2.67-20.977 0-34.051-15.084-34.051-39.309 0-32.55 18.059-55.3 43.888-55.3 8.507.001 18.561 3.609 21.419 4.73m31.443 55.608c-2.041-.236-2.941-.299-4.347-.299-11.041 0-16.633 3.787-16.633 11.266 0 4.604 2.729 7.547 6.983 7.547 7.938-.001 13.663-7.559 13.997-18.514zm14.178 32.984h-16.15l.371-7.663c-4.925 6.054-11.5 8.95-20.421 8.95-10.563 0-17.804-8.25-17.804-20.229 0-18.032 12.596-28.542 34.212-28.542 2.213 0 5.042.2 7.941.571.601-2.441.763-3.487.763-4.808 0-4.909-3.393-6.729-12.495-6.729-9.533-.108-17.396 2.271-20.63 3.321.204-1.225 2.704-16.637 2.704-16.637 9.709-2.858 16.116-3.929 23.316-3.929 16.741 0 25.604 7.517 25.583 21.704.033 3.821-.596 8.513-1.579 14.675-1.682 10.724-5.323 33.724-5.811 39.316zm-220.39-1.121c-5.338 1.679-9.496 2.408-14 2.408-9.962 0-15.399-5.726-15.399-16.268-.138-3.279 1.438-11.88 2.675-19.736 1.12-6.926 8.445-50.534 8.445-50.534h19.368l-2.26 11.212h9.941l-2.646 17.788h-9.975c-2.25 14.092-5.463 31.62-5.496 33.95 0 3.83 2.041 5.482 6.671 5.482 2.221 0 3.938-.216 5.254-.691zm59.391-.592c-6.65 2.033-13.079 3.012-19.879 3-21.685-.021-32.987-11.346-32.987-33.033 0-25.321 14.379-43.95 33.899-43.95 15.971 0 26.171 10.429 26.171 26.8 0 5.434-.7 10.733-2.384 18.212h-38.574c-1.306 10.741 5.569 15.222 16.837 15.222 6.93 0 13.188-1.435 20.138-4.677zm-10.891-43.912c.116-1.538 2.06-13.217-9.013-13.217-6.167 0-10.579 4.717-12.375 13.217zm-123.42-5.005c0 9.367 4.542 15.818 14.842 20.675 7.892 3.709 9.112 4.812 9.112 8.172 0 4.616-3.483 6.699-11.188 6.699-5.816 0-11.225-.908-17.467-2.921 0 0-2.554 16.321-2.671 17.101 4.421.967 8.375 1.85 20.275 2.191 20.566 0 30.059-7.829 30.059-24.746 0-10.18-3.971-16.15-13.737-20.637-8.167-3.759-9.113-4.584-9.113-8.046 0-4 3.246-6.059 9.542-6.059 3.821 0 9.046.421 14.004 1.125l2.771-17.179c-5.042-.8-12.692-1.441-17.146-1.441-21.804 0-29.346 11.379-29.283 25.066m398.45 50.63h-18.438l.917-6.893c-5.347 5.717-10.825 8.18-17.968 8.18-14.166 0-23.528-12.213-23.528-30.726 0-24.63 14.521-45.392 31.708-45.392 7.559 0 13.279 3.087 18.604 10.096l4.325-26.308h19.221zm-28.746-17.109c9.075 0 15.45-10.283 15.45-24.953 0-9.405-3.629-14.509-10.325-14.509-8.837 0-15.115 10.315-15.115 24.875-.001 9.686 3.357 14.587 9.99 14.587zm-56.842-56.929c-2.441 22.917-6.773 46.13-10.162 69.063l-.892 4.976h19.491c6.972-45.275 8.658-54.117 19.588-53.009 1.742-9.267 4.982-17.383 7.399-21.479-8.163-1.7-12.721 2.913-18.688 11.675.471-3.788 1.333-7.467 1.162-11.225zm-160.42 0c-2.446 22.917-6.779 46.13-10.167 69.063l-.888 4.976h19.5c6.963-45.275 8.646-54.117 19.57-53.009 1.75-9.267 4.991-17.383 7.399-21.479-8.154-1.7-12.717 2.913-18.679 11.675.471-3.788 1.324-7.467 1.162-11.225zm254.57 68.241c-.004-3.199 2.586-5.795 5.784-5.799h.012c3.197-.004 5.793 2.586 5.796 5.783v.016c-.001 3.201-2.595 5.795-5.796 5.797-3.201-.002-5.795-2.596-5.796-5.797zm5.796 4.405c2.431.002 4.402-1.969 4.403-4.399v-.004c.003-2.433-1.968-4.406-4.399-4.408h-.004c-2.435.001-4.407 1.974-4.408 4.408.002 2.432 1.975 4.403 4.408 4.403zm-.784-1.871h-1.188v-5.082h2.153c.446 0 .909.009 1.296.254.417.283.654.767.654 1.274 0 .575-.337 1.112-.888 1.317l.941 2.236h-1.32l-.779-2.009h-.87zm0-2.879h.653c.246 0 .513.019.729-.1.196-.125.296-.361.296-.588-.009-.21-.114-.404-.287-.523-.204-.117-.542-.084-.763-.084h-.629z"
                                                    fill="#fff"
                                                ></path>
                                            </svg>
                                            <span>••• 163</span>
                                        </td>
                                        <td
                                            class="p-4 whitespace-nowrap"
                                        >
                                            <span
                                                class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-md dark:bg-gray-700 dark:text-green-400 border border-green-100 dark:border-green-500"
                                                >Completed</span
                                            >
                                        </td>
                                    </tr>
                                    <tr
                                        class="bg-gray-50 dark:bg-gray-700"
                                    >
                                        <td
                                            class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white"
                                        >
                                            Refund to
                                            <span
                                                class="font-semibold"
                                                >THEMESBERG
                                                LLC</span
                                            >
                                        </td>
                                        <td
                                            class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400"
                                        >
                                            Apr 11 ,2021
                                        </td>
                                        <td
                                            class="p-4 text-sm font-semibold text-gray-900 whitespace-nowrap dark:text-white"
                                        >
                                            -$560
                                        </td>
                                        <td
                                            class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400"
                                        >
                                            0031568935
                                        </td>
                                        <td
                                            class="inline-flex items-center p-4 space-x-2 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400"
                                        >
                                            <svg
                                                class="w-7 h-7"
                                                aria-hidden="true"
                                                enable-background="new 0 0 780 500"
                                                viewBox="0 0 780 500"
                                                xmlns="http://www.w3.org/2000/svg"
                                            >
                                                <path
                                                    d="m449.01 250c0 99.143-80.371 179.5-179.51 179.5s-179.5-80.361-179.5-179.5c0-99.133 80.362-179.5 179.5-179.5 99.137 0 179.51 80.371 179.51 179.5"
                                                    fill="#d9222a"
                                                ></path>
                                                <path
                                                    d="m510.49 70.496c-46.379 0-88.643 17.596-120.5 46.467-6.49 5.889-12.548 12.237-18.125 18.996h36.267c4.965 6.037 9.536 12.387 13.685 19.012h-63.635c-3.827 6.122-7.281 12.469-10.342 19.008h84.313c2.894 6.185 5.431 12.53 7.601 19.004h-99.513c-2.09 6.234-3.832 12.58-5.217 19.008h109.94c2.689 12.49 4.045 25.231 4.042 38.008 0 19.935-3.254 39.112-9.254 57.021h-99.513c2.164 6.477 4.7 12.824 7.596 19.008h84.316c-3.063 6.541-6.519 12.889-10.347 19.013h-63.625c4.147 6.62 8.719 12.966 13.685 18.996h36.259c-5.57 6.772-11.63 13.127-18.13 19.013 31.857 28.866 74.117 46.454 120.5 46.454 99.139 0 179.51-80.361 179.51-179.5 0-99.129-80.371-179.5-179.51-179.5"
                                                    fill="#ee9f2d"
                                                ></path>
                                                <path
                                                    d="m666.07 350.06c0-3.199 2.592-5.801 5.796-5.801s5.796 2.602 5.796 5.801-2.592 5.801-5.796 5.801-5.796-2.602-5.796-5.801zm5.796 4.408c2.434-.001 4.407-1.974 4.408-4.408 0-2.432-1.971-4.402-4.402-4.404h-.006c-2.429-.003-4.4 1.963-4.404 4.391v.014c-.002 2.433 1.968 4.406 4.4 4.408.001-.001.003-.001.004-.001zm-.783-1.86h-1.187v-5.096h2.149c.45 0 .908 0 1.305.254.413.279.646.771.646 1.279 0 .571-.338 1.104-.884 1.312l.938 2.25h-1.315l-.779-2.017h-.871zm0-2.89h.658c.246 0 .505.021.726-.1.195-.125.296-.359.296-.584-.005-.209-.112-.402-.288-.518-.207-.129-.536-.101-.758-.101h-.634zm-443.5-80.063c-2.046-.238-2.945-.301-4.35-.301-11.046 0-16.638 3.787-16.638 11.268 0 4.611 2.729 7.545 6.987 7.545 7.939 0 13.659-7.559 14.001-18.512zm14.171 32.996h-16.146l.371-7.676c-4.926 6.065-11.496 8.949-20.426 8.949-10.563 0-17.804-8.25-17.804-20.229 0-18.024 12.596-28.541 34.217-28.541 2.208 0 5.042.199 7.941.57.604-2.441.763-3.488.763-4.801 0-4.908-3.396-6.737-12.5-6.737-9.533-.108-17.396 2.271-20.625 3.333.204-1.229 2.7-16.659 2.7-16.659 9.712-2.846 16.116-3.917 23.325-3.917 16.732 0 25.596 7.513 25.579 21.712.033 3.805-.597 8.5-1.579 14.671-1.691 10.734-5.32 33.721-5.816 39.325zm-62.158 0h-19.487l11.162-69.997-24.925 69.997h-13.279l-1.642-69.597-11.733 69.597h-18.242l15.237-91.056h28.021l1.7 50.968 17.092-50.968h31.167zm354.97-32.996c-2.037-.238-2.941-.301-4.342-.301-11.041 0-16.634 3.787-16.634 11.268 0 4.611 2.726 7.545 6.983 7.545 7.94 0 13.664-7.559 13.993-18.512zm14.184 32.996h-16.146l.366-7.676c-4.926 6.065-11.5 8.949-20.422 8.949-10.565 0-17.8-8.25-17.8-20.229 0-18.024 12.588-28.541 34.213-28.541 2.208 0 5.037.199 7.934.57.604-2.441.763-3.488.763-4.801 0-4.908-3.392-6.737-12.496-6.737-9.533-.108-17.387 2.271-20.629 3.333.204-1.229 2.709-16.659 2.709-16.659 9.712-2.846 16.112-3.917 23.313-3.917 16.74 0 25.604 7.513 25.587 21.712.032 3.805-.597 8.5-1.579 14.671-1.684 10.734-5.321 33.721-5.813 39.325zm-220.39-1.125c-5.333 1.679-9.491 2.398-14 2.398-9.962 0-15.399-5.725-15.399-16.267-.142-3.271 1.433-11.88 2.671-19.737 1.125-6.917 8.449-50.529 8.449-50.529h19.371l-2.263 11.208h11.699l-2.642 17.796h-11.742c-2.25 14.083-5.454 31.625-5.491 33.95 0 3.816 2.037 5.483 6.671 5.483 2.221 0 3.94-.227 5.254-.7zm59.392-.6c-6.654 2.034-13.075 3.017-19.879 3-21.684-.021-32.987-11.346-32.987-33.032 0-25.313 14.38-43.947 33.899-43.947 15.971 0 26.171 10.433 26.171 26.796 0 5.429-.7 10.729-2.388 18.212h-38.574c-1.305 10.741 5.57 15.217 16.837 15.217 6.935 0 13.188-1.429 20.142-4.663zm-10.888-43.9c.107-1.543 2.055-13.217-9.013-13.217-6.171 0-10.583 4.704-12.38 13.217zm-123.42-5.017c0 9.367 4.542 15.826 14.842 20.676 7.892 3.709 9.112 4.81 9.112 8.17 0 4.617-3.479 6.701-11.191 6.701-5.813 0-11.221-.908-17.458-2.922 0 0-2.563 16.321-2.68 17.102 4.43.967 8.38 1.861 20.279 2.19 20.563 0 30.059-7.829 30.059-24.75 0-10.175-3.976-16.146-13.737-20.634-8.171-3.75-9.108-4.587-9.108-8.045 0-4.004 3.237-6.046 9.537-6.046 3.825 0 9.05.408 14 1.112l2.775-17.175c-5.046-.8-12.696-1.442-17.15-1.442-21.801.001-29.347 11.388-29.28 25.063m229.09-23.116c5.412 0 10.458 1.421 17.412 4.921l3.188-19.763c-2.854-1.121-12.904-7.7-21.417-7.7-13.041 0-24.065 6.471-31.82 17.15-11.309-3.746-15.958 3.825-21.657 11.367l-5.063 1.179c.383-2.483.729-4.95.612-7.446h-17.896c-2.445 22.917-6.778 46.128-10.171 69.075l-.884 4.976h19.496c3.254-21.143 5.037-34.68 6.121-43.842l7.341-4.084c1.097-4.078 4.529-5.458 11.417-5.291-.926 5.008-1.389 10.091-1.383 15.184 0 24.225 13.07 39.308 34.05 39.308 5.404 0 10.041-.712 17.221-2.658l3.43-20.759c-6.458 3.181-11.759 4.677-16.559 4.677-11.329 0-18.184-8.363-18.184-22.185 0-20.051 10.196-34.109 24.746-34.109"
                                                ></path>
                                                <path
                                                    d="m185.21 297.24h-19.491l11.171-69.988-24.926 69.988h-13.283l-1.642-69.588-11.733 69.588h-18.241l15.237-91.042h28.021l.788 56.362 18.904-56.362h30.267z"
                                                    fill="#fff"
                                                ></path>
                                                <path
                                                    d="m647.52 211.6-4.321 26.309c-5.329-7.013-11.054-12.088-18.612-12.088-9.833 0-18.783 7.455-24.642 18.425-8.158-1.692-16.597-4.563-16.597-4.563l-.004.067c.658-6.134.921-9.875.862-11.146h-17.9c-2.438 22.917-6.771 46.128-10.157 69.075l-.893 4.976h19.492c2.633-17.096 4.648-31.291 6.133-42.551 6.658-6.016 9.992-11.266 16.721-10.916-2.979 7.205-4.725 15.503-4.725 24.017 0 18.513 9.366 30.725 23.533 30.725 7.142 0 12.621-2.462 17.967-8.171l-.913 6.884h18.435l14.842-91.042zm-24.371 73.941c-6.634 0-9.983-4.908-9.983-14.596 0-14.555 6.271-24.875 15.112-24.875 6.695 0 10.32 5.104 10.32 14.509.001 14.679-6.37 24.962-15.449 24.962z"
                                                ></path>
                                                <path
                                                    d="m233.19 264.26c-2.042-.236-2.946-.299-4.346-.299-11.046 0-16.634 3.787-16.634 11.266 0 4.604 2.729 7.547 6.979 7.547 7.947-.001 13.668-7.559 14.001-18.514zm14.178 32.984h-16.146l.367-7.663c-4.921 6.054-11.5 8.95-20.421 8.95-10.567 0-17.805-8.25-17.805-20.229 0-18.032 12.592-28.542 34.217-28.542 2.208 0 5.042.2 7.938.571.604-2.441.763-3.487.763-4.808 0-4.909-3.392-6.729-12.496-6.729-9.537-.108-17.396 2.271-20.629 3.321.204-1.225 2.7-16.637 2.7-16.637 9.708-2.858 16.12-3.929 23.32-3.929 16.737 0 25.604 7.517 25.588 21.704.029 3.821-.604 8.513-1.584 14.675-1.687 10.724-5.319 33.724-5.812 39.316zm261.38-88.592-3.191 19.767c-6.95-3.496-12-4.92-17.407-4.92-14.551 0-24.75 14.058-24.75 34.106 0 13.821 6.857 22.181 18.184 22.181 4.8 0 10.096-1.492 16.554-4.675l-3.421 20.75c-7.184 1.957-11.816 2.67-17.225 2.67-20.977 0-34.051-15.084-34.051-39.309 0-32.55 18.059-55.3 43.888-55.3 8.507.001 18.561 3.609 21.419 4.73m31.443 55.608c-2.041-.236-2.941-.299-4.347-.299-11.041 0-16.633 3.787-16.633 11.266 0 4.604 2.729 7.547 6.983 7.547 7.938-.001 13.663-7.559 13.997-18.514zm14.178 32.984h-16.15l.371-7.663c-4.925 6.054-11.5 8.95-20.421 8.95-10.563 0-17.804-8.25-17.804-20.229 0-18.032 12.596-28.542 34.212-28.542 2.213 0 5.042.2 7.941.571.601-2.441.763-3.487.763-4.808 0-4.909-3.393-6.729-12.495-6.729-9.533-.108-17.396 2.271-20.63 3.321.204-1.225 2.704-16.637 2.704-16.637 9.709-2.858 16.116-3.929 23.316-3.929 16.741 0 25.604 7.517 25.583 21.704.033 3.821-.596 8.513-1.579 14.675-1.682 10.724-5.323 33.724-5.811 39.316zm-220.39-1.121c-5.338 1.679-9.496 2.408-14 2.408-9.962 0-15.399-5.726-15.399-16.268-.138-3.279 1.438-11.88 2.675-19.736 1.12-6.926 8.445-50.534 8.445-50.534h19.368l-2.26 11.212h9.941l-2.646 17.788h-9.975c-2.25 14.092-5.463 31.62-5.496 33.95 0 3.83 2.041 5.482 6.671 5.482 2.221 0 3.938-.216 5.254-.691zm59.391-.592c-6.65 2.033-13.079 3.012-19.879 3-21.685-.021-32.987-11.346-32.987-33.033 0-25.321 14.379-43.95 33.899-43.95 15.971 0 26.171 10.429 26.171 26.8 0 5.434-.7 10.733-2.384 18.212h-38.574c-1.306 10.741 5.569 15.222 16.837 15.222 6.93 0 13.188-1.435 20.138-4.677zm-10.891-43.912c.116-1.538 2.06-13.217-9.013-13.217-6.167 0-10.579 4.717-12.375 13.217zm-123.42-5.005c0 9.367 4.542 15.818 14.842 20.675 7.892 3.709 9.112 4.812 9.112 8.172 0 4.616-3.483 6.699-11.188 6.699-5.816 0-11.225-.908-17.467-2.921 0 0-2.554 16.321-2.671 17.101 4.421.967 8.375 1.85 20.275 2.191 20.566 0 30.059-7.829 30.059-24.746 0-10.18-3.971-16.15-13.737-20.637-8.167-3.759-9.113-4.584-9.113-8.046 0-4 3.246-6.059 9.542-6.059 3.821 0 9.046.421 14.004 1.125l2.771-17.179c-5.042-.8-12.692-1.441-17.146-1.441-21.804 0-29.346 11.379-29.283 25.066m398.45 50.63h-18.438l.917-6.893c-5.347 5.717-10.825 8.18-17.968 8.18-14.166 0-23.528-12.213-23.528-30.726 0-24.63 14.521-45.392 31.708-45.392 7.559 0 13.279 3.087 18.604 10.096l4.325-26.308h19.221zm-28.746-17.109c9.075 0 15.45-10.283 15.45-24.953 0-9.405-3.629-14.509-10.325-14.509-8.837 0-15.115 10.315-15.115 24.875-.001 9.686 3.357 14.587 9.99 14.587zm-56.842-56.929c-2.441 22.917-6.773 46.13-10.162 69.063l-.892 4.976h19.491c6.972-45.275 8.658-54.117 19.588-53.009 1.742-9.267 4.982-17.383 7.399-21.479-8.163-1.7-12.721 2.913-18.688 11.675.471-3.788 1.333-7.467 1.162-11.225zm-160.42 0c-2.446 22.917-6.779 46.13-10.167 69.063l-.888 4.976h19.5c6.963-45.275 8.646-54.117 19.57-53.009 1.75-9.267 4.991-17.383 7.399-21.479-8.154-1.7-12.717 2.913-18.679 11.675.471-3.788 1.324-7.467 1.162-11.225zm254.57 68.241c-.004-3.199 2.586-5.795 5.784-5.799h.012c3.197-.004 5.793 2.586 5.796 5.783v.016c-.001 3.201-2.595 5.795-5.796 5.797-3.201-.002-5.795-2.596-5.796-5.797zm5.796 4.405c2.431.002 4.402-1.969 4.403-4.399v-.004c.003-2.433-1.968-4.406-4.399-4.408h-.004c-2.435.001-4.407 1.974-4.408 4.408.002 2.432 1.975 4.403 4.408 4.403zm-.784-1.871h-1.188v-5.082h2.153c.446 0 .909.009 1.296.254.417.283.654.767.654 1.274 0 .575-.337 1.112-.888 1.317l.941 2.236h-1.32l-.779-2.009h-.87zm0-2.879h.653c.246 0 .513.019.729-.1.196-.125.296-.361.296-.588-.009-.21-.114-.404-.287-.523-.204-.117-.542-.084-.763-.084h-.629z"
                                                    fill="#fff"
                                                ></path>
                                            </svg>
                                            <span>••• 443</span>
                                        </td>
                                        <td
                                            class="p-4 whitespace-nowrap"
                                        >
                                            <span
                                                class="bg-orange-100 text-orange-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-md border border-orange-100 dark:bg-gray-700 dark:border-orange-300 dark:text-orange-300"
                                                >In review</span
                                            >
                                        </td>
                                    </tr>

                                    <tr>
                                        <td
                                            class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white"
                                        >
                                            Payment from
                                            <span
                                                class="font-semibold"
                                                >Lana
                                                Lysle</span
                                            >
                                        </td>
                                        <td
                                            class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400"
                                        >
                                            Apr 6 ,2021
                                        </td>
                                        <td
                                            class="p-4 text-sm font-semibold text-gray-900 whitespace-nowrap dark:text-white"
                                        >
                                            $1437
                                        </td>
                                        <td
                                            class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400"
                                        >
                                            0023568934
                                        </td>
                                        <td
                                            class="inline-flex items-center p-4 space-x-2 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400"
                                        >
                                            <svg
                                                class="w-7 h-7"
                                                aria-hidden="true"
                                                enable-background="new 0 0 780 500"
                                                viewBox="0 0 780 500"
                                                xmlns="http://www.w3.org/2000/svg"
                                            >
                                                <path
                                                    d="m449.01 250c0 99.143-80.371 179.5-179.51 179.5s-179.5-80.361-179.5-179.5c0-99.133 80.362-179.5 179.5-179.5 99.137 0 179.51 80.371 179.51 179.5"
                                                    fill="#d9222a"
                                                ></path>
                                                <path
                                                    d="m510.49 70.496c-46.379 0-88.643 17.596-120.5 46.467-6.49 5.889-12.548 12.237-18.125 18.996h36.267c4.965 6.037 9.536 12.387 13.685 19.012h-63.635c-3.827 6.122-7.281 12.469-10.342 19.008h84.313c2.894 6.185 5.431 12.53 7.601 19.004h-99.513c-2.09 6.234-3.832 12.58-5.217 19.008h109.94c2.689 12.49 4.045 25.231 4.042 38.008 0 19.935-3.254 39.112-9.254 57.021h-99.513c2.164 6.477 4.7 12.824 7.596 19.008h84.316c-3.063 6.541-6.519 12.889-10.347 19.013h-63.625c4.147 6.62 8.719 12.966 13.685 18.996h36.259c-5.57 6.772-11.63 13.127-18.13 19.013 31.857 28.866 74.117 46.454 120.5 46.454 99.139 0 179.51-80.361 179.51-179.5 0-99.129-80.371-179.5-179.51-179.5"
                                                    fill="#ee9f2d"
                                                ></path>
                                                <path
                                                    d="m666.07 350.06c0-3.199 2.592-5.801 5.796-5.801s5.796 2.602 5.796 5.801-2.592 5.801-5.796 5.801-5.796-2.602-5.796-5.801zm5.796 4.408c2.434-.001 4.407-1.974 4.408-4.408 0-2.432-1.971-4.402-4.402-4.404h-.006c-2.429-.003-4.4 1.963-4.404 4.391v.014c-.002 2.433 1.968 4.406 4.4 4.408.001-.001.003-.001.004-.001zm-.783-1.86h-1.187v-5.096h2.149c.45 0 .908 0 1.305.254.413.279.646.771.646 1.279 0 .571-.338 1.104-.884 1.312l.938 2.25h-1.315l-.779-2.017h-.871zm0-2.89h.658c.246 0 .505.021.726-.1.195-.125.296-.359.296-.584-.005-.209-.112-.402-.288-.518-.207-.129-.536-.101-.758-.101h-.634zm-443.5-80.063c-2.046-.238-2.945-.301-4.35-.301-11.046 0-16.638 3.787-16.638 11.268 0 4.611 2.729 7.545 6.987 7.545 7.939 0 13.659-7.559 14.001-18.512zm14.171 32.996h-16.146l.371-7.676c-4.926 6.065-11.496 8.949-20.426 8.949-10.563 0-17.804-8.25-17.804-20.229 0-18.024 12.596-28.541 34.217-28.541 2.208 0 5.042.199 7.941.57.604-2.441.763-3.488.763-4.801 0-4.908-3.396-6.737-12.5-6.737-9.533-.108-17.396 2.271-20.625 3.333.204-1.229 2.7-16.659 2.7-16.659 9.712-2.846 16.116-3.917 23.325-3.917 16.732 0 25.596 7.513 25.579 21.712.033 3.805-.597 8.5-1.579 14.671-1.691 10.734-5.32 33.721-5.816 39.325zm-62.158 0h-19.487l11.162-69.997-24.925 69.997h-13.279l-1.642-69.597-11.733 69.597h-18.242l15.237-91.056h28.021l1.7 50.968 17.092-50.968h31.167zm354.97-32.996c-2.037-.238-2.941-.301-4.342-.301-11.041 0-16.634 3.787-16.634 11.268 0 4.611 2.726 7.545 6.983 7.545 7.94 0 13.664-7.559 13.993-18.512zm14.184 32.996h-16.146l.366-7.676c-4.926 6.065-11.5 8.949-20.422 8.949-10.565 0-17.8-8.25-17.8-20.229 0-18.024 12.588-28.541 34.213-28.541 2.208 0 5.037.199 7.934.57.604-2.441.763-3.488.763-4.801 0-4.908-3.392-6.737-12.496-6.737-9.533-.108-17.387 2.271-20.629 3.333.204-1.229 2.709-16.659 2.709-16.659 9.712-2.846 16.112-3.917 23.313-3.917 16.74 0 25.604 7.513 25.587 21.712.032 3.805-.597 8.5-1.579 14.671-1.684 10.734-5.321 33.721-5.813 39.325zm-220.39-1.125c-5.333 1.679-9.491 2.398-14 2.398-9.962 0-15.399-5.725-15.399-16.267-.142-3.271 1.433-11.88 2.671-19.737 1.125-6.917 8.449-50.529 8.449-50.529h19.371l-2.263 11.208h11.699l-2.642 17.796h-11.742c-2.25 14.083-5.454 31.625-5.491 33.95 0 3.816 2.037 5.483 6.671 5.483 2.221 0 3.94-.227 5.254-.7zm59.392-.6c-6.654 2.034-13.075 3.017-19.879 3-21.684-.021-32.987-11.346-32.987-33.032 0-25.313 14.38-43.947 33.899-43.947 15.971 0 26.171 10.433 26.171 26.796 0 5.429-.7 10.729-2.388 18.212h-38.574c-1.305 10.741 5.57 15.217 16.837 15.217 6.935 0 13.188-1.429 20.142-4.663zm-10.888-43.9c.107-1.543 2.055-13.217-9.013-13.217-6.171 0-10.583 4.704-12.38 13.217zm-123.42-5.017c0 9.367 4.542 15.826 14.842 20.676 7.892 3.709 9.112 4.81 9.112 8.17 0 4.617-3.479 6.701-11.191 6.701-5.813 0-11.221-.908-17.458-2.922 0 0-2.563 16.321-2.68 17.102 4.43.967 8.38 1.861 20.279 2.19 20.563 0 30.059-7.829 30.059-24.75 0-10.175-3.976-16.146-13.737-20.634-8.171-3.75-9.108-4.587-9.108-8.045 0-4.004 3.237-6.046 9.537-6.046 3.825 0 9.05.408 14 1.112l2.775-17.175c-5.046-.8-12.696-1.442-17.15-1.442-21.801.001-29.347 11.388-29.28 25.063m229.09-23.116c5.412 0 10.458 1.421 17.412 4.921l3.188-19.763c-2.854-1.121-12.904-7.7-21.417-7.7-13.041 0-24.065 6.471-31.82 17.15-11.309-3.746-15.958 3.825-21.657 11.367l-5.063 1.179c.383-2.483.729-4.95.612-7.446h-17.896c-2.445 22.917-6.778 46.128-10.171 69.075l-.884 4.976h19.496c3.254-21.143 5.037-34.68 6.121-43.842l7.341-4.084c1.097-4.078 4.529-5.458 11.417-5.291-.926 5.008-1.389 10.091-1.383 15.184 0 24.225 13.07 39.308 34.05 39.308 5.404 0 10.041-.712 17.221-2.658l3.43-20.759c-6.458 3.181-11.759 4.677-16.559 4.677-11.329 0-18.184-8.363-18.184-22.185 0-20.051 10.196-34.109 24.746-34.109"
                                                ></path>
                                                <path
                                                    d="m185.21 297.24h-19.491l11.171-69.988-24.926 69.988h-13.283l-1.642-69.588-11.733 69.588h-18.241l15.237-91.042h28.021l.788 56.362 18.904-56.362h30.267z"
                                                    fill="#fff"
                                                ></path>
                                                <path
                                                    d="m647.52 211.6-4.321 26.309c-5.329-7.013-11.054-12.088-18.612-12.088-9.833 0-18.783 7.455-24.642 18.425-8.158-1.692-16.597-4.563-16.597-4.563l-.004.067c.658-6.134.921-9.875.862-11.146h-17.9c-2.438 22.917-6.771 46.128-10.157 69.075l-.893 4.976h19.492c2.633-17.096 4.648-31.291 6.133-42.551 6.658-6.016 9.992-11.266 16.721-10.916-2.979 7.205-4.725 15.503-4.725 24.017 0 18.513 9.366 30.725 23.533 30.725 7.142 0 12.621-2.462 17.967-8.171l-.913 6.884h18.435l14.842-91.042zm-24.371 73.941c-6.634 0-9.983-4.908-9.983-14.596 0-14.555 6.271-24.875 15.112-24.875 6.695 0 10.32 5.104 10.32 14.509.001 14.679-6.37 24.962-15.449 24.962z"
                                                ></path>
                                                <path
                                                    d="m233.19 264.26c-2.042-.236-2.946-.299-4.346-.299-11.046 0-16.634 3.787-16.634 11.266 0 4.604 2.729 7.547 6.979 7.547 7.947-.001 13.668-7.559 14.001-18.514zm14.178 32.984h-16.146l.367-7.663c-4.921 6.054-11.5 8.95-20.421 8.95-10.567 0-17.805-8.25-17.805-20.229 0-18.032 12.592-28.542 34.217-28.542 2.208 0 5.042.2 7.938.571.604-2.441.763-3.487.763-4.808 0-4.909-3.392-6.729-12.496-6.729-9.537-.108-17.396 2.271-20.629 3.321.204-1.225 2.7-16.637 2.7-16.637 9.708-2.858 16.12-3.929 23.32-3.929 16.737 0 25.604 7.517 25.588 21.704.029 3.821-.604 8.513-1.584 14.675-1.687 10.724-5.319 33.724-5.812 39.316zm261.38-88.592-3.191 19.767c-6.95-3.496-12-4.92-17.407-4.92-14.551 0-24.75 14.058-24.75 34.106 0 13.821 6.857 22.181 18.184 22.181 4.8 0 10.096-1.492 16.554-4.675l-3.421 20.75c-7.184 1.957-11.816 2.67-17.225 2.67-20.977 0-34.051-15.084-34.051-39.309 0-32.55 18.059-55.3 43.888-55.3 8.507.001 18.561 3.609 21.419 4.73m31.443 55.608c-2.041-.236-2.941-.299-4.347-.299-11.041 0-16.633 3.787-16.633 11.266 0 4.604 2.729 7.547 6.983 7.547 7.938-.001 13.663-7.559 13.997-18.514zm14.178 32.984h-16.15l.371-7.663c-4.925 6.054-11.5 8.95-20.421 8.95-10.563 0-17.804-8.25-17.804-20.229 0-18.032 12.596-28.542 34.212-28.542 2.213 0 5.042.2 7.941.571.601-2.441.763-3.487.763-4.808 0-4.909-3.393-6.729-12.495-6.729-9.533-.108-17.396 2.271-20.63 3.321.204-1.225 2.704-16.637 2.704-16.637 9.709-2.858 16.116-3.929 23.316-3.929 16.741 0 25.604 7.517 25.583 21.704.033 3.821-.596 8.513-1.579 14.675-1.682 10.724-5.323 33.724-5.811 39.316zm-220.39-1.121c-5.338 1.679-9.496 2.408-14 2.408-9.962 0-15.399-5.726-15.399-16.268-.138-3.279 1.438-11.88 2.675-19.736 1.12-6.926 8.445-50.534 8.445-50.534h19.368l-2.26 11.212h9.941l-2.646 17.788h-9.975c-2.25 14.092-5.463 31.62-5.496 33.95 0 3.83 2.041 5.482 6.671 5.482 2.221 0 3.938-.216 5.254-.691zm59.391-.592c-6.65 2.033-13.079 3.012-19.879 3-21.685-.021-32.987-11.346-32.987-33.033 0-25.321 14.379-43.95 33.899-43.95 15.971 0 26.171 10.429 26.171 26.8 0 5.434-.7 10.733-2.384 18.212h-38.574c-1.306 10.741 5.569 15.222 16.837 15.222 6.93 0 13.188-1.435 20.138-4.677zm-10.891-43.912c.116-1.538 2.06-13.217-9.013-13.217-6.167 0-10.579 4.717-12.375 13.217zm-123.42-5.005c0 9.367 4.542 15.818 14.842 20.675 7.892 3.709 9.112 4.812 9.112 8.172 0 4.616-3.483 6.699-11.188 6.699-5.816 0-11.225-.908-17.467-2.921 0 0-2.554 16.321-2.671 17.101 4.421.967 8.375 1.85 20.275 2.191 20.566 0 30.059-7.829 30.059-24.746 0-10.18-3.971-16.15-13.737-20.637-8.167-3.759-9.113-4.584-9.113-8.046 0-4 3.246-6.059 9.542-6.059 3.821 0 9.046.421 14.004 1.125l2.771-17.179c-5.042-.8-12.692-1.441-17.146-1.441-21.804 0-29.346 11.379-29.283 25.066m398.45 50.63h-18.438l.917-6.893c-5.347 5.717-10.825 8.18-17.968 8.18-14.166 0-23.528-12.213-23.528-30.726 0-24.63 14.521-45.392 31.708-45.392 7.559 0 13.279 3.087 18.604 10.096l4.325-26.308h19.221zm-28.746-17.109c9.075 0 15.45-10.283 15.45-24.953 0-9.405-3.629-14.509-10.325-14.509-8.837 0-15.115 10.315-15.115 24.875-.001 9.686 3.357 14.587 9.99 14.587zm-56.842-56.929c-2.441 22.917-6.773 46.13-10.162 69.063l-.892 4.976h19.491c6.972-45.275 8.658-54.117 19.588-53.009 1.742-9.267 4.982-17.383 7.399-21.479-8.163-1.7-12.721 2.913-18.688 11.675.471-3.788 1.333-7.467 1.162-11.225zm-160.42 0c-2.446 22.917-6.779 46.13-10.167 69.063l-.888 4.976h19.5c6.963-45.275 8.646-54.117 19.57-53.009 1.75-9.267 4.991-17.383 7.399-21.479-8.154-1.7-12.717 2.913-18.679 11.675.471-3.788 1.324-7.467 1.162-11.225zm254.57 68.241c-.004-3.199 2.586-5.795 5.784-5.799h.012c3.197-.004 5.793 2.586 5.796 5.783v.016c-.001 3.201-2.595 5.795-5.796 5.797-3.201-.002-5.795-2.596-5.796-5.797zm5.796 4.405c2.431.002 4.402-1.969 4.403-4.399v-.004c.003-2.433-1.968-4.406-4.399-4.408h-.004c-2.435.001-4.407 1.974-4.408 4.408.002 2.432 1.975 4.403 4.408 4.403zm-.784-1.871h-1.188v-5.082h2.153c.446 0 .909.009 1.296.254.417.283.654.767.654 1.274 0 .575-.337 1.112-.888 1.317l.941 2.236h-1.32l-.779-2.009h-.87zm0-2.879h.653c.246 0 .513.019.729-.1.196-.125.296-.361.296-.588-.009-.21-.114-.404-.287-.523-.204-.117-.542-.084-.763-.084h-.629z"
                                                    fill="#fff"
                                                ></path>
                                            </svg>
                                            <span>••• 223</span>
                                        </td>
                                        <td
                                            class="p-4 whitespace-nowrap"
                                        >
                                            <span
                                                class="bg-orange-100 text-orange-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-md border border-orange-100 dark:bg-gray-700 dark:border-orange-300 dark:text-orange-300"
                                                >In review</span
                                            >
                                        </td>
                                    </tr>
                                    <tr
                                        class="bg-gray-50 dark:bg-gray-700"
                                    >
                                        <td
                                            class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white"
                                        >
                                            Payment to
                                            <span
                                                class="font-semibold"
                                                >Joseph
                                                Mcfall</span
                                            >
                                        </td>
                                        <td
                                            class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400"
                                        >
                                            Apr 1 ,2021
                                        </td>
                                        <td
                                            class="p-4 text-sm font-semibold text-gray-900 whitespace-nowrap dark:text-white"
                                        >
                                            $980
                                        </td>
                                        <td
                                            class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400"
                                        >
                                            0057568935
                                        </td>
                                        <td
                                            class="inline-flex items-center p-4 space-x-2 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400"
                                        >
                                            <svg
                                                class="w-6 h-6"
                                                aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 256 83"
                                            >
                                                <defs>
                                                    <linearGradient
                                                        id="logosVisa0"
                                                        x1="45.974%"
                                                        x2="54.877%"
                                                        y1="-2.006%"
                                                        y2="100%"
                                                    >
                                                        <stop
                                                            offset="0%"
                                                            stop-color="#222357"
                                                        ></stop>
                                                        <stop
                                                            offset="100%"
                                                            stop-color="#254AA5"
                                                        ></stop>
                                                    </linearGradient>
                                                </defs>
                                                <path
                                                    fill="url(#logosVisa0)"
                                                    d="M132.397 56.24c-.146-11.516 10.263-17.942 18.104-21.763c8.056-3.92 10.762-6.434 10.73-9.94c-.06-5.365-6.426-7.733-12.383-7.825c-10.393-.161-16.436 2.806-21.24 5.05l-3.744-17.519c4.82-2.221 13.745-4.158 23-4.243c21.725 0 35.938 10.724 36.015 27.351c.085 21.102-29.188 22.27-28.988 31.702c.069 2.86 2.798 5.912 8.778 6.688c2.96.392 11.131.692 20.395-3.574l3.636 16.95c-4.982 1.814-11.385 3.551-19.357 3.551c-20.448 0-34.83-10.87-34.946-26.428m89.241 24.968c-3.967 0-7.31-2.314-8.802-5.865L181.803 1.245h21.709l4.32 11.939h26.528l2.506-11.939H256l-16.697 79.963h-17.665m3.037-21.601l6.265-30.027h-17.158l10.893 30.027m-118.599 21.6L88.964 1.246h20.687l17.104 79.963h-20.679m-30.603 0L53.941 26.782l-8.71 46.277c-1.022 5.166-5.058 8.149-9.54 8.149H.493L0 78.886c7.226-1.568 15.436-4.097 20.41-6.803c3.044-1.653 3.912-3.098 4.912-7.026L41.819 1.245H63.68l33.516 79.963H75.473"
                                                    transform="matrix(1 0 0 -1 0 82.668)"
                                                ></path>
                                            </svg>
                                            <span>••• 363</span>
                                        </td>
                                        <td
                                            class="p-4 whitespace-nowrap"
                                        >
                                            <span
                                                class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-md dark:bg-gray-700 dark:text-green-400 border border-green-100 dark:border-green-500"
                                                >Completed</span
                                            >
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white"
                                        >
                                            Payment from
                                            <span
                                                class="font-semibold"
                                                >Alphabet
                                                LLC</span
                                            >
                                        </td>
                                        <td
                                            class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400"
                                        >
                                            Mar 23 ,2021
                                        </td>
                                        <td
                                            class="p-4 text-sm font-semibold text-gray-900 whitespace-nowrap dark:text-white"
                                        >
                                            $11,436
                                        </td>
                                        <td
                                            class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400"
                                        >
                                            00836143841
                                        </td>
                                        <td
                                            class="inline-flex items-center p-4 space-x-2 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400"
                                        >
                                            <svg
                                                class="w-7 h-7"
                                                aria-hidden="true"
                                                enable-background="new 0 0 780 500"
                                                viewBox="0 0 780 500"
                                                xmlns="http://www.w3.org/2000/svg"
                                            >
                                                <path
                                                    d="m449.01 250c0 99.143-80.371 179.5-179.51 179.5s-179.5-80.361-179.5-179.5c0-99.133 80.362-179.5 179.5-179.5 99.137 0 179.51 80.371 179.51 179.5"
                                                    fill="#d9222a"
                                                ></path>
                                                <path
                                                    d="m510.49 70.496c-46.379 0-88.643 17.596-120.5 46.467-6.49 5.889-12.548 12.237-18.125 18.996h36.267c4.965 6.037 9.536 12.387 13.685 19.012h-63.635c-3.827 6.122-7.281 12.469-10.342 19.008h84.313c2.894 6.185 5.431 12.53 7.601 19.004h-99.513c-2.09 6.234-3.832 12.58-5.217 19.008h109.94c2.689 12.49 4.045 25.231 4.042 38.008 0 19.935-3.254 39.112-9.254 57.021h-99.513c2.164 6.477 4.7 12.824 7.596 19.008h84.316c-3.063 6.541-6.519 12.889-10.347 19.013h-63.625c4.147 6.62 8.719 12.966 13.685 18.996h36.259c-5.57 6.772-11.63 13.127-18.13 19.013 31.857 28.866 74.117 46.454 120.5 46.454 99.139 0 179.51-80.361 179.51-179.5 0-99.129-80.371-179.5-179.51-179.5"
                                                    fill="#ee9f2d"
                                                ></path>
                                                <path
                                                    d="m666.07 350.06c0-3.199 2.592-5.801 5.796-5.801s5.796 2.602 5.796 5.801-2.592 5.801-5.796 5.801-5.796-2.602-5.796-5.801zm5.796 4.408c2.434-.001 4.407-1.974 4.408-4.408 0-2.432-1.971-4.402-4.402-4.404h-.006c-2.429-.003-4.4 1.963-4.404 4.391v.014c-.002 2.433 1.968 4.406 4.4 4.408.001-.001.003-.001.004-.001zm-.783-1.86h-1.187v-5.096h2.149c.45 0 .908 0 1.305.254.413.279.646.771.646 1.279 0 .571-.338 1.104-.884 1.312l.938 2.25h-1.315l-.779-2.017h-.871zm0-2.89h.658c.246 0 .505.021.726-.1.195-.125.296-.359.296-.584-.005-.209-.112-.402-.288-.518-.207-.129-.536-.101-.758-.101h-.634zm-443.5-80.063c-2.046-.238-2.945-.301-4.35-.301-11.046 0-16.638 3.787-16.638 11.268 0 4.611 2.729 7.545 6.987 7.545 7.939 0 13.659-7.559 14.001-18.512zm14.171 32.996h-16.146l.371-7.676c-4.926 6.065-11.496 8.949-20.426 8.949-10.563 0-17.804-8.25-17.804-20.229 0-18.024 12.596-28.541 34.217-28.541 2.208 0 5.042.199 7.941.57.604-2.441.763-3.488.763-4.801 0-4.908-3.396-6.737-12.5-6.737-9.533-.108-17.396 2.271-20.625 3.333.204-1.229 2.7-16.659 2.7-16.659 9.712-2.846 16.116-3.917 23.325-3.917 16.732 0 25.596 7.513 25.579 21.712.033 3.805-.597 8.5-1.579 14.671-1.691 10.734-5.32 33.721-5.816 39.325zm-62.158 0h-19.487l11.162-69.997-24.925 69.997h-13.279l-1.642-69.597-11.733 69.597h-18.242l15.237-91.056h28.021l1.7 50.968 17.092-50.968h31.167zm354.97-32.996c-2.037-.238-2.941-.301-4.342-.301-11.041 0-16.634 3.787-16.634 11.268 0 4.611 2.726 7.545 6.983 7.545 7.94 0 13.664-7.559 13.993-18.512zm14.184 32.996h-16.146l.366-7.676c-4.926 6.065-11.5 8.949-20.422 8.949-10.565 0-17.8-8.25-17.8-20.229 0-18.024 12.588-28.541 34.213-28.541 2.208 0 5.037.199 7.934.57.604-2.441.763-3.488.763-4.801 0-4.908-3.392-6.737-12.496-6.737-9.533-.108-17.387 2.271-20.629 3.333.204-1.229 2.709-16.659 2.709-16.659 9.712-2.846 16.112-3.917 23.313-3.917 16.74 0 25.604 7.513 25.587 21.712.032 3.805-.597 8.5-1.579 14.671-1.684 10.734-5.321 33.721-5.813 39.325zm-220.39-1.125c-5.333 1.679-9.491 2.398-14 2.398-9.962 0-15.399-5.725-15.399-16.267-.142-3.271 1.433-11.88 2.671-19.737 1.125-6.917 8.449-50.529 8.449-50.529h19.371l-2.263 11.208h11.699l-2.642 17.796h-11.742c-2.25 14.083-5.454 31.625-5.491 33.95 0 3.816 2.037 5.483 6.671 5.483 2.221 0 3.94-.227 5.254-.7zm59.392-.6c-6.654 2.034-13.075 3.017-19.879 3-21.684-.021-32.987-11.346-32.987-33.032 0-25.313 14.38-43.947 33.899-43.947 15.971 0 26.171 10.433 26.171 26.796 0 5.429-.7 10.729-2.388 18.212h-38.574c-1.305 10.741 5.57 15.217 16.837 15.217 6.935 0 13.188-1.429 20.142-4.663zm-10.888-43.9c.107-1.543 2.055-13.217-9.013-13.217-6.171 0-10.583 4.704-12.38 13.217zm-123.42-5.017c0 9.367 4.542 15.826 14.842 20.676 7.892 3.709 9.112 4.81 9.112 8.17 0 4.617-3.479 6.701-11.191 6.701-5.813 0-11.221-.908-17.458-2.922 0 0-2.563 16.321-2.68 17.102 4.43.967 8.38 1.861 20.279 2.19 20.563 0 30.059-7.829 30.059-24.75 0-10.175-3.976-16.146-13.737-20.634-8.171-3.75-9.108-4.587-9.108-8.045 0-4.004 3.237-6.046 9.537-6.046 3.825 0 9.05.408 14 1.112l2.775-17.175c-5.046-.8-12.696-1.442-17.15-1.442-21.801.001-29.347 11.388-29.28 25.063m229.09-23.116c5.412 0 10.458 1.421 17.412 4.921l3.188-19.763c-2.854-1.121-12.904-7.7-21.417-7.7-13.041 0-24.065 6.471-31.82 17.15-11.309-3.746-15.958 3.825-21.657 11.367l-5.063 1.179c.383-2.483.729-4.95.612-7.446h-17.896c-2.445 22.917-6.778 46.128-10.171 69.075l-.884 4.976h19.496c3.254-21.143 5.037-34.68 6.121-43.842l7.341-4.084c1.097-4.078 4.529-5.458 11.417-5.291-.926 5.008-1.389 10.091-1.383 15.184 0 24.225 13.07 39.308 34.05 39.308 5.404 0 10.041-.712 17.221-2.658l3.43-20.759c-6.458 3.181-11.759 4.677-16.559 4.677-11.329 0-18.184-8.363-18.184-22.185 0-20.051 10.196-34.109 24.746-34.109"
                                                ></path>
                                                <path
                                                    d="m185.21 297.24h-19.491l11.171-69.988-24.926 69.988h-13.283l-1.642-69.588-11.733 69.588h-18.241l15.237-91.042h28.021l.788 56.362 18.904-56.362h30.267z"
                                                    fill="#fff"
                                                ></path>
                                                <path
                                                    d="m647.52 211.6-4.321 26.309c-5.329-7.013-11.054-12.088-18.612-12.088-9.833 0-18.783 7.455-24.642 18.425-8.158-1.692-16.597-4.563-16.597-4.563l-.004.067c.658-6.134.921-9.875.862-11.146h-17.9c-2.438 22.917-6.771 46.128-10.157 69.075l-.893 4.976h19.492c2.633-17.096 4.648-31.291 6.133-42.551 6.658-6.016 9.992-11.266 16.721-10.916-2.979 7.205-4.725 15.503-4.725 24.017 0 18.513 9.366 30.725 23.533 30.725 7.142 0 12.621-2.462 17.967-8.171l-.913 6.884h18.435l14.842-91.042zm-24.371 73.941c-6.634 0-9.983-4.908-9.983-14.596 0-14.555 6.271-24.875 15.112-24.875 6.695 0 10.32 5.104 10.32 14.509.001 14.679-6.37 24.962-15.449 24.962z"
                                                ></path>
                                                <path
                                                    d="m233.19 264.26c-2.042-.236-2.946-.299-4.346-.299-11.046 0-16.634 3.787-16.634 11.266 0 4.604 2.729 7.547 6.979 7.547 7.947-.001 13.668-7.559 14.001-18.514zm14.178 32.984h-16.146l.367-7.663c-4.921 6.054-11.5 8.95-20.421 8.95-10.567 0-17.805-8.25-17.805-20.229 0-18.032 12.592-28.542 34.217-28.542 2.208 0 5.042.2 7.938.571.604-2.441.763-3.487.763-4.808 0-4.909-3.392-6.729-12.496-6.729-9.537-.108-17.396 2.271-20.629 3.321.204-1.225 2.7-16.637 2.7-16.637 9.708-2.858 16.12-3.929 23.32-3.929 16.737 0 25.604 7.517 25.588 21.704.029 3.821-.604 8.513-1.584 14.675-1.687 10.724-5.319 33.724-5.812 39.316zm261.38-88.592-3.191 19.767c-6.95-3.496-12-4.92-17.407-4.92-14.551 0-24.75 14.058-24.75 34.106 0 13.821 6.857 22.181 18.184 22.181 4.8 0 10.096-1.492 16.554-4.675l-3.421 20.75c-7.184 1.957-11.816 2.67-17.225 2.67-20.977 0-34.051-15.084-34.051-39.309 0-32.55 18.059-55.3 43.888-55.3 8.507.001 18.561 3.609 21.419 4.73m31.443 55.608c-2.041-.236-2.941-.299-4.347-.299-11.041 0-16.633 3.787-16.633 11.266 0 4.604 2.729 7.547 6.983 7.547 7.938-.001 13.663-7.559 13.997-18.514zm14.178 32.984h-16.15l.371-7.663c-4.925 6.054-11.5 8.95-20.421 8.95-10.563 0-17.804-8.25-17.804-20.229 0-18.032 12.596-28.542 34.212-28.542 2.213 0 5.042.2 7.941.571.601-2.441.763-3.487.763-4.808 0-4.909-3.393-6.729-12.495-6.729-9.533-.108-17.396 2.271-20.63 3.321.204-1.225 2.704-16.637 2.704-16.637 9.709-2.858 16.116-3.929 23.316-3.929 16.741 0 25.604 7.517 25.583 21.704.033 3.821-.596 8.513-1.579 14.675-1.682 10.724-5.323 33.724-5.811 39.316zm-220.39-1.121c-5.338 1.679-9.496 2.408-14 2.408-9.962 0-15.399-5.726-15.399-16.268-.138-3.279 1.438-11.88 2.675-19.736 1.12-6.926 8.445-50.534 8.445-50.534h19.368l-2.26 11.212h9.941l-2.646 17.788h-9.975c-2.25 14.092-5.463 31.62-5.496 33.95 0 3.83 2.041 5.482 6.671 5.482 2.221 0 3.938-.216 5.254-.691zm59.391-.592c-6.65 2.033-13.079 3.012-19.879 3-21.685-.021-32.987-11.346-32.987-33.033 0-25.321 14.379-43.95 33.899-43.95 15.971 0 26.171 10.429 26.171 26.8 0 5.434-.7 10.733-2.384 18.212h-38.574c-1.306 10.741 5.569 15.222 16.837 15.222 6.93 0 13.188-1.435 20.138-4.677zm-10.891-43.912c.116-1.538 2.06-13.217-9.013-13.217-6.167 0-10.579 4.717-12.375 13.217zm-123.42-5.005c0 9.367 4.542 15.818 14.842 20.675 7.892 3.709 9.112 4.812 9.112 8.172 0 4.616-3.483 6.699-11.188 6.699-5.816 0-11.225-.908-17.467-2.921 0 0-2.554 16.321-2.671 17.101 4.421.967 8.375 1.85 20.275 2.191 20.566 0 30.059-7.829 30.059-24.746 0-10.18-3.971-16.15-13.737-20.637-8.167-3.759-9.113-4.584-9.113-8.046 0-4 3.246-6.059 9.542-6.059 3.821 0 9.046.421 14.004 1.125l2.771-17.179c-5.042-.8-12.692-1.441-17.146-1.441-21.804 0-29.346 11.379-29.283 25.066m398.45 50.63h-18.438l.917-6.893c-5.347 5.717-10.825 8.18-17.968 8.18-14.166 0-23.528-12.213-23.528-30.726 0-24.63 14.521-45.392 31.708-45.392 7.559 0 13.279 3.087 18.604 10.096l4.325-26.308h19.221zm-28.746-17.109c9.075 0 15.45-10.283 15.45-24.953 0-9.405-3.629-14.509-10.325-14.509-8.837 0-15.115 10.315-15.115 24.875-.001 9.686 3.357 14.587 9.99 14.587zm-56.842-56.929c-2.441 22.917-6.773 46.13-10.162 69.063l-.892 4.976h19.491c6.972-45.275 8.658-54.117 19.588-53.009 1.742-9.267 4.982-17.383 7.399-21.479-8.163-1.7-12.721 2.913-18.688 11.675.471-3.788 1.333-7.467 1.162-11.225zm-160.42 0c-2.446 22.917-6.779 46.13-10.167 69.063l-.888 4.976h19.5c6.963-45.275 8.646-54.117 19.57-53.009 1.75-9.267 4.991-17.383 7.399-21.479-8.154-1.7-12.717 2.913-18.679 11.675.471-3.788 1.324-7.467 1.162-11.225zm254.57 68.241c-.004-3.199 2.586-5.795 5.784-5.799h.012c3.197-.004 5.793 2.586 5.796 5.783v.016c-.001 3.201-2.595 5.795-5.796 5.797-3.201-.002-5.795-2.596-5.796-5.797zm5.796 4.405c2.431.002 4.402-1.969 4.403-4.399v-.004c.003-2.433-1.968-4.406-4.399-4.408h-.004c-2.435.001-4.407 1.974-4.408 4.408.002 2.432 1.975 4.403 4.408 4.403zm-.784-1.871h-1.188v-5.082h2.153c.446 0 .909.009 1.296.254.417.283.654.767.654 1.274 0 .575-.337 1.112-.888 1.317l.941 2.236h-1.32l-.779-2.009h-.87zm0-2.879h.653c.246 0 .513.019.729-.1.196-.125.296-.361.296-.588-.009-.21-.114-.404-.287-.523-.204-.117-.542-.084-.763-.084h-.629z"
                                                    fill="#fff"
                                                ></path>
                                            </svg>
                                            <span>••• 771</span>
                                        </td>
                                        <td
                                            class="p-4 whitespace-nowrap"
                                        >
                                            <span
                                                class="bg-purple-100 text-purple-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-md border border-purple-100 dark:bg-gray-700 dark:border-purple-500 dark:text-purple-400"
                                                >In
                                                progress</span
                                            >
                                        </td>
                                    </tr>
                                    <tr
                                        class="bg-gray-50 dark:bg-gray-700"
                                    >
                                        <td
                                            class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white"
                                        >
                                            Payment from
                                            <span
                                                class="font-semibold"
                                                >Bonnie
                                                Green</span
                                            >
                                        </td>
                                        <td
                                            class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400"
                                        >
                                            Mar 23 ,2021
                                        </td>
                                        <td
                                            class="p-4 text-sm font-semibold text-gray-900 whitespace-nowrap dark:text-white"
                                        >
                                            $560
                                        </td>
                                        <td
                                            class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400"
                                        >
                                            0031568935
                                        </td>
                                        <td
                                            class="inline-flex items-center p-4 space-x-2 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400"
                                        >
                                            <svg
                                                class="w-7 h-7"
                                                aria-hidden="true"
                                                enable-background="new 0 0 780 500"
                                                viewBox="0 0 780 500"
                                                xmlns="http://www.w3.org/2000/svg"
                                            >
                                                <path
                                                    d="m449.01 250c0 99.143-80.371 179.5-179.51 179.5s-179.5-80.361-179.5-179.5c0-99.133 80.362-179.5 179.5-179.5 99.137 0 179.51 80.371 179.51 179.5"
                                                    fill="#d9222a"
                                                ></path>
                                                <path
                                                    d="m510.49 70.496c-46.379 0-88.643 17.596-120.5 46.467-6.49 5.889-12.548 12.237-18.125 18.996h36.267c4.965 6.037 9.536 12.387 13.685 19.012h-63.635c-3.827 6.122-7.281 12.469-10.342 19.008h84.313c2.894 6.185 5.431 12.53 7.601 19.004h-99.513c-2.09 6.234-3.832 12.58-5.217 19.008h109.94c2.689 12.49 4.045 25.231 4.042 38.008 0 19.935-3.254 39.112-9.254 57.021h-99.513c2.164 6.477 4.7 12.824 7.596 19.008h84.316c-3.063 6.541-6.519 12.889-10.347 19.013h-63.625c4.147 6.62 8.719 12.966 13.685 18.996h36.259c-5.57 6.772-11.63 13.127-18.13 19.013 31.857 28.866 74.117 46.454 120.5 46.454 99.139 0 179.51-80.361 179.51-179.5 0-99.129-80.371-179.5-179.51-179.5"
                                                    fill="#ee9f2d"
                                                ></path>
                                                <path
                                                    d="m666.07 350.06c0-3.199 2.592-5.801 5.796-5.801s5.796 2.602 5.796 5.801-2.592 5.801-5.796 5.801-5.796-2.602-5.796-5.801zm5.796 4.408c2.434-.001 4.407-1.974 4.408-4.408 0-2.432-1.971-4.402-4.402-4.404h-.006c-2.429-.003-4.4 1.963-4.404 4.391v.014c-.002 2.433 1.968 4.406 4.4 4.408.001-.001.003-.001.004-.001zm-.783-1.86h-1.187v-5.096h2.149c.45 0 .908 0 1.305.254.413.279.646.771.646 1.279 0 .571-.338 1.104-.884 1.312l.938 2.25h-1.315l-.779-2.017h-.871zm0-2.89h.658c.246 0 .505.021.726-.1.195-.125.296-.359.296-.584-.005-.209-.112-.402-.288-.518-.207-.129-.536-.101-.758-.101h-.634zm-443.5-80.063c-2.046-.238-2.945-.301-4.35-.301-11.046 0-16.638 3.787-16.638 11.268 0 4.611 2.729 7.545 6.987 7.545 7.939 0 13.659-7.559 14.001-18.512zm14.171 32.996h-16.146l.371-7.676c-4.926 6.065-11.496 8.949-20.426 8.949-10.563 0-17.804-8.25-17.804-20.229 0-18.024 12.596-28.541 34.217-28.541 2.208 0 5.042.199 7.941.57.604-2.441.763-3.488.763-4.801 0-4.908-3.396-6.737-12.5-6.737-9.533-.108-17.396 2.271-20.625 3.333.204-1.229 2.7-16.659 2.7-16.659 9.712-2.846 16.116-3.917 23.325-3.917 16.732 0 25.596 7.513 25.579 21.712.033 3.805-.597 8.5-1.579 14.671-1.691 10.734-5.32 33.721-5.816 39.325zm-62.158 0h-19.487l11.162-69.997-24.925 69.997h-13.279l-1.642-69.597-11.733 69.597h-18.242l15.237-91.056h28.021l1.7 50.968 17.092-50.968h31.167zm354.97-32.996c-2.037-.238-2.941-.301-4.342-.301-11.041 0-16.634 3.787-16.634 11.268 0 4.611 2.726 7.545 6.983 7.545 7.94 0 13.664-7.559 13.993-18.512zm14.184 32.996h-16.146l.366-7.676c-4.926 6.065-11.5 8.949-20.422 8.949-10.565 0-17.8-8.25-17.8-20.229 0-18.024 12.588-28.541 34.213-28.541 2.208 0 5.037.199 7.934.57.604-2.441.763-3.488.763-4.801 0-4.908-3.392-6.737-12.496-6.737-9.533-.108-17.387 2.271-20.629 3.333.204-1.229 2.709-16.659 2.709-16.659 9.712-2.846 16.112-3.917 23.313-3.917 16.74 0 25.604 7.513 25.587 21.712.032 3.805-.597 8.5-1.579 14.671-1.684 10.734-5.321 33.721-5.813 39.325zm-220.39-1.125c-5.333 1.679-9.491 2.398-14 2.398-9.962 0-15.399-5.725-15.399-16.267-.142-3.271 1.433-11.88 2.671-19.737 1.125-6.917 8.449-50.529 8.449-50.529h19.371l-2.263 11.208h11.699l-2.642 17.796h-11.742c-2.25 14.083-5.454 31.625-5.491 33.95 0 3.816 2.037 5.483 6.671 5.483 2.221 0 3.94-.227 5.254-.7zm59.392-.6c-6.654 2.034-13.075 3.017-19.879 3-21.684-.021-32.987-11.346-32.987-33.032 0-25.313 14.38-43.947 33.899-43.947 15.971 0 26.171 10.433 26.171 26.796 0 5.429-.7 10.729-2.388 18.212h-38.574c-1.305 10.741 5.57 15.217 16.837 15.217 6.935 0 13.188-1.429 20.142-4.663zm-10.888-43.9c.107-1.543 2.055-13.217-9.013-13.217-6.171 0-10.583 4.704-12.38 13.217zm-123.42-5.017c0 9.367 4.542 15.826 14.842 20.676 7.892 3.709 9.112 4.81 9.112 8.17 0 4.617-3.479 6.701-11.191 6.701-5.813 0-11.221-.908-17.458-2.922 0 0-2.563 16.321-2.68 17.102 4.43.967 8.38 1.861 20.279 2.19 20.563 0 30.059-7.829 30.059-24.75 0-10.175-3.976-16.146-13.737-20.634-8.171-3.75-9.108-4.587-9.108-8.045 0-4.004 3.237-6.046 9.537-6.046 3.825 0 9.05.408 14 1.112l2.775-17.175c-5.046-.8-12.696-1.442-17.15-1.442-21.801.001-29.347 11.388-29.28 25.063m229.09-23.116c5.412 0 10.458 1.421 17.412 4.921l3.188-19.763c-2.854-1.121-12.904-7.7-21.417-7.7-13.041 0-24.065 6.471-31.82 17.15-11.309-3.746-15.958 3.825-21.657 11.367l-5.063 1.179c.383-2.483.729-4.95.612-7.446h-17.896c-2.445 22.917-6.778 46.128-10.171 69.075l-.884 4.976h19.496c3.254-21.143 5.037-34.68 6.121-43.842l7.341-4.084c1.097-4.078 4.529-5.458 11.417-5.291-.926 5.008-1.389 10.091-1.383 15.184 0 24.225 13.07 39.308 34.05 39.308 5.404 0 10.041-.712 17.221-2.658l3.43-20.759c-6.458 3.181-11.759 4.677-16.559 4.677-11.329 0-18.184-8.363-18.184-22.185 0-20.051 10.196-34.109 24.746-34.109"
                                                ></path>
                                                <path
                                                    d="m185.21 297.24h-19.491l11.171-69.988-24.926 69.988h-13.283l-1.642-69.588-11.733 69.588h-18.241l15.237-91.042h28.021l.788 56.362 18.904-56.362h30.267z"
                                                    fill="#fff"
                                                ></path>
                                                <path
                                                    d="m647.52 211.6-4.321 26.309c-5.329-7.013-11.054-12.088-18.612-12.088-9.833 0-18.783 7.455-24.642 18.425-8.158-1.692-16.597-4.563-16.597-4.563l-.004.067c.658-6.134.921-9.875.862-11.146h-17.9c-2.438 22.917-6.771 46.128-10.157 69.075l-.893 4.976h19.492c2.633-17.096 4.648-31.291 6.133-42.551 6.658-6.016 9.992-11.266 16.721-10.916-2.979 7.205-4.725 15.503-4.725 24.017 0 18.513 9.366 30.725 23.533 30.725 7.142 0 12.621-2.462 17.967-8.171l-.913 6.884h18.435l14.842-91.042zm-24.371 73.941c-6.634 0-9.983-4.908-9.983-14.596 0-14.555 6.271-24.875 15.112-24.875 6.695 0 10.32 5.104 10.32 14.509.001 14.679-6.37 24.962-15.449 24.962z"
                                                ></path>
                                                <path
                                                    d="m233.19 264.26c-2.042-.236-2.946-.299-4.346-.299-11.046 0-16.634 3.787-16.634 11.266 0 4.604 2.729 7.547 6.979 7.547 7.947-.001 13.668-7.559 14.001-18.514zm14.178 32.984h-16.146l.367-7.663c-4.921 6.054-11.5 8.95-20.421 8.95-10.567 0-17.805-8.25-17.805-20.229 0-18.032 12.592-28.542 34.217-28.542 2.208 0 5.042.2 7.938.571.604-2.441.763-3.487.763-4.808 0-4.909-3.392-6.729-12.496-6.729-9.537-.108-17.396 2.271-20.629 3.321.204-1.225 2.7-16.637 2.7-16.637 9.708-2.858 16.12-3.929 23.32-3.929 16.737 0 25.604 7.517 25.588 21.704.029 3.821-.604 8.513-1.584 14.675-1.687 10.724-5.319 33.724-5.812 39.316zm261.38-88.592-3.191 19.767c-6.95-3.496-12-4.92-17.407-4.92-14.551 0-24.75 14.058-24.75 34.106 0 13.821 6.857 22.181 18.184 22.181 4.8 0 10.096-1.492 16.554-4.675l-3.421 20.75c-7.184 1.957-11.816 2.67-17.225 2.67-20.977 0-34.051-15.084-34.051-39.309 0-32.55 18.059-55.3 43.888-55.3 8.507.001 18.561 3.609 21.419 4.73m31.443 55.608c-2.041-.236-2.941-.299-4.347-.299-11.041 0-16.633 3.787-16.633 11.266 0 4.604 2.729 7.547 6.983 7.547 7.938-.001 13.663-7.559 13.997-18.514zm14.178 32.984h-16.15l.371-7.663c-4.925 6.054-11.5 8.95-20.421 8.95-10.563 0-17.804-8.25-17.804-20.229 0-18.032 12.596-28.542 34.212-28.542 2.213 0 5.042.2 7.941.571.601-2.441.763-3.487.763-4.808 0-4.909-3.393-6.729-12.495-6.729-9.533-.108-17.396 2.271-20.63 3.321.204-1.225 2.704-16.637 2.704-16.637 9.709-2.858 16.116-3.929 23.316-3.929 16.741 0 25.604 7.517 25.583 21.704.033 3.821-.596 8.513-1.579 14.675-1.682 10.724-5.323 33.724-5.811 39.316zm-220.39-1.121c-5.338 1.679-9.496 2.408-14 2.408-9.962 0-15.399-5.726-15.399-16.268-.138-3.279 1.438-11.88 2.675-19.736 1.12-6.926 8.445-50.534 8.445-50.534h19.368l-2.26 11.212h9.941l-2.646 17.788h-9.975c-2.25 14.092-5.463 31.62-5.496 33.95 0 3.83 2.041 5.482 6.671 5.482 2.221 0 3.938-.216 5.254-.691zm59.391-.592c-6.65 2.033-13.079 3.012-19.879 3-21.685-.021-32.987-11.346-32.987-33.033 0-25.321 14.379-43.95 33.899-43.95 15.971 0 26.171 10.429 26.171 26.8 0 5.434-.7 10.733-2.384 18.212h-38.574c-1.306 10.741 5.569 15.222 16.837 15.222 6.93 0 13.188-1.435 20.138-4.677zm-10.891-43.912c.116-1.538 2.06-13.217-9.013-13.217-6.167 0-10.579 4.717-12.375 13.217zm-123.42-5.005c0 9.367 4.542 15.818 14.842 20.675 7.892 3.709 9.112 4.812 9.112 8.172 0 4.616-3.483 6.699-11.188 6.699-5.816 0-11.225-.908-17.467-2.921 0 0-2.554 16.321-2.671 17.101 4.421.967 8.375 1.85 20.275 2.191 20.566 0 30.059-7.829 30.059-24.746 0-10.18-3.971-16.15-13.737-20.637-8.167-3.759-9.113-4.584-9.113-8.046 0-4 3.246-6.059 9.542-6.059 3.821 0 9.046.421 14.004 1.125l2.771-17.179c-5.042-.8-12.692-1.441-17.146-1.441-21.804 0-29.346 11.379-29.283 25.066m398.45 50.63h-18.438l.917-6.893c-5.347 5.717-10.825 8.18-17.968 8.18-14.166 0-23.528-12.213-23.528-30.726 0-24.63 14.521-45.392 31.708-45.392 7.559 0 13.279 3.087 18.604 10.096l4.325-26.308h19.221zm-28.746-17.109c9.075 0 15.45-10.283 15.45-24.953 0-9.405-3.629-14.509-10.325-14.509-8.837 0-15.115 10.315-15.115 24.875-.001 9.686 3.357 14.587 9.99 14.587zm-56.842-56.929c-2.441 22.917-6.773 46.13-10.162 69.063l-.892 4.976h19.491c6.972-45.275 8.658-54.117 19.588-53.009 1.742-9.267 4.982-17.383 7.399-21.479-8.163-1.7-12.721 2.913-18.688 11.675.471-3.788 1.333-7.467 1.162-11.225zm-160.42 0c-2.446 22.917-6.779 46.13-10.167 69.063l-.888 4.976h19.5c6.963-45.275 8.646-54.117 19.57-53.009 1.75-9.267 4.991-17.383 7.399-21.479-8.154-1.7-12.717 2.913-18.679 11.675.471-3.788 1.324-7.467 1.162-11.225zm254.57 68.241c-.004-3.199 2.586-5.795 5.784-5.799h.012c3.197-.004 5.793 2.586 5.796 5.783v.016c-.001 3.201-2.595 5.795-5.796 5.797-3.201-.002-5.795-2.596-5.796-5.797zm5.796 4.405c2.431.002 4.402-1.969 4.403-4.399v-.004c.003-2.433-1.968-4.406-4.399-4.408h-.004c-2.435.001-4.407 1.974-4.408 4.408.002 2.432 1.975 4.403 4.408 4.403zm-.784-1.871h-1.188v-5.082h2.153c.446 0 .909.009 1.296.254.417.283.654.767.654 1.274 0 .575-.337 1.112-.888 1.317l.941 2.236h-1.32l-.779-2.009h-.87zm0-2.879h.653c.246 0 .513.019.729-.1.196-.125.296-.361.296-.588-.009-.21-.114-.404-.287-.523-.204-.117-.542-.084-.763-.084h-.629z"
                                                    fill="#fff"
                                                ></path>
                                            </svg>
                                            <span>••• 023</span>
                                        </td>
                                        <td
                                            class="p-4 whitespace-nowrap"
                                        >
                                            <span
                                                class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-md dark:bg-gray-700 dark:text-green-400 border border-green-100 dark:border-green-500"
                                                >Completed</span
                                            >
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Card Footer -->
            <div
                class="flex items-center justify-between pt-3 sm:pt-6"
                bis_skin_checked="1"
            >
                <div bis_skin_checked="1">
                    <button
                        class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-500 rounded-lg hover:text-gray-900 dark:text-gray-400 dark:hover:text-white"
                        type="button"
                        data-dropdown-toggle="transactions-dropdown"
                    >
                        Last 7 days
                        <svg
                            class="w-4 h-4 ml-2"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M19 9l-7 7-7-7"
                            ></path>
                        </svg>
                    </button>
                    <!-- Dropdown menu -->
                    <div
                        class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600"
                        id="transactions-dropdown"
                        data-popper-placement="top"
                        bis_skin_checked="1"
                        style="
                            position: absolute;
                            inset: auto auto 0px 0px;
                            margin: 0px;
                            transform: translate(91px, 1948px);
                        "
                        data-popper-reference-hidden=""
                        data-popper-escaped=""
                    >
                        <div
                            class="px-4 py-3"
                            role="none"
                            bis_skin_checked="1"
                        >
                            <p
                                class="text-sm font-medium text-gray-900 truncate dark:text-white"
                                role="none"
                            >
                                Sep 16, 2021 - Sep 22, 2021
                            </p>
                        </div>
                        <ul class="py-1" role="none">
                            <li>
                                <a
                                    href="#"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                                    role="menuitem"
                                    >Yesterday</a
                                >
                            </li>
                            <li>
                                <a
                                    href="#"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                                    role="menuitem"
                                    >Today</a
                                >
                            </li>
                            <li>
                                <a
                                    href="#"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                                    role="menuitem"
                                    >Last 7 days</a
                                >
                            </li>
                            <li>
                                <a
                                    href="#"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                                    role="menuitem"
                                    >Last 30 days</a
                                >
                            </li>
                            <li>
                                <a
                                    href="#"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                                    role="menuitem"
                                    >Last 90 days</a
                                >
                            </li>
                        </ul>
                        <div
                            class="py-1"
                            role="none"
                            bis_skin_checked="1"
                        >
                            <a
                                href="#"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white"
                                role="menuitem"
                                >Custom...</a
                            >
                        </div>
                    </div>
                </div>
                <div class="flex-shrink-0" bis_skin_checked="1">
                    <a
                        href="#"
                        class="inline-flex items-center p-2 text-xs font-medium uppercase rounded-lg text-primary-700 sm:text-sm hover:bg-gray-100 dark:text-primary-500 dark:hover:bg-gray-700"
                    >
                        Transactions Report
                        <svg
                            class="w-4 h-4 ml-1 sm:w-5 sm:h-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 5l7 7-7 7"
                            ></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</main>
@if (session('success'))
    <script>
        Toastify({
            text: "{{ session('success') }}",
            duration: 3000,
            gravity: "top",
            position: "right",
            backgroundColor: "#16a34a",
            close: true
        }).showToast();
    </script>
@endif

@endsection

@section('custom.js')

@endsection