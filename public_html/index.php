<?php
    include("./lib/form-validations.php");
    include("./loadfile.php");
    include "./lib/variables.php";



    $formValid = False;
   

    if(isset($_POST['save'])){
        /* escribe todos los campos que se envian en el post de este formulario*/
        if(isset($_POST['UserName']) && isset($_POST['LastName']) && isset($_POST['Email']) && isset($_POST['Phone']) && isset($_POST['Gender']) && isset($_POST['ConfirmEmail']) && isset($_POST['Reasons']) && isset($_POST['terminos']) && isset($_FILES['ComprobanteDomicilio']) && isset($_FILES['Ine'])){
            $UserName = strtoupper($_POST['UserName']);
            $LastName = strtoupper($_POST['LastName']);
            $Email = strtolower($_POST['Email']);
            $Phone = strtoupper($_POST['Phone']);
            $Gender = strtoupper($_POST['Gender']);
            $ConfirmEmail = strtolower($_POST['ConfirmEmail']);
            $Reasons = strtoupper($_POST['Reasons']);
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
<html lang="es" id="resultado">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/normalize/normalize.css">

    <link rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/estilos.css">
    <title>Registro de Observatorios Ciudadanos</title>
    <link rel="icon" type="image/x-icon"
        href="https://saetlax.org/wp-content/uploads/2019/04/cropped-Logo_SAETLAX-15-150x150.png">
</head>

<body>
    <div class="container">
        <div class="header-register">
            <div class="logo">
                <img src="./assets/img/logo.png" alt="Header register">
            </div>
        </div>
        <h1 class="mb-3 mt-1">Registro de Observatorios Ciudadanos </h1>
        <form id="register" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>"
            method="POST" class=" border border-1 rounded p-5 m-0 opacity-75">
            <div class="row align-items-center">
                <div class="mb-1 col">
                    <label for="UserName" class="form-label">Nombres</label>
                    <input type="text" class="form-control" style="text-transform: uppercase;" id="UserName"
                        name="UserName" value="<?php if(isset($UserName)){ echo $UserName; } else { echo ""; } ?>">
                    <?php
                        if(isset($_POST['save'])){
                            if(empty($UserName)){                        
                            echo validator_field_form("Nombres","REQUIRED");   
                            $formValid=False;
                            }     
                    }           
                    ?>
                    <div id="err_name"></div>
                </div>
                <div class="mb-1 col">
                    <label for="LastName" class="form-label">Apellidos</label>
                    <input type="text" class="form-control" style="text-transform: uppercase;" id="LastName"
                        name="LastName" value="<?php if(isset($LastName)) echo $LastName ?>">
                    <?php
                    if(isset($_POST['save'])){                        
                        if(empty($LastName)){
                            echo validator_field_form("Apellidos","REQUIRED");    
                            $formValid=False;
                        }   
                    }                 
                    ?>
                    <div id="err_lastname"></div>
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
                                echo validator_field_form("Phone","INVALID");   
                                $formValid=False;                            
                            }                                                       
                        }else{
                            echo validator_field_form("Número Telefónico","REQUIRED");  
                            $formValid=False;                 
                        }
                    }
                    ?>
                    <div id="err_phone"></div>
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
                                    echo validator_field_form("ConfirmEmail","MATCH");
                                    $formValid=False;
                                }   
                            }else{
                                echo validator_field_form("Email","INVALID");
                                $formValid=False;
                            }
                        }else{
                            echo validator_field_form("Correo Electrónico","REQUIRED"); 
                                $formValid=False;
                        }  
                    }                  
                    ?>
                    <div id="err_email"></div>
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
                                    echo validator_field_form("ConfirmEmail","MATCH");
                                    $formValid=False;
                                }                                
                            }else{
                                echo validator_field_form("ConfirmEmail","INVALID");
                                $formValid=False;
                            }                          
                                                                   
                        }else{
                            echo validator_field_form("Confirmar Correo Electrónico","REQUIRED");
                            $formValid=False;                             
                        }
                    }                    
                    ?>
                    <div id="err_confirm_email"></div>
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
                            Observatorio Anticorrupción","REQUIRED");
                            $formValid=False;
                        }     
                    }               
                    ?>
                    <div id="err_reasons"></div>
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
                            inmediatos anteriores a la postulación","REQUIRED");
                            $formValid=False;
                        }else{
                            if(!in_array("NoRegistrado", $_POST['terminos'])){
                                echo validator_field_form("No haber sido
                                registrado como candidata o candidato a cargo alguno de elección popular, en los tres años
                                inmediatos anteriores a la postulación", "REQUIRED");
                                $formValid=False;
                            }
                        }     
                    }               
                    ?>
                    <div id="err_no_registrado"></div>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="mb-1 col">
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
                            designación","REQUIRED");
                            $formValid=False;
                        }else{
                            if(!in_array("NoCargo", $_POST['terminos'])){
                                echo validator_field_form("No haber sido
                                registrado como candidata o candidato a cargo alguno de elección popular, en los tres años
                                inmediatos anteriores a la postulación", "REQUIRED");
                                $formValid=False;
                            }
                        }     
                    }               
                    ?>
                    <div id="err_no_cargo"></div>
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
                            años inmediatos anteriores a la designación.","REQUIRED");
                            $formValid=False;
                        }else{
                            if(!in_array("NoDirigente", $_POST['terminos'])){
                                echo validator_field_form("No haber sido dirigente nacional, estatal o municipal en algún partido político, en los tres
                                años inmediatos anteriores a la designación.", "REQUIRED");
                                $formValid=False;
                            }
                        }     
                    }               
                    ?>
                    <div id="err_no_dirigente"></div>
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
                            echo validator_field_form("No ser servidora o servidor público","REQUIRED");
                            $formValid=False;
                        }else{
                            if(!in_array("NoServidor", $_POST['terminos'])){
                                echo validator_field_form("No ser servidora o servidor público", "REQUIRED");
                                $formValid=False;
                            }
                        }     
                    }               
                    ?>
                    <div id="err_no_servidor"></div>
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
                            <a href="./assets/docs/Convocatoria_Observatorio_Anticorrupcion_vf.pdf" target="_blank">Leer
                                aquí</a>
                        </label>
                    </div>
                    <?php 
                    if(isset($_POST['save'])){                       
                        if(!isset($_POST['terminos'])){
                            echo validator_field_form("He leído la Convocatoria para formar parte del Observatorio Anticorrupción y estoy de
                            acuerdo que en los casos no previstos en las etapas del proceso de selección sean resueltos
                            por la Secretaría Ejecutiva del Sistema Anticorrupción del Estado de
                            Tlaxcala.","REQUIRED");
                            $formValid=False;
                        }else{
                            if(!in_array("Convocatoria", $_POST['terminos'])){
                                echo validator_field_form("He leído la Convocatoria para formar parte del Observatorio Anticorrupción y estoy de
                                acuerdo que en los casos no previstos en las etapas del proceso de selección sean resueltos
                                por la Secretaría Ejecutiva del Sistema Anticorrupción del Estado de
                                Tlaxcala.", "REQUIRED");
                                $formValid=False;
                            }
                        }     
                    }               
                    ?>
                    <div id="err_convocatoria"></div>
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
                            <a href="./assets/docs/Carta_compromiso_de_integrantes_del_Observatorio_Anticorrupción.pdf"
                                target="_blank">Leer aquí</a>
                        </label>
                    </div>
                    <?php 
                    if(isset($_POST['save'])){                       
                        if(!isset($_POST['terminos'])){
                            echo validator_field_form("He leído la Carta Compromiso de integrantes del Observatorio Anticorrupción y estoy de
                            acuerdo con suscribirla en todos sus términos.","REQUIRED");
                            $formValid=False;
                        }else{
                            if(!in_array("CartaCompromiso", $_POST['terminos'])){
                                echo validator_field_form("He leído la Carta Compromiso de integrantes del Observatorio Anticorrupción y estoy de
                                acuerdo con suscribirla en todos sus términos.", "REQUIRED");
                                $formValid=False;
                            }
                        }     
                    }               
                    ?>
                    <div id="err_carta_compromiso"></div>
                </div>
                <div id="err_all_terms"></div>
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
                            reverso) expedida por el Instituto Nacional Electoral","REQUIRED");
                            $formValid=False;
                        }else{
                            $UserName = strtoupper($_POST['UserName']);
                            $LastName = strtoupper($_POST['LastName']);                         
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
                                echo validator_field_form("El archivo debe ser una imagen o un pdf", "REQUIRED");
                                $formValid=False;
                            }
                            if($file_size_ine > 2097152){
                                echo validator_field_form("El archivo debe ser menor a 2MB", "REQUIRED");
                                $formValid=False;
                            }
                            
                        }        
                    }                       
                    ?>
                    <div id="err_ine"></div>

                </div>
            </div>
            <div class="row align-items-center">
                <div class="mb-1 col">
                    <label for="ComprobanteDomicilio" class="form-label">Comprobante de domicilio no mayor a tres
                        meses</label>
                    <input type="file" class="form-control" id="ComprobanteDomicilio" name="ComprobanteDomicilio"
                        accept=".jpg, .jpeg, .png, .jpeg, .pdf"> <?php
                
                ?>
                    <?php
                    if(isset($_POST['save'])){
                        if(!isset($_FILES['ComprobanteDomicilio'])){
                            echo validator_field_form("Comprobante de domicilio no mayor a tres
                            meses","REQUIRED");
                            $formValid=False;
                        }else
                        {
                            $UserName = strtoupper($_POST['UserName']);
                            $LastName = strtoupper($_POST['LastName']);                         
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
                                echo validator_field_form("El archivo debe ser una imagen o un pdf", "REQUIRED");
                                $formValid=False;
                            }
                            if($file_size_cd > 2097152){
                                echo validator_field_form("El archivo debe ser menor a 2MB", "REQUIRED");
                                $formValid=False;
                            }
                            
 
                        }    
                    }                   
                   ?>
                    <div id="err_comprobante_domicilio"></div>
                </div>
            </div>

            <div class="row align-items-center mt-3">
                <button type="submit" class="btn btn-primary" name="save" id="save">Enviar
                    Información</button>
                <?php
                    if(isset($_POST['save'])){
                        if($formValid){
                  
                            $url_ine="";
                            while($url_ine===""){
                            $url_ine=uploadFile($file_tmp_ine,$file_save_name_ine,$file_type_ine);
                            }
                           /*  echo "<p>".$url_ine."</p>"; */
                            $url_cd="";
                            while($url_cd===""){
                             $url_cd=uploadFile($file_tmp_cd,$file_save_name_cd,$file_type_cd);
                            }
                           /*  echo "<p>".$url_cd."</p>";
                            echo "<p> UserName:-".$UserName."</p>";
                            echo "<p> LastName:-".$LastName."</p>";
                            echo "<p> Email:-".$Email."</p>";
                            echo "<p> Phone:-".$Phone."</p>";
                            echo "<p> Gender:-".$Gender."</p>";
                            echo "<p> ConfirmEmail:-".$ConfirmEmail."</p>";
                            echo "<p> Reasons:-".$Reasons."</p>";
                            echo "<p> Terms:-".count($Terms)."</p>"; */

                            try {
                                $db_connection = mysqli_connect($db_host, $db_user, $db_password, $db_name);

                                if (!$db_connection) {
                                die('No se ha podido conectar a la base de datos');
                                }
    
                                $email=mysqli_query($db_connection, "SELECT * FROM ".$db_table_name." WHERE cEmail = '".$Email."'");
                                $phone=mysqli_query($db_connection, "SELECT * FROM ".$db_table_name." WHERE cTel = '".$Phone."'");
    
    
                                if (mysqli_num_rows($phone)>0 || mysqli_num_rows($email)>0){
                                   /*  while ($data = mysqli_fetch_array($email)) {                                        
                                        $LocalName=$data["cEmail"];
                                        $LocalEmail=$data["cTel"];
                                     } */
                                     
                                     echo '<script language="javascript">alert("El usuario con el telefóno:' . $Phone . ' y correo: '. $Email .' ya esta registrado.");
                                     </script>';
    
                                }else {
	
                                    $insert_value = 'INSERT INTO `' . $db_name . '`.`'.$db_table_name.'` (`cNombre` , `cApellidos` , `cTel` ,  `cEmail`, `cGenero` , `cRazones` , `cUrl_Ine` ,  `cUrl_Comprobante_Domicilio`,`bTerminos`) VALUES ("' . $UserName . '", "' . $LastName. '", "' . $Phone . '", "' . $Email . '", "' . $Gender . '", "' . $Reasons . '", "' . $url_ine . '", "' . $url_cd . '",True)';
                                    
                                    mysqli_select_db($db_connection, $db_name);
                                    
                                    $retry_value = mysqli_query($db_connection, $insert_value);
                                    
                                    if (!$retry_value) {
                                       die('Error: ' . mysqli_error());
                                    }
                                    /* 
                                    
                                    header('Location: Success.html'); */
                                    
                                    echo '<script language="javascript">
                                  
                                    alert("El usuario ' .  $UserName . ' '.$LastName .' Se Registro Exitosamente!!!");
                                       </script>';
                                    
                                    }
                                    
                                    mysqli_close($db_connection);
                                   
                                    die();
                                    
                            } catch (\Throwable $th) {
                                echo $e->getMessage();
                                die();
                            }
                            
                        }else{
                            echo '<script language="javascript">                           
                            alert("Faltan campos por llenar");
                               </script>';
                        }
                    }                    
                    ?>

            </div>
        </form>

    </div>
    <script src="./assets/scripts/jquery-3.7.1.min.js"></script>
    <script type="text/javascript" src="./assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="./assets/scripts/scripts.js"></script>
</body>

</html>