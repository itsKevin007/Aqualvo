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
						<div class="box-icon">																					
							<a href="../" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>							
						</div>
					</div>
					<div class="box-content">
						<?php
								if($errorMessage == 'Saved successfully')
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
												<a class="btn btn-success nyroModal" href="type.php?c=<?php echo $sql_data['cust_id']; ?>&t=1">
													<i class="icon-adjust"></i>  
													Round                                            
												</a>												
												<a class="btn btn-info nyroModal" href="type.php?c=<?php echo $sql_data['cust_id']; ?>&t=2">
													<i class="icon-minus"></i> 
													Slim
												</a>
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
						