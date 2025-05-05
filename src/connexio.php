<?php

$servername = "db";
$username = "usuari";
$password = "paraula_de_pas";
$dbname = "incidencies";

$pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

return $pdo;