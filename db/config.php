<?php
$servername = "localhost";
$username = "ouzdo4b_user";
$password = "GordonRamsay";
$dbname = "ouzdo4b_michelinportoflio";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
