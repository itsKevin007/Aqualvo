<?php
	$userId = $_SESSION['user_id'];
	
	# Get user
	$usr = $conn->prepare("SELECT * FROM bs_user WHERE user_id = '$userId'");
	$usr->execute();
	$usr_data = $usr->fetch();
	$isadmin = $usr_data['is_admin'];
	if($isadmin == 1)
	{
		$statement = '';
	}else{
		$statement = "AND released_by = '$userId'";
	}
	
	// Get user from database
	$sql = $conn->prepare("SELECT * FROM bs_user WHERE user_id = '$userId' AND is_deleted != '1'");
	$sql->execute();
	$sql_data = $sql->fetch();

	
	$chkc = $conn->prepare("SELECT * FROM tr_notification WHERE send_to = '".$_SESSION['user_id']."' AND is_open != '1'");
	$chkc->execute();
	
	if($chkc->rowCount() > 0)
	{ $notic = "<span class='label label-warning'>" . $chkc->rowCount() . "</span>"; }
	else{ $notic = ""; }	
	
?>
			<div class="span2 main-menu-span">
				<div class="well nav-collapse sidebar-nav">
					<ul class="nav nav-tabs nav-stacked main-menu">
						<li class="nav-header hidden-tablet">Main</li>
						<?php if($sql_data['access_level'] == 3){}else{ ?><li><a class="ajax-link" href="javascript:home();"><i class="icon-home"></i><span class="hidden-tablet"> Dashboard</span></a></li><?php } ?>						
								<?php if($sql_data['access_level'] == 3){}else{ ?>
									<?php if($usr_data['is_customer_access'] == 1): ?><li><a class="ajax-link" href="javascript:cust();"><i class="icon-user"></i><span class="hidden-tablet"> Customer</span></a></li><?php endif; ?>
									<?php if($usr_data['is_schedule_access'] == 1): ?><li><a class="ajax-link" href="javascript:sch();"><i class="icon-calendar"></i><span class="hidden-tablet"> Schedule</span></a></li><?php endif; ?>
									<?php if($usr_data['is_product_access'] == 1): ?><li><a class="ajax-link" href="javascript:item();"><i class="icon-hdd"></i><span class="hidden-tablet"> Product</span></a></li><?php endif; ?>			
									<?php if($usr_data['is_inventory_access'] == 1): ?><li><a class="ajax-link" href="javascript:inv();"><i class="icon-th"></i><span class="hidden-tablet"> Inventory</span></a></li><?php endif; ?>
									<li><a class="ajax-link" href="<?php echo WEB_ROOT; ?>loading/"><i class="icon-road"></i><span class="hidden-tablet"> Truck Loading</span></a></li>
									<!--<li><a class="ajax-link" href="javascript:dat();"><i class="icon-calendar"></i><span class="hidden-tablet"> Dates</span></a></li>!-->									
									<?php if($usr_data['is_transaction_access'] == 1): ?><li><a class="ajax-link" href="javascript:trans();"><i class="icon-file"></i><span class="hidden-tablet"> Transaction</span></a></li><?php endif; ?>
									<?php if($usr_data['is_return_access'] == 1): ?><li><a class="ajax-link" href="javascript:returns();"><i class="icon-th-large"></i><span class="hidden-tablet"> Return</span></a></li><?php endif; ?>
								<?php } ?>								
									<?php if($usr_data['is_report_access'] == 1): ?><li><a class="ajax-link" href="javascript:report();"><i class="icon-list-alt"></i><span class="hidden-tablet"> Reports</span></a></li><?php endif; ?>
								<?php if($sql_data['access_level'] == 3){}else{ ?>
									<?php if($usr_data['is_user_access'] == 1): ?><li><a class="ajax-link" href="javascript:user();"><i class="icon-user"></i><span class="hidden-tablet"> Users</span></a></li><?php endif; ?>
								<?php } ?>
							<li><a class="ajax-link" href="javascript:forum();"><i class="icon-list"></i><span class="hidden-tablet"> Forum</span></a></li>
							<li><a class="ajax-link" href="javascript:chat();"><i class="icon-envelope"></i><span class="hidden-tablet"> Chat <?php echo $notic; ?></span></a></li>
					</ul>					
				</div><!--/.well -->
			</div><!--/span-->