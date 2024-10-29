<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

checkUser();

	$userId = $_SESSION['user_id'];
		
	$cname = mysqli_real_escape_string($link, $_POST['cname']);
	$address = mysqli_real_escape_string($link, $_POST['address']);
	$cp = mysqli_real_escape_string($link, $_POST['cp']);
	$cn = mysqli_real_escape_string($link, $_POST['cn']);
	
	$images = uploadimage('fileImage', SRV_ROOT . 'images/customer/');

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
				/* Check if the cname already exist. */
				$check = $conn->prepare("SELECT * FROM bs_customer
							WHERE client_name = '$cname' AND is_deleted != '1'");
				$check->execute();
				
				
				if($check->rowCount() > 0)
				{
					header('Location: index.php?view=add&error=' . urlencode('Customer already exist'));
				}
				else
				{
					
					/* Insert Customer */
					$sql = $conn->prepare("INSERT INTO bs_customer (client_name, address, contact_person, contactno, image, thumbnail, date_added)
								VALUES ('$cname', '$address', '$cp', '$cn', '$mainImage', '$thumbnail', NOW())");
					$sql->execute();
					/* End Customer */
				
					// get the order id
					$cId = $conn->lastInsertId();
					$inv = $conn->prepare("INSERT INTO tr_inventory (cust_id, date_added)
								VALUES ('$cId', NOW())");
					$inv->execute();
				
					/* Insert Log */
					$log = $conn->prepare("INSERT INTO tr_log (action, description, category, action_by, log_action_date)
								VALUES ('Customer added', '$cname', 'customer', '$userId', NOW())");
					$log->execute();
					/* End Log */
		
				header('Location: index.php?view=add&error=' . urlencode('Added successfully'));
		
				}

?>