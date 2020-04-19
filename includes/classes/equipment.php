<?php

class Equipment {
    private $con;
    private $type;
    private $model;
    private $name;
    private $yearOfPurchase;
    private $value;
    private $description;
    private $workstationId;

    public function __construct($con, $type="", $model="", $name="", $year="", $value="0", $description="", $wsId="") {
        $this->con = $con;
        $this->type = $type;
        $this->model = $model;
        $this->name = $name;
        if($year == "") {
            $this->yearOfPurchase = date("Y-m-d");
        } else {
            $this->yearOfPurchase = $year;
        }
        $this->value = $value;
        $this->description = $description;
        $this->workstationId = $wsId;
    }

    public function saveEquipment() {
        $query = mysqli_query($this->con, "INSERT INTO equipments VALUES (NULL, '$this->type', '$this->model', '$this->name', '$this->yearOfPurchase', '$this->value', '$this->description', '$this->workstationId')");
    }
}


?>