<?php
// Debes cambiar los valores según la configuración de la bbdd
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'my_bbdd';

//Creamos la conexión a la bbdd
$bbdd = new mysqli($db_host, $db_user, $db_pass, $db_name);

//Verificamos la conexión
if ($bbdd->connect_error){
    die('Error de conexión a la base de datos:' . $db->connect_error);
} else{
    echo "Se estableció la conexión correctamente";
}
?>