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
		$cust_state = "AND p.cust_id = '$customer'";
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
<title>Payment Report</title>
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
						<h2><i class="icon-pencil"></i> Payment Report - <?php echo $cust_label; ?></h2>						
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
							<td class="tdlabel">OR No.</td>
							<td width="20px;">&nbsp;</td>							
							<td class="tdlabel">Customer</td>							
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">Amount</td>							
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">Details</td>
						</tr>
						<tr>
							<td colspan="11"><hr color='black' /></td>
						</tr>
								  <tbody>
									<?php
										$emp = $conn->prepare("SELECT * FROM tr_payment p, bs_customer c
													WHERE p.cust_id = c.cust_id AND p.is_deleted != '1'
															AND (p.date_paid BETWEEN '$newfrom' and '$newto') $statement $cust_state
																	ORDER BY p.date_paid");
										$emp->execute();
										
										if($emp->rowCount() > 0)
										{
											$ctr1 = 1; $total = 0; $total_emptys = 0;
											while($emp_data = $emp->fetch())
											{
												
												
												//$tuserid = $rw_emp['t.user_id'];
												
												$datepaid = date("M d, Y", strtotime($emp_data['date_paid']));
																								
												$cust = $conn->prepare("SELECT * FROM bs_customer WHERE cust_id = '$emp_data[cust_id]'");
												$cust->execute();
												
												if($cust->rowCount() > 0)
												{ 
													$cust_data = $cust->fetch();
													$customer = utf8_encode(ucwords(strtolower($cust_data['client_name']))); 
												}else{ $customer = '- -'; }
																																				
												$total += $emp_data['amount_paid'];
												// Check if items are for drop off
												
												
												
									?>
												<tr>
													<td class="tddata" valign="top"><?php echo $ctr1++; ?>. </td>
													<td width="20px;">&nbsp;</td>
													<td class="tddata" valign="top"><?php echo $datepaid; ?></td>
													<td width="20px;">&nbsp;</td>
													<td class="tddata" valign="top"><?php echo $emp_data['or_number']; ?></td>
													<td width="20px;">&nbsp;</td>
													<td class="tddata" valign="top"><?php echo $customer; ?></td>
													<td width="20px;">&nbsp;</td>
													<td class="tddata" valign="top"><?php echo number_format($emp_data['amount_paid'], 2); ?></td>
													<td width="20px;">&nbsp;</td>
													<td class="tddata" valign="top"><?php echo $emp_data['detail']; ?></td>
												</tr>
									<?php
											} // End While
									?>
												<tr>
													<td colspan="11"><hr color='black' /></td>
												</tr>												
												<tr>
													<td colspan="6"></td>
													<td class="tdlabel">Total</td>
													<td width="20px;"> : </td>
													<td class="tdlabel"><?php echo number_format($total, 2); ?></td>													
												</tr>
									<?php
										}else{}
									?>
								  </tbody>
						</table>            
					</div>
				</div><!--/span-->
		</div><!--/row-->