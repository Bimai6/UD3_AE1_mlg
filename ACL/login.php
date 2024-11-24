<?php
//Redireccionamos a la página index si se intenta acceder sin el método POST
if($_SERVER['REQUEST_METHOD']!= 'POST'){
    header("Location: index.php");
    exit; 
}

//Redireccionamos a la página index si no se han rellenado los campos con un mensaje de error
if(empty($_POST['username']) || empty($_POST["password"])){
    header("Location: index.php?error=Rellene los campos por favor.");
    exit; 
}
require_once 'db_config.php';

//Recuperamos los datos del formulario
$username=$_POST["username"];
$password=$_POST["password"];

global $bbdd;

//Consultamos la bbdd para verificar el user y el password
$query = "SELECT password, role_id FROM users WHERE user_name = ?";

//Bloque if que procesa la query en la base de datos
if ($stmt = $bbdd->prepare($query)) {
    //Pasa el nombre de usario como string
    $stmt->bind_param("s", $username);
    //Ejecuta el statement
    $stmt->execute();

    //Recogemos los resultados y los almacenamos en una variable
    $result = $stmt->get_result();

    //Para acceder a los valores del statement, convertimos la fila con los datos en un array asociativo
    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $encryptedPasswordfromBBDD = $row['password'];
        $role_id_from_bbdd = $row['role_id'];
    } else {
        header("Location: index.php?error=El nombre del usuario o la contraseña es incorrecta");
        exit;   
    }
    //Se cierra el statement
    $stmt->close();

} else{
    echo "Error en la consulta: " . $bbdd->error;
    exit;
}
//Verificamos si la password es correcta
if (hash("sha256",$password)==$encryptedPasswordfromBBDD){
    //iniciamos sesión
    session_start();
    //Se guardan en la sesión las siguientes variables
    $_SESSION["username"]=$username;
    $_SESSION["role_id"]=$role_id_from_bbdd;

    //Se redirige al usuario a la página protegida
    header("Location: protected.php");
    exit;
}else {
    //Mostramos un mensaje de error
    header("Location: index.php?error=El nombre del usuario o la contraseña es incorrecta");
    exit;
}