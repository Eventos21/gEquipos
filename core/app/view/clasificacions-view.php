<style>
    /* Estilo para botones */
    .btn {
        font-size: 10px; /* Tamaño de la fuente para botones */
        padding: 5px 8px; /* Espaciado interno de botones */
    }

    /* Estilo para contenido de la tabla */
    #customerTable th,
    #customerTable td {
        font-size: 10px;
        padding-left: 8px; /* Espaciado interno izquierdo */
        padding-right: 5px; /* Espaciado interno derecho */
        padding-top: 5px; /* Espaciado interno superior */
        padding-bottom: 5px; /* Espaciado interno inferior */
    }
</style>
<?php if (isset($_SESSION["conticomtc"]) && isset($_SESSION["typeuser"]) && ($_SESSION["typeuser"] == 1 || $_SESSION["typeuser"] == 2)) { 
if ($_SESSION["typeuser"]==1) {
    $u = UserData::verid($_SESSION['conticomtc']);
}
if ($_SESSION["typeuser"]==2) {
    $u = JugadorData::verid($_SESSION['conticomtc']);
   
} ?>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
                        <h5 class="card-title mb-0 text-white flex-grow-1 text-center"> Clasificaciones
                        </h5>
                        <?php if ( $_SESSION['typeuser']==1 && $u->cargo==1) { ?>
                            <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModalLong">Importar</button>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <!-- Accordions Bordered -->
            <div class="accordion custom-accordionwithicon custom-accordion-border accordion-border-box accordion-secondary" id="accordionBordered">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="accordionBorderedExample1">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accorBorderedExampleCollapse1" aria-expanded="false" aria-controls="accorBorderedExampleCollapse1">
                            <span>Liga FMA Regular por Equipos - Clasificación Tercera A</span>
                        </button>
                    </h2>
                    <div id="accorBorderedExampleCollapse1" class="accordion-collapse collapse" aria-labelledby="accordionBorderedExample1" data-bs-parent="#accordionBordered">
                        <div class="accordion-body">
                            <div class="table-responsive">
                                <table id="customerTable" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                    <thead>
                                        <tr class="table-primary">
                                            <th width="5px">Nº</th>
                                            <th>Equipo</th>
                                            <th>Puntos</th>
                                            <th>Progresivo</th>
                                            <th>Buchholz -1</th>
                                            <th>Buchholz</th>
                                            <th>Mediano Buchholz</th>
                                            <th>Olímpico</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $datas1 = ResultadoData::vercontenidos1();
                                        foreach ($datas1 as $data1) { ?>
                                        <tr>
                                            <td><?= $data1->numero; ?></td>
                                            <td><?= $data1->equipo; ?></td>
                                            <td><?= $data1->puntos; ?></td>
                                            <td><?= $data1->progresivo; ?></td>
                                            <td><?= $data1->buchholz_1; ?></td>
                                            <td><?= $data1->buchholz; ?></td>
                                            <td><?= $data1->mediano_buchholz; ?></td>
                                            <td><?= $data1->olimpico; ?></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="accordionBorderedExample4">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accorBorderedExampleCollapse4" aria-expanded="false" aria-controls="accorBorderedExampleCollapse4">
                            <span>Liga FMA Regular por Equipos - Clasificación Tercera B</span>
                        </button>
                    </h2>
                    <div id="accorBorderedExampleCollapse4" class="accordion-collapse collapse" aria-labelledby="accordionBorderedExample4" data-bs-parent="#accordionBordered">
                        <div class="accordion-body">
                            <div class="table-responsive">
                                <table id="customerTable" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                    <thead>
                                        <tr class="table-primary">
                                            <th width="5px">Nº</th>
                                            <th>Equipo</th>
                                            <th>Puntos</th>
                                            <th>Progresivo</th>
                                            <th>Buchholz -1</th>
                                            <th>Buchholz</th>
                                            <th>Mediano Buchholz</th>
                                            <th>Olímpico</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $datas2 = ResultadoData::vercontenidos2();
                                        foreach ($datas2 as $data2) { ?>
                                        <tr>
                                            <td><?= $data2->numero; ?></td>
                                            <td><?= $data2->equipo; ?></td>
                                            <td><?= $data2->puntos; ?></td>
                                            <td><?= $data2->progresivo; ?></td>
                                            <td><?= $data2->buchholz_1; ?></td>
                                            <td><?= $data2->buchholz; ?></td>
                                            <td><?= $data2->mediano_buchholz; ?></td>
                                            <td><?= $data2->olimpico; ?></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="accordionBorderedExample5">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accorBorderedExampleCollapse5" aria-expanded="false" aria-controls="accorBorderedExampleCollapse5">
                            <span>Liga FMA Sub-16 por Equipos - Clasificación Sub-16</span>
                        </button>
                    </h2>
                    <div id="accorBorderedExampleCollapse5" class="accordion-collapse collapse" aria-labelledby="accordionBorderedExample5" data-bs-parent="#accordionBordered">
                        <div class="accordion-body">
                            <div class="table-responsive">
                                <table id="customerTable" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                    <thead>
                                        <tr class="table-primary">
                                            <th width="5px">Nº</th>
                                            <th>Equipo</th>
                                            <th>Puntos</th>
                                            <th>Progresivo</th>
                                            <th>Buchholz -1</th>
                                            <th>Buchholz</th>
                                            <th>Mediano Buchholz</th>
                                            <th>Olímpico</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $datas3 = ResultadoData::vercontenidos3();
                                        foreach ($datas3 as $data3) { ?>
                                        <tr>
                                            <td><?= $data3->numero; ?></td>
                                            <td><?= $data3->equipo; ?></td>
                                            <td><?= $data3->puntos; ?></td>
                                            <td><?= $data3->progresivo; ?></td>
                                            <td><?= $data3->buchholz_1; ?></td>
                                            <td><?= $data3->buchholz; ?></td>
                                            <td><?= $data3->mediano_buchholz; ?></td>
                                            <td><?= $data3->olimpico; ?></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion-item mt-2">
                    <h2 class="accordion-header" id="accordionborderedExample2">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accor_borderedExamplecollapse2" aria-expanded="false" aria-controls="accor_borderedExamplecollapse2">
                            Liga FMA Sub-16 por Equipos - Clasificación Sub-12
                        </button>
                    </h2>
                    <div id="accor_borderedExamplecollapse2" class="accordion-collapse collapse" aria-labelledby="accordionborderedExample2" data-bs-parent="#accordionBordered">
                        <div class="accordion-body">
                           <div class="table-responsive">
                                <table id="customerTable" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                    <thead>
                                        <tr class="table-primary">
                                            <th width="5px">Nº</th>
                                            <th>Equipo</th>
                                            <th>Puntos</th>
                                            <th>Progresivo</th>
                                            <th>Buchholz -1</th>
                                            <th>Buchholz</th>
                                            <th>Mediano Buchholz</th>
                                            <th>Olímpico</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $datas4 = ResultadoData::vercontenidos4();
                                        foreach ($datas4 as $data4) { ?>
                                        <tr>
                                            <td><?= $data4->numero; ?></td>
                                            <td><?= $data4->equipo; ?></td>
                                            <td><?= $data4->puntos; ?></td>
                                            <td><?= $data4->progresivo; ?></td>
                                            <td><?= $data4->buchholz_1; ?></td>
                                            <td><?= $data4->buchholz; ?></td>
                                            <td><?= $data4->mediano_buchholz; ?></td>
                                            <td><?= $data4->olimpico; ?></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item mt-2">
                    <h2 class="accordion-header" id="accordionborderedExample3">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accor_borderedExamplecollapse3" aria-expanded="false" aria-controls="accor_borderedExamplecollapse3">
                            Liga FMA Ajedrez Rápido por Equipos - Clasificación
                        </button>
                    </h2>
                    <div id="accor_borderedExamplecollapse3" class="accordion-collapse collapse" aria-labelledby="accordionborderedExample3" data-bs-parent="#accordionBordered">
                        <div class="accordion-body">
                            <div class="table-responsive">
                                <table id="customerTable" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                    <thead>
                                        <tr class="table-primary">
                                            <th width="5px">Nº</th>
                                            <th>Equipo</th>
                                            <th>Puntos</th>
                                            <th>Progresivo</th>
                                            <th>Buchholz -1</th>
                                            <th>Buchholz</th>
                                            <th>Mediano Buchholz</th>
                                            <th>Olímpico</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $datas5 = ResultadoData::vercontenidos5();
                                        foreach ($datas5 as $data5) { ?>
                                        <tr>
                                            <td><?= $data5->numero; ?></td>
                                            <td><?= $data5->equipo; ?></td>
                                            <td><?= $data5->puntos; ?></td>
                                            <td><?= $data5->progresivo; ?></td>
                                            <td><?= $data5->buchholz_1; ?></td>
                                            <td><?= $data5->buchholz; ?></td>
                                            <td><?= $data5->mediano_buchholz; ?></td>
                                            <td><?= $data5->olimpico; ?></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<!-- 

            <div class="row">
                <div class="col">
                    <div class="card shadow">
                        <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
                        <h5 class="card-title mb-0 text-white flex-grow-1 text-center"> Clasificacion de Liga Regular
                        </h5>
                        <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModalLong">Importar</button>
                    </div>
                        <div class="card-body">

                            <div class="table-responsive">
                                <table id="customerTable" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                    <thead>
                                        <tr class="table-primary">
                                            <th width="5px">Nº</th>
                                            <th>Equipo</th>
                                            <th>Puntos</th>
                                            <th>Progresivo</th>
                                            <th>Buchholz -1</th>
                                            <th>Buchholz</th>
                                            <th>Mediano Buchholz</th>
                                            <th>Olímpico</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $datas1 = ResultadoData::vercontenidos1();
                                        foreach ($datas1 as $data1) { ?>
                                        <tr>
                                            <td><?= $data1->numero; ?></td>
                                            <td><?= $data1->equipo; ?></td>
                                            <td><?= $data1->puntos; ?></td>
                                            <td><?= $data1->progresivo; ?></td>
                                            <td><?= $data1->buchholz_1; ?></td>
                                            <td><?= $data1->buchholz; ?></td>
                                            <td><?= $data1->mediano_buchholz; ?></td>
                                            <td><?= $data1->olimpico; ?></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow">
                        <div class="card-header bg-primary text-white d-flex align-items-center justify-content-center">
                            <h5 class="card-title mb-0 text-white">Clasificación de Categoría sub 16 / 12</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="customerTable" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                    <thead>
                                        <tr class="table-primary">
                                            <th width="5px">Nº</th>
                                            <th>Equipo</th>
                                            <th>Puntos</th>
                                            <th>Progresivo</th>
                                            <th>Buchholz -1</th>
                                            <th>Buchholz</th>
                                            <th>Mediano Buchholz</th>
                                            <th>Olímpico</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $datas2 = ResultadoData::vercontenidos2();
                                        foreach ($datas2 as $data2) { ?>
                                        <tr>
                                            <td><?= $data2->numero; ?></td>
                                            <td><?= $data2->equipo; ?></td>
                                            <td><?= $data2->puntos; ?></td>
                                            <td><?= $data2->progresivo; ?></td>
                                            <td><?= $data2->buchholz_1; ?></td>
                                            <td><?= $data2->buchholz; ?></td>
                                            <td><?= $data2->mediano_buchholz; ?></td>
                                            <td><?= $data2->olimpico; ?></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow">
                        <div class="card-header bg-primary text-white d-flex align-items-center justify-content-center">
                            <h5 class="card-title mb-0 text-white">Clasificación Simple</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="customerTable" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                    <thead>
                                        <tr class="table-primary">
                                            <th width="5px">Nº</th>
                                            <th>Equipo</th>
                                            <th>Puntos</th>
                                            <th>Progresivo</th>
                                            <th>Buchholz -1</th>
                                            <th>Buchholz</th>
                                            <th>Mediano Buchholz</th>
                                            <th>Olímpico</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $datas3 = ResultadoData::vercontenidos3();
                                        foreach ($datas3 as $data3) { ?>
                                        <tr>
                                            <td><?= $data3->numero; ?></td>
                                            <td><?= $data3->equipo; ?></td>
                                            <td><?= $data3->puntos; ?></td>
                                            <td><?= $data3->progresivo; ?></td>
                                            <td><?= $data3->buchholz_1; ?></td>
                                            <td><?= $data3->buchholz; ?></td>
                                            <td><?= $data3->mediano_buchholz; ?></td>
                                            <td><?= $data3->olimpico; ?></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModalLong" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title text-white" id="exampleModalLabel">Importar Resultado</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form enctype="multipart/form-data" method="POST" class="tablelist-form" autocomplete="off" action="index.php?action=registro">
            <div class="modal-body bg-light p-4">
                <div class="row mb-4">
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <!-- <label class="form-label text-dark fw-bold mb-0" for="competicion-field"></label> -->
                        <a download="" href="storage/per/plantillaresultado.xlsx" class="btn btn-outline-secondary btn-sm d-flex align-items-center">
                            <i class="ri-download-cloud-2-line" style="font-size: 18px;"></i>
                            <span class="ms-2">Descargar Plantilla</span>
                        </a>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-12">
                        <label class="form-label text-dark fw-bold" for="archivo">Importar Archivo</label>
                        <input required type="file" name="archivo" id="archivo" class="form-control border-secondary" accept=".xls, .xlsx, .csv">
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <label class="form-label text-dark fw-bold" for="tipo">Tipo de Resultado</label>
                        <select name="tipo" id="tipo" class="form-select border-secondary" required>
                            <option value="" disabled selected>Seleccionar</option>
                            <option value="RA">Regular A</option>
                            <option value="RB">Regular B</option>
                            <option value="SB16">Sub 16</option>
                            <option value="SB12">Sub 12</option>
                            <option value="S">Simple</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-info d-flex justify-content-between pb-0">
                <input class="form-control" type="hidden" name="actions" value="64">
                <button type="button" class="btn btn-outline-light me-2" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-light">Importar</button>
            </div>
            </form>
        </div>
    </div>
</div>
<?php } else {
    header("Location: ./"); 
    exit();
} ?>