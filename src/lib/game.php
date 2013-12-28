<?php

require_once "db.php";
require_once "base.php";

// A game is a single robot in a single match.
class game extends base
{
    public $MatchID;
    public $MatchNumber;
    public $TeamNumber;
    public $Autonomous = 0;
    public $Teleop = 0;
    public $Climbing = 0;
    public $ColoredFrisbees = 0;
    public $Offensive;
    public $Disqualified;
    public $TippedOver;
    public $MechanicalFailure;
    public $LostCommunication;
    public $DidNotMove;
    public $Comment;

    // __construct a game out of $object, fill in the props above using php magic.
    public function __construct($object) {
        if ($object != null) {
            foreach($object as $property => $value) {
                $this->$property = $value;
            }

            $props = json_decode($object['Properties']);
            foreach($props as $property => $value) {
                $this->$property = $value;
            }

            $this->Properties = null;
        }
    }

    // inserts *or* updates "this" game
    public function insert(DB $con) {
        base::checkcon($con, __FUNCTION__);

        // save properties as a json string
        $copy = clone $this;
        unset($copy->MatchID);
        unset($copy->TeamNumber);
        unset($copy->MatchNumber);
        unset($copy->Comment);
        $props = json_encode($copy);
        $comment = mysqli_real_escape_string($con, $this->Comment);

        // note odd "update" syntax.
        $sql=sprintf("INSERT INTO games (MatchID, TeamNumber, Properties, Comment) VALUES " .
                     "('%s', '%s', '%s', '%s')\n" .
                     "ON DUPLICATE KEY UPDATE Properties = '%s', Comment = '%s'",
                     $this->MatchID,
                     $this->TeamNumber,
                     $props,
                     $comment,
                     $props,
                     $comment);

        // printf("$sql\n");

        if (!mysqli_query($con,$sql)) {
            die('Error: ' . mysqli_error($con));
        }
    }

    // select *the* game with $matchid, $teamnumber
    public function select($con, $matchid, $teamnumber)
    {
        base::checkcon($con, __FUNCTION__);

        $sql = sprintf("select * from games where MatchID = %s and TeamNumber = %s", $matchid, $teamnumber);
        $result = mysqli_query($con,$sql);

        if (!$result) {
            die('Error: ' . mysqli_error($con));
        }

        $row = mysqli_fetch_assoc($result);
        mysqli_free_result($result);

        if (!$row)
            return null;
        else {
            $game = new game($row);

            return $game;
        }
    }
}
?>