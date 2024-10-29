<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
checkUser();

$sql = "SELECT * FROM bs_customer WHERE is_deleted != '1'";
$rs = dbQuery($sql);
while($rw = dbFetchAssoc($rs))
{
	extract($rw);
	
	$in = "INSERT INTO tr_inventory (cust_id) VALUES ('$cust_id')";
	dbQuery($in);
} // While
?>
	