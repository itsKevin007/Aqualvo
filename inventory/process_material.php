<<?php
require_once '../global-library/config.php';
require_once '../global-library/functions.php';

checkUser();

$action = isset($_GET['action']) ? $_GET['action'] : '';
switch ($action) {
	/*
    case 'add' :
        add();
        break;
    */
    case 'modify' :
        modify();
        break;
        
    case 'delete' :
        delete();
        break;       
	   
    default :
        // if action is not defined or unknown
        // move to main  page
        header('Location: index.php');
}


/*
    Add

function add()
{
    include '../global-library/database.php';

    $source = $_POST['source'];
    
    $sql = $conn->prepare("INSERT INTO bs_source (source, date_added) 
              VALUES ('$source', '$today_date1')");
    $sql->execute();
    
    header('Location: index.php?view=add&error=Added successfully');              
}
*/

/*
    Modify
*/
function modify()
{
    include '../global-library/database.php';

    $inv_id = $_POST['inv_id'];
    $inv_date= $_POST['inv_date'];
    $supplier= $_POST['supplier'];
    $inv_no= $_POST['inv_no'];
    $unit_price= $_POST['unit_price'];
    $qty_in= $_POST['qty_in'];
    $qty_out= $_POST['qty_out'];
    $received_by= $_POST['received_by'];
     
    $sql = $conn->prepare("UPDATE tr_inventory_material
               SET inv_date = '$inv_date',  supplier = '$supplier',  inv_no = '$inv_no',  unit_price = '$unit_price',  qty_in = '$qty_in',  qty_out = '$qty_out',  received_by = '$received_by', date_modified = '$today_date1'
               WHERE inv_id = '$inv_id'");
    $sql->execute();

header("Location: index.php?view=modify_material&id=$inv_id&error=Modified successfully");
}

/*
    Remove
*/
function delete()
{
    include '../global-library/database.php';

    if (isset($_GET['id']) && (int)$_GET['id'] > 0) {
        $id = (int)$_GET['id'];
    } else {
        header('Location: list.php');
    }
    
    // delete the . set is_deleted to 1 as deleted;
    $sql = $conn->prepare("UPDATE tr_inventory_material SET is_deleted = '1', date_deleted = '$today_date1'
            WHERE inv_id = '$id'");
    $sql->execute();
        
	header("Location: index.php");
}


?>