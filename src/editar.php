<?php
require_once 'connexio.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["IncidenciaID"])) {
    $id = $_POST["IncidenciaID"];

    $sql = "SELECT * FROM Incidencies WHERE ID_Incidencia = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $incidencia = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$incidencia) {
        echo "Incidència no trobada.";
        exit;
    }
} else {
    echo "ID de incidència no proporcionat.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["actualizar"])) {
    $Prioritat = $_POST["Prioritat"];
    $Tipologia = $_POST["Tipologia"];
    $Resolta = $_POST["Resolta"];
    $Id_Tecnic = $_POST["ID_Tecnic"];

    if (!is_numeric($Id_Tecnic)) {
    ?>
        <link rel="stylesheet" href="../css/style.css">
        <div><p>L'ID del tècnic ha de ser un número.</p></div><br>
        <div><button class="boton" onclick="window.history.back();">Tornar enrere</button></div>
        <?php
        exit;
    }

    $sql_update = "UPDATE Incidencies SET Prioritat=?, Tipologia=?, Resolta=?, ID_Tecnic=? WHERE ID_Incidencia=?";
    $stmt_update = $pdo->prepare($sql_update);
    $stmt_update->execute([$Prioritat, $Tipologia, $Resolta, $Id_Tecnic, $id]);

    header("Location: index.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Edició d'incidència</title>
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
            <a href="../dadesincidencia.php" class="flecha-atras">
                <span class="material-icons">arrow_back</span>
            </a>
    <div class="formulario-editar">
    <h2>Editar Incidència</h2><br>
    <form id="formulario-editar" action="editar.php" method="post">
        <input type="hidden" name="IncidenciaID" value="<?= htmlspecialchars($incidencia["ID_Incidencia"]) ?>">
        <p>ID de la incidència : <?= htmlspecialchars($incidencia["ID_Incidencia"]) ?></p><br>
        <p>Data d'inici: <?= htmlspecialchars($incidencia["Data_Inici"]) ?></p><br>
        <p>Departament: <?= htmlspecialchars($incidencia["Departament"]) ?></p><br>
        <input type="hidden" name="Departament" value="<?= htmlspecialchars($incidencia["Departament"]) ?>">
        <p>Descripcio: <?= htmlspecialchars($incidencia["Descripcio"]) ?></p><br>
        <input type="hidden" name="Descripcio" value="<?= htmlspecialchars($incidencia["Descripcio"]) ?>">

        <label for="Prioritat">Prioritat:</label>
        <select name="Prioritat">
            <option value="Baixa" <?= ($incidencia["Prioritat"] == "Baixa") ? "selected" : "" ?>>Baixa</option>
            <option value="Mitja" <?= ($incidencia["Prioritat"] == "Mitja") ? "selected" : "" ?>>Mitja</option>
            <option value="Alta" <?= ($incidencia["Prioritat"] == "Alta") ? "selected" : "" ?>>Alta</option>
        </select><br><br>

        <label for="Tipologia">Tipologia:</label>
        <input type="text" name="Tipologia" value="<?= htmlspecialchars($incidencia["Tipologia"] ?? '') ?>"><br><br>

        <label for="Resolta">Resolta:</label>
        <select name="Resolta">
            <option value="0" <?= ($incidencia["Resolta"] == 0) ? "selected" : "" ?>>No resolta</option>
            <option value="1" <?= ($incidencia["Resolta"] == 1) ? "selected" : "" ?>>Resolta</option>
        </select><br><br>

        <label for="ID_Tecnic">ID Tècnic:</label>
        <input type="text" name="ID_Tecnic" value="<?= htmlspecialchars($incidencia["ID_Tecnic"] ?? '') ?>"><br><br>

        <div id="centrado">
        <button class="boton" id="centrado" type="submit" name="actualizar">Guardar canvis</button>
        </div>
    </form>
</div>
<footer>
    <p>&copy; 2025 Daniel Robles & Jaume Hurtado</p>
    <div class="footer-links">
      <a href="#">Contacte</a>
    </div>
  </footer>
</body>
</html>
