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
	
	$dfrom = $_POST['from'];
	$dto = $_POST['to'];
	
	# Format Date to match date in db
	$newfrom = date("Y-m-d", strtotime($dfrom));
	$newto = date("Y-m-d", strtotime($dto));	
	# Format Date to words
	$wfrom = date("M d, Y", strtotime($dfrom));	
	$wto = date("M d, Y", strtotime($dto));
	
		
		$dateMonthYearArr = array();
		$fromDateTS = strtotime($newfrom);
		$toDateTS = strtotime($newto);

			for ($currentDateTS = $fromDateTS; $currentDateTS <= $toDateTS; $currentDateTS += (60 * 60 * 24)) 
			{
				// use date() and $currentDateTS to format the dates in between
				$currentDateStr = date("Y-m-d",$currentDateTS);
				$dateMonthYearArr[] = $currentDateStr;
				//print $currentDateStr."<br />";
				$dd = $currentDateStr;
				$dy = date("N", strtotime($dd));
				$da = date("l", strtotime($dd));
					//echo $dd . ' - ' . $dy . ' - ' . $da . "<br />";
					
				/* INSERT GENERATED schedule to tr_dates */
				$intr = $conn->prepare("INSERT INTO tr_dates (dt_date, dt_day, dt_num, date_added)
							VALUES ('$dd', '$da', '$dy', '$today_date1')");
				$intr->execute();
				
			} // End For
																										
			echo "<center><h3>Processing...</h3><img src='../images/loader/loader_3.gif'><center>";
			$url = "index.php?view=list";
			echo "<meta http-equiv=\"refresh\" content=\"2;URL=$url\">";
		
}

/*
   End Generate schedule
*/
?>
		