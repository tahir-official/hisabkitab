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
  
   
   <div class="row page-title-header">
      <div class="col-12">
         <div class="page-header">
            <h4 class="page-title">Broker Management</h4>
            <div class="quick-link-wrapper w-100 d-md-flex flex-md-wrap">
               <ul class="quick-links ml-auto">
                  <li><a href="<?=MAIN_URL?>">Home</a></li>
                  <li><a href="<?=$url?>">Broker Management</a></li>
               </ul>
            </div>
         </div>
      </div>
      <div class="col-md-12">
         <div class="page-header-toolbar">
            <div class="sort-wrapper">
               <button type="button"  onclick="return loadPopup('addBroker',0);" class="btn btn-primary toolbar-item">Add New</button>
            </div>
         </div>
      </div>
   </div>
   <div id="alert">
   </div>
   <?php
      if (isset($_SESSION['message'])){ echo $_SESSION['message']; unset($_SESSION['message']); }
   ?>
   <div class="row">
      <div class="col-12 ">
         <table class="table table-hover  table-bordered table-responsive-md">
            <thead>
               <tr>
                  <th>User</th>
                  <th>Product</th>
                  <th>Sale</th>
                  <th>Status</th>
               </tr>
            </thead>
            <tbody>
               <tr>
                  <td>Jacob</td>
                  <td>Photoshop</td>
                  <td class="text-danger"> 28.76% <i class="mdi mdi-arrow-down"></i>
                  </td>
                  <td>
                     <label class="badge badge-danger">Pending</label>
                  </td>
               </tr>
               <tr>
                  <td>Messsy</td>
                  <td>Flash</td>
                  <td class="text-danger"> 21.06% <i class="mdi mdi-arrow-down"></i>
                  </td>
                  <td>
                     <label class="badge badge-warning">In progress</label>
                  </td>
               </tr>
               <tr>
                  <td>John</td>
                  <td>Premier</td>
                  <td class="text-danger"> 35.00% <i class="mdi mdi-arrow-down"></i>
                  </td>
                  <td>
                     <label class="badge badge-info">Fixed</label>
                  </td>
               </tr>
               <tr>
                  <td>Peter</td>
                  <td>After effects</td>
                  <td class="text-success"> 82.00% <i class="mdi mdi-arrow-up"></i>
                  </td>
                  <td>
                     <label class="badge badge-success">Completed</label>
                  </td>
               </tr>
               <tr>
                  <td>Dave</td>
                  <td>53275535</td>
                  <td class="text-success"> 98.05% <i class="mdi mdi-arrow-up"></i>
                  </td>
                  <td>
                     <label class="badge badge-warning">In progress</label>
                  </td>
               </tr>
            </tbody>
         </table>
      </div>
   </div>
</div>
<!-- content-wrapper ends -->

<?php
   include_once('include/footer.php');
?>




