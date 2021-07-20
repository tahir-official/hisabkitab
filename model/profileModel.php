<?php
include_once('../include/functions.php');

$db= new functions();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
/*login action start*/
if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'login'){  
	//method check statement
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		//username and password check statement
		if($_POST['username'] == NULL && $_POST['password'] == NULL) {
		
			$response['message'] = '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Enter Username or Password !!</div>';
			$response['status'] = 0;
		}else{
			$tableName = '"store"';
			//password encryt statement
			$password = $db->encrypt_decrypt($conn->real_escape_string($_POST['password']),'encrypt');
			//email validation check statement
			if (filter_var($conn->real_escape_string($_POST['username']), FILTER_VALIDATE_EMAIL)) {
				$conditions = "email='".$conn->real_escape_string($_POST['username'])."' and password='".$password."'";
			}else{
				$conditions = "username='".$conn->real_escape_string($_POST['username'])."' and password='".$password."'";
				
			}
			//fetch record statement with Procedures
			$conditions = '"'.$conditions.'"';
			$run = $conn->query("call fetchRecord($tableName,$conditions,'')");
			$conn->next_result();
			if($run->num_rows > 0)
			{
				$row = $run->fetch_assoc();
				$_SESSION['is_store_logged_in'] = true;
				$_SESSION['store_id'] =$store_id= $row['store_id'];
				$_SESSION['email'] = $row['email'];
				//update record statement with Procedures
				 $contents_update= "last_login = '".date('Y-m-d H:i:s')."'";
				 $contents_update='"'.$contents_update.'"';
				 $conditions_update = "store_id='".$store_id."'";
				 $conditions_update='"'.$conditions_update.'"';
				 $conn->query("CALL updateRecord($tableName,$contents_update,$conditions_update)");
				 
				 //insert history record statement with Procedures
				 $conn->query("CALL insertHistory($store_id,'login','This store login !!')");
				 //success message
				 $_SESSION['message'] = '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> Welcome '.$row['name'].'.</div>';
				 $response['url']=MAIN_URL.'/dashboard.php';
				 $response['status']=1;
			}
			else
			{   
				//error message
				$response['message'] ='<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Username or Password in-correct !!</div>';
				$response['status']=0;
				
			}
		}

	}else{
		//error message
		$response['message'] ='<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something Went Wrong !!</div>';
		$response['status']=0;
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
/*update store action start*/
else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'updateStore')
{
	//method check statement
	if ($_SERVER["REQUEST_METHOD"] == "POST") {

		$name=$_POST['store_name'];
		$phone=$_POST['phone'];
		$store_id=$_SESSION['store_id'];
		$tableName = '"store"';
		//update record statement with Procedures
		$contents_update= "name = '".$name."',phone = '".$phone."'";
		$contents_update='"'.$contents_update.'"';
		$conditions_update = "store_id='".$store_id."'";
		$conditions_update='"'.$conditions_update.'"';
		$update=$conn->query("CALL updateRecord($tableName,$contents_update,$conditions_update)");
		$response['name']=$name;
		if($update){
		//insert history record statement with Procedures
		$conn->query("CALL insertHistory($store_id,'Update Profile','This store update detail !!')");
		//success message
		$response['message'] = '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong>Your Profile Update successfully !!</div>';
		$response['status']=1;
		}else{
		//error message
		$response['message'] = '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something went to wrong !!</div>';
		$response['status']=0;
		}

	}else{
        //error message
		$response['message'] ='<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something Went Wrong !!</div>';
		$response['status']=0;
	}
	
	
	echo json_encode($response);

}
/*update store action end*/
/*update password action start*/
else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'changePassword')
{
	
	//method check statement
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$cpassword=$_POST['cpassword'];
		$npassword=$_POST['npassword'];
		$ccpassword=$_POST['ccpassword'];
		$store_id=$_SESSION['store_id'];
		$tableName = '"store"';
		//check new or confirm password
		if($npassword==$ccpassword){
			
			$conditions = "store_id='".$store_id."'";
			$conditions = '"'.$conditions.'"';
		    $run = $conn->query("call fetchRecord($tableName,$conditions,'')");
			$conn->next_result();
			$row = $run->fetch_assoc();
			$password=$db->encrypt_decrypt($row['password'],'decrypt');
			if($password==$cpassword){
				
				$newpassword=$db->encrypt_decrypt($npassword,'encrypt');
				//update record statement with Procedures
				$contents_update= "password = '".$newpassword."'";
				$contents_update='"'.$contents_update.'"';
				$conditions_update = "store_id='".$store_id."'";
				$conditions_update='"'.$conditions_update.'"';
				$update=$conn->query("CALL updateRecord($tableName,$contents_update,$conditions_update)");
				if($update){
			    //insert history record statement with Procedures		
				$conn->query("CALL insertHistory($store_id,'Change Password','This store change password !!')");
				//success message
				$response['message'] = '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong>Your Password Changed successfully !!</div>';
				$response['status']=1;
				}else{
				//error message	
				$response['message'] = '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something went to wrong !!</div>';
				$response['status']=0;
				}
			}else{
				//error message
				$response['message'] = '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Current password is not matched !!</div>';
				$response['status']=0;
			}

		}else{
		//error message
		$response['message'] = '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> The Confirm Password does not match the New Password !!</div>';
		$response['status']=0;
		}

	}else{
		//error message
		$response['message'] ='<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something Went Wrong !!</div>';
		$response['status']=0;
	}
	
    
	
	echo json_encode($response);

}
/*update password action end*/
?>