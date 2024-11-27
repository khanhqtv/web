<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sv";

    $conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("ket noi bi loi: " . $conn->connect_error);
}