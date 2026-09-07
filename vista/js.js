$(document).ready(function () {
  $('#table').DataTable({"language": {
"url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"

}});
  
});

function delete_(message, vista) {
    var res = confirm(message)
    if (res == true) {
      alert(vista);
    } else {
      return false;
    }
  }


 