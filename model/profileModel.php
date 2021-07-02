<?php
include_once('../include/functions.php');
$db= new functions();
if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'login'){   
	
	$tableName = "store";
	$password=$db->encrypt_decrypt($db->real_sring($_REQUEST['password']),'encrypt');
	if (filter_var($db->real_sring($_REQUEST['username']), FILTER_VALIDATE_EMAIL)) {
		$conditions = "email='".$db->real_sring($_REQUEST['username'])."' and password = '".$password."'";
	}else{
		$conditions = "username='".$db->real_sring($_REQUEST['username'])."' and password = '".$password."'";
	}
	$run = $db->fetch_record($tableName,$conditions);
	if(mysqli_num_rows($run) > 0)
	{
		$row = mysqli_fetch_assoc($run);
		$_SESSION['is_store_logged_in'] = true;
		$_SESSION['store_id'] = $row['store_id'];
		$_SESSION['email'] = $row['email'];

		$conditions_update = "store_id='".$row['store_id']."'";
		$content= "last_login = '".date('Y-m-d H:i:s')."'";
		$db->update_record($tableName,$content,$conditions_update);
		$db->insert_history($row['store_id'],'login','This store login');
		$_SESSION['message'] = '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> Welcome '.$row['name'].'.</div>';
		$response['url']=MAIN_URL.'/dashboard.php';
		$response['status']=1;
	}
	else
	{
		$response['message'] ='<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Username or Password in-correct !!</div>';
		$response['status']=0;
		
	}
   	
    echo json_encode($response);
}else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'forgetPassword')
{
	if (filter_var($db->real_sring($_REQUEST['username']), FILTER_VALIDATE_EMAIL)) {
		$condition = "email='".$db->real_sring($_REQUEST['username'])."'";
	}else{
		$condition = "username='".$db->real_sring($_REQUEST['username'])."'";
	}
	$tableName = "store";
	$run = $db->fetch_record($tableName,$condition);
	if(mysqli_num_rows($run) > 0)
	{
		$row = mysqli_fetch_assoc($run);
		$password=$db->encrypt_decrypt($row['password'],'decrypt');

        $subject = "Password Notification !!";
		$html = '<p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Welcome to '.PROJECT.'!</p>';
		$html .= '<p style="margin:0;padding:20px 0px">Hi, '.$row['name'].' !</p>';
		$html .= '<p style="margin:0;padding:20px 0px">We have received your password recover request.</p>';
		$html .= '<p style="margin:0;padding:20px 0px">This is your password :<strong>' .$password .'</strong></p>';
		$db->send_mail($row['email'],$subject,$html);
		$db->insert_history($row['store_id'],'Password recover','This store recovered password');
        $response['message'] = '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong>Your password has been successfully recovered. Please check your password in register email !!</div>';
		$response['status']=1;
		
	}
	else
	{
		$response['message'] ='<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Username or Email not exists !!</div>';
		$response['status']=0;
		
	}
	 echo json_encode($response);
}else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'updateStore')
{
	
	$name=$_REQUEST['store_name'];
	$phone=$_REQUEST['phone'];
	$store_id=$_SESSION['store_id'];
	$tableName='store';
    $conditions_update = "store_id='".$store_id."'";
	$content= "name = '".$name."',phone = '".$phone."' ";
	$update= $db->update_record($tableName,$content,$conditions_update);
	$response['name']=$name;
	if($update){
	$db->insert_history($store_id,'Update Profile','This store update detail');
	$response['message'] = '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong>Your Profile Update successfully !!</div>';
	$response['status']=1;
	}else{
	$response['message'] = '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something went to wrong !!</div>';
	$response['status']=0;
	}
	
	echo json_encode($response);

}else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'changePassword')
{
	
	$cpassword=$_REQUEST['cpassword'];
	$npassword=$_REQUEST['npassword'];
	$ccpassword=$_REQUEST['ccpassword'];
	$store_id=$_SESSION['store_id'];
	$tableName='store';
	if($npassword==$ccpassword){
		$condition = "store_id='".$store_id."'";
		$run = $db->fetch_record($tableName,$condition);
		$row = mysqli_fetch_assoc($run);
		$password=$db->encrypt_decrypt($row['password'],'decrypt');
		if($password==$cpassword){
			$newpassword=$db->encrypt_decrypt($npassword,'encrypt');
			$conditions_update = "store_id='".$store_id."'";
			$content= "password = '".$newpassword."'";
			$update= $db->update_record($tableName,$content,$conditions_update);
			if($update){
			$db->insert_history($store_id,'Change Password','This store change password');
			$response['message'] = '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong>Your Password Changed successfully !!</div>';
			$response['status']=1;
			}else{
			$response['message'] = '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something went to wrong !!</div>';
			$response['status']=0;
			}
		}else{
			$response['message'] = '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Current password is not matched !!</div>';
	         $response['status']=0;
		}

	}else{
	$response['message'] = '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> The Confirm Password does not match the New Password !!</div>';
	$response['status']=0;
	}
    
	
	echo json_encode($response);

}
?>