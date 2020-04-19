<?php
require '../../config/config.php';

//get id of equip
if(isset($_GET['equipment_id'])) {
    $equipmentId = $_GET['equipment_id'];
}

//if result is set on true delete equip
if(isset($_POST['result'])) {
    if($_POST['result'] == 'true') {
        $query = mysqli_query($con, "DELETE FROM equipments WHERE id='$equipmentId'");
    }
}

?>