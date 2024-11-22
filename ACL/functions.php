<?php
require_once 'db_config.php';

function get_user_permissions($role_id)
{
    global $bbdd;  //Nos aseguramos que estamos usando la conexión a la bbdd global

    //Consulta la bbdd para obtener los permisos del rol
    $query = "SELECT p.permission_name FROM role_permissions rp INNER JOIN permissions p ON rp.permission_id=p.permission_id WHERE rp.role_id=?";

    //Preparamos y ejecutamos la consulta
    if ($stmt = $bbdd->prepare($query)) {
        $stmt->bind_param("i", $role_id);
        $stmt->execute();

        //Almacenar los resultados en un array
        $result = $stmt->get_result();
        $permissions = array();

        while ($row = $result->fetch_assoc()) {
            $permissions[] = $row['permission_name'];
        }

        //Cerramos la declaración
        $stmt->close();

        return $permissions;
    } else {
        //Mostramos un mensaje de error si la consulta falla
        echo "Error al consultar los permisos: " . $bbdd->error;
        return array();
    }
}