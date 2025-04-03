<?php
session_start();
if(isset($_SESSION['conticomtc'])){
	unset($_SESSION['conticomtc']);
}
if(isset($_SESSION['typeuser'])){
	unset($_SESSION['typeuser']);
}
session_destroy();
print "<script>window.location='./';</script>";
?>