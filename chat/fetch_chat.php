<?php	
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
checkUser();
	if(isset($_POST['fetch'])){
		$id = $_POST['id'];
		
		$sq=mysqli_query($link,"select * from `bs_user` where user_id='".$_SESSION['chat_user_id']."'");
		$srow=mysqli_fetch_array($sq);
		$chid = $srow['user_id'];
	
		$query=mysqli_query($link,"select * from `chat` left join `bs_user` on bs_user.user_id=chat.userid where chatroomid='$id' order by chat_date asc") or die(mysqli_error());
		while($row=mysqli_fetch_array($query)){
			
			if($chid == $row['userid'])
			{				
				$bgcl = "#0099ff";
				$wd = "60%";
				$flr = "right";
				$clr = "#ffffff";
				$mrg = "85px";
			}else{
				$bgcl = "#cccccc";
				$wd = "60%";
				$flr = "left";
				$clr = "#000000";
				$mrg = "0";
			}
			
			if ($row['thumbnail']) {
				$thumbnail = WEB_ROOT . 'images/user/' . $row['thumbnail'];
			} else {
				$thumbnail = WEB_ROOT . 'images/user/noimagesmall.png';
			}
			
		?>	
		
		<div style="font-family:Verdana; text-outline:border:solid 0px; background:<?php echo $bgcl; ?>; color:<?php echo $clr; ?>; width:<?php echo $wd; ?>; margin-left:<?php echo $mrg; ?>; border-radius: 13px;">			
				<img src="<?php echo $thumbnail; ?>" style="height:30px; width:30px; position:relative; top:15px; left:10px;">
				<span style="font-size:10px; position:relative; top:7px; left:15px;"><i><?php echo date('M-d-Y h:i A',strtotime($row['chat_date'])); ?></i></span><br />
				<span style="font-size:100%; position:relative; top:-2px; left:45px; border:solid 0px;">
					<strong><?php echo $row['firstname']; ?></strong>: 
					<div style="width:75%; word-wrap: break-word;"><?php echo $row['message']; ?></div>
				</span><br/ >
				<?php
					// Display picture
					if ($row['chat_thumbnail']) 
					{ 
						$thumb = '../images/chat/' . $row['chat_thumbnail'];
						$image = '../images/chat/' . $row['chat_image'];
				?>
						<span style="font-size:100%; position:relative; top:-2px; left:0px;"><a href="<?php echo $image; ?>" class="example-image-link" data-lightbox="example-1"><img src="<?php echo $image; ?>" class="example-image" /></a></span><br />
				<?php }else{} ?>
				<?php
					// Display video
					if ($row['video']) 
					{ 
						$video = '../videos/chat/' . $row['video'];
						if($row['video_type'] == 'image')
						{
				?>
							<span style="font-size:100%; position:relative; top:-2px; left:50px;"><img src="<?php echo $video; ?>" /></span><br />
					<?php }else{ ?>
							
					<?php } ?>
				<?php }else{} ?>		
		</div>
		
		<div style="height:5px; border:solid 0px;"></div>
		<?php
			mysqli_query($link, "UPDATE tr_notification SET is_open = '1' WHERE send_to = '".$_SESSION['chat_user_id']."' AND chatroomid = '$id'");
		}		
	}
	
	$chk = $conn->prepare("SELECT * FROM chat WHERE chatroomid='$id' AND userid != '".$_SESSION['chat_user_id']."' AND is_new = '1'");
	$chk->execute();
	
	if($chk->rowCount() == 1)
	{
?>
		<script>document.getElementById("beepSound").play();</script>
<?php 
		mysqli_query($link, "UPDATE chat SET is_new = '0' WHERE userid != '".$_SESSION['chat_user_id']."' AND chatroomid = '$id' AND is_new = '1'");
	}else{} 
?>