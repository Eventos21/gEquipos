<?php
if (
    isset($_SESSION["conticomtc"]) &&
    isset($_SESSION["typeuser"]) && $_SESSION["typeuser"] == 1 &&
    isset($_SESSION["cargo"])    && $_SESSION["cargo"]    == 1
) {
?>
<link  
  rel="stylesheet" 
  href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css"
/>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

<div class="main-content">
  <div class="page-content">
    <div class="container-fluid">

      <!-- Título -->
      <div class="row mb-4">
        <div class="col-12">
          <h2>Estadísticas de Jugador
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
              type="text" 
              class="form-control" 
              placeholder="Nombre, Apellido o Licencia…"
              autocomplete="off"
            />
            <!-- aquí guardamos el ID que nos devuelve el suggest -->
            <input 
              type="hidden" 
              id="buscar-id" 
              name="id_jugador" 
            />
            <button type="submit" class="btn btn-primary ms-2">
              Buscar
            </button>
          </form>
        </div>
      </div>

      <!-- Alertas -->
      <div class="row"><div class="col-12">
        <div id="alert-box"></div>
      </div></div>

      <!-- Resumen de porcentajes -->
      <div class="row mb-4"><div class="col-md-6">
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
      </div></div>

      <!-- Tabla de rivales y resultados -->
      <div class="row"><div class="col-12">
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
              <tbody id="resultado-body"></tbody>
            </table>
          </div>
        </div>
      </div></div>

    </div>
  </div>
</div>

<script>
$(function(){
  // 1) Inicializa el autocomplete
  $('#buscar-criterio').autocomplete({
    source(request, response) {
      $.getJSON('index.php?action=apijugadoressuggest-action', {
        term: request.term
      }, response);
    },
    minLength: 2,
    focus(event, ui) {
      event.preventDefault();
      $('#buscar-criterio').val(ui.item.label);
    },
    select(event, ui) {
      event.preventDefault();
      $('#buscar-criterio').val(ui.item.label);
      $('#buscar-id').val(ui.item.value);
    }
  });
});

document.addEventListener('DOMContentLoaded', function() {
  const form     = document.getElementById('form-buscar');
  const input    = document.getElementById('buscar-criterio');
  const hiddenId = document.getElementById('buscar-id');
  const alertBox = document.getElementById('alert-box');
  const nombre   = document.getElementById('jugador-nombre');
  const pctT     = document.getElementById('pct-total');
  const pctB     = document.getElementById('pct-blancas');
  const pctN     = document.getElementById('pct-negras');
  const tbody    = document.getElementById('resultado-body');

  function showAlert(type, msg) {
    alertBox.innerHTML = 
      `<div class="alert alert-${type} mt-3" role="alert">
         ${msg}
       </div>`;
  }

  form.addEventListener('submit', function(e) {
    e.preventDefault();
    alertBox.innerHTML = '';
    tbody.innerHTML    = '';
    nombre.textContent = '';
    pctT.textContent   = '0%';
    pctB.textContent   = '0%';
    pctN.textContent   = '0%';

    const term = input.value.trim();
    const id   = hiddenId.value;
    if (!term) {
      showAlert('warning','Introduce un criterio');
      return;
    }

    const body = id 
      ? `id_jugador=${encodeURIComponent(id)}`
      : `criterio=${encodeURIComponent(term)}`;

    fetch('index.php?action=apiestadisticasjugador', {
      method: 'POST',
      headers: { 'Content-Type':'application/x-www-form-urlencoded' },
      body
    })
    .then(r => r.json())
    .then(json => {
      if (!json.success) {
        showAlert('warning', json.message);
        return;
      }
      nombre.textContent = json.jugador;
      pctT.textContent   = json.total   + '%';
      pctB.textContent   = json.blancas + '%';
      pctN.textContent   = json.negras  + '%';

      // filtrar y ordenar
      const list = json.rivales
        .filter(r=> r.rival_id && r.rival_nombre.trim())
        .sort((a,b)=>{
          const [da,ma,ya]=a.fecha.split('-').map(Number);
          const [db,mb,yb]=b.fecha.split('-').map(Number);
          return new Date(yb,mb-1,db) - new Date(ya,ma-1,da);
        });

      // pintar
      list.forEach(r=>{
        const tr = document.createElement('tr');
        tr.innerHTML=`
          <td>${r.fecha}</td>
          <td>${r.rival_nombre}</td>
          <td>${r.rival_team}</td>
          <td>${r.rival_elo}</td>
          <td>${r.resultado}</td>
          <td>${r.color}</td>
        `;
        tbody.appendChild(tr);
      });
    })
    .catch(()=> showAlert('danger','Error de red'));
  });
});
</script>
<?php
} else {
  header("Location: ./");
  exit();
}
?>
