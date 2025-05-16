<?php require_once 'connexio.php';

$ID_Incidencia = $_GET['ID_Incidencia'] ?? null;
?>

<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actuacions de la Incidència</title>
    <link rel="stylesheet" href="css/style.css">
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
        <a class="flecha-atras" onclick="window.history.back()">
            <span class="material-icons">arrow_back</span>
        </a>
        <div class="formulario-lista">
            <div class="encabezado-lista">
                <h2>Actuacions de la incidència amb ID <?php echo htmlspecialchars($ID_Incidencia); ?></h2>
            </div>

            <div class="tabla-scrollable">
                <?php
                if (isset($_GET['ID_Incidencia'])) {
                    $ID_Incidencia = $_GET['ID_Incidencia'];

                    $sql = "SELECT ID_Actuacio, Data_Actuacio, Descripcio, Temps, ID_Tecnic
                            FROM Actuacions WHERE ID_Incidencia = ?";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([$ID_Incidencia]);

                    if ($stmt->rowCount() > 0) {
                        echo "<div class='llistat-actuacions'>";
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "
                                <div class='card-incidencia'>
                                    <span><ion-icon name='barcode'></ion-icon> ID de l'actuació: " . htmlspecialchars($row["ID_Actuacio"]) . "</span>
                                    <span class='data'><ion-icon name='calendar'></ion-icon> " . htmlspecialchars($row["Data_Actuacio"]) . "</span>
                                    <p class='descripcio'>" . htmlspecialchars($row["Descripcio"]) . "</p>
                                    <span class='temps'><ion-icon name='time'></ion-icon> Temps invertit: " . htmlspecialchars($row["Temps"]) . " min</span>
                                    <span class='tecnic'><ion-icon name='person'></ion-icon> Tècnic: " . ($row["ID_Tecnic"] ? htmlspecialchars($row["ID_Tecnic"]) : "No assignat") . "</span>
                                </div>
                            ";
                        }
                        echo "</div>";
                    } else {
                        echo "<p class='no-actuacions'>No hi ha actuacions per aquesta incidència.</p>";
                    }
                } else {
                    echo "<p class='error'>Error: No s'ha especificat una incidència.</p>";
                }
                ?>
            </div>
        </div>
    </section>

    <footer>
        <p>&copy; 2025 Gestió d'Incidències</p>
    </footer>

    <script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
</body>

</html>
