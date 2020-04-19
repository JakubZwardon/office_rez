<?php

class Workspace {
    private $con;
    private $name;
    private $description;

    public function __construct($con, $name = "", $description = "") {
        $this->con = $con;
        $this->name = $name;
        $this->description = $description;
    }

    public function loadWorkspaces($data, $limit) {

        $page = $data['page'];  //get current page
        $str = "";      //prepare outupt string

        //set starting position
        if($page == 1) {
            $start = 0;
        } else {
            $start = ($page - 1) * $limit;
        }

        $workplace_query = mysqli_query($this->con, "SELECT * FROM workspaces ORDER BY id ASC");

        if(mysqli_num_rows($workplace_query) > 0) {

            $numIterations = 0;
            $count = 1;

            while($row = mysqli_fetch_array($workplace_query)) {
                //get workplace dates
                $workspaceId = $row['id'];
                $wsName = $row['name'];
                $wsDescription = $row['description'];
                
                //prepare equipment dates to put in output string
                $equipString = "";
                $equip_query = mysqli_query($this->con, "SELECT * FROM equipments WHERE workstation_id='$workspaceId'");
                if(mysqli_num_rows($equip_query) > 0) {
                    while($equip_row = mysqli_fetch_array($equip_query)) {    
                        $equipId = $equip_row['id']                ;
                        $equipType = $equip_row['type'];
                        $equipModel = $equip_row['model'];
                        $equipName = $equip_row['name'];
                        $equipYear = $equip_row['year_of_purchase'];
                        $equipValue = $equip_row['value'];
                        $equipDescription = $equip_row['description'];
                        
                        $deleteEquipButton = "<button class='delete_button btn-danger' id='deleteEquip$equipId' title='usuń'>X</button>";
                        $moveEquipButton = "<button class='move_button btn-warning' id='moveEquip$equipId' title='przydziel do innego stanowiska'>-></button>";

                        $equipString .= "<div class='equipment'>
                                            <span>Nazwa: </span> $equipName <span>Typ: </span> $equipType <span>Model: </span>$equipModel <span>Rok produkcji: </span> $equipYear <span>Koszt: </span> $equipValue pln. $deleteEquipButton $moveEquipButton
                                            <br><span>Opis: </span> $equipDescription
                                        </div>";

                        ?>

                        <script>
                        //delete equipment button
                        $(document).ready(function() {
                            $('#deleteEquip<?php echo $equipId; ?>').click(function() {                                                    
                                bootbox.confirm("Potwierdź proszę?", function(result) {                                                                                                                                  
                                    $.post("includes/form_handlers/delete_equipment.php?equipment_id= <?php echo $equipId; ?>", {result:result}, function() {if(result) location.reload();});                                
                                });
                            });
                        });

                        //move equipment button
                        $(document).ready(function() {
                            $('#moveEquip<?php echo $equipId; ?>').click(function() {                                                                                 
                                bootbox.prompt("Wprowadź nazwę stanowiska do jakiego ma zostać przydzielony sprzęt", function(result) {                                                   
                                    if(result) {                                                                                                                                               
                                        $.post("includes/form_handlers/move_equipment.php?equipment_id= <?php echo $equipId; ?>", {result:result}, function(data) {                                        
                                            if(data != "BadWsName")
                                                location.reload();
                                            else
                                                bootbox.alert("Niepoprawna nazwa stanowiska!");                                            
                                        });         
                                    }                                                                                          
                                });
                            });
                        });
                        </script>
                        <?php
                    }
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

                $str .= "<div class='workplace'>
                            <h4>$wsName</h4>
                            <p>$wsDescription</p>
                            $equipString
                        </div>
                        <hr />";
            }            

            if($count > $limit) {
                $str .= "<input type='hidden' class='next_page' value='" . ($page + 1) . "'>
                            <input type='hidden' class='no_more_workplaces' value='false'>";
            } else {
                $str .= "<input type='hidden' class='no_more_workplaces' value='true'>
                            <p style='text-align: center;'> No more workplaces to show!</p>";
            }

        }

        echo $str;
    }

    public function saveWorkspace() {
        $query = mysqli_query($this->con, "INSERT INTO workspaces VALUES (NULL, '$this->name', '$this->description')");
    }
}

?>