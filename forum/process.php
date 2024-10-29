<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

checkUser();

$action = isset($_GET['action']) ? $_GET['action'] : '';
switch ($action) {	 
		
	case 'forum' :
        forum();
        break;
	
	case 'edit_forum' :
        edit_forum();
        break;			
		
	case 'delete_forum' :
        delete_forum();
        break;
		
	case 'delete_forum_img' :
        delete_forum_img();
        break;			
   
    default :
        // if action is not defined or unknown
        // move to main category page
        header('Location: index.php');
}


/*
    Add forum
*/
function forum()
{
	include '../global-library/database.php';
	$userId = $_SESSION['user_id'];
	
	# Format Date/Time
	date_default_timezone_set("Asia/Manila");
	$today_date1 = date("Y-m-d H:i:s");
	$today_date2 = date("Y-m-d");
		
    $pr = mysqli_real_escape_string($link, $_POST['forum']);
	
	$images = uploadimage('fileImage', SRV_ROOT . 'images/forum/');

	$mainImage = $images['image'];
	$thumbnail = $images['thumbnail'];
   
		/* Insert */
		$sql = $conn->prepare("INSERT INTO tr_forum (detail, image, thumbnail, added_by, date_added)
					VALUES ('$pr', '$mainImage', '$thumbnail', '$userId', '$today_date1')");
		$sql->execute();
		/* End */
	
	
		/* Insert Log */
		$log = $conn->prepare("INSERT INTO tr_log (action, description, category, action_by, log_action_date)
					VALUES ('Forum message added', '$pr', 'add forum', '$userId', NOW())");
		$log->execute();
		/* End Log */
	
		header("Location: index.php?view=list&error=Added successfully");
		           
}

/*
    Edit forum
*/
function edit_forum()
{
	include '../global-library/database.php';
	$userId = $_SESSION['user_id'];
	
	# Format Date/Time
	date_default_timezone_set("Asia/Manila");
	$today_date1 = date("Y-m-d H:i:s");
	$today_date2 = date("Y-m-d");
	
	$pid	= $_POST['pid'];
    $pr = mysqli_real_escape_string($link, $_POST['forum']);
	
	$images = uploadimage('fileImage', SRV_ROOT . 'images/forum/');

	$mainImage = $images['image'];
	$thumbnail = $images['thumbnail'];
	
	// if uploading a new image
	// remove old image
	if ($mainImage != '') {
		_deleteImage($pid);

		$mainImage = "'$mainImage'";
		$thumbnail = "'$thumbnail'";
	} else {
		// if we're not updating the image
		// make sure the old path remain the same
		// in the database
		$mainImage = 'image';
		$thumbnail = 'thumbnail';
	}
   
   
		/* Insert ticket */
		$sql = $conn->prepare("UPDATE tr_forum SET detail = '$pr', image = $mainImage, thumbnail = $thumbnail, date_modified = '$today_date1' 
					WHERE pr_id = '$pid'");
		$sql->execute();
		/* End ticket */
	
	
		/* Insert Log */
		$log = $conn->prepare("INSERT INTO tr_log (action, description, category, action_by, log_action_date)
					VALUES ('Forum message modified', '$pr', 'edit forum', '$userId', NOW())");
		$log->execute();
		/* End Log */
	
		header("Location: index.php?view=list&error=Saved successfully");
		           
}

/*
    Delete forum
*/
function delete_forum()
{
	include '../global-library/database.php';
	$userId = $_SESSION['user_id'];
	
	# Format Date/Time
	date_default_timezone_set("Asia/Manila");
	$today_date1 = date("Y-m-d H:i:s");
	$today_date2 = date("Y-m-d");

    $eId       = (int)$_GET['id'];
	
    /* Check if ticket already exist. */
		$check = $conn->prepare("SELECT * FROM tr_forum
					WHERE pr_id = '$eId' AND is_deleted != '1'");
		$check->execute();
		
		$check_data = $check->fetch();
		$name = $check_data['pr_id'] . ' - ' . mysqli_real_escape_string($link, $check_data['detail']);
		
			/* Update ticket */
			$sql = $conn->prepare("UPDATE tr_forum SET is_deleted = '1', deleted_by = '$userId', date_deleted = '$today_date1'
						WHERE pr_id = '$eId'");
			$sql->execute();
			/* End Update */
		
		
			/* Insert Log */
			$log = $conn->prepare("INSERT INTO tr_log (action, description, category, action_by, log_action_date)
						VALUES ('Forum message deleted', '$name', 'delete forum message', '$userId', '$today_date1')");
			$log->execute();
			/* End Log */
				
			header("Location: index.php?view=list&error=Deleted successfully");
		
}

/*
    Delete forum image
*/
function delete_forum_img()
{
	include '../global-library/database.php';
	$userId = $_SESSION['user_id'];
	
	# Format Date/Time
	date_default_timezone_set("Asia/Manila");
	$today_date1 = date("Y-m-d H:i:s");
	$today_date2 = date("Y-m-d");

    $eId       = (int)$_GET['id'];
	
	$check = $conn->prepare("SELECT * FROM tr_forum
					WHERE pr_id = '$eId' AND is_deleted != '1'");
		$check->execute();
		
		$check_data = $check->fetch();
		$name = $check_data['pr_id'] . ' - ' . mysqli_real_escape_string($link, $check_data['detail']);
		
			/* Update ticket */
			$sql = $conn->prepare("UPDATE tr_forum SET image = '', thumbnail = ''
						WHERE pr_id = '$eId'");
			$sql->execute();
			/* End Update */
		
		
			/* Insert Log */
			$log = $conn->prepare("INSERT INTO tr_log (action, description, category, action_by, log_action_date)
						VALUES ('Forum image deleted', '$eId', 'delete forum image', '$userId', '$today_date1')");
			$log->execute();
			/* End Log */
				
			header("Location: index.php?view=list&error=Deleted successfully");
		
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

function _deleteImage($pid)
{
	include '../global-library/database.php';
	// we will return the status
	// whether the image deleted successfully
	$deleted = false;

	$sql = $conn->prepare("SELECT image, thumbnail
	        FROM tr_forum
			WHERE pr_id = $pid");
	$sql->execute();

	if ($sql->rowCount() > 0) {
		$sql_data = $sql->fetch();
		

		if ($sql_data['image'] && $sql_data['thumbnail']) {
			// remove the image file
			$deleted = @unlink(SRV_ROOT . "images/forum/$sql_data[image]");
			$deleted = @unlink(SRV_ROOT . "images/forum/$sql_data[thumbnail]");
		}
	}

	return $deleted;
}

?>