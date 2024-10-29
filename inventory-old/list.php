<?php
if (!defined('WEB_ROOT')) {
	exit;
}

	/* Select data from database */
	$sql = "SELECT * FROM bs_customer c, tr_inventory i WHERE c.cust_id = i.cust_id AND c.is_deleted != '1'";
	$result = dbQuery($sql);
	$numrows = dbNumRows($result);
	
	

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;'
?>		
	<form action="process.php" method="post" name="frmCart" id="frmCart">
		<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon icon-black icon-users"></i> List of Customers</h2>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input name="btnSubmit" type="submit" id="btnSubmit" value="Save" class="btn btn-success">
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
								  <th>Round</th>
								  <th>Slim</th>
								  <th>Dispenser</th>
							  </tr>
						  </thead>   
						  <tbody>
							<?php
								if($numrows > 0)
								{
									while($row = dbFetchAssoc($result))
									{
										extract($row);
																				
										$name = $firstname . '&nbsp;' . $lastname;
										
							?>
										<!-- Start display list of customer !-->
										<tr>
											<td><?php echo $client_name; ?></td>
											<td>
												<input name="round_<?php echo $inv_id; ?>[]" type="text" id="round[]" size="5" value="<?php echo $round; ?>" style="width:70px;" autocomplete=off>
											</td>
											<td>
												<input name="slim_<?php echo $inv_id; ?>[]" type="text" id="slim[]" size="5" value="<?php echo $slim; ?>" style="width:70px;" autocomplete=off>
												<input name="inv[]" type="hidden" value="<?php echo $inv_id; ?>" />
											</td>
											<td>
												<input name="dispenser_<?php echo $inv_id; ?>[]" type="text" id="dispenser[]" size="5" value="<?php echo $dispenser; ?>" style="width:70px;" autocomplete=off>
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
	</form>
						