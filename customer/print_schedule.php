<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
checkUser();

	$userId = $_SESSION['user_id'];
	
	$cust = $_GET['id'];
	
$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;'
?>		
<head>		
<title>Customer Schedule</title>
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
			<center>
					<img src="<?php echo WEB_ROOT; ?>images/logo/header_logo.png" /><br />
						<b>Customer Schedule</b>						
						<br />							
						<table style="padding:7px;" border="0">
						<tr>							
							<td class="tdlabel">#</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">Name</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">Date</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">Day</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">Contact No.</td>
						<tr>							
							<td colspan="9"><hr color='black' /></td>							
						</tr>
								  <tbody>
									<?php
										$emp = $conn->prepare("SELECT * FROM bs_customer c, tr_schedule s
													WHERE s.client_id = '$cust' AND c.cust_id = s.client_id AND c.is_deleted != '1' AND s.is_deleted != '1'
															GROUP BY s.dt_date
																ORDER BY s.dt_date");
										$emp->execute();
										
										if($emp->rowCount() > 0)
										{
											$ctr = 1; $total = 0;
											while($emp_data = $emp->fetch())
											{
											;
												
												$sdate = date("M d, Y", strtotime($emp_data['dt_date']));
									?>
												<tr>													
													<td class="tddata" valign="top"><?php echo $ctr++; ?></td>
													<td width="20px;">&nbsp;</td>
													<td class="tddata" valign="top"><?php echo $emp_data['client_name']; ?></td>
													<td width="20px;">&nbsp;</td>												
													<td class="tddata" valign="top"><?php echo $sdate; ?></td>
													<td width="20px;">&nbsp;</td>												
													<td class="tddata" valign="top"><?php echo $emp_data['dt_day']; ?></td>
													<td width="20px;">&nbsp;</td>												
													<td class="tddata" valign="top"><?php echo $emp_data['contactno']; ?></td>
												</tr>
									<?php
											} // End While
									?>
												<tr>
													<td colspan="9"><hr color='black' /></td>
												</tr>
									<?php
										}else{ $total = 0; }
									?>
								  </tbody>
						</table>
			</center>