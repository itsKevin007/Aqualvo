<?php
require_once 'global-library/config.php';
require_once 'global-library/functions.php';

$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
checkUser();

	$userId = $_SESSION['user_id'];	
			
	date_default_timezone_set("Asia/Manila");
		
	$last_date = date('Y-m-d', strtotime('-6 days'));
	$today_date2 = date("Y-m-d");		

	$dateMonthYearArr = array();
	$fromDateTS = strtotime($last_date);
	$toDateTS = strtotime($today_date2);
	
	$del = $conn->prepare("DELETE FROM tr_graph_gross_current");
	$del->execute();
?>		
<!--<table>!-->
<?php
	for ($currentDateTS = $fromDateTS; $currentDateTS <= $toDateTS; $currentDateTS += (60 * 60 * 24)) 
	{
		// use date() and $currentDateTS to format the dates in between
		$currentDateStr = date("Y-m-d",$currentDateTS);
		$dateMonthYearArr[] = $currentDateStr;
		//print $currentDateStr."<br />";
		$dd = $currentDateStr;
			//echo $dd . "<br />";
			
		$ord = $conn->prepare("SELECT *, SUM(payment) as total_sales FROM tr_transaction WHERE od_date_1 = '$dd' AND is_deleted != '1'");
		$ord->execute();
		$ord_data = $ord->fetch();
		$total_sales = $ord_data['total_sales'];
		
		$dtname = date("M d, Y", strtotime($dd));
		
		$in = $conn->prepare("INSERT INTO tr_graph_gross_current (date_name, total_sales, od_date) VALUES ('$dtname', '$total_sales', '$dd')");
		$in->execute();
?>
	<!--<tr>
		<td></?php echo $dd; ?> - </?php echo $total_sales; ?></td>
	</tr>!-->
<?php 
	}
		include 'gross_sales_graph.php';
 ?>
<!--</table>!-->