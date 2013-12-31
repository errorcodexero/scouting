<?php

set_include_path(__DIR__);

require_once 'lib/db.php';
require_once 'lib/competition.php';
require_once 'lib/team.php';
require_once 'lib/game.php';

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
    <th colspan="2">Score</th>
  </tr>

<?php

function findGame($team, $games)
{
    if ($games != null) {
        foreach ($games as $game) {
            if ($game->TeamNumber == $team)
                return $game;
        }
    }
}

function addTeam($team, $hteam, $color, $match, $games)
{
    $scored = (findGame($team, $games) != null) ? "*" : "";

    // $text = ($team == $hteam) ? "yellowtext" : "";
    if ($team == $hteam)
        $style="style='color:rgb(255,255,0);'";

    printf("              <td class='$color team'><a $style href='score-game.php?match=$match->ID&team=$team' >$scored$team</a></td>\n"); 

//    printf("              <td class='%s team'><a %s href='score-game.php?match=%s&team=%s' >%s</a></td>\n", 
//           $color, $style, $match->ID, $team, $team);
}

$matches = $comp->selectMatches($con);
$highlight = 1425;  // yay for us!

foreach ($matches as $match) {
    $red = $match->RedAlliance;
    $blue = $match->BlueAlliance;

?>
  <tr> 
     <td><?php echo $match->Time; ?></td>
     <td><a href='scout-match.php?match=<?php echo $match->ID . "'>" . $match->Number; ?></a></td>

<?php
//  <td class='red team'>%s</td>

    $games = $match->selectGames($con);
    addTeam($red->TeamOne, $highlight, "red", $match, $games);
    addTeam($red->TeamTwo, $highlight, "red", $match, $games);
    addTeam($red->TeamThree, $highlight, "red", $match, $games);
    addTeam($blue->TeamOne, $highlight, "blue", $match, $games);
    addTeam($blue->TeamTwo, $highlight, "blue", $match, $games);
    addTeam($blue->TeamThree, $highlight, "blue", $match, $games);
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