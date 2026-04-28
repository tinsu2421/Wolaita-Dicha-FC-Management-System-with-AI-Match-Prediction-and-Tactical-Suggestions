
<?php
  // require __DIR__.'../CommonFunction/CommenForEveryUserFunction.php';
  require __DIR__.'\Auth\auth.php';
  $CommonOBJ = new Auth();
  session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Wolaita Dicha SC – Home</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="assets/img/dichaLogo.jpg" rel="icon">
  <link href="assets/img/dichaLogo.jpg" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <!-- <link href="assets/css/main.css" rel="stylesheet"> -->
  <link href="assets/css/dicha.css" rel="stylesheet">
  <link href="assets/css/dichacss.css" rel="stylesheet">
  <link href="assets/css/login.css" rel="stylesheet">
  <link href="assets/css/upcomingsection.css" rel="stylesheet">

  <style type="text/css">
    #hero .row.align-items-center {
      min-height: 50vh; /* adjust height as needed */
      display: flex;
      justify-content: center; /* horizontal centering */
      align-items: center;    /* vertical centering */
      text-align: center;     /* center text */
    }



    @media (max-width: 768px) {
      .match-card {
        flex-direction: column;
      }
      .team, .middle {
        width: 100%;
      }
    }



    /* Mobile fix */
  @media (max-width: 768px) {
    .about-images .row > div {
      width: 100% !important;      /* Force each column to full width */
      max-width: 100% !important;
      flex: 0 0 100% !important;   /* Stack vertically */
    }

    .about-images img {
      width: 100%;
      height: auto;
    }
  }


/* Section background */
.epl-standing-section {
    padding: 70px 20px;
    background: #f7f9fc;
    font-family: "Poppins", sans-serif;
}

/* Wrapper */
.standing-wrapper {
    max-width: 1100px;
    margin: auto;
    text-align: center;
}

/* Title */
.standing-title {
    font-size: 32px;
    color: #222;
    font-weight: 700;
    margin-bottom: 20px;
}

/* Table container */
.table-container {
    background: #ffffff;
    padding: 25px;
    border-radius: 18px;
    box-shadow: 0 10px 35px rgba(0,0,0,0.06);
    overflow-x: auto;
}

/* Table */
.standing-table {
    width: 100%;
    border-collapse: collapse;
    color: #333;
    font-size: 16px;
    min-width: 800px;
}

/* Header */
.standing-table thead {
    background: #eef3ff;
}

.standing-table th {
    padding: 14px 10px;
    text-transform: uppercase;
    font-size: 13px;
    letter-spacing: 0.5px;
    color: #3b4cca;
}

/* Body rows */
.standing-table td {
    padding: 14px 10px;
    border-bottom: 1px solid #eee;
}

/* Hover effect */
.standing-table tbody tr:hover {
    background: #f1f5ff;
    transition: 0.25s;
}

/* Club column */
.standing-table td:nth-child(2) {
    text-align: left;
}

/* Club logo */
.club-logo {
    width: 32px;
    height: 32px;
    object-fit: cover;
    border-radius: 50%;
    margin-right: 10px;
    vertical-align: middle;
}

/* Points styling */
.points {
    font-weight: 700;
    font-size: 18px;
    color: #2c7a00;
}

/* Responsive */
@media (max-width: 768px) {
    .standing-title {
        font-size: 26px;
    }

    .standing-table {
        font-size: 14px;
    }

    .club-logo {
        width: 26px;
        height: 26px;
    }
}


  </style>
</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container position-relative d-flex align-items-center justify-content-between">

      <a href="index.php" class="logo d-flex align-items-center me-auto me-xl-0">
        <img src="assets/img/dichaLogoCurrent1.jpg" alt="" style="max-height: 110px; max-width: 80px;">
        <!-- <h1 class="sitename">Invent</h1><span>.</span> -->
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="index.php" class="active">Home</a></li>
          <li><a href="#about">About</a></li>
          <li><a href="reg_fans.php?r">Fan</a></li>
          <li><a href="#match-results">Fixtures & Results</a></li>
          <li><a href="#standing">Standing Table</a></li>
          
          <li><a href="#contact">Contact</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <a class="btn-getstarted" href="pages_login.php?login">Login</a>

    </div>
  </header>

  <main class="main">
    <!-- Hero Section -->

    <!-- Hero Section -->
    <section id="hero" class="hero section" style="background-color: white;">

      <div class="container" data-aos="" data-aos-delay="100">

       <div class="row align-items-center mb-5">
        <div class="col-lg-12 mb-4 mb-lg-0">
          <div class="badge-wrapper mb-3">
            <div class="d-inline-flex align-items-center rounded-pill border border-accent-light">
              <div class="icon-circle me-2">
                <i class="bi bi-bell"></i>
              </div>
              <span class="badge-text me-3">Pride of Wolaita</span>
            </div>
          </div>

          <h1 class="hero-title mb-4">የጦና ንቦች ! - Welcome to the Bees of Tona.</h1>

          <p class="hero-description mb-4">From the heart of Sodo, Wolaita Dicha SC embodies passion, unity, and excellence in Ethiopian football.</p>
          <p class="hero-description mb-4">Passion. Pride. Wolaita Dicha.</p>

          <!-- <div class="cta-wrapper">
            <a href="http//localhost:5002" target="__blank" class="btn btn-primary">Match Prediction</a>
          </div> -->
              <div class="cta-wrapper d-flex justify-content-center">
                  <a href="http://localhost:5002/" 
                     target="_blank" 
                     rel="noopener noreferrer" 
                     class="btn btn-primary d-flex align-items-center justify-content-center">
                      <i class="bi bi-cpu-fill me-2 rotate-icon"></i>
                      አርቴፊሻል ኢንቴሌግኒሲ የእግር ኳስ ግጥሚያ ትንበያ ስርዓት / AI Match Prediction System
                  </a>
              </div>

              <style>
              .rotate-icon {
                  animation: rotate 2s linear infinite;
              }

              @keyframes rotate {
                  0% {
                      transform: rotate(0deg);
                  }
                  100% {
                      transform: rotate(360deg);
                  }
              }

              /* Ensure cta-wrapper is full width on mobile */
              .cta-wrapper {
                  width: 100%;
              }
              </style>

        </div>
      </div>


        <div class="row feature-boxes">
          <div class="col-lg-4 mb-4 mb-lg-0" data-aos="fade-up" data-aos-delay="200">
        <div class="feature-box bg-light p-4 rounded shadow-sm text-center h-100">
          <div class="feature-icon mb-3">
            <i class="bi bi-people-fill text-primary fs-2"></i>
          </div>
          <div class="feature-content">
            <h3 class="feature-title fw-bold">Team Unity</h3>
            <p class="feature-text">Strength through solidarity. Every player, every fan, every match – together as one.</p>
          </div>
        </div>
      </div>

      <div class="col-lg-4 mb-4 mb-lg-0" data-aos="fade-up" data-aos-delay="300">
        <div class="feature-box bg-light p-4 rounded shadow-sm text-center h-100">
          <div class="feature-icon mb-3">
            <i class="bi bi-trophy-fill text-warning fs-2"></i>
          </div>
          <div class="feature-content">
            <h3 class="feature-title fw-bold">Winning Spirit</h3>
            <p class="feature-text">Every game is a chance to shine. Wolaita Dicha never stops striving for victory.</p>
          </div>
        </div>
      </div>

      <div class="col-lg-4" data-aos="fade-up" data-aos-delay="400">
        <div class="feature-box bg-light p-4 rounded shadow-sm text-center h-100">
          <div class="feature-icon mb-3">
            <i class="bi bi-heart-fill text-danger fs-2"></i>
          </div>
          <div class="feature-content">
            <h3 class="feature-title fw-bold">Fan Passion</h3>
            <p class="feature-text">From the stands of Sodo to every corner of Ethiopia, our fans are the heartbeat of the club.</p>
          </div>
        </div>
      </div>
        </div>

      </div>

    </section><!-- /Hero Section -->


<!-- Include Swiper CSS -->
<link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"
/>

   <!-- About Section -->
<section id="about" class="about section">

  <div class="container">

    <div class="row gy-4">

      <div class="col-lg-6 content" data-aos="fade-up" data-aos-delay="100">
        <p class="who-we-are">Who We Are</p>
        <h3>Wolaita Dicha Football Club – The Pride of Wolaita</h3>
        <p class="fst-italic">
          Wolaita Dicha FC, affectionately known as “The Bees of Tona,” is one of Ethiopia’s most passionate football clubs, 
          representing the vibrant people of Wolaita Zone. Founded to bring local talent to the national stage, the club 
          has become a symbol of determination, teamwork, and pride.
        </p>
        <ul>
          <li><i class="bi bi-check-circle"></i> <span>Founded in 2009 and based in Wolaita Sodo, Ethiopia.</span></li>
          <li><i class="bi bi-check-circle"></i> <span>Home matches are played at the Wolaita Sodo Stadium, known for its energetic and loyal fan base.</span></li>
          <li><i class="bi bi-check-circle"></i> <span>Achieved national recognition by winning the 2017 Ethiopian Cup and participating in the CAF Confederation Cup.</span></li>
        </ul>
        <a href="#" class="read-more"><span>Learn More</span><i class="bi bi-arrow-right"></i></a>
      </div>

      <div class="col-lg-6 about-images" data-aos="fade-up" data-aos-delay="200">
            <div class="row gy-4">
              <div class="col-lg-6">
                <img src="assets/img/dichaw1.jpg" class="img-fluid" alt="">
              </div>
              <div class="col-lg-6">
                <div class="row gy-4">
                  <div class="col-lg-12">
                    <img src="assets/img/hero.jpg" class="img-fluid" alt="">
                  </div>
                  <div class="col-lg-12">
                    <img src="assets/img/dichaw2.jpg" class="img-fluid" alt="">
                  </div>
                </div>
              </div>
            </div>

          </div>

    </div>

  </div>
</section>
<!-- /About Section -->


<section id="upcoming-match" class="upcoming-section">
  <div class="container">
    <header class="section-header">
      <span class="badge">Next Match</span>
      <div>
        <h2 id="upcoming-heading">Wolaita Dicha FC — Upcoming Matches</h2>
        <p class="sub">Fixtures, kickoff time, venue & quick actions</p>
        <small class="updated">Updated: <strong>Nov 13, 2025</strong></small>
      </div>
    </header>

    <div class="events">
      <!-- Match 1 -->

      <?php
$dataQ = $CommonOBJ->getUpCompingMatch();

$clubLogos = [
  "Wolaita Dicha" => "logos/WolaitaDicha.jpg",
  "Bahir Dar Kenema" => "logos/bd.jpg",
  "Saint George" => "logos/saint.png",
  "Sidama Coffee" => "logos/sidama1.jpg",
  "Hawassa" => "logos/hc.png",
  "Hawassa City" => "logos/hc.png",
  "Hawassa city" => "logos/hc.png",
  "hawassa" => "logos/hc.png",
  "Ethiopian Coffee" => "logos/ethbuna.png",
  "Mekele 70" => "logos/mekel.png",
  "Mekelle 70" => "logos/mekel.png",
  "mekele 70" => "logos/mekel.png",
  "mekelle 70" => "logos/mekel.png",
  "Mekele" => "logos/mekel.png",
  "Mekelle" => "logos/mekel.png",
  "mekele" => "logos/mekel.png",
  "mekelle" => "logos/mekel.png",
  "Fasil Kenema" => "logos/fasil.png",
  "Adama City" => "logos/adama.jpg",
  "Defence Force" => "logos/mechal.jpg",
  "Dire Dawa City" => "logos/dire.jpg",
  "mekelle 70 Enderta" => "logos/mekel.png",
  "Negele Arsi Ketema" => "logos/negele.jpg",
  "Negele Arsi" => "logos/negele.jpg",
  "Welwalo Adigrat University" => "logos/welwaloo.png",
  "Welwalo" => "logos/welwaloo.png",
  "Shire Endaselassie" => "logos/shire.png",
  "Shire" => "logos/shire.png",
  "Ethio Eletric" => "logos/eletric.png",
   "Mekele 70" => "logos/mekel.png",
        "Mekelle 70" => "logos/mekel.png",
        "mekele 70" => "logos/mekel.png",
        "mekelle 70" => "logos/mekel.png",
        "Mekele" => "logos/mekel.png",
        "Mekelle" => "logos/mekel.png",
        "mekele" => "logos/mekel.png",
        "mekelle" => "logos/mekel.png",
];

$printedMatches = [];

if(!empty($dataQ)){
  foreach ($dataQ as $value) {

    $home_club_id = $value['home_club'];
    $away_club_id = $value['away_club'];
    

    // prevent duplicate reverse matches
    $matchKey1 = $home_club_id . '-' . $away_club_id;
    $matchKey2 = $away_club_id . '-' . $home_club_id;

    if(in_array($matchKey1, $printedMatches) || in_array($matchKey2, $printedMatches)){
        continue; // skip duplicate
    }

    $printedMatches[] = $matchKey1;
    
    // Debug: Show club names (remove after checking)
    echo "<!-- Home: '$home_club_id' | Away: '$away_club_id' -->";

?>


     <article class="match-card">

  <!-- HOME TEAM -->
  <div class="team">
    <div class="logo">
      <img src="<?= $clubLogos[$home_club_id] ?? 'logos/default.png' ?>"
           style="width:40px;height:40px;border-radius:50%;">
    </div>
    <div class="team-name"><?= $home_club_id ?></div>
    <div class="team-meta">Home</div>
  </div>

  <!-- MIDDLE -->
  <div class="middle">
    <div class="kickoff">
      <span class="home"><?= $home_club_id ?></span>
      <span class="vs">vs</span>
      <span class="away"><?= $away_club_id ?></span>
    </div>

    <div class="date-time"><?= $formatted ?></div>
    <div class="venue"><?= $venue ?></div>

    <!-- Countdown -->
    <<div class="countdown cd" data-date="<?= $js_date ?>">Loading countdown…</div>

    <div class="cta">
      <button class="btn">🎟 Get Tickets</button>
      <button class="btn wishlist" onclick="toggleWishlist(this)">💖 Add to Wishlist</button>
    </div>
  </div>

  <!-- AWAY TEAM -->
  <div class="team">
    <div class="logo">
      <img src="<?= $clubLogos[$away_club_id] ?? 'logos/default.png' ?>"
           style="width:40px;height:40px;border-radius:50%;">
    </div>
    <div class="team-name"><?= $away_club_id ?></div>
    <div class="team-meta">Away</div>
  </div>

</article>
<?php } } ?>

  
    </div>
  </div>
</section>

<!-- ========== JavaScript ========== -->
<script>
function toggleWishlist(button) {
  const isActive = button.classList.toggle('active');
  button.innerHTML = isActive ? "💔 Remove from Wishlist" : "💖 Add to Wishlist";
}
</script>
<section id="match-results" class="results-section">
  <div class="container">
    <header class="section-header">
      <span class="badge bg-primary">Recent Results</span>
      <div class="mt-2">
        <h2>Wolaita Dicha FC — Match Results</h2>
        <p class="sub">Latest scores, venues & match stats</p>
        <small class="updated">Updated: <strong><?= date('M d, Y') ?></strong></small>
      </div>
    </header>

    <div class="results-cards d-flex flex-wrap justify-content-start gap-3 mt-4">

      <?php 
      // Define club logos array for Recent Results section
      $clubLogos = [
        "Wolaita Dicha" => "logos/WolaitaDicha.jpg",
        "Bahir Dar Kenema" => "logos/bd.jpg",
        "Saint George" => "logos/saint.png",
        "Sidama Coffee" => "logos/sidama1.jpg",
        "Hawassa" => "logos/hc.png",
        "Hawassa City" => "logos/hc.png",
        "Hawassa city" => "logos/hc.png",
        "hawassa" => "logos/hc.png",
        "Ethiopian Coffee" => "logos/ethbuna.png",
        "Mekele 70 SC Logo" => "logos/mekel.png",
        "Fasil Kenema" => "logos/fasil.png",
        "Adama City" => "logos/adama.jpg",
        "Defence Force" => "logos/mechal.jpg",
        "Dire Dawa City" => "logos/dire.jpg",
        "mekelle 70 Enderta" => "logos/mekel.png",
        "Negele Arsi Ketema" => "logos/negele.jpg",
        "Negele Arsi" => "logos/negele.jpg",
        "Welwalo Adigrat University" => "logos/welwaloo.png",
        "Welwalo" => "logos/welwaloo.png",
        "Shire Endaselassie" => "logos/shire.png",
        "Shire" => "logos/shire.png",
        "Ethio Eletric" => "logos/eletric.png"
      ];

      $dataQ = $CommonOBJ->getMatchResult();
      if(!empty($dataQ)){
        foreach ($dataQ as $value) {
          $home_score = $value['home_score'];
          $away_score = $value['away_score'];
          $match_date_raw = $value['match_date'];
$matchTimestamp = strtotime($match_date_raw);
$formatted = date('D, M d, Y H:i', $matchTimestamp);
$js_date   = date('Y-m-d H:i:s', $matchTimestamp);

          $home_club_id = $value['home_club_id'];
          $away_club_id = $value['away_club_id'];
          $venue = $value['venue'];

          $formatted = date('D, M d, Y', strtotime($match_date));

          // Determine badge class
          if($home_score == $away_score){
              $badge_class = "badge-warning";
              $badge_text = "Draw";
          } elseif($home_score > $away_score){
              $badge_class = "badge-success";
              $badge_text = "Win";
          } else {
              $badge_class = "badge-danger";
              $badge_text = "Loss";
          }

          // $homeImg = "logos/WolaitaDicha.jpg";
      ?>
      <article class="result-card border rounded p-3 bg-light">
        <div class="team d-flex align-items-center mb-2">
          <img src="<?= $clubLogos[$home_club_id] ?? 'logos/default.png' ?>" alt="<?= $home_club_id ?> Logo" class="me-2" style="width:40px;height:40px;border-radius:50%;">
          <div>
            <div class="team-name fw-bold"><?= $home_club_id ?></div>
            <div class="team-meta text-muted">Home</div>
          </div>
        </div>

        <div class="middle text-center mb-2">
          <div class="score fs-4 fw-bold mb-1">
            <?= $home_score ?> - <?= $away_score ?>
          </div>
          <div class="match-info text-muted mb-1">
            <div class="date"><?= $formatted ?></div>
            <div class="venue"><?= $venue ?></div>
          </div>
          <span class="badge <?= $badge_class ?>"><?= $badge_text ?></span>
        </div>

        <div class="team d-flex align-items-center mt-2">
          <img src="<?= $clubLogos[$away_club_id] ?? 'logos/default.png' ?>" alt="<?= $away_club_id ?> Logo" class="me-2" style="width:40px;height:40px;border-radius:50%;">
          <div>
            <div class="team-name fw-bold"><?= $away_club_id ?></div>
            <div class="team-meta text-muted">Away</div>
          </div>
        </div>
      </article>
      <?php 
        } // end foreach
      } else {
        echo "<p>No match results found.</p>";
      }
      ?>
      
    </div>
  </div>
</section>

<style>
.results-section { padding: 50px 0; background: #f8f9fa; }
.results-section .results-cards { display: flex; flex-direction: column; gap: 20px; }
.result-card { display: flex; justify-content: space-between; align-items: center; background: white; padding: 15px; border-radius: 10px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); }
.result-card .team { text-align: center; width: 100px; }
.result-card .team .logo img { width: 50px; height: 50px; border-radius: 50%; object-fit: cover; }
.result-card .middle { flex: 1; text-align: center; }
.result-card .score { font-size: 24px; font-weight: bold; }
.badge { padding: 5px 10px; border-radius: 5px; color: #fff; display: inline-block; margin-top: 5px; }
.badge-success { background-color: #28a745; }
.badge-warning { background-color: #ffc107; color: #212529; }
.badge-danger { background-color: #dc3545; }
</style>

<section class="epl-standing-section" id="standing">
    <div class="standing-wrapper">
        <h2 class="standing-title">Ethiopian Premier League Standings</h2>

        <div class="table-container">
            <table class="standing-table" id="standing-body">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Club</th>
                        <th>MP</th>
                        <th>W</th>
                        <th>D</th>
                        <th>L</th>
                        <th>GF</th>
                        <th>GA</th>
                        <th>GD</th>
                        <th>Pts</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>1</td>
                        <td><img src="logos/saint.png" class="club-logo"> Saint George</td>
                        <td>10</td><td>8</td><td>1</td><td>1</td>
                        <td>20</td><td>7</td><td>+13</td><td class="points">25</td>
                    </tr>

                    <tr>
                        <td>2</td>
                        <td><img src="logos/WolaitaDicha.jpg" class="club-logo"> Wolaita Dicha</td>
                        <td>10</td><td>6</td><td>3</td><td>1</td>
                        <td>15</td><td>8</td><td>+7</td><td class="points">21</td>
                    </tr>

                    <tr>
                        <td>3</td>
                        <td><img src="logos/bd.jpg" class="club-logo"> Bahirdar City</td>
                        <td>10</td><td>5</td><td>3</td><td>2</td>
                        <td>12</td><td>9</td><td>+3</td><td class="points">18</td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
</section>



    <!-- Contact Section -->
    <section id="contact" class="contact section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Contact</h2>
        <!-- <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p> -->
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4 mb-5">

          <div class="col-lg-6">

            <div class="col-lg-12" data-aos="fade-up" data-aos-delay="100">
              <div class="info-card">
                <div class="icon-box">
                  <i class="bi bi-geo-alt"></i>
                </div>
                <h3>Our Address</h3>
                <p>University Streat, Wolaita Sodo, Ethiopia</p>
              </div>
            </div>

            <div class="col-lg-12 mt-3" data-aos="fade-up" data-aos-delay="200">
            <div class="info-card">
              <div class="icon-box">
                <i class="bi bi-telephone"></i>
              </div>
              <h3>Contact Number</h3>
              <p>Mobile: +25196916598<br>
                Email: rediettesfaye09@gmail.com</p>
            </div>
          </div>

          </div>
          
          <div class="col-lg-6">
              <div class="col-lg-12">
            <div class="form-wrapper" data-aos="fade-up" data-aos-delay="400">
              
               <!--<p class="text-danger text-center"><?=$CommonOBJ->submitubject(); ?></p>-->
             <form action="send_contact.php" method="post">
                <div class="row">

                  <div class="col-md-6 form-group">
                    <div class="input-group">
                      <span class="input-group-text"><i class="bi bi-person"></i></span>
                      <input type="text" name="name" class="form-control" placeholder="Your name*" required="">
                    </div>
                  </div>

                  <div class="col-md-6 form-group">
                    <div class="input-group">
                      <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                      <input type="email" class="form-control" name="email" placeholder="Email address*" required="">
                    </div>
                  </div>


                </div>
                <div class="row mt-3">
                 <!--  <div class="col-md-12 form-group">
                    <div class="input-group">
                      <span class="input-group-text"><i class="bi bi-phone"></i></span>
                      <input type="text" class="form-control" name="phone" placeholder="Phone number*" required="">
                    </div>
                  </div> -->
            
                  <div class="form-group mt-3">
                    <div class="input-group">
                      <span class="input-group-text"><i class="bi bi-chat-dots"></i></span>
                      <textarea class="form-control" name="message" rows="6" placeholder="Write a message*" required=""></textarea>
                    </div>
                  </div>
                  <div class="my-3">
                   <!--  <div class="loading">Loading</div>
                    <div class="error-message"></div>
                    <div class="sent-message">Your message has been sent. Thank you!</div> -->
                  </div>
                  <div class="text-center">
                    <button type="submit" name="SubmitContacQuery">Submit Message</button>
                  </div>

                </div>
              </form>
            </div>
          </div>
          </div>


        </div>

      </div>
    </section><!-- /Contact Section -->


<section id="club-logos-marquee" class="club-logos-marquee section" style="padding: 40px 0; background-color:#fff;">
  <div class="container">
    <h2 class="text-center mb-5" style="font-weight: bold; margin-bottom: 30px;">2025 CBE Premier League Club Participants</h2>
    <div class="marquee-wrapper">
      <div class="marquee">
        <div class="logo-slide"><img src="logos/saint.png" alt="Saint George SC Logo"></div>
        <div class="logo-slide"><img src="logos/hc.png" alt="Hawassa SC Logo"></div>
        <div class="logo-slide"><img src="logos/etmedihn.png" alt="Ethio Medihn SC Logo"></div>
       
        <div class="logo-slide"><img src="logos/WolaitaDicha.jpg" alt="Wolaitta Dicha SC Logo"></div>
        <div class="logo-slide"><img src="logos/mekel.png" alt="Mekele 70 SC Logo"></div>
        <div class="logo-slide"><img src="logos/bd.jpg" alt="Bahir Dar Kenema FC Logo"></div>
        <div class="logo-slide"><img src="logos/sidama1.jpg" alt="Sidama Coffee SC Logo"></div>
        <div class="logo-slide"><img src="logos/ethbuna.png" alt="Ethiopia Coffe FC Logo"></div>
        <div class="logo-slide"><img src="logos/mechal.jpg" alt="Defence FC Logo"></div>
        <div class="logo-slide"><img src="logos/shire.png" alt="Sihul Shire FC Logo"></div>
        <div class="logo-slide"><img src="logos/cbe.png" alt="CBE FC Logo"></div>
        <div class="logo-slide"><img src="logos/fasil.png" alt="Fasil FC Logo"></div>
        <!-- Repeat logos to make seamless -->
        <div class="logo-slide"><img src="logos/40.jpg" alt="Arbaminch SC Logo"></div>
        <div class="logo-slide"><img src="logos/dire.jpg" alt="Dire Dawa City FC Logo"></div>
        
        <div class="logo-slide"><img src="logos/adama.jpg" alt="Adama City SC Logo"></div>
        <div class="logo-slide"><img src="logos/welwaloo.png" alt="Walwaloo SC Logo"></div>
        <div class="logo-slide"><img src="logos/hadiya.jpg" alt="Hadiya Hossana Logo"></div>
        <div class="logo-slide"><img src="logos/negele.jpg" alt="Negele Arsi SC Logo"></div>
      </div>
    </div>
  </div>
</section>


  </main>

  <footer id="footer" class="footer light-background">

    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-6 footer-about">
          <a href="index.php" class="logo d-flex align-items-center">
            <!-- <span class="sitename">MyWebsite</span> -->
            <img src="assets/img/dichaLogoCurrent1.jpg" alt="" style="max-height: 110px; max-width: 80px;">
          </a>
          <div class="footer-contact pt-3">
            <p>University Street</p>
            <p>Wolaita Sodo, Waduu</p>
            <p class="mt-3"><strong>Phone:</strong> <span>+251969146598</span></p>
            <p><strong>Email:</strong> <span>rediettesfaye09@gmail.com</span></p>
          </div>
          <div class="social-links d-flex mt-4">
            <a href=""><i class="bi bi-twitter-x"></i></a>
            <a href=""><i class="bi bi-facebook"></i></a>
            <a href=""><i class="bi bi-instagram"></i></a>
            <a href=""><i class="bi bi-linkedin"></i></a>
          </div>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Useful Links</h4>
          <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">About us</a></li>
            <li><a href="#">Team</a></li>
            <li><a href="#">Fixture and result</a></li>
            <!-- <li><a href="#">Fan Zone</a></li> -->
            <li><a href="#">Contact</a></li>
            <li><a href="#">Login</a></li>
            <!-- <li><a href="#">Privacy policy</a></li> -->
          </ul>
        </div>

       <div class="col-lg-2 col-md-3 footer-links">
        <h4>About WDFC</h4>
        <ul>
          <li><a href="#">Our History</a></li>
          <li><a href="#">Club Mission</a></li>
          <li><a href="#">Board & Management</a></li>
          <li><a href="#">Coaching Staff</a></li>
          <li><a href="#">Players</a></li>
        </ul>
      </div>

      <div class="col-lg-2 col-md-3 footer-links">
        <h4>Club Activities</h4>
        <ul>
          <li><a href="#">Fixtures & Results</a></li>
          <li><a href="#">League Standings</a></li>
          <li><a href="#">News & Updates</a></li>
          <li><a href="#">Tickets</a></li>
          <!-- <li><a href="#">Contact Us</a></li> -->
        </ul>
      </div>

      <div class="col-lg-2 col-md-3 footer-links">
        <h4>Fan Zone</h4>
        <ul>
          <li><a href="#">Join Our Fan Club</a></li>
          <li><a href="#">Merchandise Store</a></li>
          <li><a href="#">Matchday Gallery</a></li>
          <li><a href="#">Volunteer & Support</a></li>
          <li><a href="#">Community Projects</a></li>
        </ul>
      </div>


      </div>
    </div>

    <div class="container copyright text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">2025 Wolaita Dicha Sport Club</strong> <span>All Rights Reserved</span></p>
      <div class="credits">
        Designed by <a href="https://t.me/+qEQkBeElRQYxODM0">CS Students</a>
      </div>
    </div>

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <!-- <div id="preloader"></div> -->

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- <script src="assets/vendor/php-email-form/validate.js"></script> -->
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="ajax\jquery-2.2.4.min.js"></script>
  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>
  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>
  
<script>
const wrapper = document.querySelector('#club-logos-slider .logos-wrapper');
const slides = document.querySelectorAll('#club-logos-slider .logo-slide');
let index = 0;
let direction = 1; // 1 = left/forward, -1 = right/backward

// Calculate slide width dynamically
function getSlideWidth() {
  return slides[0].offsetWidth + parseInt(getComputedStyle(slides[0]).marginRight);
}

// Move slider to current index
function showSlide(i) {
  const slideWidth = getSlideWidth();
  wrapper.scrollTo({ left: i * slideWidth, behavior: 'smooth' });
}

// Auto ping-pong scroll every 3 seconds
let autoScroll = setInterval(() => {
  index += direction;

  // Reverse direction at ends
  if (index >= slides.length - 1) direction = -1;
  if (index <= 0) direction = 1;

  showSlide(index);
}, 3000);

// Prev/Next buttons
document.querySelector('#club-logos-slider .next').addEventListener('click', () => {
  index = Math.min(index + 1, slides.length - 1);
  direction = 1;
  showSlide(index);
});

document.querySelector('#club-logos-slider .prev').addEventListener('click', () => {
  index = Math.max(index - 1, 0);
  direction = -1;
  showSlide(index);
});

// Pause auto-scroll on hover
wrapper.addEventListener('mouseenter', () => clearInterval(autoScroll));
wrapper.addEventListener('mouseleave', () => {
  autoScroll = setInterval(() => {
    index += direction;
    if (index >= slides.length - 1) direction = -1;
    if (index <= 0) direction = 1;
    showSlide(index);
  }, 200);
});
</script>



  <script>
    (function(){
      const cdEl = document.getElementById('cd');
      const kickoff = new Date('2025-11-25T16:30:00');
      function update(){
        const now = new Date();
        const diff = kickoff - now;
        if(diff <= 0){ cdEl.textContent = 'Kickoff — Live or finished'; return }
        const days = Math.floor(diff / (1000*60*60*24));
        const hrs = Math.floor((diff/(1000*60*60))%24);
        const mins = Math.floor((diff/(1000*60))%60);
        const secs = Math.floor((diff/1000)%60);
        cdEl.textContent = `${days}d ${hrs}h ${mins}m ${secs}s`;
      }
      update();
      setInterval(update,1000);
    })();

    function addToCalendar(){
      const title = 'Wolaita Dicha FC vs Bahir Dar Kenema';
      const start = '20251115T163000';
      const end = '20251115T183000';
      const ics = `BEGIN:VCALENDAR\nVERSION:2.0\nBEGIN:VEVENT\nSUMMARY:${title}\nDTSTART:${start}\nDTEND:${end}\nEND:VEVENT\nEND:VCALENDAR`;
      const blob = new Blob([ics],{type:'text/calendar;charset=utf-8'});
      const url = URL.createObjectURL(blob);
      const a = document.createElement('a');
      a.href = url; a.download = 'wolaita-match.ics';
      document.body.appendChild(a); a.click(); a.remove();
      URL.revokeObjectURL(url);
    }
  </script>
<script>
document.querySelectorAll('.cd').forEach(cdEl => {

  const raw = cdEl.getAttribute('data-date');
  const kickoff = new Date(raw.replace(' ', 'T'));

  function update(){
    const now = new Date();
    const diff = kickoff.getTime() - now.getTime();

    if(isNaN(diff) || diff <= 0){
      cdEl.textContent = 'Kickoff — Live or finished';
      return;
    }

    const days = Math.floor(diff / (1000*60*60*24));
    const hrs  = Math.floor((diff/(1000*60*60)) % 24);
    const mins = Math.floor((diff/(1000*60)) % 60);
    const secs = Math.floor((diff/1000) % 60);

    cdEl.textContent = days + "d " + hrs + "h " + mins + "m " + secs + "s";
  }

  update();
  setInterval(update, 1000);
});
</script>

</body>

</html>