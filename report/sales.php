<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
checkUser();

	$userId = $_SESSION['user_id'];	
		
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
		//$statement = "AND released_by = '$userId'";
		$statement = '';
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
						<h2><i class="icon-pencil"></i> Sales Report</h2>						
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
							<td class="tdlabel">Date Released</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">Table</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">Amount</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">Discount</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">Sub Total</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">Mode</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">Sales</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">Released By</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">Remarks</td>
						</tr>
						<tr>
							<td colspan="21">
								<hr style="border: 0; height: 1px; background-image: -webkit-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,0.75), rgba(0,0,0,0)); background-image: -moz-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,0.75), rgba(0,0,0,0)); background-image: -ms-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,0.75), rgba(0,0,0,0));  background-image: -o-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,0.75), rgba(0,0,0,0)); " />
							</td>
						</tr>
								  <tbody>
									<?php
										$emp = $conn->prepare("SELECT * FROM tbl_order
													WHERE (od_date_1 BETWEEN '$newfrom' and '$newto') $statement AND is_deleted != '1'													
																	ORDER BY od_date_1");
										$emp->execute();
										
										if($emp->rowCount() > 0)
										{
											$ctr1 = 1; $total = 0; $total_amtdue = 0; $total_disc = 0; $total_payment = 0; $total_sales = 0;
											while($emp_data = $emp->fetch())
											{
												
												
												$datereleased = date("M d, Y | h:i a", strtotime($od_date));
												
												$rby = $conn->prepare("SELECT * FROM bs_user WHERE user_id = '$released_by'");
												$rby->execute();
												
												if($rby->rowCount() > 0)
												{ 
													$rby_data = $rby->fetch();
													$released_by = utf8_encode(ucwords(strtolower($rby_data['lastname']))) . ',&nbsp;' . ucwords(strtolower($rby_data['firstname'])); 
												}else{ $released_by = '- -'; }
																								
												$sub_total = $od_amount_due -  $od_discount;
												$total += $sub_total;
												$total_amtdue += $od_amount_due;
												$total_disc += $od_discount;
												$total_payment += $od_payment;
												if($payment_mode != 'Cash')
												{ $sales = 0; }else{ $sales = $sub_total; }
												
												
												$total_sales += $sales;
												// Check if items are for drop off
												
									?>
												<tr>
													<td class="tddata" valign="top"><?php echo $ctr1++; ?>. </td>
													<td width="20px;">&nbsp;</td>
													<td class="tddata" valign="top"><?php echo $datereleased; ?></td>
													<td width="20px;">&nbsp;</td>
													<td class="tddata" valign="top"><?php echo $table_number; ?></td>
													<td width="20px;">&nbsp;</td>
													<td class="tddata" valign="top" align="right"><?php echo number_format($od_amount_due, 2); ?></td>
													<td width="20px;">&nbsp;</td>
													<td class="tddata" valign="top" align="right"><?php echo number_format($od_discount, 2); ?></td>
													<td width="20px;">&nbsp;</td>
													<td class="tddata" valign="top" align="right"><?php echo number_format($sub_total, 2); ?></td>
													<td width="20px;">&nbsp;</td>
													<td class="tddata" valign="top"><?php echo $payment_mode; ?></td>
													<td width="20px;">&nbsp;</td>
													<td class="tddata" valign="top" align="right"><?php echo number_format($sales, 2); ?></td>
													<td width="20px;">&nbsp;</td>
													<td class="tddata" valign="top"><?php echo $released_by; ?></td>
													<td width="20px;">&nbsp;</td>
													<td class="tddata" valign="top"><?php echo $od_remarks; ?></td>
												</tr>
									<?php
											} // End While
									?>
												<tr>
													<td colspan="21"><hr color='black' /></td>
												</tr>												
												<tr>
													<td colspan="6"></td>																									
													<td class="tdlabel" align="right"><?php echo number_format($total_amtdue, 2); ?></td>
													<td></td>
													<td class="tdlabel" align="right"><?php echo number_format($total_disc, 2); ?></td>
													<td></td>
													<td class="tdlabel" align="right"><?php echo number_format($total, 2); ?></td>
													<td colspan="3"></td>
													<td class="tdlabel" align="right"><?php echo number_format($total_sales, 2); ?></td>
												</tr>
									<?php
										}else{}
									?>
								  </tbody>
						</table>            
					</div>
				</div><!--/span-->
		</div><!--/row-->