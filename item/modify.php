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
	
	/* Select data from database */
	$sql = $conn->prepare("SELECT * FROM bs_item WHERE item_id = '$id' AND is_deleted != '1'");
	$sql->execute();
	$sql_data = $sql->fetch();
					

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;'

?>		
		<div class="row-fluid sortable">
				<div class="box span8">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i> Modify Item</h2>						
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
								else if($errorMessage == 'Image deleted successfully')
								{
							?>
									<div class="valid_box">
										<b><?php echo $errorMessage; ?></b>
									</div>
							<?php
								}else{}
							?>
							<fieldset>
							  
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Code</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="code" name="code" type="text" value="<?php echo $sql_data['abrv']; ?>" required autocomplete=off />
								  <div id="status"></div>
								</div>
							  </div>
							  
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Name</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="name" name="name" type="text" value="<?php echo $sql_data['name']; ?>" required autocomplete=off />
								  <div id="status"></div>
								</div>
							  </div>							  							 
							  
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Price</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="price" name="price" type="text" value="<?php echo $sql_data['price']; ?>" required autocomplete=off />
								  <div id="status"></div>
								</div>
							  </div>
							  							 
							</fieldset>
					</div>
							<div class="form-actions">
								<input type="hidden" name="id" value="<?php echo $sql_data['item_id']; ?>" />
								<button type="submit" class="btn btn-success">Save Changes</button>								
								<input type="button" value="Cancel" onclick="window.location.href='index.php'" class="btn btn-danger" />								
							</div>							
					</form>					
				</div>			
		</div><!--/span-->								
			