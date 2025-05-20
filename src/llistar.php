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
          <img src="../img/logo.png" alt="Ins Pedralbes">
        </a>
        <h1 class="titulo-sitio">Gestió d'Incidències</h1>
      </header>

      <section class="seccion-central">
        <a href="../admin.html" class="flecha-atras">
          <span class="material-icons">arrow_back</span>
        </a>
        <div class="formulario-lista">
          <div class="encabezado-lista">
            <h2>Llista d'incidències</h2>
            <button id="btn-filtrar">FILTRAR</button>
          </div>

          <div class="tabla-scrollable">
            <?php
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

            $estats = $_GET['estats'] ?? [];

    if (!empty($estats) && !in_array('Todo', $estats)) {
      $valorsResolta = [];
      foreach ($estats as $estat) {
        switch ($estat) {
          case 'No assignada':
            $valorsResolta[] = 0;
            break;
          case 'Pendent':
            $valorsResolta[] = 1;
            break;
          case 'Resolt':
            $valorsResolta[] = 2;
            break;
          case 'Tancat':
            $valorsResolta[] = 3;
            break;
        }
      }

      if (!empty($valorsResolta)) {
        $placeholders = implode(',', array_fill(0, count($valorsResolta), '?'));
        $where[] = "Resolta IN ($placeholders)";
        $params = array_merge($params, $valorsResolta);
      }
    }

            $sql = "SELECT ID_incidencia, Departament, Prioritat, Descripcio, ID_Tecnic, Resolta,
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
              echo "<div class='llistat-incidencies'>";
              while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $estat = 'No assignada';
                if ($row["Resolta"] == 1) {
                    $estat = 'Pendent';
                } elseif ($row["Resolta"] == 2) {
                    $estat = 'Resolt';
                }
                 elseif ($row["Resolta"] == 3) {
                    $estat = 'Tancat';
                }

                $prioritatClass = strtolower($row["Prioritat"]);
                echo "
                  <div class='card-incidencia $prioritatClass'>
                    <div class='info-principal'>
                      <span class='id'>{$row["ID_incidencia"]}</span>
                      <span class='departament'>" . htmlspecialchars($row["Departament"]) . "</span>
                      <span class='realitzada " . strtolower($estat)."'>" . $estat . "</span>
                    </div>
                    <p class='descripcio'>" . htmlspecialchars($row["Descripcio"]) . "</p>
                    <div class='info-extra'>
      <span class='data'>
        <ion-icon name='business'></ion-icon>
        {$row["Departament"]}
      </span>
      <span class='hora'>
        <ion-icon name='person'></ion-icon>
        " . ($row["ID_Tecnic"] === null ? "No assignat" : $row["ID_Tecnic"]) . "
      </span>
      <span class='data'>
        <ion-icon name='calendar'></ion-icon>
        {$row["Data"]}
      </span>
      <span class='hora'>
        <ion-icon name='time'></ion-icon>
        {$row["Hora"]}
      </span>
      <span class='prioritat " . strtolower($row["Prioritat"]) . "'>
        <ion-icon name='alert'></ion-icon>
        " . htmlspecialchars($row["Prioritat"]) . "
      </span>
    </div>

                    <div class='form-eliminar'>
                      <form action='editar.php' method='post'>
                        <input type='hidden' name='IncidenciaID' value='{$row["ID_incidencia"]}' />
                        <button class='botones editar' type='submit' onclick='return confirm(\"Estàs segur que vols editar aquesta incidència?\")'>Editar</button>
                      </form>
                      <form action='esborrar.php' method='post'>
                        <input type='hidden' name='IncidenciaID' value='{$row["ID_incidencia"]}' />
                        <button class='botones eliminar' type='submit' onclick='return confirm(\"Estàs segur que vols eliminar aquesta incidència?\")'>Eliminar</button>
                      </form>
                    </div>
                    </div>
                ";
              }
              echo "</div>";
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

            <div class="panel-opcion">
              <label><input type="radio" name="ordre" value="ASC" checked> Ascendent</label>
            </div>
            <div class="panel-opcion">
              <label><input type="radio" name="ordre" value="DESC"> Descendent</label>
            </div>
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
          <div class="panel-opcion">
          <div class="panel-opcion"><label><input type="checkbox" name="departaments[]" value="Todo" checked> Tot</label></div>
          <?php
          $departaments = ["Contabilitat", "Administració", "Producció", "Manteniment", "Informàtica", "Suport tècnic", "Marketing", "Atenció al client"];
          foreach ($departaments as $d) {
            echo "<div class='panel-opcion'><label><input type='checkbox' name='departaments[]' value=\"$d\"> $d</label></div>";
          }
          ?>
          </div>

          <div class="panel-titulo">Prioritat</div>
          <div class="panel-opcion">
            <div class="panel-opcion"><label><input type="checkbox" name="prioritats[]" value="Todo" checked> Tot</label></div>
            <div class="panel-opcion"><label><input type="checkbox" name="prioritats[]" value="No assignada"> No assignada</label></div>
            <div class="panel-opcion"><label><input type="checkbox" name="prioritats[]" value="Baixa"> Baixa</label></div>
            <div class="panel-opcion"><label><input type="checkbox" name="prioritats[]" value="Mitja"> Mitja</label></div>
            <div class="panel-opcion"><label><input type="checkbox" name="prioritats[]" value="Alta"> Alta</label></div>
          </div>

          <div class="panel-titulo">Estat</div>
          <div class="panel-opcion">
            <div class="panel-opcion"><label><input type="checkbox" name="estats[]" value="Todo" checked> Tot</label></div>
            <div class="panel-opcion"><label><input type="checkbox" name="estats[]" value="No assignada"> No assignada</label></div>
            <div class="panel-opcion"><label><input type="checkbox" name="estats[]" value="Pendent"> Pendent</label></div>
            <div class="panel-opcion"><label><input type="checkbox" name="estats[]" value="Resolt"> Resolt</label></div>
            <div class="panel-opcion"><label><input type="checkbox" name="estats[]" value="Tancat"> Tancat</label></div>
          </div>
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
          // Colapsar secciones por defecto
    const ocultarOpciones = () => {
      const panel = document.getElementById("panel-filtros");
      const titulos = panel.querySelectorAll(".panel-titulo");
      titulos.forEach(titulo => {
        let siguiente = titulo.nextElementSibling;
        while (siguiente && !siguiente.classList.contains("panel-titulo")) {
          siguiente.classList.add("oculto");
          siguiente = siguiente.nextElementSibling;
        }
      });
    };

    // Permitir alternar secciones al hacer clic
    const hacerPlegables = () => {
      const titulos = document.querySelectorAll(".panel-titulo");
      titulos.forEach(titulo => {
        titulo.addEventListener("click", () => {
          let siguiente = titulo.nextElementSibling;
          while (siguiente && !siguiente.classList.contains("panel-titulo")) {
            siguiente.classList.toggle("oculto");
            siguiente = siguiente.nextElementSibling;
          }
        });
      });
    };

    // Activar ambos comportamientos
    ocultarOpciones();
    hacerPlegables();



          btnFiltrar.addEventListener("click", (e) => {
            e.stopPropagation();
            panelFiltros.classList.toggle("visible");
            document.body.classList.toggle("panel-abierto");
          });

          document.addEventListener("click", (e) => {
            if (panelFiltros.classList.contains("visible") &&
              !panelFiltros.contains(e.target) &&
              e.target !== btnFiltrar) {
              panelFiltros.classList.remove("visible");
              document.body.classList.remove("panel-abierto");
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
          toggleGrupo("input[name='estats[]']");

        });
      </script>
      <script src="https://unpkg.com/ionicons@4.5.10-0/dist/ionicons.js"></script>
    </body>

    </html>
