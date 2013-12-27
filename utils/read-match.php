<?php

set_include_path("../src/");

require_once 'lib/db.php';
require_once 'lib/team.php';
require_once 'lib/match.php';
require_once 'lib/alliance.php';
require_once 'lib/competition.php';

//---------------------------------------------------------------------------//

$con = DB::connect();

$matchid = $argv[1];

printf("Match $id\n");

$match = match::select($con, $matchid);

$red = $match->RedAlliance;
$blue = $match->BlueAlliance;

printf("$match->Time, $match->Number, $red->TeamOne, $red->TeamTwo, $red->TeamThree, ".
       "$blue->TeamOne, $blue->TeamTwo, $blue->TeamThree, $red->Points, $blue->Points\n");
?>