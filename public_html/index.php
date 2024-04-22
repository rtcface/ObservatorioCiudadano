<?php
    include("./lib/form-validations.php");
    include './api-google/vendor/autoload.php';
putenv('GOOGLE_APPLICATION_CREDENTIALS=credentials.json');
$client = new Google_Client();
$client->useApplicationDefaultCredentials();
$client->SetScopes(['https://www.googleapis.com/auth/drive.file']);
try {
    //code...
    $drive = new Google_Service_Drive($client);
    $file_path = './test.png';
    $file = new Google_Service_Drive_DriveFile();
    $file->setName('test.png');
    $file->setParents(array("1n4JT1pO1-CU0DDTIoLch2r9RWvFVH8r4"));
    $file->setDescription('test.png');
    $file->setMimeType('image/png');
    $result = $drive->files->create(
        $file, array(
            'data' => file_get_contents($file_path),
            'mimeType' => 'image/png',
            'uploadType' => 'media')
        );
} catch (Google_Sevice_Exception $gs) {

    $message = json_decode($gs->getMessage());
    echo $message->error->message;
} catch (Exception $e) {
    //throw $th;
    echo $e->getMessage();
}





    if(isset($_POST['save'])){
        /* escribe todos los campos que se envian en el post de este formulario*/
        $UserName = $_POST['UserName'];
        $LastName = $_POST['LastName'];
        $Email = $_POST['Email'];
        $Phone = $_POST['Phone'];
        $Gender = $_POST['Gender'];
        $ConfirmEmail = $_POST['ConfirmEmail'];
        $Reasons = $_POST['Reasons'];
    }
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/normalize/normalize.css">

    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/estilos.css">
    <title>Document</title>
</head>

<body>
    <div class="container">
        <h1 class="mb-3 mt-5">Registro de Observatorios Ciudadanos </h1>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST"
            class=" border border-1 rounded p-5 m-0 opacity-75">
            <div class="row align-items-center">
                <div class="mb-1 col">
                    <label for="UserName" class="form-label">Nombres</label>
                    <input type="text" class="form-control" style="text-transform: uppercase;" id="UserName"
                        name="UserName">
                    <?php
                        if(isset($_POST['save'])){
                            if(empty($UserName)){                        
                            echo validator_field_form("Nombres",ErrorType::REQUIRED);    
                            }     
                    }           
                    ?>


                </div>
                <div class="mb-1 col">
                    <label for="LastName" class="form-label">Apellidos</label>
                    <input type="text" class="form-control" style="text-transform: uppercase;" id="LastName"
                        name="LastName">
                    <?php
                    if(isset($_POST['save'])){                        
                        if(empty($LastName)){
                            echo validator_field_form("Apellidos",ErrorType::REQUIRED);    
                        }   
                    }                 
                    ?>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="mb-1 col">
                    <label for="Phone" class="form-label">Número Telefónico</label>
                    <input type="tel" maxlength="10" class="form-control" id="Phone" name="Phone" pattern="[0-9]{10}">
                    <?php    
                    if(isset($_POST['save'])){                    
                        if(!empty($Phone)){
                            if(strlen($Phone) != 10){
                                echo validator_field_form("Phone",ErrorType::INVALID);                               
                            }                                                       
                        }else{
                            echo validator_field_form("Número Telefónico",ErrorType::REQUIRED);                   
                        }
                    }
                    ?>
                </div>
                <div class="mb-1 col">
                    <label for="Gender" class="form-label">Genero <span><em>(requerido para fines
                                estadisticos)</em></span></label>
                    <select type="text" id="Gender" name="Gender" class="form-control">
                        <option value="mujer">Mujer</option>
                        <option value="hombre">Hombre</option>
                        <option value="nobinario">No binario</option>
                    </select>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="mb-1 col">
                    <label for="Email" class="form-label">Correo Electrónico</label>
                    <input type="email" style="text-transform: lowercase;" class="form-control" id="Email" name="Email">
                    <?php 
                    if(isset($_POST['save'])){                       
                        if(!empty($Email)){
                            if(validate_email($Email)){
                                if(!validate_emails_match($Email,$ConfirmEmail)){
                                    echo validator_field_form("ConfirmEmail",ErrorType::MATCH);
                                }   
                            }else{
                                echo validator_field_form("Email",ErrorType::INVALID);

                            }
                        }else{
                            echo validator_field_form("Correo Electrónico",ErrorType::REQUIRED); 
                        }  
                    }                  
                    ?>
                </div>
                <div class="mb-1 col">
                    <label for="ConfirmEmail" class="form-label">Confirmar Correo Electrónico</label>
                    <input type="email" style="text-transform: lowercase;" class="form-control" id="ConfirmEmail"
                        name="ConfirmEmail">
                    <?php
                    if(isset($_POST['save'])){                        
                        if(!empty($ConfirmEmail)){ 
                            if(validate_email($ConfirmEmail)){
                                if(!validate_emails_match($Email,$ConfirmEmail)){
                                    echo validator_field_form("ConfirmEmail",ErrorType::MATCH);
                                }                                
                            }else{
                                echo validator_field_form("ConfirmEmail",ErrorType::INVALID);
                            }                          
                                                                   
                        }else{
                            echo validator_field_form("Confirmar Correo Electrónico",ErrorType::REQUIRED);                             
                        }
                    }                    
                    ?>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="mb-1 col">
                    <label for="Reasons" class="form-label">Menciona las razones por las cuales desea ser integrante del
                        Observatorio Anticorrupción</label>
                    <textarea class="form-control" id="Reasons" rows="2" name="Reasons"></textarea>
                    <?php 
                    if(isset($_POST['save'])){                       
                        if(empty($Reasons)){
                            echo validator_field_form("Menciona las razones por las cuales desea ser integrante del
                            Observatorio Anticorrupción",ErrorType::REQUIRED);
                        }     
                    }               
                    ?>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="mb-1 col">
                    <h3>Declaro bajo protesta de decir verdad: <span><em>(requerido)</em></span></h3>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="mb-1 col">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="NoRegistrado" name="terminos[]"
                            id="NoRegistrado">
                        <label class="form-check-label" for="NoRegistrado">
                            No haber sido
                            registrado como candidata o candidato a cargo alguno de elección popular, en los tres años
                            inmediatos anteriores a la postulación <span><em>(requerido)</em></span>
                        </label>
                    </div>
                    <?php 
                    if(isset($_POST['save'])){                       
                        if(!isset($_POST['terminos'])){
                            echo validator_field_form("No haber sido
                            registrado como candidata o candidato a cargo alguno de elección popular, en los tres años
                            inmediatos anteriores a la postulación",ErrorType::REQUIRED);
                        }else{
                            if(!in_array("NoRegistrado", $_POST['terminos'])){
                                echo validator_field_form("No haber sido
                                registrado como candidata o candidato a cargo alguno de elección popular, en los tres años
                                inmediatos anteriores a la postulación", ErrorType::REQUIRED);
                            }
                        }     
                    }               
                    ?>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="mb-1 col">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="NoCargo" name="terminos[]" id="NoCargo">
                        <label class="form-check-label" for="NoCargo">
                            No haber tenido cargo alguno de elección popular en los tres años inmediatos anteriores a la
                            designación<span><em>(requerido)</em></span>
                        </label>
                    </div>
                    <?php 
                    if(isset($_POST['save'])){                       
                        if(!isset($_POST['terminos'])){
                            echo validator_field_form(" No haber tenido cargo alguno de elección popular en los tres años inmediatos anteriores a la
                            designación",ErrorType::REQUIRED);
                        }else{
                            if(!in_array("NoCargo", $_POST['terminos'])){
                                echo validator_field_form("No haber sido
                                registrado como candidata o candidato a cargo alguno de elección popular, en los tres años
                                inmediatos anteriores a la postulación", ErrorType::REQUIRED);
                            }
                        }     
                    }               
                    ?>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="mb-1 col">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="NoDirigente" name="terminos[]"
                            id="NoDirigente">
                        <label class="form-check-label" for="NoDirigente">
                            No haber sido dirigente nacional, estatal o municipal en algún partido político, en los tres
                            años inmediatos anteriores a la designación.<span><em>(requerido)</em></span>
                        </label>
                    </div>
                    <?php 
                    if(isset($_POST['save'])){                       
                        if(!isset($_POST['terminos'])){
                            echo validator_field_form("No haber sido dirigente nacional, estatal o municipal en algún partido político, en los tres
                            años inmediatos anteriores a la designación.",ErrorType::REQUIRED);
                        }else{
                            if(!in_array("NoDirigente", $_POST['terminos'])){
                                echo validator_field_form("No haber sido dirigente nacional, estatal o municipal en algún partido político, en los tres
                                años inmediatos anteriores a la designación.", ErrorType::REQUIRED);
                            }
                        }     
                    }               
                    ?>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="mb-1 col">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="NoServidor" name="terminos[]"
                            id="NoServidor">
                        <label class="form-check-label" for="NoServidor">
                            No ser servidora o servidor público<span><em>(requerido)</em></span>
                        </label>
                    </div>
                    <?php 
                    if(isset($_POST['save'])){                       
                        if(!isset($_POST['terminos'])){
                            echo validator_field_form("No ser servidora o servidor público",ErrorType::REQUIRED);
                        }else{
                            if(!in_array("NoServidor", $_POST['terminos'])){
                                echo validator_field_form("No ser servidora o servidor público", ErrorType::REQUIRED);
                            }
                        }     
                    }               
                    ?>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="mb-1 col">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="Convocatoria" name="terminos[]"
                            id="Convocatoria">
                        <label class="form-check-label" for="Convocatoria">
                            He leído la Convocatoria para formar parte del Observatorio Anticorrupción y estoy de
                            acuerdo que en los casos no previstos en las etapas del proceso de selección sean resueltos
                            por la Secretaría Ejecutiva del Sistema Anticorrupción del Estado de
                            Tlaxcala.<span><em>(requerido)</em></span>
                        </label>
                    </div>
                    <?php 
                    if(isset($_POST['save'])){                       
                        if(!isset($_POST['terminos'])){
                            echo validator_field_form("He leído la Convocatoria para formar parte del Observatorio Anticorrupción y estoy de
                            acuerdo que en los casos no previstos en las etapas del proceso de selección sean resueltos
                            por la Secretaría Ejecutiva del Sistema Anticorrupción del Estado de
                            Tlaxcala.",ErrorType::REQUIRED);
                        }else{
                            if(!in_array("Convocatoria", $_POST['terminos'])){
                                echo validator_field_form("He leído la Convocatoria para formar parte del Observatorio Anticorrupción y estoy de
                                acuerdo que en los casos no previstos en las etapas del proceso de selección sean resueltos
                                por la Secretaría Ejecutiva del Sistema Anticorrupción del Estado de
                                Tlaxcala.", ErrorType::REQUIRED);
                            }
                        }     
                    }               
                    ?>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="mb-1 col">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="CartaCompromiso" name="terminos[]"
                            id="CartaCompromiso">
                        <label class="form-check-label" for="CartaCompromiso">
                            He leído la Carta Compromiso de integrantes del Observatorio Anticorrupción y estoy de
                            acuerdo con suscribirla en todos sus términos.<span><em>(requerido)</em></span>
                        </label>
                    </div>
                    <?php 
                    if(isset($_POST['save'])){                       
                        if(!isset($_POST['terminos'])){
                            echo validator_field_form("He leído la Carta Compromiso de integrantes del Observatorio Anticorrupción y estoy de
                            acuerdo con suscribirla en todos sus términos.",ErrorType::REQUIRED);
                        }else{
                            if(!in_array("CartaCompromiso", $_POST['terminos'])){
                                echo validator_field_form("He leído la Carta Compromiso de integrantes del Observatorio Anticorrupción y estoy de
                                acuerdo con suscribirla en todos sus términos.", ErrorType::REQUIRED);
                            }
                        }     
                    }               
                    ?>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="mb-1 col">
                    <h3>
                        Por favor, adjunta los documentos siguientes:
                    </h3>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="mb-1 col">
                    <label for="Ine" class="form-label">Credencial para votar vigente por ambas caras (anverso y
                        reverso) expedida por el Instituto Nacional Electoral</label>
                    <input type="file" class="form-control" id="Ine" name="Ine" accept=".jpg, .jpeg, .png, .jpeg, .pdf">
                    <div id="errorHelp" class="form-text visually-hidden">We'll never share your email with anyone else.
                    </div>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="mb-1 col">
                    <label for="ComprobanteDomicilio" class="form-label">Comprobante de domicilio no mayor a tres
                        meses</label>
                    <input type="file" class="form-control" id="ComprobanteDomicilio" name="ComprobanteDomicilio"
                        accept=".jpg, .jpeg, .png, .jpeg, .pdf">
                    <div id="errorHelp" class="form-text visually-hidden">We'll never share your email with anyone else.
                    </div>
                </div>
            </div>

            <div class="row align-items-center mt-3">
                <button type="submit" class="btn btn-primary" name="save">Enviar Información</button>
            </div>
        </form>
    </div>
    <script src="./assets/js/bootstrap.min.js"></script>


</body>

</html>