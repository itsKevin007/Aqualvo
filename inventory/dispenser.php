<?php
if (!defined('WEB_ROOT')) {
	exit;
}

	/* Select data from database */
	$dis = $conn->prepare("SELECT * FROM tr_inventory_dispenser WHERE is_deleted != '1'");
	$dis->execute();
	
	
	

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;'
?>		
		<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-magnet"></i> List of Dispenser</h2>
						&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:add_dispenser();" class="btn btn-success">Add New</a>
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
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
								<tr>
									<th colspan="7" style="background:#666666; color:#ffffff; text-align:center;">Purchase</th>
									<th colspan="6" style="background:#666666; color:#ffffff; text-align:center;">Dispatched to Customer</th>
								</tr>
								<tr>
									<th>Date</th>
									<th>Supplier</th>
									<th>Brand</th>
									<th>Serial No.</th>
									<th>Inv No.</th>								  
									<th>Unit Price</th>								  
									<th>IN</th>
									<th>OUT</th>
									<th>Date</th>
									<th>WDA No.</th>
									<th>Customer</th>
									<!--<th>Balance</th>!-->
									<th>Received By</th>
									<th>Action</th>
								
						  </thead>   
						  <tbody>
							<?php
								if($dis->rowCount() > 0)
								{
									while($dis_data = $dis->fetch())
									{
										$cust_id = $dis_data['cust_id'];
											# Get data
											$plant = $conn->prepare("SELECT * FROM bs_customer WHERE cust_id = '$cust_id' AND is_deleted != '1'");
											$plant->execute();
											$plant_data = $plant->fetch();
							?>
										<!-- Start display list of data !-->
										<tr>
											<td><?php echo $dis_data['inv_date']; ?></td>
											<td><?php echo $dis_data['supplier']; ?></td>
											<td><?php echo $dis_data['brand']; ?></td>
											<td><?php echo $dis_data['serial']; ?></td>
											<td><?php echo $dis_data['inv_no']; ?></td>											
											<td><?php echo $dis_data['unit_price']; ?></td>											
											<td><?php echo $dis_data['qty_in']; ?></td>
											<td><?php echo $dis_data['qty_out']; ?></td>
											<td><?php echo $dis_data['date_out']; ?></td>
											<td><?php echo $dis_data['wda_no']; ?></td>
											<td><?php echo $plant_data['client_name']; ?></td>
											<!--<td></?php echo $rw_dis['qty_in'] - $rw_dis['qty_out']; ?></td>!-->
											<td><?php echo $dis_data['received_by']; ?></td>
											<td class="center">												
												<a class="btn btn-info" href="index.php?view=modify_dispenser&id=<?php echo $dis_data['inv_id']; ?>;">
													<i class="icon-edit icon-white"></i>  
													Edit                                            
												</a>												
													<a class="btn btn-danger" href="process_dispenser.php?action=delete&id=<?php echo $dis_data['inv_id']; ?>;">
														<i class="icon-trash icon-white"></i> 
														Delete
													</a>
									</td>
									</td>
										<!-- End display list of data !-->
							<?php
									}
									
									
								}
								else
								{}
							?>
							
						  </tbody>
						</table>            
					</div>
				</div><!--/span-->
			
			</div><!--/row-->
						