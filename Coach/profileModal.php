      <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <!-- <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown"> -->
               <?php  if (empty($url)) { ?>
                    <img src="../assets/img/avatar/user.jpg" alt="Profile" class="rounded-circle">
                <?php }else{ ?> 
                    <img src="<?=$url; ?>" alt="Profile" class="rounded-circle">
                <?php } ?>
            <!-- </a> -->
            <!-- <img src="../dashboard/assets/img/manicon.jpg" alt="Profile" class="rounded-circle"> -->
            <span class="d-none d-md-block dropdown-toggle ps-2"><?php//= $fullname; ?></span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6><?= $fullname; ?></h6>
              <span><?= $role; ?></span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="profile.php">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="settings.php">
                <i class="bi bi-gear"></i>
                <span>User Setting</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="#" data-bs-toggle="modal" data-bs-target="#helpModal">
                <i class="bi bi-question-circle"></i>
                <span>Help ?</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="authpass.php">
                <i class="bi bi-key"></i>
                <span>Change Password</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

          <!--   <li>
              <a class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#basicModal" href="#">
                <i class="bi bi-box-arrow-right"></i>
                <span>Setting</span>
              </a>
            </li>
 -->
             <li>
              <a class="dropdown-item d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#basicModal" href="#">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->