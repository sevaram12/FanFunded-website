@extends('admin.main.main')

@section('admin-content')


   <!-- ----------------------------------------------------------------- -->
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

   <div class="New-Header">
    <div class="new-navbar-wrapper">
        <div class="new-navbar">
            <div class="dropdown">
                <button class="dropbtn">
                    UFC
                    <span class="arrow">&#9662;</span>
                </button>
                <div class="dropdown-content">
                    <a href="#">Option 1</a>
                    <a href="#">Option 2</a>
                    <a href="#">Option 3</a>
                </div>
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
    </div>
</div>


<!-- -------------------------------------------------------------------- -->

<div class="main-content">
<div class="container-schedule" id="schedule-container">
<table class="schedule-table">
  <thead>
      <tr>
          <th>Time</th>
          <th>MMA Fighters</th>
          <th>Point Spread	</th>
          <th>Total Points</th>
          <th>Moneyline</th>
      </tr>
  </thead>
  <tbody>
      <tr>
          <td>
              <span>5:00 AM</span>
              <span class="date">Mar 9</span>
          </td>
          <td>
              <div class="fighter">
                  <img src="https://via.placeholder.com/24" alt="Ozzy Diaz">
                  <span>Ozzy Diaz</span>
                        </div>
              <div class="fighter">
                  <img src="https://via.placeholder.com/24" alt="Djorden Santos">
                  <span>Djorden Santos</span>
              </div>
          </td>
          
          <td class="bet">
              <div onclick="openPickslip('Total Rounds', 'O 2.5 +114')">O 2.5 <span class="odds">+114</span></div>
              <div onclick="openPickslip('Total Rounds', 'U 2.5 -145')">U 2.5 <span class="odds">-145</span></div>
          </td>
          <td class="bet">
              <div onclick="openPickslip('Moneyline', '+164')"><span class="odds">+164</span></div>
              <div onclick="openPickslip('Moneyline', '-198')"><span class="odds">-198</span></div>
          </td>
          <td class="bet">
          <div onclick="openPickslip('Moneyline', '+164')"><span class="odds">+164</span></div>
          <div onclick="openPickslip('Moneyline', '-198')"><span class="odds">-198</span></div>  
        </td>
      </tr>
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
              <h6  id="pick-info"></h6>
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
              <h6  id="pick-info"></h6>
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
              <h6  id="pick-info"></h6>
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
              <h6  id="pick-info"></h6>
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
              <h6  id="pick-info"></h6>
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
              <h6  id="pick-info"></h6>
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

    

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"><script>



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



<!-- ----------------------------------------------------------------- -->
@endsection