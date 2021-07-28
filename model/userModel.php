<?php
include_once('../include/functions.php');
$db= new functions();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
/*user data process*/
if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'userData'){ 
}
/*user data process end*/

?>