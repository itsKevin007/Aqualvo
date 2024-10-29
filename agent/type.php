<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
checkUser();

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
	
	$script = 0;

?>		

		<a data-rel="tooltip" title="Round" class="well span3 top-block" href="index.php?id=<?php echo $pdId; ?>&c=<?php echo $custId; ?>&t=1" style="width:200px;">
			<span class="icon32 icon-color icon-bullet-on"></span>
			<div>ROUND</div>			
		</a>
		<br />
		<a data-rel="tooltip" title="Slim" class="well span3 top-block" href="index.php?id=<?php echo $pdId; ?>&c=<?php echo $custId; ?>&t=2" style="width:200px;">
			<span class="icon32 icon-color icon-carat-1-nw"></span>
			<div>SLIM</div>			
		</a>
		<br />
		<a data-rel="tooltip" title="Bottle" class="well span3 top-block" href="index.php?id=<?php echo $pdId; ?>&c=<?php echo $custId; ?>&t=3" style="width:200px;">
			<span class="icon32 icon-color icon-tag"></span>
			<div>BOTTLE</div>			
		</a>
				