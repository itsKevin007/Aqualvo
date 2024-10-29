<?php
if (!defined('WEB_ROOT')) {
	exit;
}
	
	$today_date2 = date("Y-m-d");

	/* Select data from database */
	$sql = $conn->prepare("SELECT *, SUM(total_amt_due) as total_amt FROM bs_customer c, tr_transaction p
				WHERE p.is_paid != '1' AND p.payment_mode = 'DR' AND p.cust_id = c.cust_id AND p.is_deleted != '1'
					GROUP BY p.cust_id
						ORDER BY c.client_name");
	$sql->execute();
	
	
	

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;'
?>		
		
				<div class="box span6">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-file"></i> Past Due Clients</h2>						
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
								  <th>Client</th>								  
								  <th>Amount</th>
								  <!--<th>Date</th>!-->
							  </tr>
						  </thead>   
						  <tbody>
							<?php
								if($sql->rowCount() > 0)
								{
									while($sql_data = $sql->fetch())
									{
									
																														
										$dt = date("M d, Y",strtotime($sql_data['date_added']));											
																			
							?>
										<!-- Start display list of customer !-->
										<tr>											
											<!--<td width="200"><a href="<?php echo WEB_ROOT; ?>customer/index.php?view=detail&id=<?php echo $sql_data['cust_id']; ?>"><?php echo word_split($sql_data['client_name'], 4); ?></a></td>!-->
											<td><a href="<?php echo WEB_ROOT; ?>graph/ar_detail.php?customer=<?php echo $sql_data['cust_id']; ?>" target=_blank><?php echo $sql_data['client_name']; ?></a></td>
											<td><?php echo number_format($sql_data['total_amt'], 2); ?></td>
											<!--<td><?php echo $dt; ?></td>!-->
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
			
			
						