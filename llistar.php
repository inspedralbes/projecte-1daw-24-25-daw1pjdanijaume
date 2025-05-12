<?php require_once 'connexio.php'; ?>

<!DOCTYPE html>
<html lang="ca">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Llistat</title>
  <link rel="stylesheet" href="css/style.css" />
</head>

<body>
  <header>
    <a href="https://www.institutpedralbes.cat/">
      <img src="../img/logo.png" alt="Ins Pedralbes" />
    </a>
    <h1 class="titulo-sitio">Gestió d'Incidències</h1>
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
    <div class="formulario-lista">
      <div class="encabezado-lista">
        <h2>Llista d'incidències</h2>
        <button id="btn-filtrar">FILTRAR</button>
      </div>

      <div class="tabla-scrollable">
        <?php
        // Processar filtres
        $ordre = $_GET['ordre'] ?? 'ASC';
        $ordenarPer = $_GET['ordenar_per'] ?? 'ID_incidencia';
        $departaments = $_GET['departaments'] ?? [];
        $prioritats = $_GET['prioritats'] ?? [];

        $columnesValides = ['ID_incidencia', 'Departament', 'Prioritat', 'Data_Inici'];
        if (!in_array($ordenarPer, $columnesValides)) {
          $ordenarPer = 'ID_incidencia';
        }
        $ordre = strtoupper($ordre) === 'DESC' ? 'DESC' : 'ASC';

        $where = [];
        $params = [];

        if (!empty($departaments) && !in_array('Todo', $departaments)) {
          $placeholders = implode(',', array_fill(0, count($departaments), '?'));
          $where[] = "Departament IN ($placeholders)";
          $params = array_merge($params, $departaments);
        }

        if (!empty($prioritats) && !in_array('Todo', $prioritats)) {
          $placeholders = implode(',', array_fill(0, count($prioritats), '?'));
          $where[] = "Prioritat IN ($placeholders)";
          $params = array_merge($params, $prioritats);
        }

        $sql = "SELECT ID_incidencia, Departament, Prioritat, Descripcio,
                DATE_FORMAT(Data_Inici, '%d/%m/%Y') AS Data,
                DATE_FORMAT(Data_Inici, '%H:%i') AS Hora
                FROM Incidencies";

        if (!empty($where)) {
          $sql .= " WHERE " . implode(" AND ", $where);
        }

        $sql .= " ORDER BY $ordenarPer $ordre";

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        if ($stmt->rowCount() > 0) {
          echo "<table><tr><th>ID</th><th>Departament</th><th>Prioritat</th><th>Descripció</th><th>Data</th><th>Hora</th><th></th></tr>";
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr><td>{$row["ID_incidencia"]}</td>
                    <td>" . htmlspecialchars($row["Departament"]) . "</td>
                    <td>" . htmlspecialchars($row["Prioritat"]) . "</td>
                    <td>" . htmlspecialchars($row["Descripcio"]) . "</td>
                    <td>{$row["Data"]}</td>
                    <td>{$row["Hora"]}</td>
                    <td>
                      <form action='esborrar.php' method='post' style='display:inline;'>
                        <input type='hidden' name='IncidenciaID' value='{$row["ID_incidencia"]}' />
                        <button class='boton' type='submit' onclick='return confirm(\"Estàs segur que vols eliminar aquesta incidència?\")'>Eliminar</button>
                      </form>
                    </td></tr>";
          }
          echo "</table>";
        } else {
          echo "<br><p>No hi ha dades a mostrar.</p><br>";
        }
        ?>
      </div>
    </div>
  </section>

  <form id="panel-filtros" method="GET">
    <div class="tabla-scrollable">
      <div class="panel-titulo">Ordre</div>
      <div class="panel-opcion">
        <label><input type="radio" name="ordre" value="ASC" checked> Ascendent</label>
      </div>
      <div class="panel-opcion">
        <label><input type="radio" name="ordre" value="DESC"> Descendent</label>
      </div>

      <div class="panel-titulo">Ordenar per</div>
      <div class="panel-opcion">
        <select name="ordenar_per">
          <option value="ID_incidencia">ID</option>
          <option value="Departament">Departament</option>
          <option value="Prioritat">Prioritat</option>
          <option value="Data_Inici">Data d'inici</option>
        </select>
      </div>

      <div class="panel-titulo">Departament</div>
      <div class="panel-opcion"><label><input type="checkbox" name="departaments[]" value="Todo" checked> Tot</label></div>
      <?php
      $departaments = ["Contabilitat", "Administració", "Producció", "Manteniment", "Informàtica", "Suport tècnic", "Marketing", "Atenció al client"];
      foreach ($departaments as $d) {
        echo "<div class='panel-opcion'><label><input type='checkbox' name='departaments[]' value=\"$d\"> $d</label></div>";
      }
      ?>

      <div class="panel-titulo">Prioritat</div>
      <div class="panel-opcion"><label><input type="checkbox" name="prioritats[]" value="Todo" checked> Tot</label></div>
      <div class="panel-opcion"><label><input type="checkbox" name="prioritats[]" value="No assignada"> No assignada</label></div>
      <div class="panel-opcion"><label><input type="checkbox" name="prioritats[]" value="Baixa"> Baixa</label></div>
      <div class="panel-opcion"><label><input type="checkbox" name="prioritats[]" value="Mitjana"> Mitjana</label></div>
      <div class="panel-opcion"><label><input type="checkbox" name="prioritats[]" value="Alta"> Alta</label></div>
    </div>
    <button class="boton" id="btn-aplicar" type="submit">Actualitzar</button>
  </form>

  <footer>
    <p>&copy; 2025 Daniel Robles & Jaume Hurtado</p>
  </footer>

  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const btnFiltrar = document.getElementById("btn-filtrar");
      const panelFiltros = document.getElementById("panel-filtros");

      btnFiltrar.addEventListener("click", (e) => {
        e.stopPropagation();
        panelFiltros.classList.toggle("visible");
        document.body.classList.toggle("panel-aberto");
      });

      document.addEventListener("click", (e) => {
        if (panelFiltros.classList.contains("visible") &&
          !panelFiltros.contains(e.target) &&
          e.target !== btnFiltrar) {
          panelFiltros.classList.remove("visible");
          document.body.classList.remove("panel-aberto");
        }
      });

      const toggleGrupo = (grupoSelector) => {
        const checkboxes = document.querySelectorAll(grupoSelector);
        checkboxes.forEach(checkbox => {
          checkbox.addEventListener("change", () => {
            if (checkbox.value === "Todo" && checkbox.checked) {
              checkboxes.forEach(cb => {
                if (cb !== checkbox) cb.checked = false;
              });
            } else if (checkbox.value !== "Todo" && checkbox.checked) {
              checkboxes.forEach(cb => {
                if (cb.value === "Todo") cb.checked = false;
              });
            }
          });
        });
      };

      toggleGrupo("input[name='departaments[]']");
      toggleGrupo("input[name='prioritats[]']");
    });
  </script>
</body>

</html>