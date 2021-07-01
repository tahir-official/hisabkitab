<?php
include_once('include/functions.php');
$db= new functions();
if(isset($_SESSION['is_store_logged_in'])){ $db->redirect('dashboard.php'); }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta name="description" content="This is hisabkitab Portal for personal use">
    <meta name="keywords" content="HTML, CSS, JavaScript,Hisab,Broker,Jainam,Mahaver,tahir">
    <meta name="author" content="Tahir Mansuri">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                
                <form method="post" id="ForgetForm">
                  <h3 style="text-align: center;">Forgot Password </h3>
                  <p style="text-align: center;color: #2196f3;">Please enter your email to recover your password.</p>
                  <div id="alert"></div>
                  
                  <div class="form-group">
                    <label class="label">Username or Email</label>
                    <div class="input-group">
                      <input type="text" class="form-control" name="username" id="username" placeholder="Username or Email" required="" >
                      <div class="input-group-append">
                        <span class="input-group-text">
                          <i class="mdi mdi-check-circle-outline"></i>
                        </span>
                      </div>
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <button class="btn btn-primary submit-btn btn-block btnSubmit" type="submit">Submit</button>
                  </div>
                  <div class="form-group d-flex justify-content-between">
                    
                    <a href="<?=MAIN_URL?>/index.php" class="text-small forgot-password text-black">Login</a>
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
  $("#alert").hide();
  $('#ForgetForm').submit(function(e) {

      e.preventDefault();
      let formData = $('#ForgetForm').serialize();

      $.ajax({
          method: "POST",
          url: baseUrl + "/model/profileModel.php?action=forgetPassword",
          data: formData,
          dataType: 'JSON',
          beforeSend: function() {
            $(".btnSubmit").html('<i class="fa fa-spinner"></i> Processing...');
            $(".btnSubmit").prop('disabled', true);
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
            $("#alert").html(response.message);
            $("#alert").show();
            $('#ForgetForm')[0].reset();
          }
          
        })
        .always(function() {
          $(".btnSubmit").html('Submit');
          $(".btnSubmit").prop('disabled', false);
        });
      
      

      return false;
  });
    
  </script>
</html>