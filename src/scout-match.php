<?php

require_once 'lib/db.php';
require_once 'lib/competition.php';
require_once 'lib/team.php';
require_once 'lib/game.php';

include 'header.php';
$con = DB::connect();

$compid = $_SESSION["competitionid"];

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
        <td><input type="checkbox" name="disqualified" <?php check($game->Disqualified); ?>  disabled /></td>
        <td>Disqualified</td>
      </tr>
      <tr>
        <td><input type="checkbox" name="tippedover" <?php check($game->TippedOver);  ?> disabled /></td>
        <td>Tipped Over</td>
        <td><input type="checkbox" name="mechanicalfailure" <?php check($game->MechanicalFailure); ?> disabled /></td>
        <td>Mechanical Failure</td>
      </tr>
      <tr>
        <td><input type="checkbox" name="lostcommunication" <?php check($game->LostCommunication); ?>  disabled /></td>
        <td>Lost Communication</td>
        <td><input type="checkbox" name="didnotmove" <?php check($game->DidNotMove); ?>  disabled /></td>
        <td>Did Not Move</td>
      </tr>
  </table>

  <label class="subject" title="Any other important information about robot to record">Comment</label><br/>
  <textarea rows="4" cols="60" name="Comment" disabled><?php echo $game->Comment; ?></textarea>
  <br/>

<?php

$nmatch = match::selectByNumber($con, $compid, $game->MatchNumber + 1);

if ($nmatch != null) {
    if ($color == 'red')
        $nteam = $nmatch->RedAlliance->$slot;
    else
        $nteam = $nmatch->BlueAlliance->$slot;

    echo "<a href='score-game.php?match=$nmatch->ID&team=$nteam'>Continue</a>\n";
}
else {
include 'navbar.php';
}

include 'footer.php';

?>

