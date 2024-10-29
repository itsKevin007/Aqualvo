<?php
if (!defined('WEB_ROOT')) {
	exit;
}

	# Get user
	$usr = $conn->prepare("SELECT * FROM bs_user WHERE user_id = '$userId'");
	$usr->execute();
	$usr_data = $usr->fetch();
	$isadmin = $usr_data['is_admin'];
	if($isadmin == 1)
	{
		$statement = '';
	}else{
		$statement = "AND t.user_id = '$userId'";
	}
	
	if(isset($_POST['submit']))
	{ 
		$key = $_POST['search']; 
		if($key != ""){ $keystate = "AND t.tr_id = '$key'"; $limit = ""; $dbtbl = "datatable"; }else{ $keystate = ""; $limit = "LIMIT 70"; $dbtbl = ""; }
		$cust = $_POST['cust']; 		
		if($cust != 0)
		{ 
			$customer = "AND t.cust_id = '$cust'"; $limit = ""; $dbtbl = "datatable"; 
			# Get Customer
			$ejob = $conn->prepare("SELECT * FROM bs_customer WHERE cust_id = '$cust' AND is_deleted != '1'");
			$ejob->execute();
			
			if($ejob->rowCount() > 0)
			{
				$ejob_data = $ejob->fetch();
				
				$ejobId = $ejob_data['cust_id'];
				$ejobTitle = $ejob_data['client_name'];
			}else{
				$ejobId = 0;
				$ejobTitle = 'Choose Customer';
			}
		}else{ $customer = ""; $limit = "LIMIT 70"; $dbtbl = ""; $ejobTitle = 'Choose Customer'; }
		
		$dfrom = $_POST['from']; 
		$dto = $_POST['to']; 
		$newfrom = date("Y-m-d", strtotime($dfrom));
		$newto = date("Y-m-d", strtotime($dto));
		if(($dfrom != '') && ($dto != '')){ $datefilter = "AND (t.od_date_1 BETWEEN '$newfrom' and '$newto')"; $limit = ""; $dbtbl = "datatable"; }else{ $datefilter = ""; $limit = "LIMIT 70"; $dbtbl = ""; }
	}else{ $key = ""; $cust = ""; $dfrom = ""; $dto = ""; $keystate = ""; $customer = ""; $datefilter = ""; $limit = "LIMIT 70"; $dbtbl = ""; $ejobTitle = 'Choose Customer'; }

	if(isset($_POST['submit7']))
	{
		$key7 = $_POST['search7'];
		$cust7 = $_POST['cust7'];
		$srch7 = "AND t.$cust7 = $key7";
		
	}else{ $key7 = ""; $srch7 = ""; }
		$sql = $conn->prepare("SELECT *, SUM(td.price * td.tr_qty) AS od_amount
					FROM tr_transaction_detail td, bs_item i, tr_transaction t
						WHERE td.item_id = i.item_id and t.tr_id = td.tr_id AND t.is_deleted != '1' $statement $keystate $customer $datefilter $srch7
							GROUP BY td.tr_id
								ORDER BY td.tr_id DESC $limit");
		$sql->execute();

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;'
?>		
		<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-file"></i> List of Transactions</h2>
						&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:add(1001);" class="btn btn-success">Add New</a>
						<div class="box-icon">																					
							<a href="../" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>							
						</div>
					</div>
					<div class="box-content">
					<form method="post" action="index.php?view=list">
						<input type="text" name="search" autocomplete=off placeholder="Search Transaction #" style="width:137px;" value="<?php echo $key; ?>" />
							<select name="cust" id="cust" style="width:177px;">								
								<option value="<?php echo $ejobId; ?>">-- <?php echo $ejobTitle; ?> --</option>
								<option value="0">-- All --</option>
								<?php
									# Get Data
									$job = $conn->prepare("SELECT * FROM bs_customer WHERE is_deleted != '1'");
									$job->execute();
								
									if($job->rowCount() > 0)
									{
										while($job_data = $job->fetch())
										{
										
								?>
											<option value="<?php echo $job_data['cust_id']; ?>"><?php echo ucwords(strtolower($job_data['client_name'])); ?></option>
								<?php
										} // End While
									}else{}
								?>
							</select>
							<input type="text" class="input-xlarge" id="txtFromDate" name="from" onkeypress="return isNumberKey(event)" autocomplete=off placeholder="Date From" style="width:117px;" value="<?php echo $dfrom; ?>" />
							<input type="text" class="input-xlarge" id="txtToDate" name="to" onkeypress="return isNumberKey(event)" autocomplete=off placeholder="Date To" style="width:117px;" value="<?php echo $dto; ?>" />
						<input type="submit" name="submit" class="btn btn-success btn-round" value="Search" />
					</form>
					<form method="post" action="index.php?view=list">
						<input type="text" name="search7" autocomplete=off placeholder="Search #" style="width:117px;" value="<?php echo $key7; ?>" required />						
							<select name="cust7" id="cust7" style="width:77px;">
								<option value="cr">-- CR --</option>
								<option value="dr">-- DR --</option>
								<option value="da">-- DA --</option>
							</select>
						<input type="submit" name="submit7" class="btn btn-success btn-round" value="Search" />
					</form>
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
								  <th style="display:none;">#</th>
								  <th>Trans No.</th>
								  <th>Customer</th>
								  <th>Amount</th>
								  <th>Action</th>
							  </tr>
						  </thead>   
						  <tbody>
							<?php
								if($sql->rowCount() > 0)
								{
									$ctr = 1; $total = 0;
									while($sql_data = $sql->fetch())
									{
										
																				
										
										$orderdate = date("M d, Y",strtotime($sql_data['od_date']));
										$ordertime = date("h:i a",strtotime($sql_data['date_added']));
										
										if($sql_data['is_open'] == 1)
										{
											$label = 'important'; $stat = 'Opened';
										}else{
											$label = 'success'; $stat = 'New';
										}

										$rby = $conn->prepare("SELECT * FROM bs_user WHERE user_id = '$sql_data[user_id]'");
										$rby->execute();
										
										if($rby->rowCount() > 0)
										{ 
											$rby_data = $rby->fetch();
											$released_by = utf8_encode(ucwords(strtolower($rby_data['lastname']))) . ',&nbsp;' . ucwords(strtolower($rby_data['firstname'])); 
										}else{ $released_by = '- -'; }
										
										$cust = $conn->prepare("SELECT * FROM bs_customer WHERE cust_id = '$sql_data[cust_id]'");
										$cust->execute();
										
										if($cust->rowCount() > 0)
										{ 
											$cust_data = $cust->fetch();
											$customer = utf8_encode(ucwords(strtolower($cust_data['client_name']))); 
										}else{ $customer = '- -'; }
																				
							?>
										<!-- Start display list of transactions !-->
										<tr>	
											<td style="display:none;"><?php echo $ctr++; ?></td>
											<td><?php echo $sql_data['tr_id']; ?><br /><span class="label label-<?php echo $label; ?>"><?php echo $stat; ?></span>&nbsp; &nbsp;<?php echo $released_by; ?></td>
											<td><font color="#999900"><b><?php echo $customer; ?></b></font><br /><?php echo $orderdate; ?> | <?php echo $ordertime; ?></td>											
											<td>
												Php <?php echo number_format($sql_data['amount_due'], 2); ?>
												<br />
												<span class="blue" style="font-size:14px; font-weight:bold;">
													<?php if($sql_data['is_paid'] == '1'){ echo 'Paid'; }else{ echo 'Pending'; } ?>
												</span>
											</td>
											<td class="center">												
												<a class="btn btn-info" href="javascript:detail(<?php echo $sql_data['tr_id']; ?>);" title="View">
													<i class="icon-edit icon-white icon-eye-open"></i>
												</a>											
												<a class="btn btn-danger" href="javascript:del(<?php echo $sql_data['tr_id']; ?>);" title="Delete">
													<i class="icon-trash icon-white"></i> 
												</a>																						
											</td>
										</tr>
										<!-- End display list of transactions !-->
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
						