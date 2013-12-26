<?php

set_include_path("../src/");

require_once 'lib/db.php';
require_once 'lib/team.php';
require_once 'lib/match.php';
require_once 'lib/alliance.php';
require_once 'lib/competition.php';

function reportMatches($matches)
{
    foreach ($matches as $match) {
        $red = $match->RedAlliance;
        $blue = $match->BlueAlliance;

        printf("$match->Time, $match->Number, $red->TeamOne, $red->TeamTwo, $red->TeamThree, ".
               "$blue->TeamOne, $blue->TeamTwo, $blue->TeamThree, $red->Points, $blue->Points\n");
    }
}

function reportTeams($teams) {
    foreach ($teams as $team) {
        printf("%s, %s\n", $team->Number, $team->Name);
    }
}

//---------------------------------------------------------------------------//

$name = "Oregon City District";
$con = DB::connect();
$comp = competition::selectCompetitionByName($con, $name);

if (!$comp)
    die("Competition \"$name\" not found.");

printf("Competition $name ID=%s\n", $comp->ID);

// $teams = $comp->selectTeams($con);
// reportTeams($teams);

$matches = $comp->selectMatches($con);

foreach ($matches as $match) {
    $red = $match->RedAlliance;
    $blue = $match->BlueAlliance;

    printf("
            <tr> 
              <td>%s</td>
              <td>%s</td>
              <td>%s</td>
              <td>%s</td>
              <td>%s</td>
              <td>%s</td>
              <td>%s</td>
              <td>%s</td>
            </tr>\n", 
           $match->Time, $match->Number, 
           $red->TeamOne, $red->TeamTwo, $red->TeamThree, 
           $blue->TeamOne, $blue->TeamTwo, $blue->TeamThree);
}

// reportMatches($matches);

?>