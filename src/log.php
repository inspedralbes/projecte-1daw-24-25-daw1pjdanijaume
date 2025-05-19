<?php
require 'connexio.php';

function registrarLog() {
    global $logsCollection;

    $log = [
        'url' => $_SERVER['REQUEST_URI'],
        'user' => isset($_SESSION['username']) ? $_SESSION['username'] : 'Anonymous',
        'timestamp' => new MongoDB\BSON\UTCDateTime(time() * 1000),
        'userAgent' => $_SERVER['HTTP_USER_AGENT']
    ];

    $logsCollection->insertOne($log);
}

registrarLog();
?>