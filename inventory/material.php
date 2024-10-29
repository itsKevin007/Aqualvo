<?php
if (!defined('WEB_ROOT')) {
	exit;
}

	/* Select data from database */
	$mat = $conn->prepare("SELECT * FROM tr_inventory_material WHERE is_deleted != '1'");
	$mat->execute();
	
	
	

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;'
?>		
		<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-magnet"></i> List of Materials</h2>
						&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:add_material();" class="btn btn-success">Add New</a>
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
							      <th>Date</th>
								  <th>Supplier</th>								  								  
								  <th>Inv No./WS No.</th>								  					
								  <th>Unit Price</th>
								  <th>IN</th>
								  <th>OUT</th>
								  <!--<th>Balance</th>!-->
								  <th>Received By</th>
								  <th>Action</th>
							  </tr>
						  </thead>   
						  <tbody>
							<?php
								if($mat->rowCount() > 0)
								{
									while($mat_data = $mat->fetch())
									{
							?>
										<!-- Start display list of data !-->
										<tr>
											<td><?php echo $mat_data['inv_date']; ?></td>
											<td><?php echo $mat_data['supplier']; ?></td>
											<td><?php echo $mat_data['inv_no']; ?></td>
											<td><?php echo $mat_data['unit_price']; ?></td>
											<td><?php echo $mat_data['qty_in']; ?></td>
											<td><?php echo $mat_data['qty_out']; ?></td>
											<!--<td></?php echo $rw_mat['qty_in'] - $rw_mat['qty_out']; ?></td>!-->
											<td><?php echo $mat_data['received_by']; ?></td>
											<td class="center">												
												<a class="btn btn-info" href="index.php?view=modify_material&id=<?php echo $mat_data['inv_id']; ?>;">
													<i class="icon-edit icon-white"></i>  
													Edit                                            
												</a>											
												<a class="btn btn-danger" href="process_material.php?action=delete&id=<?php echo $mat_data['inv_id']; ?>;">
													<i class="icon-trash icon-white"></i> 
													Delete
												</a>																						
											</td>
										</tr>
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
						