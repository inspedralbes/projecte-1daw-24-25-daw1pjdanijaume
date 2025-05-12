<?php
require "connexio.php";

$ID_Incidencia = $_GET["ID_Incidencia"] ?? null;

if ($ID_Incidencia) {
    $query = "SELECT * FROM Incidencies WHERE ID_Incidencia = :ID_Incidencia";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":ID_Incidencia", $ID_Incidencia, PDO::PARAM_INT);

    if ($stmt->execute()) {
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
    }
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
    <h3>Detalls de la incidència</h3><br>
        <p><strong>ID:</strong> <?= htmlspecialchars($fila['ID_Incidencia']) ?></p>
        <p><strong>Data_Inici:</strong> <?= htmlspecialchars($fila['Data_Inici']) ?></p>
        <p><strong>Descripcio:</strong> <?= htmlspecialchars($fila['Descripcio']) ?></p>
        <p><strong>Prioritat:</strong> <?= isset($fila['Prioritat']) && $fila['Prioritat'] !== null ? htmlspecialchars($fila['Prioritat']) : "Encara no assignada" ?></p>
        <p><strong>Tipologia:</strong> <?= isset($fila['Tipologia']) && $fila['Tipologia'] !== null ? htmlspecialchars($fila['Tipologia']) : "Encara no assignada" ?></p>
        <p><strong>Resolta:</strong>
            <?php
            if ($fila['Resolta'] == 1) {
                echo "Incidència resolta";
            } else {
                echo "Incidència no resolta";
            }
            ?>
        </p>
        <p><strong>ID_Tecnic:</strong> <?= isset($fila['ID_Tecnic']) && $fila['ID_Tecnic'] !== null ? htmlspecialchars($fila['ID_Tecnic']) : "Encara no assignat" ?></p>
        <div class="centrado">
        <a href="./afegirActuacio.php">
               <button class="boton" id="centrado" type="submit" name="afegiractuacio">Afegir actuació</button>
        </a>
        </div><div class="centrado">
        <a href="./tancarIncidencia.php">
        <button class="boton" id="centrado" type="submit" name="tancar">Tancar incidència</button>
        </div>
    </div>
</section>

</body>
<footer>
    <p>&copy; 2025 Daniel Robles & Jaume Hurtado</p>
  </footer>
</html>

