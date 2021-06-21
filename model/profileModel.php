<?php
include_once('../include/functions.php');
$db= new functions();
if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'login')
{
	
	$run = $db->query("select * from admin where username='".$db->real_sring($_REQUEST['username'])."' and admin_pass = '".$db->real_sring($_REQUEST['password'])."'");
	
	if(mysqli_num_rows($run) > 0)
	{
		$row = mysqli_fetch_assoc($run);
		$_SESSION['is_admin_logged_in'] = true;
		$_SESSION['admin_id'] = $row['admin_id'];
		$_SESSION['admin_email'] = $row['admin_email'];

		$db->query("update admin set admin_last_login = '".date('Y-m-d')."' where admin_id = '".$row['admin_id']."'");
		
		$_SESSION['message'] = '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> Welcome '.$row['admin_name'].'.</div>';
		$response['url']=MAIN_URL.'/dashboard.php';
		$response['status']=1;
	}
	else
	{
		$response['message'] ='<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Username or Password in correct !!</div>';
		
		$response['status']=0;
		
	}
   	
 echo json_encode($response);
}else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'forgetPassword')
{
	$run = $db->query("select * from admin where username='".$db->real_sring($_REQUEST['username'])."'");
	if(mysqli_num_rows($run) > 0)
	{
		$row = mysqli_fetch_assoc($run);
		$newpassword = rand();


		$db->query("update admin set admin_pass = '".$newpassword."' where admin_id = '".$row['admin_id']."'");

		$subject = "New password Notification !!";
					
		$html = '<p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Welcome to '.PROJECT.'!</p>';
		
		$html .= '<p style="margin:0;padding:20px 0px">Hi, '.$row['admin_name'].' !</p>';
		$html .= '<p style="margin:0;padding:20px 0px">We have received your password reset request.</p>';
		$html .= '<p style="margin:0;padding:20px 0px">Your new password is :<strong>' .$newpassword .'</strong></p>';
		
		
		$db->send_mail($row['admin_email'],$subject,$html);

		
		$response['message'] = '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong>Your password reset Successfully. Please check your new password in register email !!</div>';
		$response['status']=1;
		
	}
	else
	{
		$response['message'] ='<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> username not exists !!</div>';
		$response['status']=0;
		
	}
	 echo json_encode($response);
}
?>