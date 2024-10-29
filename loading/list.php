<?php
if (!defined('WEB_ROOT')) {
	exit;
}

	/* Select data from database */
	$sql = $conn->prepare("SELECT * FROM tr_loading WHERE is_deleted != '1'");
	$sql->execute();
	
	
	

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;'
?>		
		<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-road"></i> List of Truck Loading</h2>
						&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:add();" class="btn btn-success">Add New</a>
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
								  <th>Truck Name</th>								  
								  <th>Round</th>
								  <th>Slim</th>								 
								  <th>Dispenser</th>
								  <th>Trip No.</th>
								  <th>Date</th>
								  <th>Action</th>
							  </tr>
						  </thead>   
						  <tbody>
							<?php
								if($sql->rowCount() > 0)
								{
									while($sql_data = $sql->fetch())
									{
										
										$dateadded = date("M d, Y | h:i A", strtotime($sql_data['date_added']));										
							?>
										<!-- Start display list of data !-->
										<tr>
											<td><?php echo $sql_data['truckname']; ?></td>
											<td><?php echo $sql_data['i_round']; ?></td>											
											<td><?php echo $sql_data['i_slim']; ?></td>
											<td><?php echo $sql_data['i_dispenser']; ?></td>
											<td><?php echo $sql_data['trip_no']; ?></td>
											<td><?php echo $dateadded; ?></td>
										<td class="center">												
												<a class="btn btn-info" href="javascript:mod(<?php echo $sql_data['load_id']; ?>);">
													<i class="icon-edit icon-white"></i>  
													Edit                                            
												</a>												
													<a class="btn btn-danger" href="processmodify.php?action=delete&id=<?php echo $sql_data['load_id']; ?>">
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
						