
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
            
        }else{
          /*valida que se un numero valido de 10 digitos */
          if(!validarNumero(Phone)) {
            $("#err_phone").html(validator_field_form("Phone", "INVALID"));
          }
          
        }
        if (Gender == "") {
            $("#err_gender").html(validator_field_form("Genero", "REQUIRED"));
           
        }
        if (Email == "") {
            $("#err_email").html(validator_field_form("Email", "REQUIRED"));
        }else{
          /*valida que sea un email valido */
          if(!validarEmail(Email)) {
            $("#err_email").html(validator_field_form("Email", "INVALID"));
          }
        }
        if (ConfirmEmail == "") {
            $("#err_confirm_email").html(validator_field_form("Confirmar Email", "REQUIRED"));
           
        }else{
          /*valida que sea un email valido */
          if(!validarEmail(ConfirmEmail)) {
            $("#err_confirm_email").html(validator_field_form("Email", "INVALID"));
          }
        }

        if(!validarCorreos(Email,ConfirmEmail)){
          $("#err_confirm_email").html(validator_field_form("Email", "MATCH"));
        }
         if(!validarCorreos(Email,ConfirmEmail)){
          $("#err_email").html(validator_field_form("Email", "MATCH"));
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
          
          if(!terminos.includes("NoServidor")){
            $("#err_no_servidor").html(validator_field_form(` No ser servidora o servidor público`, "REQUIRED"));
          }
          if(!terminos.includes("Convocatoria")){
            $("#err_convocatoria").html(validator_field_form(` He leído la Convocatoria para formar parte del Observatorio
            Anticorrupción y estoy de acuerdo que en los casos no previstos
            en las etapas del proceso de selección sean resueltos por la
            Secretaría Ejecutiva del Sistema Anticorrupción del Estado de
            Tlaxcala.`, "REQUIRED"));
          }
          if(!terminos.includes("CartaCompromiso")){
            $("#err_carta_compromiso").html(validator_field_form(` He leído la Carta Compromiso de integrantes del Observatorio
            Anticorrupción y estoy de acuerdo con suscribirla en todos sus
            términos.`, "REQUIRED"));
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
        console.log(formData);
        // enviar formdata
        /* AJAX("../lib/register.php", formData).then(function(data) {
            console.log(data);
            $("#resultado").html(data);
        }); */
         // enviar formdata
         $.ajax({
          url: "../../lib/register.php",
          type: "POST",
          data: formData,
          contentType: false,
          processData: false,
          beforeSend: function () {
              /* muestra show Swal loading */
              
              Swal.fire({
                  html: ` <div class="message"><h3>Espere un momento por favor...</h3><div class="loading"><img src="./assets/img/loadingb.gif" alt="loading" /></div></div>`,               
                  showConfirmButton: false,
                  allowOutsideClick: false,
                  allowEscapeKey: false,
                  allowEnterKey: false,
                  showCloseButton: false,
                  showCancelButton: false,
                  showLoaderOnConfirm: true,
                  preConfirm: function() {
                      return new Promise(function(resolve) {
                          setTimeout(function() {                             
                              resolve();
                          }, 2000);
                      });
                  }
              });
          },      
             
          success: function(data) {
            /* muestra show Swal success */
            Swal.fire({
              title: "Información enviada",
              text: "Gracias por su registro",
              icon: "success"
            });
          },
          complete:function(){
             console.log("Complete","todo ok")
          },
          error: function(error) {
              console.log("ERROR",error);
          }
      }).done(function(data) {
        console.log("Done",data);
        Swal.hideLoading();
        /* clean register form */
        $("#register")[0].reset();
        /* clean all errors */
        $("#err_name").html("");
        $("#err_lastname").html("");
        $("#err_phone").html("");
     
        $("#err_email").html("");
        $("#err_confirm_email").html("");
        $("#err_reasons").html("");
        $("#err_ine").html("");
        $("#err_comprobante_domicilio").html("");
        $("#err_no_registrado").html("");
        $("#err_no_cargo").html("");
        $("#err_no_dirigente").html("");
        $("#err_no_servidor").html("");
        $("#err_convocatoria").html("");
        $("#err_carta_compromiso").html("");
        $("#err_all_terms").html("");


         
        //Funcion
    }).fail(function(XMLHttpRequest, textStatus, errorThrown) {
        //Funcion
        console.log("ERROR", errorThrown);
    });
    });

    function AJAX(url,data)
    {
      return new Promise(function (resolve, reject){
        //SweetCarga.fire({ title: 'Cargando...'});
        $.ajax({
            url: url,
            type: 'POST',
            data: data
        }).done(function(data) {
            //Funcion
        }).fail(function(XMLHttpRequest, textStatus, errorThrown) {
            //Funcion
        });
      });
    }
    
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
            message = "Por favor escriba un correo valido";
            break;
        case "ConfirmEmail":
            message = "Confirmar Email";
            break;
        case "Phone":
            message = "Por favor introduzca un Número Telefónico valido a 10 digitos";
            break;
        
    }
    return message;
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

/* valida que se un numero valido de 10 digitos */
function validarNumero(numero) {
  if (numero.length === 10) {
    return true;
  } else {
    return false;
  }
}
/* valida email valido */
function validarEmail(email) {
  var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email) ? true : false;
}
/*  valida que los correos coincidan  */
function validarCorreos(email, confirmEmail) {
  if (email === confirmEmail) {
    return true;
  } else {
    return false;
  }
}



