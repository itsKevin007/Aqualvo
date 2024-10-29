<?php
if (!defined('WEB_ROOT')) {
	exit;
}
	

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;'
?>


		<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-plus-sign"></i> Add Item</h2>												
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
								<label class="control-label" for="focusedInput">Code</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="code" name="code" type="text" required autocomplete=off />
								  <div id="status"></div>
								</div>
							  </div>
							  
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Name</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="name" name="name" type="text" required autocomplete=off />
								  <div id="status"></div>
								</div>
							  </div>							  							 
							  
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Price</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="price" name="price" type="text" required autocomplete=off />
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