<?php

set_include_path(__DIR__);

require_once 'lib/db.php';
require_once 'lib/team.php';

include 'header.php';

$con = DB::connect();
$result = team::selectTeams($con);

    echo "
<h1>Teams</h1>
<a href='team-form.php' class='button-link'>New Team</a>
<br><br>
<table>
  <tr>
    <th>Number</th>
    <th>Name</th>
  </tr>";

    while ($row = mysqli_fetch_array($result)) {
        printf("
             <tr>
                <td class='blue team'><a href=team-form.php?number=%s>%s</a></td>
                <td>%s</td>
             </tr>", $row['Number'], $row['Number'], $row['Name']);
    }

    echo "</table>";

DB::disconnect($con);

include 'footer.php';

?>