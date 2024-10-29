<?php
if (!defined('WEB_ROOT')) {
	exit;
}
	

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;'
?>


		<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-plus-sign"></i> Add Inventory Salt</h2>												
					</div>
					
					<form class="form-horizontal" method="post" action="processAdd.php?action=add_salt" enctype="multipart/form-data" name="form" id="form">
					<div class="box-content">
							<?php
								if($errorMessage == 'Added successfully')
								{
							?>
									<div class="valid_box">
										<b><?php echo $errorMessage; ?></b>
									</div>
							<?php
								}
								else if($errorMessage == 'Item already exist!')
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
								<label class="control-label" for="focusedInput">Date</label>
								<div class="controls">
								  <input type="text" class="input-xlarge" id="txtFromDate" name="from" onkeypress="return isNumberKey(event)" autocomplete=off />
								  <div id="status"></div>
								</div>
							  </div>
							  
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Supplier</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="supplier" name="supplier" type="text" autocomplete=off />
								  <div id="status"></div>
								</div>
							  </div>
							  
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Inv No./WS No.</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="invno" name="invno" type="text" autocomplete=off />
								  <div id="status"></div>
								</div>
							  </div>
							  
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Unit Qty</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="uqty" name="uqty" type="text" autocomplete=off />
								  <div id="status"></div>
								</div>
							  </div>
							  
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Unit Price</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="price" name="price" type="text" autocomplete=off />
								  <div id="status"></div>
								</div>
							  </div>
							  
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Qty</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="qty" name="qty" type="text" autocomplete=off />
								  <div id="status"></div>
								</div>
							  </div>
							  
							  <div class="control-group">
								<label class="control-label" for="focusedInput">IN</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="tin" name="tin" type="text" autocomplete=off />
								  <div id="status"></div>
								</div>
							  </div>
							  
							  <div class="control-group">
								<label class="control-label" for="focusedInput">OUT</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="tout" name="tout" type="text" autocomplete=off />
								  <div id="status"></div>
								</div>
							  </div>
							  
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Received By</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="rby" name="rby" type="text" autocomplete=off />
								  <div id="status"></div>
								</div>
							  </div>
							</fieldset>
					</div>
							<div class="form-actions">
								<button type="submit" class="btn btn-success">Save</button>
								<input type="button" value="Cancel" onclick="window.location.href='index.php'" class="btn btn-danger">
							</div>							
					</form>
					
					</div>
				</div><!--/span-->
			
		</div><!--/row-->		