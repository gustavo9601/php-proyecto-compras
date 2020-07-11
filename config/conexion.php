<?php
/*===============================*/
//CONEXION DB
/*================================*/

require_once 'global.php';

function conexionDB()
{

    try {
        $conexion = NEW PDO(
            'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME,
            DB_USERNAME,
            DB_PASSWORD
        );

        if (!$conexion) {
            die("<h1>Erro Conect DB</h1>");
        } else {
            return $conexion;
        }

    } catch (PDOException $error) {
        echo $error->getMessage();
    }

}


//validando que no exista la funcion, si la creamos
if (!function_exists('ejecutarConsulta')) {

    #FUNCION QUE DEVUELVE TODAS LAS FILAS DE LA CONSULTA
    function ejecutarConsulta($sql)
    {
        $statement = conexionDB()->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
        return $result;
    }

    #FUNCION QUE DEVUELVE SOLO UNA FILA DE LA CONSULTA
    function ejecutarConsultaSimpleFila($sql)
    {


        $statement = conexionDB()->prepare($sql);
        $statement->execute();
        $result = $statement->fetch();

        return $result;
    }


    #FUNCION QUE DEVUELVE EL ID QUE SIGUE PDESPUES DE HABER INSERTADO
    function ejecutarConsulta_retornarID($sql)
    {
        $statement = conexionDB()->prepare($sql);
        $statement->execute();
        $result = conexionDB()->lastInsertId();
        return $result;
    }

    #FUNCION QUE LIMPIA LAS CADENAS
    function limpiarCadena($str)
    {
        $str = trim($str); //quita spacios
        $str = htmlspecialchars($str); //quita caracteres especiales
        return $str;
    }


}


?>