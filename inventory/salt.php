<?php
if (!defined('WEB_ROOT')) {
	exit;
}

	/* Select data from database */
	$sal = $conn->prepare("SELECT * FROM tr_inventory_salt WHERE is_deleted != '1'");
	$sal->execute();
	
	
	

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;'
?>		
		<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-magnet"></i> List of Salt</h2>
						&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:add_salt();" class="btn btn-success">Add New</a>
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
								  <th>Unit Qty</th>
								  <th>Unit Price</th>
								  <th>Qty</th>
								  <th>IN</th>
								  <th>OUT</th>
								  <!--<th>Balance</th>!-->
								  <th>Received By</th>
								  <th>Action</th>
							  </tr>
						  </thead>   
						  <tbody>
							<?php
								if($sal->rowCount() > 0)
								{
									while($sal_data = $sal->fetch())
									{
							?>
										<!-- Start display list of data !-->
										<tr>
											<td><?php echo $sal_data['inv_date']; ?></td>
											<td><?php echo $sal_data['supplier']; ?></td>
											<td><?php echo $sal_data['inv_no']; ?></td>
											<td><?php echo $sal_data['unit_qty']; ?></td>
											<td><?php echo $sal_data['unit_price']; ?></td>
											<td><?php echo $sal_data['qty']; ?></td>
											<td><?php echo $sal_data['qty_in']; ?></td>
											<td><?php echo $sal_data['qty_out']; ?></td>
											<!--<td></?php echo $rw_sal['qty_in'] - $rw_sal['qty_out']; ?></td>!-->
											<td><?php echo $sal_data['received_by']; ?></td>
										<td class="center">												
												<a class="btn btn-info" href="index.php?view=modify_salt&id=<?php echo $sal_data['inv_id']; ?>;">
													<i class="icon-edit icon-white"></i>  
													Edit                                            
												</a>												
													<a class="btn btn-danger" href="process_salt.php?action=delete&id=<?php echo $sal_data['inv_id']; ?>;">
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
						