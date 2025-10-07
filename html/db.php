<?php

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "tracktrain";

$mysqli = new mysqli($servername, $username, $password, $dbname);
if($mysqli->erro){
    die("Erro de conexão: " . $mysqli->error);
}

?>
