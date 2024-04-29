$(document).ready(function () {
  $("#login").on("submit", function (e) {
    e.preventDefault();
    /* valida usuario i contraseña requeridos*/
    let usuario = $("#usuario").val();
    let password = $("#password").val();
    if (usuario == "" || password == "") {
      Swal.fire({
        title: "Error",
        text: "Datos requeridos",
        icon: "error",
      });
      return false;
    }
    let formData = new FormData();
    formData.append("user", usuario);
    formData.append("pass", password);

    $.ajax({
      url: "../../lib/login.php",
      dataType: "json",
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
          preConfirm: function () {
            return new Promise(function (resolve) {
              setTimeout(function () {
                resolve();
              }, 2000);
            });
          },
        });
      },

      success: function (data) {
        console.log(data);
        if (data.status === "ok") {
          /*  Swal.fire({
            title: "Información enviada",
            text: data.result,
            icon: "success",
          }); */
          window.location.href = "./reporte.html";
        } else {
          Swal.fire({
            title: "Error",
            text: data.result,
            icon: "error",
          });
        }
        /* muestra show Swal success */
      },
      complete: function () {
        /*  console.log("Complete","todo ok") */
      },
      error: function (error) {
        /* console.log("ERROR",error); */
      },
    })
      .done(function (data) {
        if (data.status === "ok") {
          Swal.hideLoading();
          /* clean register form */
          $("#login")[0].reset();
        }

        //Funcion
      })
      .fail(function (XMLHttpRequest, textStatus, errorThrown) {
        //Funcion
        console.log("ERROR", errorThrown);
      });
  });
});
