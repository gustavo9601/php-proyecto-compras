<?php

//Conexion con BD
require_once '../config/conexion.php';

class Articulo
{
    //construtor vacio
    public function __contruct()
    {

    }

    //Implementamos un metodo para insertar registros
    public function insertar($idcategoria, $codigo, $nombre, $stock, $descripcion, $imagen)
    {

        /* $datos = func_get_args();
         echo '<pre>';
         print_r($datos);*/

        $sql = 'INSERT INTO articulo (idcategoria, codigo, nombre, stock, descripcion, imagen, condicion)
                VALUES (:id, :cod, :nombre, :stock, :descripcion, :imagen, 1) ';
        $statement = conexionDB()->prepare($sql);
        $statement->bindParam(':id', $idcategoria, PDO::PARAM_INT);
        $statement->bindParam(':cod', $codigo, PDO::PARAM_INT);
        $statement->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $statement->bindParam(':stock', $stock, PDO::PARAM_STR);
        $statement->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        $statement->bindParam(':imagen', $imagen, PDO::PARAM_STR);
        if ($statement->execute()) {
            return 1;
        } else {
            return 0;
        }
    }


    //metodo para editar los registros
    public function editar($idarticulo, $idcategoria, $codigo, $nombre, $stock, $descripcion, $imagen)
    {
        $sql = 'UPDATE articulo SET idcategoria = :idcat, codigo = :cod, nombre = :nombre, stock = :stock, descripcion = :descripcion, imagen = :imagen
                WHERE idarticulo = :idart';
        $statement = conexionDB()->prepare($sql);
        $statement->bindParam(':idcat', $idcategoria, PDO::PARAM_INT);
        $statement->bindParam(':idart', $idarticulo, PDO::PARAM_INT);
        $statement->bindParam(':cod', $codigo, PDO::PARAM_STR);
        $statement->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $statement->bindParam(':stock', $stock, PDO::PARAM_STR);
        $statement->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        $statement->bindParam(':imagen', $imagen, PDO::PARAM_STR);
        if ($statement->execute()) {
            return 1;
        } else {
            return 0;
        }
    }

    //descartivar el articulo
    public function desactivar($idArticulo)
    {
        $sql = 'UPDATE articulo SET condicion = 0 WHERE
                idarticulo = :id';
        $statement = conexionDB()->prepare($sql);
        $statement->bindParam(':id', $idArticulo, PDO::PARAM_INT);
        if ($statement->execute()) {
            return 1;
        } else {
            return 0;
        }
    }

    //actualizar condicion articulo a a activo
    public function activar($idArticulo)
    {
        $sql = 'UPDATE articulo SET condicion = 1 WHERE
                idarticulo = :id';
        $statement = conexionDB()->prepare($sql);
        $statement->bindParam(':id', $idArticulo, PDO::PARAM_INT);
        if ($statement->execute()) {
            return 1;
        } else {
            return 0;
        }
    }

    //Metodo para mostrar todos los registros por id
    public function mostrar($idArticulo)
    {
        $sql = "SELECT * FROM articulo WHERE idarticulo = $idArticulo";
        return ejecutarConsultaSimpleFila($sql); //me devuelve los valores
    }

    //Metodo para mostrar todos los registros
    public function listar()
    {
        $sql = "SELECT A.idarticulo, A.idcategoria, A.codigo, A.nombre AS nombreart, A.stock, A.descripcion AS descripcionart, A.imagen, A.condicion, B.nombre AS nombrecat, 
                B.descripcion AS descripcioncat FROM articulo AS A INNER JOIN categoria AS B ON A.idcategoria = B.idcategoria";

        return ejecutarConsulta($sql); //me devuelve los valores


    }


    //Metodo para mostrar todos los registros activos

    public function listarActivos()
    {
        $sql = "SELECT A.idarticulo, A.idcategoria, A.codigo, A.nombre AS nombreart, A.stock, A.descripcion AS descripcionart, A.imagen, A.condicion, B.nombre AS nombrecat, 
                B.descripcion AS descripcioncat FROM articulo AS A INNER JOIN categoria AS B ON A.idcategoria = B.idcategoria WHERE a.condicion = 1";
        return ejecutarConsulta($sql); //me devuelve los valores
    }


    //Mostrara los articulos activos
    // muestra el ultimo precio de venta, de acuerdo al ingreso realizado
    public function listarActivosVenta()
    {
        $sql = "SELECT a.idarticulo, a.idcategoria, c.nombre as categoria, a.codigo, a.nombre
, a.stock, (SELECT precio_venta FROM detalle_ingreso WHERE idarticulo = a.idarticulo ORDER BY iddetalle_ingreso desc limit 0,1)
as precio_venta, a.descripcion, a.imagen, a.condicion  FROM articulo a
INNER JOIN categoria c ON a.idcategoria = c.idcategoria WHERE a.condicion = '1'";

        return ejecutarConsulta($sql);

    }

}


?>