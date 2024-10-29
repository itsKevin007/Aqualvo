<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

checkUser();

$action = isset($_GET['action']) ? $_GET['action'] : '';
switch ($action) {	 
        
    case 'returns' :
        returns();
        break;
   
    default :
        // if action is not defined or unknown
        // move to main category page
        header('Location: index.php');
}

/*
    Return
*/
function returns()
{
	include '../global-library/database.php';
	$userId = $_SESSION['user_id'];
	
	date_default_timezone_set("Asia/Manila");
	$today_date1 = date("Y-m-d H:i:s");
	$today_date2 = date("Y-m-d");

    $cid = $_POST['cid'];
	$tid = $_POST['tid'];
	$emptys = $_POST['emptys'];
	
	
			/* Insert */
			if($tid == 1)
			{
				$sql = $conn->prepare("INSERT INTO tr_return (cust_id, round, added_by, date_added)
							VALUES ('$cid', '$emptys', '$userId', '$today_date1')");
				$sql->execute();
			}else{
				$sql1 = $conn->prepare("INSERT INTO tr_return (cust_id, slim, added_by, date_added)
							VALUES ('$cid', '$emptys', '$userId', '$today_date1')");
				$sql1->execute();
			}
			/* End Insert */
			
			/*$gt = "SELECT * FROM tr_inventory WHERE cust_id = '$cid'";
			$rs_gt = dbQuery($gt);
			$rw_gt = dbFetchAssoc($rs_gt);
			$upemt = $rw_gt[$ty];
			$newemt = $upemt - $empty*/
			
			/* Update Inventory */
			if($tid == 1)
			{
				$up = $conn->prepare("UPDATE tr_inventory SET round = (round - '$emptys')
							WHERE cust_id = '$cid'");
				$up->execute();
			}else{
				$up1 = $conn->prepare("UPDATE tr_inventory SET slim = (slim - '$emptys')
							WHERE cust_id = '$cid'");
				$up1->execute();
			}
			/* End Update */
		
		
			/* Insert Log */
			$log = $conn->prepare("INSERT INTO tr_log (action, description, category, action_by, log_action_date)
						VALUES ('Return added', '$cid', 'add return', '$userId', '$today_date1')");
			$log->execute();
			/* End Log */
		
	
			header("Location: index.php?view=list&error=Saved successfully");		
}

?>