<?php
if (!defined('WEB_ROOT')) {
	exit;
}
	$userId = $_SESSION['user_id'];
	
	$used = $conn->prepare("SELECT * FROM bs_user WHERE user_id = '$userId'");
	$used->execute();
	$used_data = $used->fetch();	
		
	
$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;'
?>

		<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-list"></i> Forum</h2>						
						&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" class="btn btn-primary btn-setting">Add Forum Message</a>						
					</div>
										
					<div class="box-content">
							<?php
								if($errorMessage == 'Added successfully')
								{
							?>
									<div class="valid_box">
										<b><?php echo $errorMessage; ?></b>
									</div>
							<?php
								}
								else if($errorMessage == 'Saved successfully')
								{
							?>
									<div class="valid_box">
										<b><?php echo $errorMessage; ?></b>
									</div>	
							<?php								
								}else{}
							?>
							
							<fieldset>														  
							  														
							<hr style="border: 7; height: 4px; background-image: -webkit-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,0.75), rgba(0,0,0,0)); background-image: -moz-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,0.75), rgba(0,0,0,0)); background-image: -ms-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,0.75), rgba(0,0,0,0));  background-image: -o-linear-gradient(left, rgba(0,0,0,0), rgba(0,0,0,0.75), rgba(0,0,0,0)); " />
									<?php
										$prog = $conn->prepare("SELECT * FROM bs_user u, tr_forum f WHERE f.added_by = u.user_id AND f.is_deleted != '1' ORDER BY pr_id DESC");
										$prog->execute();
										
										if($prog->rowCount() > 0)
										{
											while($prog_data = $prog->fetch())
											{
												
												$added_date = date("M d, Y | h:s A", strtotime($prog_data['date_added']));
									?>
												<div class="alert alert-primary" style="color:#000000;">
													<strong><?php echo $prog_data['lastname']; ?>, <?php echo $prog_data['firstname']; ?> | <?php echo $added_date; ?></strong>
													
														<?php if($userId == $prog_data['added_by']){ ?>
															&nbsp;|&nbsp;
															<a href="edit_forum.php?id=<?php echo $prog_data['pr_id']; ?>" title="Modify" class="nyroModal">
																<i class="icon-edit icon-color"></i>  														
															</a>
															&nbsp;|&nbsp;
															<a href="javascript:delprog(<?php echo $prog_data['pr_id']; ?>);" title="Delete">
																<i class="icon-trash icon-color"></i>  														
															</a>
														<?php }else{} ?>
													
														<br /><br /><?php echo $prog_data['detail']; ?>
														<?php
															// Display image of user
															if ($prog_data['image']) 
															{
																$image = WEB_ROOT . 'images/forum/' . $prog_data['image'];
														?>
																<br /><img src="<?php echo $image; ?>" />																				
														<?php }else{} ?>
												</div>
									<?php
											} // End While
										}else{}
									?>
							</fieldset>
							
					</div>							
				</div>
												
		</div><!--/span-->

	<div class="modal hide fade" id="myModal">
		<form class="form-horizontal" method="post" action="process.php?action=forum" enctype="multipart/form-data" name="form" id="form">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">X</button>
				<h3>Add Forum Message</h3>
			</div>
			<div class="modal-body">
				<textarea name="forum" style="width:100%; height:200px;"></textarea>
			</div>
			<div class="control-group">
				<label class="control-label" for="fileInput">Picture</label>
				<div class="controls">
					<input class="input-file uniform_on" name="fileImage" id="fileInput" type="file" />
				</div>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal">Close</a>				
				<button type="submit" class="btn btn-primary" onClick="return confirmSubmit()">Submit</button>
			</div>
		</form>
	</div>
		