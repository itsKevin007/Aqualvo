<?php
	$userId = $_SESSION['user_id'];
	
	/* Select user from database */
	$sql = $conn->prepare("SELECT * FROM bs_user WHERE user_id = '$userId' AND is_deleted != '1'");
	$sql->execute();
	$sql_data = $sql->fetch();
	
	# Get setting details
	$sett = $conn->prepare("SELECT * FROM bs_setting");
	$sett->execute();
	$sett_data = $sett->fetch();
	
	
		
?>			
	<div class="navbar-inner">
		<div class="container-fluid">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				<a class="brand" href="javascript:home();"><span style="font-family:Verdana;"><?php echo $sett_data['system_title']; ?></span></a>
								
				
				<!-- user dropdown starts -->
				<div class="btn-group pull-right" >
					<a class="btn dropdown-toggle" data-toggle="dropdown" href="javascript:mod(<?php echo $userId; ?>);">
						<i class="icon-user"></i><span class="hidden-phone"> <?php echo $sql_data['firstname']; ?></span>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<!-- Check access level. Users can only access their own profile !-->
						<?php if($sql_data['access_level'] != "1") { ?>							
						<?php }else{ ?>
							<li><a href="javascript:user();"><i class="icon icon-black icon-users"></i> Users</a></li>							
						<?php } ?>
							<li class="divider"></li>
							<li><a href="<?php echo $self; ?>?logout"><i class="icon icon-black icon-arrowreturn-se"></i> Logout</a></li>
					</ul>
				</div>
				<!-- user dropdown ends -->
			</div>
		</div>