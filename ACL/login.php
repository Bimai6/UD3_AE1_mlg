<?php
//Recuperamos los datos del formulario
$username=$_POST["username"];
$password=$_POST["password"];

//Consultamos la bbdd para verficar el user y el password

//Verificamos si la password es correcta
if (hash("sha256",$password)==$encryptedPasswordfromBBDD){
    //iniciamos sesión
    session_start();
    $_SESSION["username"]=$username;
    $_SESSION["role_id"]=$role_id_from_bbdd;

    //Se redirige al usuario a la página protegida
    header("Location: protected.php");
    exit;
}else {
    //Mostramos un mensaje de error
    echo "El nombre del usuario o la contraseña es incorrecta";
}