<?php

include("../../config/config.php");
include("../classes/workspace.php");

$limit = 10;    //num of worspaces to be loaded per call

$workplace = new Workspace($con);
$workplace->loadWorkspaces($_REQUEST, $limit);

?>