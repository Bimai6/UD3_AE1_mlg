<?php
session_start();
require_once "functions.php";

//Comprobamos si el usuario ha iniciado sesión
if (!isset($_SESSION["username"])){
    header("Location: index.php");
    exit;
}

//Obtenemos los permisos del usuario
$permissions=get_user_permissions($_SESSION["role_id"]);

$nombre_del_rol= $_SESSION["role_id"] === 1 ? "Admin" : "User";

//Verificamos si el usuario tiene el permiso necesario
if (in_array("view_profile", $permissions)){
    //Mostramos el contenido del perfil para view_profile
    echo "<h1> Datos del usuario: </h1>";
    echo "<p> Rol del usuario:" . htmlspecialchars($nombre_del_rol) ." </p>";
    foreach($permissions as $p){
        echo "<p>  </p>";
    }

}else{
    //Mostramos un mensaje de error o lo redirigimos a otra página
}

//Destruimos la sesión
session_destroy();

//Redirigimos al usuario al formulario de inicio de sesión
header("Location: index.php");
exit;
?>