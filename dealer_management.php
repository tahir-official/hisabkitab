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
            <h4 class="page-title">Dealer Management</h4> <button type="button"  onclick="return loadPopupUser('dealer',0);" class="btn btn-primary toolbar-item">Add Dealer</button>
            <div class="quick-link-wrapper w-100 d-md-flex flex-md-wrap">
               <ul class="quick-links ml-auto">
                  <li><a href="<?=MAIN_URL?>">Home</a></li>
                  <li><a href="<?=$url?>">Dealer Management</a>  </li>
               </ul>
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
      <div class="col-12 table-responsive">
      <table id="mytable" class="row-border " >
        <thead>
            <tr>
                <th>S.N.</th>
                <th>Name</th>
                <th>Email Address</th>
                <th>Number</th>
                <th>Address</th>
                <th>City</th>
                <th>State</th>
                <th>Broker Name</th>
                <th>Status</th>
                <th>Craete Date</th>
                <th>Action</th>
               
            </tr>
        </thead>
        
    </table>
      </div>
   </div>
</div>
<!-- content-wrapper ends -->
<?php
   include_once('include/footer.php');
?>
<script type="text/javascript" language="javascript">

$(document).ready(function(){
	
	tableLoad(baseUrl +"/model/userModel.php?action=getTableDataDealer",null);

});	


</script>






