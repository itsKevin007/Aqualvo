<?php
if (!defined('WEB_ROOT')) {
	exit;
}

	$dnum = $_GET['id'];
	
$errorMessage = (isset($_GET['error']) && $_GET['error'] != '') ? $_GET['error'] : '&nbsp;'
?>
<head>
<style rel="stylesheet">
.first
{   
   background-color: #DEE3DC;
}
.second
{   
   background-color: #E3FFD6;
}
.third
{   
   background-color: #C5FCAC;
}
.fourth
{   
   background-color: #EEDEFF;
}
.fifth
{   
   background-color: #30E5FC;
}
.sixth
{   
   background-color: #FAC0CF;
}
.seventh
{   
   background-color: #C9C9C9;
}
</style>
</head>
		<div class="row-fluid sortable">
				<div class="box span6">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-tasks"></i> Generate Schedule</h2>
					</div>
										
					<div class="box-content">
					<form class="form-horizontal" method="post" action="index.php?view=generate&action=generate" name="frm" id="frm">							
						<fieldset>
						<i class="icon icon-green icon-calendar"></i> <b>Search Customer</b><br /><br />
							<div class="control-group">
								<label class="control-label" for="selectError">Customer</label>
								<div class="controls">
								  <select class="input-xlarge" id="selectError" multiple name="customer[]" data-rel="chosen">									
									<?php
										$vio = $conn->prepare("SELECT * FROM bs_customer WHERE is_deleted != '1' ORDER BY client_name");
										$vio->execute();
										
										if($vio->rowCount() > 0)
										{
											while($vio_data = $vio->fetch())
											{
												
									?>
												<option value="<?php echo $vio_data['cust_id']; ?>"><?php echo ucwords(strtolower($vio_data['client_name'])); ?></option>
									<?php
											}
										}
										else
										{
												echo "No data yet!";
										}
									?>
								  </select>
								</div>
							</div>
						</fieldset>					
							<div class="form-actions">
								<input type="hidden" name="dnum" value="<?php echo $dnum; ?>" />
								<button type="submit" class="btn btn-success" onClick="return confirmSubmit()">Submit</button>								
							</div>							
					</form>							
					</div>
					
				</div>
				<div class="box span6">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-calendar"></i> List of Schedule</h2>
						<!--&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:add();" class="btn btn-success">Add New</a>!-->
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
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
								  <th style="display:none;">#</th>
								  <th>Date</th>								  
								  <th>Day</th>								  
								  <!--<th>Action</th>!-->
							  </tr>
						  </thead>   
						  <tbody>
							<?php
								$sql = $conn->prepare("SELECT * FROM tr_schedule WHERE is_deleted != '1' AND dt_num = '$dnum'
											GROUP BY dt_date ORDER BY dt_date DESC");
								$sql->execute();
															
								if($sql->rowCount() > 0)
								{
									$ctr = 1;
									while($sql_data = $sql->fetch())
									{
																				
										# Format Date to words
										$wfrom = date("M d, Y", strtotime($sql_data['dt_date']));												
							?>
										<!-- Start display list of schedules !-->
										<tr>
											<td style="display:none;"><?php echo $ctr--; ?></td>
											<td><a href="index.php?view=list&code=<?php echo $sql_data['sch_id']; ?>&id=<?php echo $dnum; ?>"><?php echo $wfrom; ?></a></td>
											<td><?php echo $sql_data['dt_day']; ?></td>
											<!--<td>
												<a class="btn btn-danger" href="javascript:del(<?php echo $sql_data['sch_id']; ?>);" title="Delete">
													<i class="icon-trash icon-white"></i>
												</a>
											</td>!-->
										</tr>
										<!-- End display list of schedules !-->
							<?php
									} // End While
								}else{}
							?>
							
						  </tbody>
						</table>            
					</div>
				</div><!--/span-->
		</div>		
				<!-- Start schedule Details !-->	
				<?php				
					// make sure a code exists
					if (isset($_GET['code']) && $_GET['code'] > 0) 
					{
						$p_code = $_GET['code'];												
						
						$bsp = $conn->prepare("SELECT * FROM tr_schedule WHERE sch_id = '$p_code'");
						$bsp->execute();
						$bsp_data = $bsp->fetch();
						
						
						# Format Date to words
						$wfrom = date("M d, Y", strtotime($bsp_data['dt_date']));
						$wto = date("l", strtotime($bsp_data['dt_date']));
						$dddate = $bsp_data['dt_date'];
						
				?>
					<div class="row-fluid sortable">
						<div class="box span12">
							<div class="box-header well" data-original-title>
								<h2><i class="icon-calendar"></i> <?php echo $wfrom; ?> - <?php echo $wto; ?>&nbsp;&nbsp;
									<a class="btn btn-small" href="print_summary.php?code=<?php echo $p_code; ?>" target=_new>
										<i class="icon-print"></i>  
										Print                                            
									</a>
								</h2>
								<div class="box-icon">																					
									<a href="../" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>							
								</div>
							</div>
							<div class="box-content">	
								<table class="table table-bordered bootstrap-datatable datatable">
								  <thead>
									  <tr>
										<td class="first">#</td>
										<td class="first">Customer</td>
										<td class="first">Contact #</td>																																														
										<td class="second">Price</td>										
										<td class="second">Round</td>										
										<td class="second">Slim</td>										
										<td class="second">Damage</td>
										<td class="fourth">Sales</td>
										<td class="fifth">Remarks</td>
										<td class="sixth">Delete</td>
									</tr>
								  </thead>   
								  <tbody>
									<?php
										$col_a = 1001; $coll_a = 1001;
										$trp = $conn->prepare("SELECT * FROM bs_customer c, tr_schedule s
													WHERE s.dt_date = '$dddate' AND c.cust_id = s.client_id AND s.is_deleted != '1'												
															ORDER BY c.client_name, s.dt_date");
										$trp->execute();
										
										if($trp->rowCount() > 0)
										{
											$ctr = 1;
											while($trp_data = $trp->fetch())
											{												
												
												/* Format the fields to be displayed for user */
													$client_name = ucwords(strtolower($trp_data['client_name']));		
													/* End Format */
																																																								
												
									?>
												<!-- Start display list of schedules !-->
												<tr>
													<td class="first"><?php echo $ctr++; ?>. </td>
													<td class="first"><?php echo $trp_data['client_name']; ?></td>	
													<td class="first"><?php echo $trp_data['contactno']; ?></td>																								
													<td class="second">--</td>
													<td class="second">--</td>													
													<td class="second">--</td>													
													<td class="second">--</td>
													<td class="fourth">--</td>
													<td class="fifth">--</td>
													<td class="sixth">
														<a class="btn btn-danger" href="javascript:delc(<?php echo $trp_data['client_id']; ?>,<?php echo $trp_data['dt_num']; ?>);">
															<i class="icon-trash icon-white"></i> 															
														</a>
													</td>
												</tr>
												<!-- End display list of schedules !-->
									<?php
												
											} // End While											
										}else{}
									?>
									
								  </tbody>
								</table>            
							</div>
						</div><!--/span-->
					</div><!--/row-->
				<?php }else{} ?>
				<!-- End schedule Details !-->		
						