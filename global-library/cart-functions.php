<?php
require_once 'config.php';
require_once 'functions.php';

checkUser();

/*********************************************************
*                 SHOPPING CART FUNCTIONS 
*********************************************************/


/*
	Get all item in current session
	from shopping cart table
*/
function getCartContent()
{
	include 'database.php';
	$userId = $_SESSION['user_id'];
	
	$cartContent = array();

	$sid = session_id();
	$sql = $conn->prepare("SELECT *
			FROM tbl_cart ct, bs_item it
			WHERE ct.item_id = it.item_id AND ct.user_id = '$userId'");
	
	$sql->execute();
	
	while ($sql_data = $sql->fetch()) {		
		
		$cartContent[] = $sql_data;		
	}
	
	return $cartContent;
	
}

/*
	Remove an item from the cart
*/
function deleteFromCart($cartId = 0)
{
	include 'database.php';
	$userId = $_SESSION['user_id'];
	
	if (!$cartId && isset($_GET['cid']) && (int)$_GET['cid'] > 0) {
		$cartId = (int)$_GET['cid'];		
		$prdId = (int)$_GET['pid'];
	}
		

	if ($cartId) {	
			
		$sql  = $conn->prepare("DELETE FROM tbl_cart
					WHERE ct_id = $cartId");
		$sql->execute();			
	}
	
	//header('Location: index.php?view=cart');	
}

/*
	Update item quantity in shopping cart
*/
function updateCart()
{
	include 'database.php';
	$userId = $_SESSION['user_id'];
	
	$cartId     = $_POST['hidCartId'];	
	$custId     = $_POST['custId'];
	$productId  = $_POST['hidProductId'];
	$itemQty    = $_POST['txtQty'];
	$emptys    = $_POST['txEmp'];
	$numItem    = count($itemQty);
	$numEmp    = count($emptys);
	$numDeleted = 0;
	$notice     = '';
	
	$url = "index.php?c=$custId";
	
	for ($i = 0; $i < $numItem; $i++) {
		$newQty = $itemQty[$i];		
		if ($newQty < 1) {
			// remove this item from shopping cart
			deleteFromCart($cartId[$i]);	
			$numDeleted += 1;
		} else {			
								
			// update product quantity
			$sql = $conn->prepare("UPDATE tbl_cart
					SET ct_qty = $newQty, cust_id = '$custId'
					WHERE ct_id = {$cartId[$i]}");				
			$sql->execute();		
		}
	}
	
	for ($i = 0; $i < $numEmp; $i++) {
		$newEmptys = $emptys[$i];		
		if ($newEmptys < 1) {
			// remove this item from shopping cart
			deleteFromCart($cartId[$i]);	
			$numDeleted += 1;
		} else {			
								
			// update product quantity
			$sql = $conn->prepare("UPDATE tbl_cart
					SET emptys = $newEmptys, cust_id = '$custId'
					WHERE ct_id = {$cartId[$i]}");				
			$sql->execute();			
		}
	}
			
	if ($numDeleted == $numItem) {
		// if all item deleted return to the last page that
		// the customer visited before going to shopping cart
		header("Location: $returnUrl" . $_SESSION['shop_return_url']);
	} else {
		//header("Location: index.php?view=cart");
		echo "<center><h3>Processing...</h3><img src='images/loader/loader_3.gif'><center>";

		echo "<meta http-equiv=\"refresh\" content=\"1;URL=$url\">";
	}
	
	exit;
}

function isCartEmpty()
{
	include 'database.php';
	$userId = $_SESSION['user_id'];
	
	$isEmpty = false;
	
	$sid = session_id();
	$sql = $conn->prepare("SELECT ct_id
			FROM tbl_cart ct
			WHERE ct_session_id = '$sid'");
	
	$sql->execute();
	
	if ($sql->rowCount() == 0) {
		$isEmpty = true;
	}	
	
	return $isEmpty;
}

/*
	Delete all cart entries older than one day
*/
function deleteAbandonedCart()
{
	include 'database.php';
	
	$yesterday = date('Y-m-d H:i:s', mktime(0,0,0, date('m'), date('d') - 1, date('Y')));
	$sql = $conn->prepare("DELETE FROM tbl_cart
	        WHERE ct_date < '$yesterday'");
	$sql->execute();	
}

?>