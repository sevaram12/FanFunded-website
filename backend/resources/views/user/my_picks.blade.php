@extends('user.main.main')

@section('user-content')

    @if (Session::has('success'))
        <div class="alert alert-success" role="alert" id="success-message">
            {{ Session::get('success') }}
        </div>
    @endif

    @if (session('fail'))
        <div class="alert alert-danger" id="error-message">
            {{ session('fail') }}
        </div>
    @endif
    
    
      @if(session('error'))
        <div class="alert alert-danger" id="error-message">
            {{ session('error') }}
        </div>
    @endif


    <h5 class="pt-5 pb-4">Picking Journal</h5>

    <h6 class="mt-5">Important Data</h6>

    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-3 my-pick-gap">
                <div class="my-picks-box">
                    <h6 class="pb-2">Current Balance</h6>
                    <h5>${{$your_balance}}</h5>
                </div>
            </div>

            <div class="col-lg-3 my-pick-gap">
                <div class="my-picks-box">
                    <h6 class="pb-2">Number of Picks</h6>
                    <h5>{{$no_of_pick}}</h5>
                </div>
            </div>
            <div class="col-lg-3 my-pick-gap">
                <div class="my-picks-box">
                    <h6 class="pb-2">Highest Winning Pick</h6>
                    <h5>{{ $highestWinningPickPercentage}}%</h5>
                </div>
            </div>
            <div class="col-lg-3 my-pick-gap">
                <div class="my-picks-box">
                    <h6 class="pb-2">Picks Won</h6>
                    <h5>{{ $pick_won }}</h5>
                </div>
            </div>
            <div class="col-lg-3 my-pick-gap">
                <div class="my-picks-box">
                    <h6 class="pb-2">Picks Loss</h6>
                    <h5>{{ $pick_loss }}</h5>
                </div>
            </div>
            <div class="col-lg-3 my-pick-gap">
                <div class="my-picks-box">
                    <h6 class="pb-2">Win Rate</h6>
                    <h5>{{ $win_rate }}%</h5>
                </div>
            </div>
            <div class="col-lg-3 my-pick-gap">
                <div class="my-picks-box">
                    <h6 class="pb-2">Loss Rate</h6>
                    <h5>{{ $loss_rate }}%</h5>
                </div>
            </div>
            <div class="col-lg-3 my-pick-gap">
                <div class="my-picks-box">
                    <h6 class="pb-2">Average Profit Per Pick</h6>
                    <h5>${{ $averageProfitPerPickDollar }}</h5>
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
                    // If match_status is "Active", set it to "active"; otherwise, set it to "closed"
                    $statusClass = ($betting->match_status == 'Active') ? 'active' : 'closed';
                @endphp
        
                <div class="col-lg-4 betting-record mb-5" data-status="{{ $statusClass }}">
                    <div class="my-pick-box">
                        <div class="history-header d-flex justify-content-between align-items-center box">
                            <div class="d-flex align-items-center won">
                                <i class="fa-solid fa-basketball"></i>
                                <h6 class="status {{ $betting->match_status == 'Lost' ? 'bg-red' : '' }}">
                                    {{ $betting->match_status }}
                                </h6>
                                
                            </div>
                            <h6 class="gapping">{{ $betting->commence_time }}</h6>
                        </div>
                        <div class="team">
                            <span>{{ $betting->home_team }} vs {{ $betting->away_team }}</span>
                        </div>
                        @php
                            $parts = explode(" - ", $betting->type, 2);
                        @endphp
                        <div class="market">
                            <span>{{ $parts[0] ?? '' }}</span>
                        </div>
                        <div class="bet-team d-flex justify-content-between">
                            <p>{{ $betting->your_bet_team }}</p>
                            <p>{{ $betting->price }}</p>
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
                        <a href="{{url('cashout/'.$betting->id)}}">
                            <div class="cashout">
                                Cashout
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        
    </div>


    <script>
        document.querySelectorAll(".history button").forEach(button => {
    button.addEventListener("click", function () {
        document.querySelectorAll(".history button").forEach(btn => btn.classList.remove("active"));
        this.classList.add("active");
    });
});

document.querySelectorAll('.filter-btn').forEach(button => {
    button.addEventListener('click', function () {
        document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
        this.classList.add('active');

        let filter = this.getAttribute('data-filter');
        document.querySelectorAll('.betting-record').forEach(record => {
            record.style.display = (record.getAttribute('data-status') === filter) ? "block" : "none";
        });
    });
});

// Auto-trigger "Active" filter on page load
window.addEventListener("DOMContentLoaded", function() {
    document.querySelector('.filter-btn[data-filter="active"]').click();
});
    </script>
@endsection
