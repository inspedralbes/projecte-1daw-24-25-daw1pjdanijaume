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
    <h1 class="titulo-sitio">Consulta d'incidències</h1>
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
        <p><strong>Data d'inici:</strong> <?= htmlspecialchars($fila['Data_Inici']) ?></p>
        <p><strong>Descripcio:</strong> <?= htmlspecialchars($fila['Descripcio']) ?></p>
        <p><strong>Prioritat:</strong> <?= isset($fila['Prioritat']) && $fila['Prioritat'] !== null ? htmlspecialchars($fila['Prioritat']) : "Encara no assignada" ?></p>
        <p><strong>Tipologia:</strong> <?= isset($fila['Tipologia']) && $fila['Tipologia'] !== null ? htmlspecialchars($fila['Tipologia']) : "Encara no assignada" ?></p>
        <p><strong>Estat de lla incidència:</strong>
            <?php
            if ($fila['Resolta'] == 1) {
                echo "Incidència pendent";
            }
            else if ($fila['Resolta'] == 2) {
                            echo "Incidència resolta";
            }
            else if ($fila['Resolta'] == 3) {
                 echo "Incidència tancada";
            }
            else {
                echo "Incidència no resolta";
            }
            ?>
        </p>
        <p><strong>ID_Tecnic:</strong> <?= isset($fila['ID_Tecnic']) && $fila['ID_Tecnic'] !== null ? htmlspecialchars($fila['ID_Tecnic']) : "Encara no assignat" ?></p>
        <div class="centrado">
            <form action="afegirActuacio.php" method="POST">
                    <input type="hidden" name="ID_Incidencia" value="<?= htmlspecialchars($fila['ID_Incidencia']) ?>">
                    <button class="boton" id="centrado" type="submit">Afegir actuació</button>
            </form>
        </div><div class="centrado">
        <a href="tancarIncidencia.php?ID_Incidencia=<?= htmlspecialchars($fila['ID_Incidencia']) ?>">
        <button class="boton" id="centrado" type="submit" name="tancar">Tancar incidència</button>
        </div>
    </div>
</section>

</body>
<footer>
    <p>&copy; 2025 Daniel Robles & Jaume Hurtado</p>
  </footer>
</html>

