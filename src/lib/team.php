<?php

require_once "db.php";

class team
{
    public $Number;
    public $Name;
    public $City;
    public $State;
    public $Country;

    public function __construct($object) {
        foreach($object as $property => $value) {
            $this->$property = $value;
        }
    }

// a bunch of functions for manipulating teams

    public static function insertTeam(DB $con, $vals) {
        $sql=sprintf("INSERT INTO teams (Number, Name, City, State, Country) VALUES ('%s', '%s', '%s', '%s', '%s')",
                     mysqli_real_escape_string($con, $vals['Number']), 
                     mysqli_real_escape_string($con, $vals['Name']), 
                     mysqli_real_escape_string($con, $vals['City']), 
                     mysqli_real_escape_string($con, $vals['State']), 
                     mysqli_real_escape_string($con, $vals['Country']));

        // echo $sql . "\n";

        if (!mysqli_query($con,$sql)) {
            die('Error: ' . mysqli_error($con));
        }
    }

    public static function selectTeams($con)
    {
        if (!$con)
            die('selectTeams error:  no connection.');

        $result = mysqli_query($con,"SELECT * FROM teams order by number");

        return $result;
    }

    public static function selectTeam($con, $number)
    {
        if (!$con)
            die('selectTeam error:  no connection.');

        $query = "SELECT * FROM teams where Number = " . $number;
        $result = mysqli_query($con, $query);
        $team = mysqli_fetch_assoc($result);

        if (!$team)
            return null;
        else
            return new team($team);
    }
}
?>


