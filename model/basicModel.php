<?php
include_once('../include/functions.php');
$commonFunction= new functions();
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
else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'getChart')
{   $store_id=$_SESSION['store_id'];
	$current_year=$_POST['currentyear'];
	$total_paid_year_array=array();
	$total_due_year_array=array();
	for($i=1;$i<=12;$i++)
	{
		$sel="select SUM(bill_amount) as total_bill_amount from bills where store_id='$store_id' and MONTH(bill_date)='".$i."' and YEAR(bill_date)='".$current_year."' ";
		$query=$commonFunction->query($sel);
		$ro_data=mysqli_fetch_assoc($query);
		$total_amount=0;
		if($ro_data['total_bill_amount'])
	    {
		$total_amount=$ro_data['total_bill_amount'];
		}

		$total_amount=$total_amount;

		$sel_paid="select SUM(paid_amount) as total_paid_amount from bill_item as BT LEFT JOIN bills as B ON B.bill_id=BT.bill_id
		 where B.store_id='$store_id' and MONTH(BT.paid_date)='".$i."' and YEAR(BT.paid_date)='".$current_year."' ";
		$query_paid=$commonFunction->query($sel_paid);
		$ro_data_paid=mysqli_fetch_assoc($query_paid);
		$total_paid_amount=0;
		if($ro_data_paid['total_paid_amount'])
	    {
		$total_paid_amount=$ro_data_paid['total_paid_amount'];
		}

		$dueamout=$total_amount-$total_paid_amount;


		
		$total_paid_year_array[]=$total_paid_amount;
		$total_due_year_array[]=$dueamout;
	}

	
	
	 $response['total_paid_year_array']=$total_paid_year_array;
	 $response['total_due_year_array']=$total_due_year_array;
	 echo json_encode($response);
}
?>