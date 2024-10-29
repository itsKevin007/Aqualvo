<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
checkUser();
	
	$userId = $_SESSION['user_id'];	
	$us = $conn->prepare("SELECT * FROM bs_user WHERE user_id = '$userId'");
	$us->execute();
	$us_data = $us->fetch();
	$accesslevel = $us_data['access_level'];
	
	$customer = $_POST['customer'];
	$dfrom = $_POST['from'];
	$dto = $_POST['to'];

	# Get user
	$usr = $conn->prepare("SELECT * FROM bs_user WHERE user_id = '$userId'");
	$usr->execute();
	$usr_data = $usr->fetch();
	$isadmin = $usr_data['is_admin'];
	if($isadmin == 1)
	{
		$statement = '';
	}else{
		//$statement = "AND t.user_id = '$userId'";
		$statement = '';
	}
	
	if($customer != 0)
	{
		$cus1 = $conn->prepare("SELECT * FROM bs_customer WHERE cust_id = '$customer'");
		$cus1->execute();
		$cus1_data = $cus1->fetch();
		$cust_state = "AND r.cust_id = '$customer'";
		$cust_label = $cus1_data['client_name'];
	}else{
		$cust_state = "";
		$cust_label = "All";
	}
	
	# Format Date to match date in db
	$newfrom = date("Y-m-d", strtotime($dfrom));
	$newto = date("Y-m-d", strtotime($dto));	
	# Format Date to words
	$wfrom = date("M d, Y", strtotime($dfrom));	
	$wto = date("M d, Y", strtotime($dto));
	
	
$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;'
?>		
<head>		
<title>Emptys Return Report</title>
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
	
						<b>Emptys Return Report - <?php echo $cust_label; ?></b>					
					
					
						<h4><?php echo $wfrom; ?> to <?php echo $wto; ?></h4>
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
							<td colspan="7"><hr color='black' /></td>
						</tr>
								  <tbody>
									<?php
										$emp = $conn->prepare("SELECT *, SUM(round) as total_round, SUM(slim) as total_slim 
													FROM tr_return r, bs_customer c
														WHERE r.cust_id = c.cust_id AND r.is_deleted != '1'
															AND (DATE(r.date_added) BETWEEN '$newfrom' and '$newto') $statement $cust_state
																GROUP BY r.cust_id
																	ORDER BY c.client_name");
										$emp->execute();
										
										if($emp->rowCount() > 0)
										{
											$ctr = 1; $total_r = 0;  $total_s = 0;
											while($emp_data = $emp->fetch())
											{
												
												
												$datereleased = date("M d, Y | h:i a", strtotime($emp_data['date_added']));
												
												$rby = $conn->prepare("SELECT * FROM bs_user WHERE user_id = '$emp_data[added_by]'");
												$rby->execute();
												
												if($rby->rowCount() > 0)
												{ 
													$rby_data = $rby->fetch();
													$released_by = utf8_encode(ucwords(strtolower($rby_data['lastname']))) . ',&nbsp;' . ucwords(strtolower($rby_data['firstname'])); 
												}else{ $released_by = '- -'; }																																				
																								
												
												$total_r += $emp_data['total_round'];
												$total_s += $emp_data['total_slim'];
												
									?>
												<tr>
													<td class="tddata" valign="top"><?php echo $ctr++; ?></td>
													<td width="20px;">&nbsp;</td>
													<td class="tddata" valign="top"><?php echo $emp_data['client_name']; ?></td>
													<td width="20px;">&nbsp;</td>
													<td class="tddata" valign="top"><?php echo $emp_data['total_round']; ?></td>
													<td width="20px;">&nbsp;</td>												
													<td class="tddata" valign="top"><?php echo $emp_data['total_slim']; ?></td>
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
													<td class="tdlabel"><?php echo number_format($total_r, 2); ?></td>
													<td width="20px;">&nbsp;</td>
													<td class="tdlabel"><?php echo number_format($total_s, 2); ?></td>
												</tr>
									<?php
										}else{ $total = 0; }
									?>
								  </tbody>
						</table>