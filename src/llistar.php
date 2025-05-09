<?php require_once 'connexio.php'; ?>

<!DOCTYPE html>
<html lang="ca">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Llistat</title>
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
    <div class="formulario-lista">
      <div class="encabezado-lista">
        <h2>Llista d'incidències</h2>
        <button id="btn-filtrar">FILTRAR</button>
      </div>

      <div class="tabla-scrollable">
        <?php
        // Captura de filtros
        $ordre = $_GET['ordre'] ?? 'ascendent';
        $departaments = $_GET['departament'] ?? ['Tot'];
        $prioritats = $_GET['prioritat'] ?? ['Tot'];

        $where = [];
        $params = [];

        if (!in_array("Tot", $departaments)) {
            $placeholders = implode(',', array_fill(0, count($departaments), '?'));
            $where[] = "Departament IN ($placeholders)";
            $params = array_merge($params, $departaments);
        }

        if (!in_array("Tot", $prioritats)) {
            $placeholders = implode(',', array_fill(0, count($prioritats), '?'));
            $where[] = "Prioritat IN ($placeholders)";
            $params = array_merge($params, $prioritats);
        }

        $sql = "SELECT ID_incidencia, Departament, Descripcio, Prioritat,
                DATE_FORMAT(Data_Inici, '%d/%m/%Y') AS Data,
                DATE_FORMAT(Data_Inici, '%H:%i') AS Hora
                FROM Incidencies";

        if ($where) {
            $sql .= " WHERE " . implode(" AND ", $where);
        }

        $sql .= ($ordre === 'descendent') ? " ORDER BY Data_Inici DESC" : " ORDER BY Data_Inici ASC";

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        if ($stmt->rowCount() > 0) {
          echo "<table><tr><th>ID</th><th>Departament</th><th>Descripció</th><th>Prioritat</th><th>Data</th><th>Hora</th><th></th></tr>";
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr><td>{$row['ID_incidencia']}</td>
                      <td>{$row['Departament']}</td>
                      <td>{$row['Descripcio']}</td>
                      <td>{$row['Prioritat']}</td>
                      <td>{$row['Data']}</td>
                      <td>{$row['Hora']}</td>
                      <td>
                        <form action='esborrar.php' method='post'>
                          <input type='hidden' name='IncidenciaID' value='{$row['ID_incidencia']}' />
                          <button class='boton' type='submit' onclick='return confirm(\"Segur que vols eliminar?\")'>Eliminar</button>
                        </form>
                      </td></tr>";
          }
          echo "</table>";
        } else {
          echo "<p>No hi ha dades que coincideixin amb el filtre.</p>";
        }
        ?>
      </div>
    </div>
  </section>

  <!-- Panel de filtros -->
  <form id="panel-filtros" method="GET">
    <div class="tabla-scrollable">
      <div class="panel-titulo">Ordre</div>
      <div class="panel-opcion"><label><input type="radio" name="ordre" value="ascendent" <?= ($ordre === 'ascendent') ? 'checked' : '' ?>> Ascendent</label></div>
      <div class="panel-opcion"><label><input type="radio" name="ordre" value="descendent" <?= ($ordre === 'descendent') ? 'checked' : '' ?>> Descendent</label></div>

      <div class="panel-titulo">Departament</div>
      <?php
      $dptes = ["Tot", "Contabilitat", "Administració", "Producció", "Manteniment", "Informàtica", "Suport tècnic", "Marketing", "Atenció al client"];
      foreach ($dptes as $d) {
        $checked = (in_array($d, $departaments)) ? 'checked' : '';
        echo "<div class='panel-opcion'><label><input type='checkbox' name='departament[]' value='$d' $checked> $d</label></div>";
      }
      ?>

      <div class="panel-titulo">Prioritat</div>
      <?php
      $prioritats = ["Tot", "No assignada", "Baixa", "Mitjana", "Alta"];
      foreach ($prioritats as $p) {
        $checked = (in_array($p, $_GET['prioritat'] ?? ['Tot'])) ? 'checked' : '';
        echo "<div class='panel-opcion'><label><input type='checkbox' name='prioritat[]' value='$p' $checked> $p</label></div>";
      }
      ?>
    </div>

    <button class="boton" id="btn-aplicar" type="submit">Actualitzar</button>
  </form>

  <script>
    // Función para desmarcar todos los filtros de un grupo excepto el seleccionado
    function deselectOthers(name, currentValue) {
      const allCheckboxes = document.querySelectorAll(`input[name='${name}']`);
      allCheckboxes.forEach(checkbox => {
        if (checkbox.value !== currentValue) {
          checkbox.checked = false;
        }
      });
    }

    // Lógica para desmarcar "Tot" cuando se selecciona otro filtro
    function handleDeselection(event, filterName) {
      if (event.target.value !== "Tot") {
        const allCheckboxes = document.querySelectorAll(`input[name='${filterName}[]']`);
        allCheckboxes.forEach(checkbox => {
          if (checkbox.value === "Tot") {
            checkbox.checked = false;
          }
        });
      }
    }

    // Lógica para desmarcar todos los filtros cuando se selecciona "Tot"
    function handleSelectAll(event, filterName) {
      if (event.target.value === "Tot") {
        const allCheckboxes = document.querySelectorAll(`input[name='${filterName}[]']`);
        allCheckboxes.forEach(checkbox => {
          if (checkbox.value !== "Tot") {
            checkbox.checked = false;
          }
        });
      }
    }

    // Aplicar la lógica de desmarcar filtros
    document.querySelectorAll("input[name='departament[]']").forEach(checkbox => {
      checkbox.addEventListener("change", function(event) {
        handleDeselection(event, 'departament');
        handleSelectAll(event, 'departament');
      });
    });

    document.querySelectorAll("input[name='prioritat[]']").forEach(checkbox => {
      checkbox.addEventListener("change", function(event) {
        handleDeselection(event, 'prioritat');
        handleSelectAll(event, 'prioritat');
      });
    });

    document.querySelectorAll("input[name='ordre']").forEach(radio => {
      radio.addEventListener("change", function(event) {
        deselectOthers('ordre', this.value);
      });
    });

    document.getElementById("btn-filtrar").addEventListener("click", () => {
      const panel = document.getElementById("panel-filtros");
      panel.classList.toggle("visible");
    });
  </script>
</body>
</html>