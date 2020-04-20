<?php

include("../../config/config.php");
include("../classes/workspace.php");

    $name = strip_tags($_POST['add_ws_name']);
    $description = strip_tags($_POST['add_ws_description']);

    $workspace = new Workspace($con, $name, $description);
    $workspace->saveWorkspace();
?>