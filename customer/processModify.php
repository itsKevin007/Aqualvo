<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

checkUser();

	$userId = $_SESSION['user_id'];

	$id = $_POST['id'];	
	$cname = mysqli_real_escape_string($link, $_POST['cname']);
	$address = mysqli_real_escape_string($link, $_POST['address']);
	$cp = mysqli_real_escape_string($link, $_POST['cp']);
	$cn = mysqli_real_escape_string($link, $_POST['cn']);
	$uname = mysqli_real_escape_string($link, $_POST['uname']);
	$passwd = mysqli_real_escape_string($link, $_POST['passwd']);
	
	$top = mysqli_real_escape_string($link, $_POST['top']);
	
	$images = uploadimage('fileImage', SRV_ROOT . 'images/customer/');

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
		/* Check if the client_name already exist. */
		$check = $conn->prepare("SELECT * FROM bs_customer
					WHERE client_name = '$cname' AND cust_id != '$id' AND is_deleted != '1'");
		$check->execute();
		
				
		if($check->rowCount() > 0)
		{			
			header("Location: index.php?view=modify&id=$id&error=Customer already exist");
		}
		else
		{
				/* Update Customer */
				$sql = $conn->prepare("UPDATE bs_customer SET client_name = '$cname', address = '$address', contact_person = '$cp', contactno = '$cn', image = $mainImage, thumbnail = $thumbnail, allow_access = '$top', date_modified = NOW() 
								WHERE cust_id = '$id'");
				$sql->execute();
				/* End Customer */
				
				$ck = $conn->prepare("SELECT * FROM bs_user
								WHERE cust_id = '$id' AND is_deleted != '1'");
				$ck->execute();
				
				
				if($top == 'Yes')
				{					
					if($ck->rowCount() > 0)
					{
						$up = $conn->prepare("UPDATE bs_user SET username = '$uname', password = md5('$passwd'), pass_text = '$passwd', date_modified = NOW() WHERE cust_id = '$id'");
						$up->execute();
					}else{
						$in = $conn->prepare("INSERT INTO bs_user (cust_id, firstname, username, password, pass_text, is_client, date_added)
									VALUES ('$id', '$cname', '$uname', md5('$passwd'), '$passwd', '1', NOW())");
						$in->execute();
					}
				}else{
					if($ck->rowCount() > 0)
					{
						$up = $conn->prepare("UPDATE bs_user SET is_deleted = '1', date_deleted = NOW() WHERE cust_id = '$id'");
						$up->execute();
					}else{}
				}
		
				/* Insert Log */
				$log = $conn->prepare("INSERT INTO tr_log (action, description, category, action_by, log_action_date)
							VALUES ('Customer modified', '$cname', 'customer', '$userId', NOW())");
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
	        FROM bs_customer
			WHERE cust_id = $id");
	$sql->execute();

	if ($sql->rowCount() > 0) {
		$sql_data = $sql->fetch();
		

		if ($sql_data['image'] && $sql_data['thumbnail']) {
			// remove the image file
			$deleted = @unlink(SRV_ROOT . "images/customer/$sql_data[image]");
			$deleted = @unlink(SRV_ROOT . "images/customer/$sql_data[thumbnail]");
		}
	}

	return $deleted;
}
		
?>