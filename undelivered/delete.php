<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

checkUser();

	$userId = $_SESSION['user_id'];

	if (isset($_GET['id']) && (int)$_GET['id'] > 0) {
		$id = (int)$_GET['id'];
	} else {
		header('Location: list.php');
	}

	$ch = $conn->prepare("SELECT * FROM tr_loading WHERE load_id = '$id' AND is_deleted != '1'");
	$ch->execute();
	$ch_data = $ch->fetch();
	$tn = $ch_data['truckname'];			
	
		/* Update customer Status */
		$sql = $conn->prepare("UPDATE tr_loading SET is_deleted = '1'
					WHERE load_id = $id");
		$sql->execute();
		/* End Customer */

		header('Location: list.php?error=' . urlencode('Deleted successfully'));

?>