<?php

include("../../config/config.php");
include("../classes/workspace.php");

    $name = $_POST['add_ws_name'];
    $description = $_POST['add_ws_description'];

    $workspace = new Workspace($con, $name, $description);
    $workspace->saveWorkspace();
?>