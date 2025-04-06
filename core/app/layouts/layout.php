<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable" data-layout-style="default" data-layout-mode="light" data-layout-position="fixed">
<head>
    <meta charset="utf-8" />
    <title>Gestión de Competiciones - FMA</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="storage/per/logo.png">
    <meta content="AJEDREZ MADRILEÑA" name="description" />
    <meta content="Themesbrand" name="author" />
    <script src="assets/js/layout.js"></script>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/jsvectormap/css/jsvectormap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/swiper/swiper-bundle.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/custom.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.4.0/css/fixedHeader.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <script src="assets/ckeditor/ckeditor.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/noty@3.1.4/lib/noty.css">
    <script src="https://cdn.jsdelivr.net/npm/noty@3.1.4/lib/noty.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link rel="stylesheet" type="text/css" href="assets/libs/multi.js/multi.min.css" />
    <link rel="stylesheet" href="assets/libs/@tarekraafat/autocomplete.js/css/autoComplete.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
    
</head>
<body>
<?php 
if (isset($_SESSION["typeuser"]) && ($_SESSION["typeuser"] == 1 || $_SESSION["typeuser"] == 2)) {
    if (isset($_SESSION["conticomtc"])) {
        if ($_SESSION["typeuser"] == 1) {
            $u = UserData::verid($_SESSION['conticomtc']);
        } elseif ($_SESSION["typeuser"] == 2) {
            $u = JugadorData::verid($_SESSION['conticomtc']);
        }
?>
    <div id="layout-wrapper">
        <header id="page-topbar">
            <div class="layout-width">
                <div class="navbar-header">
                    <div class="d-flex">
                        <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger" id="topnav-hamburger-icon">
                            <span class="hamburger-icon">
                                <span></span>
                                <span></span>
                                <span></span>
                            </span>
                        </button>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="dropdown ms-sm-3 header-item topbar-user">
                            <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="d-flex align-items-center">
                                    <img class="rounded-circle header-profile-user" src="storage/per/usuario.png" alt="Header Avatar">
                                    <?php if ($_SESSION["typeuser"]==1 | $_SESSION["typeuser"]==2 ) { ?>
                                    <span class="text-start ms-xl-2">
                                        <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text"><?= $u->nombre; ?></span>
                                        <span class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text"><?php if ($_SESSION["typeuser"]==1) { echo $u->apellido; } 
                                        if ($_SESSION["typeuser"]==2) { echo $u->apellido1.' '.$u->apellido2; } ?></span>
                                    </span>
                                    <?php }  ?>
                                </span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <?php if ($_SESSION["typeuser"] == 1 || $_SESSION["typeuser"] == 2) { ?>
                                    <h6 class="dropdown-header">Bienvenido, <?= htmlspecialchars($u->nombre); ?>!</h6>
                                <?php } ?>
                                <a class="dropdown-item" href="perfil">
                                    <i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> 
                                    <span class="align-middle" data-key="t-profile">Mi Perfil</span>
                                </a>
                                <div class="dropdown-divider"></div> 
                                <a class="dropdown-item" href="salir.php">
                                    <i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> 
                                    <span class="align-middle" data-key="t-logout">Salir</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <div class="app-menu navbar-menu">
            <div class="navbar-brand-box">
                <a href="index" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="storage/per/logo.png" alt="" height="35" width="20px">
                    </span>
                    <span class="logo-lg">
                        <img src="storage/per/logo.png" alt="" height="75" width="47px">
                    </span>
                </a>
                <a href="index" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="storage/per/logo.png" alt="" height="35" width="20px">
                    </span>
                    <span class="logo-lg">
                        <img src="storage/per/logo.png" alt="" height="75" width="47px">
                    </span>
                </a>
                <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
                    <i class="ri-record-circle-line"></i>
                </button>
            </div>
            <div id="scrollbar">
                <div class="container-fluid">
                    <div id="two-column-menu">
                    </div>
                    <ul class="navbar-nav" id="navbar-nav">
                        <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                        <?php if ($_SESSION["typeuser"]==1 | $_SESSION["typeuser"]==2 ) { if ($u->cargo==1) { ?>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="federacion">
                                <i class="ri-star-line"></i> <span data-key="t-federacion">Federación</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="temporada">
                                <i class="ri-calendar-line"></i> <span data-key="t-temporada">Temporada</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="club">
                                <i class="ri-building-line"></i> <span data-key="t-club">Clubes</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="liga">
                                <i class="ri-trophy-line"></i> <span data-key="t-liga">Ligas</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="equipo">
                                <i class="ri-team-fill"></i> <span data-key="t-liga">Equipos</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="competicion">
                                <i class="ri-medal-line"></i> <span data-key="t-liga">Competición</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#Emparejamientos" class="nav-link menu-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="Emparejamientos" data-key="t-password-reset">
                               <i class="fas fa-random"></i> <span data-key="t-Emparejamientos">Emparejamientos</span>
                            </a>
                            <div class="collapse menu-dropdown" id="Emparejamientos">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="emparejamientos" class="nav-link" data-key="t-basic">
                                        Emparejamiento Simple </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="emparejamiento" class="nav-link" data-key="t-basic">
                                        Emparejamiento Regular </a>
                                    </li>
                                </ul>
                            </div>
                        </li>                    
                        <li class="nav-item">
                            <a href="#Jornada" class="nav-link menu-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="Jornada" data-key="t-password-reset">
                               <i class="ri-sword-line"></i> <span data-key="t-Jornada">Jornada</span>
                            </a>
                            <div class="collapse menu-dropdown" id="Jornada">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="jornadas" class="nav-link" data-key="t-basic">
                                        Jornada Simple </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="jornada" class="nav-link" data-key="t-basic">
                                        Jornada Regular </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a href="#clasificacionn" class="nav-link menu-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="clasificacionn" data-key="t-password-reset">
                               <i class="fas fa-chess-king"></i> <span data-key="t-clasificacionn">Clasificación</span>
                            </a>
                            <div class="collapse menu-dropdown" id="clasificacionn">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="clasificacions" class="nav-link" data-key="t-clasificacions">
                                        Clasificación Sistema Suizo</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="clasificacion" class="nav-link" data-key="t-clasificacion">
                                        Clasificación Round Robin</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a href="#usuarios" class="nav-link menu-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="usuarios" data-key="t-password-reset">
                               <i class="ri-user-follow-fill"></i> <span data-key="t-usuarios">Colaboradores</span>
                            </a>
                            <div class="collapse menu-dropdown" id="usuarios">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="usuario" class="nav-link" data-key="t-basic">
                                        Usuarios </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="jugador" class="nav-link" data-key="t-basic">
                                        Jugadores </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="archivado">
                                <i class="ri-calendar-line"></i> <span data-key="t-archivado">Archivado</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="cronogramas">
                               <i class="ri-calendar-todo-fill"></i> <span data-key="t-cronograma">Calendario de Jornadas</span>
                            </a>
                        </li>
                        <?php }
                        if ($u->cargo==2) { ?>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="mclub">
                                <i class="ri-building-line"></i> <span data-key="t-club">Mi Club</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="liga">
                                <i class="ri-trophy-line"></i> <span data-key="t-liga">Ligas</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="misfederados">
                                <i class="ri-user-follow-fill"></i> <span data-key="t-liga">Mis Federados</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="mequipo">
                                <i class="ri-team-fill"></i> <span data-key="t-liga">Equipos</span>
                            </a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link menu-link" href="competicion">
                                <i class="ri-medal-line"></i> <span data-key="t-liga">Competición</span>
                            </a>
                        </li>  -->
                        
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="mequipos">
                                <i class="ri-briefcase-fill"></i> <span data-key="t-liga">Archivados</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="cronogramas">
                               <i class="ri-calendar-todo-fill"></i> <span data-key="t-cronograma">Calendario de Jornadas</span>
                            </a>
                        </li>
                        <?php } if ($u->cargo==3) { ?>
                        <li class="nav-item">
                            <a href="#Jornada" class="nav-link menu-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="Jornada" data-key="t-password-reset">
                               <i class="ri-sword-line"></i> <span data-key="t-Jornada">Jornada</span>
                            </a>
                            <div class="collapse menu-dropdown" id="Jornada">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="jornadas" class="nav-link" data-key="t-basic">
                                        Jornada Simple </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="jornada" class="nav-link" data-key="t-basic">
                                        Jornada Regular </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a href="#clasificacionn" class="nav-link menu-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="clasificacionn" data-key="t-password-reset">
                               <i class="fas fa-chess-king"></i> <span data-key="t-clasificacionn">Clasificación</span>
                            </a>
                            <div class="collapse menu-dropdown" id="clasificacionn">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="clasificacions" class="nav-link" data-key="t-clasificacions">
                                        Clasificación Sistema Suizo </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="clasificacion" class="nav-link" data-key="t-clasificacion">
                                        Clasificación Round Robin </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="cronogramas">
                               <i class="ri-calendar-todo-fill"></i> <span data-key="t-cronograma">Calendario de Jornadas</span>
                            </a>
                        </li>
                        <?php } if ($u->cargo==4) { ?>
                        <li class="nav-item">
                            <a href="#Jornada" class="nav-link menu-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="Jornada" data-key="t-password-reset">
                               <i class="ri-sword-line"></i> <span data-key="t-Jornada">Jornada</span>
                            </a>
                            <div class="collapse menu-dropdown" id="Jornada">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="jornadas" class="nav-link" data-key="t-basic">
                                        Jornada Simple </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="jornada" class="nav-link" data-key="t-basic">
                                        Jornada Regular </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a href="#clasificacionn" class="nav-link menu-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="clasificacionn" data-key="t-password-reset">
                               <i class="fas fa-chess-king"></i> <span data-key="t-clasificacionn">Clasificación</span>
                            </a>
                            <div class="collapse menu-dropdown" id="clasificacionn">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="clasificacions" class="nav-link" data-key="t-clasificacions">
                                        Clasificación Sistema Suizo</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="clasificacion" class="nav-link" data-key="t-clasificacion">
                                        Clasificación Round Robin</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="cronogramas">
                               <i class="ri-calendar-todo-fill"></i> <span data-key="t-cronograma">Calendario de Jornadas</span>
                            </a>
                        </li>
                        <?php } if ($u->cargo==5) { ?>
                        <li class="nav-item">
                            <a href="#Jornada" class="nav-link menu-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="Jornada" data-key="t-password-reset">
                               <i class="ri-sword-line"></i> <span data-key="t-Jornada">Jornada</span>
                            </a>
                            <div class="collapse menu-dropdown" id="Jornada">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="jornadas" class="nav-link" data-key="t-basic">
                                        Jornada Simple </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="jornada" class="nav-link" data-key="t-basic">
                                        Jornada Regular </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a href="#clasificacionn" class="nav-link menu-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="clasificacionn" data-key="t-password-reset">
                               <i class="fas fa-chess-king"></i> <span data-key="t-clasificacionn">Clasificación</span>
                            </a>
                            <div class="collapse menu-dropdown" id="clasificacionn">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="clasificacions" class="nav-link" data-key="t-clasificacions">
                                        Clasificación Sistema Suizo</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="clasificacion" class="nav-link" data-key="t-clasificacion">
                                        Clasificación Round Robin</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a href="cronogramas" class="nav-link active" data-key="t-basic" aria-label="Calendario de Jornadas">
                               <i class="fas fa-calendar-alt"></i> Calendario de Jornadas
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="cronogramas">
                               <i class="ri-calendar-todo-fill"></i> <span data-key="t-cronograma">Calendario de Jornadas</span>
                            </a>
                        </li>
                        <?php } if ($u->cargo==6) { ?>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="emparejamientoi">
                                <i class="ri-team-line"></i> <span data-key="t-liga">Emparejamientos</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="jornadai">
                                <i class="ri-sword-line"></i> <span data-key="t-liga">Jornada</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#usuarios" class="nav-link menu-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="usuarios" data-key="t-password-reset">
                               <i class="fas fa-handshake"></i> <span data-key="t-usuarios">Encuentros</span>
                            </a>
                            <div class="collapse menu-dropdown" id="usuarios">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="encuentro" class="nav-link" data-key="t-basic">
                                        División de Honor </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="cronogramas">
                               <i class="ri-calendar-todo-fill"></i> <span data-key="t-cronograma">Calendario de Jornadas</span>
                            </a>
                        </li>
                        <?php } } if ($_SESSION["typeuser"]==3) { ?>
                        <li class="nav-item">
                            <a href="#Jornada" class="nav-link menu-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="Jornada" data-key="t-password-reset">
                               <i class="ri-sword-line"></i> <span data-key="t-Jornada">Jornada</span>
                            </a>
                            <div class="collapse menu-dropdown" id="Jornada">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="jornadasi" class="nav-link" data-key="t-basic">
                                        Jornada Simple </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="jornadai" class="nav-link" data-key="t-basic">
                                        Jornada Regular </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a href="#clasificacionn" class="nav-link menu-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="clasificacionn" data-key="t-password-reset">
                               <i class="fas fa-chess-king"></i> <span data-key="t-clasificacionn">Clasificación</span>
                            </a>
                            <div class="collapse menu-dropdown" id="clasificacionn">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="clasificacionsi" class="nav-link" data-key="t-clasificacionsi">
                                        Clasificación Sistema Suizo</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="clasificacioni" class="nav-link" data-key="t-clasificacion">
                                        Clasificación Round Robin</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="cronogramas">
                               <i class="ri-calendar-todo-fill"></i> <span data-key="t-cronograma">Calendario de Jornadas</span>
                            </a>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <div class="sidebar-background"></div>
        </div>
        <div class="vertical-overlay"></div>
            <?php View::load("index");  ?>
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            © <script>document.write(new Date().getFullYear())</script> - Gestión de Competiciones - Federación Madrileña de Ajedrez
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                                Todos los derechos reservados
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
         </div>
         <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
            <i class="ri-arrow-up-line"></i>
        </button>
<?php    } else { ?>







<link href="assets/estilologin.css" rel="stylesheet" type="text/css" />
    <div class="auth-page-wrapper pt-10">
        <div class="auth-one-bg-position" id="auth-particles" style="background-image: url('storage/per/fondillo.png'); background-size: cover; background-position: center; margin-top: 0; padding: 0;">
            <div class="bg-overlay" style="background-color: #67678F;"></div>
            <div class="shape">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1440 120">
                    <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
                </svg>
            </div>
        </div>
        <div class="auth-page-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mt-sm-5 mb-4 text-white-50">
                            <div>
                                <a href="./" class="d-inline-block auth-logo">
                                    <img src="storage/per/logo.png" alt="" height="100">
                                </a>
                            </div>
                            <div class="header-text">
                              Gestión de Competiciones - Federación Madrileña de Ajedrez
                          </div>
                      </div>
                  </div>
              </div>
              <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card mt-1">
                        <div class="card-body p-4">
                            <div class="text-center mt-2">
                                <h5 class="text-primary">Iniciar sesión</h5>
                                <p class="text-muted">Por favor, introduce tu usuario y contraseña.</p>
                            </div>
                            <div class="p-2 mt-4">
                                <?php if (!isset($_COOKIE['verificationCode'])) { ?>
                                    <form id="loginForm" method="post"  action="index.php?action=access">
                                        <?php if (isset($_SESSION['error_message'])) {
                                            echo '<div class="alert alert-danger">' . $_SESSION['error_message'] . '</div>';
                                            unset($_SESSION['error_message']);
                                        } ?>
                                        <div class="mb-3" id="usernameField">
                                            <label for="username" class="form-label">Usuario:</label>
                                            <input type="text" autofocus autocomplete="off" class="form-control" id="username" name="usuario" required>
                                        </div>
                                        <div class="mb-3" id="passwordField">
                                            <label class="form-label" for="password-input">Password:</label>
                                            <div class="position-relative auth-pass-inputgroup mb-3">
                                                <input type="password" class="form-control pe-5 password-input" id="password-input" name="password" required>
                                                <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon">
                                                    <i class="ri-eye-fill align-middle"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="form-check">
                                            <div class="float-end">
                                                <a href="javascript:void(0)" onclick="showPasswordResetForm()" class="text-muted">¿Olvidaste tu contraseña?</a>
                                            </div>
                                            <input class="form-check-input" type="checkbox" value="" id="auth-remember-check">
                                            <label class="form-check-label" for="auth-remember-check">Recordar</label>
                                        </div>
                                        <div class="mt-4">
                                            <button class="btn btn-success w-100" type="submit">Entrar</button> 
                                        </div>
                                        <a href="salir.php" class="text-muted">Volver al inicio</a>
                                    </form>
                                <?php } else { ?>
                                    <form id="verificationForm" method="post"  action="index.php?action=validar">
                                        <?php if (isset($_SESSION['error_message1'])) {
                                            echo '<div class="alert alert-danger">' . $_SESSION['error_message1'] . '</div>';
                                            unset($_SESSION['error_message1']);
                                        } ?>
                                        <div class="counter-container1">
                                            <span id="counter" data-start-time="<?php echo $_SESSION['verificationStartTime']; ?>"></span>
                                        </div>
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Introduce el código que has recibido por correo electrónico</label>
                                            <input autofocus type="text" class="form-control" name="codigo" required>
                                        </div>
                                        <div class="mt-4">
                                            <button class="btn btn-success w-100" type="submit">Validar código</button>
                                        </div>
                                    </form>
                                <?php } ?>
                                <script>
                                    document.addEventListener("DOMContentLoaded", function() {
                                        let startTime = parseInt(document.getElementById("counter").getAttribute("data-start-time"));
                                        let interval = setInterval(function() {
                                            let currentTime = Math.floor(new Date().getTime() / 1000);  
                                            let timeElapsed = currentTime - startTime;
                                            let timeRemaining = 120 - timeElapsed;
                                            if (timeRemaining <= 0) {
                                                clearInterval(interval);
                                                document.getElementById("counter").innerText = "Tiempo agotado";
                                            } else {
                                                let minutes = Math.floor(timeRemaining / 60);
                                                let seconds = timeRemaining % 60;
                                                document.getElementById("counter").innerText = minutes + ":" + (seconds < 10 ? "0" + seconds : seconds);
                                            }
                                        }, 1000);
                                    });
                                </script>
                                <form id="passwordResetForm" method="post"  action="index.php?action=recuperar" style="display: none;">
                                    <?php if (isset($_SESSION['error_message2'])) {
                                        echo '<div class="alert alert-danger">' . $_SESSION['error_message2'] . '</div>';
                                        unset($_SESSION['error_message2']);
                                    } ?>
                                    <?php if (isset($_SESSION['error_message3'])) {
                                        echo '<div class="alert alert-success">' . $_SESSION['error_message3'] . '</div>';
                                        unset($_SESSION['error_message3']);
                                    } ?>
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Introduce tu correo electrónico</label>
                                        <input autofocus type="text" class="form-control" name="correo" required>
                                    </div>

                                    <div class="mt-4">
                                        <button class="btn btn-success w-100" type="submit">Validar correo</button>
                                    </div>
                                    <a href="javascript:void(0)" class="text-muted" onclick="showLoginForm()">Volver</a>
                                </form>
                                <script>
                                    function showPasswordResetForm() {
                                        document.getElementById('loginForm').style.display = 'none';
                                        document.getElementById('passwordResetForm').style.display = 'block';
                                        localStorage.setItem('showPasswordResetForm', 'true');

                                                        // Añade una entrada al historial del navegador
                                        history.pushState({ form: 'passwordResetForm' }, '');
                                    }

                                    function hidePasswordResetForm() {
                                        document.getElementById('loginForm').style.display = 'block';
                                        document.getElementById('passwordResetForm').style.display = 'none';
                                        localStorage.removeItem('showPasswordResetForm');

                                                        // Añade una entrada al historial del navegador
                                        history.pushState({ form: 'loginForm' }, '');
                                    }

                                                    // Al cargar la página, verificamos cuál formulario mostrar
                                    if (localStorage.getItem('showPasswordResetForm') === 'true') {
                                        showPasswordResetForm();
                                    } else {
                                        hidePasswordResetForm();
                                    }

                                                    // Verifica cuál formulario mostrar cuando el estado de carga del documento cambia
                                    document.onreadystatechange = function() {
                                        if (document.readyState === "interactive") {
                                            if (localStorage.getItem('showPasswordResetForm') === 'true') {
                                                showPasswordResetForm();
                                            } else {
                                                hidePasswordResetForm();
                                            }
                                        }
                                    };

                                                    // Detecta el evento popstate para mostrar el formulario correcto cuando el usuario pulsa el botón de retroceso
                                    window.addEventListener('popstate', function(event) {
                                        if (event.state && event.state.form === 'passwordResetForm') {
                                            showPasswordResetForm();
                                        } else {
                                            hidePasswordResetForm();
                                        }
                                    });
                                    function showLoginForm() {
                                        document.getElementById('loginForm').style.display = 'block';
                                        document.getElementById('passwordResetForm').style.display = 'none';
                                        localStorage.removeItem('showPasswordResetForm');

                                                    // Añade una entrada al historial del navegador
                                        history.pushState({ form: 'loginForm' }, '');
                                    }
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="footer">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="text-center">
              <p>&copy; <script>document.write(new Date().getFullYear())</script> Gestión de Competiciones - Federación Madrileña de Ajedrez. Todos los derechos reservados.</p>
          </div>
      </div>
  </div>
</div>
</footer>
</div>
    <script src="assets/scriptlogin.js"></script>
    <script src="assets/js/pages/password-addon.init.js"></script>
    <script src="assets/libs/particles.js/particles.js"></script>
    <script src="assets/js/pages/particles.app.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>















<?php    }
} else { ?>
<div id="layout-wrapper">
    <header id="page-topbar">
        <div class="layout-width">
            <div class="navbar-header">
                <div class="d-flex">
                    <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger" id="topnav-hamburger-icon">
                        <span class="hamburger-icon">
                            <span></span>
                            <span></span>
                            <span></span>
                        </span>
                    </button>
                </div>
                <div class="d-flex align-items-center">
    <div class="dropdown ms-sm-3 header-item topbar-user">
        <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="d-flex align-items-center">
                <!-- Icono de usuario -->
                <i class="fas fa-user-circle fs-24 text-primary"></i>
                <span class="text-start ms-xl-2">
                    <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">Login</span>
                    <span class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text">Liga Madrileña</span>
                </span>
            </span>
        </button>
        <div class="dropdown-menu dropdown-menu-end">
            <!-- Encabezado del dropdown -->
            <h6 class="dropdown-header">Selecciona tu perfil:</h6>
            <!-- Opción para Administrador -->
            <a class="dropdown-item" href="index.php?action=iniciador&tid=1">
                <i class="fas fa-user-shield text-muted fs-16 align-middle me-1"></i>
                <span class="align-middle" data-key="t-logout">Club</span>
            </a>
            <!-- Opción para Administrador -->
            <a class="dropdown-item" href="index.php?action=iniciador&tid=1">
                <i class="fas fa-user-shield text-muted fs-16 align-middle me-1"></i>
                <span class="align-middle" data-key="t-logout">Capitán</span>
            </a>
            <!-- Opción para Administrador -->
            <a class="dropdown-item" href="index.php?action=iniciador&tid=1">
                <i class="fas fa-user-shield text-muted fs-16 align-middle me-1"></i>
                <span class="align-middle" data-key="t-logout">Árbitro</span>
            </a>                        
            <!-- Opción para Jugador -->
            <a class="dropdown-item" href="index.php?action=iniciador&tid=2">
                <i class="fas fa-user-tie text-muted fs-16 align-middle me-1"></i>
                <span class="align-middle" data-key="t-logout">Jugador</span>
            </a>
        </div>
    </div>
</div>

            </div>
        </div>
    </header>
    <div class="app-menu navbar-menu">
        <div class="navbar-brand-box">
            <a href="index" class="logo logo-dark">
                <span class="logo-sm">
                    <img src="storage/per/logo.png" alt="" height="35" width="20px">
                </span>
                <span class="logo-lg">
                    <img src="storage/per/logo.png" alt="" height="75" width="47px">
                </span>
            </a>
            <a href="index" class="logo logo-light">
                <span class="logo-sm">
                    <img src="storage/per/logo.png" alt="" height="35" width="20px">
                </span>
                <span class="logo-lg">
                    <img src="storage/per/logo.png" alt="" height="75" width="47px">
                </span>
            </a>
            <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
                <i class="ri-record-circle-line"></i>
            </button>
        </div>
        <div id="scrollbar">
            <div class="container-fluid">
                <div id="two-column-menu">
                </div>
                <ul class="navbar-nav" id="navbar-nav">
                    <li class="nav-item">
                        <a href="#Jornada" class="nav-link menu-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="Jornada" data-key="t-password-reset">
                            <i class="ri-sword-line"></i> <span data-key="t-Jornada">Jornada</span>
                        </a>
                        <div class="collapse menu-dropdown" id="Jornada">
                        <ul class="nav nav-sm flex-column">
                            <!-- <li class="nav-item">
                                <a href="cronogramas" class="nav-link" data-key="t-basic">
                                Calendario de Jornadas </a>
                            </li> -->
                            <li class="nav-item">
                                <a href="jornadasi" class="nav-link" data-key="t-basic">
                                Sistema Suizo </a>
                            </li>                            
                            <li class="nav-item">
                                <a href="jornadai" class="nav-link" data-key="t-basic">
                                Liga </a>
                            </li>
                        </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a href="#clasificacionn" class="nav-link menu-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="clasificacionn" data-key="t-password-reset">
                            <i class="fas fa-chess-king"></i> <span data-key="t-clasificacionn">Clasificación</span>
                        </a>
                        <div class="collapse menu-dropdown" id="clasificacionn">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                <a href="clasificacionsi" class="nav-link" data-key="t-clasificacionsi"> Clasificación Suizo </a>
                                </li>
                                <li class="nav-item">
                                    <a href="clasificacioni" class="nav-link" data-key="t-clasificacion"> Clasificación Liga </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="cronogramas">
                            <i class="ri-calendar-todo-fill"></i> <span data-key="t-cronograma">Calendario de Jornadas</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="sidebar-background"></div>
    </div>
    <div class="vertical-overlay"></div>
    <?php View::load("index");  ?>
    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <script>document.write(new Date().getFullYear())</script> @ Gestión de Competiciones - Federación Madrileña de Ajedrez
                </div>
                <div class="col-sm-6">
                    <div class="text-sm-end d-none d-sm-block">
                        Todos los derechos reservados
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>
<button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
    <i class="ri-arrow-up-line"></i>
</button>
<?php } ?>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>
    <script src="assets/libs/feather-icons/feather.min.js"></script>
    <script src="assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
    <script src="assets/js/plugins.js"></script>
    <script src="assets/libs/prismjs/prism.js"></script>
    <script src="assets/js/app.js"></script>
    <script src="assets/js/pages/form-validation.init.js"></script>
    <script src="assets/libs/apexcharts/apexcharts.min.js"></script>
    <script src="assets/libs/jsvectormap/js/jsvectormap.min.js"></script>
    <script src="assets/libs/jsvectormap/maps/world-merc.js"></script>
    <script src="assets/libs/swiper/swiper-bundle.min.js"></script>
    <script src="assets/js/pages/dashboard-ecommerce.init.js"></script>
    <script src="assets/libs/prismjs/prism.js"></script>
    <script src="assets/libs/list.pagination.js/list.pagination.min.js"></script>
    <script src="assets/js/pages/listjs.init.js"></script>
    <script src="assets/libs/sweetalert2/sweetalert2.min.js"></script>
    
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

    <script src="assets/js/pages/datatables.init.js"></script>
    <script src="https://cdn.datatables.net/fixedheader/3.4.0/js/dataTables.fixedHeader.min.js"></script>
    <script src="assets/js/pages/ecommerce-product-details.init.js"></script>
    <script src="assets/js/pages/invoicedetails.js"></script>
    <script src="assets/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/i18n/es.js"></script>
    <script src="https://unpkg.com/@zxing/library@latest"></script>
    <script src="https://cdn.rawgit.com/serratus/quaggaJS/0420d5e0/dist/quagga.min.js"></script>
    <script src="assets/js/pages/form-editor.init.js"></script>
    <script src="assets/pers1.js"></script>
    <script src="https://cdn.lordicon.com/lordicon.js"></script>

    <script src="assets/libs/multi.js/multi.min.js"></script>
    <script src="assets/libs/@tarekraafat/autocomplete.js/autoComplete.min.js"></script>
    <script src="assets/js/pages/form-advanced.init.js"></script>
    <script src="assets/js/pages/form-input-spin.init.js"></script>
    <script src="assets/js/pages/flag-input.init.js"></script>
    <!-- <script>
    // $(document).ready(function() {
    //     $('.miSelect1').select2({
    //     });
    // });
    $(".miSelect1").select2();
    $(".miSelect1").on("select2:open", function() {
        $(".select2-search__field").focus();
    });
    </script> -->
    <script>
      $('.modal').on('shown.bs.modal', function () {
        $(this).find('.miSelect1').select2({
          dropdownParent: $(this)
        });
      });
      $(document).on("select2:open", function() {
        $(".select2-search__field").focus();
      });
    </script>

    <script>
       $(document).ready(function() {
    if ($.fn.DataTable.isDataTable('.cambios')) {
        $('.cambios').DataTable().destroy();
    }

    $('.cambios').DataTable({
        language: {
            processing: "Procesando...",
            search: "Buscar:",
            lengthMenu: "Mostrar _MENU_ elementos",
            info: "Mostrando desde _START_ al _END_ de _TOTAL_ elementos",
            infoEmpty: "Mostrando ningún elemento.",
            infoFiltered: "(filtrado _MAX_ elementos total)",
            infoPostFix: "",
            loadingRecords: "Cargando registros...",
            zeroRecords: "No se encontraron registros",
            emptyTable: "No hay datos disponibles en la tabla",
            paginate: {
                first: "Primero",
                previous: "Anterior",
                next: "Siguiente",
                last: "Último"
            },
            aria: {
                sortAscending: ": Activar para ordenar la columna de manera ascendente",
                sortDescending: ": Activar para ordenar la columna de manera descendente"
            }
        }
    });
});
    </script>
<script type='text/javascript'>document.oncontextmenu = function(){return false}</script>
<!-- <script src="https://cdn.staticaly.com/gh/DungGramer/disable-devtool/cbf447f/disable-devtool.min.js" defer></script> -->
</body>
</html>