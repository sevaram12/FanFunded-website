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
                    <span class="">ACTIVE</span>
                    <span class="">CLOSED</span>
                </div>
            </div>
        </div>

        <div class="row mt-3">

            @foreach ($bettings as $betting)
                <div class="col-lg-4 align-itmes-center">
                    <div class="my-pick-box">
                        <div class="history-header d-flex justify-content-between align-itmes-center box">
                            <div class="d-flex align-itmes-center won">
                                <i class="fa-solid fa-basketball"></i>
                                <h6 class="status">Won</h6>
                            </div>
                            <h6 class="gapping">{{ $betting->commence_time }}</h6>
                        </div>
                        <div class="team">
                            <span>
                                {{ $betting->home_team }} vs {{ $betting->away_team }}
                            </span>
                        </div>
                        <div class="market">
                            <span>
                                {{ $betting->type }}
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
@endsection
