<?php

require_once "db.php";

class base {
    static function checkcon($con, $fn) {
        if (!isset($con))
            die("$fn error: no connection.");
    }

    public function set($object) {
        foreach($object as $property => $value) {
            $this->$property = $value;
        }
    }
}

?>