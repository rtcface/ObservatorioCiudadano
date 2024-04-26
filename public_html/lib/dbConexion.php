<?php
  try {
    $db_connection = mysqli_connect($db_host, $db_user, $db_password, $db_name);
    if (!$db_connection) {
        $data['status'] = 'err';
        $data['result'] = 'Por el momento tenemos problemas con el servicio intente mas tarde'; 
        echo json_encode($data);                   
    die();
    return; 
    }
    $data['status'] = 'ok';
    $data['result'] = 'Conexion exitosa';
    echo json_encode($data);
    return;
    } catch (Exception $e) {
        echo 'Excepción capturada: ',  $e->getMessage(), "\n";
    }
    return;

    