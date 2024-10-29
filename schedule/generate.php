<?php
if (!defined('WEB_ROOT')) {
	exit;
}

$action = isset($_GET['action']) ? $_GET['action'] : '';
switch ($action) {
	
    case 'generate' :
        generate();
        break;
		
    default :
        // if action is not defined or unknown
        // move to main category page
        header('Location: index.php');
}

/*
   Start Generate schedule
*/
function generate()
{
	include '../global-library/database.php';
	$userId = $_SESSION['user_id'];	
	
	date_default_timezone_set("Asia/Manila");
	$today_date1 = date("Y-m-d H:i:s");
	$today_date2 = date("Y-m-d");		
	
	$dnum = $_POST['dnum'];	
		
	$dat = $conn->prepare("SELECT * FROM tr_dates WHERE is_deleted != '1' AND dt_num = '$dnum'");
	$dat->execute();
	while($dat_data = $dat->fetch())
	{		
		$d_date = $dat_data['dt_date'];
		$d_day = $dat_data['dt_day'];
		$dt_num = $dat_data['dt_num'];
			if(isset($_POST['customer']))
			{
				foreach($_POST['customer'] as $cust)
				{ 
					$vs = $conn->prepare("INSERT INTO tr_schedule (client_id, dt_date, dt_day, dt_num, date_added) 
								VALUES ('$cust', '$d_date', '$d_day', '$dt_num', NOW())");
					$vs->execute();
					
					//echo $cust . ' - ' . $d_date . ' - ' . $d_day . ' - ' . $dt_num . '<br />';
				}
			}
	} // End While
																										
			echo "<center><h3>Processing...</h3><img src='../images/loader/loader_3.gif'><center>";
			$url = "index.php?view=list&id=$dnum";
			echo "<meta http-equiv=\"refresh\" content=\"2;URL=$url\">";
		
}

/*
   End Generate schedule
*/
?>
		