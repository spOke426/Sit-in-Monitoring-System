<?php
$hostName = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "login_reg";

// Correcting the mysqli_connect function
$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);

// Check if connection was successful
if (!$conn) {
    die("Naa ka problem: " . mysqli_connect_error()); // Shows specific error
}
?>
