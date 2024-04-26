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
    $data = array();
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

            if(!isset($_FILES['Ine'])){  
                $data['status'] = 'err';
                $data['result'] = 'El archivo de la ine es requerido';              
                $formValid=False;
                echo json_encode($data);
                return; 
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
                    $data['status'] = 'err';
                    $data['result'] = 'El archivo de la ine debe ser una imagen o un pdf';                    
                    $formValid=False;
                    echo json_encode($data);
                    return; 
                }
                if($file_size_ine > 2097152){                   
                    $data['status'] = 'err';
                    $data['result'] = 'El archivo de la ine debe ser menor a 2MB'; 
                    $formValid=False;
                    echo json_encode($data);
                    return; 
                }
                
            }
            if(!isset($_FILES['ComprobanteDomicilio'])){
                $data['status'] = 'err';
                $data['result'] = 'El archivo del comprobante de domicilio es requerido';
                $formValid=False;
                echo json_encode($data);
                return; 
            }else
            {
                       
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
                    $data['status'] = 'err';
                    $data['result'] = 'El archivo del comprobante de domicilio debe ser una imagen o un pdf'; 
                    $formValid=False;
                    echo json_encode($data);
                    return; 
                }
                if($file_size_cd > 2097152){
                    $data['status'] = 'err';
                    $data['result'] = 'El archivo del comprobante de domicilio debe ser menor a 2MB'; 
                    $formValid=False;
                    echo json_encode($data);
                    return; 
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
            
            $url_cd="";
            while($url_cd===""){
             $url_cd=uploadFile($file_tmp_cd,$file_save_name_cd,$file_type_cd);
            }         

            try {
                $db_connection = mysqli_connect($db_host, $db_user, $db_password, $db_name);

                if (!$db_connection) {
                    $data['status'] = 'err';
                    $data['result'] = 'Por el momento tenemos problemas con el servicio intente mas tarde'; 
                    echo json_encode($data);                   
                die();
                return; 
                }

                $email=mysqli_query($db_connection, "SELECT * FROM ".$db_table_name." WHERE cEmail = '".$Email."'");
                $phone=mysqli_query($db_connection, "SELECT * FROM ".$db_table_name." WHERE cTel = '".$Phone."'");


                if (mysqli_num_rows($phone)>0 || mysqli_num_rows($email)>0){  
                    $data['status'] = 'err';
                    $data['result'] = 'Error-El usuario con el telefóno:' . $Phone . ' y correo: '. $Email .' ya esta registrado';              
                }else {

                    $insert_value = 'INSERT INTO `' . $db_name . '`.`'.$db_table_name.'` (`cNombre` , `cApellidos` , `cTel` ,  `cEmail`, `cGenero` , `cRazones` , `cUrl_Ine` ,  `cUrl_Comprobante_Domicilio`,`bTerminos`) VALUES ("' . $UserName . '", "' . $LastName. '", "' . $Phone . '", "' . $Email . '", "' . $Gender . '", "' . $Reasons . '", "' . $url_ine . '", "' . $url_cd . '",True)';
                    
                    mysqli_select_db($db_connection, $db_name);
                    
                    $retry_value = mysqli_query($db_connection, $insert_value);
                    
                    if (!$retry_value) {
                       die('ErrorServer-' . mysqli_error());
                    } 
                    $data['status'] = 'ok';
                    $data['result'] = 'El usuario ' .  $UserName . ' '.$LastName .' Se Registro Exitosamente!!!';                 
                    }                    
                    mysqli_close($db_connection); 
                    echo json_encode($data);                  
                    die();
                    
            } catch (Exception $e) {
                $data['status'] = 'err';
                $data['result'] = 'Por el momento tenemos problemas con el servicio intente mas tarde'; 
                echo 'Caught exception: ',  $e->getMessage(), "\n";
                echo json_encode($data);
                die();
            }
            
        }

        echo json_encode($data);
        die();

    }
   