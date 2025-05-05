<?php

require_once "connexio.php";

$servername = "db";
$username = "usuari";
$password = "paraula_de_pas";
$dbname = "incidencies";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
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
          <header>
            <a href="https://www.institutpedralbes.cat/">
              <img src="img/logo.png" alt="Ins Pedralbes">
            </a>
            <h1 class="titulo-sitio">Gestió d'Incidències</h1>
            <!--<nav class="menu-navegacion">
              <a href="../../index.html">Inici</a>
              <a href="login.html">Login</a>
              <a href="incidencias.html">Incidències</a>
            </nav>-->
          </header>

          <section class="seccion-central">
            <div class="formulario-basico" id="incidencies">
              <h2>Vols fer una incidència?</h2>
              <p>Completa el següent formulari.</p>
              <a href="./action.php">
                <button class="boton">Incidència</button>
              </a>
            </div>
            <!--
            <div class="formulario-basico" id="login-acces">
              <h2>Accés tècnics</h2>
              <p>Inicia sessió o registra’t amb les teves credencials.</p>
              <a href="html/login.html">
                <button class="boton">Accedir</button>
              </a>
            </div>
            -->
          </section>

          <footer>
            <p>&copy; 2025 Daniel Robles & Jaume Hurtado</p>
            <div class="footer-links">
              <a href="#">Contacte</a>
            </div>
          </footer>

        </body>
        </html>
        <?php
    }
}
?>
