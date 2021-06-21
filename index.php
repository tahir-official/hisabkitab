<?php
include_once('include/functions.php');
$db= new functions();
if(isset($_SESSION['is_admin_logged_in'])){ $db->redirect('dashboard.php'); }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?=PROJECT?></title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="<?=MAIN_URL?>/assets/vendors/iconfonts/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?=MAIN_URL?>/assets/vendors/iconfonts/ionicons/dist/css/ionicons.css">
    <link rel="stylesheet" href="<?=MAIN_URL?>/assets/vendors/iconfonts/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="<?=MAIN_URL?>/assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="<?=MAIN_URL?>/assets/vendors/css/vendor.bundle.addons.css">
    <script src="<?=MAIN_URL?>/assets/js/jquery.min.js"></script>
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="<?=MAIN_URL?>/assets/css/shared/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="<?=MAIN_URL?>/assets/images/favicon.ico" />
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
                    <label class="label">Username</label>
                    <div class="input-group">
                      <input type="text" class="form-control" name="username" id="username" placeholder="Username" required="" >
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="label">Password</label>
                    <div class="input-group">
                      <input type="password" class="form-control" name="password" id="password" placeholder="*********" required="">
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
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
              
              <p class="footer-text text-center">copyright © <?=date('Y').' '.PROJECT;?> . All rights reserved.</p>
              <p class="footer-text text-center text-center">Design & Developed by <a style="color: white;" href="https://www.linkedin.com/in/tahir-mansuri-b7310a94" target="_blank"> Tahir Khan</a> </p>
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
  $("#alert").hide();
  $('#loginFrom').submit(function(e) {

      e.preventDefault();
      let formData = $('#loginFrom').serialize();

      $.ajax({
          method: "POST",
          url: baseUrl + "/model/profileModel.php?action=login",
          data: formData,
          dataType: 'JSON',
          beforeSend: function() {
            $(".btnLogin").html('<i class="fa fa-spinner"></i> Processing...');
            $(".btnLogin").prop('disabled', true);
            $("#alert").hide();
            
          }
        })

        .fail(function(response) {
          alert( "Try again later." );
        })

        .done(function(response) {
          if(response.status == 0){
            $("#alert").html(response.message);
            $("#alert").show();
          }else{
            location.href = response.url;
          }
          
        })
        .always(function() {
          $(".btnLogin").html('Login');
          $(".btnLogin").prop('disabled', false);
        });
      
      

      return false;
  });
    
  </script>
</html>