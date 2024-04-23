<?php
    include("./lib/form-validations.php");
    include("./loadfile.php");

    $formValid = False;
   

    if(isset($_POST['save'])){
        /* escribe todos los campos que se envian en el post de este formulario*/
        if(isset($_POST['UserName']) && isset($_POST['LastName']) && isset($_POST['Email']) && isset($_POST['Phone']) && isset($_POST['Gender']) && isset($_POST['ConfirmEmail']) && isset($_POST['Reasons']) && isset($_POST['terminos']) && isset($_FILES['ComprobanteDomicilio']) && isset($_FILES['Ine'])){
            $UserName = $_POST['UserName'];
            $LastName = $_POST['LastName'];
            $Email = $_POST['Email'];
            $Phone = $_POST['Phone'];
            $Gender = $_POST['Gender'];
            $ConfirmEmail = $_POST['ConfirmEmail'];
            $Reasons = $_POST['Reasons'];
            $Terms = $_POST['terminos'];
            $ComprobanteDomicilio = $_FILES['ComprobanteDomicilio'];
            $Ine = $_FILES['Ine'];
            $formValid = True;
        }else{
            $Terms = [];        
        }
        
        
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
            class=" border border-1 rounded p-5 m-0 opacity-75" enctype="multipart/form-data">
            <div class="row align-items-center">
                <div class="mb-1 col">
                    <label for="UserName" class="form-label">Nombres</label>
                    <input type="text" class="form-control" style="text-transform: uppercase;" id="UserName"
                        name="UserName" value="<?php if(isset($UserName)) echo $UserName ?>">
                    <?php
                        if(isset($_POST['save'])){
                            if(empty($UserName)){                        
                            echo validator_field_form("Nombres",ErrorType::REQUIRED);   
                            $formValid=False;
                            }     
                    }           
                    ?>


                </div>
                <div class="mb-1 col">
                    <label for="LastName" class="form-label">Apellidos</label>
                    <input type="text" class="form-control" style="text-transform: uppercase;" id="LastName"
                        name="LastName" value="<?php if(isset($LastName)) echo $LastName ?>">
                    <?php
                    if(isset($_POST['save'])){                        
                        if(empty($LastName)){
                            echo validator_field_form("Apellidos",ErrorType::REQUIRED);    
                            $formValid=False;
                        }   
                    }                 
                    ?>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="mb-1 col">
                    <label for="Phone" class="form-label">Número Telefónico</label>
                    <input type="tel" maxlength="10" class="form-control" id="Phone" name="Phone"
                        value="<?php if(isset($Phone)) echo $Phone ?>">
                    <?php    
                    if(isset($_POST['save'])){                    
                        if(!empty($Phone)){
                            
                            $res=checkNumber($Phone);
                            
                            if($res) echo $res;

                            if(strlen($Phone) != 10){
                                echo validator_field_form("Phone",ErrorType::INVALID);   
                                $formValid=False;                            
                            }                                                       
                        }else{
                            echo validator_field_form("Número Telefónico",ErrorType::REQUIRED);  
                            $formValid=False;                 
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
                    <input type="email" style="text-transform: lowercase;" class="form-control" id="Email" name="Email"
                        value="<?php if(isset($Email)) echo $Email ?>">
                    <?php 
                    if(isset($_POST['save'])){                       
                        if(!empty($Email)){
                            if(validate_email($Email)){
                                if(!validate_emails_match($Email,$ConfirmEmail)){
                                    echo validator_field_form("ConfirmEmail",ErrorType::MATCH);
                                    $formValid=False;
                                }   
                            }else{
                                echo validator_field_form("Email",ErrorType::INVALID);
                                $formValid=False;
                            }
                        }else{
                            echo validator_field_form("Correo Electrónico",ErrorType::REQUIRED); 
                                $formValid=False;
                        }  
                    }                  
                    ?>
                </div>
                <div class="mb-1 col">
                    <label for="ConfirmEmail" class="form-label">Confirmar Correo Electrónico</label>
                    <input type="email" style="text-transform: lowercase;" class="form-control" id="ConfirmEmail"
                        name="ConfirmEmail" value="<?php if(isset($ConfirmEmail)) echo $ConfirmEmail ?>">
                    <?php
                    if(isset($_POST['save'])){                        
                        if(!empty($ConfirmEmail)){ 
                            if(validate_email($ConfirmEmail)){
                                if(!validate_emails_match($Email,$ConfirmEmail)){
                                    echo validator_field_form("ConfirmEmail",ErrorType::MATCH);
                                    $formValid=False;
                                }                                
                            }else{
                                echo validator_field_form("ConfirmEmail",ErrorType::INVALID);
                                $formValid=False;
                            }                          
                                                                   
                        }else{
                            echo validator_field_form("Confirmar Correo Electrónico",ErrorType::REQUIRED);
                            $formValid=False;                             
                        }
                    }                    
                    ?>
                </div>
            </div>
            <div class=" row align-items-center">
                <div class="mb-1 col">
                    <label for="Reasons" class="form-label">Menciona las razones por las cuales desea ser integrante
                        del
                        Observatorio Anticorrupción</label>
                    <textarea class="form-control" id="Reasons" rows="2" name="Reasons"
                        value="<?php if(isset($Reasons)) echo $Reasons ?>"></textarea>
                    <?php 
                    if(isset($_POST['save'])){                       
                        if(empty($Reasons)){
                            echo validator_field_form("Menciona las razones por las cuales desea ser integrante del
                            Observatorio Anticorrupción",ErrorType::REQUIRED);
                            $formValid=False;
                        }     
                    }               
                    ?>
                </div>
            </div>
            <div class="row align-items-center">
            </div>
            <div class="row align-items-center">
                <div class="mb-1 col">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="NoRegistrado" name="terminos[]"
                            id="NoRegistrado">
                        <label class="form-check-label" for="NoRegistrado">
                            No haber sido
                            registrado como candidata o candidato a cargo alguno de elección popular, en los tres
                            años
                            inmediatos anteriores a la postulación <span><em>(requerido)</em></span>
                        </label>
                    </div>
                    <?php 
                    if(isset($_POST['save'])){                       
                        if(!isset($_POST['terminos'])){
                            echo validator_field_form("No haber sido
                            registrado como candidata o candidato a cargo alguno de elección popular, en los tres años
                            inmediatos anteriores a la postulación",ErrorType::REQUIRED);
                            $formValid=False;
                        }else{
                            if(!in_array("NoRegistrado", $_POST['terminos'])){
                                echo validator_field_form("No haber sido
                                registrado como candidata o candidato a cargo alguno de elección popular, en los tres años
                                inmediatos anteriores a la postulación", ErrorType::REQUIRED);
                                $formValid=False;
                            }
                        }     
                    }               
                    ?>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="mb-1 col">Terms
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="NoCargo" name="terminos[]" id="NoCargo">
                        <label class="form-check-label" for="NoCargo">
                            No haber tenido cargo alguno de elección popular en los tres años inmediatos anteriores
                            a la
                            designación<span><em>(requerido)</em></span>
                        </label>
                    </div>
                    <?php 
                    if(isset($_POST['save'])){                       
                        if(!isset($_POST['terminos'])){
                            echo validator_field_form(" No haber tenido cargo alguno de elección popular en los tres años inmediatos anteriores a la
                            designación",ErrorType::REQUIRED);
                            $formValid=False;
                        }else{
                            if(!in_array("NoCargo", $_POST['terminos'])){
                                echo validator_field_form("No haber sido
                                registrado como candidata o candidato a cargo alguno de elección popular, en los tres años
                                inmediatos anteriores a la postulación", ErrorType::REQUIRED);
                                $formValid=False;
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
                            No haber sido dirigente nacional, estatal o municipal en algún partido político, en los
                            tres
                            años inmediatos anteriores a la designación.<span><em>(requerido)</em></span>
                        </label>
                    </div>
                    <?php 
                    if(isset($_POST['save'])){                       
                        if(!isset($_POST['terminos'])){
                            echo validator_field_form("No haber sido dirigente nacional, estatal o municipal en algún partido político, en los tres
                            años inmediatos anteriores a la designación.",ErrorType::REQUIRED);
                            $formValid=False;
                        }else{
                            if(!in_array("NoDirigente", $_POST['terminos'])){
                                echo validator_field_form("No haber sido dirigente nacional, estatal o municipal en algún partido político, en los tres
                                años inmediatos anteriores a la designación.", ErrorType::REQUIRED);
                                $formValid=False;
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
                            $formValid=False;
                        }else{
                            if(!in_array("NoServidor", $_POST['terminos'])){
                                echo validator_field_form("No ser servidora o servidor público", ErrorType::REQUIRED);
                                $formValid=False;
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
                            acuerdo que en los casos no previstos en las etapas del proceso de selección sean
                            resueltos
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
                            $formValid=False;
                        }else{
                            if(!in_array("Convocatoria", $_POST['terminos'])){
                                echo validator_field_form("He leído la Convocatoria para formar parte del Observatorio Anticorrupción y estoy de
                                acuerdo que en los casos no previstos en las etapas del proceso de selección sean resueltos
                                por la Secretaría Ejecutiva del Sistema Anticorrupción del Estado de
                                Tlaxcala.", ErrorType::REQUIRED);
                                $formValid=False;
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
                            $formValid=False;
                        }else{
                            if(!in_array("CartaCompromiso", $_POST['terminos'])){
                                echo validator_field_form("He leído la Carta Compromiso de integrantes del Observatorio Anticorrupción y estoy de
                                acuerdo con suscribirla en todos sus términos.", ErrorType::REQUIRED);
                                $formValid=False;
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
                    <?php
                    if(isset($_POST['save'])){
                        if(!isset($_FILES['Ine'])){
                            echo validator_field_form("Credencial para votar vigente por ambas caras (anverso y
                            reverso) expedida por el Instituto Nacional Electoral",ErrorType::REQUIRED);
                            $formValid=False;
                        }else{
                            $UserName = $_POST['UserName'];
                            $LastName = $_POST['LastName'];                         
                            $file_name_ine=$_FILES['Ine']['name'];
                            $file_size_ine=$_FILES['Ine']['size'];
                            $file_tmp_ine=$_FILES['Ine']['tmp_name'];
                            $file_type_ine=$_FILES['Ine']['type'];
                            $exp_ine=explode('.', $file_name_ine);
                            $end_ine=end($exp_ine);
                            $file_ext_ine=strtolower($end_ine);
                          
                            $extensions_ine= array("jpeg","jpg","png","pdf");
                            $file_sn_ine=str_replace(" ", "_", $UserName." ".$LastName);
                            $file_sn_ine=strtolower($file_sn_ine);
                            $file_save_name_ine="INE_".$file_sn_ine.".".$file_ext_ine;
                            if(in_array($file_ext_ine, $extensions_ine)=== False){
                                echo validator_field_form("El archivo debe ser una imagen o un pdf", ErrorType::REQUIRED);
                                $formValid=False;
                            }
                            if($file_size_ine > 2097152){
                                echo validator_field_form("El archivo debe ser menor a 2MB", ErrorType::REQUIRED);
                                $formValid=False;
                            }
                            
                        }        
                    }                       
                    ?>

                </div>
            </div>
            <div class="row align-items-center">
                <div class="mb-1 col">
                    <label for="ComprobanteDomicilio" class="form-label">Comprobante de domicilio no mayor a tres
                        meses</label>
                    <input type="file" class="form-control" id="ComprobanteDomicilio" name="ComprobanteDomicilio"
                        accept=".jpg, .jpeg, .png, .jpeg, .pdf">
                    <?php
                    if(isset($_POST['save'])){
                        if(!isset($_FILES['ComprobanteDomicilio'])){
                            echo validator_field_form("Comprobante de domicilio no mayor a tres
                            meses",ErrorType::REQUIRED);
                            $formValid=False;
                        }else
                        {
                            $UserName = $_POST['UserName'];
                            $LastName = $_POST['LastName'];                         
                            $file_name_cd=$_FILES['ComprobanteDomicilio']['name'];
                            $file_size_cd=$_FILES['ComprobanteDomicilio']['size'];
                            $file_tmp_cd=$_FILES['ComprobanteDomicilio']['tmp_name'];
                            $file_type_cd=$_FILES['ComprobanteDomicilio']['type'];
                            $exp_cd=explode('.', $file_name_cd);
                            $end_cd=end($exp_cd);
                            $file_ext_cd=strtolower($end_cd);
                          
                            $extensions_cd= array("jpeg","jpg","png","pdf");
                            $file_sn_cd=str_replace(" ", "_", $UserName." ".$LastName);
                            $file_sn_cd=strtolower($file_sn_cd);
                            $file_save_name_cd="CD_".$file_sn_cd.".".$file_ext_cd;
                            if(in_array($file_ext_cd, $extensions_cd)=== False){
                                echo validator_field_form("El archivo debe ser una imagen o un pdf", ErrorType::REQUIRED);
                                $formValid=False;
                            }
                            if($file_size_cd > 2097152){
                                echo validator_field_form("El archivo debe ser menor a 2MB", ErrorType::REQUIRED);
                                $formValid=False;
                            }
                            
 
                        }    
                    }                   
                   ?>
                </div>
            </div>

            <div class="row align-items-center mt-3">
                <button type="submit" class="btn btn-primary" name="save">Enviar Información</button>
                <?php
                if($formValid){
                  
                    $url_ine="";
                    while($url_ine===""){
                    $url_ine=uploadFile($file_tmp_ine,$file_save_name_ine,$file_type_ine);
                    }
                    echo "<p>".$url_ine."</p>";
                    $url_cd="";
                    while($url_cd===""){
                     $url_cd=uploadFile($file_tmp_cd,$file_save_name_cd,$file_type_cd);
                    }
                    echo "<p>".$url_cd."</p>";
                    echo "<p> UserName:-".$UserName."</p>";
                    echo "<p> LastName:-".$LastName."</p>";
                    echo "<p> Email:-".$Email."</p>";
                    echo "<p> Phone:-".$Phone."</p>";
                    echo "<p> Gender:-".$Gender."</p>";
                    echo "<p> ConfirmEmail:-".$ConfirmEmail."</p>";
                    echo "<p> Reasons:-".$Reasons."</p>";
                    echo "<p> Terms:-".count($Terms)."</p>";
                    echo success("La informacion se envio correctamente");                               
                }else{
                    echo error("Faltan campos por llenar");
                }
                ?>
            </div>
        </form>
    </div>
    <script src="./assets/js/bootstrap.min.js"></script>


</body>

</html>