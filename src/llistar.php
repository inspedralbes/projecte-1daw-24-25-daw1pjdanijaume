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
        $sql = "SELECT ID_incidencia, Departament, Descripcio,
            DATE_FORMAT(Data_Inici, '%d/%m/%Y') AS Data,
            DATE_FORMAT(Data_Inici, '%H:%i') AS Hora
            FROM Incidencies";
        $stmt = $pdo->query($sql);

        if ($stmt->rowCount() > 0) {
          echo "<table><tr><th>ID</th><th>Departament</th><th>Descripció</th><th>Data</th><th>Hora</th><th></th></tr>";
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr><td>" . $row["ID_incidencia"] . "</td>
              <td>" . htmlspecialchars($row["Departament"]) . "</td>
              <td>" . htmlspecialchars($row["Descripcio"]) . "</td>
              <td>" . $row["Data"] . "</td>
              <td>" . $row["Hora"] . "</td>";
            echo "<td><form action='esborrar.php' method='post' style='display:inline;'>
              <input type='hidden' name='IncidenciaID' value='" . $row["ID_incidencia"] . "' />
              <button class='boton' type='submit' onclick='return confirm(\"Estàs segur que vols eliminar aquesta incidència?\")'>Eliminar</button>
              </form></td></tr>";
          }
          echo "</table>";
        } else {
          echo "<br><p>No hi ha dades a mostrar.</p><br>";
        }
        ?>
      </div>
    </div>
  </section>

  <div id="panel-filtros">
    <div class="tabla-scrollable">
      <div class="panel-titulo">Ordre</div>
      <div class="panel-opcion">
        <label><input type="radio" name="ordre" value="ascendent" checked> Ascendent</label>
      </div>
      <div class="panel-opcion">
        <label><input type="radio" name="ordre" value="descendent"> Descendent</label>
      </div>
  
      <div class="panel-titulo">Departament</div>
      <div class="panel-opcion"><label><input type="checkbox" class="filtro-dep" value="Tot" checked> Tot</label></div>
      <div class="panel-opcion"><label><input type="checkbox" class="filtro-dep" value="Contabilitat"> Contabilitat</label></div>
      <div class="panel-opcion"><label><input type="checkbox" class="filtro-dep" value="Administració"> Administració</label></div>
      <div class="panel-opcion"><label><input type="checkbox" class="filtro-dep" value="Producció"> Producció</label></div>
      <div class="panel-opcion"><label><input type="checkbox" class="filtro-dep" value="Manteniment"> Manteniment</label></div>
      <div class="panel-opcion"><label><input type="checkbox" class="filtro-dep" value="Informàtica"> Informàtica</label></div>
      <div class="panel-opcion"><label><input type="checkbox" class="filtro-dep" value="Suport tècnic"> Suport tècnic</label></div>
      <div class="panel-opcion"><label><input type="checkbox" class="filtro-dep" value="Marketing"> Marketing</label></div>
      <div class="panel-opcion"><label><input type="checkbox" class="filtro-dep" value="Atenció al client"> Atenció al client</label></div>
  
      <div class="panel-titulo">Prioritat</div>
      <div class="panel-opcion"><label><input type="checkbox" class="filtro-pri" value="Tot" checked> Tot</label></div>
      <div class="panel-opcion"><label><input type="checkbox" class="filtro-pri" value="No assignada"> No assignada</label></div>
      <div class="panel-opcion"><label><input type="checkbox" class="filtro-pri" value="Baixa"> Baixa</label></div>
      <div class="panel-opcion"><label><input type="checkbox" class="filtro-pri" value="Mitjana"> Mitjana</label></div>
      <div class="panel-opcion"><label><input type="checkbox" class="filtro-pri" value="Alta"> Alta</label></div>
    </div>

    <button class="boton"  id="btn-aplicar">Actualitzar</button>
  </div>

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
          document.body.classList.remove("panel-abierto");
        }
      });

      // Lógica Todo / otros en filtros de departamento
      const checkboxes = document.querySelectorAll(".filtro-dep");
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
      // Lógica Todo / otros en filtros de prioridad
      const checkboxes2 = document.querySelectorAll(".filtro-pri");
      checkboxes2.forEach(checkbox => {
        checkbox.addEventListener("change", () => {
          if (checkbox.value === "Todo" && checkbox.checked) {
            checkboxes2.forEach(cb => {
              if (cb !== checkbox) cb.checked = false;
            });
          } else if (checkbox.value !== "Todo" && checkbox.checked) {
            checkboxes2.forEach(cb => {
              if (cb.value === "Todo") cb.checked = false;
            });
          }
        });
      });
    });
  </script>
</body>

</html>