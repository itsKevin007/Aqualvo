<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

checkUser();
 

	$userId = $_SESSION['user_id'];
	
	date_default_timezone_set("Asia/Manila");
	$today_date1 = date("Y-m-d H:i:s");
	$today_date2 = date("Y-m-d");
	
	$asc = $_POST['inv'];
	
	$num_str = sprintf("%06d", mt_rand(1, 999999));
	$ordernum = 'LRS-' . $num_str;
	
	# Round
	foreach ($asc as $ac)
	{
				
		if (isset($_POST['round_' . $ac]) && $_POST['round_' . $ac] > 0) 
		{
			$con = $_POST['round_' . $ac];
		
			foreach($con as $op)
			{
				
				# UPDATE tr_inventory
				$up = "UPDATE tr_inventory SET round = '$op', date_modified = '$today_date1'
							WHERE inv_id = '$ac'";
				dbQuery($up);
			}
		}else{}
	}
	
	# Slim
	foreach ($asc as $ac)
	{
				
		if (isset($_POST['slim_' . $ac]) && $_POST['slim_' . $ac] > 0) 
		{
			$con = $_POST['slim_' . $ac];
		
			foreach($con as $op)
			{
				
				# UPDATE tr_inventory
				$up = "UPDATE tr_inventory SET slim = '$op', date_modified = '$today_date1'
							WHERE inv_id = '$ac'";
				dbQuery($up);
			}
		}else{}
	}
	
	# Slim
	foreach ($asc as $ac)
	{
				
		if (isset($_POST['dispenser_' . $ac]) && $_POST['dispenser_' . $ac] > 0) 
		{
			$con = $_POST['dispenser_' . $ac];
		
			foreach($con as $op)
			{
				
				# UPDATE tr_inventory
				$up = "UPDATE tr_inventory SET dispenser = '$op', date_modified = '$today_date1'
							WHERE inv_id = '$ac'";
				dbQuery($up);
			}
		}else{}
	}
		
	header('Location: index.php?error=' . urlencode('Saved successfully'));
?>