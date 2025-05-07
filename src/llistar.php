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
        <div class="formulario-lista">
            <h2>Llistat d'incidencies</h2>
            <?php

            $sql = "SELECT ID_incidencia, Departament, Descripcio, Data_Inici FROM Incidencies";
            $stmt = $pdo->query($sql);

            if ($stmt->rowCount() > 0) {
            echo "<table><tr><td>ID</td><td>Departament</td><td>Descripció</td><td>Hora</td><td></td></tr>";
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr><td>" . $row["ID_incidencia"] . "</td><td>" . htmlspecialchars($row["Departament"]) . "</td><td>" . htmlspecialchars($row["Descripcio"]) . "</td><td>" . $row["Data_Inici"] . "</td>";
                    echo "<td><form action='esborrar.php' method='post' style='display:inline;'>
                                                                         <input type='hidden' name='IncidenciaID' value='" . $row["ID_incidencia"] . "' />
                                                                         <button class='boton' type='submit' onclick='return confirm(\"Estàs segur que vols eliminar aquesta incidència?\")'>Eliminar</button>
                                                                       </form></td></tr>";
                }
                echo "</table>";
            } else {
                echo "<br><p>No hi ha dades a mostrar.</p><br>";
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