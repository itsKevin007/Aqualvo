<?php
if (!defined('WEB_ROOT')) {
	exit;
}
	// Start check user access level
	$userId = $_SESSION['user_id'];
	$ac = $conn->prepare("SELECT * FROM bs_user WHERE user_id = '$userId'");
	$ac->execute();
	$ac_data = $ac->fetch();
	$access = $ac_data['access_level'];
	
	if($access != '1')
	{ $op = 'readonly'; }else{ $op = 'required'; }
	// End check user access level

	// make sure a id exists
	if (isset($_GET['id']) && $_GET['id'] > 0) {
		$id = $_GET['id'];
	} else {
	// redirect to index.php if id is not present
		header('Location: index.php');
	}
	
	/* Select book from database */
	$sql = $conn->prepare("SELECT * FROM bs_user WHERE user_id = '$id' AND is_deleted != '1'");
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
									<div class="valid_box">
										<b><?php echo $errorMessage; ?></b>
									</div>
							<?php
								}else{}
							?>
							<fieldset>
							  <div class="control-group">
								<label class="control-label" for="focusedInput">First Name</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="firstname" name="firstname" type="text" value="<?php echo $sql_data['firstname']; ?>" <?php echo $op; ?> />
								  <div id="status"></div>
								</div>
							  </div>							  							 
							  
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Last Name</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="lastname" name="lastname" type="text" value="<?php echo $sql_data['lastname']; ?>" <?php echo $op; ?> />
								  <div id="status"></div>
								</div>
							  </div>
							  
							  <div class="control-group">
								<label class="control-label" for="focusedInput">User Name</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="username" name="username" type="text" value="<?php echo $sql_data['username']; ?>" <?php echo $op; ?> />
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
							  <div class="control-group">
								<label class="control-label" for="fileInput">User Type</label>
								<div class="controls">
								  <label class="radio">
									<input type="radio" class="user_type" name="top" id="optionsRadios1" value="o">
									Office
								  </label>
								  
								  <label class="radio">
									<input type="radio" class="user_type" name="top" id="optionsRadios2" value="a" checked="">
									Agent
								  </label>								
								</div>
							  </div>							  
							
							<hr /><b>Access Level</b><br />
							  
							  <div class="control-group" id="cust" style="display:none">
								<label class="control-label" for="selectError3">Customer</label>
									<div class="controls">
										<select name="cust" id="selectError3">
											<?php if($ac_data['is_customer_access'] == '1'){?>
												<option value="1" selected>Yes</option>
												<option value="0">No</option>
											<?php }else if($ac_data['is_customer_access'] == '0'){?>
												<option value="1">Yes</option>
												<option value="0" selected>No</option>
											<?php }else{?>
												<option value="1">Yes</option>
												<option value="0">No</option>
											<?php } ?>
										</select>
									</div>
							  </div>
							
							  <div class="control-group" id="sched" style="display:none">
								<label class="control-label" for="selectError3">Schedule</label>
									<div class="controls">
										<select name="sched" id="selectError3">
											<?php if($ac_data['is_schedule_access'] == '1'){?>
												<option value="1" selected>Yes</option>
												<option value="0">No</option>
											<?php }else if($ac_data['is_schedule_access'] == '0'){?>
												<option value="1">Yes</option>
												<option value="0" selected>No</option>
											<?php }else{?>
												<option value="1">Yes</option>
												<option value="0">No</option>
											<?php } ?>
										</select>
									</div>
							  </div>
							  
							  <div class="control-group" id="prod" style="display:none">
								<label class="control-label" for="selectError3">Product</label>
									<div class="controls">
										<select name="prod" id="selectError3">
											<?php if($ac_data['is_product_access'] == '1'){?>
												<option value="1" selected>Yes</option>
												<option value="0">No</option>
											<?php }else if($ac_data['is_product_access'] == '0'){?>
												<option value="1">Yes</option>
												<option value="0" selected>No</option>
											<?php }else{?>
												<option value="1">Yes</option>
												<option value="0">No</option>
											<?php } ?>
										</select>
									</div>
							  </div>
							  
							  <div class="control-group" id="trans" style="display:none">
								<label class="control-label" for="selectError3">Transaction</label>
									<div class="controls">
										<select name="trans" id="selectError3">
											<?php if($ac_data['is_transaction_access'] == '1'){?>
												<option value="1" selected>Yes</option>
												<option value="0">No</option>
											<?php }else if($ac_data['is_transaction_access'] == '0'){?>
												<option value="1">Yes</option>
												<option value="0" selected>No</option>
											<?php }else{?>
												<option value="1">Yes</option>
												<option value="0">No</option>
											<?php } ?>
										</select>
									</div>
							  </div>
							  
							  <div class="control-group" id="return" style="display:none">
								<label class="control-label" for="selectError3">Return</label>
									<div class="controls">
										<select name="return" id="selectError3">
											<?php if($ac_data['is_return_access'] == '1'){?>
												<option value="1" selected>Yes</option>
												<option value="0">No</option>
											<?php }else if($ac_data['is_return_access'] == '0'){?>
												<option value="1">Yes</option>
												<option value="0" selected>No</option>
											<?php }else{?>
												<option value="1">Yes</option>
												<option value="0">No</option>
											<?php } ?>
										</select>
									</div>
							  </div>
							  							 
							  <div class="control-group" id="rep" style="display:none">
								<label class="control-label" for="selectError3">Reports</label>
									<div class="controls">
										<select name="rep" id="selectError3">
											<?php if($ac_data['is_report_access'] == '1'){?>
												<option value="1" selected>Yes</option>
												<option value="0">No</option>
											<?php }else if($ac_data['is_report_access'] == '0'){?>
												<option value="1">Yes</option>
												<option value="0" selected>No</option>
											<?php }else{?>
												<option value="1">Yes</option>
												<option value="0">No</option>
											<?php } ?>
										</select>
									</div>
							  </div>
							  
							  <div class="control-group" id="user" style="display:none">
								<label class="control-label" for="selectError3">User</label>
									<div class="controls">
										<select name="user" id="selectError3">
											<?php if($ac_data['is_user_access'] == '1'){?>
												<option value="1" selected>Yes</option>
												<option value="0">No</option>
											<?php }else if($ac_data['is_user_access'] == '0'){?>
												<option value="1">Yes</option>
												<option value="0" selected>No</option>
											<?php }else{?>
												<option value="1">Yes</option>
												<option value="0">No</option>
											<?php } ?>
										</select>
									</div>
							  </div>
							  
							</fieldset>
					</div>
							<div class="form-actions">
								<input type="hidden" name="id" value="<?php echo $sql_data['user_id']; ?>" />
								<button type="submit" class="btn btn-success">Save Changes</button>
								<!-- Cancel link for user should be on the homepage !-->
								<?php if($access != "1") { ?>
									<input type="button" value="Cancel" onclick="window.location.href='../index.php'" class="btn btn-danger" />
								<?php }else{ ?>
									<input type="button" value="Cancel" onclick="window.location.href='index.php'" class="btn btn-danger" />
								<?php } ?>
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
									<a class="btn btn-danger" href="javascript:delimg(<?php echo $user_data['user_id']; ?>);"><i class="icon-trash icon-white"></i> Delete Image</a>
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

<script type="text/javascript">

	$(".user_type").click(function(){


		var value_checked = $(this).val();
		
		// Customer
		if(value_checked == "a"){
			$("#cust").hide();
		}
		else{
			$("#cust").show();
		}
		// Schedule
		if(value_checked == "a"){
			$("#sched").hide();
		}
		else{
			$("#sched").show();
		}
		// Product
		if(value_checked == "a"){
			$("#prod").hide();
		}
		else{
			$("#prod").show();
		}
		// Transaction
		if(value_checked == "a"){
			$("#trans").hide();
		}
		else{
			$("#trans").show();
		}
		
		// Return
		if(value_checked == "a"){
			$("#return").hide();
		}
		else{
			$("#return").show();
		}
		
		// Report
		if(value_checked == "a"){
			$("#rep").hide();
		}
		else{
			$("#rep").show();
		}
		
		// User
		if(value_checked == "a"){
			$("#user").hide();
		}
		else{
			$("#user").show();
		}
});

</script>		
			