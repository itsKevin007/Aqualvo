<?php
if (!defined('WEB_ROOT')) {
	exit;
}
	

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;'
?>


		<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-plus-sign"></i> Add User</h2>												
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
								<label class="control-label" for="focusedInput">First Name</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="firstname" name="firstname" type="text" required />
								  <div id="status"></div>
								</div>
							  </div>							  							 
							  
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Last Name</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="lastname" name="lastname" type="text" required />
								  <div id="status"></div>
								</div>
							  </div>
							  
							  <div class="control-group">
								<label class="control-label" for="focusedInput">User Name</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="username" name="username" type="text" required />
								  <div id="status"></div>
								</div>
							  </div>
							  
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Password</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="password" name="password" type="password" required />
								  <div id="status"></div>
								</div>
							  </div>
							  <div class="control-group">
								<label class="control-label" for="fileInput">Picture</label>
								<div class="controls">
									<input class="input-file uniform_on" name="fileImage" id="fileInput" type="file" />
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