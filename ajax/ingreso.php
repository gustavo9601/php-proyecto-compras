<?php

require_once '../modelos/Ingreso.php';

//si la cantidad de sessiones es menor a 1 creamos una nueva
if (strlen(session_id()) < 1) {
    session_start();
};
$ingreso = NEW Ingreso();

//varaibles que se llenan con el post de envio
$idingreso = isset($_POST['idingreso']) ? limpiarCadena($_POST['idingreso']) : "";
$idproveedor = isset($_POST['idproveedor']) ? limpiarCadena($_POST['idproveedor']) : "";
$idusuario = $_SESSION['idusuario'];
$tipo_Comrpobante = isset($_POST['tipo_comprobante']) ? limpiarCadena($_POST['tipo_comprobante']) : "";
$serie_comprobante = isset($_POST['serie_comprobante']) ? limpiarCadena($_POST['serie_comprobante']) : "";
$num_comprobante = isset($_POST['num_comprobante']) ? limpiarCadena($_POST['num_comprobante']) : "";
$fecha_hora = isset($_POST['fecha_hora']) ? limpiarCadena($_POST['fecha_hora']) : "";
$impuesto = isset($_POST['impuesto']) ? limpiarCadena($_POST['impuesto']) : "";
$total_compra = isset($_POST['total_compra']) ? limpiarCadena($_POST['total_compra']) : "";


switch ($_GET['op']) {
    case 'guardaryeditar':

        /*Se validam que si se envia tambien el ID categoria por el POST, es por que es un UPDATE, de lo contrario solo se insertada*/
        if (empty($idCategoria)) {
            $rspta = $ingreso->insertar($idproveedor, $idusuario, $tipo_Comrpobante, $serie_comprobante, $num_comprobante, $fecha_hora, $impuesto, $total_compra,
                $_POST['idarticulo'], $_POST['cantidad'], $_POST['precio_compra'], $_POST['precio_venta']);
            /*Si respuesta es 1 , devuele la respuesta, si es 0 devuelve la alerta*/
            echo $rspta ? "Ingresor registrado" : "No se pudieron registrar todos los datos del ingreso";
        } else {
        }
        break;

    case 'anular';
        $rspta = $ingreso->anular($idingreso);
        echo $rspta ? "Ingreso Anulado" : "Ingreso no se puede agregar";
        break;

    case 'mostrar';
        $rspta = $ingreso->mostrar($idingreso);
        //codifcamos el resultado a json, para desde el JS, mostrarlo en la vista
        echo json_encode($rspta);
        break;

    case 'listarDetalle':
        $id = $_GET['id'];
        $rspta = $ingreso->listarDetalle($id);
        $total = 0;
        echo ' <thead style="background: #A9D0F5;">
                                        <th>Opciones</th>
                                        <th>Articulo</th>
                                        <th>Cantidad</th>
                                        <th>Precio Compra</th>
                                        <th>Precio Venta</th>
                                        <th>Subtotal</th>
                                        </thead>';
        foreach ($rspta as $dato) {

            echo '<tr class="filas">
                       <td></td>
                       <td>' . $dato['nombre'] . '</td>
                       <td>' . $dato['cantidad'] . '</td>
                       <td>' . $dato['precio_compra'] . '</td>
                       <td>' . $dato['precio_venta'] . '</td>
                       <td>' . $dato['precio_compra'] * $dato['cantidad'] . '</td>

                    </tr>';

            $total += $dato['precio_compra'] * $dato['cantidad'];
        }

        echo '<tfoot>
                                        <th>TOTAL</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th><h4 id="total">S/ ' . $total . '</h4>
                                            <input type="hidden" name="total_compra" id="total_compra">
                                        </th>
                                        </tfoot>';
        break;

    case 'listar';
        $rspta = $ingreso->listar();
        //codifcamos el resultado a json, para desde el JS, mostrarlo en la vista

        /* echo '<pre>';
         print_r($rspta);*/

        $data = Array();
        //recorremos todos los registros y los alamcenamos en un nuevo array,
        foreach ($rspta as $datos) {

            $btnActiveDesactive = $datos['estado'];
            if ($btnActiveDesactive == 'Aceptado') {  //si viene Aceptado , mostrara los dos bootnes
                $btnActiveDesactive = ' <button class="btn btn-warning" onclick="mostrar(' . $datos['idingreso'] . ')"><i class="fa fa-eye"></i></button>' . '<button class="btn btn-danger" onclick="anular(' . $datos['idingreso'] . ')"><i class="fa fa-close"></i></button>';
            } else { //si es diferente a ACEPTADO, no mostraremos el boton de anular
                $btnActiveDesactive = ' <button class="btn btn-danger" onclick="mostrar(' . $datos['idingreso'] . ')"><i class="fa fa-eye"></i></button>';
            }
            $data[] = array(
                "0" => $btnActiveDesactive,
                "1" => $datos['fecha'],
                "2" => $datos['proveedor'],
                "3" => $datos['usuario'],
                "4" => $datos['tipo_comprobante'],
                "5" => $datos['serie_comprobante'] . '-' . $datos['num_comprobante'],
                "6" => $datos['total_compra'],
                "7" => ($datos['estado'] == 'Aceptado') ? '<span class="label bg-green">Aceptado</span>' : '<span class="label bg-red">Anulado</span>'
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


    case 'selectProveedor':
        require_once '../modelos/Persona.php';
        $persona = new Persona();
        $rspta = $persona->listarp();


        foreach ($rspta as $dato) {
            echo '<option value="' . $dato['idpersona'] . '">' . $dato['nombre'] . '</option>';
        }


        break;


    case 'listarArticulos':
        require_once '../modelos/Articulo.php';
        $articulo = NEW Articulo();
        $rspta = $articulo->listarActivos();
        //codifcamos el resultado a json, para desde el JS, mostrarlo en la vista

        /* echo '<pre>';
         print_r($rspta);*/

        $data = Array();
        //recorremos todos los registros y los alamcenamos en un nuevo array,
        foreach ($rspta as $datos) {

            // \ uso el backslash me perite inertar comillas en la cadena
            $data[] = array(
                "0" => '<button class="btn btn-warning" onclick="agregarDetalle(' . $datos['idarticulo'] . ',\'' . $datos['nombreart'] . '\');"><span class="fa fa-plus"></span></button>',
                "1" => $datos['nombreart'],
                "2" => $datos['nombrecat'],
                "3" => $datos['codigo'],
                "4" => $datos['stock'],
                "5" => '<img src="../files/articulos/' . $datos['imagen'] . '" height="50px" width="50px">'
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