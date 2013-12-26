<?php

set_include_path(__DIR__);

require_once 'lib/db.php';
require_once 'lib/competition.php';
require_once 'lib/team.php';
include 'header.php';

$con = DB::connect();
$id = $_GET["id"];
$comp = competition::selectCompetitionByID($con, $id);

if (!$comp)
    die("error: no such competition $id.");

echo "
<label class='heading'>$comp->Name</label><br/>
<label><$comp->Start - $comp->End></label><br/>
<br/><a class='button-link' href='view-teams.php?id=$comp->ID'>Teams</a><br/><br/>
<table class='basic_table'>
  <tr>
    <th>Time</th>
    <th>Number</th>
    <th>Red 1</th>
    <th>Red 2</th>
    <th>Red 3</th>
    <th>Blue 1</th>
    <th>Blue 2</th>
    <th>Blue 3</th>
  </tr>";

function addTeam($team, $hteam, $color, $matchid)
{
    // $text = ($team == $hteam) ? "yellowtext" : "";
    if ($team == $hteam)
        $style="style='color:rgb(255,255,0);'";

    printf("<td class='%s team'><a %s href='score-match.php?match=%s&team=%s' >%s</a></td>", 
           $color, $style, $matchid, $team, $team);
}

$matches = $comp->selectMatches($con);
$highlight = 1425;

foreach ($matches as $match) {
    $red = $match->RedAlliance;
    $blue = $match->BlueAlliance;

    printf("
            <tr> 
              <td>%s</td>
              <td>%s</td>\n", $match->Time, $match->Number);
    addTeam($red->TeamOne, $highlight, "red", $match->Number);
    addTeam($red->TeamTwo, $highlight, "red", $match->Number);
    addTeam($red->TeamThree, $highlight, "red", $match->Number);
    addTeam($blue->TeamOne, $highlight, "blue", $match->Number);
    addTeam($blue->TeamTwo, $highlight, "blue", $match->Number);
    addTeam($blue->TeamThree, $highlight, "blue", $match->Number);
    printf("</tr>\n"); 

/*
    printf("
            <tr> 
              <td>%s</td>
              <td>%s</td>
              <td class='red team'>%s</td>
              <td class='red team'>%s</td>
              <td class='red team'>%s</td>
              <td class='blue team'>%s</td>
              <td class='blue team'>%s</td>
              <td class='blue team'>%s</td>
            </tr>\n", 
           $match->Time, $match->Number, 
           $red->TeamOne, $red->TeamTwo, $red->TeamThree, 
           $blue->TeamOne, $blue->TeamTwo, $blue->TeamThree);
*/
}

echo "</table>\n";

DB::disconnect($con);

include 'footer.php';

?>