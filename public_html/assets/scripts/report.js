/* Report de usuarios registrados en una tabla de boostrap  con ajax */
$(document).ready(function() {  
    $.ajax({
        url: "../../lib/report.php",
        dataType: "json",
        type: "GET",              
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
          console.log("DATA",data)
          if(data.status === "ok"){           
            /* muestra la list de usuarios registrados */           
            Swal.fire({
              title: "Resultados del reporte",
              icon: "success"
            });

          }else{
            Swal.fire({
              title: "Error",
              text: data.result,
              icon: "error"
            });
          }
          /* muestra show Swal success */
          
        },
        complete:function(){
          /*  console.log("Complete","todo ok") */
        },
        error: function(error) {
            /* console.log("ERROR",error); */
        }
    }).done(function(data) {
      if(data.status==="ok"){
        console.log(data.result.data[0]);
        /* recorrer el array data.result.data y mostrar los datos en la tabla */
        for (let index = 0; index < data.result.data.length; index++) {
          const element = data.result.data[index];
          console.log(element);
          /* insertar los datos en la tabla */
          $("#table-report tbody").append(`
            <tr>
              <td>${index+1}</td>
              <td>${element.nombres}</td>
              <td>${element.apellidos}</td>
              <td>${element.tel}</td>
              <td>${element.gender}</td>
              <td>${element.email}</td>
              <td><textarea class='form-control' disabled readonly >${element.razones}</textarea></td>
              <td>${element.ine}</td>
              <td>${element.comprobante}</td>            
            </tr>
          `);
        }        
        Swal.hideLoading();
        /* clean register form */       
      }             
      //Funcion
  }).fail(function(XMLHttpRequest, textStatus, errorThrown) {
      //Funcion
      console.log("ERROR", textStatus);
  });

});