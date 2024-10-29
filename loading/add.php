<?php
if (!defined('WEB_ROOT')) {
	exit;
}
	

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;'
?>


		<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-plus-sign"></i> Add Truck Loading</h2>												
					</div>
					
					<form class="form-horizontal" method="post" action="processAdd.php" enctype="multipart/form-data" name="form" id="form">
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
								else if($errorMessage == 'Username already exist')
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
								<label class="control-label" for="focusedInput">Truck Name</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="tn" name="tn" type="text" required autocomplete=off />
								  <div id="status"></div>
								</div>
							  </div>							  							 
							  
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Round</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="rnd" name="rnd" type="text" required autocomplete=off />
								  <div id="status"></div>
								</div>
							  </div>
							  
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Slim</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="slm" name="slm" type="text" required autocomplete=off />
								  <div id="status"></div>
								</div>
							  </div>
							  
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Dispenser</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="dis" name="dis" type="text" required autocomplete=off />
								  <div id="status"></div>
								</div>
							  </div>
							  
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Trip No.</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="trip" name="trip" type="text" required autocomplete=off />
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