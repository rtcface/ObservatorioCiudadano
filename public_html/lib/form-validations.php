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
    return "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
    <strong>Error!</strong> $message
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";
}

function success($message){
    return "<div class='alert alert-success alert-dismissible fade show' role='alert'>
    <strong>Success!</strong> $message
    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";
}    

function validate_empty_field($field){
    if(empty($field)){
        return false;
    }
    return true;
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
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        return false;
    }
    return true;
}

function validate_emails_match($email,$confirmEmail){
    if($email !== $confirmEmail){
        return false;
    }
    return true;
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