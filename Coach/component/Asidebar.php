<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link " href="dashboard">
          <i class="bi bi-grid"></i>
          <span>DASHBOARD</span>
        </a>
      </li>
      <!-- End Dashboard Nav -->


      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-people"></i><span>Player Module</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
       
          <li>
            <a href="player_list">
              <i class="bi bi-circle"></i><span>Player List</span>
            </a>
          </li>

           <li>
            <a href="injury_list">
              <i class="bi bi-circle"></i><span>Injury List</span>
            </a>
          </li>

        <!--    <li>
            <a href="discpline_list">
              <i class="bi bi-circle"></i><span>Discpline List</span>
            </a>
          </li> -->

        </ul>
      </li>


       <li class="nav-item">
          <a class="nav-link collapsed" data-bs-target="#forms-navtraining" data-bs-toggle="collapse" href="#">
            <i class="bi bi-calendar2-week"></i><span>Training Schedule</span><i class="bi bi-chevron-down ms-auto"></i>
          </a>
          <ul id="forms-navtraining" class="nav-content collapse" data-bs-parent="#sidebar-nav">
            <li>
              <a href="new_sckedule">
                <i class="bi bi-circle"></i><span>Add Schedule</span>
              </a>
            </li>
            <li>
              <a href="sckedule_list">
                <i class="bi bi-circle"></i><span>Schedule List</span>
              </a>
            </li>
          </ul>
      </li>


       <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#forms-nav1" data-bs-toggle="collapse" href="#">
        <i class="bi bi-trophy-fill"></i><span>Game Match Module</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="forms-nav1" class="nav-content collapse" data-bs-parent="#sidebar-nav">
       <!--  <li>
          <a href="new_match">
            <i class="bi bi-circle"></i><span>Add Match Result</span>
          </a>
        </li> -->
        <li>
          <a href="recent_result">
            <i class="bi bi-circle"></i><span>Recent Match Result</span>
          </a>
        </li>

       <!--  <li>
          <a href="upcomimg_match">
            <i class="bi bi-circle"></i><span>Add Upcoming Match</span>
          </a>
        </li> -->
        <li>
          <a href="upcomimg_matchlist">
            <i class="bi bi-circle"></i><span>Upcoming Match</span>
          </a>
        </li>
      </ul>
    </li>


      <!-- End Icons Nav -->

      <li class="nav-heading">Pages</li>

        <li class="nav-item">
        <a class="nav-link collapsed" href="settings">
          <i class="bi bi-question-circle"></i>
          <span>Setting</span>
        </a>
      </li>
    <li class="nav-item">
      <a class="nav-link collapsed" href="profile">
        <i class="bi bi-person-circle"></i>
        <span>Profile</span>
      </a>
    </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="authpass">
          <i class="bi bi-info-circle"></i>
          <span>Change Password ?</span> 
        </a>
      </li>
    
    <li class="nav-item">
        <a class="nav-link collapsed" href="../pages-logout.php">
          <i class="bi bi-info-circle"></i>
          <span>Sign Out ?</span> 
        </a>
      </li>
    

    </ul>

  </aside>