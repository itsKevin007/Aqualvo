<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
checkUser();

	$userId = $_SESSION['user_id'];	
	
$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;'
?>		
<head>		
<title>Pending/Overdue</title>
<link rel="shortcut icon" href="<?php echo WEB_ROOT; ?>images/aqualvo.png">
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
							<td><h2>Pending/Over Due</h4></td>
						</tr>
						</table></center>						
					</div>
					<br />
					<div class="box-content">
						<center><table style="padding:7px; font-size:14px; text-align: center;" width="800" border="0">
								<thead>
									<tr>								  
											<th width="100px">Client Name</th>							  
											<th width="200px">Address</th>
											<th width="100px">Contact #</th>
											<th width="100px">Last Delivered #</th>
										<!--<th>Date</th>!-->
									</tr>
								</thead> 
							
							</td>
						</tr>
						<tr>
							<td colspan="5">
								<hr color='black' />
							</td>
						</tr>
								  <tbody>
									<?php
										// Query to get the latest transaction for each customer and check if overdue
										$sql = $conn->prepare("
											SELECT t.*, c.client_name, c.address, c.contactno
											FROM bs_customer c
											JOIN (
												SELECT cust_id, MAX(od_date_1) AS latest_od_date
												FROM tr_transaction
												WHERE is_deleted != '1'
												GROUP BY cust_id
											) latest ON c.cust_id = latest.cust_id
											JOIN tr_transaction t ON t.cust_id = latest.cust_id AND t.od_date_1 = latest.latest_od_date
											WHERE c.is_deleted != '1'
											AND c.is_active != '1'
											ORDER BY latest.latest_od_date ASC");
										$sql->execute();
										
										if ($sql->rowCount() > 0) {
											while ($sql_data = $sql->fetch()) {
												$cname = $sql_data['client_name'];
												$address = $sql_data['address'];
												$contactno = $sql_data['contactno'];
												$oddate = $sql_data['od_date_1'];
		
												// Calculate the overdue date by adding 8 days to the latest order date
												$datedue = date("Y-m-d", strtotime($oddate . " +8 days"));
												$today = date("Y-m-d", strtotime($today_date1));
		
												// Display only if overdue date is past
												if ($datedue < $today) {
													$oddate1 = date("M d, Y", strtotime($oddate));
													?>
													<!-- Start display list of data -->
													<tr>
														<td width="100px"><?php echo $cname; ?></td>
														<td width="200px"><?php echo $address; ?></td>
														<td width="100px"><?php echo $contactno; ?></td>
														<td width="100px"><?php echo $oddate1; ?></td>
													</tr>
													<!-- End display list of data -->
													<?php
												}
											}
										} else {
											echo "<tr><td colspan='4'>No overdue records found.</td></tr>";
										}
										?>	
								  </tbody>
							</table>
						<br />
						</center>           
					</div>
				</div><!--/span-->
		</div><!--/row-->