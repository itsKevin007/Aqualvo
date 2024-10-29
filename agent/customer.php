<?php
require_once 'global-library/config.php';
require_once 'global-library/functions.php';


checkUser();

	date_default_timezone_set("Asia/Manila");
	$today_date1 = date("Y-m-d H:i:s");
	$today_date2 = date("Y-m-d");
	$today_date3 = date("M d, Y | l");
	
	$cus = $conn->prepare("SELECT * FROM bs_user WHERE user_id = '$userId'");
	$cus->execute();
	$cus_data = $cus->fetch();
	$vnum = $cus_data['van_number'];	

?>

	<?php
		if($vnum == '1')
		{
	?>
		<a href="<?php echo WEB_ROOT; ?>agent/process_van.php?n=1" class="btn btn-large btn-warning">Van 1 <span class='icon32 icon-white icon-check'/></a>
		&nbsp;
		<a href="<?php echo WEB_ROOT; ?>agent/process_van.php?n=2" class="btn btn-large btn-warning">Van 2</a>
		&nbsp;
		<a href="<?php echo WEB_ROOT; ?>agent/process_van.php?n=3" class="btn btn-large btn-warning">Van 3</a>
	<?php
		}
		else if($vnum == '2')
		{
	?>
		<a href="<?php echo WEB_ROOT; ?>agent/process_van.php?n=1" class="btn btn-large btn-warning">Van 1</a>
		&nbsp;
		<a href="<?php echo WEB_ROOT; ?>agent/process_van.php?n=2" class="btn btn-large btn-warning">Van 2 <span class='icon32 icon-white icon-check'/></a>
		&nbsp;
		<a href="<?php echo WEB_ROOT; ?>agent/process_van.php?n=3" class="btn btn-large btn-warning">Van 3</a>
	<?php
		}else{
	?>
		<a href="<?php echo WEB_ROOT; ?>agent/process_van.php?n=1" class="btn btn-large btn-warning">Van 1</a>
		&nbsp;
		<a href="<?php echo WEB_ROOT; ?>agent/process_van.php?n=2" class="btn btn-large btn-warning">Van 2</a>
		&nbsp;
		<a href="<?php echo WEB_ROOT; ?>agent/process_van.php?n=3" class="btn btn-large btn-warning">Van 3 <span class='icon32 icon-white icon-check'/></a>
	<?php } ?>
	
		<div class="box span12">
			<div class="box-header well" data-original-title>
				<h2><i class="icon-user"></i> All Customers
					&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo WEB_ROOT; ?>agent/add.php" class="btn btn-success nyroModal">Add New</a>
				</h2>
				<!--&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:add();" class="btn btn-success">Add New</a>!-->
				<div class="box-icon">																					
					<a href="../" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>							
				</div>
			</div>
			<div class="box-content">				
				<table class="table table-striped table-bordered bootstrap-datatable datatable">
				  <thead>
					  <tr>
						  <th style="display:none;">#</th>
						  <th>Customer</th>								  
						  <th>Address</th>
						  <th>Contact No.</th>						  
						  <th>Action</th>
					  </tr>
				  </thead>   
				  <tbody>
					<?php
						/*if($inv == 1001)
						{
							$sql = "SELECT * FROM bs_customer
										WHERE is_deleted != '1'
											ORDER BY client_name";		
						}else{
							$sql = "SELECT * FROM bs_customer c, tr_schedule s
										WHERE c.is_deleted != '1' AND s.dt_date = '$today_date2' AND c.cust_id = s.client_id
											ORDER BY c.client_name";						
						}*/
						$sql = $conn->prepare("SELECT * FROM bs_customer
										WHERE is_deleted != '1'
											ORDER BY client_name");
						$sql->execute();
													
						if($sql->rowCount() > 0)
						{
							$ctr = 1;
							while($sql_data = $sql->fetch())
							{
																		
																			
					?>
								<!-- Start display list of customer !-->
								<tr>
									<td style="display:none;"><?php echo $ctr--; ?></td>
									<td><a href="agent/index.php?c=<?php echo $sql_data['cust_id']; ?>"><?php echo $sql_data['client_name']; ?></a></td>
									<td><?php echo $sql_data['address']; ?></td>
									<td><?php echo $sql_data['contactno']; ?></td>
									<td><a class="btn btn-success" href="<?php echo WEB_ROOT; ?>customer/index.php?view=add_payment&id=<?php echo $sql_data['cust_id']; ?>&o=2">Add</a></td>
								</tr>
								<!-- End display list of customer !-->
					<?php
							} // End While
						}else{}
					?>
					
				  </tbody>
				</table>            
			</div>
		</div><!--/span-->
		<?php
			$sql = $conn->prepare("SELECT * FROM bs_customer c, tr_schedule s
							WHERE c.is_deleted != '1' AND s.dt_date < '$today_date2' AND c.cust_id = s.client_id AND is_delivered != '1'
								ORDER BY c.client_name");
			$sql->execute();
				
		?>
				<div class="box span6">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-user"></i>Not Yet Delivered</h2>
					</div>
					<div class="box-content">				
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
								  <th style="display:none;">#</th>
								  <th>Customer</th>
								  <th>Date</th>
							  </tr>
						  </thead>   
						  <tbody>
							<?php
								if($sql->rowCount() > 0)
								{
									$ctr = 1;
									while($sql_data = $sql->fetch())
									{
																				
										$orderdate = date("M d, Y",strtotime($sql_data['dt_date']));
							?>
										<!-- Start display list of customer !-->
										<tr>
											<td style="display:none;"><?php echo $ctr--; ?></td>
											<td><a href="agent/index.php?c=<?php echo $sql_data['cust_id']; ?>"><?php echo $sql_data['client_name']; ?></a></td>
											<td><?php echo $orderdate; ?> - <?php echo $sql_data['dt_day']; ?></td>
										</tr>
										<!-- End display list of customer !-->
							<?php
									} // End While
								}else{}
							?>
							
						  </tbody>
						</table>            
					</div>
				</div><!--/span-->
						