<?php
require 'vendor/autoload.php';

$servername = "daw.inspedralbes.cat";
$username = "a24danrobmar_projecte";
$password = "^IkT-?4(D9NvLxEh";
$dbname = "a24danrobmar_projecte";

$pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


#$uri = "mongodb://projecteDAW2025:fwOwYM8tDaZbRlGG  @Cluster0.mongodb.net/?retryWrites=true&w=majority";

#$client = new MongoDB\Client($uri);

#$collection = $client->demo->users;

return $pdo;