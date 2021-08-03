<?php
include_once('../include/functions.php');
$db= new functions();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
/*user data process*/
if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'userData'){ 
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
else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'getTableData')
{  
    $connect = new PDO("mysql:host=localhost;dbname=hisabkitab", "root", ""); 
	$column = array("id", "fname", "lname", "c_number", "cdate");

$query = "SELECT * FROM users ";

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

$statement = $connect->prepare($query);

$statement->execute();

$number_filter_row = $statement->rowCount();

$result = $connect->query($query . $query1);

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

function count_all_data($connect)
{
	$query = "SELECT * FROM users";

	$statement = $connect->prepare($query);

	$statement->execute();

	return $statement->rowCount();
}

$output = array(
	"draw"		=>	intval($_POST["draw"]),
	"recordsTotal"	=>	count_all_data($connect),
	"recordsFiltered"	=>	$number_filter_row,
	"data"	=>	$data
);

echo json_encode($output);
}
/*get table data action end*/
?>