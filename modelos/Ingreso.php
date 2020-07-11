<?php

//Conexion con BD
require_once '../config/conexion.php';

class Ingreso
{
    //construtor vacio
    public function __contruct()
    {

    }

    //Implementamos un metodo para insertar registros
    public function insertar($idproveedor, $idusuario, $tipo_comprobante, $serie_comprobante, $num_comprobante, $fecha_hora, $impuesto, $total_compra,
                             $idarticulo, $cantidad, $precio_compra, $precio_venta)
    {

        $idIngresoNuevo = round(microtime(true));

        $sql = 'INSERT INTO ingreso (idingreso ,idproveedor, idusuario, tipo_comprobante, serie_comprobante, num_comprobante, fecha_hora, impuesto, total_compra, estado) 
                VALUES ( :idingreso, :idproveedor, :idusuario, :tipo_comprobante, :serie_comprobante,:num_comprobante, :fecha_hora, :impuesto, :total_compra, "Aceptado")';
        $statement = conexionDB()->prepare($sql);
        $statement->bindParam(':idingreso', $idIngresoNuevo, PDO::PARAM_STR);
        $statement->bindParam(':idproveedor', $idproveedor, PDO::PARAM_STR);
        $statement->bindParam(':idusuario', $idusuario, PDO::PARAM_STR);
        $statement->bindParam(':tipo_comprobante', $tipo_comprobante, PDO::PARAM_STR);
        $statement->bindParam(':serie_comprobante', $serie_comprobante, PDO::PARAM_STR);
        $statement->bindParam(':num_comprobante', $num_comprobante, PDO::PARAM_STR);
        $statement->bindParam(':fecha_hora', $fecha_hora, PDO::PARAM_STR);
        $statement->bindParam(':impuesto', $impuesto, PDO::PARAM_STR);
        $statement->bindParam(':total_compra', $total_compra, PDO::PARAM_STR);


        $statement->execute();

        //insertando en la otra tabla el detalle_ingreso
        $sw = true;
        for ($i = 0; $i < count($idarticulo); $i++) {
            $sql_detalle = 'INSERT INTO detalle_ingreso (idingreso, idarticulo, cantidad, precio_compra, precio_venta)
                          VALUES (:idingreso, :idarticulo, :cantidad, :precio_compra, :precio_venta)';
            $statement = conexionDB()->prepare($sql_detalle);
            $statement->bindParam(':idingreso', $idIngresoNuevo, PDO::PARAM_INT);
            $statement->bindParam(':idarticulo', $idarticulo[$i], PDO::PARAM_INT);
            $statement->bindParam(':cantidad', $cantidad[$i], PDO::PARAM_INT);
            $statement->bindParam(':precio_compra', $precio_compra[$i], PDO::PARAM_INT);
            $statement->bindParam(':precio_venta', $precio_venta[$i], PDO::PARAM_INT);

            $statement->execute() or $sw = false;
        }


        //retornamos true o false
        return $sw;

    }


    //actualizar condicion de la categoria a inactivo
    public function anular($idIngreso)
    {
        $sql = 'UPDATE ingreso SET estado = "Anulado" WHERE
                idingreso = :id';
        $statement = conexionDB()->prepare($sql);
        $statement->bindParam(':id', $idIngreso, PDO::PARAM_INT);
        if ($statement->execute()) {
            return 1;
        } else {
            return 0;
        }
    }


    //Metodo para mostrar todos los registros por id
    public function mostrar($idIngreso)
    {
        $sql = "SELECT i.idingreso, DATE(i.fecha_hora)as fecha, i.idproveedor, p.nombre as proveedor,  
                u.idusuario, u.nombre as usuario, i.tipo_comprobante, i.serie_comprobante, i.num_comprobante,
                i.total_compra, i.impuesto, i.estado
                                        FROM ingreso i INNER JOIN persona p ON i.idproveedor = p.idpersona
                                        INNER JOIN usuario u ON i.idusuario = u.idusuario
                                        WHERE i.idingreso = $idIngreso";
        return ejecutarConsultaSimpleFila($sql); //me devuelve los valores
    }

    //funcion que listara por idingreso los detalles
    public function listarDetalle($idIngreso)
    {
        $sql = "SELECT * FROM detalle_ingreso di INNER JOIN articulo a on di.idarticulo = a.idarticulo
                WHERE di.idingreso =  $idIngreso";
        return ejecutarConsulta($sql);

    }


    //Metodo para mostrar todos los registros
    public function listar()
    {
        $sql = "SELECT i.idingreso, DATE(i.fecha_hora)as fecha, i.idproveedor, p.nombre as proveedor,  
                u.idusuario, u.nombre as usuario, i.tipo_comprobante, i.serie_comprobante, i.num_comprobante,
                i.total_compra, i.impuesto, i.estado
                                        FROM ingreso i INNER JOIN persona p ON i.idproveedor = p.idpersona
                                        INNER JOIN usuario u ON i.idusuario = u.idusuario ORDER BY i.idingreso DESC";
        return ejecutarConsulta($sql); //me devuelve los valores
    }

}


?>