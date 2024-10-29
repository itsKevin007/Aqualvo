<?php
if (!defined('WEB_ROOT')) {
	exit;
}

	/* Select data from database */
	$sql = $conn->prepare("SELECT * FROM bs_item WHERE is_deleted != '1'");
	$sql->execute();
	
	
	

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;'
?>		
		<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-hdd"></i> List of Items</h2>
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
							      <th>Code</th>
								  <th>Name</th>								  
								  <th>Price</th>								  					
								  <th>Actions</th>
							  </tr>
						  </thead>   
						  <tbody>
							<?php
								if($sql->rowCount() > 0)
								{
									while($sql_data = $sql->fetch())
									{
										
																																				
							?>
										<!-- Start display list of data !-->
										<tr>
											<td><?php echo $sql_data['abrv']; ?></td>
											<td><?php echo $sql_data['name']; ?></td>											
											<td><?php echo $sql_data['price']; ?></td>											
											<td class="center">												
												<a class="btn btn-info" href="javascript:mod(<?php echo $sql_data['item_id']; ?>);">
													<i class="icon-edit icon-white"></i>  
													Edit                                            
												</a>												
												<a class="btn btn-danger" href="javascript:del(<?php echo $sql_data['item_id']; ?>);">
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
						