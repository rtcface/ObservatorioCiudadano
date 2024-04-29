<?php
 session_start();
 $local_user="root";
 $local_pass="123";
 $data = array();
 
 $user = $_POST['user'];
 $pass = $_POST['pass'];
 if($local_user == $user && $local_pass == $pass){   
    $_SESSION["user"] = $user;
    $data['status'] = 'ok';
    $data['result'] = 'Los Datos son correctos';  
    echo json_encode($data);
    die();  
}else{
    $data['status'] = 'err';
    $data['result'] = 'Usuario o contraseña incorrectos';
    echo json_encode($data);
    die();
}