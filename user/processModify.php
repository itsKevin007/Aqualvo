<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

checkUser();
	
	$userId = $_SESSION['user_id'];

	$id = $_POST['id'];	
	$firstname = ucwords($_POST['firstname']);
	$lastname = ucwords($_POST['lastname']);
	$username = $_POST['username'];	
	$password = $_POST['password'];
	
	// Access Level
	$cust = $_POST['cust'];
	$sched = $_POST['sched'];
	$prod = $_POST['prod'];
	$trans = $_POST['trans'];	
	$return = $_POST['return'];
	$rep = $_POST['rep'];
	$user = $_POST['user'];
	
	$top = $_POST['top'];
	if($top == 'a')
	{ $iage = '1'; }else{ $iage = '0'; }
	
	$name = $firstname . '&nbsp;' . $lastname;
	
	$images = uploadimage('fileImage', SRV_ROOT . 'images/user/');

	$mainImage = $images['image'];
	$thumbnail = $images['thumbnail'];
	
	// if uploading a new image
	// remove old image
	if ($mainImage != '') {
		_deleteImage($id);

		$mainImage = "'$mainImage'";
		$thumbnail = "'$thumbnail'";
	} else {
		// if we're not updating the image
		// make sure the old path remain the same
		// in the database
		$mainImage = 'image';
		$thumbnail = 'thumbnail';
	}
	
/*
	Upload an image and return the uploaded image name
*/
function uploadimage($inputName, $uploadDir)
{
	include '../global-library/database.php';
	$image     = $_FILES[$inputName];
	$imagePath = '';
	$thumbnailPath = '';

	// if a file is given
	if (trim($image['tmp_name']) != '') {
		$ext = substr(strrchr($image['name'], "."), 1); //$extensions[$image['type']];

		// generate a random new file name to avoid name conflict
		$imagePath = md5(rand() * time()) . ".$ext";

		list($width, $height, $type, $attr) = getimagesize($image['tmp_name']);

		// make sure the image width does not exceed the
		// maximum allowed width
		if (LIMIT_IMAGE_WIDTH && $width > MAX_IMAGE_WIDTH) {
			$result    = createThumbnail($image['tmp_name'], $uploadDir . $imagePath, MAX_IMAGE_WIDTH);
			$imagePath = $result;
		} else {
			$result = move_uploaded_file($image['tmp_name'], $uploadDir . $imagePath);
		}

		if ($result) {
			// create thumbnail
			$thumbnailPath =  md5(rand() * time()) . ".$ext";
			$result = createThumbnail($uploadDir . $imagePath, $uploadDir . $thumbnailPath, THUMBNAIL_WIDTH);

			// create thumbnail failed, delete the image
			if (!$result) {
				unlink($uploadDir . $imagePath);
				$imagePath = $thumbnailPath = '';
			} else {
				$thumbnailPath = $result;
			}
		} else {
			// the image cannot be upload / resized
			$imagePath = $thumbnailPath = '';
		}

	}


	return array('image' => $imagePath, 'thumbnail' => $thumbnailPath);
}	
		include '../global-library/database.php';
		/* Check if the username already exist. */
		$check = $conn->prepare("SELECT * FROM bs_user
					WHERE username = '$username' AND user_id != '$id' AND is_deleted != '1'");
		$check->execute();
		
				
		if($check->rowCount() > 0)
		{			
			header("Location: index.php?view=modify&id=$id&error=Username already exist");
		}
		else
		{
				/* Update User */
				$sql = $conn->prepare("UPDATE bs_user SET firstname = '$firstname', lastname = '$lastname', username = '$username', password = md5('$password'), pass_text = '$password', image = $mainImage, thumbnail = $thumbnail, 
								is_agent = '$iage', is_customer_access = '$cust', is_schedule_access = '$sched', is_product_access = '$prod', is_transaction_access = '$trans', is_return_access = '$return', is_report_access = '$rep', is_user_access = '$user', date_modified = NOW() 
									WHERE user_id = '$id'");
				$sql->execute();
				/* End User */
		
				/* Insert Log */
				$log = $conn->prepare("INSERT INTO tr_log (action, description, category, action_by, log_action_date)
							VALUES ('User modified', '$name', 'user', '$userId', NOW())");
				$log->execute();
				/* End Log */
				
				header("Location: index.php?view=modify&id=$id&error=Modified successfully");
		}		

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