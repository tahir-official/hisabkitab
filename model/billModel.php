<?php
include_once('../include/functions.php');
$commonFunction= new functions();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
/*add bill action start*/
if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'addBill')
{   
	//method check statement
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $store_id=$_SESSION['store_id'];
        $billtable = '"bills"';
        $billconditions = "bill_number='".$_POST['bill_number']."' and  store_id='".$store_id."' ";
        $billconditions = '"'.$billconditions.'"';
        $billRun = $conn->query("call fetchRecord($billtable,$billconditions,'')");
        $conn->next_result();
        if($billRun->num_rows <= 0)
        {
            $uploadImage = false;
            if($_FILES["bill_image"]['error'] == 0){
                $filename = rand(100, 500) .time() .rand(100, 500) ."." .ltrim(strstr($_FILES['bill_image']['name'], '.'), '.');
                $target_file = "../assets/images/bill_image/" .$filename;
                if(move_uploaded_file($_FILES["bill_image"]["tmp_name"], $target_file)){
                    $fileD = '/assets/images/bill_image/' .$filename;
                    $fileData= ", `bill_image` = '" .$fileD ."'"; 
                    $uploadImage = true;
                }
                
                
            }
            if($uploadImage){
            $bill_number_auto='BI'.rand(10000,1000000);
            $sql = "insert into bills set bill_number_auto = '".$bill_number_auto."', bill_number = '".$_POST['bill_number']."',
            dealer_id = '".$_POST['dealer_id']."',bill_amount = '".$_POST['bill_amount']."',bill_date = '".$_POST['bill_date']."',
            create_date = '".date('Y-m-d H:i:s')."',store_id = '".$_SESSION['store_id']."',bill_remark = '".htmlentities($_POST['bill_remark'],ENT_QUOTES)."' $fileData ";
            if ($conn->query($sql)) {
    
                $_SESSION['message'] = '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> Bill Added Successfully !!</div>';
                $response['url'] =MAIN_URL.'/all_bills.php';
                $response['status'] =1;
            
            }
            if ($conn->errno) {
                $response['message'] ='<div class="modal-body"><div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something Went Wrong !!</div></div>';
                $response['status'] =0;
            }
    
            }else{
            //error message
            $response['message'] ='<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Bill image not upload try again !!</div>';
            $response['status'] =0;   
            }
        }else{
            
            $response['message'] ='<div class="modal-body"><div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Bill Number already exists, Please Enter different Bill Number !!</div></div>';
            $response['status'] =0;
            
        }

   }else{
		//error message
		$response['message'] ='<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something Went Wrong !!</div>';
		$response['status'] =0;
		
	}
	
	 echo json_encode($response);
}
/*add bill action end*/
/*add bill action start*/
else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'editBill')
{   
	//method check statement
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $store_id=$_SESSION['store_id'];
        $billtable = '"bills"';
        $billconditions = "bill_number='".$_POST['bill_number']."' and  store_id='".$store_id."'  and bill_id != '".$_POST['bill_id']."' ";
        $billconditions = '"'.$billconditions.'"';
        $billRun = $conn->query("call fetchRecord($billtable,$billconditions,'')");
        $conn->next_result();
        if($billRun->num_rows <= 0)
        {
            $fileData= ", `bill_image` = '" .$_POST['bill_image'] ."'";
            if($_FILES["bill_image"]['error'] == 0){
                $filename = rand(100, 500) .time() .rand(100, 500) ."." .ltrim(strstr($_FILES['bill_image']['name'], '.'), '.');
                $target_file = "../assets/images/bill_image/" .$filename;
                if(move_uploaded_file($_FILES["bill_image"]["tmp_name"], $target_file)){
                $fileD = '/assets/images/bill_image/' .$filename;
                $fileData= ", `bill_image` = '" .$fileD ."'"; 
                if(file_exists('..'.$_POST['bill_image'])) unlink('..'.$_POST['bill_image']);
                    
                }
                
                
            }
           
            $sql = "UPDATE bills SET bill_number = '".$_POST['bill_number']."',
            dealer_id = '".$_POST['dealer_id']."',bill_amount = '".$_POST['bill_amount']."',bill_date = '".$_POST['bill_date']."',bill_remark = '".htmlentities($_POST['bill_remark'],ENT_QUOTES)."' $fileData
            WHERE bill_id='".$_POST['bill_id']."'";
           if ($conn->query($sql)) {
    
                $_SESSION['message'] = '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> Bill Updated Successfully !!</div>';
                $response['url'] =MAIN_URL.'/all_bills.php';
                $response['status'] =1;
            
            }
            if ($conn->errno) {
                $response['message'] ='<div class="modal-body"><div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something Went Wrong !!</div></div>';
                $response['status'] =0;
            }
    
            
        }else{
            
            $response['message'] ='<div class="modal-body"><div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Bill Number already exists, Please Enter different Bill Number !!</div></div>';
            $response['status'] =0;
            
        }

   }else{
		//error message
		$response['message'] ='<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something Went Wrong !!</div>';
		$response['status'] =0;
		
	}
	
	 echo json_encode($response);
}
/*add bill action end*/
/*get bill table data action start*/
else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'getTableDataBill')
{  
        $store_id= $_SESSION['store_id'];
        $tableName='bills';
	    $column = array(null,"bill_number_auto", "bill_number","dealer_id", "bill_amount","bill_date","status");
        $query = "SELECT T.bill_id,T.bill_number_auto,T.bill_number,T.dealer_id,T.bill_amount,T.bill_date,T.status,T.bill_image,
        T.store_id,T.create_date,U.fname,U.lname,U.broker_id,U2.fname as bfname,U2.lname as blname FROM $tableName as T INNER JOIN users as U  ON T.dealer_id = U.id
        LEFT JOIN users as U2 ON U.broker_id=U2.id ";
        if(isset($_POST["search"]["value"]))
        {
            $query .= '
            WHERE T.bill_number_auto LIKE "%'.$_POST["search"]["value"].'%" 
            OR T.bill_number LIKE "%'.$_POST["search"]["value"].'%" 
            OR U.fname LIKE "%'.$_POST["search"]["value"].'%" 
            OR U.lname LIKE "%'.$_POST["search"]["value"].'%" 
            OR T.bill_amount LIKE "%'.$_POST["search"]["value"].'%"
            OR T.bill_date LIKE "%'.$_POST["search"]["value"].'%"
            OR T.create_date LIKE "%'.$_POST["search"]["value"].'%"
            OR U2.fname LIKE "%'.$_POST["search"]["value"].'%"
            OR U2.lname LIKE "%'.$_POST["search"]["value"].'%"
            ';
        }
        
        $main_query="SELECT * FROM ($query) as X WHERE X.store_id=$store_id ";
        if(isset($_POST["order"]))
        {
            $main_query .= ' ORDER BY '.$column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
        }
        else
        {
            $main_query .= ' ORDER BY X.bill_id DESC ';
        }
       //echo $main_query ;
        
        $query1 = '';

        if($_POST["length"] != -1)
        {
            $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
        }
        $statement = $conn->query($main_query);
        $number_filter_row = $statement->num_rows;
        $result = $conn->query($main_query . $query1);
        $data = array();
        $i=1;
        foreach($result as $row)
        {
            $sub_array = array();
            $sub_array[] = $i;
            $sub_array[] = '<img onclick="previeallimage('.$row['bill_id'].')" id="myImg'.$row['bill_id'].'" alt="Snow" style="width: 100px;height: 100px;" src="'.MAIN_URL.$row['bill_image'].'">';
            $sub_array[] = $row['bill_number_auto'];
            $sub_array[] = $row['bill_number'];
            $sub_array[] = $row['fname'].' '.$row['lname'];
            $sub_array[] = $row['bfname'].' '.$row['blname'];
            $sub_array[] = CURRENCY.number_format((float)$row['bill_amount'], 2, '.', '');

            $billiteamtable = '"bill_item"';
            $billiteamconditions = "bill_id = '".$row['bill_id']."' ";
            $billiteamconditions = '"'.$billiteamconditions.'"';
            $billiteamRun = $conn->query("call fetchRecord($billiteamtable,$billiteamconditions,'')");
            $conn->next_result();
            $billiteamData = $billiteamRun->fetch_all(MYSQLI_ASSOC);
            $totalBilliteamamount=0;
            foreach($billiteamData as $billiteamrow){
                $totalBilliteamamount +=$billiteamrow['paid_amount'] ;
            }
            $totalBilliteamamount = $totalBilliteamamount;

            $sub_array[] = '<span style="color: green;">'.CURRENCY.number_format((float)$totalBilliteamamount, 2, '.', '').'</span>';
            $duaAmount= $row['bill_amount'] - $totalBilliteamamount;
            $sub_array[] = '<span style="color: red;">'.CURRENCY.number_format((float)$duaAmount, 2, '.', '').'</span>';
            $sub_array[] = $commonFunction->dateFormat($row['bill_date']);
            $sub_array[] = $commonFunction->dateFormat($row['create_date']);
            if($row['status']==0){
                if($duaAmount <= 0){
                    $changeStatus="return changeBillStatus('".$row['bill_id']."')";
                    $status='<a class="stbtn" href="javascript:void(0)" onClick="'.$changeStatus.'"><label style="color: white;cursor: pointer;" class="badge badge-dark">Mark as completed</label></a>';
                }else{
                    $status='<label style="color: white;" class="badge badge-warning">Pending</label>';
                }
                
            }else{
                   $status='<label style="color: white;" class="badge badge-success">Completed</label>';
            }
            $sub_array[] = $status;
            if($row['status']==0){
                $action='<a href="'.MAIN_URL.'/edit_bill.php?bill_id='.$row['bill_id'].'" ><label style="color: white; cursor: pointer;" class="badge badge-danger">Edit</label></a>';
                $action .='<a href="'.MAIN_URL.'/all_bill_iteam.php?bill_id='.$row['bill_id'].'" ><label style="color: white; cursor: pointer;" class="badge badge-info">Paid Detail</label></a>';
            }else{
                $action ='<a href="'.MAIN_URL.'/all_bill_iteam.php?bill_id='.$row['bill_id'].'" ><label style="color: white; cursor: pointer;" class="badge badge-info">Paid Detail</label></a>';
            }
            
            $sub_array[] = $action;
            $data[] = $sub_array;
            $i++;
        }

        /*this code for all records*/
        $query_all = "SELECT * FROM $tableName where store_id  = $store_id ";
        $statement_all = $conn->query($query_all);
        $statement_all_count= $statement_all->num_rows;

        $output = array(
            "draw"		=>	intval($_POST["draw"]),
            "recordsTotal"	=>	$statement_all_count,
            "recordsFiltered"	=>	$number_filter_row,
            "data"	=>	$data
        );

        echo json_encode($output);
}
/*get bill table data action end*/

/*get bill iteam table data action start*/
else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'getTableDataBillIteam')
{  
        $bill_id= $_POST["other_id"];
        $store_id= $_SESSION['store_id'];
        $tableName='bill_item';
	    $column = array(null,"bill_number_auto", "bill_number","dealer_id", "bill_amount","bill_date","status");
        $query = "SELECT BI.item_id,BI.bill_id,BI.paid_amount,BI.payment_mode,BI.paid_image,BI.paid_remark,BI.paid_date,B.status FROM 
        $tableName as BI LEFT JOIN bills as B  ON BI.bill_id = B.bill_id";
        if(isset($_POST["search"]["value"]))
        {
            $query .= '
            WHERE BI.paid_amount LIKE "%'.$_POST["search"]["value"].'%" 
            OR BI.payment_mode LIKE "%'.$_POST["search"]["value"].'%" 
            OR BI.paid_remark LIKE "%'.$_POST["search"]["value"].'%" 
            OR BI.paid_date LIKE "%'.$_POST["search"]["value"].'%" 
            ';
        }
        
        $main_query="SELECT * FROM ($query) as X WHERE X.bill_id=$bill_id ";
        
        
        if(isset($_POST["order"]))
        {
            $main_query .= ' ORDER BY '.$column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
        }
        else
        {
            $main_query .= ' ORDER BY X.item_id DESC ';
        }
        $main_query ;
        
        $query1 = '';

        if($_POST["length"] != -1)
        {
            $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
        }
        $statement = $conn->query($main_query);
        $number_filter_row = $statement->num_rows;
        $result = $conn->query($main_query . $query1);
        $data = array();
        $i=1;
        foreach($result as $row)
        {
            $sub_array = array();
            $sub_array[] = $i;
            $sub_array[] = '<img onclick="previeallimage('.$row['item_id'].')" id="myImg'.$row['item_id'].'" alt="Snow" style="width: 100px;height: 100px;" src="'.MAIN_URL.$row['paid_image'].'">';
            $sub_array[] = '<span style="color: green;">'.CURRENCY.number_format((float)$row['paid_amount'], 2, '.', '').'</span>';
            $sub_array[] = str_replace('_',' ',ucwords($row['payment_mode'],'_'));
            $sub_array[] = $commonFunction->dateFormat($row['paid_date']);
            $sub_array[] = $row['paid_remark'];
            
            if($row['status']==0){
                $loadPopupIteam="loadPopupBillIteam($bill_id,'".$row['item_id']."')";
                $action='<a href="javascript:void(0)" onClick="return '.$loadPopupIteam.'"><label style="color: white; cursor: pointer;" class="badge badge-danger">Edit</label></a>';
                
            }else{
                $action ='';
            }
            
            $sub_array[] = $action;
            $data[] = $sub_array;
            $i++;
        }

        /*this code for all records*/
        $query_all = "SELECT * FROM $tableName where bill_id= $bill_id  ";
        $statement_all = $conn->query($query_all);
        $statement_all_count= $statement_all->num_rows;

        $output = array(
            "draw"		=>	intval($_POST["draw"]),
            "recordsTotal"	=>	$statement_all_count,
            "recordsFiltered"	=>	$number_filter_row,
            "data"	=>	$data
        );

        echo json_encode($output);
}
/*get bill iteam table data action end*/
else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'changeBillStatus'){ 
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $bill_id=$_POST['bill_id'];
        
        $sql = "UPDATE bills SET status=1 WHERE bill_id='".$bill_id."'";

        if ($conn->query($sql)) {
          
        $response['message'] = '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> Mark as completed Successfully !!</div>';
        $response['status'] =1;
        $response['fetchTableurl'] =MAIN_URL.'/model/billModel.php?action=getTableDataBill';;
        
        
        }
        if ($conn->errno) {
            $response['message'] ='<div class="modal-body"><div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something Went Wrong !!</div></div>';
            $response['status'] =0;
        }


    }
    else{
		//error message
		$response['message'] ='<div class="modal-body"><div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something Went Wrong !!</div></div>';
		$response['status'] =0;
	}
    echo json_encode($response);
}

else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'loadPopupBillIteam'){  
	//method check statement
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $option='<option value="">Select Payment Mode</option>';   
        $paymode=$commonFunction->paymentmode(); 
        if($_POST['paid_id']==0){
            $modal_title='Add Paid History';
            $sabBtn='Add';
            $formId='AddbillIteamForm';
            
            
            foreach($paymode as $x => $x_value) {
                $option .= '<option value="'.$x_value.'">'.$x.'</option>';
                
            }
            $paid_amount='';
            $paid_date='';
            $paid_remark='';
            $imagedata='';
            $imagepreview='';

        }else{
            $modal_title='Edit Paid History ';
            $sabBtn='Update';
            $formId='updatebillIteamForm';
            $billiteamtable = '"bill_item"';
            $billiteamconditions = "item_id = '".$_POST['paid_id']."' ";
            $billiteamconditions = '"'.$billiteamconditions.'"';
            $billiteamRun = $conn->query("call fetchRecord($billiteamtable,$billiteamconditions,'')");
            $conn->next_result();
            $billiteamData = $billiteamRun->fetch_assoc();

            foreach($paymode as $x => $x_value) {
                $selected='';
                if($x_value==$billiteamData['payment_mode']){$selected='selected';}
                $option .= '<option '.$selected.' value="'.$x_value.'">'.$x.'</option>';
                
            }
            $paid_amount=$billiteamData['paid_amount'];
            $paid_date = $billiteamData['paid_date'];
            $paid_remark=$billiteamData['paid_remark'];
            $imagedata='<div class="form-group pmd-textfield pmd-textfield-floating-label">
            <label for="paid_image">Preview</label>
            <img style="width: 100px;height: 100px;border: 1px solid;" src="'.MAIN_URL.$billiteamData['paid_image'].'" >
            </div>';
            $imagepreview='<input  name="paid_image_preview" value="'.$billiteamData['paid_image'].'" class="form-control" type="hidden" >';
         }
        
        $response['html'] ='<div class="modal-header pmd-modal-border">
                                    <h3 class="modal-title">'.$modal_title.'</h3>
                                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                </div>
                                <div id="popupalert"></div>
                                <form id="'.$formId.'" method="post">
                                <div class="modal-body">
                                        <input  name="paid_id" value="'.$_POST['paid_id'].'" class="form-control" type="hidden" >
                                        <input  name="bill_id" value="'.$_POST['bill_id'].'" class="form-control" type="hidden" >
                                        '.$imagepreview.'
                                        <div class="form-group pmd-textfield pmd-textfield-floating-label">
                                            <label for="paid_amount">Paid Amount</label>
                                            <input type="text"  class="form-control number_input" name="paid_amount" id="paid_amount" placeholder="0.00" value="'.$paid_amount.'" >
                                        </div>
                                        <div class="form-group pmd-textfield pmd-textfield-floating-label">
                                            <label for="payment_mode">Select Payment Mode</label>
                                            <select id="payment_mode" name="payment_mode" class="form-control" >
                                                    '.$option.'
                                                
                                            </select>
                                        </div>
                                        <div class="form-group pmd-textfield pmd-textfield-floating-label">
                                            <label for="paid_date">Paid Date</label>
                                            <input id="paid_date" name="paid_date"  class="form-control" type="date" value="'.$paid_date.'">
                                        </div>
                                        <div class="form-group pmd-textfield pmd-textfield-floating-label">
                                            <label for="paid_image">Image</label>
                                            <input type="file" id="paid_image" name="paid_image" class="mat-input form-control"  value="">
                                        </div>
                                        '.$imagedata.'
                                        <div class="form-group pmd-textfield pmd-textfield-floating-label">
                                        <label for="paid_remark">Remark</label>
                                        <textarea class="form-control  pmd-textfield pmd-textfield-floating-label"  id="paid_remark" name="paid_remark" >'.$paid_remark.'</textarea>
                                        </div>
                                        
                                        
                                     
                                </div>
                                <div class="modal-footer">
                                    <button data-dismiss="modal" class="btn pmd-ripple-effect btn-dark pmd-btn-flat" type="button">Cancel</button>
                                    <button  class="btn pmd-ripple-effect btn-primary pmd-btn-flat btnsbt" type="submit">'.$sabBtn.'</button>
                                </div>
                                </form>';
			
		

	}else{
		//error message
		$response['html'] ='<div class="modal-body"><div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something Went Wrong !!</div></div>';
		
	}
echo json_encode($response);
}
/*load user popup process end*/

/*add bill action start*/
else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'paidIteamManage')
{   
	//method check statement
	if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $store_id=$_SESSION['store_id'];
        $billtable = '"bills"';
        $billconditions = "bill_id = '".$_POST['bill_id']."' and store_id='".$store_id."'";
        $billconditions = '"'.$billconditions.'"';
        $billRun = $conn->query("call fetchRecord($billtable,$billconditions,'')");
        $conn->next_result();
        $billData = $billRun->fetch_assoc();
        $totalBillamount= $billData['bill_amount'];

        
        

        if($_POST['paid_id']==0){
            $billiteamtable = '"bill_item"';
            $billiteamconditions = "bill_id = '".$_POST['bill_id']."' ";
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
            if($_POST['paid_amount'] <= $duaAmount){
                $uploadImage = false;
                if($_FILES["paid_image"]['error'] == 0){
                    $filename = rand(100, 500) .time() .rand(100, 500) ."." .ltrim(strstr($_FILES['paid_image']['name'], '.'), '.');
                    $target_file = "../assets/images/paid_image/" .$filename;
                    if(move_uploaded_file($_FILES["paid_image"]["tmp_name"], $target_file)){
                        $fileD = '/assets/images/paid_image/' .$filename;
                        $fileData= ", `paid_image` = '" .$fileD ."'"; 
                        $uploadImage = true;
                    }
                    
                    
                }
                if($uploadImage){
                    
                    $sql = "insert into bill_item set bill_id = '".$_POST['bill_id']."', paid_amount = '".$_POST['paid_amount']."',
                    payment_mode = '".$_POST['payment_mode']."',paid_remark = '".htmlentities($_POST['paid_remark'],ENT_QUOTES)."',
                    paid_date = '".$_POST['paid_date']."' $fileData ";
                    if ($conn->query($sql)) {
            
                        $response['message'] = '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> Paid History Added Successfully !!</div>';
                        
                        $response['status'] =1;
                        $tpaid=$totalBilliteamamount+$_POST['paid_amount'];
                        $tdua=$duaAmount-$_POST['paid_amount'];
                    
                    }
                    if ($conn->errno) {
                        $response['message'] ='<div class="modal-body"><div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something Went Wrong !!</div></div>';
                        $response['status'] =0;
                    }
                }else{
                    //error message
                    $response['message'] ='<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Paid image not upload try again !!</div>';
                    $response['status'] =0;
                }

            }else{
                $response['message'] ='<div class="modal-body"><div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> This bill dua amount is '.CURRENCY.$duaAmount.', Please enter amount equal to and less than  '.CURRENCY.$duaAmount.' !!</div></div>';
                $response['status'] =0;
            }


        }else{
            $billiteamtable = '"bill_item"';
            $billiteamconditions = "bill_id = '".$_POST['bill_id']."' and item_id != '".$_POST['paid_id']."'";
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
            if($_POST['paid_amount'] <= $duaAmount){

                $fileData= ", `paid_image` = '" .$_POST['paid_image_preview'] ."'";
                if($_FILES["paid_image"]['error'] == 0){
                    $filename = rand(100, 500) .time() .rand(100, 500) ."." .ltrim(strstr($_FILES['paid_image']['name'], '.'), '.');
                    $target_file = "../assets/images/paid_image/" .$filename;
                    if(move_uploaded_file($_FILES["paid_image"]["tmp_name"], $target_file)){
                    $fileD = '/assets/images/paid_image/' .$filename;
                    $fileData= ", `paid_image` = '" .$fileD ."'"; 
                    if(file_exists('..'.$_POST['paid_image_preview'])) unlink('..'.$_POST['paid_image_preview']);
                        
                    }
                    
                    
                }
            
                $sql = "UPDATE bill_item SET paid_amount = '".$_POST['paid_amount']."',
                    payment_mode = '".$_POST['payment_mode']."',paid_remark = '".htmlentities($_POST['paid_remark'],ENT_QUOTES)."',
                    paid_date = '".$_POST['paid_date']."' $fileData WHERE item_id ='".$_POST['paid_id']."'";
                if ($conn->query($sql)) {
        
                    $response['message'] = '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> Paid History Updated Successfully !!</div>';
                    $response['status'] =1;
                    $tpaid=$totalBilliteamamount+$_POST['paid_amount'];
                    $tdua=$duaAmount-$_POST['paid_amount'];
                
                }
                if ($conn->errno) {
                    $response['message'] ='<div class="modal-body"><div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something Went Wrong !!</div></div>';
                    $response['status'] =0;
                }
                

            }else{
                $response['message'] ='<div class="modal-body"><div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> This bill dua amount is '.CURRENCY.$duaAmount.', Please enter amount equal to and less than  '.CURRENCY.$duaAmount.' !!</div></div>';
                $response['status'] =0;
            }

        }
        $response['fetchTableurl'] = MAIN_URL.'/model/billModel.php?action=getTableDataBillIteam';
        $response['other_id'] = $_POST['bill_id'];
        $response['paid_amount'] = CURRENCY.number_format((float)$tpaid, 2, '.', '');
        $response['due_amount'] =  CURRENCY.number_format((float)$tdua, 2, '.', '');

        

   }else{
		//error message
		$response['message'] ='<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something Went Wrong !!</div>';
		$response['status'] =0;
		
	}
	
	 echo json_encode($response);
}
/*add bill action end*/



?>