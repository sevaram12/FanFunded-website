@extends('user.main.main')

@section('user-content')
    <div class="main-content">
        <div class="container-schedule" id="schedule-container">
            <table class="schedule-table">
                <thead>
                    <tr>
                        <th>Time</th>
                        <th>MMA Fighters</th>
                        <th>Point Spread</th>
                        <th>Total Points</th>
                        <th>Moneyline</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($oddsData as $item)
                        @php
                            $draftKings = collect($item['bookmakers'])->firstWhere('key', 'draftkings');
                            $homeTeam = $item['home_team'];
                            $awayTeam = $item['away_team'];
            
                            // Extract Point Spread Data
                            $spreadMarket = collect($draftKings['markets'] ?? [])->firstWhere('key', 'spreads');
                            $homePoint = $awayPoint = $homePrice = $awayPrice = null;
            
                            if ($spreadMarket) {
                                foreach ($spreadMarket['outcomes'] as $outcome) {
                                    if ($outcome['name'] === $homeTeam) {
                                        $homePoint = $outcome['point'];
                                        $homePrice = $outcome['price'];
                                    } elseif ($outcome['name'] === $awayTeam) {
                                        $awayPoint = $outcome['point'];
                                        $awayPrice = $outcome['price'];
                                    }
                                }
                            }
            
                            // Extract Total Points Data
                            $totalMarket = collect($draftKings['markets'] ?? [])->firstWhere('key', 'totals');
                            $overPoint = $underPoint = $overPrice = $underPrice = null;
            
                            if ($totalMarket) {
                                foreach ($totalMarket['outcomes'] as $outcome) {
                                    if ($outcome['name'] === 'Over') {
                                        $overPoint = $outcome['point'];
                                        $overPrice = $outcome['price'];
                                    } elseif ($outcome['name'] === 'Under') {
                                        $underPoint = $outcome['point'];
                                        $underPrice = $outcome['price'];
                                    }
                                }
                            }
            
                            // Extract Moneyline Data
                            $moneylineMarket = collect($draftKings['markets'] ?? [])->firstWhere('key', 'h2h');
                            $homeMoneyline = $awayMoneyline = null;
            
                            if ($moneylineMarket) {
                                foreach ($moneylineMarket['outcomes'] as $outcome) {
                                    if ($outcome['name'] === $homeTeam) {
                                        $homeMoneyline = $outcome['price'];
                                    } elseif ($outcome['name'] === $awayTeam) {
                                        $awayMoneyline = $outcome['price'];
                                    }
                                }
                            }
                        @endphp
            
                        @if ($draftKings)
                            <tr>
                                <!-- Time -->
                                <td>
                                    <span>{{ \Carbon\Carbon::parse($item['commence_time'])->format('g:i A') }}</span>
                                    <span class="date">{{ \Carbon\Carbon::parse($item['commence_time'])->format('M j') }}</span>
                                </td>
            
                                <!-- Fighters -->
                                <td>
                                    <div class="fighter">
                                       
                                        <span>{{ $homeTeam }}</span>
                                    </div>
                                    <div class="fighter">
                                       
                                        <span>{{ $awayTeam }}</span>
                                    </div>
                                </td>
            
                                <!-- Point Spread -->
                                <td class="bet">
                                    <div onclick="openPickslip('Point Spread', '{{ $homeTeam }} {{ $homePoint }} {{ $homePrice }}')">
                                        {{ $homePoint !== null ? $homePoint : '-' }} 
                                        <span class="odds">{{ $homePrice !== null ? $homePrice : '-' }}</span>
                                    </div>
                                    <div onclick="openPickslip('Point Spread', '{{ $awayTeam }} {{ $awayPoint }} {{ $awayPrice }}')">
                                        {{ $awayPoint !== null ? $awayPoint : '-' }} 
                                        <span class="odds">{{ $awayPrice !== null ? $awayPrice : '-' }}</span>
                                    </div>
                                </td>
            
                                <!-- Total Points -->
                                <td class="bet">
                                    <div onclick="openPickslip('Total Points', 'Over {{ $overPoint }} {{ $overPrice }}')">
                                        O {{ $overPoint !== null ? $overPoint : '-' }} 
                                        <span class="odds">{{ $overPrice !== null ? $overPrice : '-' }}</span>
                                    </div>
                                    <div onclick="openPickslip('Total Points', 'Under {{ $underPoint }} {{ $underPrice }}')">
                                        U {{ $underPoint !== null ? $underPoint : '-' }} 
                                        <span class="odds">{{ $underPrice !== null ? $underPrice : '-' }}</span>
                                    </div>
                                </td>
            
                                <!-- Moneyline -->
                                <td class="bet">
                                    <div onclick="openPickslip('Moneyline', '{{ $homeTeam }} {{ $homeMoneyline }}')">
                                        <span class="odds">{{ $homeMoneyline !== null ? $homeMoneyline : '-' }}</span>
                                    </div>
                                    <div onclick="openPickslip('Moneyline', '{{ $awayTeam }} {{ $awayMoneyline }}')">
                                        <span class="odds">{{ $awayMoneyline !== null ? $awayMoneyline : '-' }}</span>
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
                <div class="tab-content" id="straight">

                    <div class="scroll-div">
                        <div class="center-pick">
                            <div class="over">
                                <h6>Over 2.5</h6>
                                <h6>❌</h6>
                            </div>
                            <div class="total">
                                <!-- <h6>Total Rounds</h6> -->
                                <h6 id="pick-info"></h6>
                            </div>
                            <div class="date-time">
                                <h6>Mar 9 5:20 AM</h6>
                            </div>
                            <div class="btuns-pick">
                                <div class="pick-input">
                                    <span>Pick</span>
                                    <input type="number" value="987">
                                </div>
                                <div class="win-input">
                                    <span>To Win</span>
                                    <input type="text" value="313.33" disabled>
                                </div>
                            </div>

                        </div>

                        <div class="center-pick">
                            <div class="over">
                                <h6>Over 2.5</h6>
                                <h6>❌</h6>
                            </div>
                            <div class="total">
                                <!-- <h6>Total Rounds</h6> -->
                                <h6 id="pick-info"></h6>
                            </div>
                            <div class="date-time">
                                <h6>Mar 9 5:20 AM</h6>
                            </div>
                            <div class="btuns-pick">
                                <div class="pick-input">
                                    <span>Pick</span>
                                    <input type="number" value="987">
                                </div>
                                <div class="win-input">
                                    <span>To Win</span>
                                    <input type="text" value="313.33" disabled>
                                </div>
                            </div>

                        </div>
                        <div class="center-pick">
                            <div class="over">
                                <h6>Over 2.5</h6>
                                <h6>❌</h6>
                            </div>
                            <div class="total">
                                <!-- <h6>Total Rounds</h6> -->
                                <h6 id="pick-info"></h6>
                            </div>
                            <div class="date-time">
                                <h6>Mar 9 5:20 AM</h6>
                            </div>
                            <div class="btuns-pick">
                                <div class="pick-input">
                                    <span>Pick</span>
                                    <input type="number" value="987">
                                </div>
                                <div class="win-input">
                                    <span>To Win</span>
                                    <input type="text" value="313.33" disabled>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="tab-content" id="parlay" style="display: none;">
                    <div class="scroll-div">
                        <div class="center-pick">
                            <div class="over">
                                <h6>Over 2.5</h6>
                                <h6>❌</h6>
                            </div>
                            <div class="total">
                                <!-- <h6>Total Rounds</h6> -->
                                <h6 id="pick-info"></h6>
                            </div>
                            <div class="date-time">
                                <h6>Mar 9 5:20 AM</h6>
                            </div>
                            <div class="btuns-pick">
                                <div class="pick-input">
                                    <span>Pick</span>
                                    <input type="number" value="987">
                                </div>
                                <div class="win-input">
                                    <span>To Win</span>
                                    <input type="text" value="313.33" disabled>
                                </div>
                            </div>

                        </div>

                        <div class="center-pick">
                            <div class="over">
                                <h6>Over 2.5</h6>
                                <h6>❌</h6>
                            </div>
                            <div class="total">
                                <!-- <h6>Total Rounds</h6> -->
                                <h6 id="pick-info"></h6>
                            </div>
                            <div class="date-time">
                                <h6>Mar 9 5:20 AM</h6>
                            </div>
                            <div class="btuns-pick">
                                <div class="pick-input">
                                    <span>Pick</span>
                                    <input type="number" value="987">
                                </div>
                                <div class="win-input">
                                    <span>To Win</span>
                                    <input type="text" value="313.33" disabled>
                                </div>
                            </div>

                        </div>
                        <div class="center-pick">
                            <div class="over">
                                <h6>Over 2.5</h6>
                                <h6>❌</h6>
                            </div>
                            <div class="total">
                                <!-- <h6>Total Rounds</h6> -->
                                <h6 id="pick-info"></h6>
                            </div>
                            <div class="date-time">
                                <h6>Mar 9 5:20 AM</h6>
                            </div>
                            <div class="btuns-pick">
                                <div class="pick-input">
                                    <span>Pick</span>
                                    <input type="number" value="987">
                                </div>
                                <div class="win-input">
                                    <span>To Win</span>
                                    <input type="text" value="313.33" disabled>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="collect">
                    <h6>To Collect</h6>
                    <h6>$0.00</h6>
                </div>
                <!-- <p id="pick-info">Select a bet</p> -->

                <div class="last-pick-btn">
                    <button class="btn-clear" onclick="closePickslip()">Clear</button>
                    <button class="white-pick">Pick Place</button>
                </div>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <script>
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
          document.getElementById('pick-info').innerText = `${type}: ${value}`;
          document.getElementById('pickslip').classList.add('open');
          document.getElementById('schedule-container').classList.add('shrink');
      }
      
      
      function closePickslip() {
          document.getElementById('pick-info').innerText = 'Select a bet';
          document.getElementById('pickslip').classList.remove('open');
          document.getElementById('schedule-container').classList.remove('shrink');
      }
      
  </script>
      
@endsection
