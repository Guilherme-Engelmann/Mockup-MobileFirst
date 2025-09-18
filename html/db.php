<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tracktrain";

$mysqli = new mysqli("localhost","root","root","tracktrain");
if($mysqli->connect_errno){
    die("Erro de conexão: " . $mysqli->connect_error);
}

?>