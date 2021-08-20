<?php
   include_once('include/header.php');
?>
<div class="container-fluid page-body-wrapper">
<?php
   include_once('include/sidebar.php');
?>

<div class="main-panel">
<div class="content-wrapper">
   <div class="row page-title-header">
      <div class="col-12">
         <div class="page-header">
            <h4 class="page-title">Add Bill</h4>
            <div class="quick-link-wrapper w-100 d-md-flex flex-md-wrap">
               <ul class="quick-links ml-auto">
                  <li><a href="<?=MAIN_URL?>">Home</a></li>
                  <li><a href="<?=MAIN_URL?>/all_bills.php">Bills Management</a></li>
               </ul>
            </div>
         </div>
      </div>
   </div>
   <div id="alert">
   </div>
   
   <div class="row">
      
      <div class="col-md-9 d-flex align-items-stretch grid-margin">
         <div class="row flex-grow">
            <div class="col-12">
               <div class="card">
                  <div class="card-body">
                     <h4 class="card-title">Bill Details </h4>
                     
                     <form class="forms-sample" role="form" method="post" id="addBill" enctype="multipart/form-data" >
                        <div class="form-group">
                            <label for="dealer_id">Select Dealer</label>
                            <select id="dealer_id" name="dealer_id" class="form-control">
                                <option value="">Select Dealer</option>
                                <?php
                                    $dealerTable = '"users"';
                                    $dealerconditions = "user_type='dealer' and store_id='".$_SESSION['store_id']."' and status='0'";
                                    $dealerconditions = '"'.$dealerconditions.'"';
                                    $dealerrun = $conn->query("call fetchRecord($dealerTable,$dealerconditions,'')");
                                    $dealerRow = $dealerrun->fetch_all(MYSQLI_ASSOC);
                                    foreach($dealerRow as $dealer){
                                     echo '<option  value="'.$dealer['id'].'">'.$dealer['fname'].' '.$dealer['lname'].'</option>';
                                    }
                                ?>
                                
                            </select>
                        </div>
                        <div class="form-group">
                           <label for="bill_number">Bill Number</label>
                           <input type="text" class="form-control" name="bill_number" id="bill_number" placeholder="Enter Bill Number" value=""  >
                        </div>
                        <div class="form-group">
                           <label for="bill_amount">Bill Amount</label>
                           <input type="text"  class="form-control number_input" name="bill_amount" id="bill_amount" placeholder="0.00" value="">
                        </div>
                        <div class="form-group">
                           <label for="bill_date">Bill Date</label>
                           <input type="date" class="form-control" name="bill_date" id="bill_date"  value="">
                        </div>
                        <div class="form-group">
                           <label for="bill_image">Bill Image</label>
                           <input type="file" class="form-control" name="bill_image" id="bill_image" onchange="loadFile(event,'preview')" value="" accept="image/*">
                           
                        </div>
                        <div class="form-group">
                           <label for="bill_number">Remark</label>
                           <textarea class="form-control"  id="bill_remark" name="bill_remark" ></textarea>
                           
                        </div>
                        
                        <button type="submit" name="submit" id="addBtn" class="btn btn-success mr-2 btnSubmit">Add Bill</button>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="col-md-3 d-flex align-items-stretch grid-margin">
         <div class="row flex-grow">
            <div class="col-12">
               <img id="preview" style="height: 587px;"/>
                
            </div>
         </div>
      </div>
      
   </div>
</div>
<!-- content-wrapper ends -->


<?php
   include_once('include/footer.php');
?>
<script src="<?=MAIN_URL?>/assets/js/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous"></script>
<script>
    $(document).ready(function () {
       $('.number_input').mask('00000.00', { reverse: true });

            $('#addBill').validate({ 
    
            rules: {
            dealer_id: {
            required : true
            },
            bill_number: {
            required : true
            },
            bill_amount: {
            required: true,
            number: true
            },
            bill_date: {
            required : true,
            },
            
            bill_image: {
            required : true,
            
            },
            
            },
            submitHandler: function (form) { 
            var formData = new FormData($('#addBill')[0]);
            $.ajax({
                method: "POST",
                url: baseUrl + "/model/billModel.php?action=addBill",
                data: formData,
                dataType: 'JSON',
                cache:false,
                contentType: false,
                processData: false,
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
               if(response.status==0){
                  $("#alert").show();
                  $("#alert").html(response.message);
                  $(".btnSubmit").html('Add Bill');
                  $(".btnSubmit").prop('disabled', false);
               }else{
                  
                  window.location.href = response.url;
               }
            })
            .always(function() {
               $(".btnSubmit").html('Add Bill');
               $(".btnSubmit").prop('disabled', false);
            });
                return false; 
            }
        });

    });

    var loadFile = function(event,view_id) {
    var output = document.getElementById(view_id);
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function(){
      URL.revokeObjectURL(output.src) // free memory
      $('#'+view_id).css('width','264px');
      
    }
    };
</script>

