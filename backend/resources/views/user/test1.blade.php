@extends('user.main.main')

@section('user-content')

<!-- ----------------------------------------------------------------- -->

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