<?php

printf("
<div class='navbar'>
<a href='view-teams.php?id=%s'>Teams</a>
<a href='view-matches.php?id=%s'>Matches</a>
<a href='view-standings.php?id=%s'>Standings</a>", $comp->ID, $comp->ID, $comp->ID);

echo "
<div style='float: right;'>
<label class='heading'>$comp->Name</label><br/>
<label style='font-size:12px'>$comp->Start - $comp->End</label>
</div>
<div><label>$username</label></div>

</div>
";

?>