<?php
if (strlen(session_id()) < 1) {
    session_start();
};

require_once "../modelos/Venta.php";

$venta = new Venta();

$idventa = isset($_POST["idventa"]) ? limpiarCadena($_POST["idventa"]) : "";
$idcliente = isset($_POST["idcliente"]) ? limpiarCadena($_POST["idcliente"]) : "";
$idusuario = $_SESSION["idusuario"];
$tipo_comprobante = isset($_POST["tipo_comprobante"]) ? limpiarCadena($_POST["tipo_comprobante"]) : "";
$serie_comprobante = isset($_POST["serie_comprobante"]) ? limpiarCadena($_POST["serie_comprobante"]) : "";
$num_comprobante = isset($_POST["num_comprobante"]) ? limpiarCadena($_POST["num_comprobante"]) : "";
$fecha_hora = isset($_POST["fecha_hora"]) ? limpiarCadena($_POST["fecha_hora"]) : "";
$impuesto = isset($_POST["impuesto"]) ? limpiarCadena($_POST["impuesto"]) : "";
$total_venta = isset($_POST["total_venta"]) ? limpiarCadena($_POST["total_venta"]) : "";

switch ($_GET["op"]) {
    case 'guardaryeditar':
        if (empty($idventa)) {
            $rspta = $venta->insertar($idcliente, $idusuario, $tipo_comprobante, $serie_comprobante, $num_comprobante, $fecha_hora, $impuesto, $total_venta, $_POST["idarticulo"], $_POST["cantidad"], $_POST["precio_venta"], $_POST["descuento"]);
            echo $rspta ? "Venta registrada" : "No se pudieron registrar todos los datos de la venta";
        } else {
        }
        break;

    case 'anular':
        $rspta = $venta->anular($idventa);
        echo $rspta ? "Venta anulada" : "Venta no se puede anular";
        break;

    case 'mostrar':
        $rspta = $venta->mostrar($idventa);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
        break;

    case 'listarDetalle':
        $id = $_GET['id'];
        $rspta = $venta->listarDetalle($id);
        /*echo '<pre>';
        print_r($rspta);
        echo '</pre>';*/

        $total = 0;
        echo '<thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Artículo</th>
                                    <th>Cantidad</th>
                                    <th>Precio Venta</th>
                                    <th>Descuento</th>
                                    <th>Subtotal</th>
                                </thead>';
        foreach ($rspta as $dato) {

            echo '<tr class="filas">
                       <td></td>
                       <td>' . $dato['nombre'] . '</td>
                       <td>' . $dato['cantidad'] . '</td>
                       <td>' . $dato['precio_venta'] . '</td>
                       <td>' . $dato['descuento'] . '</td>
                       <td>' . $dato['subtotal'] . '</td>
                    </tr>';

            $total += $dato['precio_venta'] * $dato['cantidad'] - $dato['descuento'];
        }

        echo '<tfoot>
                                        <th>TOTAL</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th><h4 id="total">S/ ' . $total . '</h4>
                                            <input type="hidden" name="total_venta" id="total_venta">
                                        </th>
                                        </tfoot>';


        break;

    case 'listar':
        $rspta = $venta->listar();
        //Vamos a declarar un array
        $data = Array();

    /*    echo '<pre>';
        print_r($rspta);
        echo '<pre>';*/



        foreach ($rspta as $datos) {

            $btnActiveDesactive = $datos['estado'];
            if ($btnActiveDesactive == 'Aceptado') {  //si viene Aceptado , mostrara los dos bootnes
                $btnActiveDesactive = '<button class="btn btn-warning" onclick="mostrar(' . $datos['idventa'] . ')"><i class="fa fa-eye"></i></button>' .
                    ' <button class="btn btn-danger" onclick="anular(' . $datos['idventa'] . ')"><i class="fa fa-close"></i></button>';
            } else { //si es diferente a ACEPTADO, no mostraremos el boton de anular
                $btnActiveDesactive = '<button class="btn btn-warning" onclick="mostrar(' . $datos['idventa'] . ')"><i class="fa fa-eye"></i></button>';
            }
            $data[] = array(
                "0" => $btnActiveDesactive,
                "1" => $datos['fecha'],
                "2" => $datos['cliente'],
                "3" => $datos['usuario'],
                "4" => $datos['tipo_comprobante'],
                "5" => $datos['serie_comprobante'] . '-' . $datos['num_comprobante'],
                "6" => $datos['total_venta'],
                "7" => ($datos['estado'] == 'Aceptado') ? '<span class="label bg-green">Aceptado</span>' : '<span class="label bg-red">Anulado</span>'
            );
        }

        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
            "aaData" => $data);
        echo json_encode($results);

        break;

    case 'selectCliente':
        require_once "../modelos/Persona.php";
        $persona = new Persona();

        $rspta = $persona->listarC();

        foreach ($rspta as $dato) {
            echo '<option value=' . $dato['idpersona'] . '>' . $dato['nombre'] . '</option>';
        }

        break;

    case 'listarArticulosVenta':
        require_once "../modelos/Articulo.php";
        $articulo = new Articulo();

        $rspta = $articulo->listarActivosVenta();
        //Vamos a declarar un array
        $data = Array();

        foreach ($rspta as $dato) {
            $data[] = array(
                "0" => '<button class="btn btn-warning" onclick="agregarDetalle(' . $dato['idarticulo'] . ',\'' . $dato['nombre'] . '\',\'' . $dato['precio_venta'] . '\')"><span class="fa fa-plus"></span></button>',
                "1" => $dato['nombre'],
                "2" => $dato['categoria'],
                "3" => $dato['codigo'],
                "4" => $dato['stock'],
                "5" => $dato['precio_venta'],
                "6" => "<img src='../files/articulos/" . $dato['imagen'] . "' height='50px' width='50px' >"
            );
        }
        $results = array(
            "sEcho" => 1, //Información para el datatables
            "iTotalRecords" => count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
            "aaData" => $data);
        echo json_encode($results);
        break;
}
?>