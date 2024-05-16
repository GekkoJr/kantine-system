<?php
require "../auth/auth.php";
session_start();
if(!isLoggedIn()) {
     exit("du har ikke tilgang");
}

require "../DB.php";
// loads current items in db
$products = $conn->query("SELECT * FROM varer")->fetch_all(1);
$items = $_POST["varer"];
$order = [];

foreach ($items as $key => $el) {
    if ($el > 0) {
        $order[] = [$key => $el];
    }
}

if ($order != []) {
    $totalpris = 0;

    foreach ($order as $key => $el) {

        // yes its bad
        foreach ($products as $product) {
            if ($key == $product["id"]) {
                $totalpris += ($product["pris"] * intval($el));
                break;
            }
        }
    }

    $time = time();
    $bruker = $_SESSION["id"];
    $conn->query("insert into bestillinger (bruker_id, time, totalpris) VALUES ('$bruekr', $time, $totalpris)");

    $orderid = $conn->query("SELECT * FROM bestillinger WHERE time = $time")->fetch_assoc()["id"];

    foreach ($)
}