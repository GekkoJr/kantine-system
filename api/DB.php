<?php
// load env
require ( $_SERVER["DOCUMENT_ROOT"] . "/env.php");

// add errors later^tm
$conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);

