<?php
if (!defined('WEB_ROOT')) {
	exit;
}


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
						<i class="icon icon-green icon-calendar"></i> <b>Search Date</b><br /><br />
							<div class="control-group">
								<label class="control-label" for="date01">From</label>
								<div class="controls">
									<input type="text" class="input-xlarge" id="txtFromDate" name="from" onkeypress="return isNumberKey(event)" autocomplete=off required />										
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="date01">To</label>
								<div class="controls">
									<input type="text" class="input-xlarge" id="txtToDate" name="to" onkeypress="return isNumberKey(event)" autocomplete=off required />										
								</div>
							</div>
						</fieldset>					
							<div class="form-actions">
								<input type="hidden" name="reportId" value="<?php echo $reportId; ?>" />
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
								  <th>Code</th>								  
								  <th>From</th>
								  <th>To</th>
								  <th>Action</th>
							  </tr>
						  </thead>   
						  <tbody>
							<?php
								if($sql->rowCount() > 0)
								{
									$ctr = 1;
									while($sql_data = $sql->fetch())
									{
																					
										# Format Date to words
										$wfrom = date("M d, Y", strtotime($date_from));	
										$wto = date("M d, Y", strtotime($date_to));						
							?>
										<!-- Start display list of schedules !-->
										<tr>
											<td style="display:none;"><?php echo $ctr--; ?></td>
											<td><a href="index.php?view=list&code=<?php echo $schedule_code; ?>"><?php echo $schedule_code; ?></a></td>
											<td><?php echo $wfrom; ?></td>											
											<td><?php echo $wto; ?></td>
											<td>
												<a class="btn btn-danger" href="javascript:del(<?php echo $bs_sch_id; ?>);" title="Delete">
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
		</div>		
				<!-- Start schedule Details !-->	
				<?php				
					// make sure a code exists
					if (isset($_GET['code']) && $_GET['code'] > 0) 
					{
						$p_code = $_GET['code'];
						
						$bsp = $conn->prepare("SELECT * FROM bs_schedule WHERE schedule_code = '$p_code'");
						$bsp->execute();
						$bsp_data = $bsp->fetch();
						
						
						# Format Date to words
						$wfrom = date("M d, Y", strtotime($date_from));	
						$wto = date("M d, Y", strtotime($date_to));
						
						$startTimeStamp = strtotime($date_from);
						$endTimeStamp = strtotime($date_to);

						$timeDiff = abs($endTimeStamp - $startTimeStamp);

						$numberDays = $timeDiff/86400;  // 86400 seconds in one day

						// and you might want to convert to integer
						$TotalnumberDays = intval($numberDays) + 1;
				?>
					<div class="row-fluid sortable">
						<div class="box span12">
							<div class="box-header well" data-original-title>
								<h2><i class="icon-calendar"></i> <?php echo $wfrom; ?> to <?php echo $wto; ?>&nbsp;&nbsp;
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
										<td class="first">Id</td>
										<td class="first">Name</td>																																														
										<td class="second">Time IN</td>										
										<td class="second">Break IN</td>										
										<td class="second">Break OUT</td>										
										<td class="second">Time OUT</td>
										<td class="fourth">Date</td>
									</tr>
								  </thead>   
								  <tbody>
									<?php
										$col_a = 1001; $coll_a = 1001;
										$trp = $conn->prepare("SELECT * FROM bs_employee e, tr_schedule s
													WHERE s.bs_sch_id = '$bs_sch_id' AND e.emp_id = s.emp_id														
															ORDER BY e.lastname, s.sch_date");
										$trp->execute();
										
										if($trp->rowCount() > 0)
										{
											$ctr = 1;
											while($trp_data = $trp->fetch())
											{												
												
												/* Format the fields to be displayed for user */
													$fullname = ucwords(strtolower($trp_data['lastname'])) . ',&nbsp;' . ucwords(strtolower($trp_data['firstname']));		
													/* End Format */
																					
													/* Check if employee has picture then display */
													if ($thumbnail) {
														$emp_image = WEB_ROOT . 'images/employee/' . $thumbnail;
													} else {
														$emp_image = WEB_ROOT . 'images/no-image-small.png';
													}
												/* End Picture */																								
												
									?>
												<!-- Start display list of schedules !-->
												<tr>
													<td class="first"><?php echo $ctr++; ?>. </td>
													<td class="first"><?php echo $emp_id; ?></td>	
													<td class="first">
														<a href="detail.php?eid=<?php echo $emp_id; ?>&pid=<?php echo $bs_sch_id; ?>" class="nyroModal"><?php echo utf8_encode($fullname); ?></a>
													</td>																								
													<td class="second"><?php echo $sch_timein; ?></td>
													<td class="second"><?php echo $sch_breakin; ?></td>													
													<td class="second"><?php echo $sch_breakout; ?></td>													
													<td class="second"><?php echo $sch_timeout; ?></td>
													<td class="fourth"><?php echo $sch_date; ?></td>
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
						