<?php
require_once 'global-library/config.php';
require_once 'global-library/functions.php';

$_SESSION['login_return_url'] = $_SERVER['REQUEST_URI'];
checkUser();

	if(isset($_GET['id']))
	{
		$pdId = $_GET['id'];	
	}else{
		$pdId = '';
	}		
	include 'insert.php';
?>
<table border="0" width="1300">
<tr>
	<td>
<?php
	$c = 0;
	$categoryPerRow = 2;
	$productsPerRow = 2;
	$sql = "SELECT * FROM bs_item WHERE is_deleted != '1' ORDER BY ord";
	$rs = dbQuery($sql);
	$num = dbNumRows($rs);
	if($num > 0)
	{
?>
		<div class="box span6">
			<div class="box-header well" data-original-title>
				<h2><i class="icon-hdd"></i> Item</h2>
			</div>							
				<div class="box-content">		
					<?php
						echo '<table border=0 width=100% cellpadding=0 cellspacing=0>';
						while($rw = dbFetchAssoc($rs))
						{
							extract($rw);
							if ($c % $categoryPerRow == 0) {
								echo '<tr>';
							}
					?>
								<td valign="top">
									<a data-rel="tooltip" title="<?php echo $name; ?>" class="well span3 top-block" href="index.php?id=<?php echo $item_id; ?>" style="width:200px;">
										<span class="<?php echo $icon; ?>"></span>
										<div><?php echo $name; ?></div>
										<div>Php <?php echo $price; ?></div>				
									</a>
								</td>
					<?php
							if ($c % $categoryPerRow == $categoryPerRow - 1) {
								echo '</tr>';
							}
							$c += 1;	
						} // End While
						echo '</table>';
					?>
				</div>
		</div>
<?php }else{} include 'cart.php'; ?>
	</td>
</tr>
</table>