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

    $load_id = $_POST['load_id'];
    $truckname= $_POST['truckname'];
     
    $sql = $conn->prepare("UPDATE tr_loading
               SET truckname = '$truckname', date_modified = '$today_date1'
               WHERE load_id = '$load_id'");
    $sql->execute();

header("Location: index.php?view=modify&id=$load_id&error=Modified successfully");
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
    $sql = $conn->prepare("UPDATE tr_loading SET is_deleted = '1', date_deleted = '$today_date1'
            WHERE load_id = '$id'");
    $sql->execute();
        
	header("Location: index.php?error=Deleted successfully");
}


?>