<?php
if (!defined('WEB_ROOT')) {
	exit;
}

	/* Select books from database */
	$sql = $conn->prepare("SELECT * FROM bs_user WHERE is_deleted != '1'");
	$sql->execute();
	
	
	

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;'
?>		
		<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon icon-black icon-users"></i> List of Users</h2>
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
								  <th style="display:none;">Access Level</th>
								  <th>Name</th>								  
								  <th>Username</th>
								  <th>Picture</th>								 
								  <th>Actions</th>
							  </tr>
						  </thead>   
						  <tbody>
							<?php
								if($sql->rowCount() > 0)
								{
									while($sql_data = $sql->fetch())
									{
										
																				
										$name = $sql_data['firstname'] . '&nbsp;' . $sql_data['lastname'];
										if ($sql_data['image']) {
											$image = WEB_ROOT . 'images/user/' . $sql_data['image'];
										} else {
											$image = WEB_ROOT . 'images/user/noimagelarge.jpg';
										}
																				
							?>
										<!-- Start display list of users !-->
										<tr>
											<th style="display:none;"><?php $sql_data['access_level']; ?></th>
											<td><?php echo $name; ?></td>											
											<td><?php echo $sql_data['username']; ?></td>
											<td><img class="dashboard-avatar" alt="<?php echo $sql_data['lastname']; ?>" src="<?php echo $image; ?>" /></td>
											<td class="center">												
												<a class="btn btn-info" href="javascript:mod(<?php echo $sql_data['user_id']; ?>);">
													<i class="icon-edit icon-white"></i>  
													Edit                                            
												</a>
												<!-- Disable delete button for admin user level !-->
												<?php if($sql_data['access_level'] != "1") { ?>
													<a class="btn btn-danger" href="javascript:del(<?php echo $sql_data['user_id']; ?>);">
														<i class="icon-trash icon-white"></i> 
														Delete
													</a>
												<?php }else{ ?>
													<a class="btn btn-danger disabled">
														<i class="icon-trash icon-white"></i> 
														Delete
													</a>
												<?php } ?>
											</td>
										</tr>
										<!-- End display list of users !-->
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
						