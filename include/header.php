<?php
   include_once('include/functions.php');
   $commonFunction= new functions();
   if(!isset($_SESSION['is_store_logged_in'])){ $commonFunction->redirect('index.php'); }
   $store_id=$_SESSION['store_id'];
   $adminSqli = $conn->query("call getAdminData($store_id)");
   $conn->next_result();
   $adminData = $adminSqli->fetch_assoc();
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
      <link rel="stylesheet" href="<?=MAIN_URL?>/assets/css/demo_1/style.css">
      <link rel="stylesheet" href="<?=MAIN_URL?>/assets/css/custom_style.css">
      <script src="<?=MAIN_URL?>/assets/js/jquery.min.js"></script>
      
      <link rel="shortcut icon" href="<?=MAIN_URL?>/assets/images/jainlogo.png" />
      <link rel="stylesheet"  href="<?=MAIN_URL?>/assets/css/jquery.dataTables.css">
      <style>
         #loader{
               height: 400px;
               background: url('<?=MAIN_URL?>/assets/images/loader.gif') no-repeat center;
               z-index: 999;
         }
      </style>
   </head>
   <body>
      <div class="container-scroller">
      <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
         <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
            <a class="navbar-brand brand-logo" href="<?=MAIN_URL?>">
            <img src="<?=MAIN_URL?>/assets/images/jainlogo.png" alt="<?=PROJECT;?>" style="width: 125px;" /> </a>
            <a class="navbar-brand brand-logo-mini" href="<?=MAIN_URL?>">
            <img src="<?=MAIN_URL?>/assets/images/jainlogo.png" alt="<?=PROJECT;?>" /> </a>
         </div>
         <div class="navbar-menu-wrapper d-flex align-items-center">
            <ul class="navbar-nav ml-auto">
               <li class="nav-item dropdown d-none d-xl-inline-block user-dropdown">
                  <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                  <img class="img-xs rounded-circle" src="<?=MAIN_URL?>/assets/images/jainlogo.png" alt="<?=PROJECT;?>"> </a>
                  <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                     <div class="dropdown-header text-center">
                        <img class="img-md rounded-circle" src="<?=MAIN_URL?>/assets/images/jainlogo.png" alt="<?=PROJECT;?>">
                        <p class="mb-1 mt-3 font-weight-semibold" id="adminName"><?=$adminData['name']?></p>
                        <p class="font-weight-light text-muted mb-0"><?=$adminData['email']?></p>
                     </div>
                     <a href="<?=MAIN_URL?>/profile.php" class="dropdown-item">My Profile <i class="dropdown-item-icon ti-dashboard"></i></a>
                     <a href="<?=MAIN_URL?>/logout.php" class="dropdown-item">Sign Out<i class="dropdown-item-icon ti-power-off"></i></a>
                  </div>
               </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
            </button>
         </div>
      </nav>

