<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
checkUser();

	# Get setting details
	$sett = $conn->prepare("SELECT * FROM bs_setting");
	$sett->execute();
	$sett_data = $sett->fetch();
	

// show the error message ( if we have any )
displayError();

	date_default_timezone_set("Asia/Manila");
	$today_date1 = date("Y-m-d H:i:s");
	$today_date2 = date("m/d/Y");

	$subTotal = 0; $total = 0;	$script = '0';
	
	$userId = $_SESSION['user_id'];
	
	$cust_id = (isset($_GET['custId']) && $_GET['custId'] != '') ? $_GET['custId'] : '&nbsp;';
	
	if($userId == 1038)
	{ $read = ""; }else{ $read = "readonly"; }
	
	$ctc = $conn->prepare("SELECT *
				FROM tbl_cart ct, bs_item it
					WHERE ct.item_id = it.item_id AND user_id = '$userId'");
	$ctc->execute();
	
	while($ctc_data = $ctc->fetch())
	{
		$emptys = $ctc_data['emptys'];
		$subTotal = $ctc_data['price'] * $ctc_data['ct_qty'];
		$total += $ctc_data['price'] * $ctc_data['ct_qty'];
	} // End For
			
	$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;';
	
	//$script = 1;
?>
<head>
<title>Aqualvo</title>
<script type="text/javascript">
// Auto calculate 1. Loan Application
function startCalc1(){
 interval = setInterval("calc1()",1);
}
function calc1(){
 amtdue = document.frmCheckout.amtdue.value; // Amount Due
 payment = document.frmCheckout.payment.value; // Payment
 discount = document.frmCheckout.discount.value; // Discount
 
 var per1 = (discount * 1); // Get discount amount
 var per2 = (per1 * 1) * (amtdue * 1); // Multiply amount due to discount to get discounted amount
 var per3 = (amtdue * 1) - (per1 * 1); // Get total amount due less discount

 document.frmCheckout.dcamt.value = (per1 * 1); // Discount Amount
 document.frmCheckout.tamtd.value = (per3 * 1); // Total Amount Due less discount
 document.frmCheckout.change.value = ((payment * 1) - (per3 * 1)); // Get Change

}
function stopCalc1(){
 clearInterval(interval);
}
</script>
<!-- The styles -->
	<?php include ($_SERVER["DOCUMENT_ROOT"] . '/' . $sett_data['directory'] . '/global-library/global-css.php'); ?>	
	<!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<?php include ($_SERVER["DOCUMENT_ROOT"] . '/' . $sett_data['directory'] . '/global-library/misc-js.php'); ?>	
</head>	
<body onLoad="document.frmCheckout.payment.focus();">	
	<div class="row-fluid sortable">
			<div class="box span6">			
				<div class="box-header well" data-original-title>
					<h2><i class="icon-hdd"></i> Payment Information</h2>
				</div>
									
				<div class="box-content">
				<?php
					if($errorMessage == 'Updated successfully')
					{
				?>
						<div class="valid_box">
							<b><?php echo $errorMessage; ?></b>
						</div>
				<?php
					}
					else if($errorMessage == 'Input qty greater than qty order! Data entry failed.')
					{
				?>
						<div class="error_box">
							<b><?php echo $errorMessage; ?></b>
						</div>
				<?php
					}
					else if($errorMessage == 'Payment not enough!')
					{
				?>
						<div class="error_box">
							<b><?php echo $errorMessage; ?></b>
						</div>
				<?php								
					}else{}
				?>
				<form action="process.php" method="post" name="frmCheckout" id="frmCheckout">
					<table class="table table-striped table-bordered">
						<tr> 
							<td width="150"><span class="blue" style="font-size:20px; font-weight:bold;">Date</span></td>
							<td>
								<!--<input type="text" class="input-xlarge" id="txtFromDate" name="from" onkeypress="return isNumberKey(event)" readonly style="font-size:27px; font-weight:bold; height:50px;" value="<?php echo $today_date2; ?>" autocomplete=off />!-->
								<input type="text" class="input-xlarge" id="from" name="from" onkeypress="return isNumberKey(event)" <?php echo $read; ?> style="font-size:27px; font-weight:bold; height:50px;" value="<?php echo $today_date2; ?>" autocomplete=off />
							</td>
						</tr>
						<tr>
							<td width="150"><span class="blue" style="font-size:28px; font-weight:bold;">Customer</span></td>
							<td>
								<input type="hidden" name="customer" value="<?php echo $cust_id; ?>" />
									  
									<?php
										$cus7 = $conn->prepare("SELECT * FROM bs_customer WHERE cust_id = '$cust_id'");
										$cus7->execute();
										$cus7_data = $cus7->fetch();
									?>
								<span class="blue" style="font-size:27px; font-weight:bold;"><?php echo $cus7_data['client_name'];; ?></span>
							</td>
						<tr> 
							<td width="150"><span class="blue" style="font-size:28px; font-weight:bold;">Amount Due</span></td>
							<td>
								<span class="blue" style="font-size:28px; font-weight:bold;">Php <?php echo number_format($total, 2); ?></span>
								<input type="hidden" name="amtdue" id="amtdue" value="<?php echo $total; ?>" onFocus="startCalc1();" onBlur="stopCalc1();" />
							</td>
						</tr>
						
						<tr style="display:none;"> 
							<td width="150">
								<span class="blue" style="font-size:14px; font-weight:bold;">Discount</span>								
							</td>
							<td>
								<span class="blue" style="font-size:14px; font-weight:bold;">Less Php<input name="dcamt" type="text" id="dcamt" style="font-size:16px; font-weight:bold; width:70px;" readonly /></span>
								<input name="discount" type="text" id="discount" value="0" size="30" maxlength="50" onFocus="startCalc1();" onBlur="stopCalc1();" />
							</td>
						</tr>						
						<tr> 
							<td width="150"><span class="blue" style="font-size:24px; font-weight:bold;">Total Amount Due</span></td>
							<td>
								<input name="tamtd" type="text" id="tamtd" size="30" maxlength="50" style="font-size:25px; font-weight:bold; height:40px;" readonly />
							</td>
						</tr>
						<tr> 
							<td width="150"><span class="blue" style="font-size:24px; font-weight:bold;">Cash</span></td>
							<td>
								<input name="payment" type="text" id="payment" size="30" maxlength="50" style="font-size:45px; font-weight:bold; height:70px;" onFocus="startCalc1();" onBlur="stopCalc1();" autocomplete=off required />
							</td>
						</tr>
						<tr> 
							<td width="150"><span class="blue" style="font-size:24px; font-weight:bold;">Change</span></td>
							<td>
								<input name="change" type="text" id="change" size="30" maxlength="50" style="font-size:25px; font-weight:bold; height:40px;" readonly />
							</td>
						</tr>
						<tr style="display:none;"> 
							<td width="150"><span class="blue" style="font-size:14px; font-weight:bold;">Remarks</span></td>
							<td>
								<input name="remarks" type="text" id="remarks" style="font-size:13px;" autocomplete=off />
							</td>
						</tr>
						<tr style="display:none;"> 
							<td width="150"><span class="blue" style="font-size:14px; font-weight:bold;">Emptys</span></td>
							<td>
								<input name="emptys" type="text" id="emptys" style="font-size:13px;" value="<?php echo $emptys; ?>" autocomplete=off />
							</td>
						</tr>
						<tr> 
							<td width="250"><span class="blue" style="font-size:24px; font-weight:bold;">Payment Method</span></td>
							<td>
								<div class="controls">
								  <label class="radio">
									<input type="radio" class="payment_method" name="top" id="optionsRadios1" value="Cash" checked="" />
									Cash &nbsp; <input type="text" name="in_cr" placeholder="Cash Receipt" autocomplete=off />
								  </label>	
								  <br />
								  <label class="radio">
									<input type="radio" class="payment_method" name="top" id="optionsRadios1" value="DR" />
									Credit &nbsp; <input type="text" name="in_dr" placeholder="Delivery Receipt" autocomplete=off />
								  </label>
								   <br />
								  <label class="radio">
									<input type="radio" class="payment_method" name="top" id="optionsRadios1" value="DA" />
									DA &nbsp; <input type="text" name="in_da" placeholder="Delivery Acknowledgement" autocomplete=off />
								  </label>
								</div>							
							</td>
						</tr>						
						<tr>
							<td><input name="btnBack" type="button" id="btnBack" value="Go Back" onClick="window.location.href='index.php?c=<?php echo $cust_id; ?>'" class="btn btn-large btn-inverse"></td>
							<?php
								if($total != 0)
								{ $btn_status = ''; }else{ $btn_status = 'disabled'; }
								
								if(isset($_GET['ccid']) || isset($_POST['ccid']))
								{
							?>							
									<input type="hidden" name="ccid" value="<?php echo $ccid; ?>" />
							<?php }else{} ?>
							<td><input name="btnSubmit" type="submit" id="btnSubmit" value="Submit" onClick="return confirmSubmit()" class="btn btn-large btn-success" <?php echo $btn_status; ?> /></td>
						</tr>
					</table>
				</form>
				</div>			
			</div>								
			
			<div class="box span6">			
				<div class="box-header well" data-original-title>
					<h2><i class="icon-tag"></i> Items</h2>
				</div>
									
				<div class="box-content">
				<form action="process.php?action=split_payment" method="post" name="frmProduct" id="frmProduct">
					<?php
						$ctc = $conn->prepare("SELECT * FROM tbl_cart ct, bs_item it WHERE ct.item_id = it.item_id AND ct.user_id = '$userId'");		
						$ctc->execute();
						
						if ($ctc->rowCount() > 0) 
						{
					?>
							<div class="cart_details"> <?php echo $ctc->rowCount(); ?> item(s)</div>
							<br />						
							<table border="0" width="100%">
							<tr>							
								<td width="30px;" align="center"><b>#</b></td>
								<td width="10px;">&nbsp;</td>
								<td width="100px;"><b>Item</b></td>
								<td width="10px;">&nbsp;</td>
								<td width="100px;" align="center"><b>Qty</b></td>
								<td width="10px;">&nbsp;</td>
								<td width="100px;" align="left"><b>Price</b></td>
								<td width="10px;">&nbsp;</td>
								<td width="100px;"><b>Sub-Total</b></td>
							</tr>
									<?php
											$subTotal = 0; $total = 0; $ctr = 1;
											while($ctc_data = $ctc->fetch())
											{
												
												$subTotal = $ctc_data['price'] * $ctc_data['ct_qty'];
												
												$total += $subTotal;
									?>				
											  <tr>				
												<td width="30" align="center"><?php echo $ctr++; ?>.</td>
												<td width="10px;">&nbsp;</td>
												<td><span class="border_cart"></span><?php echo $ctc_data['name']; ?></td>
												<td width="10px;">&nbsp;</td>
												<td align="center"><?php echo $ctc_data['ct_qty']; ?></td>
												<td width="10px;">&nbsp;</td>
												<td><span class="border_cart"></span>Php <?php echo number_format($ctc_data['price'], 2); ?></td>												
												<td width="10px;">&nbsp;</td>
												<td><span class="border_cart"></span>Php <?php echo number_format($subTotal, 2); ?></td>												
											  </tr>
									<?php
												
											} // End For
											
									?>
							<tr>
								<td colspan="9">
									<hr style="border: 0; height: 1px; background-image: -webkit-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,0.75), rgba(0,0,0,0)); background-image: -moz-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,0.75), rgba(0,0,0,0)); background-image: -ms-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,0.75), rgba(0,0,0,0));  background-image: -o-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,0.75), rgba(0,0,0,0)); " />
								</td>
							</tr>
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td><span class="border_cart"></span>Total:</td>
								<td></td>								
								<td><span class="border_cart"></span><b>Php <?php echo number_format($total, 2); ?></b></td>
							</tr>							
							</table>							
							
					<?php
						}else{ echo "Transaction Is Empty"; } 
					?>
				</form>
				</div>			
			</div>
	</div>
	
	
<script type="text/javascript">

	$(".payment_method").click(function(){


		var value_checked = $(this).val();
		
		// Card Type
		if(value_checked == "e"){
			$("#cctype").show();
		}
		else{
			$("#cctype").hide();
		}
		// CardHolder's Name
		if(value_checked == "e"){
			$("#chname").show();
		}
		else{
			$("#chname").hide();
		}
		// Card Number
		if(value_checked == "e"){
			$("#ccnum").show();
		}
		else{
			$("#ccnum").hide();
		}
		// Expiration
		if(value_checked == "e"){
			$("#expir").show();
		}
		else{
			$("#expir").hide();
		}
		
		if(value_checked == "r"){
			$("#room_charge").show();
		}
		else{
			$("#room_charge").hide();
		}
});

$(".disc_opt").click(function(){

		var value_checked = $(this).val();
		
		// Discount Option
		if(value_checked == "dy"){
			$("#disctype").show();
		}
		else{
			$("#disctype").hide();
		}
		// Discount Name
		if(value_checked == "dy"){
			$("#discname").show();
		}
		else{
			$("#discname").hide();
		}
		// Discount Remarks
		if(value_checked == "dy"){
			$("#discrmk").show();
		}
		else{
			$("#discrmk").hide();
		}
});
</script>

<!-- Placed at the end of the document so the pages load faster -->
	<?php include ($_SERVER["DOCUMENT_ROOT"] . '/' . $sett_data['directory'] . '/global-library/global-js.php'); ?>
</body>