<?php
require_once '../auth/auth.php';

if (!isAdmin()) {
    die("Du har ikke tilgang til denne siden. (Admin tilgang påkreves)");
}

require_once '../../DB.php';

$name;

if (!$conn) {
    die("Noe gikk galt");
}
  
$sql = "INSERT INTO kategorier (name) VALUES ('$name')";
  
if (mysqli_query($conn, $sql)) {
    echo "Kategorien er lagt til databasen";
} else {
    echo "Noe gikk gikk";
}
  
mysqli_close($conn);
?>