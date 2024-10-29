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
				<div class="box span12">
					<div class="sortable row-fluid">
						<a data-rel="tooltip" title="Monday" class="well span3 top-block" href="index.php?view=list&id=1">
							<span class="icon32 icon-red icon-calendar"></span>
							<div>Monday</div>
							<div></div>
							<span class="notification"></span>
						</a>

						<a data-rel="tooltip" title="Tuesday" class="well span3 top-block" href="index.php?view=list&id=2">
							<span class="icon32 icon-red icon-calendar"></span>
							<div>Tuesday</div>
							<div></div>
							<span class="notification"></span>
						</a>

						<a data-rel="tooltip" title="Wednesday" class="well span3 top-block" href="index.php?view=list&id=3">
							<span class="icon32 icon-red icon-calendar"></span>
							<div>Wednesday</div>
							<div></div>
							<span class="notification"></span>
						</a>
						
						<a data-rel="tooltip" title="Thursday" class="well span3 top-block" href="index.php?view=list&id=4">
							<span class="icon32 icon-red icon-calendar"></span>
							<div>Thursday</div>
							<div></div>
							<span class="notification"></span>
						</a>
						
						<a data-rel="tooltip" title="Friday" class="well span3 top-block" href="index.php?view=list&id=5">
							<span class="icon32 icon-red icon-calendar"></span>
							<div>Friday</div>
							<div></div>
							<span class="notification"></span>
						</a>
						
						<a data-rel="tooltip" title="Saturday" class="well span3 top-block" href="index.php?view=list&id=6">
							<span class="icon32 icon-red icon-calendar"></span>
							<div>Saturday</div>
							<div></div>
							<span class="notification"></span>
						</a>
					</div>				
				</div>				
		</div>		
				
						