<?php
include_once('../include/functions.php');
$db= new functions();
if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'login'){   
	
	$tableName = "store";
	$password=$db->encrypt_decrypt($db->real_sring($_REQUEST['password']),'encrypt');
	if (filter_var($db->real_sring($_REQUEST['username']), FILTER_VALIDATE_EMAIL)) {
		$condition = "email='".$db->real_sring($_REQUEST['username'])."' and password = '".$password."'";
	}else{
		$condition = "username='".$db->real_sring($_REQUEST['username'])."' and password = '".$password."'";
	}
	$run = $db->selectFunction($tableName,$condition);
	if(mysqli_num_rows($run) > 0)
	{
		$row = mysqli_fetch_assoc($run);
		$_SESSION['is_store_logged_in'] = true;
		$_SESSION['store_id'] = $row['store_id'];
		$_SESSION['email'] = $row['email'];

		$db->query("update store set last_login = '".date('Y-m-d H:i:s')."' where store_id = '".$row['store_id']."'");
		
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
	$run = $db->selectFunction($tableName,$condition);
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
        $response['message'] = '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong>Your password has been successfully recovered. Please check your password in register email !!</div>';
		$response['status']=1;
		
	}
	else
	{
		$response['message'] ='<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Username or Email not exists !!</div>';
		$response['status']=0;
		
	}
	 echo json_encode($response);
}
?>