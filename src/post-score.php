<?php

require_once 'lib/db.php';
require_once 'lib/competition.php';
require_once 'lib/team.php';
require_once 'lib/game.php';

include 'authenticate.php';

include 'header.php';
$con = DB::connect();

var_dump($_POST);

$game = new game();
$game->MatchID = $_POST['match'];
$game->MatchNumber = $_POST['team'];
$game->TeamNumber = $_POST['team'];
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

printf("<h1>$game->MatchID, $game->TeamNumber</h1>\n");

?>

<div class="heading" style="height:40px; vertical-align:middle">
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
  <br/>

<?php
                             /*
  <input type="checkbox" name="Offensive"/>Offsensive (vs. Defensive)<br/>
  <input type="checkbox" name="Disqualified"/>Disqualified<br/>
  <input type="checkbox" name="TippedOver"/>Tipped Over<br/>
  <input type="checkbox" name="MechanicalFailure"/>Mechanical Failure<br/>
  <input type="checkbox" name="LostCommunication"/>Lost Communication<br/>
  <input type="checkbox" name="DidNotMove"/>Did Not Move<br/>
  <br/>

  <label class="subject" title="Any other important information about robot to record">Comment</label><br/>
  <textarea rows="8" cols="60" name="Comment"></textarea>
  <br/>
  <input value="Submit" type='Submit'>
</form>
                             */


include 'footer.php';

?>

