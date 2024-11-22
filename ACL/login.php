<?php

require_once 'db_config.php';

//Recuperamos los datos del formulario
$username=$_POST["username"];
$password=$_POST["password"];

global $bbdd;

//Consultamos la bbdd para verficar el user y el password
$query = "SELECT password, role_id FROM users WHERE user_name = ?";

if ($stmt = $bbdd->prepare($query)) {
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $encryptedPasswordfromBBDD = $row['password'];
        $role_id_from_bbdd = $row['role_id'];
    } else {
        echo "El nombre de usuario o la contraseña es incorrecta.";
        exit;
    }

    $stmt->close();

} else{
    echo "Error en la consulta: " . $bbdd->error;
    exit;
}
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