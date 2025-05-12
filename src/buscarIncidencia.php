<?php
require "connexio.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ID_Incidencia = $_POST["ID_Incidencia"] ?? null;

    if ($ID_Incidencia) {
        $query = "SELECT * FROM Incidencies WHERE ID_Incidencia = :ID_Incidencia";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":ID_Incidencia", $ID_Incidencia, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }
    if ($fila) {
        header("Location: actuacions.php?ID_Incidencia=" . $ID_Incidencia);
        exit;
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
    <div class="formulario-basico">
    <h2>Buscar Incidència</h2>
    <form action="" method="POST">
        <label for="id">Ingrese la ID de la incidència:</label>
        <input type="number" name="ID_Incidencia" id="ID_Incidencia" required>
        <button type="submit" class="boton">Buscar</button>
    </form>
    </div>
</section>

    <?php if (!empty($fila)):
        header("Location: actuacions.php?ID_Incidencia=" . $ID_Incidencia);
                        exit;
        ?>
    <?php elseif ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
        <p>No s'ha trobat cap incidència amb la ID proporcionada.</p>
    <?php endif; ?>

</body>
<footer>
    <p>&copy; 2025 Daniel Robles & Jaume Hurtado</p>
  </footer>
</html>