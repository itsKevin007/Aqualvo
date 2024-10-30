<?php
	$userId = $_SESSION['user_id'];
	
	$sql = $conn->prepare("SELECT * FROM bs_user
				WHERE user_id = '$userId'");
	$sql->execute();
	$sql_data = $sql->fetch();									
						
		
		/* Format the fields to be displayed for user */
		$fullname = ucwords(strtolower($sql_data['firstname'])) . '&nbsp;' . ucwords(strtolower($sql_data['lastname']));		
		/* End Format */
										
		/* Check if user has picture then display */
		if ($sql_data['image']) {
			$user_image = WEB_ROOT . 'images/user/' . $sql_data['image'];
		} else {
			$user_image = WEB_ROOT . 'images/user/noimagelarge.jpg';
		}
		/* End Picture */
		
		$dt_login = date("M d, Y",strtotime($sql_data['last_login']));
	
?>			
			<div>
				<ul class="breadcrumb">
					<li>
						<b>Dashboard</b> 						
					</li>
					<li style="float:right;"><?php echo date('F d, Y | l');?></li>
				</ul>
			</div>			
		<div class="row-fluid sortable">
			<div class="box span6">
				<div class="box-header well" data-original-title>
					<h2><i class="icon-list"></i> Daily Sales</h2>
					<div class="box-icon">																					
						<a href="../" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>							
					</div>
				</div>
					<div class="box-content">
						<?php include 'graph/gross_sales_process.php'; ?>
					</div>
			</div>
			<?php include 'graph/past_due.php'; ?>
		</div>
		<div class="row-fluid sortable">

				
					<div class="box-content">
						<?php include 'undelivered/list.php'; ?>
					</div>
		
		</div>