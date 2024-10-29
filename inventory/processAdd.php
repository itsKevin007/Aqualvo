<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

checkUser();

$action = isset($_GET['action']) ? $_GET['action'] : '';
switch ($action) {
	
    case 'add_material' :
        add_material();
        break;
      
    case 'add_salt' :
        add_salt();
        break;
        
    case 'add_dispenser' :
        add_dispenser();
        break;
	
	case 'add_filter' :
        add_filter();
        break;			
	
    default :
        // if action is not defined or unknown
        // move to main category page
        header('Location: index.php');
}

function add_material()
{
	include '../global-library/database.php';
	date_default_timezone_set("Asia/Manila");
	$today_date1 = date("Y-m-d H:i:s");

	$userId = $_SESSION['user_id'];
	
	$from = mysqli_real_escape_string($link, $_POST['from']);
	$inv_date = date("Y-m-d", strtotime($from));
	$supplier = mysqli_real_escape_string($link, $_POST['supplier']);
	$invno = mysqli_real_escape_string($link, $_POST['invno']);	
	$price = mysqli_real_escape_string($link, $_POST['price']);	
	$tin = mysqli_real_escape_string($link, $_POST['tin']);	
	$tout = mysqli_real_escape_string($link, $_POST['tout']);	
	$rby = mysqli_real_escape_string($link, $_POST['rby']);
	

			/* Insert Data */
			$sql = $conn->prepare("INSERT INTO tr_inventory_material (inv_date, supplier, inv_no, unit_price, qty_in, qty_out, received_by, date_added)
						VALUES ('$inv_date', '$supplier', '$invno', '$price', '$tin', '$tout', '$rby', '$today_date1')");
			$sql->execute();
			/* End Data */
		
		
			/* Insert Log */
			$log = $conn->prepare("INSERT INTO tr_log (action, description, category, action_by, log_action_date)
						VALUES ('Material added', '$invno', 'inventory', '$userId', '$today_date1')");
			$log->execute();
			/* End Log */

		header('Location: index.php?view=add_material&error=' . urlencode('Added successfully'));

}

function add_salt()
{
	include '../global-library/database.php';
	date_default_timezone_set("Asia/Manila");
	$today_date1 = date("Y-m-d H:i:s");

	$userId = $_SESSION['user_id'];
	
	$from = mysqli_real_escape_string($link, $_POST['from']);
	$inv_date = date("Y-m-d", strtotime($from));
	$supplier = mysqli_real_escape_string($link, $_POST['supplier']);
	$invno = mysqli_real_escape_string($link, $_POST['invno']);
	$uqty = mysqli_real_escape_string($link, $_POST['uqty']);	
	$price = mysqli_real_escape_string($link, $_POST['price']);
	$qty = mysqli_real_escape_string($link, $_POST['qty']);	
	$tin = mysqli_real_escape_string($link, $_POST['tin']);	
	$tout = mysqli_real_escape_string($link, $_POST['tout']);	
	$rby = mysqli_real_escape_string($link, $_POST['rby']);
	

			/* Insert Data */
			$sql = $conn->prepare("INSERT INTO tr_inventory_salt (inv_date, supplier, inv_no, unit_qty, unit_price, qty, qty_in, qty_out, received_by, date_added)
						VALUES ('$inv_date', '$supplier', '$invno', '$uqty', '$price', '$qty', '$tin', '$tout', '$rby', '$today_date1')");
			$sql->execute();
			/* End Data */
		
		
			/* Insert Log */
			$log = $conn->prepare("INSERT INTO tr_log (action, description, category, action_by, log_action_date)
						VALUES ('Salt added', '$invno', 'inventory', '$userId', '$today_date1')");
			$log->execute();
			/* End Log */

		header('Location: index.php?view=add_salt&error=' . urlencode('Added successfully'));

}

function add_dispenser()
{
	include '../global-library/database.php';
	date_default_timezone_set("Asia/Manila");
	$today_date1 = date("Y-m-d H:i:s");

	$userId = $_SESSION['user_id'];
	
	$from = mysqli_real_escape_string($link, $_POST['from']);
	$inv_date = date("Y-m-d", strtotime($from));
	$supplier = mysqli_real_escape_string($link, $_POST['supplier']);
	$brand = mysqli_real_escape_string($link, $_POST['brand']);
	$serial = mysqli_real_escape_string($link, $_POST['serial']);
	$invno = mysqli_real_escape_string($link, $_POST['invno']);	
	$price = mysqli_real_escape_string($link, $_POST['price']);	
	$tin = mysqli_real_escape_string($link, $_POST['tin']);	
	$tout = mysqli_real_escape_string($link, $_POST['tout']);
	$dout = mysqli_real_escape_string($link, $_POST['dout']);
	$out_date = date("Y-m-d", strtotime($dout));
	$wda = mysqli_real_escape_string($link, $_POST['wda']);
	$cust = mysqli_real_escape_string($link, $_POST['cust']);
	$rby = mysqli_real_escape_string($link, $_POST['rby']);
	

			/* Insert Data */
			$sql = $conn->prepare("INSERT INTO tr_inventory_dispenser (inv_date, supplier, brand, serial, inv_no, unit_price, qty_in, qty_out, date_out, wda_no, cust_id, received_by, date_added)
						VALUES ('$inv_date', '$supplier', '$brand', '$serial', '$invno', '$price', '$tin', '$tout', '$out_date', '$wda', '$cust', '$rby', '$today_date1')");
			$sql->execute();
			/* End Data */
		
		
			/* Insert Log */
			$log = $conn->prepare("INSERT INTO tr_log (action, description, category, action_by, log_action_date)
						VALUES ('Dispenser added', '$invno', 'inventory', '$userId', '$today_date1')");
			$log->execute();
			/* End Log */

		header('Location: index.php?view=add_dispenser&error=' . urlencode('Added successfully'));

}

function add_filter()
{
	include '../global-library/database.php';
	date_default_timezone_set("Asia/Manila");
	$today_date1 = date("Y-m-d H:i:s");

	$userId = $_SESSION['user_id'];
	
	$from = mysqli_real_escape_string($link, $_POST['from']);
	$inv_date = date("Y-m-d", strtotime($from));
	$supplier = mysqli_real_escape_string($link, $_POST['supplier']);
	$brand = mysqli_real_escape_string($link, $_POST['brand']);
	$ftype = mysqli_real_escape_string($link, $_POST['ftype']);
	$invno = mysqli_real_escape_string($link, $_POST['invno']);	
	$price = mysqli_real_escape_string($link, $_POST['price']);	
	$tin = mysqli_real_escape_string($link, $_POST['tin']);	
	$tout = mysqli_real_escape_string($link, $_POST['tout']);	
	$wsn = mysqli_real_escape_string($link, $_POST['wsn']);
	$purpose = mysqli_real_escape_string($link, $_POST['purpose']);
	$rby = mysqli_real_escape_string($link, $_POST['rby']);
	

			/* Insert Data */
			$sql = $conn->prepare("INSERT INTO tr_inventory_filter (inv_date, supplier, brand, filter_type, inv_no, unit_price, qty_in, qty_out, ws_no, purpose, received_by, date_added)
						VALUES ('$inv_date', '$supplier', '$brand', '$ftype', '$invno', '$price', '$tin', '$tout', '$wsn', '$purpose', '$rby', '$today_date1')");
			$sql->execute();
			/* End Data */
		
		
			/* Insert Log */
			$log = $conn->prepare("INSERT INTO tr_log (action, description, category, action_by, log_action_date)
						VALUES ('Filter added', '$invno', 'inventory', '$userId', '$today_date1')");
			$log->execute();
			/* End Log */

		header('Location: index.php?view=add_filter&error=' . urlencode('Added successfully'));

}

?>