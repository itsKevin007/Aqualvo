<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
checkUser();

	# Format Date/Time
	date_default_timezone_set("Asia/Manila");
	$today_date1 = date("Y-m-d H:i:s");
	$today_date2 = date("Y-m-d");

$cui = $_SESSION['chat_user_id'];

$cid7 = $_GET['ids'];

$chId = $cid7 . '-' . $cui;

	$cust = $conn->prepare("SELECT * FROM chatroom WHERE (userid = '$cui' AND userid7 = '$cid7') OR (userid = '$cid7' AND userid7 = '$cui')");
	$cust->execute();
	
	if($cust->rowCount() == 0)
	{							
		$in7 = $conn->prepare("INSERT INTO chatroom (chat_name, date_created, userid, userid7) VALUES ('$chId', '$today_date1', '$cui', '$cid7')");
		$in7->execute();
		$crId = $conn->lastInsertId();
		
		$sc1 = $conn->prepare("INSERT INTO chat_member (chatroomid, userid)
					VALUES ('$crId', '$cui')");
		$sc1->execute();
		
		$sc2 = $conn->prepare("INSERT INTO chat_member (chatroomid, userid)
					VALUES ('$crId', '$cid7')");
		$sc2->execute();							
	}else{}
	
	header('Location: index.php');
?>