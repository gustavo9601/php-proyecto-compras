<?php

//Conexion con BD
require_once '../config/conexion.php';

class Categoria
{
    //construtor vacio
    public function __contruct()
    {

    }

    //Implementamos un metodo para insertar registros
    public function insertar($nombre, $descripcion)
    {
        $sql = 'INSERT INTO categoria (nombre, descripcion, condicion)
                VALUES (:nombre, :descripcion, 1) ';
        $statement = conexionDB()->prepare($sql);
        $statement->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $statement->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        if ($statement->execute()) {
            return 1;
        } else {
            return 0;
        }

    }


    //metodo para editar los registros
    public function editar($idCategoria, $nombre, $descripcion)
    {
        $sql = 'UPDATE categoria SET nombre = :nombre, descripcion = :descripcion WHERE
                idcategoria = :id';
        $statement = conexionDB()->prepare($sql);
        $statement->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $statement->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        $statement->bindParam(':id', $idCategoria, PDO::PARAM_INT);
        if ($statement->execute()) {
            return 1;
        } else {
            return 0;
        }
    }

    //actualizar condicion de la categoria a inactivo
    public function desactivar($idCategoria)
    {
        $sql = 'UPDATE categoria SET condicion = 0 WHERE
                idcategoria = :id';
        $statement = conexionDB()->prepare($sql);
        $statement->bindParam(':id', $idCategoria, PDO::PARAM_INT);
        if ($statement->execute()) {
            return 1;
        } else {
            return 0;
        }
    }

    //actualizar condicion de la categoria a activo
    public function activar($idCategoria)
    {
        $sql = 'UPDATE categoria SET condicion = 1 WHERE
                idcategoria = :id';
        $statement = conexionDB()->prepare($sql);
        $statement->bindParam(':id', $idCategoria, PDO::PARAM_INT);
        if ($statement->execute()) {
            return 1;
        } else {
            return 0;
        }
    }

    //Metodo para mostrar todos los registros por id
    public function mostrar($idCategoria)
    {
        $sql = "SELECT * FROM categoria WHERE idcategoria = $idCategoria";
        return ejecutarConsultaSimpleFila($sql); //me devuelve los valores
    }

    //Metodo para mostrar todos los registros
    public function listar()
    {
        $sql = "SELECT * FROM categoria";
        return ejecutarConsulta($sql); //me devuelve los valores
    }


//mostrar los registross para el select
    public function select()
    {//solo categorias activas
        $sql = "SELECT * FROM categoria WHERE condicion=1";
        return ejecutarConsulta($sql); //me devuelve los valores
    }


}


?>