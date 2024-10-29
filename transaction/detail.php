<?php
if (!defined('WEB_ROOT')) {
	exit;
}

if (!isset($_GET['oid']) || (int)$_GET['oid'] <= 0) {
	header('Location: index.php');
}

$orderId = $_GET['oid'];

	// Update is_open is order has been viewed or opened
	$up = $conn->prepare("UPDATE tr_transaction SET is_open = '1' WHERE tr_id = '$orderId'");
	$up->execute();
	
$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;';
	
?>		
		<form action="process.php?action=saveorder" method="post" name="frmCart" id="frmCart">
			<div class="box span8">
				<div class="box-header well" data-original-title>
					<h2><i class="icon-hdd"></i> Item Details</h2>
				</div>
									
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
						else if($errorMessage == 'Deleted successfully')
						{
					?>
							<div class="valid_box">
								<b><?php echo $errorMessage; ?></b>
							</div>
					<?php
						}else{}
					
						$sql = $conn->prepare("SELECT * FROM bs_customer c, tr_transaction t, bs_item i, tr_transaction_detail td
									WHERE c.cust_id = t.cust_id AND t.tr_id = td.tr_id AND td.item_id = i.item_id AND t.tr_id = '$orderId'
										AND td.is_deleted != '1'");
						$sql->execute();
						
						if ($sql->rowCount() > 0) 
						{
					?>
							<div class="cart_details"> <?php echo $sql->rowCount(); ?> item(s)</div>
							<br />						
							<table border="0" width="100%">
							<tr>
								<td width="30px;" align="center"><b>Delete</b></td>
								<td width="10px;">&nbsp;</td>
								<td width="30px;" align="center"><b>#</b></td>
								<td width="10px;">&nbsp;</td>
								<td width="40px;"><b>Type</b></td>
								<td width="10px;">&nbsp;</td>
								<td width="130px;"><b>Item</b></td>
								<td width="10px;">&nbsp;</td>
								<td width="70px;"><b>Price</b></td>
								<td width="10px;">&nbsp;</td>
								<td width="20px;" align="center"><b>Qty</b></td>
								<td width="10px;">&nbsp;</td>
								<td width="20px;" align="center"><b>Emptys</b></td>
								<td width="10px;">&nbsp;</td>
								<td width="100px;"><b>Sub-Total</b></td>
								<?php if($sql_data['is_edit_price_access'] == 1){ ?><td width="100px;"><b>Edit</b></td><?php }else{} ?>
							</tr>
									<?php
											$subTotal = 0; $total = 0; $ctr = 1;
											while($sql_data = $sql->fetch())
											{
												
																								
												$subTotal = $sql_data['price'] * $sql_data['tr_qty'];
												$total += $sql_data['price'] * $sql_data['tr_qty'];																								
												
												//$orderdate = date("M d, Y | h:i a",strtotime($sql_data['od_date']));
												
												# Item Type
												if($sql_data['item_type'] == 'r'){ $sql_data['type_item'] = "<button class='btn btn-mini btn-info'>Round</button>"; }
												else if($sql_data['item_type'] == 's'){ $sql_data['type_item'] = "<button class='btn btn-mini btn-warning'>Slim</button>"; }
												else{ $sql_data['type_item'] = "<button class='btn btn-mini btn-success'>Bottle</button>"; }
									?>				
											  <tr>
												<td width="30" align="center">
													<a href="javascript:delitem(<?php echo $sql_data['trd_id']; ?>);"><i class="icon-trash"></i></a>
												</td>
												<td width="10px;">&nbsp;</td>
												<td width="30" align="center"><?php echo $ctr++; ?>.</td>
												<td width="10px;">&nbsp;</td>
												<td><?php echo $sql_data['type_item']; ?></td>
												<td width="10px;">&nbsp;</td>
												<td><span class="border_cart"></span><?php echo $sql_data['name']; ?></td>
												<td width="10px;">&nbsp;</td>
												<td><span class="border_cart"></span>Php <?php echo number_format($sql_data['price'], 2); ?></td>
												<td width="10px;">&nbsp;</td>
												<td align="center"><?php echo $sql_data['tr_qty']; ?></td>
												<td width="10px;">&nbsp;</td>
												<td align="center"><?php echo $sql_data['emptys']; ?></td>
												<td width="10px;">&nbsp;</td>
												<td><span class="border_cart"></span>Php <?php echo number_format($subTotal, 2); ?></td>
												<?php if($user_data['is_edit_price_access'] == 1){ ?><td><a class="btn btn-info nyroModal" href="edit_price.php?id=<?php echo $sql_data['trd_id']; ?>&oid=<?php echo $orderId; ?>"><i class="icon-edit icon-white"></i></a></td><?php }else{} ?>
											  </tr>
									<?php
											} // End For
											
									?>
							<tr>
								<td colspan="15">
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
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td><span class="border_cart"></span>Total:</td>
								<td></td>								
								<td><span class="border_cart"></span>Php <?php echo number_format($total, 2); ?></td>
							</tr>							
							</table>							
							
					<?php
						}else{ echo "Transaction Is Empty"; } 
					?>
				</div>
			</div>			
			<div class="box span4">
				<div class="box-header well" data-original-title>
					<h2><i class="icon-file"></i> Transaction Details</h2>
				</div>
					<?php					
						$sql1 = $conn->prepare("SELECT * FROM bs_customer c, tr_transaction t, bs_item i, tr_transaction_detail td
									WHERE c.cust_id = t.cust_id AND t.tr_id = td.tr_id AND td.item_id = i.item_id AND t.tr_id = '$orderId'
										AND td.is_deleted != '1'");
						$sql1->execute();
						$sql1_data = $sql1->fetch();	

						$orderdate = date("M d, Y | h:i a",strtotime($sql1_data['od_date']));
					?>				
				<div class="box-content">					
					<table class="table table-striped table-bordered">
						<tr> 
							<td width="150">Transaction No.</td>
							<td><?php echo $sql1_data['tr_id']; ?></td>
						</tr>
						<tr> 
							<td width="150">Customer</td>
							<td><?php echo $sql1_data['client_name']; ?></td>
						</tr>
						<tr> 
							<td width="150"><span class="black" style="font-size:11px; font-weight:bold;">Order Date</span></td>
							<td><span class="black" style="font-size:11px; font-weight:bold;"><?php echo $orderdate; ?></span></td>
						</tr>
						<tr> 
							<td width="150"><span class="blue" style="font-size:14px; font-weight:bold;">Amount Due</span></td>
							<td><span class="blue" style="font-size:14px; font-weight:bold;">Php <?php echo number_format($sql1_data['amount_due'], 2); ?></span></td>
						</tr>												
						<tr> 
							<td width="150"><span class="green" style="font-size:14px; font-weight:bold;">Payment</span></td>
							<td><span class="green" style="font-size:14px; font-weight:bold;">Php <?php echo number_format($sql1_data['payment'], 2); ?></span></td>
						</tr>
						<tr> 
							<td width="150"><span class="red" style="font-size:14px; font-weight:bold;">Change</span></td>
							<td><span class="red" style="font-size:14px; font-weight:bold;">Php <?php echo number_format($sql1_data['od_change'], 2); ?></span></td>
						</tr>
						<tr>
							<td width="150"><span class="blue" style="font-size:14px; font-weight:bold;">Payment Mode</span></td>
							<td><span class="blue" style="font-size:14px; font-weight:bold;"><?php echo $sql1_data['payment_mode']; ?></span></td>							
						</tr>
						<tr>
							<td width="150"><span class="blue" style="font-size:14px; font-weight:bold;">OR</span></td>
							<td><span class="blue" style="font-size:14px; font-weight:bold;"><?php echo $sql1_data['cr']; ?></span></td>							
						</tr>	
						<tr>
							<td width="150"><span class="blue" style="font-size:14px; font-weight:bold;">DR</span></td>
							<td><span class="blue" style="font-size:14px; font-weight:bold;"><?php echo $sql1_data['dr']; ?></span></td>							
						</tr>	
						<tr>
							<td width="150"><span class="blue" style="font-size:14px; font-weight:bold;">DA</span></td>
							<td><span class="blue" style="font-size:14px; font-weight:bold;"><?php echo $sql1_data['da']; ?></span></td>							
						</tr>
						<tr>
							<td width="150"><span class="blue" style="font-size:14px; font-weight:bold;">Bank</span></td>
							<td><span class="blue" style="font-size:14px; font-weight:bold;"><?php echo $sql1_data['bank']; ?></span></td>							
						</tr>
						<tr>
							<td width="150"><span class="blue" style="font-size:14px; font-weight:bold;">Check No.</span></td>
							<td><span class="blue" style="font-size:14px; font-weight:bold;"><?php echo $sql1_data['check_number']; ?></span></td>							
						</tr>
						<tr>
							<td width="150"><span class="blue" style="font-size:14px; font-weight:bold;">Status</span></td>
							<td>
								<span class="blue" style="font-size:14px; font-weight:bold;">
									<?php if($sql1_data['is_paid'] == '1'){ echo 'Paid'; }else{ echo 'Pending'; } ?>
								</span>
							</td>
						</tr>
						<tr>							
							<td colspan="2">
								<input name="btnBack" type="button" id="btnBack" value="Go Back" onClick="window.location.href='index.php?view=list'" class="btn btn-small">
								<!--&nbsp;
								<a class="btn btn-success" href="<?php echo WEB_ROOT; ?>gate/print.php?oid=<?php echo $orderId; ?>">
									<i class="icon-print icon-white"></i> 
									Print
								</a>!-->
								<a href="#" class="btn btn-info btn-setting">Modify</a>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</form>
		
	<div class="modal hide fade" id="myModal">
		<form class="form-horizontal" method="post" action="processModify.php" enctype="multipart/form-data" name="form" id="form">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">X</button>
				<h3>Modify Transaction</h3>
			</div>
			<div class="modal-body">
				<div class="control-group">
				<label class="control-label" for="focusedInput">Date</label>
					<div class="controls">
					  <input type="text" class="input-xlarge" id="txtFromDate" name="from" onkeypress="return isNumberKey(event)" value="<?php echo $sql1_data['od_date_1']; ?>" required autocomplete=off />
					  <div id="status"></div>
					</div>
			    </div>
				<div class="control-group">
				<label class="control-label" for="focusedInput">DR</label>
					<div class="controls">
					  <input class="input-xlarge focused" id="dr" name="dr" type="text" value="<?php echo $sql1_data['dr']; ?>" autocomplete=off />
					  <div id="status"></div>
					</div>
			    </div>
				<div class="control-group">
				<label class="control-label" for="focusedInput">OR</label>
					<div class="controls">
					  <input class="input-xlarge focused" id="or" name="or" type="text" value="<?php echo $sql1_data['cr']; ?>" autocomplete=off />
					  <div id="status"></div>
					</div>
			    </div>
				<div class="control-group">
				<label class="control-label" for="focusedInput">DA</label>
					<div class="controls">
					  <input class="input-xlarge focused" id="da" name="da" type="text" value="<?php echo $sql1_data['da']; ?>" autocomplete=off />
					  <div id="status"></div>
					</div>
			    </div>
				<div class="control-group">
				<label class="control-label" for="focusedInput">Bank</label>
					<div class="controls">
					  <input class="input-xlarge focused" id="bank" name="bank" type="text" value="<?php echo $sql1_data['bank']; ?>" autocomplete=off />
					  <div id="status"></div>
					</div>
			    </div>
				<div class="control-group">
				<label class="control-label" for="focusedInput">Check No.</label>
					<div class="controls">
					  <input class="input-xlarge focused" id="checkno" name="checkno" type="text" value="<?php echo $sql1_data['check_number']; ?>" autocomplete=off />
					  <div id="status"></div>
					</div>
			    </div>
				<div class="control-group">
				<label class="control-label" for="focusedInput">Status</label>
					<div class="controls">
					  <select name="status">
						<?php
							if($sql1_data['is_paid'] == 1)
							{
								echo "<option value='1'>Paid</option>";
								echo "<option value='0'>Pending</option>";
							}else{
								echo "<option value='0'>Pending</option>";
								echo "<option value='1'>Paid</option>";
							}
						?>
					  </select>
					  <div id="status"></div>
					</div>
			    </div>
			</div>			
			<div class="modal-footer">
				<input type="hidden" name="id" value="<?php echo $orderId; ?>" />				
				<a href="#" class="btn" data-dismiss="modal">Close</a>				
				<button type="submit" class="btn btn-primary" onClick="return confirmSubmit()">Submit</button>
			</div>
		</form>
	</div>
			