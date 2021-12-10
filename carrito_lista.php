<?php require_once('Connections/Conexion1.php'); 
function GetSQLValue($conn, $theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
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

function obtenerNombreProducto($conn, $idProd) {
	$query_Consulta=sprintf("SELECT strNombre FROM tblproducto WHERE idProducto = %s", $idProd);
	$DatosConsulta = $conn->query($query_Consulta) or die($conn->error);
	$row_DatosConsulta = $DatosConsulta->fetch_assoc();
	$totalRows_DatosConsulta = $DatosConsulta->num_rows;
	return $row_DatosConsulta['strNombre'];
	mysqli_free_result($DatosConsulta);
}

function obtenerPrecioProducto($conn, $idProd) {
	$query_Consulta=sprintf("SELECT dblPrecio FROM tblproducto WHERE idProducto = %s", $idProd);
	$DatosConsulta = $conn->query($query_Consulta) or die($conn->error);
	$row_DatosConsulta = $DatosConsulta->fetch_assoc();
	$totalRows_DatosConsulta = $DatosConsulta->num_rows;
	return $row_DatosConsulta['dblPrecio'];
	mysqli_free_result($DatosConsulta);
}

function obtenerIdCompra($conn, $idProd) {
	$query_Consulta=sprintf("SELECT idCompra FROM tblcarrito WHERE idProducto = %s", $idProd);
	$DatosConsulta = $conn->query($query_Consulta) or die($conn->error);
	$row_DatosConsulta = $DatosConsulta->fetch_assoc();
	$totalRows_DatosConsulta = $DatosConsulta->num_rows;
	return $row_DatosConsulta['idCompra'];
	mysqli_free_result($DatosConsulta);
}

$varUsuario_DatosCarrito="0";
if(isset($_SESSION['MM_idUsuario'])) {
	$varUsuario_DatosCarrito = $_SESSION['MM_idUsuario'];
}
$conn->select_db($database_conn);
$query_DatosCarrito=sprintf("SELECT * FROM tblcarrito WHERE tblcarrito.idUsuario = %s AND tblcarrito.intEfectuado = 0", GetSQLValue($conn, $varUsuario_DatosCarrito, "int"));
$DatosCarrito = $conn->query($query_DatosCarrito) or die($conn->error);
$row_DatosCarrito = $DatosCarrito->fetch_assoc();
$totalRows_DatosCarrito = $DatosCarrito->num_rows;
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
    <li><a href="#">MI CARRITO</a></li>
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
    <h1 style="text-align:center">Mi Carrito</h1>
		<?php if ($totalRows_DatosCarrito > 0) { ?>
		<table class="GeneratedTable">
			<tr>
				<td>Producto</td>
				<td>Precio</td>
				<td>Acciones</td>
			</tr>
			<?php $precioTotal = 0; ?>
			<?php do { ?>
			<tr>
				<td><?php echo obtenerNombreProducto($conn, $row_DatosCarrito['idProducto']); ?></td>
				<td><?php echo "$". obtenerPrecioProducto($conn, $row_DatosCarrito['idProducto']); ?></td>
				<td><a href="carrito_del.php?recordID=<?php echo obtenerIdCompra($conn, $row_DatosCarrito['idProducto']); ?>">Eliminar</a></td>
			</tr>
			<?php $precioTotal = $precioTotal + obtenerPrecioProducto($conn, $row_DatosCarrito['idProducto']); ?>
			<?php } while ($row_DatosCarrito = $DatosCarrito->fetch_assoc()) ?>
			<tr>
				<td align="right">Total:</td>
				<td><?php echo "$". $precioTotal; ?></td>
				<td><a href="realizar_compra.php">Pagar</a></td>
			</tr>
		</table>
		<a href="historial_compras.php">Historial de compras</a>
		<?php } else { ?>
		<h2 style="text-align:center">Usted no ha seleccionado ningun producto...</h2>
		<a href="historial_compras.php">Historial de compras</a>
		<?php } ?>
		
  <!-- InstanceEndEditable --><!-- end .content --></div>
  <div class="footer">
    <p>&nbsp;</p>
    <p>Administraci&oacute;n E-commerce UABCS<br/>
      Encarnaci&oacute;n Varo 2021</p>
    <!-- end .footer --></div>
  <!-- end .container --></div>
</body>
<!-- InstanceEnd --></html>
