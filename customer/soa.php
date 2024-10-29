<?php
require_once 'global-library/config.php';
require_once 'global-library/functions.php';


checkUser();

	date_default_timezone_set("Asia/Manila");
	$today_date1 = date("Y-m-d H:i:s");
	$today_date2 = date("Y-m-d");
	$today_date3 = date("M d, Y | l");
	
	$sql = $conn->prepare("SELECT * FROM bs_user
				WHERE user_id = '$userId'");
	$sql->execute();
	$sql_data = $sql->fetch();								
	
	
?>
		<div class="box span12">
			<div class="box-header well" data-original-title>
				<h2><i class="icon-user"></i> Payables
					
				</h2>
				<!--&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:add();" class="btn btn-success">Add New</a>!-->
				<div class="box-icon">																					
					<a href="../" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>							
				</div>
			</div>
			<div class="box-content">				
				<table class="table table-striped table-bordered">
				  <thead>
					  <tr>
						  <th style="display:none;">#</th>
						  <th>Date</th>								  
						  <th>Amount</th>						 
					  </tr>
				  </thead>   
				  <tbody>
					<?php
						
						$sql = $conn->prepare("SELECT * FROM tr_transaction
										WHERE is_deleted != '1' AND cust_id = '$cust_id'
											ORDER BY date_added");
						$sql->execute();
														
						if($sql->rowCount() > 0)
						{
							$ctr = 1;
							while($sql_data = $sql->fetch())
							{
																	
								$orderdate = date("M d, Y",strtotime($sql_data['date_added']));
					?>
								<!-- Start display list of customer !-->
								<tr>
									<td style="display:none;"><?php echo $ctr--; ?></td>									
									<td><?php echo $orderdate; ?></td>
									<td>Php <?php echo number_format($sql_data['total_amt_due'], 2); ?></td>
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