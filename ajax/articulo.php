<?php
require_once '../modelos/Articulo.php';


$articulo = NEW Articulo();

//varaibles que se llenan con el post de envio
$idarticulo = isset($_POST['idarticulo']) ? limpiarCadena($_POST['idarticulo']) : "";
$idCategoria = isset($_POST['idcategoria']) ? limpiarCadena($_POST['idcategoria']) : "";
$codigo = isset($_POST['codigo']) ? limpiarCadena($_POST['codigo']) : "";
$stock = isset($_POST['stock']) ? limpiarCadena($_POST['stock']) : "";
$descripcion = isset($_POST['descripcion']) ? limpiarCadena($_POST['descripcion']) : "";
$imagen = isset($_POST['imagen']) ? limpiarCadena($_POST['imagen']) : "";
$nombre = isset($_POST['nombre']) ? limpiarCadena($_POST['nombre']) : "";

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
                move_uploaded_file($_FILES['imagen']['tmp_name'], '../files/articulos/' . $imagen);
            }

        }

        /*Se validam que si se envia tambien el ID categoria por el POST, es por que es un UPDATE, de lo contrario solo se insertada*/
        if (empty($idarticulo)) {
            $rspta = $articulo->insertar($idCategoria, $codigo, $nombre, $stock, $descripcion, $imagen);
            /*Si respuesta es 1 , devuele la respuesta, si es 0 devuelve la alerta*/
            echo $rspta ? "Articulo registrado" : "Articulo no se pudo registrar";
        } else {
            $rspta = $articulo->editar($idarticulo, $idCategoria, $codigo, $nombre, $stock, $descripcion, $imagen);
            echo $rspta ? "Articulo actualizado" : "Articulo no se pudo actualizar";
        }
        break;

    case 'desactivar';
        $rspta = $articulo->desactivar($idarticulo);
        echo $rspta ? "Articulo Desactivado" : "Articulo no se puede desactivar";
        break;


    case 'activar';
        $rspta = $articulo->activar($idarticulo);
        echo $rspta ? "Artiuclo Activado" : "Articulo no se puede Activar";

        break;


    case 'mostrar';
        $rspta = $articulo->mostrar($idarticulo);
        //codifcamos el resultado a json, para desde el JS, mostrarlo en la vista
        echo json_encode($rspta);
        break;


    case 'listar';
        $rspta = $articulo->listar();
        //codifcamos el resultado a json, para desde el JS, mostrarlo en la vista

        /* echo '<pre>';
         print_r($rspta);*/

        $data = Array();
        //recorremos todos los registros y los alamcenamos en un nuevo array,
        foreach ($rspta as $datos) {

            $btnActiveDesactive = $datos['condicion'];
            if ($btnActiveDesactive) {  //si viene 1 , es porque se debe ir el boton desactivar
                $btnActiveDesactive = ' <button class="btn btn-danger" onclick="desactivar(' . $datos['idarticulo'] . ')"><i class="fa fa-close"></i></button>';
            } else { //si es 0 o false, debe ir el btn activar
                $btnActiveDesactive = ' <button class="btn btn-primary" onclick="activar(' . $datos['idarticulo'] . ')"><i class="fa fa-check"></i></button>';
            }
            $data[] = array(
                "0" => '<button class="btn btn-warning" onclick="mostrar(' . $datos['idarticulo'] . ')"><i class="fa fa-pencil"></i></button>' .
                    $btnActiveDesactive,
                "1" => $datos['nombreart'],
                "2" => $datos['nombrecat'],
                "3" => $datos['codigo'],
                "4" => $datos['stock'],
                "5" => '<img src="../files/articulos/' . $datos['imagen'] . '" height="50px" width="50px">',
                "6" => ($datos['condicion']) ? '<span class="label bg-green">Activado</span>' : '<span class="label bg-red">Desactivado</span>'
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
}

?>