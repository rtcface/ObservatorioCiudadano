<?php 

include "./variables.php";



try{
    $db_connection = mysqli_connect($db_host, $db_user, $db_password, $db_name);
    
    if (!$db_connection) {
       die('No se ha podido conectar a la base de datos');
    }





}catch(Exception $e){
    echo $e->getMessage();
    die();
}



var_export($db_host, $db_user, $db_password, $db_name, $db_table_name)




?>