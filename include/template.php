<?php

if (!defined('WEB_ROOT')) {
	exit;
}

$self = WEB_ROOT . 'encrypt.php';

	function word_split($str,$words=15) {
		$arr = preg_split("/[\s]+/", $str,$words+1);
		$arr = array_slice($arr,0,$words);
		return join(' ',$arr);
	}
	
	$userId = $_SESSION['user_id'];
	
	$sql = $conn->prepare("SELECT * FROM bs_user
				WHERE user_id = '$userId'");
	$sql->execute();
	$sql_data = $sql->fetch();
	
	# Get setting details
	$sett = $conn->prepare("SELECT * FROM bs_setting");
	$sett->execute();
	$sett_data = $sett->fetch();
	
?>

<!DOCTYPE html>
<html lang="en">
<head>	
	<meta charset="utf-8">
	<title><?php echo $sett_data['system_title']; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="<?php echo $sett_data['system_title']; ?>">
	<meta name="author" content="<?php echo $sett_data['developer']; ?>">	

	<!-- The styles -->
	<?php include ($_SERVER["DOCUMENT_ROOT"] . '/' . $sett_data['directory'] . '/global-library/global-css.php'); ?>	
	<!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<?php include ($_SERVER["DOCUMENT_ROOT"] . '/' . $sett_data['directory'] . '/global-library/misc-js.php'); ?>	
</head>

<body onLoad="document.getElementById('siteLoader').style.display = 'none'; document.frm.pid.focus();">
	<!-- loading BEGIN PAGE LOADER -->
      <div id="siteLoader"> 
        <div id="loadImg" style="margin:auto;"> 
        <img src="<?php echo WEB_ROOT; ?>images/loader/loader_2.gif" border="0" align="left" style="position:absolute; left:50%; top:50%; margin-left:-100px; /*image width/2 */ margin-top:-100px; /">
        </div> 
      </div> 
	<!-- END PAGE LOADER -->
	
	<!-- topbar starts -->	
	<div class="navbar">
		<?php include ($_SERVER["DOCUMENT_ROOT"] . '/' . $sett_data['directory'] . '/include/header.php'); ?>
	</div>	
	<!-- topbar ends -->
	<div class="container-fluid">
		<div class="row-fluid">
				
			<!-- left menu starts -->
			
				<?php
				if(($sql_data['is_agent'] == 1) || ($sql_data['is_client'] == 1)){}else{
					include ($_SERVER["DOCUMENT_ROOT"] . '/' . $sett_data['directory'] . '/include/left-menu.php');
				} // End Condition
				?>
			
			<!-- left menu ends -->					
			
			<div id="content" class="span10">
				<!-- content starts -->								
					<?php require_once $content; ?>
				<!-- content ends -->
			</div><!--/#content.span10-->
		</div><!--/fluid-row-->
				
		<hr />		

		<footer>
			<?php include ($_SERVER["DOCUMENT_ROOT"] . '/' . $sett_data['directory'] . '/include/footer.php'); ?>
		</footer>
		
	</div><!--/.fluid-container-->

	
	<!-- external javascript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<?php include ($_SERVER["DOCUMENT_ROOT"] . '/' . $sett_data['directory'] . '/global-library/global-js.php'); ?>
	
		
</body>
</html>