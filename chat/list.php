<?php
if (!defined('WEB_ROOT')) {
	exit;
}
	$cui = $_SESSION['chat_user_id'];
	
	# Format Date/Time
	date_default_timezone_set("Asia/Manila");
	$today_date1 = date("Y-m-d H:i:s");
	$today_date2 = date("Y-m-d");
	
	$usr = $conn->prepare("SELECT * FROM bs_user WHERE user_id = '$cui'");
	$usr->execute();
	$usr_data = $usr->fetch();
		
	/* Select data from database */
	$sql = $conn->prepare("SELECT * FROM bs_user WHERE is_deleted != '1' AND user_id != '$cui'");
	$sql->execute();
		

$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;';
?>
	
		<div class="row-fluid sortable">
				<?php
				
					if(isset($_GET['ids']))
					{
						if($_GET['ids'] != 7)
						{
							$cid7 = $_GET['ids'];
							
							$cn = $conn->prepare("SELECT * FROM bs_user WHERE user_id = '$cid7'");
							$cn->execute();
							$cn_data = $cn->fetch();
							$chat_label = $cn_data['firstname'] . '' . $cn_data['lastname'];
						}else{
							$cid7 = $_GET['ids'];
							$idn = $_GET['id'];
							$cn = $conn->prepare("SELECT * FROM chatroom WHERE chatroomid = '$idn'");
							$cn->execute();
							$cn_data = $cn->fetch();
							$chat_label = $cn_data['chat_name'];
						}
				?>
						<div class="box span6">
							<div class="box-header well" data-original-title>
								<h2><i class="icon-user"></i> <?php echo $chat_label; ?></h2>
								<div class="box-icon">																					
									<a href="../" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>							
								</div>
							</div>
							<div class="box-content">
									<div class="panel panel-default" style="height:auto; width:auto; border:solid 0px;">
										<div style="height:10px;"></div>
										<span style="margin-left:10px;">Your'e chatting with <?php echo $chat_label; ?></span><br />
										<span style="font-size:10px; margin-left:10px;"><i>Note: Avoid using foul language and hate speech to avoid banning of account</i></span>
										<div style="height:10px;"></div>
										<div id="chat_area" style="margin-left:10px; max-height:420px; overflow-y:scroll;">
										</div>
									</div>
									
									<div class="input-group">					
										<input type="text" class="form-control" placeholder="Type message..." id="chat_msg" style="height:25px; width:337px;" autocomplete=off>
										<span class="input-group-btn">
										<button class="btn btn-success" type="submit" id="send_msg" value="<?php echo $id; ?>">
										<span class="glyphicon glyphicon-comment"></span> Send
										</button>
										<!--<a href="#attach_picture" data-toggle="modal" class="btn btn-setting btn-primary" id="dt" title="Send Picture"><span class="icon-white icon-picture"></span></a>!-->
										<!--<a href="#attach_video" data-toggle="modal" class="btn btn-warning" id="dt" title="Send Video"><span class="glyphicon glyphicon-film"></span></a>!-->
										</span>
										
									</div>			
							</div>
						</div><!--/span-->
				<?php
					}else{}
				?>
				
			<!-- START MEMBERS LIST !--->
				<div class="box span3">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-user"></i> List of Members</h2>						
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
						<table class="table table-striped table-bordered bootstrap-datatable">
						  <thead>
							  <tr>
								  <th>Name</th>
							  </tr>
						  </thead>   
						  <tbody>
							<?php
								if($sql->rowCount() > 0)
								{
									while($sql_data = $sql->fetch())
									{
										
										
										$mr = $sql_data['user_id'];
																				
										$cst = $conn->prepare("SELECT * FROM chatroom WHERE (userid = '$cui' AND userid7 = '$mr') OR (userid = '$mr' AND userid7 = '$cui')");
										$cst->execute();
										
										if($cst->rowCount() > 0)
										{
											$cst_data = $cst->fetch();
											$chatrid = $cst_data['chatroomid'];
										}else{ $chatrid = 0; }
										
										// Member Chat
										$chkc = $conn->prepare("SELECT * FROM tr_notification WHERE send_from = '$mr' AND send_to = '$cui' AND is_open != '1' AND is_group != '1'");
										$chkc->execute();
										
										if($chkc->rowCount() > 0)
										{ $notic = "<span class='label label-warning'>" . $chkc->rowCount() . "</span>"; }
										else{ $notic = ""; }
							?>
										<!-- Start display list of data !-->
										<tr>
											<td>
												<?php if($cst->rowCount() > 0){}else{ ?><a href="invite.php?ids=<?php echo $sql_data['user_id']; ?>" title="Invite to Chat"><span class="icon icon-blue icon-messages"/></a>
												&nbsp; &nbsp;<?php } ?>
												<?php if($cst->rowCount() > 0){ ?><a href="index.php?ids=<?php echo $sql_data['user_id']; ?>&id=<?php echo $chatrid; ?>"><?php }else{} ?>
													<?php echo $sql_data['firstname']; ?> <?php echo $sql_data['lastname']; ?> &nbsp; <?php echo $notic; ?>
												<?php if($cst->rowCount() > 0){ ?></a><?php }else{} ?>
											</td>
										</tr>
										<!-- End display list of data !-->
							<?php
									}
								}
								else
								{}
							?>
							
						  </tbody>
						</table>            
					</div>
				</div><!--/span-->								
			<!-- END MEMBERS LIST !--->
			
			<!-- START GROUP CHAT LIST !--->
				<div class="box span3">
					<div class="box-header well" data-original-title>
						<h2>
							<i class="icon icon-black icon-users"></i> List of Group Chat</h2>						
						<div class="box-icon">																					
							<a href="../" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
						</div>
					</div>
					<div class="box-content">
					<?php if($user_data['access_level'] == 1){ ?><a href="groupchat.php" class="btn btn-success nyroModal">Add New</a><br /><br /><?php }else{} ?>
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
						<table class="table table-striped table-bordered bootstrap-datatable">
						  <thead>
							  <tr>
								  <th>Name</th>
							  </tr>
						  </thead>   
						  <tbody>
							<?php
								$cst7 = $conn->prepare("SELECT * FROM chatroom c, chat_member m WHERE m.userid = '$cui' AND c.chatroomid = m.chatroomid AND c.is_group = '1'");
								$cst7->execute();
								
								if($cst7->rowCount() > 0)
								{
									while($cst7_data = $cst7->fetch())
									{
										$chatrid7 = $cst7_data['chatroomid'];
										
										// Group Chat
										$chkg = $conn->prepare("SELECT * FROM tr_notification
													WHERE send_to = '".$_SESSION['chat_user_id']."' AND is_open != '1' AND chatroomid = '$chatrid7' AND is_group = '1'");
										$chkg->execute();
										
										if($chkg->rowCount() > 0)
										{ $notig = "<span class='label label-warning'>" . $chkg->rowCount() . "</span>"; }
										else{ $notig = ""; }	
							?>
										<!-- Start display list of data !-->
										<tr>
											<td>
												<a href="index.php?ids=7&id=<?php echo $chatrid7; ?>">
													<?php echo $cst7_data['chat_name']; ?> &nbsp; <?php echo $notig; ?>
												</a>
											</td>
										</tr>
										<!-- End display list of data !-->
							<?php
									} // End While
								}else{ echo "<tr><td>No group chat</td></tr>"; }
							?>
							
						  </tbody>
						</table>            
					</div>
				</div><!--/span-->								
			<!-- END GROUP CHAT LIST !--->
		</div><!--/row-->
		
		<div class="modal hide fade" id="myModal">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">X</button>
				<h3>Uploading Photo...</h3>
			</div>
			<div class="modal-body">
				<form method="POST" enctype="multipart/form-data" action="attachpicture.php">
					<div class="form-group input-group">
						<span class="input-group-addon" style="width:150px;">Photo:</span>
						<input class="input-file uniform_on" name="fileImage" id="fileInput" type="file" />
						<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
					</div>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal">Close</a>
				<!--<a href="#" class="btn btn-primary">Save changes</a>!-->
				<button type="submit" class="btn btn-primary">Upload</button>
			</div>
				</form>
		</div>
						