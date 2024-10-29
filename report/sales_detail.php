<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
checkUser();

	$userId = $_SESSION['user_id'];	
	
	$customer = $_POST['customer'];
	$agent = $_POST['agent'];
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
	
	if($agent != 0)
	{
		$agt = $conn->prepare("SELECT * FROM bs_user WHERE user_id = '$agent'");
		$agt->execute();
		$agt_data = $agt->fetch();
		$agent_state = "AND t.user_id = '$agent'";		
	}else{
		$agent_state = "";		
	}
	
	$vanum = $_POST['van'];
	if($vanum != 0)
	{				
		$van_state = "AND t.van_number = '$vanum'";		
	}else{
		$van_state = "";		
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
<title>Sales Report</title>
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
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-pencil"></i> Sales Report - <?php echo $cust_label; ?></h2>						
						<div class="box-icon">
							<a href="../" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
						<h4><?php echo $wfrom; ?> to <?php echo $wto; ?></h4>
						<br />							
						<table style="padding:7px;" border="0">
						<tr>
							<td class="tdlabel">#</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">Date</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">Trans No.</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">Cash</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">DR</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">DA</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">Customer</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">Item</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">Qty</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">Price</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">Sub Total</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">Emptys</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">Staff</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">Van No.</td>
						</tr>
						<tr>
							<td colspan="28"><hr color='black' /></td>
						</tr>
								  <tbody>
									<?php
										$emp = $conn->prepare("SELECT * FROM bs_item i, tr_transaction t, tr_transaction_detail td
													WHERE t.tr_id = td.tr_id AND td.item_id = i.item_id AND t.is_deleted != '1' AND td.is_deleted != '1'
															AND (t.od_date_1 BETWEEN '$newfrom' and '$newto') $statement $cust_state $agent_state $van_state
																	ORDER BY t.od_date");
										$emp->execute();
										
										if($emp->rowCount() > 0)
										{
											$ctr1 = 1; $total = 0; $total_emptys = 0;
											while($emp_data = $emp->fetch())
											{
												
												
												//$tuserid = $rw_emp['t.user_id'];
												
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
												// Check if items are for drop off
												
												if($emp_data['item_type'] == 's'){ $itmtype = 'Slim'; }else{ $itmtype = 'Round'; }
												
												$total_emptys += $emp_data['emptys'];
												
									?>
												<tr>
													<td class="tddata" valign="top"><?php echo $ctr1++; ?>. </td>
													<td width="20px;">&nbsp;</td>
													<td class="tddata" valign="top"><?php echo $datereleased; ?></td>
													<td width="20px;">&nbsp;</td>
													<td class="tddata" valign="top"><?php echo $emp_data['tr_id']; ?></td>
													<td width="20px;">&nbsp;</td>
													<td class="tddata" valign="top"><?php echo $emp_data['cr']; ?></td>
													<td width="20px;">&nbsp;</td>
													<td class="tddata" valign="top"><?php echo $emp_data['dr']; ?></td>
													<td width="20px;">&nbsp;</td>
													<td class="tddata" valign="top"><?php echo $emp_data['da']; ?></td>
													<td width="20px;">&nbsp;</td>
													<td class="tddata" valign="top"><?php echo $customer; ?></td>
													<td width="20px;">&nbsp;</td>
													<td class="tddata" valign="top"><?php echo $emp_data['name']; ?> - <?php echo $itmtype; ?></td>
													<td width="20px;">&nbsp;</td>
													<td class="tddata" valign="top"><?php echo $emp_data['tr_qty']; ?></td>
													<td width="20px;">&nbsp;</td>
													<td class="tddata" valign="top"><?php echo number_format($emp_data['price'], 2); ?></td>
													<td width="20px;">&nbsp;</td>
													<td class="tddata" valign="top"><?php echo number_format($sub_total, 2); ?></td>
													<td width="20px;">&nbsp;</td>
													<td class="tddata" valign="top"><?php echo $emp_data['emptys']; ?></td>
													<td width="20px;">&nbsp;</td>
													<td class="tddata" valign="top"><?php echo $released_by; ?></td>
													<td width="20px;">&nbsp;</td>
													<td class="tddata" valign="top"><?php echo $emp_data['van_number']; ?></td>
												</tr>
									<?php
											} // End While
									?>
												<tr>
													<td colspan="28"><hr color='black' /></td>
												</tr>												
												<tr>
													<td colspan="18"></td>
													<td class="tdlabel">Total</td>
													<td width="20px;"> : </td>
													<td class="tdlabel"><?php echo number_format($total, 2); ?></td>
													<td width="20px;">&nbsp;</td>													
													<td class="tdlabel"><?php echo number_format($total_emptys, 2); ?></td>
												</tr>
									<?php
										}else{}
									?>
								  </tbody>
						</table>            
					</div>
				</div><!--/span-->
		</div><!--/row-->