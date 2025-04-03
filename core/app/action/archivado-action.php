<?php 
$actions=$_GET['tid2'];
if ($actions==1) {
	$registro = new TemporadaData();
	$registro->id=$_GET['tid'];
	$registro->estado=0;
	$registro->archivado=0;
	$registro->archivado1 =1;
	$registro->archivar();
	$_SESSION['success_messagea'] = "Archivado con éxito.";
    header("Location: temporada");
}
if ($actions==2) {
	$registro = new TemporadaData();
	$registro->id=$_GET['tid'];
	$registro->estado=1;
	$registro->archivado=0;
	$registro->desarchivar();
	$_SESSION['success_messagea'] = "Archivado Listo para visualizar.";
    header("Location: archivado");
}
if ($actions==3) {
	$registro = new TemporadaData();
	$registro->id=$_GET['tid'];
	$registro->estado=0;
	$registro->archivado=0;
	$registro->archivado1 =1;
	$registro->archivar();
	$_SESSION['success_messagea'] = "Archivado con éxito.";
    header("Location: archivado");
}
?>