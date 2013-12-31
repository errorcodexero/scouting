<?php

set_include_path(__DIR__);

require_once 'lib/db.php';
require_once 'lib/team.php';
require_once 'lib/robot.php';
require_once 'lib/competition.php';

$con = DB::connect();
$number = $_GET["number"];
$team = team::selectTeam($con, $number);

session_start();
$compid = $_SESSION["competitionid"];
$comp = competition::select($con, $compid);

$robot = robot::select($con, $number);
if ($robot == null) {  // make a new robot if necessary
    $robot = new robot();
    $robot->TeamNumber = $number;
    $robot->insert($con);
}

function makeSelector($enum, $value)
{
    print "<select>\n";
    foreach ($enum as $val => $name) {
        print "<option value='$val'>$name</option>\n";
    }
    print "</select>\n";
}

function makeRoleSelector($value) {
    makeSelector(array('offensive' => 'Offensive', 
                       'defensive' => 'Defensive', 
                       'climber' => 'Climber'), $value);
}


function makeLocationSelector($value) {
    makeSelector(array('pyramid' => 'Pyramid', 
                       'fullcourt' => 'Full Court', 
                       'climber' => 'Climber'), $value);
}

?>

<!DOCTYPE HTML>
<html>
<head>
  <meta charset="utf-8" />
  <Title><?php echo $title ?></Title>
  <link rel="stylesheet" href="css/main.css" type="text/css" />
  <style>
.scout 
{
    border-collapse:collapse;
}

.scout td
{
    font-size:1.2em;
    height: 30px;
    border:1px solid #000;
    padding:2px 2px 2px 8px;
    background-color: white;
}

.scout td:nth-child(1) {
    font-size:1.2em;
    border:1px solid #000;
    padding:4px 4px 4px 4px;
    background-color: #888;
    padding:2px 8px 2px 8px;
    color:white;
}

label
 {    
    font-weight:bold;
    line-height:.7em;
}

.image-upload > input
{
    display: none;
}

img { 
    max-width: 200px;
    max-height: 200px;
}

  </style>
</head>
<body>
  <script type="text/javascript" src="script/jquery-2.0.3.min.js"></script>
  <script type="text/javascript">
    var team = <?php echo $team->Number; ?>;

  $(document).ready(function() {
      // magic JavaScript to upload selected file.
      document.getElementById("upload").addEventListener('change', handleFileSelect, false);
   });

function handleFileSelect(evt) {
    var file = this.files[0];
    var fd = new FormData();
    var xhr = new XMLHttpRequest();

    fd.append("afile", file);
    fd.append("team", team);
    xhr.open('POST', 'image-upload.php', true);
    xhr.upload.onprogress = function(e) {
        if (e.lengthComputable) {
            var percentComplete = (e.loaded / e.total) * 100;
            console.log(percentComplete + '% uploaded');
        }
    };
 
    xhr.onload = function() {
        if (this.status == 200) {
            var resp = JSON.parse(this.response);
 
            console.log('Server got:', resp);
 
            var image = document.createElement('img');
            image.src = resp.dataUrl;
            var images = document.getElementById("images");
            images.appendChild(image);
        };
    };
 
    xhr.send(fd);
}
  </script>
<?php

include 'navbar.php';

?>

<table class="score">
  <tr class='heading'>
    <td>Team</td>
    <td class="team"><?php echo $team->Number; ?></td>
    <td><?php echo $team->Name; ?></td>
  </tr>
</table>
<br/>

<table class="scout">
  <tr>
    <td>Role</td>
    <td><?php makeRoleSelector($robot->Role); ?></td>
  </tr>
    <td>Shooting Location</td>
    <td><?php makeLocationSelector($robot->Role); ?></td>
  </tr>
    <td>Max Autonomous</td>
    <td>
<?php 
    for ($i = 0; $i < 8; $i++) {
        printf("<input type='radio' class='inline' name='maxauto' %s value='%s' />%s\n",
               (($robot->MaxAutonomous == $i) ? 'checked' : ''), $i, $i);
    }
?>
    </td>
  </tr>
    <td>Max Climb</td>
      <td>
<?php 
    for ($i = 0; $i <= 30; $i += 10) {
        printf("<input type='radio' class='inline' name='climbing' %s value='%s' />%s\n",
               (($robot->MaxClimb == $i) ? 'checked' : ''), $i, $i);
    }
?>
    </td>
  </tr>
    <td>Dumper</td>
    <td><input type="checkbox" style="zoom:200%;" name="dumper" /></td>
  </tr>
  </tr>
    <td>Lifter</td>
    <td><input type="checkbox" style="zoom:200%;" name="lifter" <?php if ($robot->Lifter) echo 'checked'; ?> />
  </tr>
    <td>Defensive Height</td>
    <td><input type="number" name="MaxDefensiveHeight" value="<?php echo $robot->MaxDefensiveHeight; ?>"/></td>
  </tr>
    <td>Strategy Partner</td>
    <td><textarea rows="2" cols="60" name="comment"><?php echo $robot->StrategyPartner; ?></textarea></td>
  </tr>
    <td>Strategy Opposition</td>
    <td><textarea rows="2" cols="60" name="comment"><?php echo $robot->StrategyOpposition; ?></textarea></td>
  </tr>
    <td>Comment</td>
    <td><textarea rows="3" cols="60" name="comment"><?php echo $robot->Comment; ?></textarea></td>
  </tr>
</table>


<br/>
<div id="images">
  <img src="images/3574-1.png" />
</div>
<div class="image-upload">
    <label for="upload" style="cursor:pointer;">
        <img src="icons/plus.png"/>
    </label>
    <input type="file" id="upload" accept="image/*"  />
</div>

<br/>
<a href="robot-matches.php?number=<php echo $number; ?>">Matches</a>
<a href="robot-games.php?number=<php echo $number; ?>">Games</a>
</body>
</html>