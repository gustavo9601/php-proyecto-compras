<?php
ob_start(); //activamos almacenamiento en el buffer
@session_start();

//validacion si existe la sesion
if (!isset($_SESSION['nombre'])) {
    header('Location: login.php');
} else {

}
if (@$_SESSION['almacen'] == 1) {

    //requerimos la clase, que permite que se realice salto de linea si no cabe el texto en una columan
    require_once 'PDF_MC_Table.php';

//intanacia de la clase
    $pdf = NEW PDF_MC_Table();

//agreramos la primer pagina al documento
    $pdf->AddPage();

//seteamos e margin superior
    $y_axis_initial = 25;

    //setemoas el tipo de letra y cremos el titulo de la pagina
    $pdf->SetFont('Arial', 'B', 12);

    $pdf->Cell(40, 6, '', 0, 0, 'C');
    $pdf->Cell(100, 6, 'Lista de Articulos', 1, 0, 'C');
    $pdf->Ln(10); //aparecera en un rectangulo


    //creamos la celda para los tiutlo de cada columna
    $pdf->SetFillColor(232, 232, 232);
    $pdf->SetFont('Arial', 'B', 12);
    // width = 58, heigth = 6
    // totdo el anchi es de 158
    $pdf->Cell(58, 6, 'Nombre', 1, 0, 'C', 1);
    $pdf->Cell(50, 6, utf8_decode('Categoría'), 1, 0, 'C', 1);
    $pdf->Cell(30, 6, utf8_decode('Código'), 1, 0, 'C', 1);
    $pdf->Cell(12, 6, 'Stock', 1, 0, 'C', 1);
    $pdf->Cell(35, 6, utf8_decode('Descripción'), 1, 0, 'C', 1);
    $pdf->Ln(10); //queremos que las celdas esten dentro de un rectangulo


    //traemos la filas desde la BD
    require_once '../modelos/Articulo.php';
    $llamandoClase = NEW Articulo();
    $rspta = $llamandoClase->listar();

    /*  echo '<pre>';
      print_r($rspta);
      echo '</pre>';*/
    //Implementamos la celdas de la tabla , especficando el ancho para cada columnna
    $pdf->SetWidths(array(58, 50, 30, 12, 35));


    foreach ($rspta as $dato) {
        $nombre = $dato['nombreart'];
        $categoria = $dato['nombrecat'];
        $codigo = $dato['codigo'];
        $stock = $dato['stock'];
        $descripcion = $dato['descripcionart'];

        //modificamos el tipo y tamaño de letra par asl filas de la tabla
        $pdf->SetFont('Arial', '', 10);
//array de fila, con los datos
        $pdf->Row(
            array(
                utf8_decode($nombre),
                utf8_decode($categoria),
                $codigo,
                $stock,
                utf8_decode($descripcion)
            )
        );
    }

    $pdf->Output();

} else {
    echo 'No tiene permiso para visualizar el reporte';
}
