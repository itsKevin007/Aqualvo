<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';
checkUser();

if (!isset($_GET['oid']) || (int)$_GET['oid'] <= 0) {
	header('Location: index.php');
}

$orderId = (int)$_GET['oid'];
$userId = $_SESSION['user_id'];

$dt = $conn->prepare("SELECT * FROM tr_transaction WHERE tr_id = '$orderId'");
$dt->execute();
$dt_data = $dt->fetch();
$orderdate = date("m-d-y | g:i a",strtotime($dt_data['od_date']));

//$orderId = 1042;
$dsgn1 = "style='font-size:13px; font-family: Calibri; font-weight:bold;'";

?>
<head>
<title>Ticket</title>
<script type="text/javascript">     
    function PrintDiv() {    
       var divToPrint = document.getElementById('divToPrint');
       var popupWin = window.open('', '_blank', 'width=auto', 'height=auto');
       popupWin.document.open();
       popupWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</html>');
        popupWin.document.close();
            }
 </script>
 <style rel="stylesheet" type="text/css">
	body {
		font-weight:bold;
	}
	.ctd {
		font-family: 'Calibri', sans-serif;
		font-weight:bold;
	}
 </style>
</head>
<body onload="PrintDiv()">
	<table id="divToPrint" style="display:none;">
	<tr>
		<td><?php echo $orderdate; ?></td>
	</tr>
	<tr>
		<td>			
					<?php
						$sql = $conn->prepare("SELECT * FROM tr_transaction t, bs_item i, tr_transaction_detail d
									WHERE t.tr_id = d.tr_id AND d.item_id = i.item_id AND t.tr_id = '$orderId'
											ORDER BY i.ord");
						$sql->execute();
					
						if ($sql->rowCount() > 0) 
						{
					?>									
							<table border="0" width="100">							
									<?php
											$subTotal = 0; $total = 0; $ctr = 1;
											while($sql_data = $sql->fetch())
											{
												
												$subTotal += $tr_qty;
									?>				
											  <tr>												
												<td><?php echo $abrv; ?></td>
												<td><?php echo number_format($tr_qty, 0); ?></td>
											  </tr>
									<?php
												
											} // End For
											
									?>
									<!--<tr>
										<td>T</td>
										<td></?php echo $subTotal; ?></td>
									</tr>!-->
									<tr><td><br />--</td></tr>
							</table>							
							
					<?php
						}else{ echo "Transaction Is Empty"; } 
					?>
									
		</td>
	</tr>
	</table>
<?php	
		$url = "../index.php";
		echo "<meta http-equiv=\"refresh\" content=\"1;URL=$url\">";	
?>
</body>