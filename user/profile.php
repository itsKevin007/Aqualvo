<?php
if (!defined('WEB_ROOT')) {
	exit;
}

	// make sure a id exists
	if (isset($_GET['id']) && $_GET['id'] > 0) {
		$id = $_GET['id'];
	} else {
	// redirect to index.php if id is not present
		header('Location: index.php');
	}
	
	/* Select book from database */
	$sql = $conn->prepare("SELECT * FROM bs_user WHERE id = '$id' AND status != '1'");
	$sql->execute();
	$sql_data = $sql->fetch();
					

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;'

?>		
		<div class="row-fluid sortable">
				<div class="box span8">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i> Modify User</h2>						
					</div>
					
					<form class="form-horizontal" method="post" enctype="multipart/form-data" action="processModify.php">
					<div class="box-content">
							<?php
								if($errorMessage == 'Modified successfully')
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
								}
								else if($errorMessage == 'Image deleted successfully')
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
								  <input class="input-xlarge focused" id="firstname" name="firstname" type="text" value="<?php echo $sql_data['firstname']; ?>" readonly />
								  <div id="status"></div>
								</div>
							  </div>							  							 
							  
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Last Name</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="lastname" name="lastname" type="text" value="<?php echo $sql_data['lastname']; ?>" readonly />
								  <div id="status"></div>
								</div>
							  </div>
							  
							  <div class="control-group">
								<label class="control-label" for="focusedInput">User Name</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="username" name="username" type="text" value="<?php echo $sql_data['username']; ?>" readonly />
								  <div id="status"></div>
								</div>
							  </div>
							  
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Password</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="password" name="password" type="password" value="<?php echo $sql_data['pass_text']; ?>" required />
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
								<input type="hidden" name="id" value="<?php echo $id; ?>" />
								<button type="submit" class="btn btn-success">Save Changes</button>
								<input type="button" value="Cancel" onclick="window.location.href='../index.php'" class="btn btn-danger" />
							</div>							
					</form>					
				</div>
				
				<div class="box span4">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-picture"></i> Picture</h2>						
					</div>
										
					<div class="box-content">
						<?php
							// Display image of user
							if ($sql_data['image']) 
							{
								$image = WEB_ROOT . 'images/user/' . $sql_data['image'];
						?>
								<img src="<?php echo $image; ?>" />
								<br /><br />
									<a class="btn btn-danger" href="javascript:delimg(<?php echo $id; ?>);"><i class="icon-trash icon-white"></i> Delete Image</a>
						<?php
							} else {
								$image = WEB_ROOT . 'images/user/noimagelarge.jpg';
						?>
								<img src="<?php echo $image; ?>" />
						<?php
							}	
						?>
						
					</div>
				</div>	
				
		</div><!--/span-->								
			