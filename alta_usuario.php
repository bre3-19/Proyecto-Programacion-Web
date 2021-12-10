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

$MM_flag="MM_insert";
if(isset($_POST[$MM_flag])) {
	$MM_dupKeyRedirect="alta_usuario_error.php";
	$loginUsername=$_POST['strEmail'];
	$loginRS_query=sprintf("SELECT strEmail FROM tblusuario WHERE strEmail=%s", GetSQLValueString($conn, $loginUsername, "text"));
	$conn->select_db($database_conn);
	$loginRS = $conn->query($loginRS_query) or die($conn->error);
	$loginFoundUser=$loginRS->num_rows;
	
	if($loginFoundUser) {
		$MM_qsChar="?";
		$MM_dupKeyRedirect = $MM_dupKeyRedirect . $MM_qsChar ."requsername=".$loginUsername;
		header("location: $MM_dupKeyRedirect");
		exit;
	}
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	if ($_POST["strPassword"] == $_POST["strPassword2"]) {
		$insertSQL = sprintf("INSERT INTO tblusuario (strNombre, strEmail, intActivo, strPassword) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($conn, $_POST['strNombre'], "text"),
                       GetSQLValueString($conn, $_POST['strEmail'], "text"),
                       GetSQLValueString($conn, $_POST['strActivo'], "int"),
                       GetSQLValueString($conn, $_POST['strPassword'], "text"));

		$conn->select_db($database_conn);
		$Result1 = $conn->query($insertSQL) or die($conn->error);

		$insertGoTo = "index.php";
		if (isset($_SERVER['QUERY_STRING'])) {
			$insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
			$insertGoTo .= $_SERVER['QUERY_STRING'];
		}
		header(sprintf("Location: %s", $insertGoTo));
		}
		else {
			alert("Las contraseñas no coinciden");
        } 
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/BaseFormularios.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Registro de usuario</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
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
  
  <div class="content">
    <!-- InstanceBeginEditable name="Titulo" -->
    <!-- InstanceEndEditable -->
    <!-- InstanceBeginEditable name="Contenido" -->
    <div class="login">
		<h1>Registro de Usuario</h1>
		<form action="<?php echo $editFormAction; ?>" method="post", name="form1" id="form1">
			Nombre:</br>
			<input type="text" name="strNombre" value="" size="32" /></br>
			<p>Email:</p>
			<span id="sprytextfield1">
			<input type="text" name="strEmail" value="" size="32" /></br>
			<span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldInvalidFormatMsg">Invalid format.</span></span></td>
			Contrase&ntilde;a:</br>
			<input type="password" name="strPassword" value="" size="32" /></br>
			Repetir contrase&ntilde;a:</br>
			<input type="password" name="strPassword2" value="" size="32" /></br>
			
			<input type="submit" value="Registrarse">
			<input type="hidden" name="strActivo" value="1" />
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
