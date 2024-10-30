<?php
if (!defined('WEB_ROOT')) {
	exit;
}

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;'
?>		


				<div class="box span6">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-tasks"></i> Undelivered</h2>&nbsp;&nbsp;
						<a href="<?php echo WEB_ROOT; ?>report/pending.php" target="_blank"><button class="btn btn-primary"><i class="icon-print icon-white"></i></button></a>
						<div class="box-icon">																					
							<a href="../" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>							
						</div>
					</div>
					<div class="box-content">
						<?php
								if($errorMessage == 'Deleted successfully')
								{
							?>
									<div class="valid_box">
										<b><?php echo $errorMessage; ?></b>
									</div>
							<?php
								}else{}
						?>
						</div>
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  	<tr>  
							  		<th>Client Name</th>								  
									<th>Address</th>
									<th>Contact #</th>
									<th>Last Delivered #</th>
								  <!--<th>Date</th>!-->
							  </tr>
						  </thead>   
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
												<td><?php echo $cname; ?></td>
												<td><?php echo $address; ?></td>
												<td><?php echo $contactno; ?></td>
												<td><?php echo $oddate1; ?></td>
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
					
				</div><!--/span-->
