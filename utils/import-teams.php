<?php

set_include_path("c:/Tools/wamp/apps/scouting/");

require_once 'lib/db.php';
require_once 'lib/team.php';

function json_last_error_msg() {
    switch (json_last_error()) {
        default:
            return;
        case JSON_ERROR_DEPTH:
            $error = 'Maximum stack depth exceeded';
            break;
        case JSON_ERROR_STATE_MISMATCH:
            $error = 'Underflow or the modes mismatch';
            break;
        case JSON_ERROR_CTRL_CHAR:
            $error = 'Unexpected control character found';
            break;
        case JSON_ERROR_SYNTAX:
            $error = 'Syntax error, malformed JSON';
            break;
        case JSON_ERROR_UTF8:
            $error = 'Malformed UTF-8 characters, possibly incorrectly encoded';
            break;
    }

    throw new Exception($error);
}

$homepage = file_get_contents('teams.json');

$teams = json_decode($homepage, true, 5);
json_last_error_msg();

// var_dump($teams);
$con = DB::connect();

foreach ($teams as $team) {
    $st = team::selectTeam($con, $team['Number']);

    if (!$st) {
        printf("Missing: %s, %s, %s\n", $team['Number'], $team['Name'], $team['City']);
        team::insertTeam($con, $team);
    }
    // else {
    //    var_dump($st);
    //}
}
?>