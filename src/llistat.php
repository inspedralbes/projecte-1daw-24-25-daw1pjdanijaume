<!DOCTYPE html>
<html lang="ca">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Llistat</title>
</head>

<body>
    <h1>Llistat d'incidencies</h1>
    <?php

    $servername = "localhost";
    $username = "a24danrobmar_projecte";
    $password = "^IkT-?4(D9NvLxEh";
    $dbname = "a24danrobmar_projecte";

    try {
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("No s'ha pogut connectar a la base de dades pel següent error: " . $e->getMessage());
    }


    $sql = "SELECT ID_incidencia, Descripcio FROM incidencies";
$stmt = $pdo->query($sql);

if ($stmt->rowCount() > 0) {
    echo "<ul>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<li>ID: " . $row["ID_incidencia"] . " - Descripcio: " . htmlspecialchars($row["Descripcio"]) . "</li>";
    }
    echo "</ul>";
} else {
    echo "<p>No hi ha dades a mostrar.</p>";
}

    ?>
    <p>Vols tornar a la <a href="index.php">pàgina inicial</a>? </p>
</body>

</html>