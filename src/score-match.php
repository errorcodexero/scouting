<?php

require_once 'lib/db.php';
require_once 'lib/competition.php';
require_once 'lib/team.php';

include 'authenticate.php';

include 'header.php';

$con = DB::connect();
$matchid = $_GET["match"];
$teamnumber = $_GET["team"];
$match = match::select($con, $matchid);

// printf("<h1>$matchid, $teamnumber</h1>\n");

$red = $match->RedAlliance;
$blue = $match->BlueAlliance;
$color = 'red';

// figure out if we're scoring a blue or red team, to adjust the color
if (($teamnumber == $blue->TeamOne) ||
    ($teamnumber == $blue->TeamTwo) || 
    ($teamnumber == $blue->TeamThree))
    $color = 'blue';

//printf("$match->Time, $match->Number, $red->TeamOne, $red->TeamTwo, $red->TeamThree, ".
//       ", $red->Points, $blue->Points\n");

?>

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

<form method='post' action='post-score.php'>
  <table>
    <tr>
      <td class="subject">Autonomous Points</td>
      <td>
      <input type="number" name="autonomous" value="0" /></td>
    </tr>
    <tr>
      <td class="subject">Teleop Points</td>
      <td>
      <input type="number" name="teleop" value="0" /></td>
    </tr>
    <tr>
      <td class="subject">Climbing Points</td>
      <td>
      <input type="number" name="climbing" value="0" /></td>
    </tr>
    <tr>
      <td class="subject" title="Number of Frisbees scored in Pyramid Goal">Colored Frisbees</td>
      <td>
        <input type="radio" class="inline" name="coloredfrisbees" value="0" />0
        <input type="radio" class="inline" name="coloredfrisbees" value="1" />1
        <input type="radio" class="inline" name="coloredfrisbees" value="2" />2
        <input type="radio" class="inline" name="coloredfrisbees" value="3" />3
        <input type="radio" class="inline" name="coloredfrisbees" value="4" />4
        <input type="radio" class="inline" name="coloredfrisbees" value="5" />5
        <input type="radio" class="inline" name="coloredfrisbees" value="6" />6
      </td>
    </tr>
  </table>

  <br/>
  <input type="checkbox" name="offensive"/>Offsensive (vs. Defensive)<br/>
  <input type="checkbox" name="disqualified"/>Disqualified<br/>
  <input type="checkbox" name="tippedover"/>Tipped Over<br/>
  <input type="checkbox" name="mechanicalfailure"/>Mechanical Failure<br/>
  <input type="checkbox" name="lostcommunication"/>Lost Communication<br/>
  <input type="checkbox" name="didnotmove"/>Did Not Move<br/>
  <br/>

  <label class="subject" title="Any other important information about robot to record">Comment</label><br/>
  <textarea rows="8" cols="60" name="comment"></textarea>
  <br/>
  <input type="hidden" name="matchid" value="<?php echo $matchid; ?>" />
  <input type="hidden" name="matchnumber" value="<?php echo $match->Number; ?>" />
  <input type="hidden" name="team" value="<?php echo $teamnumber; ?>" />
  <input value="Submit" type='Submit'>
</form>


<?php

include 'footer.php';

?>

