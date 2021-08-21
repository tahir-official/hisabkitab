<?php
   include_once('include/header.php');
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
right: 377px;
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
   
<span class="close myclose">&times;</span>

  
  <img class="modal-content mymodal-content" id="img01">

  
</div> 

<?php
   include_once('include/footer.php');
?>
<script type="text/javascript" language="javascript">

$(document).ready(function(){
	
	tableLoad(baseUrl +"/model/billModel.php?action=getTableDataBill",null);

});	
// Get the modal
var modal = document.getElementById("myModal");
function previeallimage(id){
var img = document.getElementById("myImg"+id);
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");
modal.style.display = "block";
modalImg.src = img.src;
}
var span = document.getElementsByClassName("myclose")[0];
span.onclick = function() {
  modal.style.display = "none";
} 

</script>






