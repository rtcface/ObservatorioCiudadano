<?php
 


/* Variables Para tipos de errores */
$ErrorType = ["REQUIRED","INVALID","MATCH","OTHER","NONE","EMAIL"];

function validator_field_form($name_field,$errorType){
    $getMessage = "";   
        $getMessage = message_for_field_error_type($name_field, $errorType);       
    return error($getMessage);
}


/* Function return error */
function error($message){
    return $message;
}


function validate_empty_field($field,$label){
    if(empty($field)) return validator_field_form($label,"REQUIRED");    
    return false;
}

function checkNumber($number){
    if(!is_numeric($number)) return error("El campo solo acepta numeros");   
    return false;
}

function validate_form($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function sanitize_email($email){
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    return $email;
}

 function sanitize_string($string){
    $string = filter_var($string, FILTER_SANITIZE_STRING);
    return $string;
}
function validate_email($email){   
    if(!filter_var( $email, FILTER_VALIDATE_EMAIL)) return message_for_field("Email");
    return false;
}

function validate_emails_match($email,$confirmEmail){    
    if($email !== $confirmEmail) return message_for_field_error_type("ConfirmEmail","MATCH");
    return false;
}
  

function message_for_field($field){
    $message = "";
    switch($field){
        case "Email":
            $message = "Por favor introduzca una dirección de correo electrónico válida";
            break;
        case "ConfirmEmail":
            $message = "Por favor introduzca una dirección de correo electrónico válida";
            break;
        case "Phone":
            $message = "Por favor introduzca un Número Telefónico valido a 10 digitos";
            break;
                   
    }
    return $message;
}

function message_for_field_error_type($field,$errorType){
    $message = "";
    switch($errorType){
        case "REQUIRED":
            $message = "El campo $field es requerido";
            break;
        case "INVALID":
            $message = message_for_field($field);
            break;
        case "MATCH":
            $message = "Los correos no coinciden";
            break;
        case "OTHER":
            $message = "Ocurrio un error";
            break;
    }
    return $message;
}

function eliminar_acentos($cadena){
    strtoupper($cadena);
    //Reemplazamos la A y a
    $cadena = str_replace(
    array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
    array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
    $cadena
    );

    //Reemplazamos la E y e
    $cadena = str_replace(
    array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
    array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
    $cadena );

    //Reemplazamos la I y i
    $cadena = str_replace(
    array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
    array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
    $cadena );

    //Reemplazamos la O y o
    $cadena = str_replace(
    array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
    array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
    $cadena );

    //Reemplazamos la U y u
    $cadena = str_replace(
    array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
    array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
    $cadena );

    //Reemplazamos la N, n, C y c
    $cadena = str_replace(
    array('Ñ', 'ñ', 'Ç', 'ç'),
    array('N', 'n', 'C', 'c'),
    $cadena
    );
    
    return $cadena;
}