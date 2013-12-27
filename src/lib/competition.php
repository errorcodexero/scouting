<?php

require_once "base.php";
require_once "match.php";
require_once "alliance.php";

class competition extends base
{
    public $ID;
    public $Name;
    public $City;
    public $State;
    public $Start;
    public $End;
    public $Type;

    public function __construct($object) {
        foreach($object as $property => $value) {
            $this->$property = $value;
        }
    }

    public static function selectCompetitions($con)
    {
        base::checkcon($con, __FUNCTION__);

        $result = mysqli_query($con, "SELECT * FROM competitions order by Start");

        return $result;
    }

    public static function selectCompetitionByName($con, $name)
    {
        base::checkcon($con, __FUNCTION__);

        $name = mysqli_real_escape_string($con, $name);

        // printf("name = $name\n");

        $query = "SELECT * FROM competitions where Name = \"$name\"";
        $result = mysqli_query($con, $query);
        $comp = mysqli_fetch_assoc($result);

        mysqli_free_result($result);

        if (!$comp)
            return null;
        else
            return new competition ($comp);
    }

    public static function selectCompetitionByID($con, $id)
    {
        base::checkcon($con, __FUNCTION__);

        $query = "SELECT * FROM competitions where ID = '$id'";
        $result = mysqli_query($con, $query);
        $comp = mysqli_fetch_assoc($result);

        mysqli_free_result($result);

        if (!$comp)
            return null;
        else
            return new competition($comp);
    }

    public function insertTeam($con, $team)
    {
        base::checkcon($con, __FUNCTION__);

        $sql = sprintf("INSERT INTO competitionteams (CompetitionID, TeamNumber) VALUES (%s, %s)", $this->ID, $team);

        // printf("$sql\n");

        if (!mysqli_query($con, $sql)) {
            die('Error: ' . mysqli_error($con));
        }

        return $result;
    }

    public function selectTeams($con)
    {
        base::checkcon($con, __FUNCTION__);

        $sql = "select * from teams " .
               "INNER JOIN competitionteams " .
               "ON (competitionteams.CompetitionID = " . $this->ID . " and " .
               "competitionteams.TeamNumber = teams.Number)";

        $result = mysqli_query($con, $sql);
        $teams = array();

        while ($row = mysqli_fetch_array($result)) {
            $team = new team($row);

            array_push($teams, $team);
        }

        mysqli_free_result($result);

        return $teams;
    }

    public function selectMatches($con)
    {
        base::checkcon($con, __FUNCTION__);

        $sql = "select matches.*, alliances.* from alliances
                INNER JOIN matches
                ON (matches.CompetitionID = " . $this->ID . " and 
                alliances.MatchID = matches.ID)
                order by matches.Number, alliances.Color";

        $result = mysqli_query($con,$sql);

        if (!$result) {
            die('Error: ' . mysqli_error($con));
        }

        $matches = array();

        while ($row = mysqli_fetch_array($result)) {
            $match = new match();
            $match->Competition = this;
            $match->Time = $row['Time'];
            $match->Number = $row['Number'];
            $match->Round = $row['Round'];
            $match->ID = $row['MatchID'];

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

            array_push($matches, $match);
        }

        mysqli_free_result($result);

        return $matches;
    }
}

?>