<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
checkUser();

	$userId = $_SESSION['user_id'];	
			
	$dfrom = $_POST['from'];
	$dto = $_POST['to'];
	$top = $_POST['top'];
	$customer = $_POST['customer'];
	$rty = $_POST['rty'];		
	
	# Format Date to match date in db
	$newfrom = date("Y-m-d", strtotime($dfrom));
	$newto = date("Y-m-d", strtotime($dto));	
	# Format Date to words
	$wfrom = date("M d, Y", strtotime($dfrom));	
	$wto = date("M d, Y", strtotime($dto));		

	$dateMonthYearArr = array();
	$fromDateTS = strtotime($newfrom);
	$toDateTS = strtotime($newto);
	
	$del = $conn->prepare("DELETE FROM tr_sales_graph");
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
			
		$ord = $conn->prepare("SELECT *, SUM(total_amt_due) as total_sales FROM tr_transaction WHERE od_date_1 = '$dd' AND cust_id = '$customer' AND is_deleted != '1'");
		$ord->execute();
		$ord_data = $ord->fetch();
		$total_sales = $ord_data['total_sales'];
		$tid = $ord_data['tr_id'];
		
		if($rty == 1)
		{
			$total_data = $total_sales;
		}else{
			$ird = $conn->prepare("SELECT *, SUM(tr_qty) as total_qty FROM tr_transaction_detail WHERE tr_id = '$tid' AND is_deleted != '1'");
			$ird->execute();
			$ird_data = $ird->fetch();
			$total_data = $ird_data['total_qty'];
		}			
		
		$dtname = date("M d, Y", strtotime($dd));
		
		$in = $conn->prepare("INSERT INTO tr_sales_graph (cust_id, date_name, total_sales, od_date) VALUES ('$customer', '$dtname', '$total_data', '$dd')");
		$in->execute();
?>
	<!--<tr>
		<td></?php echo $dd; ?> - </?php echo $total_sales; ?></td>
	</tr>!-->
<?php 
	}
		echo "<center><h3>Processing...</h3><img src='../images/loader/loader_3.gif'><center>";
		$url = "graph.php?b=$top&c=$customer&l=$rty";
		echo "<meta http-equiv=\"refresh\" content=\"1;URL=$url\">";
 ?>
<!--</table>!-->