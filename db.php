<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = getenv("MYSQLHOST");
$user = getenv("MYSQLUSER");
$pass = getenv("MYSQLPASSWORD");
$db   = getenv("MYSQLDATABASE");

try {

    $conn = new PDO(
        "mysql:host=$host;dbname=$db",
        $user,
        $pass
    );

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e){

    die("Connection failed: " . $e->getMessage());

}

?>
