<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
checkUser();

	$userId = $_SESSION['user_id'];	
	
	$customer = $_GET['customer'];
	
	# Get user
	$usr = $conn->prepare("SELECT * FROM bs_user WHERE user_id = '$userId'");
	$usr->execute();
	$usr_data = $usr->fetch();
	$isadmin = $usr_data['is_admin'];
	if($isadmin == 1)
	{
		$statement = '';
	}else{
		$statement = "AND t.user_id = '$userId'";
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
		

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;'
?>		
<head>		
<title>Account Receivables</title>
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
		<div class="row-fluid sortable">		
				<div class="box span6">
					<div class="box-header well" data-original-title>
						<center><table>
						<tr>
							<td><img src="<?php echo WEB_ROOT; ?>images/logo/header_logo.png" /></td>
							<td><h2>Account Receivables Details - <?php echo $cust_label; ?></h2><h4></h4></td>
						</tr>
						</table></center>						
					</div>
					<br />
					<div class="box-content">
						<center><table style="padding:7px; font-size:14px;" width="700" border="0">
						<tr>
							<td class="tdlabel">#</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">Customer</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel" valign="top">
								<table border="0">
								<tr>
									<td class="tdlabel" width="100">Date</td>
									<td width="20px;">&nbsp;</td>
									<td class="tdlabel" width="50">DR #</td>
									<td width="20px;">&nbsp;</td>
									<td class="tdlabel" width="70" style="text-align:right;">Amount</td>
								</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td colspan="5">
								<hr color='black' />
							</td>
						</tr>
								  <tbody>
									<?php
										$emp = $conn->prepare("SELECT *, SUM(total_amt_due) as total_amt FROM tr_transaction t, bs_customer c
													WHERE t.cust_id = c.cust_id AND t.payment_mode = 'DR' AND t.is_deleted != '1' AND t.is_paid != '1'
															$statement $cust_state
																GROUP BY t.cust_id
																	ORDER BY c.client_name, t.od_date");
										$emp->execute();
										
										if($emp->rowCount() > 0)
										{
											$ctr1 = 1; $total = 0;
											while($emp_data = $emp->fetch())
											{
											
												
												$datereleased = date("M d, Y", strtotime($emp_data['od_date']));
												
												$rby = $conn->prepare("SELECT * FROM bs_user WHERE user_id = '$emp_data[user_id]'");
												$rby->execute();
												
												if($rby->rowCount() > 0)
												{ 
													$rby_data = $rby->fetch();
													$released_by = utf8_encode(ucwords(strtolower($rby_data['lastname']))) . ',&nbsp;' . ucwords(strtolower($rby_data['firstname'])); 
												}else{ $released_by = '- -'; }
																							
																																				
												$total += $emp_data['total_amt'];
												// Check if items are for drop off
												$lst = $conn->prepare("SELECT * FROM tr_transaction t
																	WHERE cust_id = '$emp_data[cust_id]' AND t.payment_mode = 'DR' AND t.is_deleted != '1' AND t.is_paid != '1'
																		$statement $cust_state");
												$lst->execute();
												
												
									?>
												<tr>
													<td class="tddata" valign="top"><?php echo $ctr1++; ?>. </td>
													<td width="20px;">&nbsp;</td>
													<td class="tddata" valign="top"><?php echo $emp_data['client_name']; ?></td>													
													<td width="20px;">&nbsp;</td>
													<td class="tddata" valign="top">
														<table border="0">
														<?php 
															
															if($lst->rowCount() > 0)
															{
																$total_amount = 0;
																while($lst_data = $lst->fetch())
																{
																	
																	$odate = date("M d, Y", strtotime($emp_data['od_date']));
																	$total_amount += $emp_data['total_amt_due'];
														?>
																	<tr>
																		<td class="tddata" valign="top" width="100"><?php echo $odate; ?></td>
																		<td width="20px;">&nbsp;</td>
																		<td class="tddata" valign="top" width="50"><?php echo $emp_data['dr']; ?></td>
																		<td width="20px;">&nbsp;</td>
																		<td class="tddata" valign="top" width="70" style="text-align:right;"><?php echo number_format($emp_data['total_amt_due'], 2); ?></td>																	
																	</tr>
														<?php
																} // End While
														?>
																	<tr><td colspan="5" class="tddata" style="text-align:right;"><b><?php echo number_format($total_amount, 2); ?></b><br /><br /></td></tr>
														<?php
															}else{}
														?>
														</table>
													</td>
												</tr>
									<?php
											} // End While
									?>
												<tr>
													<td colspan="5"><hr color='black' /></td>
												</tr>												
												<!--<tr>
													<td colspan="2" align="center"></td>
													<td class="tdlabel">Total</td>
													<td width="20px;"> : </td>
													<td class="tdlabel"><?php echo number_format($total, 2); ?></td>													
												</tr>!-->
												<tr>
													<td colspan="5" align="center">*** Nothing Follows ***</td>
												</tr>
									<?php
										}else{}
									?>
								  </tbody>
						</table>
						<br />
						<table style="padding:7px; font-size:14px;" width="700">
						<tr>
							<td>Prepared by:<br /><br />__________________<br />Jodee Mae B. Buelba</td>
							<td>Checked by:<br /><br />__________________<br />Jumer P. Liza</td>
							<td>Received by:<br /><br />__________________<br />Signature over Printed Name</td>
						</tr>
						</table>
						</center>           
					</div>
				</div><!--/span-->
		</div><!--/row-->