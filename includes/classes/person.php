<?php
class Person {
    private $con;
    private $fName;
    private $lName;
    private $phone;
    private $mail;
    private $description;

    public function __construct($con, $fName, $lName, $phone, $mail, $description)
    {
        $this->con = $con;
        $this->fName = $fName;
        $this->lName = $lName;
        $this->phone = $phone;
        $this->mail = $mail;
        $this->description = $description;
    }

    public function savePerson() {
        $query = mysqli_query($this->con, "INSERT INTO persons VALUES (NULL, '$this->fName', '$this->lName', '$this->phone', '$this->mail', '$this->description')");
    }
}

?>