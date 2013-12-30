<?php

set_include_path(__DIR__);

require_once 'lib/db.php';
require_once 'lib/competition.php';
require_once 'lib/team.php';

$con = DB::connect();
$id = $_GET["id"];
$comp = competition::select($con, $id);

if (!$comp)
    die("error: no such competition $id.");

include 'header.php';
include 'navbar.php';

?>
<table class='basic_table'>
  <tr>
    <th>Team Number</th>
    <th>Team Name</th>
    <th>Location</th>
  </tr>

<?php

$teams = $comp->selectTeams($con);
   
foreach ($teams as $team) {
?>
     <tr> 
        <td><a href='team-form.php?number=<?php echo $team->Number . "'>" . $team->Number ?></a></td> 
        <td><?php echo $team->Name; ?></td> 
        <td><?php echo $team->City . ", " . $team->State . ", " . $team->Country; ?></td>
     </tr> 

<?php
}

echo "</table>\n";

DB::disconnect($con);

include 'footer.php';

?>