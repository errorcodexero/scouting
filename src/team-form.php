<?php

set_include_path(__DIR__);

require_once 'lib/db.php';
require_once 'lib/team.php';

include 'header.php';

$con = DB::connect();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $team = null;
    $btn = "Create";
    if (isset($_GET["number"])) {  // edit an existing team
        $number = $_GET["number"];
        
        $team = team::selectTeam($con, $number);
        $btn = "Update";

        // echo "number " . $team['Number'] . " name " . $team['Name'];
    }
    else {
        $team = new team(); // make an empty 
    }

    $form = "
<form action='team-form.php' method='post'>
<table>
  <tr>
    <td>Number</td>
    <td><input type='text' name='Number' value='" . $team->Number . "'></td>
  </tr>
  <tr>
    <td>Name</td>
    <td><input type='text' name='Name' value='" . $team->Name . "'></td>
  </tr>
  <tr>
    <td>City</td>
    <td><input type='text' name='City' value='" . $team->City . "'></td>
  </tr>
  <tr>
    <td>State</td>
    <td><input type='text' name='State' value='" . $team->State . "'></td>
  </tr>
  <tr>
    <td>Country</td>
    <td><input type='text' name='Country'  value='" . $team->Country . "'></td>
  </tr>
</table>
<br>";

    echo "<h2>" . $btn ." Team</h2>";
    echo $form;
    echo "<input value='" . $btn . "' type='Submit'>
          </form>";
}
else {  // create a new team
    echo "POST";
}

include 'footer.php';
?>
