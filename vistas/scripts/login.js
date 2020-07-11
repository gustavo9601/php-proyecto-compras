/*Cpturamos el submit desde el formulario de iniico de sesion*/
$('#frmAcceso').on('submit', function (e) {
//quita el action y no ejecuta nada mas
    e.preventDefault();

    //captura los valores del formulario
    logina = $('#logina').val();
    clavea = $('#clavea').val();


    //metodo post sencillo
    //url pasando por get la opcion a realizar
    // envio un array los valores
    //ejecuto una funcion con lo que me devoleuva
    $.post("../ajax/usuario.php?op=verificar",
        {
            "logina": logina,
            "clavea": clavea
        },
        function (data) {
        console.log(data);
            if (data == false || data == "false") {
                bootbox.alert("Usuario y/o contraseña invalido");

            } else {
                //si es diferente a vacio, redireccionara a categoria.php
                $(location).attr("href", "escritorio.php");
            }
        }
    )

});