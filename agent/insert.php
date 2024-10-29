<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';
require_once '../global-library/product-functions.php';
require_once '../global-library/cart-functions.php';

checkUser();

$userId = $_SESSION['user_id'];

$product = getProductDetail($pdId);
	
// we have $pd_name, $pd_price, $pd_description, $pd_image, $cart_url
//extract($product);

	$sql = $conn->prepare("SELECT *
			FROM bs_item
			WHERE item_id = '$pdId' AND is_deleted != '1'");
	
	$sql->execute();
	
	if($sql->rowCount() > 0)
	{
		$sid = session_id();
		$sql_data = $sql->fetch();
		$prodId = $sql_data['item_id'];
		$price = $sql_data['price'];
						
		# Format Date/Time
		date_default_timezone_set("Asia/Manila");
		$today_date1 = date("Y-m-d H:i:s");
		$today_date2 = date("Y-m-d");
		
		# Item Type
		if($itemType == 1){ $type_item = 'r'; }
		else if($itemType == 2){ $type_item = 's'; }
		else{ $type_item = 'b'; }
		
		// check if the product is already
		// in cart table for this session
		$sql2 = $conn->prepare("SELECT item_id, item_type
				FROM tbl_cart
				WHERE item_id = '$prodId' AND item_type = '$type_item' AND user_id = '$userId'");
		$sql2->execute();
		
		if ($sql2->rowCount() == 0) {			
			// get the ct id
			$ctId = $conn->lastInsertId();						
			
			// put the product in cart table
			$sql3 = $conn->prepare("INSERT INTO tbl_cart (item_id, cust_id, ct_qty, price, item_type, ct_date, user_id)
					VALUES ($prodId, '$custId', 1, '$price', '$type_item', '$today_date1', '$userId')");
			$sql3->execute();
			
		} else {			
		
			// update product quantity in cart table
			$sql4 = $conn->prepare("UPDATE tbl_cart 
					SET ct_qty = ct_qty + 1
					WHERE item_id = $prodId AND item_type = '$type_item' AND user_id = '$userId'");						
			$sql4->execute();
			
		}	
		
		// an extra job for us here is to remove abandoned carts.
		// right now the best option is to call this function here
		deleteAbandonedCart();
		
		//header('Location: ' . $_SESSION['shop_return_url']);	

	}else{}
	
?>