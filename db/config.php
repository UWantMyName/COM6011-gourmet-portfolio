<?php
$host = 'localhost';
$db   = 'michelinportofolio';
$user = 'ouzdo4b@localhost';
$pass = 'GordonRamsay';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
