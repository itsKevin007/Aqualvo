<?php

	# Get setting details
	$sett = $conn->prepare("SELECT * FROM bs_setting");
	$sett->execute();
	$sett_data = $sett->fetch();
	

?>
<p class="pull-left">&copy; <?php echo $sett_data['system_title']; ?> <?php echo $sett_data['year_developed']; ?></p>
<p class="pull-right">Developed by: <?php echo $sett_data['developer']; ?> | <?php echo $sett_data['website']; ?></p>