<?php
   include_once('include/header.php');
   ?>
<div class="container-fluid page-body-wrapper">
<?php
   include_once('include/sidebar.php');
   ?>
<!-- partial -->
<div class="main-panel">
<div class="content-wrapper">
   <!-- Page Title Header Starts-->
   <?php
      if (isset($_SESSION['message'])){ echo $_SESSION['message']; unset($_SESSION['message']); }
      ?>
   <div id="alert">
   </div>
   <div class="row">
      <div class="col-md-6 d-flex align-items-stretch grid-margin">
         <div class="row flex-grow">
            <div class="col-12">
               <div class="card">
                  <div class="card-body">
                     <h4 class="card-title">Personal Information </h4>
                     <p class="card-description"> Personal Information Details </p>
                     <form class="forms-sample" role="form" method="post" id="updateProfile" onsubmit="return updateProfile();" >
                        <div class="form-group">
                           <label for="username">Username</label>
                           <input type="text" class="form-control" name="username" id="username" placeholder="Enter Username" value="<?=$adminData['username']?>" readonly >
                        </div>
                        <div class="form-group">
                           <label for="email">Email</label>
                           <input type="email" class="form-control" name="email" id="email" placeholder="Enter email" value="<?=$adminData['email']?>" readonly>
                        </div>
                        <div class="form-group">
                           <label for="store_name">Store Name</label>
                           <input type="text" class="form-control" name="store_name" id="store_name" placeholder="Enter name" value="<?=$adminData['name']?>">
                        </div>
                        <div class="form-group">
                           <label for="phone">Phone</label>
                           <input type="text" class="form-control" name="phone" id="phone" placeholder="Enter phone" value="<?=$adminData['phone']?>">
                        </div>
                        <button type="submit" name="submit" id="updateProfileBtn" class="btn btn-success mr-2 btnSubmit">Update</button>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="col-md-6 grid-margin stretch-card">
         <div class="card">
            <div class="card-body">
               <h4 class="card-title">Change Password </h4>
               <p class="card-description"> Change Password Detail </p>
               <form class="forms-sample">
                  <div class="form-group">
                     <label for="exampleInputPassword1">Current Password</label>
                     <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Current Password">
                  </div>
                  <div class="form-group">
                     <label for="exampleInputPassword1">New Password</label>
                     <input type="password" class="form-control" id="exampleInputPassword1" placeholder="New Password">
                  </div>
                  <div class="form-group">
                     <label for="exampleInputPassword1">Confirm Password</label>
                     <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Confirm Password">
                  </div>
                  <button type="submit" class="btn btn-success mr-2">Change</button>
                  <button class="btn btn-danger">Cancel</button>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- content-wrapper ends -->
<?php
   include_once('include/footer.php');
?>

