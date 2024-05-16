<?php
require ("../auth/auth.php");

if (!isAdmin()) {
    // die("access denied");
}

require ("../DB.php");

$name = $_POST["navn"];
$beskrivelse = $_POST["beskrivelse"];
if (empty($_POST['allergi'])){
    $allergi = 'Ingen';
} else {
    $allergi = $_POST["allergi"];
}
$kategori = $_POST["kategori"];

$pris = $_POST["pris"];

$q = "INSERT INTO varer (navn, pris, kategori, allergi, beskrivelse) VALUES ('$name', $pris, $kategori, '$allergi', '$beskrivelse')";
$conn->query($q);
header("Location: /administrer_varer.php");