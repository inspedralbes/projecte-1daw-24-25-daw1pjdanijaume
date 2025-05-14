<?php
require "connexio.php";

$ID_Incidencia = intval($_GET["ID_Incidencia"]);


$query = "SELECT * FROM Actuacions WHERE ID_Incidencia = :ID_Incidencia";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":ID_Incidencia", $ID_Incidencia, PDO::PARAM_INT);
$stmt->execute();

$incidencia = $stmt->fetch(PDO::FETCH_ASSOC);

$ID_Incidencia = $_GET["ID_Incidencia"] ?? null;

    if (!$incidencia) {
        echo "<p>No s'ha trobat cap incidència amb la ID proporcionada.</p>";
        exit;
    }

    if ($incidencia["Resolta"] == 1) {
    echo "<p>Aquesta incidència ja està resolta està resolta.</p>";
            exit;
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
    <h3>Actuació a una incidència</h3><br>
        <p><strong>ID:</strong> <?= htmlspecialchars($incidencia['ID_Incidencia']) ?></p>
        <p><strong>Data d'inici de la incidencia:</strong> <?= htmlspecialchars($incidencia['Data_Inici']) ?></p>
        <p><strong>Data de l'actuació:</strong> <?= htmlspecialchars($incidencia['Data_Actuacio']) ?></p>
        <p><strong>Descripcio de l'actuació:</strong> <?= htmlspecialchars($incidencia['Descripcio']) ?></p>
        <p><strong>Temps dedicat a l'actuació:</strong> <?= isset($incidencia['Temps']) ?></p>
        <p><strong>Tècnic de l'actuació:</strong> <?= isset($incidencia['ID_Tecnic']) ?></p>

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