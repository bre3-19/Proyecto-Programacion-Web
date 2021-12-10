<?php require_once('Connections/Conexion1.php'); 
function GetSQLValueString($conn, $theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = mysqli_real_escape_string($conn, $theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

function loggedIn() {
	$cuenta="";
	$accion="";
	if(!isset($_SESSION['MM_Username'])){
		$cuenta="ACCEDER";
	}
	else {
		$cuenta="SALIR";
	}
	return $cuenta;
}

$insertSQL=sprintf("INSERT INTO tblcarrito (idUsuario, idProducto) VALUES (%s, %s)",
	GetSQLValueString($conn, $_SESSION['MM_idUsuario'], "int"),
	GetSQLValueString($conn, $_GET['recordID'], "int"));

$conn->select_db($database_conn);
$Recordset1 = $conn->query($insertSQL) or die($conn->error);

$insertGoTo="carrito_lista.php";
if(isset($_SERVER['QUERY_STRING'])) {
	$insertGoTo .= (strpos($insertGoTo, '?')) ? '&' : '?';
	$insertGoTo .= $_SERVER['QUERY_STRING'];
}
	
header(sprintf("Location: %s", $insertGoTo));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/BasePrincipal.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>P&aacute;gina de Inicio</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->
<link href="styles/principal.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="container">
  <div class="header">
  <img src="images/logo.jpg" width="100%" height="150" />
  <!-- end .header --></div>
  
  <ul>
	<li><a href="index.php">INICIO</a></li>
    <li><a href="categorias_productos.php?cat=8">TIENDA</a></li>
    <li><a href="carrito_usuario.php">MI CARRITO</a></li>
    <li><a href="usuario.php"><?php echo loggedIn() ?></a></li>
    <li></li>
  </ul>
  
  <div class="banner">
	<img src="images/banner.jpg" width="900" height="280" class="center"/>
  </div>
  
  <div class="sidebar1">
    <?php include("includes/categorias.php");?>
  </div>
  <div class="content"><!-- InstanceBeginEditable name="Contenido" -->
    <h1>P&aacute;gina de Inicio</h1>
    <p>Be aware</p>
  <!-- InstanceEndEditable --><!-- end .content --></div>
  <div class="footer">
    <p>&nbsp;</p>
    <p>Administraci&oacute;n E-commerce UABCS<br/>
      Encarnaci&oacute;n Varo 2021</p>
    <!-- end .footer --></div>
  <!-- end .container --></div>
</body>
<!-- InstanceEnd --></html>
