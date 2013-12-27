<?php

set_include_path(__DIR__);

require_once 'lib/db.php';
require_once 'lib/competition.php';

include 'header.php';

//session_start();
//printf("Session username = %s\n", $_SESSION['username']);

$con = DB::connect();
$result = competition::selectCompetitions($con);
$year = "2014";

echo "<h1>Competitions " . $year . "</h1>";

while ($row = mysqli_fetch_array($result)) {
    $date = date_create($row['Start']);

    if (date_format($date, 'Y') == $year) {
        printf("
                   <a href='view-matches.php?id=%s'>%s</a><br/>
                   <label>%s - %s</label></br>\n",
               $row['ID'], $row['Name'], $row['Start'], $row['End']);
    }
}

mysqli_free_result($result);
DB::disconnect($con);

include 'footer.php';

?>