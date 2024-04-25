<?php
    include("./form-validations.php");
    include("./loadfile.php");
    include "./variables.php";

    $formValid=
    $Error_UserName=
    $Error_LastName=
    $Error_Email=
    $Error_Email_Valid=
    $Error_Email_Exist=
    $Error_Email_Match=
    $Error_Phone=
    $Error_Phone_Valid= 
    $Error_Phone_Exist=
    $Error_Gender=
    $Error_ConfirmEmail=
    $Error_ConfirmEmail_Valid=
    $Error_Reasons=
    $Error_Terms=
    $Error_ComprobanteDomicilio=
    $Error_Ine = False;
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
            /* $Error_UserName=validate_empty_field($UserName,"Nombres");
            $Error_LastName=validate_empty_field($LastName, "Apellidos");
            $Error_Email=validate_empty_field($Email, "Correo Electrónico");
            $Error_Phone=validate_empty_field($Phone, "Número Telefónico");
            $Error_Gender=validate_empty_field($Gender, "Genero");
            $Error_ConfirmEmail=validate_empty_field($ConfirmEmail, "Confirmar Correo");
            $Error_Reasons=validate_empty_field($Reasons, "Menciona las razones por las cules desea ser integrante del Observatorio Anticorrupción");
            $Error_Terms=validate_empty_field($Terms, "Acepta los terminos y condiciones");
            $Error_ComprobanteDomicilio=validate_empty_field($ComprobanteDomicilio, "Comprobante de Domicilio");
            $Error_Ine=validate_empty_field($Ine, "Ine"); */

            

            /* Si hay errores, no se guarda el registro y se muestran los errores */
          /*   if($Error_UserName || $Error_LastName || $Error_Email || $Error_Phone || $Error_Gender || $Error_ConfirmEmail || $Error_Reasons || $Error_Terms || $Error_ComprobanteDomicilio || $Error_Ine){
                $formValid = False;
                if($Error_UserName) echo $Error_UserName;
                if($Error_LastName) echo $Error_LastName;
                if($Error_Email) echo $Error_Email;
                if($Error_Phone) echo $Error_Phone;
                if($Error_Gender) echo $Error_Gender;
                if($Error_ConfirmEmail) echo $Error_ConfirmEmail;
                if($Error_Reasons) echo $Error_Reasons;
                if($Error_Terms) echo $Error_Terms;
                if($Error_ComprobanteDomicilio) echo $Error_ComprobanteDomicilio;
                if($Error_Ine) echo $Error_Ine;
            } */

            if(!isset($_FILES['Ine'])){               
                $formValid=False;
            }else{                                
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
            $formValid = True;        
        }else{
            $Terms = [];            
        }
       
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
            
        }

    }
   