<?php
require_once 'config.php';

/*********************************************************
*                 PRODUCT FUNCTIONS 
**********************************************************/


/*
	Get detail information of a product
*/
function getProductDetail($pdId)
{
	include 'database.php';
	$_SESSION['shoppingReturnUrl'] = $_SERVER['REQUEST_URI'];
	
	// get the product information from database
	$sql = $conn->prepare("SELECT *
			FROM bs_item
			WHERE item_id = '$pdId'");
	
	$sql->execute();
	
	if($sql->rowCount() > 0)
	{
		$sql_data = $sql->fetch();
		
		
		$sql_data['name'] = nl2br($sql_data['name']);
		$prdId = $sql_data['item_id'];			
		
		$sql_data['cart_url'] = "cart.php?action=add&p=$prdId";
		
		return $sql_data;	
	}else{
		$prdId = 0;
		$sql_data['cart_url'] = "cart.php?action=add&p=$prdId";
		
		return $sql->rowCount();		
	}
}


?>