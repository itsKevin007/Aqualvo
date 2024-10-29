<?php
if (!defined('WEB_ROOT')) {
	exit;
}
	
	$id = $_GET['id'];
	$o = $_GET['o'];
	
	$sql = $conn->prepare("SELECT * FROM bs_customer WHERE cust_id = '$id' AND is_deleted != '1'");
	$sql->execute();
	$sql_data = $sql->fetch();


$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;'
?>


		<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-plus-sign"></i> Add Payment</h2>												
					</div>
					
					<form class="form-horizontal" method="post" action="processPayment.php" enctype="multipart/form-data" name="form" id="form">
					<div class="box-content">
							<?php
								if($errorMessage == 'Saved successfully')
								{
							?>
									<div class="valid_box">
										<b><?php echo $errorMessage; ?></b>
									</div>
							<?php
								}
								else if($errorMessage == 'Customer already exist')
								{
							?>
									<div class="error_box">
										<b><?php echo $errorMessage; ?></b>
									</div>
							<?php								
								}else{}
							?>
							<fieldset>
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Customer Name</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="cname" name="cname" type="text" value="<?php echo $sql_data['client_name']; ?>" readonly autocomplete=off />
								  <div id="status"></div>
								</div>
							  </div>
								
							  <div class="control-group">
								<label class="control-label" for="focusedInput">SOA Number</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="soan" name="soan" type="text" autocomplete=off />
								  <div id="status"></div>
								</div>
							  </div>
							  
							  <div class="control-group">
								<label class="control-label" for="focusedInput">OR Number</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="or" name="or" type="text" required autocomplete=off />
								  <div id="status"></div>
								</div>
							  </div>
							  
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Amount</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="amt" name="amt" type="text" onKeyUp="checkNumber(this);" required autocomplete=off />
								  <div id="status"></div>
								</div>
							  </div>
							  
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Detail</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="det" name="det" type="text" autocomplete=off />
								  <div id="status"></div>
								</div>
							  </div>
							  <div class="control-group">
									<label class="control-label" for="date01">Date Paid</label>
									<div class="controls">
										<input type="text" class="input-xlarge" id="txtFromDate" name="from" onkeypress="return isNumberKey(event)" required autocomplete=off />										
									</div>
							  </div>

							  <div class="control-group">
								<label class="control-label" for="selectError">DR No.</label>
								<div class="controls">
								  <select class="input-xlarge" id="selectError" multiple name="dr[]" data-rel="chosen">									
									<?php
										$vio = $conn->prepare("SELECT * FROM tr_transaction
														WHERE cust_id = '$id' AND payment_mode = 'DR' AND is_deleted != '1' AND is_paid != '1'");
										$vio->execute();
									
										if($vio->rowCount() > 0)
										{
											while($vio_data = $vio->fetch())
											{
												
									?>
												<option value="<?php echo $vio_data['tr_id']; ?>"><?php echo $vio_data['dr']; ?></option>
									<?php
											}
										}
										else
										{
												echo "No data yet!";
										}
									?>
								  </select>
								</div>
							  </div>
							</fieldset>
					</div>
							<div class="form-actions">
								<input type="hidden" name="id" value="<?php echo $id; ?>" />
								<input type="hidden" name="o" value="<?php echo $o; ?>" />
								<button type="submit" class="btn btn-success">Save</button>
								<?php if($o == 1){ ?>
									<input type="button" value="Cancel" onclick="window.location.href='index.php'" class="btn btn-danger">
								<?php }else{ ?>
									<input type="button" value="Cancel" onclick="window.location.href='../index.php'" class="btn btn-danger">
								<?php } ?>
							</div>							
					</form>
					
					</div>
				</div><!--/span-->
			
		</div><!--/row-->		