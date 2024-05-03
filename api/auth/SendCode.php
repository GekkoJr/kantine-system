<?php
include ("../DB.php");
$email = $_POST["email"];

$error = null;

if ($email == null) {
    $error = "ingen epost gitt";
}

$query = "SELECT * FROM users WHERE email = $email";
$result = $conn->query($query);

if ($result == null) {
    $error = "du ligger ikke i systemet";
}

if ($error != null) {
    echo $error;
} else {
    $code = random_int(100000, 999999);
    $time = time();
    $conn->query("UPDATE users SET token = $code, token_timestamp = $time");
    include("SendCode.php");
    $mail->addAddress($email);
    $mail->Subject = "Verifikasjons kode";
    $mail->Body = "Koden er: " . $code;
    $mail->send();

}
