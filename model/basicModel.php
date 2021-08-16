<?php
include_once('../include/functions.php');
$db= new functions();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
/*login action start*/

/*login action end*/
/*get cities action start*/
if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'getCites')
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