<?php require_once('Connections/Conexion1.php');      
$username = $_POST['strEmail'];  
$password = $_POST['strPassword'];  
$username = stripcslashes($username);  
$password = stripcslashes($password);  
$username = mysqli_real_escape_string($conn, $username);  
$password = mysqli_real_escape_string($conn, $password);  
      
$sql = "SELECT * FROM tblusuario WHERE strEmail = '$username' AND strPassword = '$password'"; 
$result = $conn->query($sql) or die($conn->error);	
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);  
$count = mysqli_num_rows($result);
        
if($count == 1){  
	$_SESSION['MM_Username']=$username;
	$_SESSION['MM_idUsuario']=$row["idUsuario"];
	session_start();
    header('Location:index.php');
} else {  
    header('Location:acceso_incorrecto.php'); 
} 
?>
