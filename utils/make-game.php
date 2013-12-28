<?php

set_include_path("../src/");

require_once 'lib/db.php';
require_once 'lib/team.php';
require_once 'lib/match.php';
require_once 'lib/game.php';
require_once 'lib/alliance.php';
require_once 'lib/competition.php';


//---------------------------------------------------------------------------//

$name = "Oregon City District";
$con = DB::connect();
$comp = competition::selectByName($con, $name);

if (!$comp)
    die("Competition \"$name\" not found.");

printf("Competition $name ID=%s\n", $comp->ID);

function reportGames($games)
{
    foreach ($games as $game) {
        $first = true;

        foreach($game as $property => $value) {
            if ($value) {
               if (!$first)
                    print ", ";

                print "$property = $value";
                $first = false;
            }
        }
        print "\n";
    }
}

function reportMatch($match)
{
    $red = $match->RedAlliance;
    $blue = $match->BlueAlliance;

    printf("$match->ID, $match->Time, $match->Number, $red->TeamOne, $red->TeamTwo, $red->TeamThree, ".
           "$blue->TeamOne, $blue->TeamTwo, $blue->TeamThree, $red->Points, $blue->Points\n");
}


$match = match::select($con, 42);
$team = team::selectTeam($con, 1425);

// reportMatch($match);

if ($match == null)
    die("match not found.");

if ($team == null)
    die("team not found.");

// reportMatch($match);
printf("match = %s, team = %s\n", $match->ID, $match->Number);

/*
$game = new game();
$game->MatchID = $match->ID;
$game->MatchNumber = $match->Number;
$game->TeamNumber = $team->Number;
$game->Autonomous = 9;
$game->Teleop = 42;
$game->Climbing = 20;
$game->ColoredFrisbees = 1;
$game->Offensive = true;
$game->Disqualified = false;
$game->TippedOver = false;
$game->MechanicalFailure = false;
$game->LostCommunication = true;
$game->DidNotMove = false;
$game->Comment = "A really good robot with a long comment.";

$game->insert($con);
*/

$game = game::select($con, $match->ID, $team->Number);
reportGames(array($game));

// $games = $match->selectGames($con);
// reportGames($games);

?>