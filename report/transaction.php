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
	if($accesslevel == 3)
	{ $per = ($us_data['per']) + 11; }
	else
	{ 
		if($_POST['per'] == 0)
		{ $per = $_POST['per']; }else{ $per = $_POST['per'] + 11; }
	}
	
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
		$cust_state = "AND t.cust_id = '$customer'";
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
<title>Transaction Report</title>
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
	
						<b>Transaction Report - <?php echo $cust_label; ?></b>					
					
					
						<h4><?php echo $wfrom; ?> to <?php echo $wto; ?></h4>
						<br />							
						<table style="padding:7px;" border="0">
						<tr>							
							<td class="tdlabel">Item</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">Qty</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">Total</td>							
						<tr>
							<td colspan="5">
								<hr style="border: 0; height: 1px; background-image: -webkit-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,0.75), rgba(0,0,0,0)); background-image: -moz-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,0.75), rgba(0,0,0,0)); background-image: -ms-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,0.75), rgba(0,0,0,0));  background-image: -o-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,0.75), rgba(0,0,0,0)); " />
							</td>
						</tr>
								  <tbody>
									<?php
										$emp = $conn->prepare("SELECT *, SUM(tr_qty) as totalqty, SUM(td.price * td.tr_qty) AS sub_total FROM bs_item i, tr_transaction_detail td, tr_transaction t
													WHERE t.tr_id = td.tr_id AND td.item_id = i.item_id AND t.is_deleted != '1' AND td.is_deleted != '1'
															AND (t.od_date_1 BETWEEN '$newfrom' and '$newto') $statement $cust_state
																GROUP BY td.item_id
																	ORDER BY t.od_date_1, i.name");
										$emp->execute();
										
										if($emp->rowCount() > 0)
										{
											$ctr1 = 1; $total = 0;
											while($emp_data = $emp->fetch())
											{
												
												
												$datereleased = date("M d, Y | h:i a", strtotime($emp_data['od_date']));
												
												$rby = $conn->prepare("SELECT * FROM bs_user WHERE user_id = '$emp_data[user_id]'");
												$rby->execute();
												
												if($rby->rowCount() > 0)
												{ 
													$rby_data = $rby->fetch();
													$released_by = utf8_encode(ucwords(strtolower($rby_data['lastname']))) . ',&nbsp;' . ucwords(strtolower($rby_data['firstname'])); 
												}else{ $released_by = '- -'; }																																				
																								
												if($per != 0)
												{
													$dsc = $per / 100;
													$nsub1 = $sub_total * $dsc;
													$nsub2 = $sub_total - $nsub1;
												}else{
													$nsub2 = $emp_data['sub_total'];
												}												
												$ttqty1 = round($nsub2 / $emp_data['price']);
												$ttqty = number_format(($nsub2 / $emp_data['price']));												
												$nsub3 = $ttqty1 * $emp_data['price'];
												//$sub_total = $totalqty * $price;
												$total += $nsub3;												
												
									?>
												<tr>													
													<td class="tddata" valign="top"><?php echo $emp_data['name']; ?></td>
													<td width="20px;">&nbsp;</td>
													<td class="tddata" valign="top"><?php echo $ttqty; ?></td>
													<td width="20px;">&nbsp;</td>												
													<td class="tddata" valign="top"><?php echo number_format($nsub3, 2); ?></td>													
												</tr>
									<?php
											} // End While
									?>
												<tr>
													<td colspan="5"><hr color='black' /></td>
												</tr>												
												<tr>
													<td colspan="2"></td>
													<td class="tdlabel">Total</td>
													<td width="20px;"> : </td>
													<td class="tdlabel"><?php echo number_format($total, 2); ?></td>													
												</tr>
									<?php
										}else{ $total = 0; }
									?>
								  </tbody>
						</table>