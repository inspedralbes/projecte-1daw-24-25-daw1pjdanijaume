<?php

require_once 'connexio.php';

?>

<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Llistat</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <header>
        <a href="https://www.institutpedralbes.cat/">
            <img src="../img/logo.png" alt="Ins Pedralbes">
        </a>
        <h1 class="titulo-sitio">Gestió d'Incidències</h1>
        <nav class="menu-navegacion">
            <a href="../index.html">Inici</a>
            <a href="login.html">Login</a>
            <a href="incidencias.html">Incidències</a>
        </nav>
    </header>

    <section class="seccion-central">
        <a href="../index.html" class="flecha-atras">
            <span class="material-icons">arrow_back</span>
        </a>
        <div class="formulario-basico">
            <h2>Llistat d'incidencies</h2>
            <?php

            $sql = "SELECT ID_incidencia, Descripcio FROM Incidencies";
            $stmt = $pdo->query($sql);

            if ($stmt->rowCount() > 0) {
            echo "<ul>";
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<li>ID: " . $row["ID_incidencia"] . " - Descripcio: " . htmlspecialchars($row["Descripcio"]) . "</li>";
                }
                echo "</ul>";
            } else {
                echo "<p>No hi ha dades a mostrar.</p>";
            }

            ?>
        </div>
    </section>

    <footer>
    <p>&copy; 2025 Daniel Robles & Jaume Hurtado</p>
    <div class="footer-links">
      <a href="#">Contacte</a>
    </div>
  </footer>
</body>

</html>