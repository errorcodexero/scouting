﻿<?php

require_once 'lib/db.php';
require_once 'lib/competition.php';
require_once 'lib/team.php';
require_once 'lib/game.php';

include 'authenticate.php';

include 'header.php';
$con = DB::connect();

$compid = $_SESSION["competitionid"];

function check($val) {
    if ($val)
        echo "checked";
}
// var_dump($_POST);

$game = new game();
$game->MatchID = $_POST['matchid'];
$game->MatchNumber = $_POST['matchnumber'];
$game->TeamNumber = $_POST['teamnumber'];
$game->Autonomous = $_POST['autonomous'];
$game->Teleop = $_POST['teleop'];
$game->Climbing = $_POST['climbing'];
$game->ColoredFrisbees = $_POST['coloredfrisbees'];
$game->Offensive  = $_POST['offensive'];
$game->Disqualified  = $_POST['disqualified'];
$game->TippedOver  = $_POST['tippedover'];
$game->MechanicalFailure  = $_POST['mechanicalfailure'];
$game->LostCommunication  = $_POST['lostcommunication'];
$game->DidNotMove  = $_POST['didnotmove'];
$game->Comment  = $_POST['comment'];

$game->insert($con);

?>

<div class="heading" style="height:40px; vertical-align:middle">
  <label class="heading">Match <?php echo $game->MatchNumber; ?></td>
  <label>Scouting Team</label>
  <label style='display:inline;' class='<?php echo $color; ?> team'><?php echo $game->TeamNumber; ?></label>
  <br/>
</div>
  <table>
    <tr>
      <td class="subject">Autonomous Points</td><td><?php echo $game->Autonomous; ?></td>
    </tr>
    <tr>
      <td class="subject">Teleop Points</td><td><?php echo $game->Teleop; ?></td>
    </tr>
    <tr>
      <td class="subject">Climbing Points</td><td><?php echo $game->Climbing; ?></td>
    </tr>
    <tr>
      <td class="subject" title="Number of Frisbees scored in Pyramid Goal">Colored Frisbees</td>
      <td><?php echo $game->ColoredFrisbees; ?></td>
    </tr>
  </table>

  <table>
      <tr>
        <td><input type="checkbox" name="offensive" <?php check($game->Offensive); ?> disabled /></td>
        <td>Offsensive (vs. Defensive)</td>
      </tr>
      <tr>
        <td><input type="checkbox" name="disqualified" <?php check($game->Disqualified); ?>  disabled /></td>
        <td>Disqualified</td>
      </tr>
      <tr>
        <td><input type="checkbox" name="tippedover" <?php check($game->TippedOver);  ?> disabled /></td>
        <td>Tipped Over</td>
      </tr>
      <tr>
        <td><input type="checkbox" name="mechanicalfailure" <?php check($game->MechanicalFailure); ?> disabled /></td>
        <td>Mechanical Failure</td>
      </tr>
      <tr>
        <td><input type="checkbox" name="lostcommunication" <?php check($game->LostCommunication); ?>  disabled /></td>
        <td>Lost Communication</td>
     </tr>
      <tr>
        <td><input type="checkbox" name="didnotmove" <?php check($game->DidNotMove); ?>  disabled /></td>
        <td>Did Not Move</td>
      </tr>
  </table>

  <label class="subject" title="Any other important information about robot to record">Comment</label><br/>
  <textarea rows="8" cols="60" name="Comment" disabled></textarea>
  <br/>

<a href='view-matches.php?id=<?php echo $compid; ?>'>Continue</a>
                             
<?php

include 'footer.php';

?>

