<?php
if (!defined('WEB_ROOT')) {
	exit;
}

	$userId = $_SESSION['user_id'];
	$us = $conn->prepare("SELECT * FROM bs_user WHERE user_id = '$userId'");
	$us->execute();
	$us_data = $us->fetch();
	$accesslevel = $us_data['access_level'];	
	
	$reportId = $_GET['id']; // Get report id
	# Get report details from db
	$sql = $conn->prepare("SELECT * FROM bs_report WHERE report_id = '$reportId'");
	$sql->execute();
	$sql_data = $sql->fetch();
	

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;'
?>		
		<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-calendar"></i> Search Date</h2>
					</div>
										
					<div class="box-content">
					<form class="form-horizontal" method="post" action="<?php echo $sql_data['page']; ?>.php" target=_new name="frm" id="frm">							
						<fieldset>
						<i class="icon icon-green icon-bullet-on"></i> <b>Report - <?php echo $sql_data['name']; ?></b><br /><br />
						<?php if($accesslevel == 3){}else{ ?>
							<?php if($reportId == 1015){ ?>
							<div class="control-group">
								<label class="control-label" for="date01"></label>
								<div class="controls">
									<input type="hidden" class="input-xlarge" id="per" name="per" value="0" required autocomplete=off style="width:40px;" />										
								</div>
							</div>
							<?php }else{} ?>
						<?php } ?>
							<div class="control-group">
								<label class="control-label" for="selectError">Customer</label>
								<div class="controls">
								  <select id="selectError" name="customer" data-rel="chosen">
									<?php if($reportId != 1001 && $reportId != 1020){ ?>
										<option value="0">All</option>
									<?php }else{} ?>
										<?php
											$cus = $conn->prepare("SELECT * FROM bs_customer WHERE is_deleted != '1'");
											$cus->execute();												
											while($cus_data = $cus->fetch())
											{
												
										?>
												<option value="<?php echo $cus_data['cust_id']; ?>"><?php echo $cus_data['client_name']; ?></option>
										<?php
											} // End While
										?>
								  </select>
								</div>
							</div>
							<?php if($reportId == 1013){ ?>
								<div class="control-group">
									<label class="control-label" for="selectError">Agent</label>
									<div class="controls">
									  <select id="selectError1" name="agent" data-rel="chosen">
										<option value="0">All</option>
											<?php
												$agt = $conn->prepare("SELECT * FROM bs_user WHERE is_deleted != '1'");
												$agt->execute();												
												while($agt_data = $agt->fetch())
												{
													
											?>
													<option value="<?php echo $agt_data['user_id']; ?>"><?php echo $agt_data['firstname']; ?> <?php echo $agt_data['lastname']; ?></option>
											<?php
												} // End While
											?>
									  </select>
									</div>
								</div>
								
								<div class="control-group">
									<label class="control-label" for="selectError">Van No.</label>
									<div class="controls">
									  <select id="selectError7" name="van" data-rel="chosen">
										<option value="0">All</option>
											<option value="1">1</option>
											<option value="2">2</option>
									  </select>
									</div>
								</div>
								
							<?php }else{} ?>
							<?php if($reportId != 1014){ ?>
								<div class="control-group">
									<label class="control-label" for="date01">From</label>
									<div class="controls">
										<input type="text" class="input-xlarge" id="txtFromDate" name="from" onkeypress="return isNumberKey(event)" required autocomplete=off />										
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="date01">To</label>
									<div class="controls">
										<input type="text" class="input-xlarge" id="txtToDate" name="to" onkeypress="return isNumberKey(event)" required autocomplete=off />										
									</div>
								</div>
								
								<?php if($reportId == '1020'){ ?>
									<div class="control-group" style="display:none;">
										<label class="control-label" for="date01">Graph Type</label>
										<div class="controls">
										  <label class="radio">
											<input type="radio" class="graph_type" name="top" id="optionsRadios1" value="1" checked="" />
											Bar
										  </label>									  
										</div>
									</div>
									<div class="control-group">
										<label class="control-label" for="date01">Report Type</label>
										<div class="controls">
										  <label class="radio">
											<input type="radio" class="graph_type" name="rty" id="optionsRadios2" value="1" checked="" />
											Sales
										  </label>
										  &nbsp;
										  <label class="radio">
											<input type="radio" class="graph_type" name="rty" id="optionsRadios3" value="2" />
											Quantity
										  </label>
										</div>
									</div>
								<?php }else{} ?>
								
							<?php }else{} ?>
						</fieldset>					
							<div class="form-actions">
								<input type="hidden" name="reportId" value="<?php echo $sql_data['report_id']; ?>" />
								<button type="submit" class="btn btn-success">Submit</button>								
							</div>							
					</form>							
					</div>
					
				</div>
		</div><!--/span-->
		