<?php

require_once "db.php";
require_once "base.php";

class game extends base
{
    public $MatchID;
    public $MatchNumber;
    public $TeamNumber;
    public $Autonomous;
    public $Teleop;
    public $Climbing;
    public $ColoredFrisbees;
    public $Offensive;
    public $Disqualified;
    public $Tippedover;
    public $MechanicalFailure;
    public $LostCommunication;
    public $DidNotMove;
    public $Comment;

    public function __construct($object) {
        foreach($object as $property => $value) {
            $this->$property = $value;
        }
    }
}
?>