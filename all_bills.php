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
            <h4 class="page-title">Bills Management</h4> <a href="<?=MAIN_URL?>/add_bill.php"><button type="button"   class="btn btn-primary toolbar-item">Add Bill</button></a>
            <div class="quick-link-wrapper w-100 d-md-flex flex-md-wrap">
               <ul class="quick-links ml-auto">
                  <li><a href="<?=MAIN_URL?>">Home</a></li>
                  <li><a href="<?=$url?>">Bills Management</a>  </li>
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
                <th>Bill Image</th>
                <th>Bill ID</th>
                <th>Bill Number</th>
                <th>Dealer Name</th>
                <th>Broker Name</th>
                <th>Bill Amount</th>
                <th>Bill Paid Amount</th>
                <th>Bill Due Amount</th>
                <th>Bill Date</th>
                <th>Bill Created Date</th>
                <th>Status</th>
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
	
	tableLoad(baseUrl +"/model/billModel.php?action=getTableDataBill");

});	


</script>






