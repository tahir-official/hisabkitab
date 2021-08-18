<?php
include_once('../include/functions.php');
$commonFunction= new functions();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
/*get cities action start*/
if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'addBill')
{   
	//method check statement
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
        create_date = '".date('Y-m-d H:i:s')."' $fileData ";
        if ($conn->query($sql)) {

            $_SESSION['message'] = '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> Bill Added Successfully !!</div>';
            $response['url'] =MAIN_URL.'/all_bills.php';
            $response['status'] =1;
        
        }
        if ($conn->errno) {
            $response['html'] ='<div class="modal-body"><div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something Went Wrong !!</div></div>';
            $response['status'] =0;
        }

        }else{
        //error message
		$response['html'] ='<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Bill image not upload try again !!</div>';
		$response['status'] =0;   
        }
        

		

	}else{
		//error message
		$response['html'] ='<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something Went Wrong !!</div>';
		$response['status'] =0;
		
	}
	
	 echo json_encode($response);
}
/*get cities action end*/

?>