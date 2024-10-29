<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

checkUser();

	date_default_timezone_set("Asia/Manila");
	$today_date1 = date("Y-m-d H:i:s");
	$today_date2 = date("Y-m-d");
	
	$userId = $_SESSION['user_id'];

	$cus = $conn->prepare("SELECT * FROM bs_user WHERE user_id = '$userId'");
	$cus->execute();
	$cus_data = $cus->fetch();
	$vnum = $cus_data['van_number'];	
	
	//$from = $_POST['from'];
	$from = $today_date1;
	$customer = $_POST['customer'];
	$amtdue = $_POST['amtdue'];	
	$tamtd = $_POST['tamtd'];
	$payment = $_POST['payment'];
	$change = $_POST['change'];
	$emptys = $_POST['emptys'];	

	$orderdate1 = date("Y-m-d h:i:s",strtotime($from));
	$orderdate2 = date("Y-m-d",strtotime($from));
	
	$top = $_POST['top'];
	
	$in_cr = $_POST['in_cr'];
	$in_dr = $_POST['in_dr'];
	$in_da = $_POST['in_da'];
	
	$chkcr = $conn->prepare("SELECT * FROM tr_transaction WHERE cr = '$in_cr' AND cr != '' AND is_deleted != '1'");	
	$chkcr->execute();
	
	
	$chkdr = $conn->prepare("SELECT * FROM tr_transaction WHERE dr = '$in_dr' AND dr != '' AND is_deleted != '1'");	
	$chkdr->execute();

	
	$chkda = $conn->prepare("SELECT * FROM tr_transaction WHERE da = '$in_da' AND da != '' AND is_deleted != '1'");	
	$chkda->execute();
	
	
	if(($chkcr->rowCount() > 0) || ($chkdr->rowCount() > 0) || ($chkda->rowCount() > 0))
	{
		echo "<center><h3>Receipt number already exist!</h3><img src='../images/loader/loader_3.gif'><center>";
			$url = "payment.php";
			echo "<meta http-equiv=\"refresh\" content=\"1;URL=$url\">";
	}
	else
	{
	
		if(($payment < $tamtd) && ($top == 'Cash'))
		{		
			echo "<center><h3>Payment not enough</h3><img src='../images/loader/loader_3.gif'><center>";
			$url = "payment.php";
			echo "<meta http-equiv=\"refresh\" content=\"1;URL=$url\">";
		}
		else if(($payment == 0) && ($top == 'Cash'))
		{		
			echo "<center><h3>Payment not enough</h3><img src='../images/loader/loader_3.gif'><center>";
			$url = "payment.php";
			echo "<meta http-equiv=\"refresh\" content=\"1;URL=$url\">";
		}else{
					
			// save order & get order id
			$sql = $conn->prepare("INSERT INTO tr_transaction (cust_id, amount_due, total_amt_due, payment, od_change, od_date, od_date_1, payment_mode, cr, dr, da, emptys, van_number, user_id, date_added)
					VALUES ('$customer', '$amtdue', '$tamtd', '$payment', '$change', '$orderdate1', '$orderdate2', '$top', '$in_cr', '$in_dr', '$in_da', '$emptys', '$vnum', '$userId', '$today_date1')");
			$sql->execute();
			
			// get the order id
			$orderId = $conn->lastInsertId();
			
			// Update Schedule
			$upsched = $conn->prepare("UPDATE tr_schedule SET is_delivered = '1' WHERE client_id = '$customer' AND dt_date = '$orderdate2'");
			$upsched->execute();

			/* START INVENTORY ADDED */
			$inv = $conn->prepare("SELECT * FROM tr_inventory WHERE cust_id = '$customer'");
			$inv->execute();
			$inv_data = $inv->fetch();		
			$round = $inv_data['round'];
			$slim = $inv_data['slim'];			
			$invcustomer = $inv_data['cust_id'];

			// ROUND
			$sq2 = $conn->prepare("SELECT *, SUM(ct_qty) as total_qty FROM tbl_cart WHERE cust_id = '$invcustomer' AND user_id = '$userId' AND item_type = 'r'");
			$sq2->execute();
			$sq2_data = $sq2->fetch();
			$r_added = $sq2_data['total_qty'];
			
			$sq4 = $conn->prepare("SELECT *, SUM(emptys) as total_empty FROM tbl_cart WHERE cust_id = '$invcustomer' AND user_id = '$userId' AND item_type = 'r'");
			$sq4->execute();
			$sq4_data = $sq4->fetch();
			$r_empty = $sq4_data['total_empty'];
			
			$round_bal1 = $round - $r_empty;
			$round_bal2 = $round_bal1 + $r_added;
			
			// SLIM
			$sq3 = $conn->prepare("SELECT *, SUM(ct_qty) as total_qty FROM tbl_cart WHERE cust_id = '$invcustomer' AND user_id = '$userId' AND item_type = 's'");
			$sq3->execute();
			$sq3_data = $sq3->fetch();
			$s_added = $sq3_data['total_qty'];
			
			$sq5 = $conn->prepare("SELECT *, SUM(emptys) as total_empty FROM tbl_cart WHERE cust_id = '$invcustomer' AND user_id = '$userId' AND item_type = 's'");
			$sq5->execute();
			$sq5_data = $sq5->fetch();
			$s_empty = $sq5_data['total_empty'];
			
			$slim_bal1 = $slim - $s_empty;
			$slim_bal2 = $slim_bal1 + $s_added;
			
			$in = $conn->prepare("INSERT INTO tr_inventory_log (od_id, cust_id, round_current, slim_current, round_added, slim_added, round_balance, slim_balance, date_added)
						VALUES ('$orderId', '$customer', '$round', '$slim', '$r_added', '$s_added', '$round_bal2', '$slim_bal2', '$today_date1')");
			$in->execute();
			
			$up2 = $conn->prepare("UPDATE tr_inventory SET round = '$round_bal2', slim = '$slim_bal2' WHERE cust_id = '$customer'");
			$up2->execute();
		/* END INVENTORY ADDED */	

			if ($orderId) {
				// save order items
				$total = 0;
				$ctc = $conn->prepare("SELECT *
							FROM tbl_cart ct, bs_item it
								WHERE ct.item_id = it.item_id AND ct.user_id = '$userId'");
				$ctc->execute();
				while($ctc_data = $ctc->fetch())
				{
					$item_id = $ctc_data['item_id'];
					$ct_qty = $ctc_data['ct_qty'];
					$price = $ctc_data['price'];
					$item_type = $ctc_data['item_type'];
					
						$sql = $conn->prepare("INSERT INTO tr_transaction_detail (tr_id, item_id, tr_qty, emptys, price, item_type)
									VALUES ('$orderId', '$item_id', '$ct_qty', '$emptys', '$price', '$item_type')");
						$sql->execute();										
														
						$sql5 = $conn->prepare("DELETE FROM tbl_cart");
						$sql5->execute();
										
				} // End While
				
			}
			echo "<center><h3>Processing...</h3><img src='../images/loader/loader_3.gif'><center>";
			//$url = "print.php?oid=$orderId";
			$url = "../index.php";
			echo "<meta http-equiv=\"refresh\" content=\"1;URL=$url\">";
		}
	}
?>