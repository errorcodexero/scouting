<?php

set_include_path(__DIR__);

require_once 'lib/db.php';
require_once 'lib/competition.php';
require_once 'lib/team.php';

$styles=true;
include 'header.php';

?>

<style>
#teams
{
    font-family:'Trebuchet MS', Arial, Helvetica, sans-serif;
    width:100%;
    border-collapse:collapse;
    margin-left: 0px; 
    text-align:center;
}

#teams td, #teams th 
{
    font-size:1.2em;
    border:1px solid #88F;
    padding:3px 7px 2px 7px;
}

#teams th 
{
    font-size:1.4em;
    padding-top:5px;
    padding-bottom:4px;
    background-color: #448;
    color:white;
}

#teams tr.alt td 
{
    color:#000;
    background-color:#EAF2D3;
}
</style>
</head>
<body>

<?php 

$con = DB::connect();
$result = competition::selectCompetitions($con);

$id = $_GET["id"];
$comp = competition::selectCompetitionByID($con, $id);
if (!$comp)
    die("error: no such competition $id.");

echo "
<label class='heading'>$comp->Name></label><br/>
<label><$comp->Start - $comp->End></label><br/>
<br/><a class='button-link' href='view-matches.php?id=$comp->ID'>Matches</a><br/><br/>
<table id='teams'>
  <tr>
    <th>Team Number</th>
    <th>Team Name</th>
    <th>Location</th>
  </tr>";

$teams = $comp->selectTeams($con);
   
$numteams = count($teams);

foreach ($teams as $team) {
    printf("
            <tr> 
               <td>%s</td> 
               <td>%s</td> 
               <td>%s, %s, %s</td> 
            </tr>\n", $team->Number, $team->Name, $team->City, $team->State, $team->Country);
}

echo "</table>\n";

DB::disconnect($con);

include 'footer.php';

?>