<?php
require "connexio.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_incident = $_POST["ID_Incidencia"] ?? null;

    if ($id_incident) {
        $query = "SELECT * FROM Incidencies WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":ID_Incidencia", $id_incidencia, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        }
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
        <input type="number" name="id" id="id" required>
        <button type="submit" class="boton">Buscar</button>
    </form>
    </div>
</section>

    <?php if (!empty($fila)): ?>
        <h3>Detalls de la incidència</h3>
        <p><strong>ID:</strong> <?= htmlspecialchars($fila['id']) ?></p>
        <p><strong>Departament:</strong> <?= htmlspecialchars($fila['Departament']) ?></p>
        <p><strong>Descripció:</strong> <?= htmlspecialchars($fila['Descripcio']) ?></p>
        <p><strong>Data d'inici:</strong> <?= htmlspecialchars($fila['Data_Inici']) ?></p>
    <?php elseif ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
        <p>No s'ha trobat cap incidència amb la ID proporcionada.</p>
    <?php endif; ?>

</body>
<footer>
    <p>&copy; 2025 Daniel Robles & Jaume Hurtado</p>
  </footer>
</html>