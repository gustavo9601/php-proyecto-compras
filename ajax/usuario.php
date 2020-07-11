<?php
require_once '../modelos/Usuario.php';
require_once '../modelos/Permiso.php';

$usuario = NEW Usuario();

//varaibles que se llenan con el post de envio
$idusuario = isset($_POST['idusuario']) ? limpiarCadena($_POST['idusuario']) : "";
$nombre = isset($_POST['nombre']) ? limpiarCadena($_POST['nombre']) : "";
$tipo_documento = isset($_POST['tipo_documento']) ? limpiarCadena($_POST['tipo_documento']) : "";
$num_documento = isset($_POST['num_documento']) ? limpiarCadena($_POST['num_documento']) : "";
$direccion = isset($_POST['direccion']) ? limpiarCadena($_POST['direccion']) : "";
$telefono = isset($_POST['telefono']) ? limpiarCadena($_POST['telefono']) : "";
$email = isset($_POST['email']) ? limpiarCadena($_POST['email']) : "";
$cargo = isset($_POST['cargo']) ? limpiarCadena($_POST['cargo']) : "";
$login = isset($_POST['login']) ? limpiarCadena($_POST['login']) : "";
$clave = isset($_POST['clave']) ? limpiarCadena($_POST['clave']) : "";
$imagen = isset($_POST['imagen']) ? limpiarCadena($_POST['imagen']) : "";


switch ($_GET['op']) {
    case 'guardaryeditar':
        //si no existe el archivo files creado temporalmnete o no ha sido cargado nada a la variable files imagen
        if (!file_exists($_FILES['imagen']['tmp_name']) || !isset($_FILES['imagen']['tmp_name'])) {
            $imagen = $_POST['imagenactual'] ? $_POST['imagenactual'] : "default.png";
        } else {

            //validacion que sea tipo imagen lo que se sube
            $extencion = explode(".", $_FILES['imagen']["name"]);  //obtengo la extencion del archivo
            if ($_FILES['imagen']["type"] == "image/jpg" ||
                $_FILES['imagen']["type"] == "image/jpeg" ||
                $_FILES['imagen']["type"] == "image/png"
            ) {
                //nombre de la imagen microtime->formato de tiempo
                //end($array)  -> devuelve la ultima posicion de un array, que para este explode lo convirtio
                $imagen = round(microtime(true)) . "." . end($extencion);
                //subimos la imagen al server
                move_uploaded_file($_FILES['imagen']['tmp_name'], '../files/usuario/' . $imagen);
            }

        }

        /*Excriptacion del password con hash SH256*/
        $clavehash = hash("SHA256", $clave);
        /*Se validam que si se envia tambien el ID usuario por el POST, es por que es un UPDATE, de lo contrario solo se insertada*/
        if (empty($idusuario)) {
            //envio tambien los permisos del formulario en forma de array
            $rspta = $usuario->insertar($nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email, $cargo, $login, $clavehash, $imagen, $_POST['permiso']);
            /*Si respuesta es 1 , devuele la respuesta, si es 0 devuelve la alerta*/
            echo $rspta ? "Usuario registrado" : "No se pudieron registrar todos los datos del usuario";
        } else {
            $rspta = $usuario->editar($idusuario, $nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email, $cargo, $login, $clavehash, $imagen, $_POST['permiso']);
            echo $rspta ? "Usuario actualizado" : "Usuario no se pudo actualizar";
        }
        break;
    case 'desactivar';
        $rspta = $usuario->desactivar($idusuario);
        echo $rspta ? "Usuario Desactivado" : "Usuario no se puede desactivar";
        break;
    case 'activar';
        $rspta = $usuario->activar($idusuario);
        echo $rspta ? "Usuario Activado" : "Usuario no se puede Activar";
        break;
    case 'mostrar';
        $rspta = $usuario->mostrar($idusuario);
        //codifcamos el resultado a json, para desde el JS, mostrarlo en la vista
        echo json_encode($rspta);
        break;


    case 'listar';
        $rspta = $usuario->listar();
        //codifcamos el resultado a json, para desde el JS, mostrarlo en la vista

        /* echo '<pre>';
         print_r($rspta);*/

        $data = Array();
        //recorremos todos los registros y los alamcenamos en un nuevo array,
        foreach ($rspta as $datos) {

            $btnActiveDesactive = $datos['condicion'];
            if ($btnActiveDesactive) {  //si viene 1 , es porque se debe ir el boton desactivar
                $btnActiveDesactive = ' <button class="btn btn-danger" onclick="desactivar(' . $datos['idusuario'] . ')"><i class="fa fa-close"></i></button>';
            } else { //si es 0 o false, debe ir el btn activar
                $btnActiveDesactive = ' <button class="btn btn-primary" onclick="activar(' . $datos['idusuario'] . ')"><i class="fa fa-check"></i></button>';
            }
            $data[] = array(
                "0" => '<button class="btn btn-warning" onclick="mostrar(' . $datos['idusuario'] . ')"><i class="fa fa-pencil"></i></button>' .
                    $btnActiveDesactive,
                "1" => $datos['nombre'],
                "2" => $datos['tipo_documento'],
                "3" => $datos['num_documento'],
                "4" => $datos['telefono'],
                "5" => $datos['email'],
                "6" => $datos['login'],
                "7" => '<img src="../files/usuario/' . $datos['imagen'] . '" height="50px" width="50px">',
                "8" => ($datos['condicion']) ? '<span class="label bg-green">Activado</span>' : '<span class="label bg-red">Desactivado</span>'
            );
        }

        //variable que definira, lsod atos para el data tables
        $resulsts = array(
            "sEcho" => 1,  //Informacion para data tables
            "iTotalRecords" => count($data), //enviamos el total de registros
            "iTotalDisplayRecords" => count($data), //enviamos el total de registros a visualizar
            "aaData" => $data
        );

        //retornamos el array , encodeado  a json para que sea interpretado por el Datatables
        echo json_encode($resulsts);

        break;

    //caso para llenar el select
    case "selectCategoria":
        require_once "../modelos/Categoria.php";
        $categoria = NEW Categoria();
        $rpsta = $categoria->select();

        /*   echo '<pre>';
           print_r($rpsta);*/

        foreach ($rpsta as $datos) {
            echo '<option value="' . $datos['idcategoria'] . '">' . $datos['nombre'] . '</option>';
        }

        break;

    //cuando se permisos
    case 'permisos':
        $permiso = NEW Permiso();
        $rpsta = $permiso->listar();


        //obtener los permisos asignados al usuario
        $id = $_GET['id'];
        $marcados = $usuario->listarmarcados($id);
        $valores = array();
        //capturar los permisos asignadors por id de suuario
        // y los alamceno en el array valores
        foreach ($marcados as $dato) {
            array_push($valores, $dato['idpermiso']);
        }

        /*   echo '<pre>';
           print_r($marcados);
           echo '<pre>';


           echo '<pre>';
           print_r($valores);
           echo '<pre>';*/

        foreach ($rpsta as $dato) {
            /*Con in_Array determinara si el Permiso estata dentro de array valores*/
            $sw = in_array($dato['idpermiso'], $valores) ? 'checked' : '';  //estructura condiconal
            //una vez ya sabemos que se encontro el permiso dentro del array valores, añadimos al input
            // que corresponda si esta cehckede o no
            echo '<li><input type="checkbox" ' . $sw . ' name="permiso[]" value="' . $dato['idpermiso'] . '"> ' . $dato['nombre'] . '</li>';
        }

        break;


    case 'verificar':
        $logina = $_POST['logina'];
        $clavea = $_POST['clavea'];

        //encripatmos la clave
        $claveHash1 = hash('SHA256', $clavea);

        $rspta = $usuario->verificar($logina, $claveHash1);

        //si viene lleno es por que existe
        session_start();
        if (isset($rspta)) {
            $_SESSION['idusuario'] = $rspta['idusuario'];
            $_SESSION['nombre'] = $rspta['nombre'];
            $_SESSION['imagen'] = $rspta['imagen'];
            $_SESSION['login'] = $rspta['login'];


            //capturamos los permisos por usuario
            $marcados = $usuario->listarmarcados($_SESSION['idusuario']);
            $valores = array();
            foreach ($marcados as $dato) {  //relleno el array con los permisos
                array_push($valores, $dato['idpermiso']);
            }

            //Dterminamos que permisos tiene el usuario y de esa forma se creara una variable de session por cada apartado
            in_array(1, $valores) ? $_SESSION['escritorio'] = 1 : $_SESSION['escritorio'] = 0;
            in_array(2, $valores) ? $_SESSION['almacen'] = 1 : $_SESSION['almacen'] = 0;
            in_array(3, $valores) ? $_SESSION['compras'] = 1 : $_SESSION['compras'] = 0;
            in_array(4, $valores) ? $_SESSION['ventas'] = 1 : $_SESSION['ventas'] = 0;
            in_array(5, $valores) ? $_SESSION['acceso'] = 1 : $_SESSION['acceso'] = 0;
            in_array(6, $valores) ? $_SESSION['consultac'] = 1 : $_SESSION['consultac'] = 0;
            in_array(7, $valores) ? $_SESSION['consultav'] = 1 : $_SESSION['consultavo'] = 0;


            //mostramos todo el objeto
            echo json_encode($rspta);
        } else {
            echo '';
        }
        break;

    case 'salir':
        @session_start();
        //limpiamos las vairables
        session_unset();
        //destruimos las sesiones
        session_destroy();
        //redireccianomos a iniico
        header('Location: ../index.php');
        break;
}

?>