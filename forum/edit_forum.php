<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
checkUser();

	$userId = $_SESSION['user_id'];
	
	$id = $_GET['id'];
		# Get setting details
		$sett = $conn->prepare("SELECT * FROM bs_setting");
		$sett->execute();
		$sett_data = $sett->fetch();
		
		$sql = $conn->prepare("SELECT * FROM tr_forum WHERE pr_id = '$id'");
		$sql->execute();
		$sql_data = $sql->fetch();
		
	$script = 0;
?>
<head>	
	<meta charset="utf-8">
	<title><?php echo $sett_data['pageTitle']; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!--<meta name="description" content="<?php echo $sett_data['pageTitle']; ?>">-->
	<meta name="author" content="<?php echo $sett_data['developer']; ?>">	

	<!-- The styles -->
	<?php include ($_SERVER["DOCUMENT_ROOT"] . '/aqualvo/global-library/global-css.php'); ?>	
	<!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<?php //include ($_SERVER["DOCUMENT_ROOT"] . '/aqualvo/global-library/misc-js.php'); ?>	
</head>	
		
		<form class="form-horizontal" method="post" action="process.php?action=edit_forum" enctype="multipart/form-data" name="form" id="form">
			<div class="modal-header">				
				<h3>Edit Forum Message</h3>
			</div>
			<div class="modal-body">
				<textarea name="forum" style="width:100%; height:200px;"><?php echo $sql_data['detail']; ?></textarea>
			</div>
			<div class="control-group">
				<label class="control-label" for="fileInput">Picture</label>
				<div class="controls">
					<input class="input-file uniform_on" name="fileImage" id="fileInput" type="file" />
				</div>
			</div>
			<?php
				// Display image of user
				if ($sql_data['image']) 
				{
					$image = WEB_ROOT . 'images/forum/' . $sql_data['image'];
			?>
				<div class="box span4">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-picture"></i> Picture</h2>
					</div>
										
					<div class="box-content">
						
								<img src="<?php echo $image; ?>" />
								<br /><br />
									<a class="btn btn-danger" href="javascript:delimg(<?php echo $sql_data['pr_id']; ?>);"><i class="icon-trash icon-white"></i> Delete Image</a>						
					</div>
				</div>
			<?php } else {} ?>
						
			<div class="modal-footer">
				<input type="hidden" name="pid" value="<?php echo $id; ?>" />
				<button type="submit" class="btn btn-primary" onClick="return confirmSubmit()">Save</button>
			</div>
		</form>
<?php include ($_SERVER["DOCUMENT_ROOT"] . '/aqualvo/global-library/global-js.php'); ?>