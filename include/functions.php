<?php
include_once('config.php');
class Functions
{
	
   /*basic function*/
   function __construct()
	{ 
		$this->con=mysqli_connect(DbHost, DbUser, DbPass, DbName) or die('Could not connect: ' . mysqli_connect_error());
	}
	function query($q)
	{
		$sqlquery = mysqli_query($this->con,$q);
		return $sqlquery;
	}
	function insert_id()
	{
		$id = mysqli_insert_id($this->con);
		return $id;
	}
	function real_sring($q)
	{
		$string = mysqli_real_escape_string($this->con, $q);
		return $string;
	}
	function redirect($location)
	{ 
		echo '<script>window.location.href="'.$location.'"</script>';
		die(); 
	}
	function getAdminData($id)
	{
		$data = false;
		$sql = "select * from admin where admin_id = '".$id."'";
		$run = $this->query($sql);
		if(mysqli_num_rows($run) > 0)
		{
			$data = mysqli_fetch_assoc($run);
		}
		return $data;
	}


   /*basic function*/
   

    /*Email function*/                            
	function send_mail($to,$subject,$contant){ 
   		$from = EMAIL;
   		$headers ="From:  ".PROJECT.' '.$from."\n";
   		$headers .= "MIME-Version: 1.0\n";
   		$headers .= "Content-type: text/html; charset=iso-8859-1 \n";
             
   		$txt  = '<body style="margin:0px;">
   					<table style="background-color:#f8f8f8;border-collapse:collapse!important;width:100%;border-spacing:0" width="100%" bgcolor="#f8f8f8"> 
   						<tbody>    
   							<tr>     
   								<td style="border-collapse:collapse;font-family:Helvetica Neue,Helvetica,Arial,Lucida Grande,sans-serif;font-size:14px;vertical-align:top;padding:0" valign="top">  
   								</td>       
   								<td  style="border-collapse:collapse;font-family:Helvetica Neue,Helvetica,Arial,Lucida Grande,sans-serif;font-size:14px;vertical-align:top;background:#ffffff;display:block;margin:0 auto!important;max-width:600px;width:600px;padding:0" width="600" valign="top">
   									<div style="display:block;margin:0 auto;max-width:600px;padding:0;background:#ffffff">  
   										<div>  
   											<table style="border-collapse:collapse!important;width:100%;border-spacing:0" width="100%">       
   												<tbody>        
   													<tr>        
   														<td style="border-collapse:collapse;font-family:Helvetica Neue,Helvetica,Arial,Lucida Grande,sans-serif;font-size:14px;vertical-align:top;padding:10px 0 10px 0;color:#ffffff;margin-top:20px;width:100%;border-bottom:none;background-color:#f8f8f8;margin-bottom:30px" width="100%" valign="top" bgcolor="#f8f8f8">     
   															<table style="border-collapse:collapse!important;width:100%;border-spacing:0" width="100%">      
   																<tbody>    
   																	<tr>       
   																		<td style="border-collapse:collapse;font-family:Helvetica Neue,Helvetica,Arial,Lucida Grande,sans-serif;font-size:14px;vertical-align:top;padding:0;color:#000000" valign="top" align="left">  
   																			<img src="'.MAIN_URL.'/assets/images/logo.svg" style="max-width:100%;width:160px;margin:5px 0 0 0" width="140">
   																		</td>   
   																		<td style="border-collapse:collapse;font-family:Helvetica Neue,Helvetica,Arial,Lucida Grande,sans-serif;font-size:14px;vertical-align:top;padding:0;color:#000000" valign="top" align="right">
   																		</td>        
   																	</tr>   
   																</tbody>     
   															</table>   
   														</td>   
   													</tr>        
   													<tr>        
   														<td style="border-collapse:collapse;font-family:Helvetica Neue,Helvetica,Arial,Lucida Grande,sans-serif;font-size:14px;vertical-align:top;padding:0" valign="top"> 
   															<table style="color:#000;text-align:center;border-collapse:collapse!important;width:100%;border-spacing:0" width="100%" align="center">
   																<tbody> 
   																	<tr>        
   																		<td style="border-collapse:collapse;font-family:Helvetica Neue,Helvetica,Arial,Lucida Grande,sans-serif;font-size:14px;vertical-align:top;padding:30px 0 0" width="600" valign="top" height="40" bgcolor="#fff"> 
   																			<div> 
   																			</div>      
   																		</td>      
   																	</tr>     
   																</tbody> 
   															</table>      
   															<table style="border-collapse:collapse!important;width:100%;border-spacing:0" width="100%"> 
   																<tbody>   
   																	<tr>
   																		<td style="border-collapse:collapse;font-family:Helvetica Neue,Helvetica,Arial,Lucida Grande,sans-serif;font-size:14px;vertical-align:top;padding:30px" valign="top">
   																			'.$contant.'<br><br>
   																			<h4>Thank You!</h4>
   																			<h3>'.PROJECT.'</h3>
   																		</td>
   																	</tr>
   																</tbody>          
   															</table>
   															<table style="margin-bottom:20px;border-collapse:collapse!important;width:100%;border-spacing:0" width="100%"> 
   																<tbody></tbody>          
   															</table>         
   														</td>       
   													</tr> 
   												</tbody>          
   											</table> 
   										</div>         
   										<table style="border-collapse:collapse!important;width:100%;border-spacing:0" width="100%">  
   											<tbody>      
   												        
   											</tbody>          
   										</table>         
   									</div>         
   								</td>     
   								<td style="border-collapse:collapse;font-family:Helvetica Neue,Helvetica,Arial,Lucida Grande,sans-serif;font-size:14px;vertical-align:top;padding:0" valign="top"></td>         
   							</tr>   
   						</tbody>        
   					</table>    
   				</body>';
         if(mail($to,$subject,$txt,$headers))
         {
   		 return true; 
   	  }else
        {
   		   return false; 
   	  }
   		
   	}
}

?>