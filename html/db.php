<?php

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "tracktrain";

$mysqli = new mysqli($servername, $username, $password, $dbname);
if($mysqli->connect_errno){
    die("Erro de conexão: " . $mysqli->connect_error);
}

?>