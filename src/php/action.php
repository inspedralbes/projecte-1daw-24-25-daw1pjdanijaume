<?php

$servername = " ";
$username = " ";
$password = " ";
$dbname = " ";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("No s'ha pogut connectar a la base de dades pel següent error: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $departamento = $_POST["departament"] ?? null;
    $descripcion = $_POST["descripcio"] ?? null;

    if ($departamento && $descripcion) {
        $query = "INSERT INTO registro_incidencias (departamento, descripcion, fecha) VALUES (:departamento, :descripcion, NOW())";
        $stmt = $pdo->prepare($query);

        $stmt->bindParam(":departamento", $departamento);
        $stmt->bindParam(":descripcion", $descripcion);

        if ($stmt->execute()) {
            
            header("Location: confirmacio.html");
            exit;
        } else {
            echo "No s'ha pogut registrar la incidència.";
        }
    } else {
        echo "Si us plau omple tots els camps a l'hora de registrar la incidència.";
    }
}
?>
