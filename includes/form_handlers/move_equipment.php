<?php
require '../../config/config.php';

//get id of equip
if(isset($_GET['equipment_id'])) {
    $equipmentId = $_GET['equipment_id'];
}

//if result is set on true delete equip
if(isset($_POST['result'])) {

    $wsName = $_POST['result'];

    $query = mysqli_query($con, "SELECT id FROM workspaces WHERE name='$wsName'");

    if($row = mysqli_fetch_array($query)){
        $wsId = $row['id'];
        $query = mysqli_query($con, "UPDATE equipments SET workstation_id='$wsId' WHERE id='$equipmentId'");
    } else {
        echo "BadWsName";
    }
}


?>