var tabla;

//Funcion que se ejcuta al inciio

function init() {
    mostrarform(false);
    listar();


    //Validano si el formulario se envio y alcenara la informacion en la BD
    $('#formulario').on("submit", function (e) {
        guardaryeditar(e);
    });


    //Cargando el select, via ajax
    var a = "";
    $.ajax({
        url: "../ajax/articulo.php?op=selectCategoria",
        method: "POST",
        data: a,
        contentType: false,
        processData: false,
        success: function (respuesta) {


            $('#idcategoria').html(respuesta);
            $('#idcategoria').selectpicker('refresh'); //para que se actualice el select
        }
    });


    //ocultndo la iamgen , inicial
    $('#imagenmuestra').hide();
}


//Funcion limpiar
function limpiar() {
    $('#codigo').val("");
    $('#nombre').val("");
    $('#descripcion').val("");
    $('#stock').val("");
    $('#imagenmuestra').attr("src", "");
    $('#imagenactual').val("");
    $('#print').hide();
    $('#idarticulo').val("");
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
            url: '../ajax/articulo.php?op=listar',
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
    var formData = new FormData($("#formulario")[0]); //guardamos en una variable, los valores del formulario, y 0 para capturar todos los datso


    console.log(formData);
    //va ser una peticion enviando la acccion via get
    //ña otra peticion la realizara via POST, enviando los datos
    $.ajax({
        url: "../ajax/articulo.php?op=guardaryeditar",
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

//Funcion que mostrara mediante ajax los datos de la cateforia
function mostrar(idarticulo) {

    var id = new FormData();
    id.append("idarticulo", idarticulo);
    $.ajax({
        url: "../ajax/articulo.php?op=mostrar",
        type: "POST",
        data: id,
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
            $('#idcategoria').val(datos['idcategoria']);
            $('#idcategoria').selectpicker('refresh');  //refrescamos que se movio el option seleccionao
            $('#codigo').val(datos['codigo']);
            $('#nombre').val(datos['nombre']);
            $('#stock').val(datos['stock']);
            $('#descripcion').val(datos['descripcion']);
            $('#imagenmuestra').show().attr('src', '../files/articulos/' + datos['imagen']);
            $('#idarticulo').val(datos['idarticulo']);
            generarbarcode();  //invoco a la funcion para, que se muestra el barcode, si se dio click en editar
        }
    });
}


//Funcion para desactivar las categorias
function desactivar(idarticulo) {
    //mostramos la alerta, de confirmacion
    bootbox.confirm("Estas seguro de Desactivar el articulo ?", function (result) {
        //si decide quesi, hara lo siguiente
        if (result) {
            var id = new FormData();
            id.append("idarticulo", idarticulo);
            //hacemos la peticion ajax
            $.ajax({
                url: "../ajax/articulo.php?op=desactivar",
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
function activar(idarticulo) {
    //mostramos la alerta, de confirmacion
    bootbox.confirm("Estas seguro de Activar el articulo ?", function (result) {
        //si decide quesi, hara lo siguiente
        if (result) {
            var id = new FormData();
            id.append("idarticulo", idarticulo);
            //hacemos la peticion ajax
            $.ajax({
                url: "../ajax/articulo.php?op=activar",
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


/*Funcion que añadira el codigo de barras*/
function generarbarcode() {
    var codigo = $('#codigo').val();  //captirando la base del codigo de barras en string
    $('#print').show();
    JsBarcode("#barcode", codigo);  //invoco la funcion del plugin, le paso donde quiero mostrarlo, y luego el el codigo a vonvertir
}


/*Funcion que imrpimira el codigo de barras*/
function imprimir() {
    $('#print').printArea(); //seleccionamos el arrea, y ejecutamos la fucnion que enviara la orden de imprimir
}


init();