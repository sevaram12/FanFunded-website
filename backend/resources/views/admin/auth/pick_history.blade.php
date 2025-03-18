@extends('admin.main.main')

@section('admin-content')
    <!-- Success Message -->
    @if (Session::has('success'))
        <div class="alert alert-success" role="alert" id="success-message">
            {{ Session::get('success') }}
        </div>
    @endif

    <div class="row mt-5">
        <div class="d-flex justify-content-between">
            <h6>Pick History</h6>
            <div class="history">

                <a class="dropdown-item sport-option">
                    <button class="btn btn-primary">ACTIVE</button>
                    <button class="btn btn-secondary">CLOSED</button>
                </a>

            </div>
        </div>
    </div>
    <div class="row mt-4">
        <table class="table ">
            <thead class="table-color">
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Sport</th>
                    <th scope="col">Event</th>
                    <th scope="col">League</th>
                    <th scope="col">Your Pick</th>
                    <th scope="col">odds</th>
                    <th scope="col">Pick</th>
                    <th scope="col">OutCome</th>
                    <th scope="col">Payout</th>
                    <th scope="col">Date</th>
                    <th scope="col">Game Date</th>
                </tr>
            </thead>
            <tbody class="table-data">

                @foreach ($pickslips as $bet)
                    <tr>
                        <th scope="row">{{ $bet->id }}</th>
                        <td>{{ $bet->sport }}</td>
                        <td>{{ $bet->home_team }} vs {{ $bet->away_team }}</td>
                        <td>{{ $bet->sport_title }}</td>
                        <td>{{ $bet->type }}</td>
                        <td>{{ $bet->price }}</td>
                        <td>{{ $bet->pick }}</td>
                        <td>{{ $bet->outcome }}</td>
                        <td>{{ $bet->total_collect }}</td>
                        <td>{{ $bet->commence_time }}</td>
                        <td>{{ $bet->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    </div>
    <!-- jQuery to handle AJAX call and fadeout success/error messages -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript">
        setTimeout(function() {
            $('#success-message').fadeOut('fast');
        }, 4000);
        setTimeout(function() {
            $('#error-message').fadeOut('fast');
        }, 4000);
    </script>
@endsection
