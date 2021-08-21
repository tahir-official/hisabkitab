<?php
   include_once('include/header.php');
   if(!isset($_REQUEST['bill_id']) || $_REQUEST['bill_id']==''){$commonFunction->redirect(MAIN_URL.'/all_bills.php'); }
    $billtable = '"bills"';
    $billconditions = "bill_id='".$_REQUEST['bill_id']."' and  store_id='".$store_id."' ";
    $billconditions = '"'.$billconditions.'"';
    $billRun = $conn->query("call fetchRecord($billtable,$billconditions,'')");
    $conn->next_result();
    if($billRun->num_rows <= 0)
    {
        $commonFunction->redirect(MAIN_URL.'/all_bills.php');
    }else{
        $billData = $billRun->fetch_assoc();
    }

    
    $billtable = '"bills"';
    $billconditions = "bill_id = '".$_REQUEST['bill_id']."' and store_id='".$store_id."'";
    $billconditions = '"'.$billconditions.'"';
    $billRun = $conn->query("call fetchRecord($billtable,$billconditions,'')");
    $conn->next_result();
    $billData = $billRun->fetch_assoc();
    $totalBillamount= $billData['bill_amount'];
 
   $billiteamtable = '"bill_item"';
   $billiteamconditions = "bill_id = '".$_REQUEST['bill_id']."' ";
   $billiteamconditions = '"'.$billiteamconditions.'"';
   $billiteamRun = $conn->query("call fetchRecord($billiteamtable,$billiteamconditions,'')");
   $conn->next_result();
   $billiteamData = $billiteamRun->fetch_all(MYSQLI_ASSOC);
   $totalBilliteamamount=0;
   foreach($billiteamData as $billiteamrow){
         $totalBilliteamamount +=$billiteamrow['paid_amount'] ;
   }
   $totalBilliteamamount = $totalBilliteamamount;
   $duaAmount= $totalBillamount - $totalBilliteamamount;

   $billiteampaidper=($totalBilliteamamount/$totalBillamount) * 100;
   $billiteamdueper=($duaAmount/$totalBillamount) * 100;
      
    
   ?>
<div class="container-fluid page-body-wrapper">
<?php
   include_once('include/sidebar.php');
?>
<style>
.mymodal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
}
.mymodal-content {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
}
@keyframes zoom {
  from {transform:scale(0)}
  to {transform:scale(1)}
}
.myclose {
   position: absolute;
top: 68px;
right: 480px;
color: white;
font-size: 40px;
font-weight: bold;
transition: 0.3s;
background: #284cef;
border-radius: 15px;
border: 1px #3956f0 solid;
}

.myclose:hover,
.myclose:focus {
  color: red;
  text-decoration: none;
  cursor: pointer;
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
  .mymodal-content {
    width: 100%;
  }
} 
</style>
<!-- partial -->
<div class="main-panel">
<div class="content-wrapper">
   <!-- Page Title Header Starts-->
  
   
   <div class="row page-title-header">
      <div class="col-12">
         <div class="page-header">
            <h4 class="page-title">Paid History Management</h4> <?php if($billData['status']==0){
               ?>
               <button type="button"   class="btn btn-primary toolbar-item" onclick="return loadPopupBillIteam(<?=$_REQUEST['bill_id']?>,0);">Add Paid History</button>
               <?php
            }?> 
            
            <div class="quick-link-wrapper w-100 d-md-flex flex-md-wrap">
               <ul class="quick-links ml-auto">
                  <li><a href="<?=MAIN_URL?>">Home</a></li>
                  <li><a href="<?=$url?>">Bills Management</a>  </li>
               </ul>
            </div>
         </div>
      </div>
      
   </div>
  
   <div class="row page-title-header">
                        <div class="col-md-4">
                           <div class="d-flex align-items-center pb-2">
                              <div class="dot-indicator bg-info mr-2"></div>
                                <p class="mb-0">Total Amount</p>
                              
                           </div>
                                                      <h4 class="font-weight-semibold"><?=CURRENCY.number_format((float)$totalBillamount, 2, '.', '')?></h4>
                           <div class="progress progress-md">
                              <div class="progress-bar bg-info" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                           </div>
                        </div>
                        <div class="col-md-4 mt-4 mt-md-0">
                           <div class="d-flex align-items-center pb-2">
                              <div class="dot-indicator bg-success mr-2"></div>
                              
                                 <p class="mb-0">Total Paid Amount</p>
                              
                           </div>
                                                      <h4 class="font-weight-semibold"><?=CURRENCY.number_format((float)$totalBilliteamamount, 2, '.', '')?></h4>
                           <div class="progress progress-md">
                              <div class="progress-bar bg-success" role="progressbar" style="width: <?=round($billiteampaidper);?>%" aria-valuenow="<?=round($billiteampaidper);?>" aria-valuemin="0" aria-valuemax="<?=round($billiteampaidper);?>"></div>
                           </div>
                        </div>
                        <div class="col-md-4 mt-4 mt-md-0">
                           <div class="d-flex align-items-center pb-2">
                              <div class="dot-indicator bg-danger mr-2"></div>
                              
                                 <p class="mb-0">Total Due Amount</p>
                              
                           </div>
                                                      <h4 class="font-weight-semibold"><?=CURRENCY.number_format((float)$duaAmount, 2, '.', '')?></h4>
                           <div class="progress progress-md">
                              <div class="progress-bar bg-danger" role="progressbar" style="width: <?=round($billiteamdueper);?>%" aria-valuenow="<?=round($billiteamdueper);?>" aria-valuemin="0" aria-valuemax="<?=round($billiteamdueper);?>"></div>
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
                <th>Created Date</th>
                <th>Status</th>
                <th>Action</th>
               
            </tr>
        </thead>
        
    </table>
      </div>
   </div>
</div>
 

<!-- The Modal -->
<div id="myModal" class="modal mymodal">
   
<span class="close">&times;</span>

  
  <img class="modal-content mymodal-content" id="img01">

  
</div> 

<?php
   include_once('include/footer.php');
?>
<script src="<?=MAIN_URL?>/assets/js/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous"></script>
<script type="text/javascript" language="javascript">
	
$(document).ready(function () {
      var bill_id='<?=$_REQUEST['bill_id']?>';
      tableLoad(baseUrl +"/model/billModel.php?action=getTableDataBillIteam",bill_id);

});
// Get the modal
var modal = document.getElementById("myModal");
function abcd(id){
var img = document.getElementById("myImg"+id);
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");
modal.style.display = "block";
modalImg.src = img.src;
}
var span = document.getElementsByClassName("close")[0];
span.onclick = function() {
  modal.style.display = "none";
} 

</script>






