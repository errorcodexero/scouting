<?php

set_include_path(__DIR__);

require_once 'lib/db.php';
require_once 'lib/team.php';
require_once 'lib/competition.php';

$con = DB::connect();
$number = $_GET["number"];
$team = team::selectTeam($con, $number);

session_start();
$compid = $_SESSION["competitionid"];
$comp = competition::select($con, $compid);

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
    font-size:1em;
    height: 30px;
    border:1px solid #000;
    padding:1px 1px 5px 5px;
}

.scout th 
{
    font-size:1.2em;
    width: 200px;
    border:1px solid #000;
    padding:4px 4px 4px 4px;
    background-color: #888;
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
  </style>
</head>
<body>
  <script type="text/javascript" src="script/jquery-2.0.3.min.js"></script>
  <script type="text/javascript">
  $(document).ready(function() {
      // magic JavaScript to upload selected file.
      document.getElementById("upload").addEventListener('change', handleFileSelect, false);
   });

function handleFileSelect(evt) {
    var file = this.files[0];
    var fd = new FormData();
    var xhr = new XMLHttpRequest();

    fd.append("afile", file);
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
            document.body.appendChild(image);
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

<label>Strategy for</label>
<table class="scout">
  <tr>
    <th>alliance partner</th>
    <th>opposing alliance</th>
    <th>alliance selection</th>
  </tr>
  <tr>
     <td>score</td>
     <td>defend</td>
     <td>3rd among scoring robots</td>
  </tr>
</table>
<textarea rows="4" cols="60" name="comment">Good scorer, maneuverable</textarea>
<br/>
<img src="images/3574-1.png" width="20%" height="20%"/>

<div class="image-upload">
    <label for="upload" style="cursor:pointer;">
        <img src="images/plus.png"/>
    </label>
    <input type="file" id="upload" accept="image/*"  />
</div>

<br/>
<a href="robot-matches.php?number=<php echo $number; ?>">Matches</a>
<a href="robot-games.php?number=<php echo $number; ?>">Games</a>
</body>
</html>