<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
checkUser();
$script = array('main.js');

	# Get setting details
	$sett = $conn->prepare("SELECT * FROM bs_setting");
	$sett->execute();
	$sett_data = $sett->fetch();
	

	# Item Id
	if(isset($_GET['id']))
	{
		$pdId = $_GET['id'];	
	}else{
		$pdId = '';
	}
	# Customer Id
	if(isset($_GET['c']))
	{
		$custId = $_GET['c'];	
	}else{
		$custId = '';
	}
	# Item Type
	if(isset($_GET['t']))
	{
		$itemType = $_GET['t'];	
	}else{
		$itemType = '';
	}
	
	include 'insert.php';

	$cus = $conn->prepare("SELECT * FROM bs_customer WHERE cust_id = '$custId'");
	$cus->execute();
	if($cus->rowCount() > 0)
	{
		$cus_data = $cus->fetch();
		$client = $cus_data['client_name'];
	}else{ $client = ''; }

	$sql7 = $conn->prepare("SELECT * FROM bs_item WHERE is_deleted != '1' ORDER BY ord");
	$sql7->execute();
	
	if($sql7->rowCount() > 0)
	{
?>		
<head>
<title>Aqualvo</title>
	<!-- The styles -->
	<?php include ($_SERVER["DOCUMENT_ROOT"] . '/' . $sett_data['directory'] . '/global-library/global-css.php'); ?>	
	<!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<?php include ($_SERVER["DOCUMENT_ROOT"] . '/' . $sett_data['directory'] . '/global-library/misc-js.php'); ?>	
</head>	
	
	<!-- topbar starts -->	
	<div class="navbar">
		<?php include ($_SERVER["DOCUMENT_ROOT"] . '/' . $sett_data['directory'] . '/include/header.php'); ?>
	</div>	
	
		<div class="box span6">
			<div class="box-header well" data-original-title>
				<h2><i class="icon-hdd"></i> Item - &nbsp; Customer: &nbsp;<?php echo $client; ?></h2>
			</div>							
				<div class="box-content">
					<div class="sortable row-fluid">
					<?php
						
						while($sql7_data = $sql7->fetch())
						{
							
							
					?>
							<a data-rel="tooltip" title="<?php echo $sql7_data['name']; ?>" class="well span3 top-block nyroModal" href="type.php?id=<?php echo $sql7_data['item_id']; ?>&c=<?php echo $custId; ?>" style="width:200px;">
								<span class="<?php echo $sql7_data['icon']; ?>"></span>
								<div><?php echo $sql7_data['name']; ?></div>
								<div>Php <?php echo $sql7_data['price']; ?></div>				
							</a>
					<?php
							
						} // End While
						
					?>
					</div>
				</div>
		</div>
<?php }else{} include 'cart.php'; ?>
<!-- Placed at the end of the document so the pages load faster -->
	<?php include ($_SERVER["DOCUMENT_ROOT"] . '/' . $sett_data['directory'] . '/global-library/global-js.php'); ?>