@extends('user.main.main')

@section('user-content')
    <h5 class="pt-5 pb-4">Picking Journal</h5>

    <h6 class="mt-5">Important Data</h6>

    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-3 my-pick-gap">
                <div class="my-picks-box">
                    <h6 class="pb-2">Current Balance</h6>
                    <h5>$1,023.45</h5>
                </div>
            </div>

            <div class="col-lg-3 my-pick-gap">
                <div class="my-picks-box">
                    <h6 class="pb-2">Number of Picks</h6>
                    <h5>8</h5>
                </div>
            </div>
            <div class="col-lg-3 my-pick-gap">
                <div class="my-picks-box">
                    <h6 class="pb-2">Highest Winning Pick</h6>
                    <h5>13.20%</h5>
                </div>
            </div>
            <div class="col-lg-3 my-pick-gap">
                <div class="my-picks-box">
                    <h6 class="pb-2">Picks Won</h6>
                    <h5>4</h5>
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
        </div>


        <div class="row">
            <div class="d-flex justify-content-between">
                <h6>Pick History</h6>
                <div class="history">
                    <button class="filter-btn active" data-filter="active">ACTIVE</button>
                    <button class="filter-btn" data-filter="closed">CLOSED</button>
                </div>
            </div>
        </div>
        
        <div class="row mt-3">
            @foreach ($bettings as $betting)
                @php
                    // Flatten all game data from different sports
                    $flattenedScores = collect($allScores)->flatMap(function ($sport) {
                        return $sport; // Extracting all games
                    });
        
                    // Find matching game by bet_id
                    $matchingScore = $flattenedScores->firstWhere('id', $betting->bet_id);
        
                    // Determine status: Active if completed == false, otherwise Closed
                    $isActive = $matchingScore && isset($matchingScore['completed']) && !$matchingScore['completed'];
                @endphp
        
                <div class="col-lg-4 betting-record" data-status="{{ $isActive ? 'active' : 'closed' }}">
                    <div class="my-pick-box">
                        <div class="history-header d-flex justify-content-between align-items-center box">
                            <div class="d-flex align-items-center won">
                                <i class="fa-solid fa-basketball"></i>
                                <h6 class="status">{{ $isActive ? 'Active' : 'Closed' }}</h6>
                            </div>
                            <h6 class="gapping">{{ $betting->commence_time }}</h6>
                        </div>
                        <div class="team">
                            <span>{{ $betting->home_team }} vs {{ $betting->away_team }}</span>
                        </div>
                        <div class="market">
                            <span>{{ $betting->type }}</span>
                        </div>
                        <div class="bet-team d-flex justify-content-between">
                            <p>Austin Peay -2.5</p>
                            <p>-166</p>
                        </div>
                        <div class="bet-team">
                            <p>Feb 18 6:30 PM (EST)</p>
                        </div>
                        <hr>
                        <div class="price">
                            <div class="total-pick bet-team d-flex justify-content-between">
                                <p>Total Pick</p>
                                <h6>{{ $betting->pick }}</h6>
                            </div>
                            <div class="total-pick bet-team d-flex justify-content-between">
                                <p>Payout</p>
                                <h6>{{ $betting->total_collect }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>


    <script>
        document.querySelectorAll(".history button").forEach(button => {
            button.addEventListener("click", function() {
                document.querySelectorAll(".history button").forEach(btn => btn.classList.remove("active"));
                this.classList.add("active");
            });
        });

        document.querySelectorAll('.filter-btn').forEach(button => {
    button.addEventListener('click', function() {
        document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
        this.classList.add('active');

        let filter = this.getAttribute('data-filter');
        document.querySelectorAll('.betting-record').forEach(record => {
            if (record.getAttribute('data-status') === filter) {
                record.style.display = "block";
            } else {
                record.style.display = "none";
            }
        });
    });
});
    </script>
@endsection
