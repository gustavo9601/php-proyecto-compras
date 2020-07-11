<?php
require_once '../modelos/Categoria.php';


$categoria = NEW Categoria();

//varaibles que se llenan con el post de envio
$idCategoria = isset($_POST['idcategoria']) ? limpiarCadena($_POST['idcategoria']) : "";
$nombre = isset($_POST['nombre']) ? limpiarCadena($_POST['nombre']) : "";
$descripcion = isset($_POST['descripcion']) ? limpiarCadena($_POST['descripcion']) : "";


switch ($_GET['op']) {
    case 'guardaryeditar':

        /*Se validam que si se envia tambien el ID categoria por el POST, es por que es un UPDATE, de lo contrario solo se insertada*/
        if (empty($idCategoria)) {
            $rspta = $categoria->insertar($nombre, $descripcion);
            /*Si respuesta es 1 , devuele la respuesta, si es 0 devuelve la alerta*/
            echo $rspta ? "Categoria registrada" : "Categoria no se pudo registrar";
        } else {
            $rspta = $categoria->editar($idCategoria, $nombre, $descripcion);
            echo $rspta ? "Categoria actualizada" : "Categoria no se pudo actualizar";
        }
        break;

    case 'desactivar';
        $rspta = $categoria->desactivar($idCategoria);
        echo $rspta ? "Categoria Desactivada" : "Categoria no se puede desactivar";
        break;


    case 'activar';
        $rspta = $categoria->activar($idCategoria);
        echo $rspta ? "Categoria Activada" : "Categoria no se puede Activar";

        break;


    case 'mostrar';
        $rspta = $categoria->mostrar($idCategoria);
        //codifcamos el resultado a json, para desde el JS, mostrarlo en la vista
        echo json_encode($rspta);
        break;


    case 'listar';
        $rspta = $categoria->listar();
        //codifcamos el resultado a json, para desde el JS, mostrarlo en la vista

        /* echo '<pre>';
         print_r($rspta);*/

        $data = Array();
        //recorremos todos los registros y los alamcenamos en un nuevo array,
        foreach ($rspta as $datos) {

            $btnActiveDesactive = $datos['condicion'];
            if ($btnActiveDesactive) {  //si viene 1 , es porque se debe ir el boton desactivar
                $btnActiveDesactive = ' <button class="btn btn-danger" onclick="desactivar(' . $datos['idcategoria'] . ')"><i class="fa fa-close"></i></button>';
            } else { //si es 0 o false, debe ir el btn activar
                $btnActiveDesactive = ' <button class="btn btn-primary" onclick="activar(' . $datos['idcategoria'] . ')"><i class="fa fa-check"></i></button>';
            }
            $data[] = array(
                "0" => '<button class="btn btn-warning" onclick="mostrar(' . $datos['idcategoria'] . ')"><i class="fa fa-pencil"></i></button>' .
                    $btnActiveDesactive,
                "1" => $datos['nombre'],
                "2" => $datos['descripcion'],
                "3" => ($datos['condicion']) ? '<span class="label bg-green">Activado</span>' : '<span class="label bg-red">Desactivado</span>'
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
}

?>