<?php

require "connexio.php";

//try {
//    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
//  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//} catch (PDOException $e) {
//    die("No s'ha pogut connectar a la base de dades pel següent error: " . $e->getMessage());
//}
//
//$sqlScript = file_get_contents("create.sql");
//if ($conn->multi_query($sqlScript)) {
//    echo "Base de datos y tablas creadas exitosamente.";
//} else {
//    echo "Error al ejecutar el script SQL: " . $conn->error;
//}

//$conn->close();
//$db_check = $conn->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$dbname'");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Departament = $_POST["Departament"] ?? null;
    $Descripcio = $_POST["Descripcio"] ?? null;

    if ($Departament && $Descripcio) {
       $stmt = $pdo->prepare("INSERT INTO Incidencies (Departament, Data_Inici, Descripcio) VALUES (:departament, NOW(), :descripcio)");
            $stmt->bindParam(":departament", $Departament, PDO::PARAM_STR);
            $stmt->bindParam(":descripcio", $Descripcio, PDO::PARAM_STR);
            if ($stmt->execute()) {
                header("Location: ./html/confirmacio.html");
                exit();
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
            $conn->close();
    } else {
        ?>
        <!--<!DOCTYPE html>
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
            <nav class="menu-navegacion">
              <a href="../../index.html">Inici</a>
              <a href="login.html">Login</a>
              <a href="incidencias.html">Incidències</a>
            </nav>
          </header>

          <section class="seccion-central">
            <div class="formulario-basico" id="incidencies">
              <h2>Vols fer una incidència?</h2>
              <p>Completa el següent formulari.</p>
              <a href="./action.php">
                <button class="boton">Incidència</button>
              </a>
            </div>

            <div class="formulario-basico" id="login-acces">
              <h2>Accés tècnics</h2>
              <p>Inicia sessió o registra’t amb les teves credencials.</p>
              <a href="html/login.html">
                <button class="boton">Accedir</button>
              </a>
            </div>

            <div class="formulario-basico" id="login-acces">
              <h2>Llistat</h2>
              <p>a.</p>
              <a href="./llistat.php">
                <button class="boton">Accedir</button>
              </a>
            </div>
          </section>

          <footer>
            <p>&copy; 2025 Daniel Robles & Jaume Hurtado</p>
            <div class="footer-links">
              <a href="#">Contacte</a>
            </div>
          </footer>

        </body>
        </html>-->
        <?php
    }
}
?>
<!DOCTYPE html>
<html lang="ca">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../css/style.css">
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
    <div class="contenedor-principal incidencies">
      <div class="contenedor-formulario">
        <form action="../action.php" method="post">
          <h2>Incidència</h2>
            <div class="in-line">
                <label for="Departament">Departament:</label>
                <select class="campo-input" id="departament" name="Departament" required>
                    <option value="Contabilitat">Contabilitat</option>
                    <option value="Administracio">Administració</option>
                    <option value="Produccio">Producció</option>
                    <option value="Manteniment">Manteniment</option>
                    <option value="Informatica">Informàtica</option>
                    <option value="Suport tecnic">Suport tècnic</option>
                    <option value="Marketing">Marketing</option>
                    <option value="Atencio al client">Atenció al client</option>
                </select>
          </div>
          <div class="campo-input">
            <ion-icon name="reader-outline"></ion-icon>
            <input name="Descripcio" type="text" placeholder="Descripció" />
          </div>
          <br><br>
          <button class="boton" type="submit">Enviar</button>
        </form>
      </div>
    </div>
  </section>

  <footer>
    <p>&copy; 2025 Daniel Robles & Jaume Hurtado</p>
  </footer>

  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>
