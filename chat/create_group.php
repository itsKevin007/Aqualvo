<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
checkUser();

	$userId = $_SESSION['user_id'];
	
	date_default_timezone_set("Asia/Manila");
	$today_date1 = date("Y-m-d H:i:s");
	$today_date2 = date("Y-m-d");
	
	$gname = $_POST['gname'];
	
	if((isset($_POST['member'])))
	{
		$in7 = $conn->prepare("INSERT INTO chatroom (chat_name, date_created, userid, is_group) VALUES ('$gname', '$today_date1', '$userId', '1')");
		$in7->execute();
		$crId = $conn->lastInsertId();	
		
		foreach($_POST['member'] as $emp)
		{					
			$sc1 = $conn->prepare("INSERT INTO chat_member (chatroomid, userid)
						VALUES ('$crId', '$emp')");
			$sc1->execute();
		} // End For Each
	}else{}
	
	header("Location: index.php");
?>