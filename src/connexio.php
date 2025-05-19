<?php
require 'vendor/autoload.php';


$servername = "db";
$username = "usuari";
$password = "paraula_de_pas";
$dbname = "incidencies";

$pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

#$client = new MongoDB\Client("mongodb+srv://projecteDAW2025:ztaVAIdaJ9KWdMTu@Cluster0.mongodb.net/?retryWrites=true&w=majority");
$client = new MongoDB\Client("mongodb://root:example@mongo:27017");

$db = $client->selectDatabase("incidencies");
$logsCollection = $db->selectCollection("incidencies");

return $pdo;