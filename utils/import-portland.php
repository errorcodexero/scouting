<?php

set_include_path("../src/");

require_once 'obj/db.php';
require_once 'obj/team.php';
require_once 'obj/match.php';
require_once 'obj/alliance.php';
require_once 'obj/competition.php';

// Find competition with Name='Portland 2013'
// for each match
//    for all teams, add if necessary
//    create an alliance for red, blue
//    create a match

function readMatches($comp, $filename, $delimiter="\t")
{
    if (!file_exists($filename) || !is_readable($filename))
        throw new Exception("can't read " . $filename);

    $header = NULL;
    $data = array();
    if (($handle = fopen($filename, 'r')) !== FALSE)
    {
        while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
        {
            $match = new match();
            $match->Competition = $comp;
            $match->Time = trim($row[0]);
            $match->Number = trim($row[1]);
            $match->Round = 'qualification';

            $red = new alliance(true);
            $red->Match = $match;
            $red->TeamOne = trim($row[2]);
            $red->TeamTwo = trim($row[3]);
            $red->TeamThree = trim($row[4]);
            $red->Points = trim($row[8]);

            $blue = new alliance(false);
            $blue->Match = $match;
            $blue->TeamOne = trim($row[5]);
            $blue->TeamTwo = trim($row[6]);
            $blue->TeamThree = trim($row[7]);
            $blue->Points = trim($row[9]);

            $match->RedAlliance = $red;
            $match->BlueAlliance = $blue;

            array_push($data, $match);
        }

        fclose($handle);
    }

    return $data;
}

function reportMatches()
{
    foreach ($matches as $match) {
        $red = $match->RedAlliance;
        $blue = $match->BlueAlliance;

        printf("$match->Time, $match->Number, $red->TeamOne, $red->TeamTwo, $red->TeamThree, ".
               "$blue->TeamOne, $blue->TeamTwo, $blue->TeamThree, $red->Points, $blue->Points\n");
    }
}

// addTeams is to add all teams to the competition that haven't yet been added.
function addTeams($con, $comp, $matches)
{
    $current = array();
    foreach ($comp->getTeams($con) as $team) {
        array_push($current, $team->Number);
        // printf("%s %s %s %s %s\n",
        //        $team->Number, $team->Name, $team->City, $team->State, $team->Country);
    }

    $allteams = array();

    // get all the $teams
    foreach ($matches as $match) {
        $red = $match->RedAlliance;
        $blue = $match->BlueAlliance;

        array_push($allteams, $red->TeamOne);
        array_push($allteams, $red->TeamOne);
        array_push($allteams, $red->TeamTwo);
        array_push($allteams, $red->TeamThree);
        array_push($allteams, $blue->TeamOne);
        array_push($allteams, $blue->TeamTwo);
        array_push($allteams, $blue->TeamThree);
    }

    // pitch duplicates
    $allteams = array_unique($allteams);
    sort($teams);

    foreach ($allteams as $team) {
        if (!in_array($team, $current)) {
            printf("missing %s\n", $team);
            $comp->addTeam($con, $team);
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

$name = "Autodesk Portland Regional 2013";
$con = DB::connect();
$comp = competition::selectCompetitionByName($con, $name);

if (!$comp)
    die("Competition \"$name\" not found.");

printf("Competition $name ID=%s\n", $comp->ID);

$matches = readMatches($comp, "portland-2013.tsv");

// reportMatches();

addTeams($con, $comp, $matches);
insertMatches($con, $comp, $matches);

?>