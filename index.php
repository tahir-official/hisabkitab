<?php
   include_once('include/functions.php');
   $db= new functions();
   if(isset($_SESSION['is_store_logged_in'])){ $db->redirect('dashboard.php'); }
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="description" content="This is hisabkitab Portal for personal use">
      <meta name="keywords" content="HTML, CSS, JavaScript,Hisab,Broker,Jainam,Mahaver,tahir">
      <meta name="author" content="Tahir Mansuri">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title><?=PROJECT?></title>
      <link rel="stylesheet" href="<?=MAIN_URL?>/assets/vendors/iconfonts/mdi/css/materialdesignicons.min.css">
      <link rel="stylesheet" href="<?=MAIN_URL?>/assets/vendors/iconfonts/ionicons/dist/css/ionicons.css">
      <link rel="stylesheet" href="<?=MAIN_URL?>/assets/vendors/iconfonts/flag-icon-css/css/flag-icon.min.css">
      <link rel="stylesheet" href="<?=MAIN_URL?>/assets/vendors/css/vendor.bundle.base.css">
      <link rel="stylesheet" href="<?=MAIN_URL?>/assets/vendors/css/vendor.bundle.addons.css">
      <script src="<?=MAIN_URL?>/assets/js/jquery.min.js"></script>
      <link rel="stylesheet" href="<?=MAIN_URL?>/assets/css/shared/style.css">
      <link rel="shortcut icon" href="<?=MAIN_URL?>/assets/images/jainlogo.png" />
   </head>
   <body>
      <div class="container-scroller">
         <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth auth-bg-1 theme-one">
               <div class="row w-100">
                  <div class="col-lg-4 mx-auto">
                     <div class="auto-form-wrapper">
                        <div id="alert"></div>
                        <form method="post" id="loginFrom">
                           <div class="form-group">
                              <label class="label">Username or Email</label>
                              <div class="input-group">
                                 <input type="text" class="form-control" name="username" id="username" placeholder="Username or Email" required="" >
                                 <div class="input-group-append">
                                    <span class="input-group-text mdi mdi-check-circle-outline"></span>
                                 </div>
                              </div>
                           </div>
                           <div class="form-group">
                              <label class="label">Password</label>
                              <div class="input-group">
                                 <input type="password" class="form-control" name="password" id="password" placeholder="*********" required="">
                                 <div class="input-group-append toggle-password">
                                    <span class="input-group-text mdi mdi-eye-outline"></span>
                                 </div>
                              </div>
                           </div>
                           <div class="form-group">
                              <button class="btn btn-primary submit-btn btn-block btnLogin" type="submit">Login</button>
                           </div>
                           <div class="form-group d-flex justify-content-between">
                              <a href="<?=MAIN_URL?>/forget.php" class="text-small forgot-password text-black">Forgot Password</a>
                           </div>
                        </form>
                     </div>
                     <p class="footer-text text-center">Copyright © <?=date('Y').' '.PROJECT;?> . All rights reserved.</p>
                     <p class="footer-text text-center text-center">Design & Developed by <a style="color: white;" href="<?=PROFILE_URL?>" target="_blank"> <?=DEVELOPER?></a> </p>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <script src="<?=MAIN_URL?>/assets/vendors/js/vendor.bundle.base.js"></script>
      <script src="<?=MAIN_URL?>/assets/vendors/js/vendor.bundle.addons.js"></script>
   </body>
   <script type="text/javascript">
      let baseUrl = '<?=MAIN_URL;?>';
   </script>
   <script src="<?=MAIN_URL?>/assets/js/custom.js"></script>  
</html>

