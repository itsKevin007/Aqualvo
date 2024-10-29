<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
checkUser();

$view = (isset($_GET['view']) && $_GET['view'] != '') ? $_GET['view'] : '';

	# Get setting details
	$sett = $conn->prepare("SELECT * FROM bs_setting");
	$sett->execute();
	$sett_data = $sett->fetch();
	

switch ($view) {
	case 'list' :
		$content 	= 'list.php';
		$pageTitle 	= $sett_data['system_title'];
		break;
			
	default :
		$content 	= 'list.php';
		$pageTitle 	= $sett_data['system_title'];
}

$script    = array('chat.js');

require_once '../include/template.php';

	if(isset($_REQUEST['id']))
	{
		$id=$_REQUEST['id'];
	}
	if(isset($_GET['id']))
	{
		$id=$_GET['id'];
	}else{ $id=''; }
	
?>
<head>	
	<link rel="stylesheet" href="css/bootstrap.min.css" />
	<link rel="stylesheet" href="fonts/font.css" />
	<link rel="stylesheet" href="css/style.css" />			
	<link rel="shortcut icon" href="../images/favicon.ico">
	<!--<link rel="stylesheet" href="../global-library/dist/css/lightbox.min.css">!-->
	
</head>

<script>
$(document).ready(function(){
	
	$('#myChatRoom').DataTable({
	"sDom": '<"row view-filter"<"col-sm-12"<"pull-left"l><"pull-right"f><"clearfix">>>t<"row view-pager"<"col-sm-12"<"text-center"ip>>>',
	"bLengthChange": false,
	"bInfo": false,
	"bPaginate": true,
	"bFilter": false,
	"bSort": false,
	"pageLength": 8
	});

	displayChat();
	
		$(document).on('click', '#send_msg', function(){
			id = <?php echo $id; ?>;
			if($('#chat_msg').val() == ""){
				alert('Please write message first');
			}else{
				$msg = $('#chat_msg').val();
				$.ajax({
					type: "POST",
					url: "send_message.php",
					data: {
						msg: $msg,
						id: id,
					},
					success: function(){
						$('#chat_msg').val("");
						displayChat();						
					}
				});
			}	
		});
		
		$(document).on('click', '#confirm_leave', function(){
			id = <?php echo $id; ?>;
			$('#leave_room').modal('hide');
			$('body').removeClass('modal-open');
			$('.modal-backdrop').remove();
				$.ajax({
					type: "POST",
					url: "leaveroom.php",
					data: {
						id: id,
						leave: 1,
					},
					success: function(){
						window.location.href='index.php';
					}
				});
				
		});		
		
		$(document).on('click', '#confirm_delete', function(){
			id = <?php echo $id; ?>;
			$('#confirm_delete').modal('hide');
			$('body').removeClass('modal-open');
			$('.modal-backdrop').remove();
				$.ajax({
					type: "POST",
					url: "deleteroom.php",
					data: {
						id: id,
						del: 1,
					},
					success: function(){
						window.location.href='index.php';
					}
				});
				
		});
		
		$(document).keypress(function(e){
			if (e.which == 13){
			$("#send_msg").click();
			}
		});
		
		$("#user_details").hover(function(){
			$('.showme').removeClass('hidden');
		},function(){
			$('.showme').addClass('hidden');
		});
		
		//
	$(document).on('click', '.delete2', function(){
		var rid=$(this).val();
		$('#delete_room2').modal('show');
		$('.modal-footer #confirm_delete2').val(rid);
	});
	
	$(document).on('click', '#confirm_delete2', function(){
		var nrid=$(this).val();
		$('#delete_room2').modal('hide');
		$('body').removeClass('modal-open');
		$('.modal-backdrop').remove();
			$.ajax({
				url:"deleteroom.php",
				method:"POST",
				data:{
					id: nrid,
					del: 1,
				},
				success:function(){
					window.location.href='index.php';
				}
			});
	});
	
	$(document).on('click', '.leave2', function(){
		var rid=$(this).val();
		$('#leave_room2').modal('show');
		$('.modal-footer #confirm_leave2').val(rid);
	});
	
	$(document).on('click', '#confirm_leave2', function(){
		var nrid=$(this).val();
		$('#leave_room2').modal('hide');
		$('body').removeClass('modal-open');
		$('.modal-backdrop').remove();
			$.ajax({
				url:"leaveroom.php",
				method:"POST",
				data:{
					id: nrid,
					leave: 1,
				},
				success:function(){
					window.location.href='index.php';
				}
			});
	});
});

window.setInterval(function () {
    displayChat7();
	//$("#chat_area").scrollTop($("#chat_area")[1].scrollHeight);
}, 1000);

	
	function displayChat(){
		id = <?php echo $id; ?>;
		$.ajax({			
			url: 'fetch_chat.php',
			type: 'POST',
			async: false,
			data:{
				id: id,
				fetch: 1,
			},
			
			success: function(response){
				
				$('#chat_area').html(response);
				$("#chat_area").scrollTop($("#chat_area")[0].scrollHeight);	
				//document.getElementById("beepSound").play();
			}
		});
	}
	
	function displayChat7(){
		id = <?php echo $id; ?>;
		$.ajax({
			url: 'fetch_chat.php',
			type: 'POST',
			async: false,
			data:{
				id: id,
				fetch: 1,
			},
			
			success: function(response){
				$('#chat_area').html(response);
				$("#chat_area").scrollTop($("#chat_area")[-1].scrollHeight);
				
			}
		});		
	}
		
</script>
<!--<script src="../global-library/dist/js/lightbox-plus-jquery.min.js"></script>!-->
		<audio id="beepSound"> 
		  <source src="Buttercup.mp3" type="audio/mpeg"></source>
		  Your browser does not support the audio element.
		</audio>
		
	<!--<script> 
        $("#chat_msg").on("change", function() { 
            alert('Text content changed!<?php echo $id; ?>'); 
			<?php
			//	$up = "UPDATE chat SET is_seen = '1' WHERE chatroomid = '$id'";
			//	dbQuery($up);
			?>
        }); 
    </script>!-->