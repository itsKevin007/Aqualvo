<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
checkUser();

	# Format Date/Time
	date_default_timezone_set("Asia/Manila");
	$today_date1 = date("F d, Y");

	$userId = $_SESSION['user_id'];	
	$us = $conn->prepare("SELECT * FROM bs_user WHERE user_id = '$userId'");
	$us->execute();
	$us_data = $us->fetch();
	$accesslevel = $us_data['access_level'];	
	
	$customer = $_POST['customer'];	
	
	if($customer != 0)
	{
		$cus1 = $conn->prepare("SELECT * FROM bs_customer WHERE cust_id = '$customer'");
		$cus1->execute();
		$cus_data = $cus->fetch();
		$cust_state = "AND r.cust_id = '$customer'";
		$cust_label = $cus_data['client_name'];
	}else{
		$cust_state = "";
		$cust_label = "All";
	}
		
	
$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;'
?>		
<head>		
<title>Inventory Report</title>
<link rel="shortcut icon" href="<?php echo WEB_ROOT; ?>images/favicon.ico">
<style rel="stylesheet">
.tdlabel
{   
   color: #000 !important;
   font-family: Arial !important;
   font-weight: bold;
   font-size:14px;
}
.tddata
{   
   color: #000 !important;
   font-family: Arial !important;  
   font-size:13px;
}
</style>
</head>
	
						<b>Inventory Report - <?php echo $cust_label; ?></b>					
					
					
						<h4><?php echo $today_date1; ?></h4>
						<br />							
						<table style="padding:7px;" border="0">
						<tr>
							<td class="tdlabel">#</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">Customer</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">Round</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">Slim</td>							
						<tr>
							<td colspan="7">
								<hr color='black' />
							</td>
						</tr>
								  <tbody>
									<?php
										$emp = $conn->prepare("SELECT * FROM tr_inventory r, bs_customer c
													WHERE r.cust_id = c.cust_id AND r.is_deleted != '1'	$cust_state
																ORDER BY c.client_name");
										$emp->execute();
										
										if($emp->rowCount() > 0)
										{
											$ctr = 1; $total_round = 0; $total_slim = 0;
											while($emp_data = $emp->fetch())
											{
												
																								
												$total_round += $emp_data['round'];
												$total_slim += $emp_data['slim'];
												
									?>
												<tr>
													<td class="tddata" valign="top"><?php echo $ctr++; ?></td>
													<td width="20px;">&nbsp;</td>
													<td class="tddata" valign="top"><?php echo $emp_data['client_name']; ?></td>
													<td width="20px;">&nbsp;</td>
													<td class="tddata" valign="top"><?php echo $emp_data['round']; ?></td>
													<td width="20px;">&nbsp;</td>
													<td class="tddata" valign="top"><?php echo $emp_data['slim']; ?></td>
												</tr>
									<?php
											} // End While
									?>
												<tr>
													<td colspan="7"><hr color='black' /></td>
												</tr>												
												<tr>
													<td colspan="2"></td>
													<td class="tdlabel">Total</td>
													<td width="20px;"> : </td>
													<td class="tdlabel"><?php echo number_format($total_round, 2); ?></td>
													<td width="20px;">&nbsp;</td>
													<td class="tdlabel"><?php echo number_format($total_slim, 2); ?></td>
												</tr>
									<?php
										}else{}
									?>
								  </tbody>
						</table>