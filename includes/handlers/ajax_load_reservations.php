<?php

include("../../config/config.php");
include("../classes/reservation.php");

$limit = 10;    //num of reservations to be loaded per call

$reservation = new Reservation($con);
$reservation->loadReservations($_REQUEST, $limit);

?>