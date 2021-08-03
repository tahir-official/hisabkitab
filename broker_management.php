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
               <button type="button"  onclick="return loadPopupUser(1,0);" class="btn btn-primary toolbar-item">Add Broker</button>
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
                <th>Name</th>
                <th>Position</th>
                <th>Office</th>
                <th>Age</th>
                <th>Start date</th>
               
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
	
	tableLoad();

});	

function tableLoad(){

   var dataTable = $('#mytable').DataTable({
		"processing" : true,
		"serverSide" : true,
		"order" : [],
		"ajax" : {
			url:"<?=MAIN_URL?>//model/userModel.php?action=getTableData",
			type:"POST"
		}
	});
	
	// $('#column_name').selectpicker();

	// $('#column_name').change(function(){

	// 	var all_column = ["0", "1", "2", "3", "4"];

	// 	var remove_column = $('#column_name').val();

	// 	var remaining_column = all_column.filter(function(obj) { return remove_column.indexOf(obj) == -1; });

	// 	dataTable.columns(remove_column).visible(false);

	// 	dataTable.columns(remaining_column).visible(true);

	// });

}
</script>






