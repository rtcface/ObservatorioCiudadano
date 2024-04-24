const success = `
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./assets/normalize/normalize.css" />

    <link rel="stylesheet" href="./assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="./assets/estilos.css" />
    <title>Gracias Registro de Observatorios Ciudadanos</title>
    <link
      rel="icon"
      type="image/x-icon"
      href="https://saetlax.org/wp-content/uploads/2019/04/cropped-Logo_SAETLAX-15-150x150.png"
    />
  </head>
  <body>
    
      <div class="message-thanks">
        <div class="header-register">
          <div class="logo">
            <img src="./assets/img/logo.png" alt="Header register" />
          </div>
        </div>
        <div class="messge">
          <h1>Gracias por su registro</h1>
        </div>
        <a href="./index.php" class="btn btn-success">Regresar</a>
      </div>
   
  </body>
</html>
`;


const loading = `
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./assets/normalize/normalize.css" />

    <link rel="stylesheet" href="./assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="./assets/estilos.css" />
    <title>Gracias Registro de Observatorios Ciudadanos</title>
    <link
      rel="icon"
      type="image/x-icon"
      href="https://saetlax.org/wp-content/uploads/2019/04/cropped-Logo_SAETLAX-15-150x150.png"
    />
  </head>
  <body>
   
      <div class="message-thanks">
        <div class="header-register">
          <div class="logo">
            <img src="./assets/img/logo.png" alt="Header register" />
          </div>
        </div>
        <div class="messge">
          <h1>Espere un momento porfavor</h1>
          <div class="loading">
          <img src="./assets/img/loading.gif" alt="loading" />   
          </div>       
        </div>
        
      </div>
    
  </body>
</html>
`;
$(document).ready(function() {
    $("#register").on('submit', function(e) {
        e.preventDefault();
        console.log("onclick")
        let UserName = $("#UserName").val();
        let LastName = $("#LastName").val();
        let Phone = $("#Phone").val();
        let Gender = $("#Gender").val();
        let Email = $("#Email").val();
        let ConfirmEmail = $("#ConfirmEmail").val();
        let Reasons = $("#Reasons").val();
        // varible para arreglo de terminos
        let terminos = [];
        // varible para guardar los terminos
        let terminos1 = $("#NoRegistrado").is(":checked");

        let terminos2 = $("#NoCargo").is(":checked");
        let terminos3 = $("#NoDirigente").is(":checked");
        let terminos4 = $("#NoServidor").is(":checked");
        let terminos5 = $("#Convocatoria").is(":checked");
        let terminos6 = $("#CartaCompromiso").is(":checked");
        // llenar arreglo de terminos solo si se aceptan
        if (terminos1) {
            terminos.push("NoRegistrado");
        }
        
        if (terminos2) {
            terminos.push("NoCargo");
        }
        if (terminos3) {
            terminos.push("NoDirigente");
        }else{
          $("#err_dirigente")
        }
        if (terminos4) {
            terminos.push("NoServidor");
        }
        if (terminos5) {
            terminos.push("Convocatoria");
        }
        if (terminos6) {
            terminos.push("CartaCompromiso");
        }      

        //varible para guardar el archivo
        let Ine = $("#Ine")[0].files[0];
        console.log()
        let ComprobanteDomicilio = $("#ComprobanteDomicilio")[0].files[0];
        // valida campos uno por uno y mada error personalizado
        if (UserName == "") {
            $("#err_name").html(validator_field_form("Nombres","REQUIRED"));
            
        }
        if (LastName == "") {
            $("#err_lastname").html(validator_field_form("Apellidos", "REQUIRED"));
            
        }
        if (Phone == "") {
            $("#err_phone").html(validator_field_form("Telefono", "REQUIRED"));
            
        }
        if (Gender == "") {
            $("#err_gender").html(validator_field_form("Genero", "REQUIRED"));
           
        }
        if (Email == "") {
            $("#err_email").html(validator_field_form("Email", "REQUIRED"));
           
        }
        if (ConfirmEmail == "") {
            $("#err_confirm_email").html(validator_field_form("Confirmar Email", "REQUIRED"));
           
        }
        if (Reasons == "") {
            $("#err_reasons").html(validator_field_form("Motivo", "REQUIRED"));
           
        }
        
        if (Ine == "" || Ine === undefined) {
            $("#err_ine").html(validator_field_form("Ine", "REQUIRED"));
           
        }
        if (ComprobanteDomicilio == "" || ComprobanteDomicilio === undefined) {
            $("#err_comprobante_domicilio").html(validator_field_form("Comprobante Domicilio", "REQUIRED"));
            
        }
        // valida el array tiene NoRegistrado entre sus elemntos
        console.log("TERMS",terminos)
        if(terminos.length > 0){

          if (!terminos.includes("NoRegistrado")) {
            $("#err_no_registrado").html(validator_field_form(`No haber sido
            registrado como candidata o candidato a cargo alguno de elección popular, en los tres años
            inmediatos anteriores a la postulación`, "REQUIRED"));
          }

          if (!terminos.includes("NoCargo")) {
            $("#err_no_cargo").html(validator_field_form(` No haber tenido cargo alguno de elección popular en los tres años inmediatos anteriores a la
            designación`, "REQUIRED"));
          }

          if (!terminos.includes("NoDirigente")) {
            $("#err_no_dirigente").html(validator_field_form(` No haber sido dirigente nacional, estatal o municipal en algún partido político, en los tres
            años inmediatos anteriores a la designación.`, "REQUIRED"));
          }




        }else{
          $("#err_all_terms").html(error(`Todos los terminos son requeridos`));
        }

       


        

        

        if (UserName == "" || LastName == "" || Phone == "" || Gender == "" || Email == "" || ConfirmEmail == "" || Reasons == "" || terminos == "" || Ine == "" || ComprobanteDomicilio == "" || Ine === undefined || ComprobanteDomicilio === undefined) {
            $("#validaciones").html("Todos los campos son obligatorios");
            return false;
        }
        // agregar los parametros al formdata
        let formData = new FormData()
        formData.append("UserName", UserName);
        formData.append("LastName", LastName);
        formData.append("Phone", Phone);
        formData.append("Gender", Gender);
        formData.append("Email", Email);
        formData.append("ConfirmEmail", ConfirmEmail);
        formData.append("Reasons", Reasons);
        formData.append("Ine", Ine);
        formData.append("ComprobanteDomicilio", ComprobanteDomicilio);
        // agregar los terminos al formdata
        for (let i = 0; i < terminos.length; i++) {
            formData.append("terminos[]", terminos[i]);
        }
        // agrega boton de enviar al formdata
        formData.append("save", "save");   
        // enviar formdata
        $.ajax({
            url: "index.php",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $("#resultado").html(loading);
            },
            success: function(data) {
                console.log(data);
                $("#resultado").html(success);
            }
        });
    });

    // Add input files to array
  /*   var filesToUpload = []
  
    //On Change loop through all file and push to array[]
    $('#inputId').on('change', function(e) {
      for (var i = 0; i < this.files.length; i++) {
        filesToUpload.push(this.files[i]);
      }
    });
  
    // Form submission
    $("#register").on('submit', function(e) {
      e.preventDefault();
  
      //Store form Data
      let formData = new FormData()
      //Loop through array of file and append form Data
      for (let i = 0; i < filesToUpload.length; i++) {
        let file = filesToUpload[i]
        formData.append("uploaded_files[]", file);
      }
  
      //Fetch Request
      url = '../php/submit.php';
      fetch(url, {
          method: 'POST',
          body: formData
        })
        .then(function(response) {
          return response.text();
        })
        .then(function(body) {
          console.log(body);
        });
    }) */
  });


  function error (message) {
      return `<div class='alert alert-warning alert-dismissible fade show' role='alert'>
   <strong>Error!</strong> ${message}
   <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>`;
  }

  function message_for_field(field){
    let message = "";
    switch (field) {
       
        case "Email":
            message = "Email";
            break;
        case "ConfirmEmail":
            message = "Confirmar Email";
            break;
        case "Phone":
            message = "Por favor introduzca un Número Telefónico valido a 10 digitos";
            break;
        
    }
  }

  function message_for_field_error_type (field, errorType){
    let message = "";
    switch(errorType){
      case "REQUIRED":
          message = `El campo ${field} es requerido`;
          break;
      case "INVALID":
          message = message_for_field(field);
          break;
      case "MATCH":
          message = "Los correos no coinciden";
          break;
      case "OTHER":
          message = "Ocurrio un error";
          break;
  }
  return message;
  }



  function  validator_field_form(name_field,errorType){
    let getMessage = "";   
         getMessage = message_for_field_error_type(name_field, errorType);       
    return error(getMessage);
}



function realizaProceso(UserName,LastName,Phone,Gender,Email,ConfirmEmail,Reasons,Ine){     
    let parameters = {
        "UserName": UserName,
        "LastName": LastName,
        "Phone": Phone,
        "Gender": Gender,
        "Email": Email,
        "ConfirmEmail": ConfirmEmail,
        "Reasons": Reasons,
        "Ine": Ine,
        
    };
    console.log(JSON.stringify(parameters));
    /* var parametros = {
            "valorCaja1" : valorCaja1,
            "valorCaja2" : valorCaja2
    };
    $.ajax({
            data:  parametros,
            url:   'index.php',
            type:  'post',
            beforeSend: function () {
                    $("#resultado").html("Procesando, espere por favor...");
            },
            success:  function (response) {
                    $("#resultado").html(response);
            }
    }); */
}

/* ,LastName,Phone,Gender,Email,ConfirmEmail,Reasons,Ine,ComprobanteDomicilio,save)
 */
/* /?UserName=&LastName=&Phone=&Gender=mujer&Email=&ConfirmEmail=&Reasons=&Ine=&ComprobanteDomicilio=&save= */

/* , $('#Phone').val(), $('#Gender').val(), $('#Email').val(), $('#ConfirmEmail').val(), $('#Reasons').val(), $('#Ine').val(),$('#ComprobanteDomicilio').val(),$('#save').val() */