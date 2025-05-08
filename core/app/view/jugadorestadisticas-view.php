// jugadorestadisticas-view.php
<?php
// jugadorestadisticas-view.php

if (
    isset($_SESSION["conticomtc"]) &&
    isset($_SESSION["typeuser"]) && $_SESSION["typeuser"] == 1 &&
    isset($_SESSION["cargo"])    && $_SESSION["cargo"]    == 1
) {
?>
<div class="main-content">
  <div class="page-content">
    <div class="container-fluid">

      <!-- Título -->
      <div class="row mb-4">
        <div class="col-12">
          <h2>
            Estadísticas de Jugador
            <span id="jugador-nombre" class="text-primary"></span>
          </h2>
        </div>
      </div>

      <!-- Formulario de búsqueda -->
      <div class="row mb-4">
        <div class="col-12">
          <form id="form-buscar" class="d-flex">
            <input 
              id="buscar-criterio" 
              name="criterio"
              type="text" 
              class="form-control" 
              placeholder="Nombre, Apellido o Licencia…" 
              autocomplete="off"
            >
            <button type="submit" class="btn btn-primary ms-2">
              Buscar
            </button>
          </form>
        </div>
      </div>

      <!-- Alertas -->
      <div class="row">
        <div class="col-12">
          <div id="alert-box"></div>
        </div>
      </div>

      <!-- Resumen de porcentajes -->
      <div class="row mb-4">
        <div class="col-md-6">
          <div class="card shadow-sm">
            <div class="card-header bg-info text-white">
              Resumen de puntuación
            </div>
            <div class="card-body">
              <p>Porcentaje <strong>total</strong>: 
                <span id="pct-total">0%</span>
              </p>
              <p>Con <strong>blancas</strong>: 
                <span id="pct-blancas">0%</span>
              </p>
              <p>Con <strong>negras</strong>: 
                <span id="pct-negras">0%</span>
              </p>
            </div>
          </div>
        </div>
      </div>

      <!-- Tabla de rivales y resultados -->
      <div class="row">
        <div class="col-12">
          <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
              Rivales y resultados
            </div>
            <div class="card-body p-0">
              <table class="table mb-0">
                <thead class="table-light">
                  <tr>
                    <th>Fecha</th>
                    <th>Rival</th>
                    <th>Equipo del rival</th>
                    <th>ELO del rival</th>
                    <th>Resultado</th>
                    <th>Color</th>
                  </tr>
                </thead>
                <tbody id="resultado-body">
                  <!-- Se llenará vía JS -->
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  console.log('jugadorestadisticas-view: DOM listo');

  const form         = document.getElementById('form-buscar');
  const input        = document.getElementById('buscar-criterio');
  const alertBox     = document.getElementById('alert-box');
  const nombreSpan   = document.getElementById('jugador-nombre');
  const pctTotal     = document.getElementById('pct-total');
  const pctBlancas   = document.getElementById('pct-blancas');
  const pctNegras    = document.getElementById('pct-negras');
  const tbody        = document.getElementById('resultado-body');

  function showAlert(type, msg) {
    alertBox.innerHTML =
      `<div class="alert alert-${type} mt-3" role="alert">
         ${msg}
       </div>`;
  }

  form.addEventListener('submit', function(e) {
    e.preventDefault();
    alertBox.innerHTML   = '';
    tbody.innerHTML      = '';
    nombreSpan.textContent = '';
    pctTotal.textContent   = '0%';
    pctBlancas.textContent = '0%';
    pctNegras.textContent  = '0%';

    const crit = input.value.trim();
    if (!crit) {
      showAlert('warning', 'Por favor, introduce un criterio de búsqueda.');
      return;
    }
    console.log('Submit capturado, criterio:', crit);

    fetch('index.php?action=apiestadisticasjugador', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: `criterio=${encodeURIComponent(crit)}`
    })
    .then(res => res.json())
    .then(json => {
      console.log('AJAX success, respuesta:', json);

      // mostramos también las queries para depurar
      console.log('→ QUERY jugador :',   json.sql_jugador || '(no disponible)');
      console.log('→ QUERY partidas:', json.sql_partidas || '(no disponible)');

      if (!json.success) {
        showAlert('warning', json.message || 'Error al buscar jugador');
        return;
      }

      // Ponemos el nombre del jugador
      nombreSpan.textContent = json.jugador;

      // Actualiza el resumen
      pctTotal.textContent   = json.total   + '%';
      pctBlancas.textContent = json.blancas + '%';
      pctNegras.textContent  = json.negras  + '%';

      // Filtramos para quedarnos sólo con los que tienen rival
      const rivalesValidos = json.rivales.filter(r => 
        r.rival_id !== 0 && r.rival_id != null && r.rival_nombre.trim() !== ''
      );

      // Ordenar por fecha descendente
      json.rivales.sort((a, b) => {
        const [da, ma, ya] = a.fecha.split('-').map(Number);
        const [db, mb, yb] = b.fecha.split('-').map(Number);
        return new Date(yb, mb - 1, db) - new Date(ya, ma - 1, da);
      });

      // Rellena la tabla
      rivalesValidos.forEach(r => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
          <td>${r.fecha        || ''}</td>
          <td>${r.rival_nombre || ''}</td>
          <td>${r.rival_team   || ''}</td>
          <td>${r.rival_elo    || ''}</td>
          <td>${r.resultado    || ''}</td>
          <td>${r.color        || ''}</td>
        `;
        tbody.appendChild(tr);
      });
    })
    .catch(err => {
      console.error(err);
      showAlert('danger', 'Error de red al consultar las estadísticas.');
    });
  });
});
</script>
<?php
} else {
    header("Location: ./");
    exit();
}