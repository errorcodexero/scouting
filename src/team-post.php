<?php

include 'connect.php';
include 'teams.php';

$con = connect();

insertTeam($con, $_POST);

disconnect($con);

// redirect to teams
header( 'Location: teams.php' )

?> 

