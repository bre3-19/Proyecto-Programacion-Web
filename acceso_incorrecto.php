<?php require_once('Connections/Conexion1.php'); ?>
<?php
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

function alert($msg) {
	echo "<script type='text/javascript'>alert('$msg');</script>";
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/BasePrincipal.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Acceso de Usuario</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
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
  
  <div class="content"><!-- InstanceBeginEditable name="Contenido" -->
    
	<div class="login">
		<h1>Acceso de usuario</h1>
		<form action="autenticar.php" method="post", name="form1" id="form1">
			<p style="text-align: center">Usuario o contraseña no encontrados, ya tiene una <a href="alta_usuario.php">cuenta?</a></p>
			
			Email:</br>
			<span id="sprytextfield1">
			<p><input type="text" name="strEmail" value="" size="32" /></p>
			<span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldInvalidFormatMsg">Invalid format.</span></span></td>
			Contrase&ntilde;a:</br>
			<p><input type="password" name="strPassword" value="" size="32" /></p>
			<input type="submit" value="Iniciar sesi&oacute;n">
			<input type="hidden" name="MM_insert" value="form1" />
		</form>
	</div>
	
    <p>&nbsp;</p>
    <script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "email");
    </script>
  <!-- InstanceEndEditable --><!-- end .content --></div>
  <div class="footer">
    <p>&nbsp;</p>
    <p>Administraci&oacute;n E-commerce UABCS<br/>
      Encarnaci&oacute;n Varo 2021</p>
    <!-- end .footer --></div>
  <!-- end .container --></div>
</body>
<!-- InstanceEnd --></html>
