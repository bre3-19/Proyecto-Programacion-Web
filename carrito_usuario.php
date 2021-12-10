<?php require_once('Connections/Conexion1.php');      
if(!isset($_SESSION['MM_Username'])){
	header('Location:acceso.php');
}
else {
	header('Location:carrito_lista.php');
}  
?>
