<?php 
$tid=$_GET['tid'];
if ($tid==1) {
	$_SESSION['typeuser'] = 1;
	header("Location: index.php?view=login");
        exit;
} 
if ($tid==2) {
	$_SESSION['typeuser'] = 2;
	header("Location: index.php?view=login");
        exit;
} 
 ?>