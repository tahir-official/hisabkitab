<?php
 include_once('include/functions.php');
 $db= new functions();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
  <meta charset="UTF-8">
    <meta name="description" content="This is hisabkitab Portal for personal use">
    <meta name="keywords" content="HTML, CSS, JavaScript,Hisab,Broker,Jainam,Mahaver,tahir">
    <meta name="author" content="Tahir Mansuri">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=PROJECT;?></title>
    <link rel="stylesheet" href="<?=MAIN_URL?>/assets/vendors/iconfonts/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?=MAIN_URL?>/assets/vendors/iconfonts/ionicons/dist/css/ionicons.css">
    <link rel="stylesheet" href="<?=MAIN_URL?>/assets/vendors/iconfonts/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="<?=MAIN_URL?>/assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="<?=MAIN_URL?>/assets/vendors/css/vendor.bundle.addons.css">
    
    <link rel="stylesheet" href="<?=MAIN_URL?>/assets/css/shared/style.css">
    <link rel="shortcut icon" href="<?=MAIN_URL?>/assets/images/jainlogo.png" />
  </head>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center text-center error-page bg-info">
          <div class="row flex-grow">
            <div class="col-lg-7 mx-auto text-white">
              <div class="row align-items-center d-flex flex-row">
                <div class="col-lg-6 text-lg-right pr-lg-4">
                  <h1 class="display-1 mb-0">500</h1>
                </div>
                <div class="col-lg-6 error-page-divider text-lg-left pl-lg-4">
                  <h2>SORRY!</h2>
                  <h3 class="font-weight-light">Internal server error!</h3>
                </div>
              </div>
              <div class="row mt-5">
                <div class="col-12 text-center mt-xl-2">
                <a class="text-white font-weight-medium" href="<?=MAIN_URL?>">Back to home</a>
                </div>
              </div>
              <div class="row mt-5">
                <div class="col-12 mt-xl-2">
                  <p class="text-white font-weight-medium text-center">Copyright © <?=date('Y').' '.PROJECT;?> . All rights reserved.</p>
                  <p class="footer-text text-center text-center">Design & Developed by <a style="color: #1c45ef;" style="color: white;" href="<?=PROFILE_URL?>" target="_blank"> <?=DEVELOPER?></a></p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="<?=MAIN_URL?>/assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="<?=MAIN_URL?>/assets/vendors/js/vendor.bundle.addons.js"></script>
    <!-- endinject -->
    <!-- inject:js -->
    <script src="<?=MAIN_URL?>/assets/js/shared/off-canvas.js"></script>
    <script src="<?=MAIN_URL?>/assets/js/shared/misc.js"></script>
    <!-- endinject -->
    <script src="<?=MAIN_URL?>/assets/js/shared/jquery.cookie.js" type="text/javascript"></script>
  </body>
</html>