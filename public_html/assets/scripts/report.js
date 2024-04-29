/* Report de usuarios registrados en una tabla de boostrap  con ajax */
$(document).ready(function () {
  ajax();
});

const updateTable = () => {
  /* limpiar la tabla */
  $("#table-report tbody").html("");
  /* llamar a la funcion ajax */
  ajax();
};

const ajax = () => {
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
      console.log("DATA", data);
      if (data.status === "ok") {
        /* muestra la list de usuarios registrados */
        Swal.fire({
          title: "Resultados del reporte",
          icon: "success",
        });
      } else if (data.status === "sn") {
        window.location.href = "./index.html";
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
        /* recorrer el array data.result.data y mostrar los datos en la tabla */
        for (let index = 0; index < data.result.length; index++) {
          const element = data.result[index];
          console.log(element);
          /* insertar los datos en la tabla */
          $("#table-report tbody").append(`
        <tr>
          <td>${index + 1}</td>
          <td>${element.cNombre}</td>
          <td>${element.cApellidos}</td>
          <td>${element.cTel}</td>
          <td>${element.cGenero}</td>
          <td>${element.cEmail}</td>
          <td><textarea class='form-control' disabled readonly >${
            element.cRazones
          }</textarea></td>
          <td><a href='https://drive.google.com/open?id=${
            element.cUrl_Ine
          }' target='_blank'>Ver</a></td>
          <td><a href='https://drive.google.com/open?id=${
            element.cUrl_Comprobante_Domicilio
          }' target='_blank'>Ver</a></td>            
        </tr>
      `);
        }
        Swal.hideLoading();
        /* clean register form */
      }
      //Funcion
    })
    .fail(function (XMLHttpRequest, textStatus, errorThrown) {
      //Funcion
      console.log("ERROR", textStatus);
    });
};

const cerrarSesion = () => {
  $.ajax({
    url: "../../lib/logout.php",
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
      if (data.status === "ok") {
        window.location.href = "./index.html";
      }
    },
  });
};

function fnExcelReport() {
  let tab_text = `<table id="table-report" class="table">
  <tr><td>#</td><td>Nombres</td><td>Apellidos</td><td>Telefono</td><td>Genero</td><td>Email</td><td>Razones para ser integrante</td><td>Ine</td><td>Comprobante de domicilio</td></tr><tr>`;

  let tab = document.querySelectorAll("#table-report tbody"); // id of table

  tab.forEach((item) => {
    tab_text = tab_text + item.innerHTML + "</tr>";
    //tab_text=tab_text+"</tr>";
  });
  tab_text = tab_text.replace(/<textarea[^>]*>|<\/textarea>/gi, "");
  tab_text = tab_text + "</table>";
  console.log(tab_text);
  /* for (j = 0; j < tab.rows.length; j++) {
      tab_text = tab_text + tab.rows[j].innerHTML + "</tr></thead>";
      //tab_text=tab_text+"</tr>";
  }
 */
  /*  tab_text = tab_text + "</table>";
  tab_text = tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
  tab_text = tab_text.replace(/<img[^>]*>/gi, ""); // remove if u want images in your table
  tab_text = tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params */

  var msie = window.navigator.userAgent.indexOf("MSIE ");

  // If Internet Explorer
  if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) {
    txtArea1.document.open("txt/html", "replace");
    txtArea1.document.write(tab_text);
    txtArea1.document.close();
    txtArea1.focus();

    sa = txtArea1.document.execCommand(
      "SaveAs",
      true,
      "Say Thanks to Sumit.xls"
    );
  } else {
    // other browser not tested on IE 11
    sa = window.open(
      "data:application/vnd.ms-excel," + encodeURIComponent(tab_text)
    );
  }

  return sa;
}
