var tabla;

//Funcion que se ejcuta al inciio

function init() {
    mostrarform(false);
    listar();


    //Validano si el formulario se envio y alcenara la informacion en la BD
    $('#formulario').on("submit", function (e) {
        guardaryeditar(e);
    });


    //Peticion Ajax, que cargara la informacion de los permisos cuando cargue este script
    //version corta de peticion post, sin enviar datos solo la url
    //enviamos el id vacio para que no genere error
    $.post("../ajax/usuario.php?op=permisos&id=", function (respuesta) {
        $('#permisos').html(respuesta);
    });


    //ocultndo la iamgen , inicial
    $('#imagenmuestra').hide();
}


//Funcion limpiar
function limpiar() {
    $('#nombre').val("");
    $('#num_documento').val("");
    $('#direccion').val("");
    $('#telefono').val("");
    $('#email').attr("src", "");
    $('#cargo').val("");
    $('#login').val();
    $('#clave').val("");
    $('#imagenmuestra').attr("src", "");
    $('#imagenactual').val("");
    $('#idusuario').val("");
}
//Funcion muestra el formulario
function mostrarform(flag) {
    limpiar();

    if (flag) {
        $('#listadoregistros').hide();
        $('#formularioregistros').show();
        $('#btnGuardar').prop("disabled", false);
        $('#btnagregar').hide();
    } else {
        $('#listadoregistros').show();
        $('#formularioregistros').hide();
        $('#barcode').html(" ");
        $('#imagenmuestra').html(" ").hide();
        $('#btnGuardar').prop("disabled", false);
        $('#btnagregar').show();
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
            url: '../ajax/usuario.php?op=listar',
            type: "get",
            dataType: "json",
            error: function (e) {

                //$('body').append(e.responseText);
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
    var formData = new FormData($("#formulario")[0]); //guardamos en una variable, los valores del formulario, y 0 indica la poscion inical del formulario

    //va ser una peticion enviando la acccion via get
    //ña otra peticion la realizara via POST, enviando los datos
    $.ajax({
        url: "../ajax/usuario.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (datos) {
            console.log(datos);
            bootbox.alert(datos); //ejcutamos el plugin
            mostrarform(false);
            tabla.ajax.reload(); //recargamos la tabla
            limpiar();
        }
    });

}

//Funcion que mostrara mediante ajax los datos de la cateforia
function mostrar(idusuario) {

    var id = new FormData();
    id.append("idusuario", idusuario);
    $.ajax({
        url: "../ajax/usuario.php?op=mostrar",
        type: "POST",
        data: id,
        contentType: false,
        processData: false,
        success: function (datos) {
            console.log(datos);
            datos = JSON.parse(datos);  //parceamos los que recibimos de respuesta
            mostrarform(true);
            //pruebas para capturar el array que recibo
            /* console.log(datos);
             console.log(datos['nombre']);
             console.log(datos['descripcion']);
             console.log(datos['idcategoria']);*/


            //colocamos lo que reciba por post, en el formulario
            $('#nombre').val(datos['nombre']);
            $('#tipo_documento').val(datos['tipo_documento']);
            $('#tipo_documento').selectpicker('refresh');
            $('#num_documento').val(datos['num_documento']);
            $('#direccion').val(datos['direccion']);
            $('#telefono').val(datos['telefono']);
            $('#email').val(datos['email']);
            $('#cargo').val(datos['cargo']);
            $('#login').val(datos['login']);
            $('#clave').val(datos['clave']);
            $('#imagenmuestra').show().attr('src', '../files/usuario/' + datos['imagen']);
            $('#imagenactual').val(datos['imagen']);
            $('#idusuario').val(datos['idusuario']);

        }
    });


    //Peticion Ajax, que cargara la informacion de los permisos cuando cargue este script
    //version corta de peticion post, sin enviar datos solo la url
    //enviamos el id
    $.post("../ajax/usuario.php?op=permisos&id=" + idusuario, function (respuesta) {
        $('#permisos').html(respuesta);
    });


}


//Funcion para desactivar las categorias
function desactivar(idusuario) {
    //mostramos la alerta, de confirmacion
    bootbox.confirm("Estas seguro de Desactivar el Usuario ?", function (result) {
        //si decide quesi, hara lo siguiente
        if (result) {
            var id = new FormData();
            id.append("idusuario", idusuario);
            //hacemos la peticion ajax
            $.ajax({
                url: "../ajax/usuario.php?op=desactivar",
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


//Funcion para Activar las categorias
function activar(idusuario) {
    //mostramos la alerta, de confirmacion
    bootbox.confirm("Estas seguro de Activar el Usuario?", function (result) {
        //si decide quesi, hara lo siguiente
        if (result) {
            var id = new FormData();
            id.append("idusuario", idusuario);
            //hacemos la peticion ajax
            $.ajax({
                url: "../ajax/usuario.php?op=activar",
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