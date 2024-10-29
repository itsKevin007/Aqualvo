<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

checkUser();

$action = isset($_GET['action']) ? $_GET['action'] : '';
switch ($action) {	 
        
    case 'delete' :
        delete();
        break;
   
    default :
        // if action is not defined or unknown
        // move to main category page
        header('Location: index.php');
}

/*
    Delete payroll
*/
function delete()
{
	include '../global-library/database.php';
	$userId = $_SESSION['user_id'];

    $pId       = (int)$_GET['id'];	
	  
			/* Update Payroll */
			$sql = $conn->prepare("UPDATE bs_payroll SET is_deleted = '1', date_deleted = NOW()
						WHERE bs_payroll_id = '$pId'");
			$sql->execute();
			/* End Update */
		
		
			/* Insert Log */
			$log = $conn->prepare("INSERT INTO tr_log (action, description, category, action_by, log_action_date)
						VALUES ('Payroll deleted', '$pId', 'delete payroll', '$userId', NOW())");
			$log->execute();
			/* End Log */
		
	
			header("Location: index.php?view=list&error=Deleted successfully");		
}

?>