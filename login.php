<?php
require_once 'global-library/config.php';
require_once 'global-library/functions.php';

$errorMessage = '&nbsp;';

/* Check login attempt */
$ip = $_SERVER['REMOTE_ADDR']; // Get IP Address of user
$sql = $conn->prepare("SELECT * FROM tr_login_attempt WHERE ip = '$ip' AND status = '1'");
$sql->execute();

/*if($num > 3)
{
	echo "<img src='images/png/animo.png' />";
}else{*/
	// if verified proceed

if (isset($_POST['txtUserName'])) {
	$result = doLogin();

	if ($result != '') {
		$errorMessage = $result;
	}
}

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
	<meta name="description" content="<?php echo $sett_data['developer']; ?>">
	<meta name="author" content="<?php echo $sett_data['developer']; ?>">
	<!-- The styles -->
	<?php include ($_SERVER["DOCUMENT_ROOT"] . '/' . $sett_data['directory'] . '/global-library/global-css.php'); ?>
	<!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	
	<link rel="shortcut icon" href="<?php echo WEB_ROOT; ?>images/favicon.ico">
	<link rel="apple-touch-icon" sizes="128x128" href="https://aqualvo.tridentechnology.com/images/favicon.ico">
	
	<link rel="manifest" href="manifest.json">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="theme-color" content="#ffffff">
<meta name="apple-mobile-web-app-status-bar-style" content="default">
<link rel="apple-touch-startup-image" href="<?php echo WEB_ROOT; ?>images/logo/header_logo.png" media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)">
<link rel="apple-touch-startup-image" href="<?php echo WEB_ROOT; ?>images/logo/header_logo.png" media="(device-width: 375px) and 	(device-height: 667px) and (-webkit-device-pixel-ratio: 2) and (orientation: portrait)">
<link rel="apple-touch-startup-image" href="<?php echo WEB_ROOT; ?>images/logo/header_logo.png" media="(device-width: 414px) and 	(device-height: 736px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)">
<link rel="apple-touch-startup-image" href="<?php echo WEB_ROOT; ?>images/logo/header_logo.png" media="(device-width: 375px) and 	(device-height: 812px) and (-webkit-device-pixel-ratio: 3) and (orientation: portrait)">
<link rel="apple-touch-startup-image" href="<?php echo WEB_ROOT; ?>images/logo/header_logo.png" media="(min-device-width: 768px) and 	(max-device-width: 1024px) and (-webkit-min-device-pixel-ratio: 2) and (orientation: portrait)">
<link rel="apple-touch-startup-image" href="<?php echo WEB_ROOT; ?>images/logo/header_logo.png" media="(min-device-width: 834px) and 	(max-device-width: 834px) and (-webkit-min-device-pixel-ratio: 2) and (orientation: portrait)">
<link rel="apple-touch-startup-image" href="<?php echo WEB_ROOT; ?>images/logo/header_logo.png" media="(min-device-width: 1024px) and (max-device-width: 1024px) and (-webkit-min-device-pixel-ratio: 2) and (orientation: portrait)">
</head>
<body id="login-bg"> 
 
	<div class="container-fluid">
		<div class="row-fluid">
		
			<div class="row-fluid">
				<div class="span12 center login-header">
					<h2><img src="<?php echo WEB_ROOT; ?>images/logo/header_logo.png" /> <!--&nbsp; </?php echo $system_title; ?>!--></h2>
				</div><!--/span-->
			</div><!--/row-->
			<br /><br /><br />
			<div class="row-fluid">
				<div class="well span5 center login-box">
					<?php
						if($errorMessage == 'You must enter your username')
						{
					?>
							<div class="alert alert-danger">
								<b><?php echo $errorMessage; ?></b>
							</div>
					<?php
						}
						else if($errorMessage == 'You must enter the password')
						{
					?>
							<div class="alert alert-danger">
								<b><?php echo $errorMessage; ?></b>
							</div>
					<?php
						}
						else if($errorMessage == 'Wrong username or password')
						{
					?>
							<div class="alert alert-danger">
								<b><?php echo $errorMessage; ?></b>
							</div>
					<?php
						}
						else
						{
					?>
							<div class="alert alert-info">
								Please login with your Username and Password.
							</div>
					<?php
						}
					?>
					
					<form class="form-horizontal" name="frmLogin" id="frmLogin" method="post">
						<fieldset>
							<div class="input-prepend" title="Username" data-rel="tooltip">
								<span class="add-on"><i class="icon-user"></i></span><input autofocus class="input-large span10" name="txtUserName" id="txtUserName" type="text" placeholder="Username" autocomplete=off />
							</div>
							<div class="clearfix"></div>

							<div class="input-prepend" title="Password" data-rel="tooltip">
								<span class="add-on"><i class="icon-lock"></i></span><input class="input-large span10" name="txtPassword" id="txtPassword" type="password" placeholder="Password" autocomplete=off />
							</div>
							<div class="clearfix"></div>
							
							<div class="clearfix"></div>

							<p class="center span5">
							<button type="submit" class="btn btn-success">Login</button><br />
							</p>
						</fieldset>
					</form>
				</div><!--/span-->
			</div><!--/row-->
				</div><!--/fluid-row-->
		
	</div><!--/.fluid-container-->
	
	<!-- external javascript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<?php include ($_SERVER["DOCUMENT_ROOT"] . '/' . $sett_data['directory'] . '/global-library/global-js.php'); ?>
	<div style="text-align:center;">&copy; <?php echo $sett_data['system_title']; ?> <?php echo $sett_data['year_developed']; ?>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Developed by: <?php echo $sett_data['developer']; ?> | <?php echo $sett_data['website']; ?>
	</div>
</body>
</html>

<!--<?php// } // End Check ?>!-->