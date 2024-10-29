<?php
if (!defined('WEB_ROOT')) {
	exit;
}
	

$action = (isset($_GET['action']) && $_GET['action'] != '') ? $_GET['action'] : 'view';

switch ($action) {
	case 'add' :
		addToCart();
		break;
	case 'update' :
		updateCart();
		break;	
	case 'delete' :
		deleteFromCart();
		break;
	case 'view' :
}


// show the error message ( if we have any )
displayError();

	$userId = $_SESSION['user_id'];
?>
<head>
 <style rel="stylesheet" type="text/css">	
	.ctd {
		font-family: 'Calibri', sans-serif;
		font-weight:bold;
		font-size:20px;
	}
 </style>
</head>			
			<div class="box span6">
				<div class="box-header well" data-original-title>
					<h2><i class="icon-shopping-cart"></i> Content - &nbsp; Customer: &nbsp;<?php echo $client; ?></h2>
				</div>
									
				<div class="box-content">				
					<?php
						$sid = session_id();
						$ctc = $conn->prepare("SELECT *
									FROM tbl_cart ct, bs_item it
										WHERE ct.item_id = it.item_id AND ct.user_id = '$userId'");						
						$ctc->execute();
						
						if ($ctc->rowCount() > 0) 
						{
					?>
							<div class="cart_details"> <?php echo $ctc->rowCount(); ?> item(s)</div>
							<br />
							<form action="index.php?view=cart&action=update" method="post" name="frmCart" id="frmCart">
							<table border="0" width="600">
							<tr>
								<td width="30px;" align="center"><b>#</b></td>
								<td width="10px;">&nbsp;</td>
								<td width="200px;"><b>Item</b></td>
								<td width="10px;">&nbsp;</td>
								<td width="100px;" align="center"><b>Qty</b></td>
								<td width="10px;">&nbsp;</td>
								<td width="70px;" align="center"><b>Empty</b></td>
								<td width="10px;">&nbsp;</td>
								<td width="100px;" align="left"><b>Price</b></td>
								<td width="10px;">&nbsp;</td>
								<td width="10px;"><b>Sub</b></td>
								<td width="10px;">&nbsp;</td>
							</tr>
									<?php
											$subTotal = 0; $total = 0; $ctr = 1; $total_qty = 0;
											while($ctc_data = $ctc->fetch())
											{
												$subTotal = $ctc_data['price'] * $ctc_data['ct_qty'];
												
												$total += $subTotal;
												$total_qty += $ctc_data['ct_qty'];
												
												# Item Type
												if($ctc_data['item_type'] == 'r'){ $type_item = "<button class='btn btn-mini btn-info'>Round</button>"; }
												else if($ctc_data['item_type'] == 's'){ $type_item = "<button class='btn btn-mini btn-warning'>Slim</button>"; }
												else{ $type_item = "<button class='btn btn-mini btn-success'>Bottle</button>"; }
												
												$crt = $conn->prepare("SELECT * FROM tbl_cart WHERE ct_id = '$ctc_data[ct_id]'");
												$crt->execute();
												$crt_data = $crt->fetch();			
												$ctId = $crt_data['ct_id'];
																								
									?>				
											  <tr>				
												<td width="30" align="center"><?php echo $ctr++; ?>.</td>
												<td width="10px;">&nbsp;</td>
												<td class="ctd" width="110px;"><?php echo $ctc_data['name']; ?><br /><?php echo $type_item; ?></td>
												<td width="10px;">&nbsp;</td>
												<td align="center">													
													<input name="txtQty[]" type="text" id="txtQty[]" value="<?php echo number_format($ctc_data['ct_qty'], 0); ?>" class="box" style="font-size:27px; width:55px; font-weight:bold; height:50px;" autocomplete=off>
													<input name="hidCartId[]" type="hidden" value="<?php echo $ctc_data['ct_id']; ?>">
													<input name="hidProductId[]" type="hidden" value="<?php echo $ctc_data['item_id']; ?>">												
													
												</td>
												<td width="10px;">&nbsp;</td>
												<td align="center">															
													<input name="txEmp[]" type="text" id="txEmp[]" value="<?php echo number_format($ctc_data['emptys'], 0); ?>" class="box" style="font-size:27px; width:55px; font-weight:bold; height:50px;" autocomplete=off>
												</td>
												<td width="10px;">&nbsp;</td>
												<td class="ctd"><span class="border_cart"></span><?php echo number_format($ctc_data['price'], 2); ?></td>
												
												<td width="10px;">&nbsp;</td>
												<td class="ctd"><span class="border_cart"></span><?php echo number_format($subTotal, 2); ?></td>
												<td width="10px;">&nbsp;</td>
												<td width="10"><a href="index.php?view=cart&action=delete&cid=<?php echo $ctc_data['ct_id']; ?>&pid=<?php echo $ctc_data['item_id']; ?>&c=<?php echo $custId; ?>" class="btn btn-danger"><i class="icon-white icon-trash"></i></a></td>
											  </tr>
									<?php
											} // End For
									?>
											<input name="ctId" type="hidden" value="<?php echo $ctId; ?>">
											<input name="custId" type="hidden" value="<?php echo $custId; ?>">
							<tr>
								<td colspan="10">
									<hr style="border: 0; height: 1px; background-image: -webkit-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,0.75), rgba(0,0,0,0)); background-image: -moz-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,0.75), rgba(0,0,0,0)); background-image: -ms-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,0.75), rgba(0,0,0,0));  background-image: -o-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,0.75), rgba(0,0,0,0)); " />
								</td>
							</tr>							
							<tr>	
								<td><br /></td>
							</tr>
							<tr>					
								<td colspan="10" align="right">									
									<input name="btnUpdate" type="submit" id="btnUpdate" value="Update" class="btn btn-large btn-success">
								</td>
							</tr>
							<tr><td><br /></td></tr>
							</table>
							<table>
							<tr>														
								<td colspan="2"><span class="blue" style="font-size:20px; font-weight:bold;">Total:</span></td>													
								<td colspan="3"><span class="blue" style="font-size:70px; font-weight:bold;"><?php echo number_format($total, 2); ?></span></td>								
							</tr>
							</table>
							</form>
							<br />
							<?php
								$shoppingReturnUrl = isset($_SESSION['shop_return_url']) ? $_SESSION['shop_return_url'] : 'index.php';
							?>
							<table width="550" border="0" align="center" cellpadding="10" cellspacing="0">
							 <tr align="center"> 							  
								<?php 
									if ($ctc->rowCount() > 0)
									{
								?>  
										<td><a href="payment.php?custId=<?php echo $custId; ?>" title="Process Payment"><button class="btn btn-large btn-inverse">Proceed <i class="icon icon-white icon-carat-1-e"></i></button></a></td>
								<?php
									}
								?>  
							 </tr>
							</table>
							
					<?php
						}else{ echo "Transanction Is Empty"; } 
					?>
				</div>
			</div>
		