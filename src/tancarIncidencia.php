<?php
require "connexio.php";

$ID_Incidencia = intval($_GET["ID_Incidencia"]);


$query = "SELECT * FROM Incidencies WHERE ID_Incidencia = :ID_Incidencia";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":ID_Incidencia", $ID_Incidencia, PDO::PARAM_INT);
$stmt->execute();


$incidencia = $stmt->fetch(PDO::FETCH_ASSOC);

$ID_Incidencia = $_GET["ID_Incidencia"] ?? null;

    if (!$incidencia) {
        echo "<p>No s'ha trobat cap incidència amb la ID proporcionada.</p>";
        exit;
    }

    if ($incidencia["Resolta"] < 2) {
    ?>
    <!DOCTYPE html>
    <html lang="ca">
     <head>
         <link rel="stylesheet" href="css/style.css">
     </head>
     <body>
         <header>
            <a href="https://www.institutpedralbes.cat/">
                <img src="../img/logo.png" alt="Ins Pedralbes">
            </a>
        <h1 class="titulo-sitio">Consulta d'ncidències</h1>
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
      <h3>Tancament d'incidència</h3><br>
      <p>No es pot tancar aquesta incidència perque encara no està resolta</p>
      <div><button class="boton" onclick="window.history.back();">Tornar enrere</button></div>
              </div>
      </body>
  </html>

    <?php
            exit;
        }
    else if ($incidencia["Resolta"] > 2) {
    ?>
        <!DOCTYPE html>
        <html lang="ca">
        <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <title>Confirmació</title>
          <link rel="stylesheet" href="../css/style.css">
        </head>
        <body>
          <header>
            <a href="https://www.institutpedralbes.cat/">
              <img src="../img/logo.png" alt="Ins Pedralbes">
            </a>
          </header>

          <section class="seccion-central">
            <a href="../index.html" class="flecha-atras">
              <span class="material-icons">arrow_back</span>
            </a>
            <div class="formulario-basico">
              <h2>Incidència tancada</h2>
              <p>Aquesta incidència ja està tancada.</p>
                <div><button class="boton" onclick="window.history.back();">Tornar enrere</button></div>
                </div>
            </div>
          </section>

          <footer>
            <p>Daniel Robles    |   Jaume Hurtado</p>
          </footer>
        </body>
        </html>
        <?php
            exit;
        }

    $query = "UPDATE Incidencies SET Resolta = 3 WHERE ID_Incidencia = :ID_Incidencia";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":ID_Incidencia", $ID_Incidencia, PDO::PARAM_INT);
    if ($stmt->execute()) {
            header("Location: incidenciaTancada.php");
            exit;
        } else {
            echo "<p>Error en tancar la incidència.</p>";
        }

?>

<!DOCTYPE html>
<html lang="ca">
 <header>
     <link rel="stylesheet" href="css/style.css">
    <a href="https://www.institutpedralbes.cat/">
        <img src="../img/logo.png" alt="Ins Pedralbes">
    </a>
    <h1 class="titulo-sitio">Consulta d'ncidències</h1>
    <nav class="menu-navegacion">
      <a href="../index.html">Inici</a>
      <a href="login.html">Login</a>
      <a href="incidencias.html">Incidències</a>
    </nav>
  </header>

<body>
    <section class="seccion-central">
        <a href="../index.html" class="flecha-atras">
          <span class="material-icons">arrow_back</span>
        </a>
    <div class="formulario-lista">
    <h3>Tancament d'incidència</h3><br>
        <p><strong>ID:</strong> <?= htmlspecialchars($incidencia['ID_Incidencia']) ?></p>
        <p><strong>Data_Inici:</strong> <?= htmlspecialchars($incidencia['Data_Inici']) ?></p>
        <p><strong>Descripcio:</strong> <?= htmlspecialchars($incidencia['Descripcio']) ?></p>
        <p><strong>Prioritat:</strong> <?= isset($incidencia['Prioritat']) && $incidencia['Prioritat'] !== null ? htmlspecialchars($incidencia['Prioritat']) : "Encara no assignada" ?></p>
        <p><strong>Tipologia:</strong> <?= isset($incidencia['Tipologia']) && $incidencia['Tipologia'] !== null ? htmlspecialchars($incidencia['Tipologia']) : "Encara no assignada" ?></p>
        <p><strong>Resolta:</strong>
            <?php
            if ($incidencia['Resolta'] > 1) {
                echo "Incidència resolta";
            } else {
                echo "Incidència no resolta";
            }
            ?>
        </p>
        <p><strong>ID_Tecnic:</strong> <?= isset($incidencia['ID_Tecnic']) && $incidencia['ID_Tecnic'] !== null ? htmlspecialchars($incidencia['ID_Tecnic']) : "Encara no assignat" ?></p>
        <h4>Aquesta incidència ja està resolta, vols tancarla definitivament?<h4>
        <div class="centrado">
        <a href="./afegirActuacio.php">
               <button class="boton" id="centrado" type="submit" name="tancament">Tancar incidència</button>
        </a>
    </div>
</section>

</body>
<footer>
    <p>&copy; 2025 Daniel Robles & Jaume Hurtado</p>
  </footer>
</html>