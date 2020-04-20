<?php

include("../../config/config.php");
include("../classes/reservation.php");
include("../classes/person.php");


    $presonFirstName = strip_tags($_POST['add_res_fname']);
    $presonLatsName = strip_tags($_POST['add_res_lname']);
    $personMail = strip_tags($_POST['add_res_mail']);
    $personPhone = strip_tags($_POST['add_res_phone']);
    $personDescription = strip_tags($_POST['add_res_description']);
    $workspaceName = strip_tags($_POST['add_res_workspace']);
    $fromDate = $_POST['add_res_from_date'];
    $toDate = $_POST['add_res_to_date'];
    $fromTime = $_POST['add_res_from_time'];
    $toTime = $_POST['add_res_to_time'];

    $timeFrom = new DateTime($fromDate . " " . $fromTime);
    $timeTo = new DateTime($toDate . " " . $toTime);

    $query = mysqli_query($con, "SELECT id FROM workspaces WHERE name='$workspaceName'");

    if($row = mysqli_fetch_array($query)){
        $workspaceId = $row['id'];
        $isFreeDate = true;  //mark date as free to take
        //get the dates of reservations
        $date_check_query = mysqli_query($con, "SELECT date_from, date_to FROM reservations WHERE workspace_id='$workspaceId'");
        while($date_check_row = mysqli_fetch_array($date_check_query)) {
            
            $takenFromDate = $date_check_row['date_from'];
            $takenToDate = $date_check_row['date_to'];

            //convert to DateTime
            $timeTakenFrom = new DateTime($takenFromDate);
            $timeTakenTo = new DateTime($takenToDate);

            //check if the given date is taken
            if(($timeFrom >= $timeTakenFrom) && ($timeFrom <= $timeTakenTo)) {
                $isFreeDate = false;
                echo "DateTaken";
                return;
            }
            if(($timeTo >= $timeTakenFrom) && ($timeTo <= $timeTakenTo)) {
                $isFreeDate = false;
                echo "DateTaken";
                return;
            }
            if(($timeTakenFrom >= $timeFrom) && ($timeTakenFrom <= $timeTo)) {
                $isFreeDate = false;
                echo "DateTaken";
                return;
            }
            if(($timeTakenTo >= $timeFrom) && ($timeTakenTo <= $timeTo)) {
                $isFreeDate = false;
                echo "DateTaken";
                return;
            }
            if($timeTo <= $timeFrom) {
                echo "DateInvalid"; //end date cannot be less than start date
                return;
            }
            if($timeFrom < new DateTime(date("Y-m-d H:i:s"))) {
                echo "DateLess"; //connot be less then current
                return;
            }
        }
        //if date is free to take, do reservation
        if($isFreeDate) {        
            $person = new Person($con, $presonFirstName, $presonLatsName, $personPhone, $personMail, $personDescription);
            $person->savePerson();
            $personId = mysqli_insert_id($con);
    
            
            $reservation = new Reservation($con, $timeFrom->format('Y-m-d H:i:s'), $timeTo->format('Y-m-d H:i:s'), $workspaceId, $personId);
            $reservation->saveReservation();
            
        }
    } else {
        echo "BadWsName";
    }
?>