var tabla;

//Funcion que se ejcuta al inciio

function init() {
    mostrarform(false);
    listar();
}


//Funcion limpiar
function limpiar() {
    $('#nombre').val("");
    $('#descripcion').val("");
    $('#idcategoria').val("");
}
//Funcion muestra el formulario
function mostrarform(flag) {
    if (flag) {
        $('#listadoregistros').hide();
        $('#formularioregistros').show();
        $('#btnGuardar').prop("disabled", false);
        $('#btnagregar').hide();
    } else {
        $('#listadoregistros').show();
        $('#formularioregistros').hide();
        $('#btnagregar').hide();
    }
}

//Funcion listar
function listar() {
    tabla = $('#tbllistado').dataTable({
        "aProcessing": true, //Activamos el procesamiento del datatable
        "aServerSide": true, //Paginacion y filtrado realizados por el servidor
        "dom": 'Bfrtip', //Definimos los elementos del control de la tabla
        "buttons": [   //botones
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdf'
        ],
        "ajax": {
            url: '../ajax/permiso.php?op=listar',
            type: "get",
            dataType: "json",
            error: function (e) {
                console.log(e.responseText);
            }
        },
        "bDestory": true,
        "iDisplayLength": 5,  //cada cuantos registros, la paginacion
        "order": [[0, "desc"]]  //orden de los registros
    }).DataTable();
}
init();