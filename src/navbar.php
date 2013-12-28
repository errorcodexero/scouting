<div class='navbar'>
<a href='view-teams.php?id=<?php echo $comp->ID; ?>'>Teams</a>
<a href='view-matches.php?id=<?php echo $comp->ID; ?>'>Matches</a>
<a href='view-standings.php?id=<?php echo $comp->ID; ?>'>Standings</a>

<div style='float: right;'>
  <label class='heading'><?php echo $comp->Name; ?></label><br/>
  <label style='font-size:12px'><?php echo $comp->Start . ' - ' . $comp->End; ?></label>
</div>
<div>
  <label><?php echo $username; ?></label></div>
</div>
