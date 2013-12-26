<?php

require_once "db.php";

class alliance
{
    public $ID;
    public $Match;
    public $Color;
    public $TeamOne;
    public $TeamTwo;
    public $TeamThree;
    public $Points;
    public $Won;

    public function set($object) {
        foreach($object as $property => $value) {
            $this->$property = $value;
        }
    }

    public function __construct($red = false) {
        $this->Color = ($red) ? 'red' : 'blue';
    }

    // inserts "this" alliance
    public function insert(DB $con) {
        $sql=sprintf("INSERT INTO alliances (MatchID, Color, TeamOne, TeamTwo, TeamThree, Points) VALUES " .
                     "('%s', '%s', '%s', '%s', '%s', '%s')",
                     $this->Match->ID,
                     $this->Color,
                     $this->TeamOne, 
                     $this->TeamTwo, 
                     $this->TeamThree, 
                     $this->Points);

        printf("$sql\n");

        if (!mysqli_query($con,$sql)) {
            die('Error: ' . mysqli_error($con));
        }

        $this->ID = mysqli_insert_id($con);

        // $alliance = selectAlliance($con, $id);
    }

    public static function selectAlliance($con, $id)
    {
        if (!$con)
            die('selectTeam error:  no connection.');

        $query = "SELECT * FROM alliances where ID = " . $id;
        $result = mysqli_query($con, $query);
        $row = mysqli_fetch_assoc($result);

        if (!$row)
            return null;
        else {
            $a = new alliance();
            $a->set($alliance);

            return $a;
        }
    }
}
?>