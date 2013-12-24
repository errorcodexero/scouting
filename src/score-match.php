<?php

include 'header.php';

?>

<table class="score">
  <tr>
	<td class="heading">Match 42</td>
	<td>
	  <table>
		<tr>
		  <td class="red team">360</td>
		  <td class="red team">1510</td>
		  <td class="red team">422</td>
		  <td class="blue team">2568</td>
		  <td class="blue team">2460</td>
		  <td class="blue team">753</td>
		</tr>
	  </table>
	</td>
  </tr>
</table>

<div class="heading" style="height:40px; vertical-align:middle">Scouting Team<label class="red team">1510</label><br/></div>

<form>
  <table>
    <tr>
      <td class="subject">Autonomous Points</td>
      <td>
      <input type="number" name="Autonomous" value="0" /></td>
    </tr>
    <tr>
      <td class="subject">Teleop Points</td>
      <td>
      <input type="number" name="Teleop" value="0" /></td>
    </tr>
    <tr>
      <td class="subject">Climbing Points</td>
      <td>
      <input type="number" name="Climbing" value="0" /></td>
    </tr>
    <tr>
      <td class="subject" title="Number of Frisbees scored in Pyramid Goal">Colored Frisbees</td>
      <td>
        <input type="radio" class="inline" name="ColoredFrisbees" value="0" />0
        <input type="radio" class="inline" name="ColoredFrisbees" value="1" />1
        <input type="radio" class="inline" name="ColoredFrisbees" value="2" />2
        <input type="radio" class="inline" name="ColoredFrisbees" value="3" />3
        <input type="radio" class="inline" name="ColoredFrisbees" value="4" />4
        <input type="radio" class="inline" name="ColoredFrisbees" value="5" />5
        <input type="radio" class="inline" name="ColoredFrisbees" value="6" />6
      </td>
    </tr>
  </table>

  <br/>
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


<?php

include 'footer.php';

?>

