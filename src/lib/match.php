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
        base::checkcon($con, __FUNCTION__);

        $sql = "select matches.*, alliances.* from alliances
                INNER JOIN matches
                ON (matches.ID = " . $id . " and 
                alliances.MatchID = " . $id . ")
                order by alliances.Color";

        // print "$sql\n";

        $result = mysqli_query($con,$sql);

        if (!$result) {
            die('Error: ' . mysqli_error($con));
        }

        $row = mysqli_fetch_array($result);

        if (!$row) 
            return null;
        else {
            $match = new match();
            $match->Competition = this;
            $match->Time = $row['Time'];
            $match->Number = $row['Number'];
            $match->Round = $row['Round'];

            $a1 = new alliance($row->Color == 'red');
            $a1->set($row);
            
            $row = mysqli_fetch_array($result);
            $a2 = new alliance($row->Color == 'red');
            $a2->set($row);

            if ($a1->Color == 'red') {
                $match->RedAlliance = $a1;
                $match->BlueAlliance = $a2;
            }
            else {
                $match->RedAlliance = $a2;
                $match->BlueAlliance = $a1;
            }

            mysqli_free_result($result);

            return $match;
        }
    }
}
?>