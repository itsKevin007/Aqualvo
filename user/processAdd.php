<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

checkUser();

	$userId = $_SESSION['user_id'];
		
	$firstname = ucwords($_POST['firstname']);
	$lastname = ucwords($_POST['lastname']);
	$username = $_POST['username'];	
	$password = $_POST['password'];
	
	$name = $firstname . ' ' . $lastname;
	
	$images = uploadimage('fileImage', SRV_ROOT . 'images/user/');

	$mainImage = $images['image'];
	$thumbnail = $images['thumbnail'];
	
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
							WHERE username = '$username' AND is_deleted != '1'");
				$check->execute();
				
				
				if($check->rowCount() > 0)
				{
					header('Location: index.php?view=add&error=' . urlencode('Username already exist'));
				}
				else
				{
					
					/* Insert User */
					$sql = $conn->prepare("INSERT INTO bs_user (firstname, lastname, username, password, pass_text, image, thumbnail, access_level, date_added)
								VALUES ('$firstname', '$lastname', '$username', md5('$password'), '$password', '$mainImage', '$thumbnail', '2', NOW())");
					$sql->execute();
					/* End User */
				
				
					/* Insert Log */
					$log = $conn->prepare("INSERT INTO tr_log (action, description, category, action_by, log_action_date)
								VALUES ('User added', '$name', 'user', '$userId', NOW())");
					$log->execute();
					/* End Log */
		
				header('Location: index.php?view=add&error=' . urlencode('Added successfully'));
		
				}

?>