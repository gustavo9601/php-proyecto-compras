<?php
require_once '../modelos/Consultas.php';


$consulta = NEW Consultas();

switch ($_GET['op']) {

    case 'comprasfecha';


       /* echo '<pre>';
        print_r($_REQUEST);
        echo '</pre>';*/

        $fecha_inicio = $_REQUEST['fecha_inicio'];
        $fecha_fin = $_REQUEST['fecha_fin'];

        $rspta = $consulta->comprasfecha($fecha_inicio, $fecha_fin);
        //codifcamos el resultado a json, para desde el JS, mostrarlo en la vista

        /* echo '<pre>';
         print_r($rspta);*/

        $data = Array();
        //recorremos todos los registros y los alamcenamos en un nuevo array,
        foreach ($rspta as $datos) {


            $data[] = array(
                "0" => $datos['fecha'],
                "1" => $datos['usuario'],
                "2" => $datos['proveedor'],
                "3" => $datos['tipo_comprobante'],
                "4" => $datos['serie_comprobante'] . ' ' . $datos['num_comprobante'],
                "5" => $datos['total_compra'],
                "6" => $datos['impuesto'],
                "7" => ($datos['estado'] == 'Aceptado' ) ? '<span class="label bg-green">Aceptado</span>' : '<span class="label bg-red">Anulado</span>'
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


    case 'ventasfechacliente';


        /* echo '<pre>';
         print_r($_REQUEST);
         echo '</pre>';*/

        $fecha_inicio = $_REQUEST['fecha_inicio'];
        $fecha_fin = $_REQUEST['fecha_fin'];
        $idcliente = $_REQUEST['idcliente'];

        $rspta = $consulta->ventasfechacliente($fecha_inicio, $fecha_fin, $idcliente);
        //codifcamos el resultado a json, para desde el JS, mostrarlo en la vista

        /* echo '<pre>';
         print_r($rspta);*/

        $data = Array();
        //recorremos todos los registros y los alamcenamos en un nuevo array,
        foreach ($rspta as $datos) {


            $data[] = array(
                "0" => $datos['fecha'],
                "1" => $datos['usuario'],
                "2" => $datos['cliente'],
                "3" => $datos['tipo_comprobante'],
                "4" => $datos['serie_comprobante'] . ' ' . $datos['num_comprobante'],
                "5" => $datos['total_venta'],
                "6" => $datos['impuesto'],
                "7" => ($datos['estado'] == 'Aceptado' ) ? '<span class="label bg-green">Aceptado</span>' : '<span class="label bg-red">Anulado</span>'
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