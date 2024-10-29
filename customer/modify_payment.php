<?php
if (!defined('WEB_ROOT')) {
	exit;
}
	
	$id = $_GET['id'];
	
	$sql = $conn->prepare("SELECT * FROM tr_payment WHERE pay_id = '$id' AND is_deleted != '1'");
	$sql->execute();
	$sql_data = $sql->fetch();
	

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;'
?>


		<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-plus-sign"></i> Modify Payment</h2>												
					</div>
					
					<form class="form-horizontal" method="post" action="processModPayment.php" enctype="multipart/form-data" name="form" id="form">
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
								<label class="control-label" for="focusedInput">SOA Number</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="soan" name="soan" type="text" value="<?php echo $sql_data['soa_number']; ?>" autocomplete=off />
								  <div id="status"></div>
								</div>
							  </div>
							  
							  <div class="control-group">
								<label class="control-label" for="focusedInput">OR Number</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="or" name="or" type="text" value="<?php echo $sql_data['or_number']; ?>" required autocomplete=off />
								  <div id="status"></div>
								</div>
							  </div>
							  
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Amount</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="amt" name="amt" type="text" onKeyUp="checkNumber(this);" value="<?php echo $sql_data['amount_paid']; ?>" required autocomplete=off />
								  <div id="status"></div>
								</div>
							  </div>
							  
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Detail</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="det" name="det" type="text" value="<?php echo $sql_data['detail']; ?>" autocomplete=off />
								  <div id="status"></div>
								</div>
							  </div>
							  <div class="control-group">
									<label class="control-label" for="date01">Date Paid</label>
									<div class="controls">
										<input type="text" class="input-xlarge" id="txtFromDate" name="from" onkeypress="return isNumberKey(event)" value="<?php echo $sql_data['date_paid']; ?>" required autocomplete=off />										
									</div>
							  </div>
							
							</fieldset>
					</div>
							<div class="form-actions">
								<input type="hidden" name="id" value="<?php echo $id; ?>" />
								<button type="submit" class="btn btn-success">Save</button>
								<input type="button" value="Cancel" onclick="window.location.href='index.php'" class="btn btn-danger">
							</div>							
					</form>
					
					</div>
				</div><!--/span-->
			
		</div><!--/row-->		