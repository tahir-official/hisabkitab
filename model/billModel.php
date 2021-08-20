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
                    
                    $uploadImage = true;
                }
                $fileD = '/assets/images/bill_image/' .$filename;
                $fileData= ", `bill_image` = '" .$fileD ."'";
                
            }
            if($uploadImage){
            $bill_number_auto='BI'.rand(10000,1000000);
            $sql = "insert into bills set bill_number_auto = '".$bill_number_auto."', bill_number = '".$_POST['bill_number']."',
            dealer_id = '".$_POST['dealer_id']."',bill_amount = '".$_POST['bill_amount']."',bill_date = '".$_POST['bill_date']."',
            create_date = '".date('Y-m-d H:i:s')."',store_id = '".$_SESSION['store_id']."' $fileData ";
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
                    
                    
                }
                $fileD = '/assets/images/bill_image/' .$filename;
                $fileData= ", `bill_image` = '" .$fileD ."'";
                
            }
           
            $sql = "UPDATE bills SET bill_number = '".$_POST['bill_number']."',
            dealer_id = '".$_POST['dealer_id']."',bill_amount = '".$_POST['bill_amount']."',bill_date = '".$_POST['bill_date']."' $fileData
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

        // $query = "SELECT U.id,U.user_type,U.fname,U.lname,U.email_address,U.c_number,
        // U.address,U.city_id,U.state_id,U.status,U.store_id,U.broker_id,U.cdate,C.city,S.name FROM $tableName as U INNER JOIN cities as C
        // ON U.city_id = C.id INNER JOIN states AS S ON U.state_id = S.id ";
        $query = "SELECT T.bill_id,T.bill_number_auto,T.bill_number,T.dealer_id,T.bill_amount,T.bill_date,T.status,T.bill_image,
        T.store_id,T.create_date,U.fname,U.lname,U.broker_id FROM $tableName as T INNER JOIN users as U  ON T.dealer_id = U.id  ";
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
            $sub_array[] = '<img style="width: 150px;height: 150px;" src="'.MAIN_URL.$row['bill_image'].'">';
            $sub_array[] = $row['bill_number_auto'];
            $sub_array[] = $row['bill_number'];
            $sub_array[] = $row['fname'].' '.$row['lname'];
            $sub_array[] = $row['fname'].' '.$row['lname'];
            $sub_array[] = $row['bill_amount'];
            $sub_array[] = $row['bill_amount'];
            $sub_array[] = $row['bill_amount'];
            $sub_array[] = $commonFunction->dateFormat($row['bill_date']);
            $sub_array[] = $commonFunction->dateFormat($row['create_date']);
            // $usertable = '"users"';
            // $userconditions = "id='".$row['broker_id']."'";
            // $userconditions = '"'.$userconditions.'"';
            // $userRun = $conn->query("call fetchRecord($usertable,$userconditions,'')");
            // $userData = $userRun->fetch_assoc();
            // $conn->next_result();
            // $sub_array[] = $userData['fname'].' '.$userData['lname'];
            if($row['status']==0){
                $changeStatus="return changeUserStatus('".$row['bill_id']."',1,'dealer')";
                $status='<a class="stbtn" href="javascript:void(0)" onClick="'.$changeStatus.'"><label style="color: white;cursor: pointer;" class="badge badge-success">Active</label></a>';
            }else{
                $changeStatus="return changeUserStatus('".$row['bill_id']."',0,'dealer')";
                $status='<a class="stbtn" href="javascript:void(0)" onClick="'.$changeStatus.'"><label style="color: white;cursor: pointer;" class="badge badge-danger">Deactive</label></a>';
            }
            $sub_array[] = $status;
            
            $sub_array[] = '<a href="'.MAIN_URL.'/edit_bill.php?bill_id='.$row['bill_id'].'" ><label style="color: white; cursor: pointer;" class="badge badge-danger">Edit</label></a>';
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

?>