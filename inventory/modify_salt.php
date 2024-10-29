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
	$sql = $conn->prepare("SELECT * FROM tr_inventory_salt WHERE inv_id = '$id' AND is_deleted != '1'");
	$sql->execute();
	$sql_data = $sql->fetch();
	
	$custId = $sql_data['inv_id'];


$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;'

?>		
		<div class="row-fluid sortable">
				<div class="box span8">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i> Modify Salt</h2>						
					</div>
					
					<form class="form-horizontal" method="post" enctype="multipart/form-data" action="process_salt.php?action=modify">
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
								<label class="control-label" for="focusedInput">Date</label>
								<div class="controls">
								<input class="input-xlarge focused" id="txtFromDate" name="inv_date" type="text" value="<?php echo $sql_data['inv_date']; ?>" onkeypress="return isNumberKey(event)" required autocomplete=off />
								  <div id="status"></div>
								</div>
							  </div>							  							 
							  
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Supplier</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="supplier" name="supplier" type="text" value="<?php echo $sql_data['supplier']; ?>" autocomplete=off />
								  <div id="status"></div>
								</div>
							  </div>
							  
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Inv No./WS No.</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="inv_no" name="inv_no" type="text" value="<?php echo $sql_data['inv_no']; ?>" autocomplete=off />
								  <div id="status"></div>
								</div>
							  </div>

                              <div class="control-group">
								<label class="control-label" for="focusedInput">Unit Quantity</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="unit_qty" name="unit_qty" type="text" value="<?php echo $sql_data['unit_qty']; ?>" autocomplete=off />
								  <div id="status"></div>
								</div>
							  </div>
							  
							  <div class="control-group">
								<label class="control-label" for="focusedInput">Unit Price</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="unit_price" name="unit_price" type="text" value="<?php echo $sql_data['unit_price']; ?>" autocomplete=off />
								  <div id="status"></div>
								</div>
							  </div>

                              <div class="control-group">
								<label class="control-label" for="focusedInput">Quantity</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="qty" name="qty" type="text" value="<?php echo $sql_data['qty']; ?>" autocomplete=off />
								  <div id="status"></div>
								</div>
							  </div>

                              <div class="control-group">
								<label class="control-label" for="focusedInput">IN</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="qty_in" name="qty_in" type="text" value="<?php echo $sql_data['qty_in']; ?>" autocomplete=off />
								  <div id="status"></div>
								</div>
							  </div>

                              <div class="control-group">
								<label class="control-label" for="focusedInput">OUT</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="qty_out" name="qty_out" type="text" value="<?php echo $sql_data['qty_out']; ?>" autocomplete=off />
								  <div id="status"></div>
								</div>

							  </div>
                              <div class="control-group">
								<label class="control-label" for="focusedInput">Recieved By</label>
								<div class="controls">
								  <input class="input-xlarge focused" id="received_by" name="received_by" type="text" value="<?php echo $sql_data['received_by']; ?>" autocomplete=off />
								  <div id="status"></div>
								</div>
							  </div>

							  
					</div>
							<div class="form-actions">
								<input type="hidden" name="inv_id" value="<?php echo $sql_data['inv_id']; ?>" />
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