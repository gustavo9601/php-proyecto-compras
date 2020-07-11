var tabla;

//Funcion que se ejcuta al inciio

function init() {
    mostrarform(false);
    listar();


    //Validano si el formulario se envio y alcenara la informacion en la BD
    $('#formulario').on("submit", function (e) {
        guardaryeditar(e);
    });


}


//Funcion limpiar
function limpiar() {

    $('#nombre').val("");
    $('#num_documento').val("");
    $('#direccion').val("");
    $('#telefono').val("");
    $('#email').val("");
    $('#idpersona').val("");

}
//Funcion muestra el formulario
function mostrarform(flag) {
    limpiar();

    if (flag) {
        $('#listadoregistros').hide();
        $('#formularioregistros').show();
        $('#btnGuardar').prop("disabled", false);
    } else {
        $('#listadoregistros').show();
        $('#formularioregistros').hide();
    }
}

//Funcion cancelar form, oculatara el cform
function cancelarform() {
    limpiar();
    mostrarform(false);
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
            url: '../ajax/persona.php?op=listarc',
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

//Funcuion que realiza la peticion ajax y guarca la caetogira
function guardaryeditar(e) {
    e.preventDefault(); //No se activara la accion predeterminada
    $('#btnGuardar').prop("disabled", true);
    var formData = new FormData($("#formulario")[0]); //guardamos en una variable, los valores del formulario, y 0 para capturar todos los datso

    //va ser una peticion enviando la acccion via get
    //ña otra peticion la realizara via POST, enviando los datos
    $.ajax({
        url: "../ajax/persona.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            bootbox.alert(datos); //ejcutamos el plugin
            mostrarform(false);
            tabla.ajax.reload(); //recargamos la tabla
        }
    });
    limpiar();
}

//Funcion que mostrara mediante ajax los datos de la persona
function mostrar(idpersona) {

    var datos = new FormData();
    datos.append("idpersona", idpersona);
    $.ajax({
        url: "../ajax/persona.php?op=mostrar",
        type: "POST",
        data: datos,
        contentType: false,
        processData: false,
        success: function (datos) {

            datos = JSON.parse(datos);  //parceamos los que recibimos de respuesta
            mostrarform(true);
            //pruebas para capturar el array que recibo
            /* console.log(datos);
             console.log(datos['nombre']);
             console.log(datos['descripcion']);
             console.log(datos['idcategoria']);*/


            //colocamos lo que reciba por post, en el formulario
            $('#nombre').val(datos['nombre']);
            //actualizo el select
            $('#tipo_documento').val(datos['tipo_documento']);
            $('#tipo_documento').selectpicker('refresh');

            $('#num_documento').val(datos['num_documento']);
            $('#direccion').val(datos['direccion']);
            $('#telefono').val(datos['telefono']);
            $('#email').val(datos['email']);
            $('#idpersona').val(datos['idpersona']);

        }
    });
}


//Funcion para eiminar los clientes o provedores
function eliminar(idpersona) {
    //mostramos la alerta, de confirmacion
    bootbox.confirm("Estas seguro de Elimnar el Proveedor ?", function (result) {
        //si decide quesi, hara lo siguiente
        if (result) {
            var id = new FormData();
            id.append("idpersona", idpersona);
            //hacemos la peticion ajax
            $.ajax({
                url: "../ajax/persona.php?op=eliminar",
                type: "POST",
                data: id,
                contentType: false,
                processData: false,
                success: function (datos) {
                    bootbox.alert(datos);
                    mostrarform(false);
                    tabla.ajax.reload(); //recargamos la tabla
                }
            });
        }
    });
}

init();