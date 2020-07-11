<?php

//Conexion con BD
require_once '../config/conexion.php';

class Permiso
{
    //construtor vacio
    public function __contruct()
    {

    }


    //Metodo para mostrar todos los registros
    public function listar()
    {
        $sql = "SELECT * FROM permiso";
        return ejecutarConsulta($sql); //me devuelve los valores
    }


}


?>