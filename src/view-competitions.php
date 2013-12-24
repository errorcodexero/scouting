<?php

set_include_path(__DIR__);

require_once 'lib/db.php';
require_once 'lib/competition.php';

include 'header.php';

$con = DB::connect();
$result = competition::selectCompetitions($con);
$year = "2014";

echo "<h1>Competitions " . $year . "</h1>";
/*
<div class='competition'>
<table style='border:1px solid black;'>
  <tr>
    <th>Start</th>
    <th>End</th>
    <th>Event</th>
  </tr>\n";
   
    while ($row = mysqli_fetch_array($result)) {
        $date = date_create($row['Start']);

        if (date_format($date, 'Y') == $year) {
            printf("
                   <tr> 
                      <td class='border'>%s</td> 
                      <td class='border'>%s</td> 
                      <td class='border'><a class='competition_link' href='view-competition.php?id=%s'>%s</a></td> 
                   </tr>\n", $row['Start'], $row['End'], $row['ID'], $row['Name']);
        }
    }

echo "</table>\n</div>";
*/

    while ($row = mysqli_fetch_array($result)) {
        $date = date_create($row['Start']);

        if (date_format($date, 'Y') == $year) {
            printf("
                   <a class='competition_link' href='view-competition.php?id=%s'>%s</a><br/>
                   <label>%s - %s</label></br>\n",
                   $row['ID'], $row['Name'], $row['Start'], $row['End']);
        }
    }


DB::disconnect($con);

include 'footer.php';

?>