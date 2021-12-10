<?php require_once('Connections/Conexion1.php'); 
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

function GetValueString($conn, $theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
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

$varCategoria_Productos="0";
if(isset($_GET["cat"])) {
	$varCategoria_Productos=$_GET["cat"];
}
$conn->select_db($database_conn);
$queryProductos = sprintf("SELECT * FROM tblproducto WHERE tblproducto.intCategoria = %s", $varCategoria_Productos);
$DatosProductos = $conn->query($queryProductos) or die($mysqli->error);
$row_DatosProductos = $DatosProductos->fetch_assoc();
$totalRows_DatosProductos = $DatosProductos->num_rows;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/BasePrincipal.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Cat&aacute;logo</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->
<link href="styles/principal.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="container">
  <div class="header">
  <img src="images/logo.jpg" width="100%" height="150"/>
  <!-- end .header --></div>
  
  <ul>
	<li><a href="index.php">INICIO</a></li>
    <li><a href="#">TIENDA</a></li>
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
    <h1 style="text-align: center">Cat&aacute;logo</h1>
    
	<div class="resultado_producto">
	
	<?php do { ?>
		<div class="producto"><div class="imagenProd"><img src="docs/prods/<?php echo $row_DatosProductos['strImagen']; ?>" width="150" height="150" /></div>
		<div class ="textoProd">
		</br>
		<a href="ver_producto.php?recordID=<?php echo $row_DatosProductos['idProducto']; ?>"><?php echo $row_DatosProductos['strNombre']; ?></a>
		</br>
		Precio: $<?php echo $row_DatosProductos['dblPrecio']; ?></div>
		</div>
		
		<?php } while ($row_DatosProductos = $row_DatosProductos = $DatosProductos->fetch_assoc()); 
	?>
	</div>
  <!-- InstanceEndEditable --><!-- end .content --></div>
  <div class="footer">
    <p>&nbsp;</p>
    <p>Administraci&oacute;n E-commerce UABCS<br/>
      Encarnaci&oacute;n Varo 2021</p>
    <!-- end .footer --></div>
  <!-- end .container --></div>
</body>
<!-- InstanceEnd --></html>
