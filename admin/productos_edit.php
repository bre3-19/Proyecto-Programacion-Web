<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQLi"
# HTTP="true"
$hostname_conn = "127.0.0.1:3308";
$database_conn = "ecommerce";
$username_conn = "root";
$password_conn = "root";
$conn = new mysqli($hostname_conn, $username_conn, $password_conn, $database_conn); 

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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE tblproducto SET strNombre=%s, strSEO=%s, dblPrecio=%s, intEstado=%s, intCategoria=%s, strImagen=%s WHERE idProducto=%s",
                       GetSQLValueString($conn, $_POST['strNombre'], "text"),
                       GetSQLValueString($conn, $_POST['strSEO'], "text"),
                       GetSQLValueString($conn, $_POST['dblPrecio'], "double"),
                       GetSQLValueString($conn, $_POST['intEstado'], "int"),
                       GetSQLValueString($conn, $_POST['intCategoria'], "int"),
                       GetSQLValueString($conn, $_POST['strImagen'], "text"),
                       GetSQLValueString($conn, $_POST['idProducto'], "int"));

  $conn->select_db($database_conn);
  $Result1 = $conn->query($updateSQL) or die($conn->error);

  $updateGoTo = "productos_lista.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$varProducto_DatosProducto = "0";
if (isset($_GET["recordID"])) {
  $varProducto_DatosProducto = $_GET["recordID"];
}
$conn->select_db($database_conn);
$query_DatosProducto = sprintf("SELECT * FROM tblproducto WHERE tblproducto.idProducto = %s", GetSQLValueString($conn, $varProducto_DatosProducto, "int"));
$DatosProducto = $conn->query($query_DatosProducto) or die($conn->error);
$row_DatosProducto = $DatosProducto->fetch_assoc();
$totalRows_DatosProducto = $DatosProducto->num_rows;

$conn->select_db($database_conn);
$query_ConsultaCategoria = "SELECT * FROM tblcategoria ORDER BY tblcategoria.strDescripcion ASC";
$ConsultaCategoria = $conn->query($query_ConsultaCategoria) or die($conn->error);
$row_ConsultaCategoria = $ConsultaCategoria->fetch_assoc();
$totalRows_ConsultaCategoria = $ConsultaCategoria->num_rows;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/BaseAdmin.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Administracion E-commerce</title>
<!-- InstanceEndEditable -->
<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->
<link href="../styles/admin.css" rel="stylesheet" type="text/css" />
</head>

<body>

<div class="container">
  <div class="header">
  <img src="../images/logo.jpg" width="100%" height="150" />
  <!-- end .header --></div>
  <div class="sidebar1">
    <?php include("../includes/cabeceraadmin.php");
?>
  <!-- end .sidebar1 --></div>
  <div class="content"><!-- InstanceBeginEditable name="Contenido" -->
 <script>
	function subirimagen() {
		self.name = 'opener';
		remote = open('gestionimagen.php', 'remote', 'width = 400, height = 150, location = no, scrollbars = yes, menubars = no, toolbars = no, resizable = yes, fullscreen = no, status = yes');
		remote.focus();
	}
</script>   
    
    <h1>Editar Producto</h1>
    <p>&nbsp;</p>
    <form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
      <table align="center">
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Nombre:</td>
          <td><input type="text" name="strNombre" value="<?php echo htmlentities($row_DatosProducto['strNombre'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">SEO:</td>
          <td><input type="text" name="strSEO" value="<?php echo htmlentities($row_DatosProducto['strSEO'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Precio:</td>
          <td><input type="text" name="dblPrecio" value="<?php echo htmlentities($row_DatosProducto['dblPrecio'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" /></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Imagen:</td>
          <td><input type="text" name="strImagen2" value="<?php echo htmlentities($row_DatosProducto['strImagen'], ENT_COMPAT, 'iso-8859-1'); ?>" size="32" />
            <input type="button" name="button" id="button" value="Subir Imagen" onclick="javascript:subirimagen();"/></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Estado:</td>
          <td><select name="intEstado">
            <option value="1" <?php if (!(strcmp(1, htmlentities($row_DatosProducto['intEstado'], ENT_COMPAT, 'iso-8859-1')))) {echo "SELECTED";} ?>>Activo</option>
            <option value="0" <?php if (!(strcmp(0, htmlentities($row_DatosProducto['intEstado'], ENT_COMPAT, 'iso-8859-1')))) {echo "SELECTED";} ?>>Inactivo</option>
          </select></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">Categoria:</td>
          <td><select name="intCategoria">
            <?php 
do {  
?>
            <option value="<?php echo $row_ConsultaCategoria['idCategoria']?>" <?php if (!(strcmp($row_ConsultaCategoria['idCategoria'], htmlentities($row_DatosProducto['intCategoria'], ENT_COMPAT, 'iso-8859-1')))) {echo "SELECTED";} ?>><?php echo $row_ConsultaCategoria['strDescripcion']?></option>
            <?php
} while ($row_ConsultaCategoria = mysqli_fetch_assoc($ConsultaCategoria));
?>
          </select></td>
        </tr>
        <tr valign="baseline">
          <td nowrap="nowrap" align="right">&nbsp;</td>
          <td><input type="submit" value="Actualizar Producto" /></td>
        </tr>
      </table>
      <input type="hidden" name="MM_update" value="form1" />
      <input type="hidden" name="idProducto" value="<?php echo $row_DatosProducto['idProducto']; ?>" />
    </form>
    <p>&nbsp;</p>
  <!-- InstanceEndEditable -->


    <!-- end .content --></div>
  <div class="footer">
    <p>&nbsp;</p>
    <p>Administraci&oacute;n E-commerce UABCS<br/>Encarnaci&oacute;n Varo 2021</p>
    <!-- end .footer --></div>
  <!-- end .container --></div>
</body>
<!-- InstanceEnd --></html>
<?php
mysqli_free_result($DatosProducto);

mysqli_free_result($ConsultaCategoria);
?>
