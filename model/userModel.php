<?php
include_once('../include/functions.php');
$commonFunction= new functions();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
/*get broker table data action start*/
if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'getTableDataBroker')
{  
        $store_id= $_SESSION['store_id'];
        $tableName='users';
	    $column = array("user_type", "fname","email_address", "c_number","address","city_id","state_id","status","cdate");

        $query = "SELECT U.id,U.user_type,U.fname,U.lname,U.email_address,U.c_number,U.address,U.city_id,U.state_id,U.status,U.store_id,U.cdate,C.city,S.name FROM $tableName as U INNER JOIN cities as C
        ON U.city_id = C.id INNER JOIN states AS S ON U.state_id = S.id ";
        if(isset($_POST["search"]["value"]))
        {
            $query .= '
            WHERE U.fname LIKE "%'.$_POST["search"]["value"].'%" 
            OR U.lname LIKE "%'.$_POST["search"]["value"].'%" 
            OR U.email_address LIKE "%'.$_POST["search"]["value"].'%" 
            OR U.c_number LIKE "%'.$_POST["search"]["value"].'%" 
            OR U.address LIKE "%'.$_POST["search"]["value"].'%"
            OR C.city LIKE "%'.$_POST["search"]["value"].'%"
            OR S.name LIKE "%'.$_POST["search"]["value"].'%"
            OR U.cdate LIKE "%'.$_POST["search"]["value"].'%"
            ';
        }
        $main_query="SELECT * FROM ($query) as X WHERE X.store_id=$store_id and X.user_type='broker'";
        if(isset($_POST["order"]))
        {
            $main_query .= ' ORDER BY '.'X.'.$column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
        }
        else
        {
            $main_query .= ' ORDER BY X.id DESC ';
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
            $sub_array[] = $row['fname'].' '.$row['lname'];
            $sub_array[] = $row['email_address'];
            $sub_array[] = $row['c_number'];
            $sub_array[] = $row['address'];
            $sub_array[] = $row['city'];
            $sub_array[] = $row['name'];
            if($row['status']==0){
                $changeStatus="return changeUserStatus('".$row['id']."',1,'broker','".MAIN_URL."/model/userModel.php?action=getTableDataBroker')";
                $status='<a class="stbtn" href="javascript:void(0)" onClick="'.$changeStatus.'"><label style="color: white;cursor: pointer;" class="badge badge-success">Active</label></a>';
            }else{
                $changeStatus="return changeUserStatus('".$row['id']."',0,'broker','".MAIN_URL."/model/userModel.php?action=getTableDataBroker')";
                $status='<a class="stbtn" href="javascript:void(0)" onClick="'.$changeStatus.'"><label style="color: white;cursor: pointer;" class="badge badge-danger">Deactive</label></a>';
            }
            $sub_array[] = $status;
            $sub_array[] = $commonFunction->dateFormat($row['cdate']);
            $loadPopupUser="loadPopupUser('broker','".$row['id']."')";
            $sub_array[] = '<a href="javascript:void(0)" onClick="'.$loadPopupUser.'"><label style="color: white; cursor: pointer;" class="badge badge-danger">Edit</label></a>';
            $data[] = $sub_array;
            $i++;
        }

        /*this code for all records*/
        $query_all = "SELECT * FROM $tableName where user_type = 'broker' and store_id  = $store_id ";
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
/*get broker table data action end*/
/*get dealer table data action start*/
else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'getTableDataDealer')
{  
        $store_id= $_SESSION['store_id'];
        $tableName='users';
	    $column = array("user_type", "fname","email_address", "c_number","address","city_id","state_id","status","cdate");

        $query = "SELECT U.id,U.user_type,U.fname,U.lname,U.email_address,U.c_number,
        U.address,U.city_id,U.state_id,U.status,U.store_id,U.broker_id,U.cdate,C.city,S.name,U2.fname as bfname,U2.lname as blname FROM $tableName as U INNER JOIN cities as C
        ON U.city_id = C.id INNER JOIN states AS S ON U.state_id = S.id LEFT JOIN $tableName AS U2 ON U.broker_id = U2.id ";
        if(isset($_POST["search"]["value"]))
        {
            $query .= '
            WHERE U.fname LIKE "%'.$_POST["search"]["value"].'%" 
            OR U.lname LIKE "%'.$_POST["search"]["value"].'%" 
            OR U.email_address LIKE "%'.$_POST["search"]["value"].'%" 
            OR U.c_number LIKE "%'.$_POST["search"]["value"].'%" 
            OR U.address LIKE "%'.$_POST["search"]["value"].'%"
            OR C.city LIKE "%'.$_POST["search"]["value"].'%"
            OR S.name LIKE "%'.$_POST["search"]["value"].'%"
            OR U.cdate LIKE "%'.$_POST["search"]["value"].'%"
            OR U2.fname LIKE "%'.$_POST["search"]["value"].'%"
            OR U2.lname LIKE "%'.$_POST["search"]["value"].'%"
            
            ';
        }
        
        $main_query="SELECT * FROM ($query) as X WHERE X.store_id=$store_id and X.user_type='dealer'";
        if(isset($_POST["order"]))
        {
            $main_query .= ' ORDER BY '.'X.'.$column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
        }
        else
        {
            $main_query .= ' ORDER BY X.id DESC ';
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
            $sub_array[] = $row['fname'].' '.$row['lname'];
            $sub_array[] = $row['email_address'];
            $sub_array[] = $row['c_number'];
            $sub_array[] = $row['address'];
            $sub_array[] = $row['city'];
            $sub_array[] = $row['name'];
            $sub_array[] = $row['bfname'].' '.$row['blname'];
            if($row['status']==0){
                $changeStatus="return changeUserStatus('".$row['id']."',1,'dealer','".MAIN_URL."/model/userModel.php?action=getTableDataDealer')";
                $status='<a class="stbtn" href="javascript:void(0)" onClick="'.$changeStatus.'"><label style="color: white;cursor: pointer;" class="badge badge-success">Active</label></a>';
            }else{
                $changeStatus="return changeUserStatus('".$row['id']."',0,'dealer','".MAIN_URL."/model/userModel.php?action=getTableDataDealer')";
                $status='<a class="stbtn" href="javascript:void(0)" onClick="'.$changeStatus.'"><label style="color: white;cursor: pointer;" class="badge badge-danger">Deactive</label></a>';
            }
            $sub_array[] = $status;
            $sub_array[] = $commonFunction->dateFormat($row['cdate']);
            $loadPopupUser="loadPopupUser('dealer','".$row['id']."')";
            $sub_array[] = '<a href="javascript:void(0)" onClick="'.$loadPopupUser.'"><label style="color: white; cursor: pointer;" class="badge badge-danger">Edit</label></a>';
            $data[] = $sub_array;
            $i++;
        }

        /*this code for all records*/
        $query_all = "SELECT * FROM $tableName where user_type = 'dealer' and store_id  = $store_id ";
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
/*get dealer table data action end*/
/*load user popup process start*/
else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'loadPopupUser'){  
	//method check statement
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $stateTable = '"states"';
        $stateRun = $conn->query("call fetchRecord($stateTable,'','')");
        $stateRow = $stateRun->fetch_all(MYSQLI_ASSOC);
        $conn->next_result();
        $option='';
        if($_POST['data_id']==0){
            $modal_title='Add ';
            $sabBtn='Submit';
            $user_id='<input  name="user_id" value="0" class="form-control" type="hidden" >';
            $fname='';
            $lname='';
            $email_address='';
            $c_number='';
            $address='';
            foreach($stateRow as $state){
                $option .='<option value="'.$state['id'].'">'.$state['name'].'</option>';
            }
            $cities='<option value="">Select City</option>';
            
        }else{
            $modal_title='Edit ';
            $sabBtn='Update';
            $user_id='<input  name="user_id" value="'.$_POST['data_id'].'" class="form-control" type="hidden" >';

            $usertable = '"users"';
            $userconditions = "id='".$_POST['data_id']."'";
            $userconditions = '"'.$userconditions.'"';
            $userRun = $conn->query("call fetchRecord($usertable,$userconditions,'')");
            $userData = $userRun->fetch_assoc();
            $conn->next_result();
            $fname=$userData['fname'];
            $lname=$userData['lname'];
            $email_address=$userData['email_address'];
            $c_number=$userData['c_number'];
            $address=$userData['address'];
            foreach($stateRow as $state){
                $selectstate='';
                if($state['id']==$userData['state_id']){$selectstate='selected';}
                $option .='<option '.$selectstate.' value="'.$state['id'].'">'.$state['name'].'</option>';
             }

            $cityTable = '"cities"';
            $cityconditions = "state_id='".$userData['state_id']."'";
            $cityconditions = '"'.$cityconditions.'"';
            $cityrun = $conn->query("call fetchRecord($cityTable,$cityconditions,'')");
            $citiesRow = $cityrun->fetch_all(MYSQLI_ASSOC);
            $conn->next_result();
            $cities='<option>Select City</option>';
            foreach($citiesRow as $city){
            $selectcity='';    
            if($city['id']==$userData['city_id']){$selectcity='selected';}   
            $cities .='<option '.$selectcity.' value="'.$city['id'].'">'.$city['city'].'</option>';
            }


            

        }

        $city_id = "'city_id'";
        
		
        $usertype='';
        if($_POST['user_type']=='broker'){
            $modal_title .='Broker';
            $usertype='<input  name="user_type" value="broker" class="form-control" type="hidden" >';
            $brokeroption='';
        }else{
            $modal_title .='Dealer';
            $usertype='<input  name="user_type" value="dealer" class="form-control" type="hidden" >';

            $brokerTable = '"users"';
            $brokerconditions = "user_type='broker' and store_id='".$_SESSION['store_id']."'";
            $brokerconditions = '"'.$brokerconditions.'"';
            $brokerrun = $conn->query("call fetchRecord($brokerTable,$brokerconditions,'')");
            $brokerRow = $brokerrun->fetch_all(MYSQLI_ASSOC);
            $brokerdropdwon='<option value="0">Select broker</option>';
            foreach($brokerRow as $broker){
            $selectbroker=''; 
            if($_POST['data_id']!=0){
                if($broker['id']==$userData['broker_id']){$selectbroker='selected';} 
            }   
            $brokerdropdwon .='<option '.$selectbroker.' value="'.$broker['id'].'">'.$broker['fname'].' '.$broker['lname'].'</option>';
            }

            $brokeroption='<div class="form-group pmd-textfield pmd-textfield-floating-label">
                <label for="broker_id">Select Broker</label>
                <select id="broker_id" name="broker_id" class="form-control">
                    '.$brokerdropdwon.'
                </select>
            </div>';

        }
        

        
        
        $response['html'] ='<div class="modal-header pmd-modal-border">
                                    <h3 class="modal-title">'.$modal_title.'</h3>
                                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                                </div>
                                <div id="popupalert"></div>
                                <form id="userForm" method="post">
                                <div class="modal-body">
                                       '.$usertype.$user_id.'
                                        <div class="form-group pmd-textfield pmd-textfield-floating-label">
                                            <label for="fname">First Name</label>
                                            <input id="fname" name="fname" value="'.$fname.'" class="form-control" type="text" >
                                        </div>
                                        <div class="form-group pmd-textfield pmd-textfield-floating-label">
                                            <label for="lname">Last Name</label>
                                            <input id="lname" name="lname" value="'.$lname.'" class="form-control" type="text" >
                                        </div>
                                        <div class="form-group pmd-textfield pmd-textfield-floating-label">
                                            <label for="email_address">Email Address</label>
                                            <input type="email" id="email_address" name="email_address" class="mat-input form-control"  value="'.$email_address.'">
                                        </div>
                                        <div class="form-group pmd-textfield pmd-textfield-floating-label">
                                        <label for="c_number">Contact Number</label>
                                        <input type="tel" id="c_number" name="c_number" class="mat-input form-control"  value="'.$c_number.'">
                                        </div>
                                        <div class="form-group pmd-textfield pmd-textfield-floating-label">
                                        <label for="address">Address</label>
                                        <input type="text" id="address" name="address" class="mat-input form-control"  value="'.$address.'">
                                        </div>
                                        <div class="form-group pmd-textfield pmd-textfield-floating-label">
                                            <label for="state_id">State</label>
                                            <select id="state_id" name="state_id" class="form-control" onchange="return loadCity(this.value,'.$city_id.')">
                                                <option value="">Select State</option>
                                                '.$option.'
                                            </select>
                                        </div>
                                        <div class="form-group pmd-textfield pmd-textfield-floating-label">
                                            <label for="city_id">City</label>
                                            <select id="city_id" name="city_id" class="form-control">
                                                 '.$cities.'
                                            </select>
                                        </div>
                                        '.$brokeroption.'
                                     
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

/*user data process*/
else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'userData'){ 
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $user_type=$_POST['user_type'];
        $user_id=$_POST['user_id'];
        $fname=$_POST['fname'];
        $lname=$_POST['lname'];
        $email_address=$_POST['email_address'];
        $c_number=$_POST['c_number'];
        $address=$_POST['address'];
        $city_id=$_POST['city_id'];
        $state_id=$_POST['state_id'];
        $store_id=$_SESSION['store_id'];
        
        if($user_id==0){

            $userstable = '"users"';
            $usersconditions = "email_address='".$_POST['email_address']."' and user_type='".$user_type."'  and store_id='".$store_id."' ";
            $usersconditions = '"'.$usersconditions.'"';
            $usersRun = $conn->query("call fetchRecord($userstable,$usersconditions,'')");
            $conn->next_result();
            if($usersRun->num_rows <= 0)
		    {
                
                $userstable2 = '"users"';
                $usersconditions2 = "c_number='".$_POST['c_number']."'  and user_type='".$user_type."' and store_id='".$store_id."'";
                $usersconditions2 = '"'.$usersconditions2.'"';
                $usersRun2 = $conn->query("call fetchRecord($userstable2,$usersconditions2,'')");
                $conn->next_result();
                if($usersRun2->num_rows <= 0)
		        {
                    
                    
                    
                        if($user_type=='broker'){
                            $sql = "INSERT INTO users ".
                            "(user_type,fname,lname,c_number,email_address,address,city_id,state_id,store_id) "."VALUES ".
                            "('$user_type','$fname','$lname','$c_number','$email_address','$address','$city_id','$state_id','$store_id')";
                        }else{
                            $broker_id=$_POST['broker_id'];
                            $sql = "INSERT INTO users ".
                            "(user_type,fname,lname,c_number,email_address,address,city_id,state_id,store_id,broker_id) "."VALUES ".
                            "('$user_type','$fname','$lname','$c_number','$email_address','$address','$city_id','$state_id','$store_id','$broker_id')";
                        }
                    
                
                        if ($conn->query($sql)) {

                        if($user_type=='broker'){
                            $response['message'] = '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> Broker Added Successfully !!</div>';
                            $response['fetchTableurl'] =MAIN_URL.'/model/userModel.php?action=getTableDataBroker';
                        }else{
                            $response['message'] = '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> Dealer Added Successfully !!</div>';
                            $response['fetchTableurl'] =MAIN_URL.'/model/userModel.php?action=getTableDataDealer';
                        }
                        $response['status'] =1;
                        
                        }
                        if ($conn->errno) {
                            $response['message'] ='<div class="modal-body"><div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something Went Wrong !!</div></div>';
                            $response['status'] =0;
                        }
                }else{
                    $response['message'] ='<div class="modal-body"><div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Phone Number already exists !!</div></div>';
                    $response['status'] =0;
                }
                
            }else{
                $response['message'] ='<div class="modal-body"><div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Email address already exists !!</div></div>';
                $response['status'] =0;
            }


            
        }else{

            $userstable = '"users"';
            $usersconditions = "email_address='".$_POST['email_address']."' and user_type='".$user_type."' and store_id='".$store_id."' and id != '".$user_id."' ";
            $usersconditions = '"'.$usersconditions.'"';
            $usersRun = $conn->query("call fetchRecord($userstable,$usersconditions,'')");
            $conn->next_result();
            if($usersRun->num_rows <= 0)
		    {
                
                $userstable2 = '"users"';
                $usersconditions2 = "c_number='".$_POST['c_number']."'  and user_type='".$user_type."' and store_id='".$store_id."' and id != '".$user_id."'";
                $usersconditions2 = '"'.$usersconditions2.'"';
                $usersRun2 = $conn->query("call fetchRecord($userstable2,$usersconditions2,'')");
                $conn->next_result();
                if($usersRun2->num_rows <= 0)
		        {
                        $other_update="";
                        if($user_type=='dealer'){
                        $broker_id=$_POST['broker_id'];
                        $other_update=",broker_id='".$broker_id."'";
                        }
                        $sql = "UPDATE users SET fname='".$fname."',lname='".$lname."',c_number='".$c_number."',email_address='".$email_address."',
                          address='".$address."',city_id='".$city_id."',state_id='".$state_id."' $other_update WHERE id='".$user_id."'";
                
                        if ($conn->query($sql)) {

                        if($user_type=='broker'){
                            $response['message'] = '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> Broker Updated Successfully !!</div>';
                            $response['fetchTableurl'] =MAIN_URL.'/model/userModel.php?action=getTableDataBroker';
                        }else{
                            $response['message'] = '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> Dealer Updated Successfully !!</div>';
                            $response['fetchTableurl'] =MAIN_URL.'/model/userModel.php?action=getTableDataDealer';
                        }
                        $response['status'] =1;
                        
                        }
                        if ($conn->errno) {
                            $response['message'] ='<div class="modal-body"><div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something Went Wrong !!</div></div>';
                            $response['status'] =0;
                        }
                }else{
                    $response['message'] ='<div class="modal-body"><div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Phone Number already exists !!</div></div>';
                    $response['status'] =0;
                }
                
            }else{
                $response['message'] ='<div class="modal-body"><div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Email address already exists !!</div></div>';
                $response['status'] =0;
            }

        }
    }else{
		//error message
		$response['message'] ='<div class="modal-body"><div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something Went Wrong !!</div></div>';
		$response['status'] =0;
	}
    echo json_encode($response);
}
/*user data process end*/
else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'changeUserStatus'){ 
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $user_id=$_POST['user_id'];
        $status=$_POST['status'];
        $user_type=$_POST['user_type'];

        $sql = "UPDATE users SET status='".$status."' WHERE id='".$user_id."'";

        if ($conn->query($sql)) {
        if($status==1){
            $alertstatus='Deactivated';
        }else{
            $alertstatus='Activated';
        }    

        if($user_type=='broker'){
            $response['message'] = '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> Broker '.$alertstatus.' Successfully !!</div>';
        }else{
            $response['message'] = '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> Dealer '.$alertstatus.' Successfully !!</div>';
        }
        $response['status'] =1;
        
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
