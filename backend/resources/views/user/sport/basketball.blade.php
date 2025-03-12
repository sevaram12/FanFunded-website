@extends('user.main.main')

@section('user-content')
    <div class="New-Header">
        <div class="new-navbar-wrapper">
            <div class="new-navbar">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        {{ request('sport') ? collect($sportData)->firstWhere('key', request('sport'))['title'] ?? 'Select Sport' : 'Select Sport' }}
                    </button>

                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        @php $hasBasketball = false; @endphp

                        @foreach ($sportData as $sport)
                            @if ($sport['group'] == 'Basketball')
                                @php $hasBasketball = true; @endphp
                                <li>
                                    <a class="dropdown-item sport-option" style="cursor: pointer;"
                                        data-value="{{ $sport['key'] }}">
                                        {{ $sport['title'] }}
                                    </a>
                                </li>
                            @endif
                        @endforeach

                        @if (!$hasBasketball)
                            <li><a class="dropdown-item text-muted" href="#">No Basketball Data</a></li>
                        @endif
                    </ul>
                </div>


                <a href="{{ url('american-football') }}?sport={{ urlencode('americanfootball_ncaaf') }}"
                    class="d-flex align-items-center gap-2"><button>Football</button></a>
                <a href="{{ url('basketball') }}?sport={{ urlencode('basketball_nba') }}"
                    class="d-flex align-items-center gap-2"><button>Basketball</button></a>
                <a href="{{ url('baseball') }}?sport={{ urlencode('baseball_mlb_preseason') }}"
                    class="d-flex align-items-center gap-2" data-key="baseball_mlb_preseason"><button>Baseball</button></a>
                <a href="{{ url('mma') }}?sport={{ urlencode('mma_mixed_martial_arts') }}"
                    class="d-flex align-items-center gap-2"><button>MMA</button></a>
                <a href="{{ url('icehockey') }}?sport={{ urlencode('icehockey_liiga') }}"
                    class="d-flex align-items-center gap-2"><button>Hockey</button></a>
                <a href="{{ url('soccer') }}?sport={{ urlencode('soccer_argentina_primera_division') }}"
                    class="d-flex align-items-center gap-2"
                    data-key="soccer_argentina_primera_division"><button>Soccer</button></a>
                <a href="{{ url('tennis') }}?sport={{ urlencode('tennis_atp_indian_wells') }}"
                    class="d-flex align-items-center gap-2" data-key="tennis_atp_indian_wells"><button>Tennis</button></a>
                <a href="{{ url('golf') }}?sport={{ urlencode('golf_us_open_winner') }}"
                    class="d-flex align-items-center gap-2"><button>Golf</button></a>
            </div>
        </div>
    </div>



    <div class="main-content">
        <div class="container-schedule" id="schedule-container">
            <table class="schedule-table">
                <thead>
                    <tr>
                        <th>Time</th>
                        <th>Basketball</th>
                        <th>Point Spread</th>
                        <th>Total Points</th>
                        <th>Moneyline</th>
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
        
                            if ($draftKings && isset($draftKings['markets'])) {
                                $markets = collect($draftKings['markets']);
        
                                // Extract Point Spread Data
                                $spreadMarket = $markets->firstWhere('key', 'spreads');
                                if ($spreadMarket && isset($spreadMarket['outcomes'])) {
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
                                if ($totalMarket && isset($totalMarket['outcomes'])) {
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
                                if ($moneylineMarket && isset($moneylineMarket['outcomes'])) {
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
                                <td>
                                    <span>{{ \Carbon\Carbon::parse($item['commence_time'] ?? now())->format('g:i A') }}</span>
                                    <span class="date">{{ \Carbon\Carbon::parse($item['commence_time'] ?? now())->format('M j') }}</span>
                                </td>
        
                                <td>
                                    <div class="fighter"><span>{{ $homeTeam }}</span></div>
                                    <div class="fighter"><span>{{ $awayTeam }}</span></div>
                                </td>
        
                                <td class="bet">
                                    <div onclick="openPickslip('Point Spread', '{{ $homeTeam }}', '{{ $homePoint }}', '{{ $homePrice }}')">
                                        {{ $homePoint  ?? '-' }} <span class="odds">{{ $homePrice !== null ? $homePrice : '-' }}</span>
                                    </div>
                                    <div onclick="openPickslip('Point Spread', '{{ $awayTeam }}', '{{ $awayPoint }}', '{{ $awayPrice }}')">
                                        {{ $awayPoint ?? '-' }} <span class="odds">{{ $awayPrice !== null ? $awayPrice : '-' }}</span>
                                    </div>
                                </td>
        
                                <td class="bet">
                                    <div onclick="openPickslip('Total Points', 'Over', '{{ $overPoint }}', '{{ $overPrice }}')">
                                        O {{ $overPoint ?? '-' }} <span class="odds">{{ $overPrice !== null ? $overPrice : '-' }}</span>
                                    </div>
                                    <div onclick="openPickslip('Total Points', 'Under', '{{ $underPoint }}', '{{ $underPrice }}')">
                                        U {{ $underPoint ?? '-' }} <span class="odds">{{ $underPrice !== null ? $underPrice : '-' }}</span>
                                    </div>
                                </td>
        
                                <td class="bet">
                                    <div onclick="openPickslip('Moneyline', '{{ $homeTeam }}', '', '{{ $homeMoneyline }}')">
                                        <span class="odds">{{ $homeMoneyline ?? '-' }}</span>
                                    </div>
                                    <div onclick="openPickslip('Moneyline', '{{ $awayTeam }}', '', '{{ $awayMoneyline }}')">
                                        <span class="odds">{{ $awayMoneyline ?? '-' }}</span>
                                    </div>
                                </td>
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
                        <div class="center-pick" style="display: none">
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
                        <div class="center-pick" style="display: none">
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

        let totalCollect = {
    straight: 0,
    parlay: 0
};

function openPickslip(type, team, point, price) {
    let pickslip = document.getElementById("pickslip");

    // Get both tabs
    let straightBetContainer = document.querySelector("#straight .scroll-div");
    let parlayBetContainer = document.querySelector("#parlay .scroll-div");

    pickslip.style.display = "block";
    pickslip.classList.add("open");

    let parsedPrice = parseFloat(price); // Convert price to float
    let absolutePrice = Math.abs(parsedPrice); // Convert negative price to positive

    // Create the bet HTML
    let newBetHTML = `
        <div class="center-pick">
            <div class="over">
                <h6>${type} - ${team}</h6>
                <h6 class="remove-bet" style="cursor: pointer;" onclick="removeBet(this)">❌</h6>
            </div>
            <div class="total">
                <h6>${point}</h6>
            </div>
            <div class="btuns-pick">
                <div class="pick-input">
                    <span>Pick</span>
                    <input type="number" oninput="calculateWin(this, ${parsedPrice})">
                </div>
                <div class="win-input">
                    <span>To Win</span>
                    <input type="text" value="0.00" disabled>
                </div>
            </div>
        </div>
    `;

    // Append the bet to both tabs (Straight & Parlay)
    let straightBet = document.createElement("div");
    straightBet.innerHTML = newBetHTML;
    straightBetContainer.appendChild(straightBet);

    let parlayBet = document.createElement("div");
    parlayBet.innerHTML = newBetHTML;
    parlayBetContainer.appendChild(parlayBet);
}

function calculateWin(input, price) {
    let pickValue = parseFloat(input.value) || 0; // User-entered bet amount
    let profit, totalPayout;

    let absolutePrice = Math.abs(price); // Convert negative price to positive

    // **Formula for Negative and Positive Price Values**
    if (price < 0) {
        profit = (pickValue * 100) / absolutePrice;
    } else {
        profit = (pickValue * price) / 100;
    }

    totalPayout = pickValue + profit; // "To Collect" amount

    // **Update UI**
    let betContainer = input.closest(".center-pick");
    let winInput = betContainer.querySelector(".win-input input");

    // **Remove old value before updating totalCollect**
    let previousCollectValue = parseFloat(winInput.dataset.collect || 0);
    totalCollect.straight -= previousCollectValue;
    totalCollect.parlay -= previousCollectValue;

    winInput.value = profit.toFixed(2);
    winInput.dataset.collect = totalPayout; // Store new collect value

    totalCollect.straight += totalPayout;
    totalCollect.parlay += totalPayout;

    document.querySelector(".collect h6:last-child").textContent = `$${totalCollect.straight.toFixed(2)}`;
}

// ✅ Function to Remove Bet and Subtract "To Collect" Amount
function removeBet(element) {
    let betContainer = element.closest(".center-pick");
    let winInput = betContainer.querySelector(".win-input input");

    let collectValue = parseFloat(winInput.dataset.collect || 0);
    totalCollect.straight -= collectValue;
    totalCollect.parlay -= collectValue;

    document.querySelector(".collect h6:last-child").textContent = `$${totalCollect.straight.toFixed(2)}`;

    // Remove both copies of the bet
    let betText = betContainer.querySelector("h6").textContent;
    document.querySelectorAll(".center-pick").forEach(bet => {
        if (bet.querySelector("h6").textContent === betText) {
            bet.remove();
        }
    });
}

// ✅ Function to Clear Pickslip
function closePickslip() {
    document.querySelectorAll(".scroll-div").forEach(div => div.innerHTML = "");
    document.getElementById("pickslip").style.display = "none";
    totalCollect.straight = 0;
    totalCollect.parlay = 0;
    document.querySelector(".collect h6:last-child").textContent = "$0.00";
}

// ✅ Function to Open Active Tab
function openTab(tabName) {
    document.querySelectorAll(".tab-content").forEach(tab => {
        tab.style.display = "none";
    });
    document.querySelectorAll(".tab").forEach(tab => {
        tab.classList.remove("active");
    });
    document.getElementById(tabName).style.display = "block";
    event.target.classList.add("active");
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
