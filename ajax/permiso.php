<?php
require_once '../modelos/Permiso.php';


$permiso = NEW Permiso();

switch ($_GET['op']) {

    case 'listar';
        $rspta = $permiso->listar();
        //codifcamos el resultado a json, para desde el JS, mostrarlo en la vista

        /* echo '<pre>';
         print_r($rspta);*/

        $data = Array();
        //recorremos todos los registros y los alamcenamos en un nuevo array,
        foreach ($rspta as $datos) {

            $data[] = array(
                "0" => $datos['nombre']
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