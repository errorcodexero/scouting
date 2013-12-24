<?php

set_include_path(__DIR__);

require_once 'lib/db.php';
require_once 'lib/competition.php';
require_once 'lib/team.php';

include 'header.php';

$con = DB::connect();
$result = competition::selectCompetitions($con);

$id = $_GET["id"];
$comp = competition::selectCompetitionByID($con, $id);
if (!$comp)
    die("error: no such competition $id.");

echo "
<label class='heading'>$comp->Name</label><br/>
<label>$comp->Start - $comp->End</label><br/>
<div class='competition'>
<table style='border:1px solid black;'>
  <tr>
    <th>Team Number</th>
    <th>Team Name</th>
    <th>Location</th>
  </tr>\n";

$teams = $comp->getTeams($con);
   
foreach ($teams as $team) {
    printf("
            <tr> 
               <td class='border'>%s</td> 
               <td class='border'>%s</td> 
               <td class='border'>%s, %s, %s</td> 
            </tr>\n", $team->Number, $team->Name, $team->City, $team->State, $team->Country);
}

echo "</table>\n</div>";

DB::disconnect($con);

include 'footer.php';

?>