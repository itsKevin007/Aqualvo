<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

checkUser();

	$userId = $_SESSION['user_id'];
					
?>		
	<div class="row-fluid sortable">
		<form class="form-horizontal" method="post" action="create_group.php" enctype="multipart/form-data" name="form" id="form">
			<div class="modal-header">
				<h3>Create Group Chat</h3>
			</div>
			<div class="modal-body">
				<div class="control-group">
					<label class="control-label" for="selectError">Group Name</label>
						<div class="controls">
							<input class="input-xlarge focused" id="gname" name="gname" type="text" required autocomplete=off />				
						</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="selectError">Choose Employee</label>
						<div class="controls">
						<table width="100%" border="0" cellspacing="7" cellspacing="7">
							<?php																		
								$productsPerRow7 = 3; $columnWidth7 = (int)(100 / $productsPerRow7);
								$vio7 = $conn->prepare("SELECT * FROM bs_user WHERE is_deleted != '1' ORDER BY lastname");
								$vio7->execute();
								
								if($vio7->rowCount() > 0)
								{
									$i7 = 0;
									while($vio7_data = $vio7->fetch())
									{
										
										if ($i7 % $productsPerRow7 == 0) { echo '<tr>'; }
							?>
										<td valign="top"><input type="checkbox" name="member[]" value="<?php echo $user_id; ?>">&nbsp;&nbsp;<?php echo $vio7_data['lastname']; ?>, <?php echo $vio7_data['firstname']; ?>&nbsp;&nbsp;</td>
							<?php
										if ($i7 % $productsPerRow7 == $productsPerRow7 - 1) { echo '</tr>'; }
										$i7 += 1;
									} // End While
								}
								else
								{
										echo "No data yet!";
								}
							?>
						</table>
						</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-primary" onClick="return confirmSubmit()">Submit</button>
			</div>
		</form>
	</div>