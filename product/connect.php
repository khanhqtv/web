<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sp";

    $conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("ket noi bi loi: " . $conn->connect_error);
}