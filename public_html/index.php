<?php
    include("./lib/form-validations.php");
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
                        if(empty($UserName)){                        
                        echo validator_field_form("Nombres",ErrorType::REQUIRED);    
                        }                
                    ?>


                </div>
                <div class="mb-1 col">
                    <label for="LastName" class="form-label">Apellidos</label>
                    <input type="text" class="form-control" style="text-transform: uppercase;" id="LastName"
                        name="LastName">
                    <?php                        
                        if(empty($LastName)){
                            echo validator_field_form("Apellidos",ErrorType::REQUIRED);    
                        }                    
                    ?>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="mb-1 col">
                    <label for="Phone" class="form-label">Número Telefónico</label>
                    <input type="number" maxlength="10" class="form-control" id="Phone" name="Phone"
                        pattern="[0-9]{10}">
                    <?php                        
                        if(!empty($Phone)){
                            if(strlen($Phone) != 10){
                                echo validator_field_form("Phone",ErrorType::INVALID);                               
                            }                                                       
                        }else{
                            echo validator_field_form("Número Telefónico",ErrorType::REQUIRED);                   
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
                    ?>
                </div>
                <div class="mb-1 col">
                    <label for="ConfirmEmail" class="form-label">Confirmar Correo Electrónico</label>
                    <input type="email" style="text-transform: lowercase;" class="form-control" id="ConfirmEmail"
                        name="ConfirmEmail">
                    <?php                        
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
                    ?>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="mb-1 col">
                    <label for="Reasons" class="form-label">Menciona las razones por las cuales desea ser integrante del
                        Observatorio Anticorrupción</label>
                    <textarea class="form-control" id="Reasons" rows="2" name="Reasons"></textarea>
                    <?php                        
                        if(empty($Reasons)){
                            echo validator_field_form("Menciona las razones por las cuales desea ser integrante del
                            Observatorio Anticorrupción",ErrorType::REQUIRED);
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
                        <input class="form-check-input" type="checkbox" value="" name="NoRegistrado" id="NoRegistrado">
                        <label class="form-check-label" for="NoRegistrado">
                            No haber sido
                            registrado como candidata o candidato a cargo alguno de elección popular, en los tres años
                            inmediatos anteriores a la postulación <span><em>(requerido)</em></span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="mb-1 col">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" name="NoCargo" id="NoCargo">
                        <label class="form-check-label" for="NoCargo">
                            No haber tenido cargo alguno de elección popular en los tres años inmediatos anteriores a la
                            designación<span><em>(requerido)</em></span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="mb-1 col">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" name="NoDirigente" id="NoDirigente">
                        <label class="form-check-label" for="NoDirigente">
                            No haber sido dirigente nacional, estatal o municipal en algún partido político, en los tres
                            años inmediatos anteriores a la designación<span><em>(requerido)</em></span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="mb-1 col">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" name="noservidor" id="noservidor">
                        <label class="form-check-label" for="noservidor">
                            No ser servidora o servidor público<span><em>(requerido)</em></span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="mb-1 col">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" name="Convocatoria" id="Convocatoria">
                        <label class="form-check-label" for="Convocatoria">
                            He leído la Convocatoria para formar parte del Observatorio Anticorrupción y estoy de
                            acuerdo que en los casos no previstos en las etapas del proceso de selección sean resueltos
                            por la Secretaría Ejecutiva del Sistema Anticorrupción del Estado de
                            Tlaxcala.<span><em>(requerido)</em></span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="mb-1 col">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" name="CartaCompromiso"
                            id="CartaCompromiso">
                        <label class="form-check-label" for="CartaCompromiso">
                            He leído la Carta Compromiso de integrantes del Observatorio Anticorrupción y estoy de
                            acuerdo con suscribirla en todos sus términos.<span><em>(requerido)</em></span>
                        </label>
                    </div>
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