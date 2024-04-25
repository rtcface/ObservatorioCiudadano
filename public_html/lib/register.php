<?php
    include("./form-validations.php");
    include("../loadfile.php");
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
    echo "<script> console.log('save')</script>";
    if(isset($_POST['save'])){
        echo "<script> console.log('....save')</script>";
        /* escribe todos los campos que se envian en el post de este formulario*/
        if(isset($_POST['UserName']) && isset($_POST['LastName']) && isset($_POST['Email']) && isset($_POST['Phone']) && isset($_POST['Gender']) && isset($_POST['ConfirmEmail']) && isset($_POST['Reasons']) && isset($_POST['terminos']) && isset($_FILES['ComprobanteDomicilio']) && isset($_FILES['Ine'])){
            echo "<script> console.log('....Isset')</script>";
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
            $Error_UserName=validate_empty_field($UserName,"Nombres");
            $Error_LastName=validate_empty_field($LastName, "Apellidos");
            $Error_Email=validate_empty_field($Email, "Correo Electrónico");
            $Error_Phone=validate_empty_field($Phone, "Número Telefónico");
            $Error_Gender=validate_empty_field($Gender, "Genero");
            $Error_ConfirmEmail=validate_empty_field($ConfirmEmail, "Confirmar Correo");
            $Error_Reasons=validate_empty_field($Reasons, "Menciona las razones por las cules desea ser integrante del Observatorio Anticorrupción");
            $Error_Terms=validate_empty_field($Terms, "Acepta los terminos y condiciones");
            $Error_ComprobanteDomicilio=validate_empty_field($ComprobanteDomicilio, "Comprobante de Domicilio");
            $Error_Ine=validate_empty_field($Ine, "Ine");

            echo "<script> console.log('name','".$Error_UserName."'); </script>";

            /* Si hay errores, no se guarda el registro y se muestran los errores */
            if($Error_UserName || $Error_LastName || $Error_Email || $Error_Phone || $Error_Gender || $Error_ConfirmEmail || $Error_Reasons || $Error_Terms || $Error_ComprobanteDomicilio || $Error_Ine){
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
            }

            echo error("este es un error");
                
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
            
        }

    }
   