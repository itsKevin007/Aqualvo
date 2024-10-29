<!-- external javascript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->

	<!-- jQuery -->
	<script src="<?php echo WEB_ROOT; ?>global-library/js/jquery-1.7.2.min.js"></script>
	<!-- jQuery UI -->
	<script src="<?php echo WEB_ROOT; ?>global-library/js/jquery-ui-1.8.21.custom.min.js"></script>
	<!-- transition / effect library -->
	<script src="<?php echo WEB_ROOT; ?>global-library/js/bootstrap-transition.js"></script>
	<!-- alert enhancer library -->
	<script src="<?php echo WEB_ROOT; ?>global-library/js/bootstrap-alert.js"></script>
	<!-- modal / dialog library -->
	<script src="<?php echo WEB_ROOT; ?>global-library/js/bootstrap-modal.js"></script>
	<!-- custom dropdown library -->
	<script src="<?php echo WEB_ROOT; ?>global-library/js/bootstrap-dropdown.js"></script>
	<!-- scrolspy library -->
	<script src="<?php echo WEB_ROOT; ?>global-library/js/bootstrap-scrollspy.js"></script>
	<!-- library for creating tabs -->
	<script src="<?php echo WEB_ROOT; ?>global-library/js/bootstrap-tab.js"></script>
	<!-- library for advanced tooltip -->
	<script src="<?php echo WEB_ROOT; ?>global-library/js/bootstrap-tooltip.js"></script>
	<!-- popover effect library -->
	<script src="<?php echo WEB_ROOT; ?>global-library/js/bootstrap-popover.js"></script>
	<!-- button enhancer library -->
	<script src="<?php echo WEB_ROOT; ?>global-library/js/bootstrap-button.js"></script>
	<!-- accordion library (optional, not used in demo) -->
	<script src="<?php echo WEB_ROOT; ?>global-library/js/bootstrap-collapse.js"></script>
	<!-- carousel slideshow library (optional, not used in demo) -->
	<script src="<?php echo WEB_ROOT; ?>global-library/js/bootstrap-carousel.js"></script>
	<!-- autocomplete library -->
	<script src="<?php echo WEB_ROOT; ?>global-library/js/bootstrap-typeahead.js"></script>
	<!-- tour library -->
	<script src="<?php echo WEB_ROOT; ?>global-library/js/bootstrap-tour.js"></script>
	<!-- library for cookie management -->
	<script src="<?php echo WEB_ROOT; ?>global-library/js/jquery.cookie.js"></script>
	<!-- calander plugin -->
	<script src='<?php echo WEB_ROOT; ?>global-library/js/fullcalendar.min.js'></script>
	<!-- data table plugin -->
	<script src='<?php echo WEB_ROOT; ?>global-library/js/jquery.dataTables.min.js'></script>

	<script>
		$(document).ready(function(){
			setTimeout(function(){
				$(".valid_box").fadeOut("slow", function () {
				$(".valid_box").remove();
			});
			}, 10000);
		});
		
		$(document).ready(function(){
			setTimeout(function(){
				$(".error_box").fadeOut("slow", function () {
				$(".error_box").remove();
			});
			}, 10000);
		});
	</script>
	
	<!-- select or dropdown enhancer -->
	<script src="<?php echo WEB_ROOT; ?>global-library/js/jquery.chosen.min.js"></script>
	<!-- checkbox, radio, and file input styler -->
	<script src="<?php echo WEB_ROOT; ?>global-library/js/jquery.uniform.min.js"></script>
	<!-- plugin for gallery image view -->
	<script src="<?php echo WEB_ROOT; ?>global-library/js/jquery.colorbox.min.js"></script>
	<!-- rich text editor library -->
	<script src="<?php echo WEB_ROOT; ?>global-library/js/jquery.cleditor.min.js"></script>
	<!-- notification plugin -->
	<script src="<?php echo WEB_ROOT; ?>global-library/js/jquery.noty.js"></script>
	<!-- file manager library -->
	<script src="<?php echo WEB_ROOT; ?>global-library/js/jquery.elfinder.min.js"></script>
	<!-- star rating plugin -->
	<script src="<?php echo WEB_ROOT; ?>global-library/js/jquery.raty.min.js"></script>
	<!-- for iOS style toggle switch -->
	<script src="<?php echo WEB_ROOT; ?>global-library/js/jquery.iphone.toggle.js"></script>
	<!-- autogrowing textarea plugin -->
	<script src="<?php echo WEB_ROOT; ?>global-library/js/jquery.autogrow-textarea.js"></script>
	<!-- multiple file upload plugin -->
	<script src="<?php echo WEB_ROOT; ?>global-library/js/jquery.uploadify-3.1.min.js"></script>
	<!-- history.js for cross-browser state change on ajax -->
	<script src="<?php echo WEB_ROOT; ?>global-library/js/jquery.history.js"></script>
	<!-- application script for Charisma demo -->
	<script src="<?php echo WEB_ROOT; ?>global-library/js/charisma.js"></script>