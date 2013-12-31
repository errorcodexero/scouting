<?php

require_once "db.php";
require_once "base.php";

class robot extends base
{
    public $TeamNumber;
    public $Role = 'offensive';
    public $ShootingLocation = 'pyramid';
    public $MaxAutonomous = 0;
    public $MaxClimb = 0;
    public $Lifter = false;
    public $MaxDefensiveHeight = 0;
    public $Comment = "";
    public $StrategyPartner = "";
    public $StrategyOpposition = "";
    
    public function __construct($object) {
        foreach($object as $property => $value) {
            $this->$property = $value;
        }
    }

// a bunch of functions for manipulating robots

    public function insert(DB $con, $vals) {
        base::checkcon($con, __FUNCTION__);

        $sql=sprintf("INSERT INTO robots (TeamNumber, Role, ShootingLocation, MaxAutonomous, " .
                     "MaxClimb, Lifter, MaxDefensiveHeight, `Comment`, StrategyPartner, StrategyOpposition) " .
                     "VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
                     $this->TeamNumber,
                     $this->Role,
                     $this->ShootingLocation,
                     $this->MaxAutonomous,
                     $this->MaxClimb,
                     $this->Lifter,
                     $this->MaxDefensiveHeight,
                     mysqli_real_escape_string($con, $this->Comment),
                     mysqli_real_escape_string($con, $this->StrategyPartner),
                     mysqli_real_escape_string($con, $this->StrategyOpposition));

        // echo $sql . "\n";

        if (!mysqli_query($con,$sql)) {
            die('Error: ' . mysqli_error($con));
        }
    }

    public static function select($con, $number)
    {
        base::checkcon($con, __FUNCTION__);

        if (!$con)
            die('selectTeam error:  no connection.');

        $query = "SELECT * FROM robots where TeamNumber = " . $number;

        // print "$query\n";

        $result = mysqli_query($con, $query);
        $row = mysqli_fetch_assoc($result);

        if (!$row)
            return null;
        else
            return new robot($row);
    }
}

?>