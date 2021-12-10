<?php require_once('../Connections/Conexion1.php'); ?>
<?php
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysqli_escape_string($theValue);

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

$conn->select_db($database_conn);
$query_Recordset1 = "SELECT * FROM tblcategoria ORDER BY tblcategoria.strDescripcion ASC";
$Recordset1 = $conn->query($query_Recordset1) or die($mysqli->error);
$row_Recordset1 = $Recordset1->fetch_assoc();
$totalRows_Recordset1 = $Recordset1->num_rows;
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
    <h1>Lista de Categor&iacute;as</h1>
    <p><a href="categorias_add.php">A&ntilde;adir categor&iacute;a</a></p>
    <table border="0" align="center" cellpadding="0" cellspacing="0" width="100%">
      <tr class="tablaprincipal">
        <td>Nombre de categor&iacute;a</td>
        <td>Acciones</td>
      </tr>
      <?php do { ?>
        <tr class="cursorarriba">
          <td><?php echo $row_Recordset1['strDescripcion']; ?></td>
          <td><a href="categorias_edit.php?recordID=<?php echo $row_Recordset1['idCategoria']; ?>">Editar</a></td>
        </tr>
        <?php } while ($row_Recordset1 = mysqli_fetch_assoc($Recordset1)); ?>
    </table>
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
mysql_free_result($Recordset1);
?>
