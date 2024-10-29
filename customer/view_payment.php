<?php
if (!defined('WEB_ROOT')) {
	exit;
}

	$id = $_GET['id'];
	
	$cst = $conn->prepare("SELECT * FROM bs_customer WHERE cust_id = '$id' AND is_deleted != '1'");
	$cst->execute();
	$cst_data = $cst->fetch();

	/* Select data from database */
	$sql = $conn->prepare("SELECT * FROM bs_customer c, tr_payment p WHERE c.cust_id = '$id' AND p.is_deleted != '1' AND p.cust_id = c.cust_id");
	$sql->execute();
	
	
	

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;'
?>		
		<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon icon-black icon-users"></i> List of Payments - <?php echo $cst_data['client_name']; ?></h2>						
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
								  <th>SOA</th>
								  <th>OR</th>
								  <th>Amount</th>								 
								  <th>Detail</th>
								  <th>Date Paid</th>
								  <th>Action</th>
							  </tr>
						  </thead>   
						  <tbody>
							<?php
								if($sql->rowCount() > 0)
								{
									while($sql_data = $sql->fetch())
									{
										
																														
										$datepaid = date("M d, Y",strtotime($sql_data['date_paid']));										
							?>
										<!-- Start display list of customer !-->
										<tr>
											<td><?php echo $sql_data['soa_number']; ?></td>
											<td><?php echo $sql_data['or_number']; ?></td>
											<td><?php echo $sql_data['amount_paid']; ?></td>
											<td><?php echo $sql_data['detail']; ?></td>
											<td><?php echo $datepaid; ?></td>
											<td>
												<a class="btn btn-info" href="index.php?view=modify_payment&id=<?php echo $sql_data['pay_id']; ?>">Edit</a>
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
						