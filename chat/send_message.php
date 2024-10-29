<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
checkUser();
	
	date_default_timezone_set("Asia/Manila");
	$today_date1 = date("Y-m-d H:i:s");
	$today_date2 = date("Y-m-d");
	
	session_start();
	if(isset($_POST['msg'])){		
		$msg=mysqli_real_escape_string($link, $_POST['msg']);
		$id=$_POST['id'];
		
		$me=mysqli_query($link,"select * from bs_user where member_id='".$_SESSION['chat_user_id']."'");
		$numme=mysqli_fetch_assoc($me);
		$isadmin = $numme['is_admin'];				

		mysqli_query($link,"insert into `chat` (chatroomid, message, userid, chat_date, isadmin, is_new) values ('$id', '$msg' , '".$_SESSION['chat_user_id']."', '$today_date1', '$isadmin', '1')") or die(mysqli_error());
		
		$ig = $conn->prepare("SELECT * FROM chatroom c, chat_member m WHERE m.chatroomid = '$id' AND m.userid != '".$_SESSION['chat_user_id']."' AND c.chatroomid = m.chatroomid");
		$ig->execute();
		while($ig_data = $ig->fetch())
		{
			$isgroup = $ig_data['is_group'];
			$sendto = $ig_data['userid'];
			mysqli_query($link,"insert into `tr_notification` (chatroomid, send_from, send_to, message, date_added, is_group) values ('$id', '".$_SESSION['chat_user_id']."', '$sendto', '$msg', '$today_date1', '$isgroup')") or die(mysqli_error());
		} // End While			
	}
?>