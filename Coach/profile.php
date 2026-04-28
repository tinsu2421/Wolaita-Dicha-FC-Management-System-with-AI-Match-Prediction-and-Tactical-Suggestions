
<?php 

  session_start();
  if (isset($_SESSION['sessionID'])) {
    // code...
  }else{
    echo "<script>window.location='../pages_login.php?login&error=Session Timeout try again.';</script>";
  }

  require __DIR__.'/performCoachAction.php';
  $isPerformCoachOBJ = new isperformCoachAction();
  require __DIR__.'/../CommonFunction/CommenForEveryUserFunction.php';
  $CommonOBJ = new CommonFunction();

  $dataQ = $isPerformCoachOBJ->getSessionUser($_SESSION['sessionID']);
  $rowQ = $isPerformCoachOBJ->getSessionUser($_SESSION['sessionID']);
  
  // Initialize variables with default values
  $fullname = '';
  $role = '';
  $AccountState = '';
  $lastlogintime = '';
  $url = '';
  $urlId = '';
  
  foreach ($dataQ as $key => $value) {
    // code...
    $fullname = $value['fullname'];
    $role = $value['role'];
    $AccountState = $value['account_status'];
    $url = $value['profile_picture_url'];
    $lastlogintime = $value['last_login_time'];
    $urlId  = $value['account_id'];
  }


 // error_reporting(0);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Wolaita Dicha - FC</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!--Organization Favicons -->
  <link href="../assets/img/dichaLogo.jpg" rel="icon">
  <link href="../assets/img/dichaLogo.jpg" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../dashboard/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../dashboard/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../dashboard/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../dashboard/assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="../dashboard/assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="../dashboard/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="../dashboard/assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="../dashboard/assets/css/style.css" rel="stylesheet">
  <link href="../dashboard/assets/css/logo.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="../Syadmin/avatar.css">

  <!-- =======================================================
  * Folder Super/Admin
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="dashboard" class="logo d-flex align-items-center">
        <img src="../assets/img/dichaLogoCurrent1.jpg" alt="" style="max-height: 60PX; max-width: 60px;">
        <!-- <span class="d-none d-lg-block">Honda</span> -->
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->



    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li>

        

      <?php include __DIR__.'/profileModal.php';  ?>

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <!-- Include aside bar for super admin -->
  <?php 
    require __DIR__.'/Component/Asidebar.php';
    // require __DIR__.'/Component/Logoutmodal.php';
  ?>
  <!-- End Sidebar-->

  <main id="main" class="main">
<?php 
    require __DIR__.'/Component/Logoutmodal.php';
?>
    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home (<?=$role; ?>)</a></li>
          <li class="breadcrumb-item active">Last login date : <?= $lastlogintime; ?></li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">
        <?php if (isset($_GET['success'])) { ?>
        <div class="col-12">
          <div class="alert alert-success alert-dismissible fade show" role="alert" style="background-color: #198754; color: white;">
                 Hi, &nbsp; <?= $fullname; ?> ! &nbsp;<i class="bi-hand-thumbs-up"></i>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        </div>
      <?php } ?>
        <!-- Left side columns -->
       <div class="row grid-margin">
    <div class="col-md-2"></div>

<div class="col-md-8">
  <div class="card" role="region" aria-label="Avatar upload">
    <div>
      <div class="heading">
        <div style="width:44px;height:44px;border-radius:10px;background:#0d6efd;display:grid;place-items:center;color:white;font-weight:800">A</div>
        <div>
          <h1>Upload your avatar</h1>
          <p>Choose a photo or drag & drop — preview and replace anytime.</p>
        </div>
      </div>
      <p class="text-center text-success spanError"><?= $CommonOBJ->isUpdateAvatar(); ?></p>
      <form class="form-sample" id="userForm" action="" method="post" enctype="multipart/form-data">
      

       <input type="hidden" name="urlId" value="<?=$urlId; ?>">
      <div class="uploader" id="uploader" tabindex="0" aria-describedby="uploader-desc">
        <input id="fileInput" type="file" accept="image/*" name="avatar" style="display:none">
         <!-- <input id="fileInput" type="file" accept="image/*" name="avatar" style="display:none"> -->
        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" aria-hidden="true">
          <path d="M12 3v9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
          <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" stroke="currentColor" stroke-width="1.5"></path>
          <path d="M7 10l5-5 5 5" stroke="currentColor" stroke-width="1.5"></path>
        </svg>
        <p id="uploader-desc">Drop image here or <button class="btn ghost" id="chooseBtn" type="button">Choose file</button></p>
        <p class="meta">Max size 5MB. PNG, JPG, GIF supported.</p>
      </div>

      <div class="form" style="margin-top:14px">
        <label class="small">Preview & actions</label>
        <div class="info-list">
          <div class="info-item"><span>File name</span><strong id="fileName">—</strong></div>
          <div class="info-item"><span>Size</span><strong id="fileSize">—</strong></div>
        </div>

        <div style="margin-top:12px">
          <div class="progress"><span id="progressBar"></span></div>
        </div>
      </div>
    </div>

    <div class="avatar-wrap">
      <div class="avatar-preview" id="preview">
        <div class="avatar-blank" id="blank">
          <?php 
            if (!empty($url)) { ?>
             <img src="<?=$url; ?>" />
           <?php  }else{ ?> 
            A
           <?php } ?>
          
        </div>
      </div>

      <div class="controls">
        <button class="btn" id="uploadBtn" name="UploadAvatar">Upload</button>
        <button class="btn ghost" id="removeBtn" disabled>Remove</button>
      </div>

      <p class="meta" style="text-align:center;max-width:240px">Tip: For best results use a square image.</p>
    </div>

  </form>
  </div>
              </div>
          </div>
        </div>



      </div>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer" style="margin-top: 150px;">
    <div class="copyright">
      &copy; Copyright <strong><span>Wolaita Dich FC</span></strong>.All right reserved.
    </div>
    <div class="credits">
     
      Powered By <a href="https://t.me/+qEQkBeElRQYxODM0">CS Students</a>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="../dashboard/assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="../dashboard/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../dashboard/assets/vendor/chart.js/chart.umd.js"></script>
  <script src="../assets/vendor/echarts/echarts.min.js"></script>
  <script src="../dashboard/assets/vendor/quill/quill.min.js"></script>
  <script src="../dashboard/assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="../dashboard/assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="../dashboard/assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="../dashboard/assets/js/main.js"></script>

  <script>
    const fileInput = document.getElementById('fileInput');
    const chooseBtn = document.getElementById('chooseBtn');
    const uploader = document.getElementById('uploader');
    const preview = document.getElementById('preview');
    const blank = document.getElementById('blank');
    const fileName = document.getElementById('fileName');
    const fileSize = document.getElementById('fileSize');
    const progressBar = document.getElementById('progressBar');
    const uploadBtn = document.getElementById('uploadBtn');
    const removeBtn = document.getElementById('removeBtn');

    const MAX_SIZE = 5 * 1024 * 1024;

    chooseBtn.addEventListener('click', ()=> fileInput.click());
    uploader.addEventListener('click', ()=> fileInput.click());

    ['dragenter','dragover'].forEach(ev => uploader.addEventListener(ev, e=>{
      e.preventDefault(); uploader.classList.add('dragover');
    }));
    ['dragleave','drop'].forEach(ev => uploader.addEventListener(ev, e=>{
      e.preventDefault(); uploader.classList.remove('dragover');
    }));

    uploader.addEventListener('drop', e=>{
      const file = e.dataTransfer.files[0];
      if(file) handleFile(file);
    });

    fileInput.addEventListener('change', ()=>{
      const file = fileInput.files[0];
      if(file) handleFile(file);
    });

    function humanFileSize(bytes){
      const units = ['KB','MB','GB'];
      let u = -1;
      do{ bytes/=1024; ++u; } while(bytes>=1024 && u<units.length-1);
      return bytes.toFixed(1)+' '+units[u];
    }

    function handleFile(file){
      if(!file.type.startsWith('image/')){ alert('Image only!'); return; }
      if(file.size > MAX_SIZE){ alert('Max 5MB'); return; }

      fileName.textContent = file.name;
      fileSize.textContent = humanFileSize(file.size);
      removeBtn.disabled = false;

      const url = URL.createObjectURL(file);
      preview.innerHTML = `<img src="${url}" alt="Avatar preview">`;

      simulateUpload();
    }

    function simulateUpload(){
      let p = 0;
      progressBar.style.width = '0%';
      const timer = setInterval(()=>{
        p += 18;
        if(p >= 100){ p = 100; clearInterval(timer); }
        progressBar.style.width = p+'%';
      }, 200);
    }

    uploadBtn.addEventListener('click', (e)=> {
      // If no file is selected, open file dialog
      if (!fileInput.files[0]) {
        e.preventDefault();
        fileInput.click();
      }
      // Otherwise, let the form submit normally (don't prevent default)
    });
    removeBtn.addEventListener('click', ()=>{
      preview.innerHTML = '<div class="avatar-blank">A</div>';
      fileInput.value = '';
      fileName.textContent = '—';
      fileSize.textContent = '—';
      progressBar.style.width = '0%';
      removeBtn.disabled = true;
    });
  </script>
</body>

</html>