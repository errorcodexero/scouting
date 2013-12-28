<?php

set_include_path(__DIR__);

session_start();

require_once 'lib/db.php';
require_once 'lib/competition.php';
require_once 'lib/team.php';

$con = DB::connect();
$id = $_GET["id"];
$comp = competition::select($con, $id);

if (!$comp)
    die("error: no such competition $id.");

session_start();
$_SESSION["competitionid"] = $id;

include 'header.php';
include 'navbar.php';

?>
<table class='basic_table'>
  <tr>
    <th>Time</th>
    <th>Number</th>
    <th colspan="3">Red</th>
    <th colspan="3">Blue</th>
    <th colspan="3">Score</th>
  </tr>

<?php

function addTeam($team, $hteam, $color, $match)
{
    // $text = ($team == $hteam) ? "yellowtext" : "";
    if ($team == $hteam)
        $style="style='color:rgb(255,255,0);'";

    printf("              <td class='%s team'><a %s href='score-match.php?match=%s&team=%s' >%s</a></td>\n", 
           $color, $style, $match->ID, $team, $team);
}

$matches = $comp->selectMatches($con);
$highlight = 1425;  // yay for us!

foreach ($matches as $match) {
    $red = $match->RedAlliance;
    $blue = $match->BlueAlliance;

?>
  <tr> 
     <td><?php echo $match->Time; ?></td>
     <td><?php echo $match->Number; ?></td>
<?php
//  <td class='red team'>%s</td>

    addTeam($red->TeamOne, $highlight, "red", $match);
    addTeam($red->TeamTwo, $highlight, "red", $match);
    addTeam($red->TeamThree, $highlight, "red", $match);
    addTeam($blue->TeamOne, $highlight, "blue", $match);
    addTeam($blue->TeamTwo, $highlight, "blue", $match);
    addTeam($blue->TeamThree, $highlight, "blue", $match);
?>

      <td><?php echo $red->Points; ?></td>
      <td><?php echo $blue->Points; ?></td>
    </tr>    

<?php

}

echo "</table>\n";

if (count($matches) == 0)
    echo "<h1>No matches scheduled yet.</h1>\n";

DB::disconnect($con);

include 'footer.php';

?>