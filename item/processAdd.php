<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

checkUser();

	$userId = $_SESSION['user_id'];
	
	$code = mysqli_real_escape_string($link, $_POST['code']);	
	$name = mysqli_real_escape_string($link, $_POST['name']);	
	$price = $_POST['price'];
	
	$ore = $conn->prepare("SELECT * FROM bs_item WHERE is_deleted != '1' ORDER BY ord DESC LIMIT 1");
	$ore->execute();
	$ore_data = $ore->fetch();
	$neworder = $ore_data['ord'] + 1;
	
				/* Check if the data already exist. */
				$check = $conn->prepare("SELECT * FROM bs_item
							WHERE name = '$name' AND is_deleted != '1'");
				$check->execute();
				
				
				if($check->rowCount() > 0)
				{
					header('Location: index.php?view=add&error=' . urlencode('Item already exist!'));
				}
				else
				{
					
					/* Insert Data */
					$sql = $conn->prepare("INSERT INTO bs_item (abrv, name, price, ord, date_added)
								VALUES ('$code', '$name', '$price', '$neworder', NOW())");
					$sql->execute();
					/* End Data */
				
				
					/* Insert Log */
					$log = $conn->prepare("INSERT INTO tr_log (action, description, category, action_by, log_action_date)
								VALUES ('Item added', '$name', 'item', '$userId', NOW())");
					$log->execute();
					/* End Log */
		
				header('Location: index.php?view=add&error=' . urlencode('Added successfully'));
		
				}

?>