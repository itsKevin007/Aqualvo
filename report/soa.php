<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
checkUser();

	$userId = $_SESSION['user_id'];	
	
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
	
	/* Generate SOA */
		$dt1 = date("md", strtotime($dfrom));
		$dt2 = date("md", strtotime($dto));
		$dt3 = date("y", strtotime($dto));
		
		$soanum = $customer . '-' . $dt1 . $dt2 . $dt3;
	/* End SOA */
	
	$blf = $conn->prepare("SELECT *, SUM(total_amt_due) as total_blf FROM bs_item i, tr_transaction_detail td, tr_transaction t 
				WHERE t.tr_id = td.tr_id AND td.item_id = i.item_id AND t.is_deleted != '1' AND t.is_paid != '1' AND t.od_date_1 < '$newfrom' $cust_state");
	$blf->execute();
	
	

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;'
?>		
<head>		
<title>Statement of Account</title>
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
						<td>
							<h2>Statement of Account - <?php echo $cust_label; ?></h2>
							<h4><?php echo $wfrom; ?> to <?php echo $wto; ?></h4>
							<b style="font-size:13px; margin-left:70px;">SOA #: <?php echo $soanum; ?></b>
						</td>
					</tr>
					</table></center>						
				</div>
				<br />
				<div class="box-content">
					<center><table style="padding:7px; font-size:14px;" width="700" border="0">						
					<tr>
						<td colspan="11">
							<hr color='black' />
						</td>
					</tr>
					<tr>
						<td class="tdlabel">#</td>
						<td width="20px;">&nbsp;</td>
						<td class="tdlabel">Date</td>
						<td width="20px;">&nbsp;</td>
						<td class="tdlabel">DR/<font color="red">OR</font> #</td>
						<td width="20px;">&nbsp;</td>							
						<td class="tdlabel">Qty</td>
						<td width="20px;">&nbsp;</td>
						<td class="tdlabel">Price</td>
						<td width="20px;">&nbsp;</td>
						<td class="tdlabel">Amount</td>							
					</tr>
					<tr>
						<td colspan="11">
							<hr color='black' />
						</td>
					</tr>
							  <tbody>
								<?php
									if($blf->rowCount() > 0)
									{
										$lastday = date('Y-m-d', strtotime('-1 day', strtotime($newfrom)));
										$ld = date("M d, Y", strtotime($lastday));
										$blf_data = $blf->fetch();
								?>
										<tr><td colspan="11"><b>Balance Forwarded:</b></td></tr>
										<tr>
											<td></td><td></td>
											<td><b><?php echo $ld; ?></b></td>
											<td></td>
											<td colspan="6"></td>
											<td><b><?php echo number_format($blf_data['total_blf'], 2); ?></b></td>
										</tr>
								<?php
										
									}else{}
								?>
								<?php										
									$pay = $conn->prepare("SELECT * FROM tr_payment WHERE cust_id = '$customer' AND (date_paid BETWEEN '$newfrom' and '$newto') AND is_deleted != '1' ORDER BY date_paid");												
									$pay->execute();
									
									if($pay->rowCount() > 0)
									{
										$ctr_pay = 1; $total_pay = 0;
										while($pay_data = $pay->fetch())
										{
											
											$datepaid = date("M d, Y", strtotime($pay_data['date_paid']));
											$total_pay += $pay_data['amount_paid'];
								?>
											<tr>
												<td class="tddata" valign="top"><font color="red"><?php echo $ctr_pay++; ?>.</font> </td>
												<td width="20px;">&nbsp;</td>
												<td class="tddata" valign="top"><font color="red"><?php echo $datepaid; ?></font></td>
												<td width="20px;">&nbsp;</td>
												<td class="tddata" valign="top"><font color="red"><?php echo $pay_data['or_number']; ?></font></td>
												<td width="20px;">&nbsp;</td>													
												<td class="tddata" valign="top"></td>
												<td width="20px;">&nbsp;</td>
												<td class="tddata" valign="top"></td>
												<td width="20px;">&nbsp;</td>
												<td class="tddata" valign="top"><font color="red">(<?php echo number_format($pay_data['amount_paid'], 2); ?>)</font></td>
											</tr>
											
								<?php
										} // End While										
										echo "<tr><td colspan='11'><hr color='#000000'/></td></tr>";
								?>
											<tr>
												<td colspan="8" align="center">*** Nothing Follows ***</td>
												<td class="tdlabel">Total</td>
												<td width="20px;"> : </td>
												<td class="tdlabel"><font color="red">(<?php echo number_format($total_pay, 2); ?>)</font></td>													
											</tr>
								<?php
										echo "<tr><td colspan='11'><hr color='#000000'/></td></tr>";
									}else{}
									
									$emp = $conn->prepare("SELECT * FROM bs_item i, tr_transaction_detail td, tr_transaction t
												WHERE t.tr_id = td.tr_id AND td.item_id = i.item_id AND (t.payment_mode = 'DR') AND t.is_deleted != '1' AND td.is_deleted != '1' AND t.is_paid != '1'
														AND (t.od_date_1 BETWEEN '$newfrom' and '$newto') $statement $cust_state												
																ORDER BY t.od_date");
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
											
											$cust = $conn->prepare("SELECT * FROM bs_customer WHERE cust_id = '$emp_data[cust_id]'");
											$cust->execute();
											
											if($cust->rowCount() > 0)
											{ 
												$cust_data = $cust->fetch();
												$customer = utf8_encode(ucwords(strtolower($cust_data['client_name']))); 
											}else{ $customer = '- -'; }
																							
											$sub_total = $emp_data['tr_qty'] * $emp_data['price'];
											$total += $sub_total;
								?>
											<tr>
												<td class="tddata" valign="top"><?php echo $ctr1++; ?>. </td>
												<td width="20px;">&nbsp;</td>
												<td class="tddata" valign="top"><?php echo $datereleased; ?></td>
												<td width="20px;">&nbsp;</td>
												<td class="tddata" valign="top"><?php echo $emp_data['dr']; ?></td>
												<td width="20px;">&nbsp;</td>													
												<td class="tddata" valign="top"><?php echo $emp_data['tr_qty']; ?></td>
												<td width="20px;">&nbsp;</td>
												<td class="tddata" valign="top"><?php echo number_format($emp_data['price'], 2); ?></td>
												<td width="20px;">&nbsp;</td>
												<td class="tddata" valign="top"><?php echo number_format($sub_total, 2); ?></td>													
											</tr>
								<?php
										} // End While
								?>
											<tr>
												<td colspan="11"><hr color='black' /></td>
											</tr>												
											<tr>
												<td colspan="8" align="center">*** Nothing Follows ***</td>
												<td class="tdlabel">Total</td>
												<td width="20px;"> : </td>
												<td class="tdlabel"><?php echo number_format($total, 2); ?></td>													
											</tr>
								<?php
									}else{}
								?>
							  </tbody>
					</table>
					<br />
					<table style="padding:7px; font-size:14px;" width="700">
					<tr>
						<td>Prepared by:<br /><br />__________________<br />Stefany Osalla</td>
						<td>Checked by:<br /><br />__________________<br />Teresa Calvo</td>
						<td>Received by:<br /><br />__________________<br />Signature over Printed Name</td>
					</tr>
					<tr>
						<td><br /></td>
					</tr>
					<tr>
						<td colspan="3">Please make check payable to <b>AQUALVO WATER REFILLING STATION</b><br />(CB Account No. 1369-00-00439-6)</td>
					</tr>
					</table>
					</center>           
				</div>
			</div><!--/span-->
		</div><!--/row-->