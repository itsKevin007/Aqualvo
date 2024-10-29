<?php
if (!defined('WEB_ROOT')) {
	exit;
}
	// Start check user access level
	$userId = $_SESSION['user_id'];	

	// make sure a id exists
	if (isset($_GET['id']) && $_GET['id'] > 0) {
		$id = $_GET['id'];
	} else {
	// redirect to index.php if id is not present
		header('Location: index.php');
	}
	
	/* Select data from database */
	$sql = $conn->prepare("SELECT * FROM bs_customer WHERE cust_id = '$id' AND is_deleted != '1'");
	$sql->execute();
	$sql_data = $sql->fetch();
	
	$custId = $sql_data['cust_id'];


$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;'

?>		
		<div class="row-fluid sortable">
				<div class="box span8">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i> Modify Customer</h2>						
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
								else if($errorMessage == 'Customer already exist')
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
								<label class="control-label" for="focusedInput">Customer Name</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="cname" name="cname" type="text" value="<?php echo $sql_data['client_name']; ?>" required autocomplete=off />
								  <div id="status"></div>
								</div>
							  </div>							  							 
							  
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Address</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="address" name="address" type="text" value="<?php echo $sql_data['address']; ?>" autocomplete=off />
								  <div id="status"></div>
								</div>
							  </div>
							  
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Contact Person</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="cp" name="cp" type="text" value="<?php echo $sql_data['contact_person']; ?>" autocomplete=off />
								  <div id="status"></div>
								</div>
							  </div>
							  
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Contact No.</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="cn" name="cn" type="text" value="<?php echo $sql_data['contactno']; ?>" autocomplete=off />
								  <div id="status"></div>
								</div>
							  </div>
							  
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Allow Acces</label>
								<div class="controls">
									<?php if($sql_data['allow_access'] == 'Yes'){ ?>
										<label class="radio">
											<input type="radio" class="allow_access" name="top" id="optionsRadios1" value="No" />No
										</label>	
										<br />
										<label class="radio">
											<input type="radio" class="allow_access" name="top" id="optionsRadios2" value="Yes" checked="" />Yes
										</label>
									<?php }else{ ?>
										<label class="radio">
											<input type="radio" class="allow_access" name="top" id="optionsRadios1" value="No" checked="" />No
										</label>	
										<br />
										<label class="radio">
											<input type="radio" class="allow_access" name="top" id="optionsRadios2" value="Yes" />Yes
										</label>
									<?php } ?>
								</div>
							  </div>
							  
							  <?php
								$ck7 = $conn->prepare("SELECT * FROM bs_user WHERE cust_id = '$custId' AND is_deleted != '1'");
								$ck7->execute();
								
								if($ck7->rowCount() > 0){
									while($ck7_data = $ck7->fetch()){
										$userName = $ck7_data['username'];
										$passWord = $ck7_data['pass_text'];
									}
								} else {
										$userName = "";
										$passWord = "";
								}
								
								if($sql_data['allow_access'] == 'Yes'){ $disp = ""; }else{ $disp = "style='display:none;'"; }
							  ?>
							  
							  <div class="control-group" id="cust_name" <?php echo $disp; ?>">
								<label class="control-label" for="focusedInput">Username</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="uname" name="uname" type="text" value="<?php echo $userName; ?>" autocomplete=off />
								  <div id="status"></div>
								</div>
							  </div>
							  
							  <div class="control-group" id="cust_name2" <?php echo $disp; ?>">
								<label class="control-label" for="focusedInput">Password</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="passwd" name="passwd" type="password" value="<?php echo $passWord; ?>" autocomplete=off />
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
								<input type="hidden" name="id" value="<?php echo $sql_data['cust_id']; ?>" />
								<button type="submit" class="btn btn-success">Save Changes</button>							
									<input type="button" value="Cancel" onclick="window.location.href='index.php'" class="btn btn-danger" />								
							</div>							
					</form>					
				</div>
				
				<div class="box span4">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-picture"></i> Picture</h2>
					</div>
										
					<div class="box-content">
						<?php
							// Display image of customer
							if ($sql_data['image']) 
							{
								$image = WEB_ROOT . 'images/customer/' . $sql_data['image'];
						?>
								<img src="<?php echo $image; ?>" />
								<br /><br />
									<a class="btn btn-danger" href="javascript:delimg(<?php echo $sql_data['cust_id']; ?>);"><i class="icon-trash icon-white"></i> Delete Image</a>
						<?php
							} else {
								$image = WEB_ROOT . 'images/customer/noimagelarge.jpg';
						?>
								<img src="<?php echo $image; ?>" />
						<?php
							}	
						?>
						
					</div>
				</div>	
				
		</div><!--/span-->								
<script type="text/javascript">

	$(".allow_access").click(function(){


		var value_checked = $(this).val();
		
		// No
		if(value_checked == "No"){
			$("#cust_name").hide();
		}
		else{
			$("#cust_name").show();
		}
		// Yes
		if(value_checked == "Yes"){
			$("#cust_name2").show();
		}
		else{
			$("#cust_name2").hide();
		}
		
});

</script>			