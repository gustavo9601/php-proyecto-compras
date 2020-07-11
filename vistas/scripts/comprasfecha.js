var tabla;
//Funcion que se ejcuta al inciio

function init() {

    listar();

    //si se realiza el cambio sobre alguno de los input date, se ejecutara nuevamente la funcion
    $('#fecha_inicio').on('change', function () {

            listar();
        }
    );
    $('#fecha_fin').on('change', function () {

            listar();
        }
    );

}

//Funcion listar
function listar() {
        //tabla.dataTable.Destory();
   var fecha_inicio = $('#fecha_inicio').val();
   var fecha_fin = $('#fecha_fin').val();



    tabla=$('#tbllistado').dataTable(
        {
            "aProcessing": true,//Activamos el procesamiento del datatables
            "aServerSide": true,//Paginación y filtrado realizados por el servidor
            dom: 'Bfrtip',//Definimos los elementos del control de tabla
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdf'
            ],
            "ajax": {
                url: '../ajax/consultas.php?op=comprasfecha',
                data: {
                    fecha_inicio: fecha_inicio,
                    fecha_fin: fecha_fin
                },
                type: "get",
                dataType: "json",
                error: function (e) {
                    console.log(e.responseText);
                }
            },
            "bDestroy": true,
            "iDisplayLength": 5,//Paginación
            "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
        }).DataTable();


}


init();