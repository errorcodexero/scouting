<?php

include 'login.php';

session_start();
session_regenerate_id(true); 

unset($_SESSION['username']);
unset($_SESSION['authenticated']);

header( 'Location: view-competitions.php' );

?>