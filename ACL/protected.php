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

//Guardamos la información del usuario en cookies
setcookie("username", $_SESSION['username'], time() + (86400));
setcookie("role_id", $_SESSION['role_id'], time() + (86400));
setcookie("permissions", implode(", ", $permissions), time() + (86400));

//Verificamos si el usuario tiene el permiso necesario
if (in_array("view_profile", $permissions)){
    //Mostramos el contenido del perfil para view_profile
    echo "<h1> Bienvenido " . $_SESSION['username'] . "</h1>";
    echo "<p> Rol del usuario: " . htmlspecialchars($nombre_del_rol) ." </p>";
    echo "<p> Permisos del usuario:" . " </p>";
    if(in_array("edit_profile", $permissions)){
        echo '<p> Puedes <span style="color: blue">editar</span> tu perfil </p>';
    };
    if(in_array("view_profile", $permissions)){
        echo '<p> Puedes <span style="color: green">ver</span> tu perfil </p>';
    };
    if(in_array("delete_profile", $permissions)){
        echo '<p> Puedes <span style="color: red">borrar</span> tu perfil </p>';
    };

}else{
    //Mostramos un mensaje de error o lo redirigimos a otra página
    echo '<p style= "color: red"> No tienes el permiso para ver el perfil </p>';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="post">
        <button name="delete_cookies">Borrar Cookies</button>
        <button name="logout">Cerrar Sesión</button>
    </form>
    <?php
    // Borrar las cookies si se presiona el botón
    if (isset($_POST['delete_cookies'])) {
        setcookie("username", "", time() - 3600, "/");
        setcookie("role_id", "", time() - 3600, "/");
        setcookie("permissions", "", time() - 3600, "/");
        echo '<p style="color: green">Cookies eliminadas correctamente.</p>';
    }

    // Cerrar sesión si se presiona el botón
    if (isset($_POST['logout'])) {
        session_destroy();
        header("Location: index.php");
        exit;
    }
    ?>
</body>
</html>