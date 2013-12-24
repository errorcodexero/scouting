<?php

include "error.php";

class DB 
{
public static function connect() {
// Create connection
    $con=mysqli_connect("localhost","root","team1425rock$","scouting");

// Check connection
    if (mysqli_connect_errno()) {
        simpleError(mysqli_connect_error());
    }

    return $con;
}

public static function disconnect($con)
{
    mysqli_close($con);
}

public static function checkQueryError($con, $sql)
{
    if (!mysqli_query($this,$sql)) {
        die('Error: ' . mysqli_error($con));
    }
}
}

?>
