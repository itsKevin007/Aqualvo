<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
checkUser();

	$userId = $_SESSION['user_id'];
	
$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;'
?>		
<head>		
<title>Customer List</title>
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
						<b>List of Customers</b>						
						<br />							
						<table style="padding:7px;" border="0">
						<tr>							
							<td class="tdlabel">#</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">Name</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">Address</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">Contact No.</td>
							<td width="20px;">&nbsp;</td>
							<td class="tdlabel">Contact Person</td>
						<tr>							
							<td colspan="9"><hr color='black' /></td>							
						</tr>
								  <tbody>
									<?php
										$emp = $conn->prepare("SELECT * FROM bs_customer
													WHERE is_deleted != '1'
															ORDER BY client_name");
										$emp->execute();
										
										if($emp->rowCount() > 0)
										{
											$ctr = 1; $total = 0;
											while($emp_data = $emp->fetch())
											{
												
									?>
												<tr>													
													<td class="tddata" valign="top"><?php echo $ctr++; ?></td>
													<td width="20px;">&nbsp;</td>
													<td class="tddata" valign="top"><?php echo $emp_data['client_name']; ?></td>
													<td width="20px;">&nbsp;</td>												
													<td class="tddata" valign="top"><?php echo $emp_data['address']; ?></td>
													<td width="20px;">&nbsp;</td>												
													<td class="tddata" valign="top"><?php echo $emp_data['contactno']; ?></td>
													<td width="20px;">&nbsp;</td>												
													<td class="tddata" valign="top"><?php echo $emp_data['contact_person']; ?></td>
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