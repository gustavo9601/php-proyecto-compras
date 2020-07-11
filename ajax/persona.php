<?php
require_once '../modelos/Persona.php';


$persona = NEW Persona();

//varaibles que se llenan con el post de envio
$idpersona = isset($_POST['idpersona']) ? limpiarCadena($_POST['idpersona']) : "";
$tipo_persona = isset($_POST['tipo_persona']) ? limpiarCadena($_POST['tipo_persona']) : "";
$nombre = isset($_POST['nombre']) ? limpiarCadena($_POST['nombre']) : "";
$tipo_documento = isset($_POST['tipo_documento']) ? limpiarCadena($_POST['tipo_documento']) : "";
$num_documento = isset($_POST['num_documento']) ? limpiarCadena($_POST['num_documento']) : "";
$direccion = isset($_POST['direccion']) ? limpiarCadena($_POST['direccion']) : "";
$telefono = isset($_POST['telefono']) ? limpiarCadena($_POST['telefono']) : "";
$email = isset($_POST['email']) ? limpiarCadena($_POST['email']) : "";

switch ($_GET['op']) {
    case 'guardaryeditar':

        /*Se validam que si se envia tambien el ID categoria por el POST, es por que es un UPDATE, de lo contrario solo se insertada*/
        if (empty($idpersona)) {
            $rspta = $persona->insertar($tipo_persona, $nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email);
            /*Si respuesta es 1 , devuele la respuesta, si es 0 devuelve la alerta*/
            echo $rspta ? "Persona registrada" : "Persona no se pudo registrar";
        } else {
            $rspta = $persona->editar($idpersona, $tipo_persona, $nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email);
            echo $rspta ? "Persona actualizada" : "Persona no se pudo actualizar";
        }
        break;

    case 'eliminar';
        $rspta = $persona->eliminar($idpersona);
        echo $rspta ? "Persona Eliminada" : "Persona no se puede Elimiar";
        break;

    case 'mostrar';
        $rspta = $persona->mostrar($idpersona);
        //codifcamos el resultado a json, para desde el JS, mostrarlo en la vista
        echo json_encode($rspta);
        break;


    case 'listarp';
        $rspta = $persona->listarp();
        //codifcamos el resultado a json, para desde el JS, mostrarlo en la vista

        /* echo '<pre>';
         print_r($rspta);*/

        $data = Array();
        //recorremos todos los registros y los alamcenamos en un nuevo array,
        foreach ($rspta as $datos) {

            //arrray que alacenara las posiciones de lo que devuleva la bd, y lo devolveremos parseado a json
            $data[] = array(
                "0" => '<button class="btn btn-warning" onclick="mostrar(' . $datos['idpersona'] . ')"><i class="fa fa-pencil"></i></button>' .
                    '<button class="btn btn-danger" onclick="eliminar(' . $datos['idpersona'] . ')"><i class="fa fa-trash"></i></button>',
                "1" => $datos['nombre'],
                "2" => $datos['tipo_documento'],
                "3" => $datos['num_documento'],
                "4" => $datos['telefono'],
                "5" => $datos['email']);
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

    case 'listarc';
        $rspta = $persona->listarc();
        //codifcamos el resultado a json, para desde el JS, mostrarlo en la vista

        /* echo '<pre>';
         print_r($rspta);*/

        $data = Array();
        //recorremos todos los registros y los alamcenamos en un nuevo array,
        foreach ($rspta as $datos) {

            //arrray que alacenara las posiciones de lo que devuleva la bd, y lo devolveremos parseado a json
            $data[] = array(
                "0" => '<button class="btn btn-warning" onclick="mostrar(' . $datos['idpersona'] . ')"><i class="fa fa-pencil"></i></button>' .
                    '<button class="btn btn-danger" onclick="eliminar(' . $datos['idpersona'] . ')"><i class="fa fa-trash"></i></button>',
                "1" => $datos['nombre'],
                "2" => $datos['tipo_documento'],
                "3" => $datos['num_documento'],
                "4" => $datos['telefono'],
                "5" => $datos['email']);
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
}

?>