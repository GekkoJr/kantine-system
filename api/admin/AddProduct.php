<?php
require ("../auth/auth.php");

if (!isAdmin()) {
    die("access denied");
}

$name = $_POST["name"];
$beskrivelse = $_POST["beskrivelse"];
$allergi = $_POST["allergi"];