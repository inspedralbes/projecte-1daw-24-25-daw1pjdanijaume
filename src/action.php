<?php

require "connexio.php";
include "crear.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Departament = $_POST["Departament"] ?? null;
    $Descripcio = $_POST["Descripcio"] ?? null;

    if ($Departament && $Descripcio) {
        $query = "INSERT INTO Incidencies (Departament, Descripcio, Data_Inici) VALUES (:Departament, :Descripcio, NOW())";
        $stmt = $pdo->prepare($query);

        $stmt->bindParam(":Departament", $Departament);
        $stmt->bindParam(":Descripcio", $Descripcio);

        if ($stmt->execute()) {
            
            header("Location: confirmacio.html");
            exit;
        } else {
            echo "No s'ha pogut registrar la incidència.";
        }
    } else {
        ?>
        <!DOCTYPE html>
        <html lang="ca">
        <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <title>Pàgina d'inici</title>
          <link rel="stylesheet" href="css/style.css">
        </head>
        <body>

          <footer>
    <p>&copy; 2025 Daniel Robles & Jaume Hurtado</p>
  </footer>

        </body>
        </html>
        <?php
    }
}
?>
