<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
checkUser();

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;';

	$id = $_GET['id'];
	$oid = $_GET['oid'];

	$sql = $conn->prepare("SELECT * FROM tr_transaction_detail WHERE trd_id = '$id'");
	$sql->execute();
	$sql_data = $sql->fetch();
	
?>


		<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i> Edit Price</h2>												
					</div>
					
					<form class="form-horizontal" method="post" action="processPrice.php" enctype="multipart/form-data" name="form" id="form">
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
								<label class="control-label" for="focusedInput">Price</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="price" name="price" type="text" value="<?php echo $sql_data['price']; ?>" required autocomplete=off />
								  <div id="status"></div>
								</div>
							  </div>
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Emptys</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="emptys" name="emptys" type="text" value="<?php echo $sql_data['emptys']; ?>" required autocomplete=off />
								  <div id="status"></div>
								</div>
							  </div>							  
							  							 			 
							</fieldset>
					</div>
							<div class="form-actions">
								<input type="hidden" name="id" value="<?php echo $id; ?>" />
								<input type="hidden" name="oid" value="<?php echo $oid; ?>" />
								<button type="submit" class="btn btn-success">Save</button>								
							</div>							
					</form>
					
					</div>
				</div><!--/span-->
			
		</div><!--/row-->		