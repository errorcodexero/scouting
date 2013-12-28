<?php

set_include_path("../src/");

require_once 'lib/db.php';
require_once 'lib/team.php';
require_once 'lib/competition.php';

// Find competition with Name='Portland 2013'
// for each match
//    for all teams, add if necessary
//    create an alliance for red, blue
//    create a match

function readTeams($comp, $filename, $delimiter="\t")
{
    if (!file_exists($filename) || !is_readable($filename))
        throw new Exception("can't read " . $filename);

    $header = NULL;
    $data = array();

    if (($handle = fopen($filename, 'r')) !== FALSE) {
        while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE) {
            $team = new team();
            $team->Number = trim($row[0]);
            $team->Name = trim($row[1]);

            $loc = explode(",", $row[2]);

            $team->City = trim($loc[0]);
            $team->State  = trim($loc[1]);
            $team->Country  = trim($loc[2]);

            array_push($data, $team);
        }

        fclose($handle);
    }

    sort($data);

    return $data;
}

function reportTeams($teams)
{
    foreach ($teams as $team) {
        printf("$team->Number\t$team->Name\t$team->City, $team->State, $team->Country\n");
    }
}

// addTeams is to add all teams to the competition that haven't been added.
function addTeams($con, $comp, $teams)
{
    $current = array();
    foreach ($comp->selectTeams($con) as $team) {
        array_push($current, $team->Number);
        // printf("%s %s %s %s %s\n",
        //        $team->Number, $team->Name, $team->City, $team->State, $team->Country);
    }

    foreach ($teams as $team) {
        if (!in_array($team->Number, $current)) {
            printf("Adding %s to %s\n", $team->Number, $comp->Name);
            $st = team::selectTeam($con, $team->Number);

            if (!$st) {
                printf("New team:  $team->Number, $team->Name, $team->City, $team->State, $team->Country\n");
                team::insertTeam($con, (array) $team);
            }

            $comp->insertTeam($con, $team->Number);
        }
        else {
            printf("Team %s to already added.\n", $team->Number);
        }
    }
}

function insertMatches($con, $comp, $matches)
{
    foreach ($matches as $match) {
        $red = $match->RedAlliance;
        $blue = $match->BlueAlliance;

        $match->insert($con);

        $red->insert($con);
        $blue->insert($con);

        printf("%s - $s: %s, %s\n", $match->Number, $match->ID, $red->ID, $blue->ID);
    }
}

//---------------------------------------------------------------------------//

$compname = $argv[1];
$teampath = $argv[2];

printf("Importing teams for competition %s from %s.\n", $compname, $teampath);

$con = DB::connect();
$comp = competition::selectByName($con, $compname);

if (!$comp)
    die("Competition \"$name\" not found.");

printf("Competition $name ID=%s\n", $comp->ID);

$teams = readTeams($comp, $teampath);
// reportTeams($teams);

addTeams($con, $comp, $teams);

?>