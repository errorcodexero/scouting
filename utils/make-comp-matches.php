<?php

set_include_path("../src/");

require_once 'lib/db.php';
require_once 'lib/team.php';
require_once 'lib/match.php';
require_once 'lib/alliance.php';
require_once 'lib/competition.php';

// http://www.thebluealliance.com/event/2013miket
// 39 teams, 78 qualification matches, each team played 12 matches
// (num_teams * num_rounds) / 6 :  39 * 12 / 6 == 78
//
// Each team has the same number of matches.
// Matches per team are at least 4 matches apart.
// A team can be in an alliance with another team at most twice.
//
function makeMatches($comp, $teams, $numrounds)
{
    $minutespermatch = 7;
    $matches = array();

    // get all team numbers
    $numbers = array();  
    foreach ($teams as $team) {
        array_push($numbers, $team->Number);
    }

    $copynumbers = $numbers;  // to fill in subsequent rounds
    $numteams = count($numbers);
    shuffle($numbers);

    print "makeMatches $numteams teams\n";

    $roundnum = 0;
    $matchnum = 1;
    $matchtime = date_create($comp->Start);
    $matchtime->setTime(12, 0, 0);  // First day starts at noon.

    // Figure out how many matches are on each of the two days
    $nummatches = ($numteams * $numrounds) / 6;
    $hoursday2 = 3;
    $day2 = (int) round($hoursday2 * 60 / $minutespermatch);
    $day1 = $nummatches - $day2;
    // printf("day1 $day1 day2 $day2 nummatches $nummatches\n");

    while ($matchnum <= $nummatches) {
        $count = count($numbers);

        if ($count < 6) {
            // we need to find more teams to fill out the current round
            $need = 6 - $count;
            $last = $numbers;   // these need to be added to next round
            $pickfrom = array_diff($copynumbers, $last);  // pick from these
            shuffle($pickfrom);

            while ($need > 0) {
                $next = array_pop($pickfrom);
                array_push($numbers, $next);                
                $need--;
            }
            
            // $numbers now how 6 teams
            $red1 = array_pop($numbers);
            $red2 = array_pop($numbers);
            $red3 = array_pop($numbers);
            $blue1 =array_pop($numbers);
            $blue2 = array_pop($numbers);
            $blue3 = array_pop($numbers);
            
            // next round picks from these...
            $numbers = array_merge($last, $pickfrom);
            shuffle($numbers);

            $roundnum++;
        }
        else {
            $red1 = array_pop($numbers);
            $red2 = array_pop($numbers);
            $red3 = array_pop($numbers);
            $blue1 =array_pop($numbers);
            $blue2 = array_pop($numbers);
            $blue3 = array_pop($numbers);
        }

        $time = $matchtime->Format('H:i A');

        $match = new match();
        $match->Competition = $comp;
        $match->Time = $time;
        $match->Number = $matchnum;
        $match->Round = 'qualification';

        $red = new alliance(true);
        $red->Match = $match;
        $red->TeamOne = $red1;
        $red->TeamTwo = $red2;
        $red->TeamThree = $red3;

        $blue = new alliance(false);
        $blue->Match = $match;
        $blue->TeamOne = $blue1;
        $blue->TeamTwo = $blue2;
        $blue->TeamThree = $blue3;

        $match->RedAlliance = $red;
        $match->BlueAlliance = $blue;

        array_push($matches, $match);
       // printf("$time\t$matchnum\t$red1\t$red2\t$red3\t$blue1\t$blue2\t$blue3\n");

        $matchtime->add(new DateInterval('PT' . $minutespermatch . 'M'));
        $matchnum++;

        if ($day1 && ($matchnum > $day1)) {
            $matchtime = date_create($comp->End);
            $matchtime->setTime(9, 0, 0);  // second day starts at 9:00.
            $day1 = false;
        }
    }

    return $matches;
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

function reportTeams($teams) {
    foreach ($teams as $team) {
        printf("%s, %s\n", $team->Number, $team->Name);
    }
}

function reportMatches($matches)
{
    foreach ($matches as $match) {
        $red = $match->RedAlliance;
        $blue = $match->BlueAlliance;

        printf("$match->Time, $match->Number, $red->TeamOne, $red->TeamTwo, $red->TeamThree, ".
               "$blue->TeamOne, $blue->TeamTwo, $blue->TeamThree, $red->Points, $blue->Points\n");
    }
}

//---------------------------------------------------------------------------//

$name = "Oregon City District";
$con = DB::connect();
$comp = competition::selectCompetitionByName($con, $name);

if (!$comp)
    die("Competition \"$name\" not found.");

printf("Competition $name ID=%s\n", $comp->ID);

$teams = $comp->selectTeams($con);
// reportTeams($teams);

$matches = makeMatches($comp, $teams, 12);

reportMatches($matches);
insertMatches($con, $comp, $matches);

?>