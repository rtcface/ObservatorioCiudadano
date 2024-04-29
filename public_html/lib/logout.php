<?php 
$data = array();
session_start();
session_destroy();

$data['status'] = 'ok';
$data['result'] = 'Sesión cerrada';  
echo json_encode($data);
die();
?>