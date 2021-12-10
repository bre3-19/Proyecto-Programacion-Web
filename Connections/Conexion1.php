<?php
if(!isset($_SESSION)) {
	session_start();
}
# FileName="Connection_php_mysql.htm"
# Type="MYSQLi"
# HTTP="true"
$hostname_conn = "127.0.0.1:3308";
$database_conn = "ecommerce";
$username_conn = "root";
$password_conn = "root";
$conn = new mysqli($hostname_conn, $username_conn, $password_conn, $database_conn); 
?>