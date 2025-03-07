@extends('user.main.main')

@section('user-content')
    <div class="new-navbar">
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                aria-expanded="false">
                {{ request('sport') ? collect($sportData)->firstWhere('key', request('sport'))['title'] ?? 'Select Sport' : 'Select Sport' }}
            </button>

            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                @php $hasAmericanFootball = false; @endphp

                @foreach ($sportData as $sport)
                    @if ($sport['group'] == 'American Football')
                        @php $hasAmericanFootball = true; @endphp
                        <li>
                            <a class="dropdown-item sport-option" style="cursor: pointer;" data-value="{{ $sport['key'] }}">
                                {{ $sport['title'] }}
                            </a>
                        </li>
                    @endif
                @endforeach

                @if (!$hasAmericanFootball)
                    <li><a class="dropdown-item text-muted" href="#">No American Football Data</a></li>
                @endif
            </ul>
        </div>


        <button>Football</button>
        <button>Basketball</button>
        <button>Baseball</button>
        <button>MMA</button>
        <button>Hockey</button>
        <button>Soccer</button>
        <button>Tennis</button>
        <button>Golf</button>
    </div>


    <div class="main-content">
        <div class="container-schedule" id="schedule-container">
            <table class="schedule-table">
                <thead>
                    <tr>
                        <th>Time</th>
                        <th>MMA Fighters</th>
                        <th>Point Spread</th>
                        {{-- <th>Total Points</th>
                        <th>Moneyline</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($oddsData as $item)
                        @php
                            $draftKings = collect($item['bookmakers'] ?? [])->firstWhere('key', 'draftkings');

                            $homeTeam = $item['home_team'] ?? 'N/A';
                            $awayTeam = $item['away_team'] ?? 'N/A';

                            $homePoint = $awayPoint = $homePrice = $awayPrice = null;
                            $overPoint = $underPoint = $overPrice = $underPrice = null;
                            $homeMoneyline = $awayMoneyline = null;

                            if (
                                $draftKings &&
                                is_array($draftKings) &&
                                isset($draftKings['markets']) &&
                                is_array($draftKings['markets'])
                            ) {
                                $markets = collect($draftKings['markets']);

                                // Extract Point Spread Data
                                $spreadMarket = $markets->firstWhere('key', 'spreads');
                                if (
                                    $spreadMarket &&
                                    isset($spreadMarket['outcomes']) &&
                                    is_array($spreadMarket['outcomes'])
                                ) {
                                    foreach ($spreadMarket['outcomes'] as $outcome) {
                                        if (($outcome['name'] ?? '') === $homeTeam) {
                                            $homePoint = $outcome['point'] ?? null;
                                            $homePrice = $outcome['price'] ?? null;
                                        } elseif (($outcome['name'] ?? '') === $awayTeam) {
                                            $awayPoint = $outcome['point'] ?? null;
                                            $awayPrice = $outcome['price'] ?? null;
                                        }
                                    }
                                }

                                // Extract Total Points Data
                                $totalMarket = $markets->firstWhere('key', 'totals');
                                if (
                                    $totalMarket &&
                                    isset($totalMarket['outcomes']) &&
                                    is_array($totalMarket['outcomes'])
                                ) {
                                    foreach ($totalMarket['outcomes'] as $outcome) {
                                        if (($outcome['name'] ?? '') === 'Over') {
                                            $overPoint = $outcome['point'] ?? null;
                                            $overPrice = $outcome['price'] ?? null;
                                        } elseif (($outcome['name'] ?? '') === 'Under') {
                                            $underPoint = $outcome['point'] ?? null;
                                            $underPrice = $outcome['price'] ?? null;
                                        }
                                    }
                                }

                                // Extract Moneyline Data
                                $moneylineMarket = $markets->firstWhere('key', 'h2h');
                                if (
                                    $moneylineMarket &&
                                    isset($moneylineMarket['outcomes']) &&
                                    is_array($moneylineMarket['outcomes'])
                                ) {
                                    foreach ($moneylineMarket['outcomes'] as $outcome) {
                                        if (($outcome['name'] ?? '') === $homeTeam) {
                                            $homeMoneyline = $outcome['price'] ?? null;
                                        } elseif (($outcome['name'] ?? '') === $awayTeam) {
                                            $awayMoneyline = $outcome['price'] ?? null;
                                        }
                                    }
                                }
                            }
                        @endphp

                        @if ($draftKings)
                            <tr>
                                <!-- Time -->
                                <td>
                                    <span>{{ \Carbon\Carbon::parse($item['commence_time'] ?? now())->format('g:i A') }}</span>
                                    <span
                                        class="date">{{ \Carbon\Carbon::parse($item['commence_time'] ?? now())->format('M j') }}</span>
                                </td>

                                <!-- Fighters -->
                                <td>
                                    <div class="fighter"><span>{{ $homeTeam }}</span></div>
                                    <div class="fighter"><span>{{ $awayTeam }}</span></div>
                                </td>

                                <!-- Point Spread -->
                                <td class="bet">
                                    <div
                                        onclick="openPickslip('Point Spread', '{{ $homeTeam }} {{ $homePoint }} {{ $homePrice }}')">
                                        {{ $homePoint !== null ? $homePoint : '-' }}
                                        <span class="odds">{{ $homePrice !== null ? $homePrice : '-' }}</span>
                                    </div>
                                    <div
                                        onclick="openPickslip('Point Spread', '{{ $awayTeam }} {{ $awayPoint }} {{ $awayPrice }}')">
                                        {{ $awayPoint !== null ? $awayPoint : '-' }}
                                        <span class="odds">{{ $awayPrice !== null ? $awayPrice : '-' }}</span>
                                    </div>
                                </td>

                                <!-- Total Points -->
                                {{-- <td class="bet">
                                    <div onclick="openPickslip('Total Points', 'Over {{ $overPoint }} {{ $overPrice }}')">
                                        O {{ $overPoint !== null ? $overPoint : '-' }} 
                                        <span class="odds">{{ $overPrice !== null ? $overPrice : '-' }}</span>
                                    </div>
                                    <div onclick="openPickslip('Total Points', 'Under {{ $underPoint }} {{ $underPrice }}')">
                                        U {{ $underPoint !== null ? $underPoint : '-' }} 
                                        <span class="odds">{{ $underPrice !== null ? $underPrice : '-' }}</span>
                                    </div>
                                </td> --}}

                                <!-- Moneyline -->
                                {{-- <td class="bet">
                                    <div onclick="openPickslip('Moneyline', '{{ $homeTeam }} {{ $homeMoneyline }}')">
                                        <span class="odds">{{ $homeMoneyline !== null ? $homeMoneyline : '-' }}</span>
                                    </div>
                                    <div onclick="openPickslip('Moneyline', '{{ $awayTeam }} {{ $awayMoneyline }}')">
                                        <span class="odds">{{ $awayMoneyline !== null ? $awayMoneyline : '-' }}</span>
                                    </div>
                                </td> --}}
                            </tr>
                        @endif
                    @endforeach

                </tbody>
            </table>



        </div>

        <div class="pickslip" id="pickslip">
            <div class="pick-slip">
                <h5>Pickslip</h5>

                <div class="tabs-pickslip">
                    <span class="tab active" onclick="openTab('straight')">Straight</span>
                    <span class="tab" onclick="openTab('parlay')">Parlay</span>
                </div>

                <!-- --------------------------------------------- -->
                <div class="tab-content" id="straight">
                    <div class="scroll-div">
                        <div class="center-pick">
                            <div class="over">
                                <h6>Over 2.5</h6>
                                <h6 class="remove-bet" style="cursor: pointer;" onclick="removeBet(this)">❌</h6>
                            </div>
                            <div class="total">
                                <h6 id="pick-info"></h6>
                            </div>
                            <div class="date-time">
                                <h6 id="pick-date-time">Select a bet</h6>
                            </div>
                            <div class="btuns-pick">
                                <div class="pick-input">
                                    <span>Pick</span>
                                    <input type="number" value="">
                                </div>
                                <div class="win-input">
                                    <span>To Win</span>
                                    <input type="text" value="" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- --------------------------------------------- -->
                <div class="tab-content" id="parlay" style="display: none;">
                    <div class="scroll-div">
                        <div class="center-pick">
                            <div class="over">
                                <h6>Over 2.5</h6>
                                <h6 class="remove-bet" style="cursor: pointer;" onclick="removeBet(this)">❌</h6>
                            </div>
                            <div class="total">
                                <h6 id="pick-info"></h6>
                            </div>
                            <div class="date-time">
                                <h6 id="pick-date-time">Select a bet</h6>
                            </div>
                            <div class="btuns-pick">
                                <div class="pick-input">
                                    <span>Pick</span>
                                    <input type="number" value="">
                                </div>
                                <div class="win-input">
                                    <span>To Win</span>
                                    <input type="text" value="" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- --------------------------------------------- -->
                <div class="collect">
                    <h6>To Collect</h6>
                    <h6>$0.00</h6>
                </div>

                <div class="last-pick-btn">
                    <button class="btn-clear" onclick="closePickslip()">Clear</button>
                    <button class="white-pick">Pick Place</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.querySelectorAll('.sport-option').forEach(item => {
            item.addEventListener('click', function() {
                let selectedSport = this.getAttribute('data-value');

                // Get current URL and remove any existing sport parameter
                let url = new URL(window.location.href);
                url.searchParams.delete('sport'); // Remove existing sport param
                url.searchParams.set('sport', selectedSport); // Add new sport param

                window.location.href = url.toString(); // Redirect to updated URL
            });
        });

        function openTab(tabName) {
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.style.display = 'none';
            });
            document.querySelectorAll('.tab').forEach(tab => {
                tab.classList.remove('active');
            });
            document.getElementById(tabName).style.display = 'block';
            event.target.classList.add('active');
        }

        function openPickslip(type, value) {
            let pickslip = document.getElementById("pickslip");
            let betContainer = document.querySelector(".scroll-div"); // Get the container for picks

            // Ensure pickslip opens every time a new pick is added
            pickslip.style.display = "block";
            pickslip.classList.add("open");

            // Create a new pick entry (APPENDS instead of replacing)
            let newBet = document.createElement("div");
            newBet.classList.add("center-pick");
            newBet.innerHTML = `
        <div class="over">
            <h6>${type}</h6>
            <h6 class="remove-bet" style="cursor: pointer;" onclick="removeBet(this)">❌</h6>
        </div>
        <div class="total">
            <h6>${value}</h6>
        </div>
        <div class="date-time">
            <h6>Select a bet</h6>
        </div>
        <div class="btuns-pick">
            <div class="pick-input">
                <span>Pick</span>
                <input type="number" value="">
            </div>
            <div class="win-input">
                <span>To Win</span>
                <input type="text" value="" disabled>
            </div>
        </div>
    `;

            betContainer.appendChild(newBet); // Append new pick below previous ones
        }

        function removeBet(element) {
            let betItem = element.closest(".center-pick");
            if (betItem) {
                betItem.remove();
            }

            // Hide pickslip if no picks are left
            let betContainer = document.querySelector(".scroll-div");
            if (betContainer.children.length === 0) {
                document.getElementById("pickslip").style.display = "none";
            }
        }

        // Ensure pickslip can reopen after being closed
        function closePickslip() {
            let betContainer = document.querySelector(".scroll-div");
            betContainer.innerHTML = ""; // Remove all bets
            document.getElementById("pickslip").style.display = "none"; // Hide pickslip
        }

        // Ensure clicking on a schedule-container item adds a new pick
        document.getElementById("schedule-container").addEventListener("click", function(event) {
            let target = event.target;
            if (target.classList.contains("schedule-item")) { // Clicked item must have the class schedule-item
                let type = target.getAttribute("data-type"); // Example: data-type="Point Spread"
                let value = target.getAttribute("data-value"); // Example: data-value="Over 2.5"
                openPickslip(type, value);
            }
        });
    </script>
@endsection
