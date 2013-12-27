<?php

set_include_path(__DIR__);

require_once 'lib/db.php';
require_once 'lib/competition.php';
require_once 'lib/team.php';

$con = DB::connect();
$id = $_GET["id"];
$comp = competition::selectCompetitionByID($con, $id);

if (!$comp)
    die("error: no such competition $id.");

include 'header.php';
include 'navbar.php';

echo "
<table class='basic_table'>
  <tr>
    <th>Team Number</th>
    <th>Team Name</th>
    <th>Location</th>
  </tr>";

$teams = $comp->selectTeams($con);
   
foreach ($teams as $team) {
    printf("
            <tr> 
               <td>%s</td> 
               <td>%s</td> 
               <td>%s, %s, %s</td> 
            </tr>\n", $team->Number, $team->Name, $team->City, $team->State, $team->Country);
}

echo "</table>\n";

DB::disconnect($con);

include 'footer.php';

?>