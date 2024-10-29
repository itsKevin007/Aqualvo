<?php
if (!defined('WEB_ROOT')) {
	exit;
}

	/* Select data from database */
	$sql = $conn->prepare("SELECT * FROM bs_customer WHERE is_deleted != '1'");
	$sql->execute();
	
	
	

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;'
?>		
		<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon icon-black icon-users"></i> List of Customers</h2>
						&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:add();" class="btn btn-success">Add New</a>
						&nbsp;&nbsp;&nbsp;&nbsp;<a href="print_list.php" target="_blank" class="btn btn-info">Print List</a>
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
								  <th>Customer</th>
								  <th>Contact Person</th>
								  <th>Contact No.</th>								 
								  <th>Actions</th>
								  <th>Payment</th>
							  </tr>
						  </thead>   
						  <tbody>
							<?php
								if($sql->rowCount() > 0)
								{
									while($sql_data = $sql->fetch())
									{
																													
										//$name = $firstname . '&nbsp;' . $lastname;
										if ($sql_data['image']) {
											$image = WEB_ROOT . 'images/customer/' . $sql_data['image'];
										} else {
											$image = WEB_ROOT . 'images/customer/noimagelarge.jpg';
										}
																				
							?>
										<!-- Start display list of customer !-->
										<tr>
											<td><?php echo $sql_data['client_name']; ?></td>
											<td><?php echo $sql_data['contact_person']; ?></td>
											<td><?php echo $sql_data['contactno']; ?></td>
											<td class="center">												
												<a class="btn btn-info" href="javascript:mod(<?php echo $sql_data['cust_id']; ?>);">
													<i class="icon-edit icon-white"></i>  
													Edit                                            
												</a>												
													<a class="btn btn-danger" href="javascript:del(<?php echo $sql_data['cust_id']; ?>);">
														<i class="icon-trash icon-white"></i> 
														Delete
													</a>
													<a class="btn btn-small" href="print_schedule.php?id=<?php echo $sql_data['cust_id']; ?>" target="_blank">
														<i class="icon-calendar"></i> 
														Schedule
													</a>
											</td>
											<td>
												<a class="btn btn-info" href="index.php?view=view_payment&id=<?php echo $sql_data['cust_id']; ?>">View</a>
												<a class="btn btn-success" href="index.php?view=add_payment&id=<?php echo $sql_data['cust_id']; ?>&o=1">Add</a>
											</td>
										</tr>
										<!-- End display list of customer !-->
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
						