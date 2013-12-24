<?php

require_once "db.php";
require_once "base.php";

class match extends base
{
    public static $roundtype =  array('qualification', 'quarters', 'semis', 'finals');

    public $ID;
    public $Competition;
    public $Time;
    public $Number;
    public $RedAlliance;
    public $BlueAlliance;
    public $Round;

    // inserts "this" alliance
    public function insert(DB $con) {
        $this->checkcon($con, __FUNCTION__);
        $sql=sprintf("INSERT INTO matches (CompetitionID, Time, Number, Round) VALUES " .
                     "('%s', '%s', '%s', '%s')",
                     $this->Competition->ID,
                     $this->Time,
                     $this->Number,
                     $this->Round);

        printf("$sql\n");

        if (!mysqli_query($con,$sql)) {
            die('Error: ' . mysqli_error($con));
        }

        $this->ID = mysqli_insert_id($con);
    }

    public static function select($con, $id)
    {
        $this->checkcon($con, __FUNCTION__);
        $query = "SELECT * FROM matches where ID = " . $id;
        $result = mysqli_query($con, $query);
        $row = mysqli_fetch_assoc($result);

        if (!$row)
            return null;
        else {
            $a = new match();
            $a->set($alliance);

            return $a;
        }
    }
}
?>


