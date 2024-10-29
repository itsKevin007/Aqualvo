<?php
require_once 'config.php';

/*********************************************************
*                 CHECKOUT FUNCTIONS 
*********************************************************/
function saveOrder()
{
	include 'databse.php';
	$sqlsp = $conn->prepare("SELECT * FROM tbl_shop_config");
	$sqlsp->execute();
	$sqlsp_data = $sqlsp->fetch();
	$shipcost = $sqlsp_data['sc_shipping_cost'];
	
	$orderId       = 0;
	$shippingCost  = $shipcost;
	$requiredField = array('customer');
						   
	if (checkRequiredPost($requiredField)) {
	    extract($_POST);				
				
		$cartContent = getCartContent();
		$numItem     = count($cartContent);
		
		// save order & get order id
		$sql = $conn->prepare("INSERT INTO tbl_order(od_date, od_date_1, od_last_update, customer, od_shipping_cost)
                VALUES (NOW(), NOW(), NOW(), '$customer', '$shippingCost')");
		$sql->execute();
		
		// get the order id
		$orderId = $conn->lastInsertId();
		
		if ($orderId) {
			// save order items
			for ($i = 0; $i < $numItem; $i++) {
				$sql = $conn->prepare("INSERT INTO tbl_order_item(od_id, pd_id, od_qty)
						VALUES ($orderId, {$cartContent[$i]['pd_id']}, {$cartContent[$i]['ct_qty']})");
				$sql->execute();				
			}
		
			
			// update product stock
			for ($i = 0; $i < $numItem; $i++) {
				$sql = $conn->prepare("UPDATE tbl_product 
				        SET pd_qty = pd_qty - {$cartContent[$i]['ct_qty']}
						WHERE pd_id = {$cartContent[$i]['pd_id']}");
				$sql->execute();
			
			
			// then remove the ordered items from cart
			for ($i = 0; $i < $numItem; $i++) {
				$sql = $conn->prepare("DELETE FROM tbl_cart
				        WHERE ct_id = {$cartContent[$i]['ct_id']}");
				$sql->execute();					
			}							
		}					
	}
	
	return $orderId;
}

/*
	Get order total amount ( total purchase + shipping cost )
*/
function getOrderAmount($orderId)
{
	include 'database.php';
	$orderAmount = 0;
	
	$sql = $conn->prepare("SELECT SUM(pd_price * od_qty)
	        FROM tbl_order_item oi, tbl_product p 
		    WHERE oi.pd_id = p.pd_id and oi.od_id = $orderId
			
			UNION
			
			SELECT od_shipping_cost 
			FROM tbl_order
			WHERE od_id = $orderId");
	$sql->execute();

	if ($sql->rowCount() == 2) {
		$sql_data = $sql->fetch();
		$totalPurchase = $sql_data[0];
		
		$sql_data = $sql->fetch();
		$shippingCost = $sql_data[0];
		
		$orderAmount = $totalPurchase + $shippingCost;
	}	
	
	return $orderAmount;	
}

/*
Email : testme@phpwebcommerce.com 
Password : phpwebco
348640028
348640691
*/

?>