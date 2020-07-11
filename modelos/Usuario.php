<?php

//Conexion con BD
require_once '../config/conexion.php';

class Usuario
{
    //construtor vacio
    public function __contruct()
    {

    }

    //Implementamos un metodo para insertar registros
    public function insertar($nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email, $cargo, $login, $clave, $imagen, $permisos)
    {

        $idUsuario = round(microtime(true));

        $sql = 'INSERT INTO usuario (idusuario, nombre, tipo_documento, num_documento, direccion, telefono, email, cargo, login, clave, imagen, condicion)
                VALUES (:id, :nombre, :tipo_documento, :num_documento, :direccion, :telefono, :email, :cargo, :login, :clave, :imagen, 1) ';
        $statement = conexionDB()->prepare($sql);
        $statement->bindParam(':id', $idUsuario, PDO::PARAM_STR);
        $statement->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $statement->bindParam(':tipo_documento', $tipo_documento, PDO::PARAM_STR);
        $statement->bindParam(':num_documento', $num_documento, PDO::PARAM_STR);
        $statement->bindParam(':direccion', $direccion, PDO::PARAM_STR);
        $statement->bindParam(':telefono', $telefono, PDO::PARAM_STR);
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->bindParam(':cargo', $cargo, PDO::PARAM_STR);
        $statement->bindParam(':login', $login, PDO::PARAM_STR);
        $statement->bindParam(':clave', $clave, PDO::PARAM_STR);
        $statement->bindParam(':imagen', $imagen, PDO::PARAM_STR);

        $statement->execute();

        $sw = true;

        for ($i = 0; $i < count($permisos); $i++) {
            $sql_detalle = 'INSERT INTO usuario_permiso (idusuario, idpermiso)
                                VALUES (:id, :permisos)';
            $statement = conexionDB()->prepare($sql_detalle);
            $statement->bindParam(':id', $idUsuario, PDO::PARAM_INT);
            $statement->bindParam(':permisos', $permisos[$i], PDO::PARAM_INT);
            $statement->execute() or $sw = false;
        }


        //retornamos true o false
        return $sw;

    }


    //metodo para editar los registros
    public function editar($idusuario, $nombre, $tipo_documento, $num_documento, $direccion, $telefono, $email, $cargo, $login, $clave, $imagen, $permisos)
    {
        $sql = 'UPDATE usuario 
                  SET nombre = :nombre, tipo_documento = :tipo_documento, num_documento = :num_documento, 
                  direccion = :direccion, telefono = :telefono, email = :email, cargo = :cargo, login = :login, clave = :clave, imagen = :imagen 
                  WHERE idusuario = :id';
        $statement = conexionDB()->prepare($sql);
        $statement->bindParam(':id', $idusuario, PDO::PARAM_STR);
        $statement->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $statement->bindParam(':tipo_documento', $tipo_documento, PDO::PARAM_STR);
        $statement->bindParam(':num_documento', $num_documento, PDO::PARAM_STR);
        $statement->bindParam(':direccion', $direccion, PDO::PARAM_STR);
        $statement->bindParam(':telefono', $telefono, PDO::PARAM_STR);
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->bindParam(':cargo', $cargo, PDO::PARAM_STR);
        $statement->bindParam(':login', $login, PDO::PARAM_STR);
        $statement->bindParam(':clave', $clave, PDO::PARAM_STR);
        $statement->bindParam(':imagen', $imagen, PDO::PARAM_STR);
        if ($statement->execute()) {
            /*Eliminamos todos los permisos asignados, para volver a colocar unos nuevos*/
            $sql2 = 'DELETE FROM usuario_permiso WHERE idusuario = ' . $idusuario;
            ejecutarConsulta($sql2);


            /*Insertamos de nuevo los permisos*/
            $sw = true;
            for ($i = 0; $i < count($permisos); $i++) {
                $sql_detalle = "INSERT INTO usuario_permiso (idusuario, idpermiso)
                                VALUES ($idusuario , $permisos[$i]);";
                //echo $sql_detalle;
                ejecutarConsulta($sql_detalle);
            }

            //retornamos true o false
            return true;
        } else {
            return 0;
        }
    }

    //actualizar condicion de la categoria a inactivo
    public function desactivar($idusuario)
    {
        $sql = 'UPDATE usuario SET condicion = 0 WHERE
                idusuario = :id';
        $statement = conexionDB()->prepare($sql);
        $statement->bindParam(':id', $idusuario, PDO::PARAM_INT);
        if ($statement->execute()) {
            return 1;
        } else {
            return 0;
        }
    }

    //actualizar condicion de la categoria a activo
    public function activar($idusuario)
    {
        $sql = 'UPDATE usuario SET condicion = 1 WHERE
                idusuario = :id';
        $statement = conexionDB()->prepare($sql);
        $statement->bindParam(':id', $idusuario, PDO::PARAM_INT);
        if ($statement->execute()) {
            return 1;
        } else {
            return 0;
        }
    }

    //Metodo para mostrar todos los registros por id
    public function mostrar($idusuario)
    {
        $sql = "SELECT * FROM usuario WHERE idusuario = $idusuario";
        return ejecutarConsultaSimpleFila($sql); //me devuelve los valores
    }

    //Metodo para mostrar todos los registros
    public function listar()
    {
        $sql = "SELECT * FROM usuario";
        return ejecutarConsulta($sql); //me devuelve los valores
    }


    //funcion que devolvera los permisos marcados por id usuario
    public function listarmarcados($idusuario)
    {
        $sql = "SELECT * FROM usuario_permiso WHERE idusuario = $idusuario";
        return ejecutarConsulta($sql); //me devuelve los valores
    }


    //funcion que vierfica el acceso al sistema
    public function verificar($login, $clave)
    {
        $sql = "SELECT * FROM usuario WHERE login = '$login' AND clave = '$clave' AND condicion = 1";
        //echo $sql;
        return ejecutarConsultaSimpleFila($sql); //me devuelve los valores
    }


}


?>