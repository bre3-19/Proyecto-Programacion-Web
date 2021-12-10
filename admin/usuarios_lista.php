<?php require_once('../Connections/Conexion1.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

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
}

$conn->select_db($database_conn);
$query_DatosUsuario = "SELECT * FROM tblusuario ORDER BY tblusuario.strNombre ASC";
$DatosUsuario = $conn->query($query_DatosUsuario) or die($mysqli->error);
$row_DatosUsuario = $DatosUsuario->fetch_assoc();
$totalRows_DatosUsuario = $DatosUsuario->num_rows;
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
    <h1>Lista de Usuarios</h1>
    <p>&nbsp;    
    <table border="0" align="center" cellpadding="0" cellspacing="0" width="100%">
      <tr class="tablaprincipal">
        <td>ID</td>
        <td>Nombre</td>
        <td>Acciones</td>
      </tr>
      <?php do { ?>
        <tr  class="cursorarriba">
          <td><a href="usuarios_datos.php?recordID=<?php echo $row_DatosUsuario['idUsuario']; ?>"> <?php echo $row_DatosUsuario['idUsuario']; ?>&nbsp; </a></td>
          <td><?php echo $row_DatosUsuario['strNombre']; ?>&nbsp; </td>
          <td>Editar - Eliminar</td>
        </tr>
        <?php } while ($row_DatosUsuario = mysqli_fetch_assoc($DatosUsuario)); ?>
    </table>
    <br />
    <?php echo $totalRows_DatosUsuario ?> Records Total
    </p>
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
mysql_free_result($DatosUsuario);
?>
