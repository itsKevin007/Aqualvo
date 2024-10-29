<?php
if (!defined('WEB_ROOT')) {
	exit;
}
	$userId = $_SESSION['user_id'];
	
	# Get user
	$usr = $conn->prepare("SELECT * FROM bs_user WHERE user_id = '$userId'");
	$usr->execute();
	$usr_data = $usr->fetch();
	$isadmin = $usr_data['access_level'];
	if($isadmin == 3)
	{
		$statement = "AND report_id = '1015'";		
	}else{
		$statement = '';
	}
	
	/* Select reports from database */
	$sql = $conn->prepare("SELECT * FROM bs_report WHERE is_deleted != '1' $statement");
	$sql->execute();
	

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;'
?>		
		<div class="row-fluid sortable">	
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-file"></i> List of Reports</h2>
						<!--&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:add();" class="btn btn-success">Add New</a>!-->
						<div class="box-icon">																					
							<a href="../" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>							
						</div>
					</div>
					<div class="box-content">	
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>								  
								  <th>Name</th>								  
								  <th>Description</th>
								  <th>Action</th>
							  </tr>
						  </thead>   
						  <tbody>
							<?php
								if($sql->rowCount() > 0)
								{
									while($sql_data = $sql->fetch())
									{
																				
																				
							?>
										<!-- Start display list of reports !-->
										<tr>											
											<td><?php echo $sql_data['name']; ?></td>											
											<td><?php echo $sql_data['description']; ?></td>											
											<td class="center">												
												<a class="btn btn-small" href="javascript:view(<?php echo $sql_data['report_id']; ?>);">
													<i class="icon-eye-open"></i>  
													View                                            
												</a>												
											</td>
										</tr>
										<!-- End display list of reports !-->
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
						