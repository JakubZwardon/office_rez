<?php
class Reservation {
    private $con;
    private $dateFrom;
    private $dateTo;
    private $workspaceId;
    private $personId;

    public function __construct($con, $dateFrom="", $dateTo="", $workspaceId="", $personId="")
    {
        $this->con = $con;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
        $this->workspaceId = $workspaceId;
        $this->personId = $personId;
    }

    public function saveReservation() {
        $query = mysqli_query($this->con, "INSERT INTO reservations VALUES (NULL, '$this->dateFrom', '$this->dateTo', '$this->workspaceId', '$this->personId')");
    }

    public function loadReservations($data, $limit) {

        $page = $data['page'];  //get current page
        $str = "";      //prepare outupt string

        //set starting position
        if($page == 1) {
            $start = 0;
        } else {
            $start = ($page - 1) * $limit;
        }

        $reservation_query = mysqli_query($this->con, "SELECT * FROM reservations ORDER BY id ASC");

        if(mysqli_num_rows($reservation_query) > 0) {

            $numIterations = 0;
            $count = 1;

            while($row = mysqli_fetch_array($reservation_query)) {
                //get reservation dates
                $reservationId = $row['id'];
                $resDateFrom = $row['date_from'];
                $resDateTo = $row['date_to'];
                $resWsId = $row['workspace_id'];
                $resPersonId = $row['person_id'];
                
                //prepare person dates to put in output string                
                $person_query = mysqli_query($this->con, "SELECT * FROM persons WHERE id='$resPersonId'");
                if($person_row = mysqli_fetch_array($person_query)) {                              
                    $personFName = $person_row['first_name'];
                    $personLName = $person_row['last_name'];
                    $personMail = $person_row['mail'];        
                    $personPhoneNum = $person_row['phone_number'];
                    $personDescription = $person_row['description'];
                }

                //prepere workspace date to put in output string
                $workspace_query = mysqli_query($this->con, "SELECT * FROM workspaces WHERE id='$resWsId'");
                if($workspace_row = mysqli_fetch_array($workspace_query)) {
                    $workspaceName = $workspace_row['name'];
                }

                //Search place to start load
                if($numIterations++ < $start) {
                    continue;
                }

                //once 10 have been loaded, break
                if($count > $limit) {
                    break;
                } else {
                    $count++;
                }

                $str .= "<div class='reservation'>
                            <div class='person_info'>
                                <p><span>$personFName $personLName </span><span>$personMail </span><span>$personPhoneNum</span></p>
                                <p><span>$personDescription</span></p>
                            </div>
                            <div class='date_info'>
                                <p>Rezerwacja <span>Od: </span>$resDateFrom<span> Do: </span>$resDateTo</p>                                
                            </div>
                            <div class='workspace_info'>
                                <p><span>Nazwa Stanowiska </span>$workspaceName</p>                                
                            </div>
                        </div>
                        <hr />";
            }            

            if($count > $limit) {
                $str .= "<input type='hidden' class='next_page' value='" . ($page + 1) . "'>
                            <input type='hidden' class='no_more_reservations' value='false'>";
            } else {
                $str .= "<input type='hidden' class='no_more_reservations' value='true'>
                            <p style='text-align: center;'> No more reservations to show!</p>";
            }

        }

        echo $str;
    }
}

?>