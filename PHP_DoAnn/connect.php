<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname="web1_mysql";

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $conn->query('set names utf8');
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
?>
