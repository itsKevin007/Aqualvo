	<script language="JavaScript" type="text/javascript" src="<?php echo WEB_ROOT; ?>global-library/js/left-menu.js"></script>
	<script language="JavaScript" type="text/javascript" src="<?php echo WEB_ROOT; ?>global-library/js/eval_left-menu.js"></script>
	<script language="JavaScript" type="text/javascript" src="<?php echo WEB_ROOT; ?>global-library/js/select_all.js"></script>
	<script type="text/javascript" src="<?php echo WEB_ROOT; ?>global-library/tiny_mce/tiny_mce.js"></script>
	<script language="JavaScript" type="text/javascript" src="<?php echo WEB_ROOT;?>global-library/common.js"></script>
	<script type="text/javascript">
	tinyMCE.init({
		mode : "textareas",
		theme : "simple"
	});
	</script>
	<?php
		
		if (is_array($script) || $script instanceof Countable) {
			$n = count($script);
		} else {
			// Handle the case where $script is not countable
			$n = 0; // Or any other appropriate default value
		}
		
		//$n = count($script);
		for ($i = 0; $i < $n; $i++) 
		{
			if ($script[$i] != '') 
			{
				echo '<script language="JavaScript" type="text/javascript" src="' . WEB_ROOT . 'global-library/js/misc/'.$script[$i].'"></script>';								
			}
		}
	?>
	<!-- Disable button if checkbox is empty !-->
	<script type="text/javascript">
		function leaveChecker()
		{
			if(document.frm.theCheck.checked==false)
			{
				document.frm.sick.disabled=true;
				document.frm.vacation.disabled=true;
				document.frm.special.disabled=true;
			}
			else
			{
				document.frm.sick.disabled=false;
				document.frm.vacation.disabled=false;
				document.frm.special.disabled=false;
			}
		}
	</script>
	
	<!-- Confirm Submission of Form !-->
	<script LANGUAGE="JavaScript">
	<!--
		// Nannette Thacker http://www.shiningstar.net
		function confirmSubmit()
		{
			var agree=confirm("Make sure all informations are correct. Changes are not allowed once submitted. Please confirm to continue.");
			if (agree)
			return true ;
		else
			return false ;
		}
	// -->
	</script>
	
	<SCRIPT language=Javascript>
      <!--
      function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
		
         return true;
      }
      //-->
   </SCRIPT>
	
	<!-- Time Picker Library 
	<link rel="stylesheet" href="</?php echo WEB_ROOT; ?>global-library/timepicker/include/ui-1.10.0/ui-lightness/jquery-ui-1.10.0.custom.min.css" type="text/css" />
    <link rel="stylesheet" href="</?php echo WEB_ROOT; ?>global-library/timepicker/jquery.ui.timepicker.css?v=0.3.2" type="text/css" />

    <script type="text/javascript" src="</?php echo WEB_ROOT; ?>global-library/timepicker/include/jquery-1.9.0.min.js"></script>
    <script type="text/javascript" src="</?php echo WEB_ROOT; ?>global-library/timepicker/include/ui-1.10.0/jquery.ui.core.min.js"></script>
    <script type="text/javascript" src="</?php echo WEB_ROOT; ?>global-library/timepicker/include/ui-1.10.0/jquery.ui.widget.min.js"></script>
    <script type="text/javascript" src="</?php echo WEB_ROOT; ?>global-library/timepicker/include/ui-1.10.0/jquery.ui.tabs.min.js"></script>
    <script type="text/javascript" src="</?php echo WEB_ROOT; ?>global-library/timepicker/include/ui-1.10.0/jquery.ui.position.min.js"></script>

    <script type="text/javascript" src="</?php echo WEB_ROOT; ?>global-library/timepicker/jquery.ui.timepicker.js?v=0.3.2"></script>
	<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
	!-->
	<!-- End Time Picker !-->
	
	
	<!-- End Confirm !-->
	
	<!-- Libraries for date picker feature !-->
	<!--<script src="</?php echo WEB_ROOT; ?>global-library/js/mypicker/jquery.js"></script>
    <script type="text/javascript" src="</?php echo WEB_ROOT; ?>global-library/js/mypicker/jquery-ui.min.js"></script>
    <link rel="stylesheet" type="text/css" media="screen" href="</?php echo WEB_ROOT; ?>global-library/js/mypicker/jquery-ui.css">
	<script type="text/javascript">
		$(function() {
			$('.date-picker').datepicker( {
			changeMonth: true,
			changeYear: true,
			showButtonPanel: true,
			dateFormat: 'MM yy',
			onClose: function(dateText, inst) { 
				var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
				var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
				$(this).datepicker('setDate', new Date(year, month, 1));
				}
			});
		});
	</script>
	<style>
		.ui-datepicker-calendar {
		display: none;
		}
	</style>!-->
	
	<!-- Pop Up nyroModal Library !-->
	<link rel="stylesheet" href="<?php echo WEB_ROOT; ?>global-library/nyroModal/styles/nyroModalCal.css" type="text/css" media="screen" />
	<script type="text/javascript" src="<?php echo WEB_ROOT; ?>global-library/nyroModal/js/jquery.min.js"></script>	
	<script type="text/javascript" src="<?php echo WEB_ROOT; ?>global-library/nyroModal/js/jquery.nyroModal-1.6.2.pack.js"></script>
	
	<!-- DropDown Hide/UnHide Library !-->
	<style rel="stylesheet" type="text/css">
		.hidden { display: none; }
		.unhidden { display: block; }
	
		.hidden { visibility: hidden; }
		.unhidden { visibility: visible; }
	
	</style>

	<script type="text/javascript">
		function unhide(divID) {
			var item = document.getElementById(divID);
			var item2 = document.getElementById(col2);
			if (item) {
				item.className=(item.className=='hidden')?'unhidden':'hidden';
				item2.className=(item2.className=='unhidden')?'hidden':'unhidden';
			}
 
		}
	</script>
	<!-- DropDown Hide/UnHide Library !-->