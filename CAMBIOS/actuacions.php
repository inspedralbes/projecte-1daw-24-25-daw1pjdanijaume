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
    <div class="formulario-lista actuaciones">
        <h2>Detalls de la incidència</h2>
        <div class="tabla-scrollable">
            <label>ID</label>
            <div class="campo-input actuaciones">
                <p><?= htmlspecialchars($fila['ID_Incidencia']) ?></p>
            </div>
            <label>Data d'inici</label>
            <div class="campo-input actuaciones">
                <p><?= htmlspecialchars($fila['Data_Inici']) ?></p>
            </div>
            <label>Descripció</label>
            <div class="campo-input actuaciones">                
                <p><?= htmlspecialchars($fila['Descripcio']) ?></p>
            </div>
            <label>Prioritat</label>
            <div class="campo-input actuaciones">                
                <p><?= isset($fila['Prioritat']) && $fila['Prioritat'] !== null ? htmlspecialchars($fila['Prioritat']) : "Encara no assignada" ?></p>
            </div>
            <label>Tipologia</label>
            <div class="campo-input actuaciones">                
                <p><?= isset($fila['Tipologia']) && $fila['Tipologia'] !== null ? htmlspecialchars($fila['Tipologia']) : "Encara no assignada" ?></p>
            </div>
            <label>Estat de la incidència</label>
            <div class="campo-input actuaciones">
                <p>
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
            </div>
            <label>ID del tècnic</label>
            <div class="campo-input actuaciones">
                <p><?= isset($fila['ID_Tecnic']) && $fila['ID_Tecnic'] !== null ? htmlspecialchars($fila['ID_Tecnic']) : "Encara no assignat" ?></p>
            </div>
        </div>
        <div class="alineados">
                <a href="llistatActuacions.php?ID_Incidencia=<?= htmlspecialchars($fila['ID_Incidencia']) ?>">
                <button class="boton" id="centrado" type="submit" name="llistaActuacions">Actuacions de la incidència</button></a>
            <form action="afegirActuacio.php" method="POST">
                    <input type="hidden" name="ID_Incidencia" value="<?= htmlspecialchars($fila['ID_Incidencia']) ?>">
                    <button class="boton" id="centrado" type="submit">Afegir actuació</button>
            </form>
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

