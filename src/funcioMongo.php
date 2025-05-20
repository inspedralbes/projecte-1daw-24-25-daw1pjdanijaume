<?php
function insertLogs($collection, $Usuari, $dataUsuari, $ipUsuari, $paginaUsuari){
    $collection->insertOne([
    'Usuari'=>$Usuari,
    'Data'=>$dataUsuari,
    'ip_origen'=>$ipUsuari,
    'pagina visitada'=>$paginaUsuari
    ]);
}
?>