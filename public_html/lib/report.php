<?php
include "./variables.php";
$data = array();
try {

    $db = new mysqli($db_host, $db_user, $db_password, $db_name);
    if($db->connect_error){
        die("Unable to connect database: " . $db->connect_error);
    }
    
    //get user data from the database
    $query = $db->query("SELECT * FROM ".$db_table_name." WHERE cEstatus is null");
    
    if($query->num_rows > 0){
        $userData = $query->fetch_fields();
        $data['status'] = 'ok';
        $data['result'] = $userData;
    }else{
        $data['status'] = 'err';
        $data['result'] = 'No hay datos';
    }
    echo json_encode($data);

} catch (Exception $e) {
    $data['status'] = 'err';
    $data['result'] = 'Por el momento tenemos problemas con el servicio intente mas tarde'; 
   /*  echo 'Caught exception: ',  $e->getMessage(), "\n"; */
    echo json_encode($data);
    die();
}
//valida si hay datos si lo hay arma el json




/* Reporte de usuarios registrados */
/* $data = array();
$file = file_get_contents("../data/mock.json");
$users = json_decode($file, true);
$data['status'] = 'ok';
$data['result'] = $users;  
echo json_encode($data); */
/* $data['status'] = 'ok';
$data['result'] = []; */