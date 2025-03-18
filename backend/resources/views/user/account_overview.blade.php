@extends('user.main.main')

@section('user-content')
    <div class="container pt-5">
        <div class="row">
            <div class="col-lg-4">
                <div class="balance">
                    {{-- <img src="{{asset('assets/images/bg-balance.png')}}" alt=""> --}}
                    <h5 class="bet-team">Balance</h5>
                    <h1 class="bet-team">$1,015.71</h1>
                    <div class="d-flex bet-team">
                        <span class="balance-percentage">$26.71</span>
                        <span class="balance-percentage circle">2.67%</span>
                    </div>
                </div>
                <div class="pick">
                    Pick
                </div>
            </div>

            <div class="col-lg-8">
                <div class="cup">
                    <h5>Challenge Info</h5>
                    <div class="d-flex justify-content-between pt-5 challenge">
                        <h6>Start Date</h6>
                        <p>Feb 18 12:53 PM (EST)</p>
                    </div>
                    <div class="d-flex justify-content-between challenge">
                        <h6>Start Date</h6>
                        <p>Feb 18 12:53 PM (EST)</p>
                    </div>
                    <div class="d-flex justify-content-between challenge">
                        <h6>End Date</h6>
                        <p>03/21/25 4:04 AM</p>
                    </div>
                    <div class="d-flex justify-content-between challenge">
                        <h6>Challenge</h6>
                        <p>1k2Step - Phase1</p>
                    </div>
                    <div class="d-flex justify-content-between challenge">
                        <h6>Account size</h6>
                        <p>$1,000.00</p>
                    </div>
                    <div class="d-flex justify-content-between challenge">
                        <h6>Profit</h6>
                        <p class="profit">$26.71</p>
                    </div>
                </div>
            </div>

            {{-- <div class="col-lg-8">
      <div class="d-flex justify-content-between align-items-center">
        <h6>Pick Objectives</h6>
        <p class="in-progress"><span class="dot">•</span>In Progress</p>
      </div>

      <div class="pick-objective">
        <div class="d-flex">
          <div class="col-lg-7">
            <p># of Picks</p>
          </div>
          <div class="col-lg-5">
            <p>8/25</p>
          </div>
        </div>
      </div>
    </div> --}}
        </div>

        <div class="row mt-5">
            <div class="d-flex justify-content-between">
                <h6>Pick History</h6>
                <div class="history">
                    <button class="filter-btn active" data-filter="active">ACTIVE</button>
                    <button class="filter-btn" data-filter="closed">CLOSED</button>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <table class="table">
                <thead class="table-color">
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Sport</th>
                        <th scope="col">Event</th>
                        <th scope="col">League</th>
                        <th scope="col">Your Pick</th>
                        <th scope="col">Odds</th>
                        <th scope="col">Pick</th>
                        <th scope="col">Outcome</th>
                        <th scope="col">Payout</th>
                        <th scope="col">Date</th>
                        <th scope="col">Game Date</th>
                    </tr>
                </thead>
                <tbody class="table-data">
                    @foreach ($bettings as $bet)
                        @php
                            // Flatten all scores from different sports
                            $flattenedScores = collect($allScores)->flatMap(fn($sport) => $sport);

                            // Find matching game by bet_id
                            $matchingScore = $flattenedScores->firstWhere('id', $bet->bet_id);

                            // Determine outcome: Active if completed == false, otherwise Closed
                            $isActive =
                                $matchingScore && isset($matchingScore['completed']) && !$matchingScore['completed'];
                            $outcome = $isActive ? 'Active' : 'Closed';
                        @endphp

                        <tr class="betting-record" data-status="{{ $isActive ? 'active' : 'closed' }}">
                            <th scope="row">{{ $bet->id }}</th>
                            <td>{{ $bet->sport }}</td>
                            <td>{{ $bet->home_team }} vs {{ $bet->away_team }}</td>
                            <td>{{ $bet->sport_title }}</td>
                            <td>{{ $bet->type }}</td>
                            <td>{{ $bet->price }}</td>
                            <td>{{ $bet->pick }}</td>
                            <td class="outcome-status">{{ $outcome }}</td> <!-- Updated Outcome Column -->
                            <td>{{ $bet->total_collect }}</td>
                            <td>{{ $bet->commence_time }}</td>
                            <td>{{ $bet->created_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

<script>
  document.querySelectorAll('.filter-btn').forEach(button => {
      button.addEventListener('click', function() {
          document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
          this.classList.add('active');
  
          let filter = this.getAttribute('data-filter');
          document.querySelectorAll('.betting-record').forEach(record => {
              if (record.getAttribute('data-status') === filter) {
                  record.style.display = "table-row";
              } else {
                  record.style.display = "none";
              }
          });
      });
  });
  
  // Initially show only Active bets
  document.addEventListener("DOMContentLoaded", function() {
      document.querySelectorAll('.betting-record[data-status="closed"]').forEach(row => row.style.display = "none");
  });
</script>
@endsection
