<?php
require "connexio.php";


$ID_Incidencia = $_POST["ID_Incidencia"] ?? ($_GET["ID_Incidencia"] ?? null);
$ID_Incidencia = intval($ID_Incidencia);
$dataActuacio = date("Y-m-d H:i:s");

$query = "SELECT * FROM Incidencies WHERE ID_Incidencia = :ID_Incidencia";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":ID_Incidencia", $ID_Incidencia, PDO::PARAM_INT);
$stmt->execute();
$incidencia = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$incidencia) {
    echo "<p>Error: La incidència no existeix.</p>";
    exit;
}

if ($incidencia["Resolta"] == 3) {
    echo "<p>Aquesta incidència està tancada i no es poden afegir actuacions.</p>";
    exit;
}

$actuacio = null;


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["Descripcio"], $_POST["Temps"], $_POST["ID_Tecnic"])) {
    $Descripcio = $_POST["Descripcio"];
    $Temps = $_POST["Temps"];
    $ID_Tecnic = $_POST["ID_Tecnic"];

if ($Temps < 1) {
    header("Location: errorTemps.php");
    exit;
}


    if ($actuacio) {
        $query = "UPDATE Actuacions SET Descripcio = :Descripcio, Temps = :Temps, ID_Tecnic = :ID_Tecnic WHERE ID_Actuacio = :ID_Actuacio";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":Descripcio", $Descripcio, PDO::PARAM_STR);
        $stmt->bindParam(":Temps", $Temps, PDO::PARAM_INT);
        $stmt->bindParam(":ID_Tecnic", $ID_Tecnic, PDO::PARAM_INT);
        $stmt->bindParam(":ID_Actuacio", $actuacio['ID_Actuacio'], PDO::PARAM_INT);
    } else {
        $query = "INSERT INTO Actuacions (ID_Incidencia, Data_Actuacio, Descripcio, Temps, ID_Tecnic, VisibleUsuari)
                  VALUES (:ID_Incidencia, NOW(), :Descripcio, :Temps, :ID_Tecnic, 1)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":ID_Incidencia", $ID_Incidencia, PDO::PARAM_INT);
        $stmt->bindParam(":Descripcio", $Descripcio, PDO::PARAM_STR);
        $stmt->bindParam(":Temps", $Temps, PDO::PARAM_INT);
        $stmt->bindParam(":ID_Tecnic", $ID_Tecnic, PDO::PARAM_INT);
    }

    if ($stmt->execute()) {
        header("Location: actuacioAfegida.php");
        exit;
    } else {
        echo "<p>Error al afegir o actualitzar l'actuació.</p>";
    }

    if ($Temps < 1) {
        header("Location: actuacioAfegida.php");
                exit;
    }
}
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
    <h1 class="titulo-sitio">Afegir actuació</h1>
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
        <div class="formulario-editar">
            <h3>Afegir actuació a la incidència</h3><br>

            <form action="afegirActuacio.php" method="POST">
                <p><strong>Id de la incidència: </strong><input type="text" name="ID_Incidencia" value="<?= $incidencia["ID_Incidencia"] ?>" readonly></p>
                <p><strong>Data de l'actuació: </strong><?= htmlspecialchars($dataActuacio) ?></p>

            <label><strong>Descripció de l'actuació:</strong></label>
            <input type="text" name="Descripcio" required><br>

            <label><strong>Temps dedicat (min):</strong></label>
            <input type="number" name="Temps" required><br>

            <label><strong>Tècnic assignat:</strong></label>
            <input type="number" name="ID_Tecnic" required><br>

            <a href="./actuacioAfegida.php">
            <button class="boton" type="submit">Guardar actuació</button>
            </a>
    </form>
</section>
</body>
<footer>
    <p>&copy; 2025 Daniel Robles & Jaume Hurtado</p>
</footer>
</html>
