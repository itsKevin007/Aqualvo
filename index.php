<?php	
	require_once 'global-library/config.php';
	require_once 'global-library/functions.php';
	
	checkUser();
	
	# Get setting details
	$sett = $conn->prepare("SELECT * FROM bs_setting");
	$sett->execute();
	$sett_data = $sett->fetch();
	
	$userId = $_SESSION['user_id'];
	
	$sql = $conn->prepare("SELECT * FROM bs_user
				WHERE user_id = '$userId'");
	$sql->execute();
	$sql_data = $sql->fetch();
	
	if(isset($_GET['id']))
	{ $inv = $_GET['id']; }
	else{ $inv = 0; }
				
		
	if($sql_data['is_agent'] == 1)
	{ $content = 'agent/customer.php'; }
	else if($inv == 1001)
	{ $content = 'agent/customer.php'; }
	else if($sql_data['is_client'] == 1)
	{ $content = 'customer/soa.php'; }	
	else
	{ $content = 'home.php'; }
	$pageTitle = $sett_data['system_title'];
	$script = array('main.js');

	require_once 'include/template.php';
	
?>
<html>
<head>
</head>
<body bgcolor = "#FDE2B8">
</body>
</html>