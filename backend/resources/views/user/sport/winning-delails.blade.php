@extends('user.main.main')

@section('user-content')



    <h5 class="pt-5 pb-4">Picking Journal</h5>

    <h6 class="mt-5">Important Data</h6>

    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-3 my-pick-gap">
                <div class="my-picks-box">
                    <h6 class="pb-2">Current Balance</h6>
                    <h5>${{ number_format($currentBalance, 2) }}</h5>
                </div>
            </div>

            <div class="col-lg-3 my-pick-gap">
                <div class="my-picks-box">
                    <h6 class="pb-2">Number of Picks</h6>
                    <h5>{{ $totalPicks }}</h5>
                </div>
            </div>
            <div class="col-lg-3 my-pick-gap">
                <div class="my-picks-box">
                    <h6 class="pb-2">Highest Winning Pick</h6>
                    <h5>{{ $highestWinningPick }}%</h5>
                </div>
            </div>
            <div class="col-lg-3 my-pick-gap">
                <div class="my-picks-box">
                    <h6 class="pb-2">Picks Won</h6>
                    <h5>{{ $picksWon }}</h5>
                </div>
            </div>
            <div class="col-lg-3 my-pick-gap">
                <div class="my-picks-box">
                    <h6 class="pb-2">Picks Loss</h6>
                    <h5>2</h5>
                </div>
            </div>
            <div class="col-lg-3 my-pick-gap">
                <div class="my-picks-box">
                    <h6 class="pb-2">Win Rate</h6>
                    <h5>62.50%</h5>
                </div>
            </div>
            <div class="col-lg-3 my-pick-gap">
                <div class="my-picks-box">
                    <h6 class="pb-2">Loss Rate</h6>
                    <h5>25.00%</h5>
                </div>
            </div>
            <div class="col-lg-3 my-pick-gap">
                <div class="my-picks-box">
                    <h6 class="pb-2">Average Profit Per Pick</h6>
                    <h5>$7.71</h5>
                </div>
            </div>

            <div class="MuiGrid-root MuiGrid-item MuiGrid-grid-xs-12 css-15j76c0">
                <div class="MuiGrid-root MuiGrid-container css-1d3bbye">
                    <div class="MuiGrid-root MuiGrid-item MuiGrid-grid-xs-12 css-15j76c0">
                        <h6 class="MuiTypography-root MuiTypography-subtitle1 text-white font-bold my-2 css-15d4j8k">Balance
                            History</h6>
                    </div>
                    <div class="MuiGrid-root MuiGrid-item MuiGrid-grid-xs-12 w-full css-15j76c0">
                        <div
                            class="MuiPaper-root MuiPaper-elevation MuiPaper-rounded MuiPaper-elevation1 w-full rounded-2xl p-2 md:p-8 bg-gray-300/5 css-aoeo82">
                            <div class="pt-8">
                                <div data-highcharts-chart="1" style="overflow: hidden; pointer-events: fill;">
                                    <div id="highcharts-u4s98fv-18"
                                        style="position: relative; overflow: hidden; width: 1141px; height: 400px; text-align: left; line-height: normal; z-index: 0; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); user-select: none; touch-action: manipulation; outline: none; font-family: sans-serif;"
                                        dir="ltr" class="highcharts-container "><svg version="1.1"
                                            class="highcharts-root" style="font-family: sans-serif; font-size: 1rem;"
                                            xmlns="http://www.w3.org/2000/svg" width="1141" height="400"
                                            viewBox="0 0 1141 400" role="img" aria-label="">
                                            <desc>Created with Highcharts 11.4.6</desc>
                                            <defs>
                                                <linearGradient x1="0" x2="0" y1="0" y2="1"
                                                    id="highcharts-u4s98fv-19">
                                                    <stop offset="0" stop-color="rgb(255,0,255)" stop-opacity="0.5">
                                                    </stop>
                                                    <stop offset="1" stop-color="rgb(255,0,255)" stop-opacity="0">
                                                    </stop>
                                                </linearGradient>
                                                <filter id="highcharts-drop-shadow-1">
                                                    <feDropShadow dx="1" dy="1" flood-color="#000000"
                                                        flood-opacity="0.75" stdDeviation="2.5"></feDropShadow>
                                                </filter>
                                                <clipPath id="highcharts-u4s98fv-27-">
                                                    <rect x="0" y="0" width="1049" height="304" fill="none"></rect>
                                                </clipPath>
                                            </defs>
                                            <rect fill="transparent" class="highcharts-background" filter="none" x="0"
                                                y="0" width="1141" height="400" rx="0" ry="0"></rect>
                                            <rect fill="none" class="highcharts-plot-background" x="82" y="10"
                                                width="1049" height="304" filter="none"></rect>
                                            <rect fill="none" class="highcharts-plot-border" data-z-index="1"
                                                stroke="#cccccc" stroke-width="0" x="82" y="10" width="1049"
                                                height="304"></rect>
                                            <g class="highcharts-grid highcharts-xaxis-grid" data-z-index="1">
                                                <path fill="none" stroke="#e6e6e6" stroke-width="0"
                                                    stroke-dasharray="none" data-z-index="1" class="highcharts-grid-line"
                                                    d="M 231.5 10 L 231.5 314" opacity="1"></path>
                                                <path fill="none" stroke="#e6e6e6" stroke-width="0"
                                                    stroke-dasharray="none" data-z-index="1" class="highcharts-grid-line"
                                                    d="M 381.5 10 L 381.5 314" opacity="1"></path>
                                                <path fill="none" stroke="#e6e6e6" stroke-width="0"
                                                    stroke-dasharray="none" data-z-index="1" class="highcharts-grid-line"
                                                    d="M 531.5 10 L 531.5 314" opacity="1"></path>
                                                <path fill="none" stroke="#e6e6e6" stroke-width="0"
                                                    stroke-dasharray="none" data-z-index="1" class="highcharts-grid-line"
                                                    d="M 681.5 10 L 681.5 314" opacity="1"></path>
                                                <path fill="none" stroke="#e6e6e6" stroke-width="0"
                                                    stroke-dasharray="none" data-z-index="1" class="highcharts-grid-line"
                                                    d="M 831.5 10 L 831.5 314" opacity="1"></path>
                                                <path fill="none" stroke="#e6e6e6" stroke-width="0"
                                                    stroke-dasharray="none" data-z-index="1" class="highcharts-grid-line"
                                                    d="M 981.5 10 L 981.5 314" opacity="1"></path>
                                                <path fill="none" stroke="#e6e6e6" stroke-width="0"
                                                    stroke-dasharray="none" data-z-index="1" class="highcharts-grid-line"
                                                    d="M 1131.5 10 L 1131.5 314" opacity="1"></path>
                                                <path fill="none" stroke="#e6e6e6" stroke-width="0"
                                                    stroke-dasharray="none" data-z-index="1" class="highcharts-grid-line"
                                                    d="M 82.5 10 L 82.5 314" opacity="1"></path>
                                            </g>
                                            <g class="highcharts-grid highcharts-yaxis-grid" data-z-index="1">
                                                <path fill="none" stroke="#3a3a3a" stroke-width="1"
                                                    stroke-dasharray="none" data-z-index="1" class="highcharts-grid-line"
                                                    d="M 82 314.5 L 1131 314.5" opacity="1"></path>
                                                <path fill="none" stroke="#3a3a3a" stroke-width="1"
                                                    stroke-dasharray="none" data-z-index="1" class="highcharts-grid-line"
                                                    d="M 82 253.5 L 1131 253.5" opacity="1"></path>
                                                <path fill="none" stroke="#3a3a3a" stroke-width="1"
                                                    stroke-dasharray="none" data-z-index="1" class="highcharts-grid-line"
                                                    d="M 82 192.5 L 1131 192.5" opacity="1"></path>
                                                <path fill="none" stroke="#3a3a3a" stroke-width="1"
                                                    stroke-dasharray="none" data-z-index="1" class="highcharts-grid-line"
                                                    d="M 82 131.5 L 1131 131.5" opacity="1"></path>
                                                <path fill="none" stroke="#3a3a3a" stroke-width="1"
                                                    stroke-dasharray="none" data-z-index="1" class="highcharts-grid-line"
                                                    d="M 82 70.5 L 1131 70.5" opacity="1"></path>
                                                <path fill="none" stroke="#3a3a3a" stroke-width="1"
                                                    stroke-dasharray="none" data-z-index="1" class="highcharts-grid-line"
                                                    d="M 82 10.5 L 1131 10.5" opacity="1"></path>
                                            </g>
                                            <g class="highcharts-axis highcharts-xaxis" data-z-index="2">
                                                <path fill="none" class="highcharts-axis-line" stroke="#3a3a3a"
                                                    stroke-width="1" data-z-index="7" d="M 82 314.5 L 1131 314.5"></path>
                                            </g>
                                            <g class="highcharts-axis highcharts-yaxis" data-z-index="2">
                                                <path fill="none" class="highcharts-axis-line" stroke="#333333"
                                                    stroke-width="0" data-z-index="7" d="M 82 10 L 82 314"></path>
                                            </g>
                                            <g class="highcharts-series-group" data-z-index="3" filter="none">
                                                <g class="highcharts-series highcharts-series-0 highcharts-areaspline-series"
                                                    data-z-index="0.1" opacity="1"
                                                    transform="translate(82,10) scale(1 1)"
                                                    clip-path="url(#highcharts-u4s98fv-27-)">
                                                    <path fill="url(#highcharts-u4s98fv-19)"
                                                        d="M 74.928571428571 66.853248 C 74.928571428571 66.853248 164.84285714285437 54.547328 224.78571428571 54.547328 C 284.72857142857004 54.547328 314.7 56.979328 374.64285714286 56.979328 C 434.58571428571594 56.979328 464.557142857144 52.375552 524.5 52.375552 C 584.4428571428559 52.375552 614.414285714284 52.375552 674.35714285714 52.375552 C 734.3 52.375552 764.2714285714301 52.375552 824.21428571429 52.375552 C 884.157142857146 52.375552 974.07142857143 55.050752 974.07142857143 55.050752 L 974.07142857143 304 C 974.07142857143 304 884.157142857146 304 824.21428571429 304 C 764.2714285714301 304 734.3 304 674.35714285714 304 C 614.414285714284 304 584.4428571428559 304 524.5 304 C 464.557142857144 304 434.58571428571594 304 374.64285714286 304 C 314.7 304 284.72857142857004 304 224.78571428571 304 C 164.84285714285437 304 74.928571428571 304 74.928571428571 304 Z"
                                                        class="highcharts-area" data-z-index="0" fill-opacity="1"
                                                        style="pointer-events: none;"></path>
                                                    <path fill="none"
                                                        d="M 74.928571428571 66.853248 C 74.928571428571 66.853248 164.84285714285437 54.547328 224.78571428571 54.547328 C 284.72857142857004 54.547328 314.7 56.979328 374.64285714286 56.979328 C 434.58571428571594 56.979328 464.557142857144 52.375552 524.5 52.375552 C 584.4428571428559 52.375552 614.414285714284 52.375552 674.35714285714 52.375552 C 734.3 52.375552 764.2714285714301 52.375552 824.21428571429 52.375552 C 884.157142857146 52.375552 974.07142857143 55.050752 974.07142857143 55.050752"
                                                        class="highcharts-graph" data-z-index="1" stroke="#FF00FF"
                                                        stroke-width="2" stroke-linejoin="round" stroke-linecap="round"
                                                        filter="none"></path>
                                                    <path fill="none"
                                                        d="M 74.928571428571 66.853248 C 74.928571428571 66.853248 164.84285714285437 54.547328 224.78571428571 54.547328 C 284.72857142857004 54.547328 314.7 56.979328 374.64285714286 56.979328 C 434.58571428571594 56.979328 464.557142857144 52.375552 524.5 52.375552 C 584.4428571428559 52.375552 614.414285714284 52.375552 674.35714285714 52.375552 C 734.3 52.375552 764.2714285714301 52.375552 824.21428571429 52.375552 C 884.157142857146 52.375552 974.07142857143 55.050752 974.07142857143 55.050752"
                                                        data-z-index="2" class="highcharts-tracker-line"
                                                        stroke-linecap="round" stroke-linejoin="round"
                                                        stroke="rgba(192,192,192,0.0001)" stroke-width="22"></path>
                                                </g>
                                                <g class="highcharts-markers highcharts-series-0 highcharts-areaspline-series highcharts-tracker"
                                                    data-z-index="0.1" opacity="1"
                                                    transform="translate(82,10) scale(1 1)" clip-path="none">
                                                    <path fill="#FF00FF"
                                                        d="M 524.5 52.375552 A 0 0 0 1 1 524.5 52.375552 Z"
                                                        class="highcharts-halo highcharts-color-undefined"
                                                        data-z-index="-1" fill-opacity="0.25" visibility="hidden"></path>
                                                    <path fill="#FF00FF"
                                                        d="M 74.5 70.853248 A 4 4 0 1 1 74.50019999999992 70.85324799499999 Z"
                                                        stroke="#ffffff" stroke-width="0" opacity="1"
                                                        class="highcharts-point"></path>
                                                    <path fill="#FF00FF"
                                                        d="M 224.5 58.547328 A 4 4 0 1 1 224.50019999999992 58.547327995 Z"
                                                        stroke="#ffffff" stroke-width="0" opacity="1"
                                                        class="highcharts-point"></path>
                                                    <path fill="#FF00FF"
                                                        d="M 374.5 60.979328 A 4 4 0 1 1 374.5001999999999 60.979327995000006 Z"
                                                        stroke="#ffffff" stroke-width="0" opacity="1"
                                                        class="highcharts-point"></path>
                                                    <path fill="#FF00FF"
                                                        d="M 524.5 56.375552 A 4 4 0 1 1 524.5002 56.375551995 Z"
                                                        stroke="#ffffff" stroke-width="0" opacity="1"
                                                        class="highcharts-point"></path>
                                                    <path fill="#FF00FF"
                                                        d="M 674.5 56.375552 A 4 4 0 1 1 674.5002 56.375551995 Z"
                                                        stroke="#ffffff" stroke-width="0" opacity="1"
                                                        class="highcharts-point"></path>
                                                    <path fill="#FF00FF"
                                                        d="M 824.5 56.375552 A 4 4 0 1 1 824.5002 56.375551995 Z"
                                                        stroke="#ffffff" stroke-width="0" opacity="1"
                                                        class="highcharts-point"></path>
                                                    <path fill="#FF00FF"
                                                        d="M 974.5 59.050752 A 4 4 0 1 1 974.5002 59.050751995000006 Z"
                                                        stroke="#ffffff" stroke-width="0" opacity="1"
                                                        class="highcharts-point"></path>
                                                </g>
                                            </g><text x="571" text-anchor="middle" class="highcharts-title"
                                                data-z-index="4"
                                                style="font-size: 1.2em; color: rgb(51, 51, 51); font-weight: bold; fill: rgb(51, 51, 51);"
                                                y="25"></text><text x="571" text-anchor="middle"
                                                class="highcharts-subtitle" data-z-index="4"
                                                style="color: rgb(102, 102, 102); font-size: 0.8em; fill: rgb(102, 102, 102);"
                                                y="24"></text><text x="10" text-anchor="start" class="highcharts-caption"
                                                data-z-index="4"
                                                style="color: rgb(102, 102, 102); font-size: 0.8em; fill: rgb(102, 102, 102);"
                                                y="397"></text>
                                            <g class="highcharts-legend highcharts-no-tooltip" data-z-index="7"
                                                transform="translate(529,355)">
                                                <rect fill="none" class="highcharts-legend-box" rx="0"
                                                    ry="0" stroke="#999999" stroke-width="0" filter="none"
                                                    x="0" y="0" width="83" height="30"></rect>
                                                <g data-z-index="1">
                                                    <g>
                                                        <g class="highcharts-legend-item highcharts-areaspline-series highcharts-color-undefined highcharts-series-0"
                                                            data-z-index="1" transform="translate(8,3)">
                                                            <path fill="none" class="highcharts-graph"
                                                                stroke-width="2" stroke-linecap="round" d="M 1 12 L 15 12"
                                                                stroke="#FF00FF"></path>
                                                            <path fill="url(#highcharts-u4s98fv-19)"
                                                                class="highcharts-area" d="M 1 12 L 15 12 L 15 17 L 1 17"
                                                                fill-opacity="1"></path>
                                                            <path fill="#FF00FF"
                                                                d="M 8 16 A 4 4 0 1 1 8.000199999999918 15.999999995 Z"
                                                                class="highcharts-point" stroke="#ffffff"
                                                                stroke-width="0" opacity="1"></path><text x="21" y="17"
                                                                text-anchor="start" data-z-index="2"
                                                                style="color: rgb(255, 255, 255); cursor: pointer; font-size: 0.8em; text-decoration: none; fill: rgb(255, 255, 255);">Balance</text>
                                                        </g>
                                                    </g>
                                                </g>
                                            </g>
                                            <g class="highcharts-axis-labels highcharts-xaxis-labels" data-z-index="7">
                                                <text x="156.92857142856855"
                                                    style="color: rgb(255, 255, 255); cursor: default; font-size: 0.8em; fill: rgb(255, 255, 255);"
                                                    text-anchor="middle" transform="translate(0,0)" y="341"
                                                    opacity="1">2025-03-11</text><text x="306.78571428571854"
                                                    style="color: rgb(255, 255, 255); cursor: default; font-size: 0.8em; fill: rgb(255, 255, 255);"
                                                    text-anchor="middle" transform="translate(0,0)" y="341"
                                                    opacity="1">2025-03-12</text><text x="456.6428571428586"
                                                    style="color: rgb(255, 255, 255); cursor: default; font-size: 0.8em; fill: rgb(255, 255, 255);"
                                                    text-anchor="middle" transform="translate(0,0)" y="341"
                                                    opacity="1">2025-03-13</text><text x="606.4999999999985"
                                                    style="color: rgb(255, 255, 255); cursor: default; font-size: 0.8em; fill: rgb(255, 255, 255);"
                                                    text-anchor="middle" transform="translate(0,0)" y="341"
                                                    opacity="1">2025-03-14</text><text x="756.3571428571386"
                                                    style="color: rgb(255, 255, 255); cursor: default; font-size: 0.8em; fill: rgb(255, 255, 255);"
                                                    text-anchor="middle" transform="translate(0,0)" y="341"
                                                    opacity="1">2025-03-15</text><text x="906.2142857142885"
                                                    style="color: rgb(255, 255, 255); cursor: default; font-size: 0.8em; fill: rgb(255, 255, 255);"
                                                    text-anchor="middle" transform="translate(0,0)" y="341"
                                                    opacity="1">2025-03-16</text><text x="1056.0714285714287"
                                                    style="color: rgb(255, 255, 255); cursor: default; font-size: 0.8em; fill: rgb(255, 255, 255);"
                                                    text-anchor="middle" transform="translate(0,0)" y="341"
                                                    opacity="1">2025-03-17</text></g>
                                            <g class="highcharts-axis-labels highcharts-yaxis-labels" data-z-index="7">
                                                <text x="67"
                                                    style="color: rgb(255, 255, 255); cursor: default; font-size: 0.8em; fill: rgb(255, 255, 255);"
                                                    text-anchor="end" transform="translate(0,0)" y="319"
                                                    opacity="1">$0.00</text><text x="67"
                                                    style="color: rgb(255, 255, 255); cursor: default; font-size: 0.8em; fill: rgb(255, 255, 255);"
                                                    text-anchor="end" transform="translate(0,0)" y="258"
                                                    opacity="1">$250.00</text><text x="67"
                                                    style="color: rgb(255, 255, 255); cursor: default; font-size: 0.8em; fill: rgb(255, 255, 255);"
                                                    text-anchor="end" transform="translate(0,0)" y="198"
                                                    opacity="1">$500.00</text><text x="67"
                                                    style="color: rgb(255, 255, 255); cursor: default; font-size: 0.8em; fill: rgb(255, 255, 255);"
                                                    text-anchor="end" transform="translate(0,0)" y="137"
                                                    opacity="1">$750.00</text><text x="67"
                                                    style="color: rgb(255, 255, 255); cursor: default; font-size: 0.8em; fill: rgb(255, 255, 255);"
                                                    text-anchor="end" transform="translate(0,0)" y="76"
                                                    opacity="1">$1,000.00</text><text x="67"
                                                    style="color: rgb(255, 255, 255); cursor: default; font-size: 0.8em; fill: rgb(255, 255, 255);"
                                                    text-anchor="end" transform="translate(0,0)" y="15"
                                                    opacity="1">$1,250.00</text></g>
                                            <g class="highcharts-label highcharts-tooltip highcharts-color-undefined"
                                                data-z-index="8" filter="url(#highcharts-drop-shadow-1)"
                                                style="cursor: default; pointer-events: none;"
                                                transform="translate(542,1)" opacity="0" visibility="hidden">
                                                <path fill="rgba(0, 0, 0, 0.75)"
                                                    class="highcharts-label-box highcharts-tooltip-box"
                                                    d="M 3 0 L 127 0 A 3 3 0 0 1 130 3 L 130 42 A 3 3 0 0 1 127 45 L 71 45 L 65 51 L 59 45 L 3 45 A 3 3 0 0 1 0 42 L 0 3 A 3 3 0 0 1 3 0 Z"
                                                    stroke-width="0" stroke="#FF00FF"></path><text x="8" data-z-index="1"
                                                    y="20"
                                                    style="color: rgb(255, 255, 255); font-size: 0.8em; fill: rgb(255, 255, 255);">
                                                    <tspan style="font-weight: bold;">Date:</tspan> 2025-03-14<tspan
                                                        class="highcharts-br" dy="15" x="8">&ZeroWidthSpace;
                                                    </tspan>
                                                    <tspan style="font-weight: bold;">Amount:</tspan> $1,034.64
                                                </text>
                                            </g>
                                        </svg></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="d-flex justify-content-between">
                    <h6>Pick History</h6>
                    <div class="history">
                        <li>
                            <a class="dropdown-item sport-option" style="cursor: pointer;" data-value="">
                                <button class="btn btn-primary">ACTIVE</button>
                                <button class="btn btn-secondary">CLOSED</button>
                            </a>
                        </li>
                    </div>
                </div>
            </div>

             <div class="row mt-3">
    <div class="col-lg-4 align-itmes-center ">
      <div class="history-header d-flex justify-content-between box">
        <div class="d-flex">
          <i class="fa-solid fa-basketball gapping"></i>
          <h6 class="gapping status">Won</h6>
        </div>
        <h6>Feb 19 4:43 AM</h6>
      </div>
      <div class="team">
        <span>
          Bellarmine vs Austin Peay
        </span>
      </div>
      <div class="market">
        <span>
          Point Spread
        </span>
      </div>
      <div class="bet-team d-flex justify-content-between">
        <p>Austin Peay -2.5</p>
        <p>-166</p>
      </div>
      <div class="bet-team">
        <p>Feb 18 6:30 PM (EST)</p>
      </div>
      <hr>
      <div class="price ">
        <div class="total-pick bet-team d-flex justify-content-between">
          <p>Total Pick</p>
          <h6>20.00</h6>
        </div>
        <div class="total-pick bet-team d-flex justify-content-between">
          <p>Payout</p>
          <h6>0.00</h6>
        </div>
        
      </div>
    </div>
            <div class="container mt-4">

                {{-- Success or Error Messages --}}
                @if (session('error'))
                    <div class="alert alert-danger text-center">{{ session('error') }}</div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success text-center">{{ session('success') }}</div>
                @endif

                @if (empty($winningDetails) || count($winningDetails) == 0)
                    <div class="alert alert-warning text-center">❌ No winning details found.</div>
                @else
                    <div class="row">
                        @foreach ($winningDetails as $detail)
                            <div class="col-md-6">
                                <!-- Winning Card Summary -->
                                <div class="card mb-4 shadow-sm">
                                    <div class="card-body">
                                        <h5 class="card-title text-success">✅ Won</h5>
                                        <p class="text-muted">
                                            {{ \Carbon\Carbon::parse($detail['created_at'])->format('M d h:i A') }}</p>

                                        <h6 class="text-dark">{{ $detail['game'] ?? 'Match Details' }}</h6>
                                        <p class="text-muted">{{ $detail['bet_type'] ?? 'Bet Type' }}</p>

                                        <h5 class="text-primary">{{ $detail['team'] ?? 'Team Name' }}
                                            {{ $detail['spread'] ?? '' }}
                                        </h5>
                                        <p class="text-muted">{{ $detail['odds'] ?? 'odds' }}</p>

                                        <hr>

                                        <h6 class="text-dark">Fanfunded</h6>
                                        <p><strong>Total Pick:</strong> ${{ number_format($detail['total_pick'], 2) }}</p>
                                        <p><strong>Payout:</strong> ${{ number_format($detail['payout'], 2) }}</p>

                                        <p class="text-muted"><strong>Pick ID:</strong>
                                            {{ $detail['pick_id'] ?? 'pick_id' }}</p>
                                    </div>
                                </div>

                                <!-- Detailed Bet Breakdown -->
                                <div class="card mb-4 shadow-sm">
                                    <div class="card-body">
                                        <h5 class="card-title">User: {{ $detail['user'] }}</h5>

                                        <!-- Straight Bets Section -->
                                        <h6 class="text-primary">Straight Bets:</h6>
                                        <ul class="list-group">
                                            @foreach ($detail['straight_bets'] as $bet)
                                                <li class="list-group-item">
                                                    <strong>Type:</strong> {{ $bet['type'] }} <br>
                                                    @if (isset($bet['team']))
                                                        <strong>Team:</strong> {{ $bet['team'] }} <br>
                                                    @endif
                                                    <strong>Pick:</strong> {{ $bet['pick'] }} <br>
                                                    <strong>To Win:</strong> ${{ $bet['toWin'] }}
                                                </li>
                                            @endforeach
                                        </ul>

                                        <!-- Parlay Bets Section -->
                                        <h6 class="mt-3 text-success">Parlay Bets:</h6>
                                        <ul class="list-group">
                                            @foreach ($detail['parlay_bets'] as $bet)
                                                <li class="list-group-item">
                                                    <strong>Type:</strong> {{ $bet['type'] }} <br>
                                                    @if (isset($bet['team']))
                                                        <strong>Team:</strong> {{ $bet['team'] }} <br>
                                                    @endif
                                                    <strong>Pick:</strong> {{ $bet['pick'] }} <br>
                                                    <strong>To Win:</strong> ${{ $bet['toWin'] }}
                                                </li>
                                            @endforeach
                                        </ul>

                                        <!-- Total Collect -->
                                        <h6 class="mt-3 text-danger">Total Collect:</h6>
                                        <p><strong>Straight:</strong>
                                            ${{ number_format($detail['total_collect']['straight'], 2) }}</p>
                                        <p><strong>Parlay:</strong>
                                            ${{ number_format($detail['total_collect']['parlay'], 2) }}</p>
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        @endsection
