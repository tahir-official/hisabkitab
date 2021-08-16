<?php
include_once('../include/functions.php');
$commonFunction= new functions();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
/*load user popup process start*/
if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'loadPopupUser'){  
	//method check statement
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $stateTable = '"states"';
        $stateRun = $conn->query("call fetchRecord($stateTable,'','')");
        $stateRow = $stateRun->fetch_all(MYSQLI_ASSOC);
        $conn->next_result();

        if($_POST['data_id']==0){
            $modal_title='Add ';
            $sabBtn='Submit';
            $user_id='<input  name="user_id" value="0" class="form-control" type="hidden" >';
            
            
        }else{
            $modal_title='Edit ';
            $sabBtn='Update';
            $user_id='<input  name="user_id" value="'.$_POST['data_id'].'" class="form-control" type="hidden" >';
        }

        $city_id = "'city_id'";
        
		
        $usertype='';
        if($_POST['user_type']=='broker'){
            $modal_title .='Broker';
            $usertype='<input  name="user_type" value="broker" class="form-control" type="hidden" >';
        }else{
            $modal_title .='dealer';
            $usertype='<input  name="user_type" value="dealer" class="form-control" type="hidden" >';
        }
        

        $option='';
        foreach($stateRow as $state){
           $option .='<option value="'.$state['id'].'">'.$state['name'].'</option>';
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
                                            <input id="fname" name="fname" value="" class="form-control" type="text" >
                                        </div>
                                        <div class="form-group pmd-textfield pmd-textfield-floating-label">
                                            <label for="lname">Last Name</label>
                                            <input id="lname" name="lname" value="" class="form-control" type="text" >
                                        </div>
                                        <div class="form-group pmd-textfield pmd-textfield-floating-label">
                                            <label for="email_address">Email Address</label>
                                            <input type="email" id="email_address" name="email_address" class="mat-input form-control"  value="">
                                        </div>
                                        <div class="form-group pmd-textfield pmd-textfield-floating-label">
                                        <label for="c_number">Contact Number</label>
                                        <input type="tel" id="c_number" name="c_number" class="mat-input form-control"  value="">
                                        </div>
                                        <div class="form-group pmd-textfield pmd-textfield-floating-label">
                                        <label for="address">Address</label>
                                        <input type="text" id="address" name="address" class="mat-input form-control"  value="">
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
                                                <option value="">Select City</option>
                                               
                                            </select>
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
        $state_id=$_POST['state_id'];
        $city_id=$_POST['city_id'];
        if($user_id==0){
            $sql = "INSERT INTO users ".
               "(user_type,fname,lname,c_number,email_address,address,city_id,state_id) "."VALUES ".
               "('$user_type','$fname','$lname','$email_address','$c_number','$address','$state_id','$city_id')";
           
            if ($conn->query($sql)) {

               if($user_type==1){
                $response['html'] = '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> Broker Added Successfully !!</div>';
               }else{
                $response['html'] = '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> Dealer Added Successfully !!</div>';
               }
               $response['status'] =1;
            }
            if ($conn->errno) {
                $response['html'] ='<div class="modal-body"><div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something Went Wrong !!</div></div>';
                $response['status'] =0;
            }
        }
    }else{
		//error message
		$response['html'] ='<div class="modal-body"><div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something Went Wrong !!</div></div>';
		$response['status'] =0;
	}
    echo json_encode($response);
}
/*user data process end*/
/*get table data action start*/
else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'getTableDataBroker')
{  
        $table='users';
	    $column = array("id", "fname", "lname", "c_number", "cdate");

        $query = "SELECT * FROM $table ";

        if(isset($_POST["search"]["value"]))
        {
            $query .= '
            WHERE id LIKE "%'.$_POST["search"]["value"].'%" 
            OR fname LIKE "%'.$_POST["search"]["value"].'%" 
            OR lname LIKE "%'.$_POST["search"]["value"].'%" 
            OR c_number LIKE "%'.$_POST["search"]["value"].'%" 
            OR cdate LIKE "%'.$_POST["search"]["value"].'%" 
            ';
        }

        if(isset($_POST["order"]))
        {
            $query .= 'ORDER BY '.$column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
        }
        else
        {
            $query .= 'ORDER BY id DESC ';
        }

        $query1 = '';

        if($_POST["length"] != -1)
        {
            $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
        }

        $statement = $conn->query($query);

        $number_filter_row = $statement->num_rows;
        $result = $conn->query($query . $query1);

        $data = array();

        foreach($result as $row)
        {
            $sub_array = array();
            $sub_array[] = $row['id'];
            $sub_array[] = $row['fname'];
            $sub_array[] = $row['lname'];
            $sub_array[] = $row['c_number'];
            $sub_array[] = $row['email_address'];
            $data[] = $sub_array;
        }

        

        $output = array(
            "draw"		=>	intval($_POST["draw"]),
            "recordsTotal"	=>	$commonFunction->count_all_data($table),
            "recordsFiltered"	=>	$number_filter_row,
            "data"	=>	$data
        );

        echo json_encode($output);
}
/*get table data action end