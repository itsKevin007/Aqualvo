<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
checkUser();

	# Item Id
	if(isset($_GET['t']))
	{
		$type = $_GET['t'];	
	}else{
		$type = '';
	}
	# Customer Id
	if(isset($_GET['c']))
	{
		$custId = $_GET['c'];	
	}else{
		$custId = '';
	}	
	
	$script = 0;
	if($type == 1){ $ty = "Round"; }else{ $ty = "Slim"; }

?>		
		<form action="process.php?action=returns" method="post" name="frmCheckout" id="frmCheckout">
			<table class="table table-striped table-bordered">
				<tr> 
					<td width="150"><span class="blue" style="font-size:20px; font-weight:bold;">Emptys - <?php echo $ty; ?></span></td>
					<td>
						<input type="text" class="input-xlarge" id="emptys" name="emptys" onkeypress="return isNumberKey(event)" required autocomplete=off />
					</td>
				</tr>
				<tr>							
					<input type="hidden" name="cid" value="<?php echo $custId; ?>" />
					<input type="hidden" name="tid" value="<?php echo $type; ?>" />
					<td><input name="btnSubmit" type="submit" id="btnSubmit" value="Submit" onClick="return confirmSubmit()" class="btn btn-large btn-success" /></td>
				</tr>
			</table>
		</form>