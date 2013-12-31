<?php

require_once 'lib/db.php';
require_once 'lib/competition.php';
require_once 'lib/team.php';
require_once 'lib/game.php';

include 'authenticate.php';
include 'title.php';

$con = DB::connect();
$matchid = $_GET["match"];
$teamnumber = $_GET["team"];
$match = match::select($con, $matchid);

$game = game::select($con, $matchid, $teamnumber);
if ($game == null)
    $game = new game();

// useful for setting checkboxes...
function check($val) {
    if ($val)
        echo "checked";
}

$red = $match->RedAlliance;
$blue = $match->BlueAlliance;
$color = 'red';

// figure out if we're scoring a blue or red team, to adjust the color
if (($teamnumber == $blue->TeamOne) ||
    ($teamnumber == $blue->TeamTwo) || 
    ($teamnumber == $blue->TeamThree))
    $color = 'blue';

// so we can scout the team in the same position in the next match.
if (($teamnumber == $blue->TeamOne) || ($teamnumber == $red->TeamOne))
    $slot = 'TeamOne';
else if (($teamnumber == $blue->TeamTwo) || ($teamnumber == $red->TeamTwo))
    $slot = 'TeamTwo';
else if (($teamnumber == $blue->TeamThree) || ($teamnumber == $red->TeamThree))
    $slot = 'TeamThree';

//printf("$match->Time, $match->Number, $red->TeamOne, $red->TeamTwo, $red->TeamThree, ".
//       ", $red->Points, $blue->Points\n");

?>

<!DOCTYPE HTML>
<html>
<head>
  <meta charset="utf-8" />
  <Title><?php echo $title ?></Title>
  <link rel="stylesheet" href="css/main.css" type="text/css" />
  <script>
    function countAutoDisk(val) {
        auto = document.getElementsByName("autonomous")[0];
        auto.value = parseInt(auto.value) + (2 * parseInt(val));

        // event.stopPropagation();
    }

    function countDisk(val) {
        tel = document.getElementsByName("teleop")[0];
        tel.value = parseInt(tel.value) + parseInt(val);
    }
</script>
</head>
<body>
<table class="score">
  <tr>
	<td class="heading">Match <?php echo $match->Number; ?></td>
	<td>
	  <table>
		<tr>
		  <td class="red team"><?php echo $red->TeamOne; ?></td>
		  <td class="red team"><?php echo $red->TeamTwo; ?></td>
		  <td class="red team"><?php echo $red->TeamThree; ?></td>
		  <td class="blue team"><?php echo $blue->TeamOne; ?></td>
		  <td class="blue team"><?php echo $blue->TeamTwo; ?></td>
		  <td class="blue team"><?php echo  $blue->TeamThree ?></td>
		</tr>
	  </table>
	</td>
  </tr>
</table>
    <table>
      <tr>
          <td class='heading'>Scouting Team</td>
          <td class='<?php echo $color; ?> team'><?php echo $teamnumber; ?></td>
      </tr>
    </table>

<form method='post' action='post-game.php'>
  <table>
    <tr>
      <td class="subject">Autonomous Points</td>
      <td><input type="number" name="autonomous" value="<?php echo $game->Autonomous; ?>" />
          <input type="button" onclick="countAutoDisk(3)" value="3" />
          <input type="button" onclick="countAutoDisk(2)" value="2" />
          <input type="button" onclick="countAutoDisk(1)" value="1" />
      </td>
    </tr>
    <tr>
      <td class="subject">Teleop Points</td>
      <td><input type="number" name="teleop" value="<?php echo $game->Teleop; ?>" />
          <input type="button" onclick="countDisk(3)" value="3" />
          <input type="button" onclick="countDisk(2)" value="2" />
          <input type="button" onclick="countDisk(1)" value="1" />
      </td>
    </tr>
    <tr>
      <td class="subject">Climbing Points</td>
      <td>
<?php 
    for ($i = 0; $i <= 30; $i += 10) {
        printf("<input type='radio' class='inline' name='climbing' %s value='%s' />%s\n",
               (($game->Climbing == $i) ? 'checked' : ''), $i, $i);
    }
?>
    </tr>
    <tr>
      <td class="subject" title="Number of Frisbees scored in Pyramid Goal">Colored Frisbees</td>
      <td>
<?php 
    for ($i = 0; $i < 7; $i++) {
        printf("<input type='radio' class='inline' name='coloredfrisbees' %s value='%s' />%s\n",
               (($game->ColoredFrisbees == $i) ? 'checked' : ''), $i, $i);
    }
?>
      </td>
    </tr>
  </table>
  <table>
      <tr><td><input type="checkbox" name="offensive" <?php check($game->Offensive); ?> /></td><td>Offsensive (vs. Defensive)</td>
          <td><input type="checkbox" name="disqualified" <?php check($game->Disqualified); ?> /></td><td>Disqualified</td></tr>
      <tr><td><input type="checkbox" name="tippedover" <?php check($game->TippedOver); ?> /></td><td>Tipped Over</td>
          <td><input type="checkbox" name="mechanicalfailure" <?php check($game->MechanicalFailure); ?> /></td><td>Mechanical Failure</td></tr>
      <tr><td><input type="checkbox" name="lostcommunication" <?php check($game->LostCommunication); ?>/></td><td>Lost Communication</td>
          <td><input type="checkbox" name="didnotmove" <?php check($game->DidNotMove); ?>/></td><td>Did Not Move</td></tr>
  </table>

  <label class="subject" title="Any other important information about robot to record">Comment</label><br/>
  <textarea rows="4" cols="60" name="comment"><?php echo $game->Comment; ?></textarea>
  <br/>
  <input type="hidden" name="compid" value="<?php echo $matchid; ?>" />
  <input type="hidden" name="matchid" value="<?php echo $matchid; ?>" />
  <input type="hidden" name="matchnumber" value="<?php echo $match->Number; ?>" />
  <input type="hidden" name="teamnumber" value="<?php echo $teamnumber; ?>" />
  <input type="hidden" name="color" value="<?php echo $color; ?>" />
  <input type="hidden" name="slot" value="<?php echo $slot; ?>" />
  <input value="Submit" type='Submit'>
</form>
</body>
</html>
