<?php

require_once 'lib/db.php';
require_once 'lib/competition.php';
require_once 'lib/team.php';
require_once 'lib/game.php';

$con = DB::connect();

$matchid = $_GET["match"];
$match = match::select($con, $matchid);
$number = $match->Number; 

session_start();
$compid = $_SESSION["competitionid"];
$comp = competition::select($con, $compid);

$prevmatch = match::selectByNumber($con, $compid, $number - 1);
$nextmatch = match::selectByNumber($con, $compid, $number + 1);

include 'header.php';
include 'navbar.php';

$red = $match->RedAlliance;
$blue = $match->BlueAlliance;

?>

<label class="heading">Match <?php echo $number; ?></label><br/>
<br/>
<table class='scout_table'>
  <tr>
    <td class='team red'><?php echo $red->TeamOne; ?></td>
    <td class='heading'>Full court shooter, defend away from loading area.</td>
  </tr>
  <tr>
    <td class='team red'><?php echo $red->TeamTwo; ?></td>
    <td class='heading'>defensive, tall extension</td>
  </tr>
  <tr>
    <td class='team red'><?php echo $red->TeamThree; ?></td>
    <td class='heading'>Trouble loading, defend away from loading area.</td>
  </tr>
</table>

<br/>
<table class='scout_table'>
  <tr>
    <td class='team blue'><?php echo $blue->TeamOne; ?></td>
    <td class='heading'></td>
  </tr>
  <tr>
    <td class='team blue'><?php echo $blue->TeamTwo; ?></td>
    <td class='heading'></td>
  </tr>
  <tr>
    <td class='team blue'><?php echo $blue->TeamThree; ?></td>
    <td class='heading'></td>
  </tr>
</table>

<br/>

<div class='navbar'>

<?php

if ($prevmatch != null) 
    printf("<a href='scout-match.php?match=%s' disabled>Previous</a>", $prevmatch->ID);

if ($nextmatch != null) 
    printf("<a href='scout-match.php?match=%s' disabled>Next</a>", $nextmatch->ID);

echo "</div>\n";

include 'footer.php';

?>

