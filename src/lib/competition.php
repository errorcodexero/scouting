<?php

require_once "base.php";

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

    public function addTeam($con, $team)
    {
        base::checkcon($con, __FUNCTION__);

        $sql = sprintf("INSERT INTO competitionteams (CompetitionID, TeamNumber) VALUES (%s, %s)", $this->ID, $team);

        // printf("$sql\n");

        if (!mysqli_query($con, $sql)) {
            die('Error: ' . mysqli_error($con));
        }

        return $result;
    }

    public function getTeams($con)
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
}

?>