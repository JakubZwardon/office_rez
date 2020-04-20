<?php

include("../../config/config.php");
include("../classes/equipment.php");

    $type = strip_tags($_POST['add_equip_type']);
    $model = strip_tags($_POST['add_equip_model']);
    $name = strip_tags($_POST['add_equip_name']);
    $year = $_POST['add_equip_date'];
    $value = $_POST['add_equip_value'];
    $description = strip_tags($_POST['add_equip_description']);
    $wsName = strip_tags($_POST['add_equip_ws_name']);

    $query = mysqli_query($con, "SELECT id FROM workspaces WHERE name='$wsName'");

    if($row = mysqli_fetch_array($query)){
        $wsId = $row['id'];
        $equipment = new Equipment($con, $type, $model, $name, $year, $value, $description, $wsId);
        $equipment->saveEquipment();
    } else {
        echo "BadWsName";
    }
?>