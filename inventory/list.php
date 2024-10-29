<?php
if (!defined('WEB_ROOT')) {
	exit;
}

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;'
?>		
		<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-hdd"></i> List of Inventory</h2>
						<div class="box-icon">																					
							<a href="../" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>							
						</div>
					</div>
					<div class="box-content">
						<?php
								if($errorMessage == 'Deleted successfully')
								{
							?>
									<div class="valid_box">
										<b><?php echo $errorMessage; ?></b>
									</div>
							<?php
								}else{}
						?>
						<ul class="nav nav-tabs" id="myTab">
							<li class="active"><a href="#material">Materials</a></li>
							<li><a href="#salt">Salt</a></li>
							<li><a href="#dispenser">Dispensers</a></li>
							<li><a href="#filter">Filters</a></li>
						</ul>
						 
						<div id="myTabContent" class="tab-content">
							<div class="tab-pane active" id="material">
								<?php include 'material.php'; ?>
							</div>
							<div class="tab-pane" id="salt">
								<?php include 'salt.php'; ?>
							</div>
							<div class="tab-pane" id="dispenser">
								<?php include 'dispenser.php'; ?>
							</div>
							<div class="tab-pane" id="filter">
								<?php include 'filter.php'; ?>
							</div>
						</div>          
					</div>
				</div><!--/span-->
			
			</div><!--/row-->
						