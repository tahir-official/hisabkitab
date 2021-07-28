<?php
include_once('../include/functions.php');
$db= new functions();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
/*login action start*/
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
        if($_POST['user_type']==1){
            $modal_title .='Broker';
            $usertype='<input  name="user_type" value="1" class="form-control" type="hidden" >';
        }else{
            $modal_title .='Dealer';
            $usertype='<input  name="user_type" value="2" class="form-control" type="hidden" >';
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
/*login action end*/
/*get cities action start*/
else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'getCites')
{   
	//method check statement
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$tableName = '"cities"';

		$conditions = "state_id='".$_POST['state_id']."'";
		//fetch record statement with Procedures
		$conditions = '"'.$conditions.'"';
		$run = $conn->query("call fetchRecord($tableName,$conditions,'')");
		$conn->next_result();
		if($run->num_rows > 0)
		{
			$citiesRow = $run->fetch_all(MYSQLI_ASSOC);
        
			$option='<option>Select City</option>';
            foreach($citiesRow as $city){
            $option .='<option value="'.$city['id'].'">'.$city['city'].'</option>';
            }

            $response['html'] = $option;
			
		}
		else
		{
			//error message
			$response['html'] ='<option>Select City</option>';
			
			
		}

	}else{
		//error message
		$response['html'] ='<option>Select City</option>';
		
	}
	
	 echo json_encode($response);
}
/*get cities action end*/

?>