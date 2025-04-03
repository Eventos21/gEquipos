<div class="main-content"> 
    <div class="page-content">
        <div class="container-fluid"> 
            <div class="row">
                <!-- FullCalendar CSS y JS -->
                <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
                <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

                <!-- Estilos personalizados -->
                <style>
                    /* Estilos del calendario */
                    #calendar {
                        max-width: 1000px;
                        margin: 5px auto;
                        padding: 20px;
                        background-color: #ffffff;
                        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                        border-radius: 10px;
                    }

                    .fc-toolbar {
                        background-color: #007bff;
                        color: white;
                        border-radius: 8px 8px 0 0;
                        padding: 10px;
                    }

                    .fc-toolbar h2 {
                        font-size: 1.5rem;
                    }

                    .fc-button {
                        background-color: #0056b3;
                        border: none;
                        color: white;
                        transition: background-color 0.3s ease;
                    }

                    .fc-button:hover {
                        background-color: #003f7f;
                    }

                    .fc-button-primary:not(:disabled).fc-button-active {
                        background-color: #003f7f;
                        border-color: #003f7f;
                    }

                    .fc-daygrid-day {
                        border: 1px solid #dee2e6;
                    }

                    .fc-daygrid-day-number {
                        color: #007bff;
                        font-weight: bold;
                    }

                    /* Estilos del modal */
                    .modal-content {
                        border-radius: 8px;
                        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
                    }

                    .modal-header {
                        background-color: #007bff;
                        border-bottom: 2px solid #0056b3;
                        border-top-left-radius: 8px;
                        border-top-right-radius: 8px;
                        padding: 15px;
                    }

                    .modal-title {
                        font-size: 1.25rem;
                        font-weight: bold;
                    }

                    .modal-body {
                        padding: 20px;
                        background-color: #f8f9fa;
                    }

                    .table-bordered {
                        border: 1px solid #dee2e6;
                        background-color: white;
                    }

                    .table-bordered th {
                        background-color: #f1f1f1;
                        font-weight: bold;
                        text-align: center;
                    }

                    .table-bordered td {
                        text-align: center;
                        vertical-align: middle;
                    }

                    .table-bordered td a {
                        color: #007bff;
                        text-decoration: none;
                    }

                    .table-bordered td a:hover {
                        text-decoration: underline;
                    }

                    .modal-footer {
                        padding: 10px 20px;
                        border-top: 1px solid #dee2e6;
                    }

                    .btn-outline-light {
                        border: 1px solid #ffffff;
                        color: #ffffff;
                        transition: background-color 0.3s ease, color 0.3s ease;
                    }

                    .btn-outline-light:hover {
                        background-color: #ffffff;
                        color: #007bff;
                    }
                    
                </style>

                <!-- Calendario -->
                <div id="calendar"></div>

                <!-- Script para inicializar el calendario -->
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        var calendarEl = document.getElementById('calendar');
                        var calendar = new FullCalendar.Calendar(calendarEl, {
                            initialView: 'dayGridMonth',
                            locale: 'es',
                            headerToolbar: {
                                left: 'prev,next today',
                                center: 'title',
                                right: 'dayGridMonth,timeGridWeek,timeGridDay'
                            },
                            buttonText: {
                                today: 'Hoy',
                                month: 'Mes',
                                week: 'Semana',
                                day: 'Día'
                            },
                            events: function(fetchInfo, successCallback, failureCallback) {
                                $.ajax({
                                    url: 'index.php?action=apicalendarioseventos',
                                    method: 'GET',
                                    success: function(data) {
                                        var events = JSON.parse(data);
                                        successCallback(events);
                                    },
                                    error: function() {
                                        failureCallback([]);
                                    }
                                });
                            },
                            eventClick: function(info) {
                                var fecha = info.event.startStr;

                                $.ajax({
                                    url: 'index.php?action=apilistareventos',
                                    method: 'GET',
                                    data: { fecha: fecha },
                                    success: function(response) {
                                        $('#detailsTableBody').empty();

                                        $.each(response.data, function(groupName, events) {
                                        $.each(events, function(index, event) {
                                            var row = `<tr>
                                                <td>${index + 1}</td>
                                                <td>${event.equipoa} vs ${event.equipob}</td>
                                                <td>${event.resultado_a} - ${event.resultado_b}</td>
                                                <td>${event.usuarios}</td>
                                                <td>${event.aprobacion}</td>`;
                                            
                                            // Agregar la celda de acuerdo al valor de 'adicional'
                                            if (event.adicional == 1) {
                                                row += `<td>
                                                            <form action="actasi" method="post">
                                                                <input style="font-size: 9px" type="hidden" class="form-control" name="tid" value="${event.id}">
                                                                <button class="btn btn-light btn-sm" type="submit">Acta</button>
                                                            </form>
                                                        </td>`;
                                            } else if (event.adicional == 2) {
                                                row += `<td>
                                                            <form action="actai" method="post">
                                                                <input style="font-size: 9px" type="hidden" class="form-control" name="competiciones" value="${event.id}">
                                                                <input style="font-size: 9px" type="hidden" class="form-control" name="equipo_a" value="${event.equipo_a}">
                                                                <input style="font-size: 9px" type="hidden" class="form-control" name="equipo_b" value="${event.equipo_b}">
                                                                <button class="btn btn-light btn-sm" type="submit">Acta</button>
                                                            </form>
                                                        </td>`;
                                            }

                                            row += `</tr>`;
                                            $('#detailsTableBody').append(row);
                                        });
                                    });


                                        $('#ModalJornada').modal('show');
                                    },
                                    error: function() {
                                        alert('No se pudieron cargar los detalles del evento.');
                                    }
                                });
                            }
                        });

                        calendar.render();
                    });
                </script>
            </div>            
        </div>
    </div> 
</div>

<!-- Modal para mostrar los detalles de la jornada -->
<div class="modal fade" id="ModalJornada" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content border-5">
      <div class="modal-header bg-info">
        <h5 class="modal-title text-white" id="exampleModalLabel">Jornadas</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table class="table table-bordered border-primary">
            <thead>
              <tr>
                <th scope="col">Nro</th>
                <th scope="col">Encuentro</th>
                <th scope="col">Resultado</th>
                <th scope="col">Usuario</th>
                <th scope="col">Aprobacion</th>
                <th scope="col">Actas</th>
              </tr>
            </thead>
            <tbody id="detailsTableBody"></tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>