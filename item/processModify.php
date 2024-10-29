<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

checkUser();

	$userId = $_SESSION['user_id'];

	$id = $_POST['id'];	
	$code = mysqli_real_escape_string($link, $_POST['code']);
	$name = mysqli_real_escape_string($link, $_POST['name']);	
	$price = $_POST['price'];
	
		/* Check if the data already exist. */
		$check = $conn->prepare("SELECT * FROM bs_item
					WHERE name = '$name' AND item_id != '$id' AND is_deleted != '1'");
		$check->execute();
	
				
		if($check->rowCount() > 0)
		{			
			header("Location: index.php?view=modify&id=$id&error=Item already exist");
		}
		else
		{
				/* Update Data */
				$sql = $conn->prepare("UPDATE bs_item SET abrv = '$code', name = '$name', price = '$price', date_modified = NOW() 
							WHERE item_id = '$id'");
				$sql->execute();
				/* End Data */
		
				/* Insert Log */
				$log = $conn->prepare("INSERT INTO tr_log (action, description, category, action_by, log_action_date)
							VALUES ('Item modified', '$name', 'item', '$userId', NOW())");
				$log->execute();
				/* End Log */
				
				header("Location: index.php?view=modify&id=$id&error=Modified successfully");
		}
?>