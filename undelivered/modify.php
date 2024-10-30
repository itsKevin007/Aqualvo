<?php
 include '../global-library/database.php';
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
	$sql = $conn->prepare("SELECT * FROM tr_loading WHERE load_id = '$id' AND is_deleted != '1'");
	$sql->execute();
	$sql_data = $sql->fetch();
	
	$custId = $sql_data['load_id'];


$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;'

?>		
		<div class="row-fluid sortable">
				<div class="box span8">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i> Modify Loading</h2>						
					</div>
					
					<form class="form-horizontal" method="post" enctype="multipart/form-data" action="processmodify.php?action=modify">
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
								<label class="control-label" for="focusedInput">Truck Name</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="tn" name="truckname" type="text" value="<?php echo $sql_data['truckname']; ?>" required autocomplete=off />
								  <div id="status"></div>
								</div>
							  </div>							  							 
							  
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Round</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="rdn" name="i_round" type="text" value="<?php echo $sql_data['i_round']; ?>" autocomplete=off />
								  <div id="status"></div>
								</div>
							  </div>
							  
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Slim</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="slm" name="i_slim" type="text" value="<?php echo $sql_data['i_slim']; ?>" autocomplete=off />
								  <div id="status"></div>
								</div>
							  </div>
							  
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Dispenser</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="dis" name="i_dispenser" type="text" value="<?php echo $sql_data['i_dispenser']; ?>" autocomplete=off />
								  <div id="status"></div>
								</div>
							  </div>

                              <div class="control-group">
								<label class="control-label" for="focusedInput">Trip No.</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="trip" name="trip_no" type="text" value="<?php echo $sql_data['trip_no']; ?>" autocomplete=off />
								  <div id="status"></div>
								</div>
							  </div>

							  
					</div>
							<div class="form-actions">
								<input type="hidden" name="load_id" value="<?php echo $sql_data['load_id']; ?>" />
								<button type="submit" class="btn btn-success">Save Changes</button>							
									<input type="button" value="Cancel" onclick="window.location.href='index.php'" class="btn btn-danger" />								
							</div>							
					</form>					
				</div>
						
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