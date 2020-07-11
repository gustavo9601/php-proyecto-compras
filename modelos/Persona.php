<?php

//Conexion con BD
require_once '../config/conexion.php';

class Persona
{
    //construtor vacio
    public function __contruct()
    {

    }

    //Implementamos un metodo para insertar registros
    public function insertar($tipo_persona, $nombre, $tipo_documento, $num_documemento, $direccion, $telefono, $email)
    {
        $sql = 'INSERT INTO persona (tipo_persona, nombre, tipo_documento, num_documento, direccion, telefono, email) VALUES
                                    (:tipo_persona, :nombre, :tipo_documento, :num_doc, :direccion, :telefono, :email)';
        $statement = conexionDB()->prepare($sql);
        $statement->bindParam(':tipo_persona', $tipo_persona, PDO::PARAM_STR);
        $statement->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $statement->bindParam(':tipo_documento', $tipo_documento, PDO::PARAM_STR);
        $statement->bindParam(':num_doc', $num_documemento, PDO::PARAM_STR);
        $statement->bindParam(':direccion', $direccion, PDO::PARAM_STR);
        $statement->bindParam(':telefono', $telefono, PDO::PARAM_STR);
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        if ($statement->execute()) {
            return 1;
        } else {
            return 0;
        }

    }


    //metodo para editar los registros
    public function editar($id_persona, $tipo_persona, $nombre, $tipo_documento, $num_documemento, $direccion, $telefono, $email)
    {
        $sql = 'UPDATE persona SET tipo_persona = :tipo_persona, nombre = :nombre, tipo_documento = :tipo_documento,
                num_documento = :num_documento, direccion = :direccion, telefono = :telefono, email = :email
                WHERE idpersona = :idpersona';
        $statement = conexionDB()->prepare($sql);
        $statement = conexionDB()->prepare($sql);
        $statement->bindParam(':tipo_persona', $tipo_persona, PDO::PARAM_STR);
        $statement->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $statement->bindParam(':tipo_documento', $tipo_documento, PDO::PARAM_STR);
        $statement->bindParam(':num_documento', $num_documemento, PDO::PARAM_INT);
        $statement->bindParam(':direccion', $direccion, PDO::PARAM_STR);
        $statement->bindParam(':telefono', $telefono, PDO::PARAM_STR);
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->bindParam(':idpersona', $id_persona, PDO::PARAM_INT);
        if ($statement->execute()) {
            return 1;
        } else {
            return 0;
        }
    }

    //actualizar condicion de la categoria a inactivo
    public function eliminar($idpersona)
    {
        $sql = 'DELETE FROM persona WHERE idpersona = :idpersona';
        $statement = conexionDB()->prepare($sql);
        $statement->bindParam(':idpersona', $idpersona, PDO::PARAM_INT);
        if ($statement->execute()) {
            return 1;
        } else {
            return 0;
        }
    }


    //Metodo para mostrar todos los registros por id
    public function mostrar($idpersona)
    {
        $sql = "SELECT * FROM persona WHERE idpersona = $idpersona";
        return ejecutarConsultaSimpleFila($sql); //me devuelve los valores
    }

    //Metodo para mostrar todos los registros
    public function listarp()
    {
        $sql = "SELECT * FROM persona WHERE tipo_persona = 'Proveedor'";
        return ejecutarConsulta($sql); //me devuelve los valores
    }

    //Metodo para mostrar todos los registros
    public function listarc()
    {
        $sql = "SELECT * FROM persona WHERE tipo_persona = 'Cliente'";
        return ejecutarConsulta($sql); //me devuelve los valores
    }
}


?>