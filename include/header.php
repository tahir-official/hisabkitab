<?php
include_once('include/functions.php');
$db= new functions();
if(!isset($_SESSION['is_admin_logged_in'])){ $db->redirect('index.php'); }

$adminData=$db->getAdminData($_SESSION['admin_id']);

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?=PROJECT;?></title>
  
    <link rel="stylesheet" href="<?=MAIN_URL?>/assets/vendors/iconfonts/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?=MAIN_URL?>/assets/vendors/iconfonts/ionicons/dist/css/ionicons.css">
    <link rel="stylesheet" href="<?=MAIN_URL?>/assets/vendors/iconfonts/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="<?=MAIN_URL?>/assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="<?=MAIN_URL?>/assets/vendors/css/vendor.bundle.addons.css">
   
    <link rel="stylesheet" href="<?=MAIN_URL?>/assets/css/shared/style.css">

   
    <link rel="stylesheet" href="<?=MAIN_URL?>/assets/css/demo_1/style.css">
    <script src="<?=MAIN_URL?>/assets/js/jquery.min.js"></script>
  
    <link rel="shortcut icon" href="<?=MAIN_URL?>/assets/images/favicon.ico" />
  </head>
  <body>
    <div class="container-scroller">
     
      <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
          <a class="navbar-brand brand-logo" href="index.html">
            <img src="<?=MAIN_URL?>/assets/images/logo.svg" alt="logo" /> </a>
          <a class="navbar-brand brand-logo-mini" href="index.html">
            <img src="<?=MAIN_URL?>/assets/images/logo-mini.svg" alt="logo" /> </a>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-center">
          
          
          <ul class="navbar-nav ml-auto">
            
            
            <li class="nav-item dropdown d-none d-xl-inline-block user-dropdown">
              <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                <img class="img-xs rounded-circle" src="<?=MAIN_URL?>/assets/images/faces/face8.jpg" alt="Profile image"> </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                <div class="dropdown-header text-center">
                  <img class="img-md rounded-circle" src="<?=MAIN_URL?>/assets/images/faces/face8.jpg" alt="Profile image">
                  <p class="mb-1 mt-3 font-weight-semibold"><?=$adminData['admin_name']?></p>
                  <p class="font-weight-light text-muted mb-0"><?=$adminData['admin_email']?></p>
                </div>
                <a class="dropdown-item">My Profile <span class="badge badge-pill badge-danger">1</span><i class="dropdown-item-icon ti-dashboard"></i></a>
                
                <a href="<?=MAIN_URL?>/logout.php" class="dropdown-item">Sign Out<i class="dropdown-item-icon ti-power-off"></i></a>
              </div>
            </li>
          </ul>
          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
          </button>
        </div>
      </nav>
      
   