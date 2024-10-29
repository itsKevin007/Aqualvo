<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

checkUser();

	$userId = $_SESSION['user_id'];

	if (isset($_GET['id']) && (int)$_GET['id'] > 0) {
		$id = (int)$_GET['id'];
	} else {
		header('Location: index.php');
	}
		
		$ch = $conn->prepare("SELECT * FROM bs_user WHERE user_id = '$id' AND is_deleted != '1'");
		$ch->execute();
		$ch_data = $ch->fetch();
		$name = $ch_data['firstname'] . '&nbsp;' . $ch_data['lastname'];

		$deleted = _deleteImage($id);

		// update the image and thumbnail name in the database
		$sql = $conn->prepare("UPDATE bs_user
				SET image = '', thumbnail = ''
				WHERE user_id = $id");
		$sql->execute();
		
		/* Insert Log */
		$log = $conn->prepare("INSERT INTO tr_log (action, description, category, action_by, log_action_date)
					VALUES ('Image deleted', '$name', 'user', '$userId', NOW())");
		$log->execute();
		/* End Log */

	header("Location: index.php?view=modify&id=$id&error=Image deleted successfully");

function _deleteImage($id)
{
	include '../global-library/database.php';
	// we will return the status
	// whether the image deleted successfully
	$deleted = false;

	$sql = $conn->prepare("SELECT image, thumbnail
	        FROM bs_user
			WHERE user_id = $id");
	$sql->execute();

	if ($sql->rowCount() > 0) {
		$sql_data = $sql->fetch();
		

		if ($sql_data['image'] && $sql_data['thumbnail']) {
			// remove the image file
			$deleted = @unlink(SRV_ROOT . "images/user/$sql_data[image]");
			$deleted = @unlink(SRV_ROOT . "images/user/$sql_data[thumbnail]");
		}
	}

	return $deleted;
}

?>
