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
            <h4 class="page-title">Edit Bill</h4>
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
                     
                     <form class="forms-sample" role="form" method="post" id="editBill" enctype="multipart/form-data" >
                        <input type="hidden" name="bill_id" value="<?=$_REQUEST['bill_id']?>" >
                        <input type="hidden" name="bill_image" value="<?=$billData['bill_image']?>" >
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
                                    $selectdealer='';    
                                    if($dealer['id']==$billData['dealer_id']){$selectdealer='selected';}    
                                     echo '<option '.$selectdealer.' value="'.$dealer['id'].'">'.$dealer['fname'].' '.$dealer['lname'].'</option>';
                                    }
                                ?>
                                
                            </select>
                        </div>
                        <div class="form-group">
                           <label for="bill_number">Bill Number</label>
                           <input type="text" class="form-control" name="bill_number" id="bill_number" placeholder="Enter Bill Number" value="<?=$billData['bill_number']?>"  >
                        </div>
                        <div class="form-group">
                           <label for="bill_amount">Bill Amount</label>
                           <input type="text"  class="form-control number_input" name="bill_amount" id="bill_amount" placeholder="0.00" value="<?=$billData['bill_amount']?>">
                        </div>
                        <div class="form-group">
                           <label for="bill_date">Bill Date</label>
                           <input type="date" class="form-control" name="bill_date" id="bill_date"  value="<?=$billData['bill_date']?>">
                        </div>
                        <div class="form-group">
                           <label for="bill_image">Bill Image</label>
                           <input type="file" class="form-control" name="bill_image" id="bill_image" onchange="loadFile(event,'preview')" value="" accept="image/*">
                           
                        </div>
                        <div class="form-group">
                           <label for="bill_number">Remark</label>
                           <textarea class="form-control"  id="bill_remark" name="bill_remark" ><?=html_entity_decode($billData['bill_remark'], ENT_QUOTES)?></textarea>
                           
                        </div>
                        
                        <button type="submit" name="submit" id="addBtn" class="btn btn-success mr-2 btnSubmit">Edit Bill</button>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="col-md-3 d-flex align-items-stretch grid-margin">
         <div class="row flex-grow">
            <div class="col-12">
                <?php
                $imgsrc='';
                $imgwidht='';
                if($billData['bill_image']!=''){
                    $imgsrc=MAIN_URL.$billData['bill_image'];
                    $imgwidht='width:264px;';
                }
                ?>
               <img id="preview" src="<?=$imgsrc?>" style="height: 587px;<?=$imgwidht?>"/>
                
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

            $('#editBill').validate({ 
    
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
            
            },
            submitHandler: function (form) { 
            var formData = new FormData($('#editBill')[0]);
            $.ajax({
                method: "POST",
                url: baseUrl + "/model/billModel.php?action=editBill",
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
                $(".btnSubmit").html('Edit Bill');
                $(".btnSubmit").prop('disabled', false);
            }else{
                
                window.location.href = response.url;
            }
                
            })
            .always(function() {
               $(".btnSubmit").html('Edit Bill');
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

