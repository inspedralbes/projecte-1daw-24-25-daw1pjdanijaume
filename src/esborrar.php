<?php
require_once "connexio.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $incidenciaID = $_POST["IncidenciaID"] ?? null;

    if ($incidenciaID) {
        try {
            $stmt = $pdo->prepare("DELETE FROM Incidencies WHERE ID_incidencia = :incidenciaID");
            $stmt->bindParam(":incidenciaID", $incidenciaID, PDO::PARAM_INT);

            if ($stmt->execute()) {
                header("Location: llistar.php");
                exit();
            } else {
                echo "Error: No s'ha pogut eliminar la incidència.";
            }
        } catch (PDOException $e) {
            echo "Error en la base de dades: " . $e->getMessage();
        }
    } else {
        echo "Error: No s'ha proporcionat un ID de incidència vàlid.";
    }
}
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Incidència</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <a href="https://www.institutpedralbes.cat/">
          <img src="../img/logo.png" alt="Ins Pedralbes">
        </a>
        <h1 class="titulo-sitio">Gestió d'Incidències</h1>
      </header>

<section class="seccion-central">

</section>

<footer>
    <p>&copy; 2025 Daniel Robles & Jaume Hurtado</p>
  </footer>

</body>
</html>
