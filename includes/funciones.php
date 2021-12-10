<?php


function NombreUsuario($id) {
	global $database_conn, $conn;
	
	$conn->select_db($database_conn);
	$query_ConsultaFuncion = sprintf("SELECT tblusuario.strNombre FROM tblusuario WHERE tblusuario.idUsuario=%s", $id, "text");
	
	$ConsultaFuncion= $conn->query($query_ConsultaFuncion) or die($conn->error);
	$row_ConsultaFuncion = $ConsultaFuncion->fetch_assoc();
	$totalRows_ConsultaFuncion = $ConsultaFuncion->num_rows;

	echo $row_ConsultaFuncion['strNombre'];
	$ConsultaFuncion->free_result();
	}
?>
