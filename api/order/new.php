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
        $order[$key] = $el;
    }
}

if ($order != []) {
    $totalpris = 0;
    var_dump($order);
    foreach ($order as $key => $el) {

        // yes its bad
        foreach ($products as $product) {
            if ($key == $product["id"]) {
                $totalpris += (intval($product["pris"] )* intval($el));
                break;
            }
        }
    }

    $time = time();
    $bruker = $_SESSION["id"];
    $avdeling = 1;
    $conn->query("insert into bestillinger (bruker_id, time, total_pris, avdeling) VALUES ('$bruker', $time, $totalpris, $avdeling)");

    $orderid = $conn->query("SELECT * FROM bestillinger WHERE time = $time")->fetch_assoc()["id"];
    foreach ($order as $key => $el) {

        echo $orderid . "," . $el . "," . $key . "<br>";
        $conn->query("INSERT INTO vare_bestilling (vare_id, bestilling_id, antall) VALUES ('$key', $orderid, $el[0])");
    }

    echo "bestilling registrert";
    $user = $conn->query("SELECT * FROM users WHERE id = $bruker")->fetch_assoc();

    require "generatePDF.php";
    require "../EmailClient.php";
    $file = generateOrderPdf($orderid);
    $mail->addAddress($user["email"]);
    $mail->Subject = "Ny bestilling #" . $orderid;
    $mail->Body = "<p>Bestilling #" . $orderid . " er registrert. En kopi av bestillinger er vedlagt denne eposten</p>";
    $mail->addAttachment($file, "bestilling_" . $orderid . ".pdf");
    $mail->send();


}