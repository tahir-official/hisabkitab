<?php
include_once('../include/functions.php');

$db= new functions();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
/*login action start*/
if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'loadPopup'){  
	//method check statement
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		//poup check statement
		if($_POST['popupname'] == 'addBroker') {
            $response['html'] ='<div class="modal-header pmd-modal-border">
            <h2 class="modal-title">Get In Touch</h2>
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
        </div>
        <div class="modal-body">
            <form>
                <div class="form-group pmd-textfield pmd-textfield-floating-label">
                    <label for="full-name">Full Name</label>
                    <input id="full-name" class="form-control" type="text">
                </div>
                <div class="form-group pmd-textfield pmd-textfield-floating-label">
                    <label for="email">Email Address</label>
                    <input type="email" class="mat-input form-control" id="email" value="">
                </div>
                <div class="form-group pmd-textfield pmd-textfield-floating-label">
                    <label for="mobil">Mobile No.</label>
                    <input type="tel" class="mat-input form-control" id="mobil" value="">
                </div>
                <div class="form-group pmd-textfield pmd-textfield-floating-label">
                    <label class="control-label">Message</label>
                    <textarea required class="form-control"></textarea>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button data-dismiss="modal" class="btn pmd-ripple-effect btn-dark pmd-btn-flat" type="button">Reset</button>
            <button data-dismiss="modal" class="btn pmd-ripple-effect btn-primary pmd-btn-flat" type="button">Send</button>
        </div>';
			
		}else{
			$response['html'] ='<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something Went Wrong !!</div>';
		}

	}else{
		//error message
		$response['html'] ='<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something Went Wrong !!</div>';
		
	}
echo json_encode($response);
}
/*login action end*/
/*forgetPassword action start*/
else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'forgetPassword')
{   
	//method check statement
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$tableName = '"store"';
		//username and password check statement
		if (filter_var($conn->real_escape_string($_POST['username']), FILTER_VALIDATE_EMAIL)) {
			
			$conditions = "email='".$conn->real_escape_string($_POST['username'])."'";
		}else{
			$conditions = "username='".$conn->real_escape_string($_POST['username'])."'";
			
		}
		//fetch record statement with Procedures
		$conditions = '"'.$conditions.'"';
		$run = $conn->query("call fetchRecord($tableName,$conditions,'')");
		$conn->next_result();
		if($run->num_rows > 0)
		{
			$row = $run->fetch_assoc();
			$password=$db->encrypt_decrypt($row['password'],'decrypt');
			$store_id=$row['store_id'];
			
			//send mail
			$subject = "Password Notification !!";
			$html = '<p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Welcome to '.PROJECT.'!</p>';
			$html .= '<p style="margin:0;padding:20px 0px">Hi, '.$row['name'].' !</p>';
			$html .= '<p style="margin:0;padding:20px 0px">We have received your password recover request.</p>';
			$html .= '<p style="margin:0;padding:20px 0px">This is your password :<strong>' .$password .'</strong></p>';
			$db->send_mail($row['email'],$subject,$html);
			//insert history record statement with Procedures
			$conn->query("CALL insertHistory($store_id,'Password recover','This store recovered password !!')");
			//success message
			$response['message'] = '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong>Your password has been successfully recovered. Please check your password in register email !!</div>';
			$response['status']=1;
			
		}
		else
		{
			//error message
			$response['message'] ='<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Username or Email not exists !!</div>';
			$response['status']=0;
			
		}

	}else{
		//error message
		$response['message'] ='<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something Went Wrong !!</div>';
		$response['status']=0;
	}
	
	 echo json_encode($response);
}
/*forgetPassword action end*/

?>