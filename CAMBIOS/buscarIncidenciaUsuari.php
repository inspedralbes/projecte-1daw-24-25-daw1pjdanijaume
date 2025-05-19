<?php
require "connexio.php";

$mensaje = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ID_Incidencia = $_POST["ID_Incidencia"] ?? null;

    if ($ID_Incidencia) {
        $query = "SELECT * FROM Incidencies WHERE ID_Incidencia = :ID_Incidencia";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":ID_Incidencia", $ID_Incidencia, PDO::PARAM_INT);
        $stmt->execute();
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);

     if (!$fila) {
                $mensaje = "No s'ha trobat cap incidència amb la ID proporcionada.";
            } else {
                switch ($fila["Resolta"]) {
                    case 0:
                        header("Location: actuacionsUsuari.php?ID_Incidencia=" . $ID_Incidencia);
                        exit;
                    case 1:
                        header("Location: actuacionsUsuari.php?ID_Incidencia=" . $ID_Incidencia);
                        exit;
                    case 2:
                        header("Location: actuacionsUsuari.php?ID_Incidencia=" . $ID_Incidencia);
                        exit;
                    case 3:
                        $mensaje = "Aquesta incidència ja està tancada i no es pot modificar.";
                        break;
                    default:
                        $mensaje = "Estat de l'incidència desconegut.";
                }
            }
        }
    }

?>

<!DOCTYPE html>
<html lang="ca">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Buscar Incidència</title>
        <link rel="stylesheet" href="css/style.css">
    </head>
<body>
 <header>
        <a href="https://www.institutpedralbes.cat/">
          <img src="../img/logo.png" alt="Ins Pedralbes" />
        </a>
        <h1 class="titulo-sitio">Gestió d'Incidències</h1>
      </header>

    <section class="seccion-central">
        <a href="../index.html" class="flecha-atras">
          <span class="material-icons">arrow_back</span>
        </a>
        <div class="formulario-basico buscar">
        <h2>Buscar Incidència</h2>
        <form method="POST">
            <label for="id">Introdueix l'ID de la incidència:</label>
            <input type="number" name="ID_Incidencia" id="ID_Incidencia" required>
            <div class="centrado">
                <button type="submit" class="boton btn-buscar">Buscar</button>
                <?php if ($mensaje): ?>
                    <p><strong><?= htmlspecialchars($mensaje) ?></strong></p>
                <?php endif; ?>
            </div>
        </form>
    </div>
</section>

<footer>
      <p>&copy; 2025 Daniel Robles & Jaume Hurtado</p>
</footer>

</body>

</html>