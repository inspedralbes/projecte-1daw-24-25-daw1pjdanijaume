<?php
require 'connexio.php';

$logs = $logsCollection->find([], ['sort' => ['timestamp' => -1]]);

foreach ($logs as $log) {
    echo "<p><strong>URL:</strong> {$log['url']} | <strong>Usuari:</strong> {$log['user']} | <strong>Data:</strong> " . date("d-m-Y H:i:s", $log['timestamp']->toDateTime()->getTimestamp()) . " | <strong>Navegador:</strong> {$log['userAgent']}</p>";
}
?>
