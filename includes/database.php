<?php
//configurar la conexion a la base de datos
//cadena de conexion
$host = 'localhost'; //servidor de la base de datos
$usuario = 'root'; //usuario de la base de datos
$contraseña  = ''; //clave de la base de datos
$base_datos = 'bdtecnosoluciones'; //nombre de la base de datos


//crear la conexion
$conn=new mysqli($host,$usuario,$contraseña,$base_datos);
//verificar la conexion
if($conn-> connect_error){
    die("Error de conexion: ".$conn->connect_error);
}
$conn->set_charset("utf8");


?>