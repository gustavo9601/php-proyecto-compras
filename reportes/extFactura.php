<?php
ob_start(); //activamos almacenamiento en el buffer
@session_start();

//validacion si existe la sesion
if (!isset($_SESSION['nombre'])) {
    header('Location: login.php');
} else {

}
if (@$_SESSION['ventas'] == 1) {


    require_once 'PDF_Invoice.php'; //importando el script para facturas
    //Datos de la empresa
    $logo = 'logo.jpg';
    $ext_logo = 'jpg';
    $empresa = 'Inge Gustavo Marquez';
    $documento = '789965666';
    $direccion = 'Calle 82 # 11 - 37';
    $telefono = '7789331';
    $email = 'ing.gustavo.marquez@gmail.com';

    //Datos de la cabecera de la venta actual
    require_once '../modelos/venta.php';
    $venta = NEW Venta();
    $rpsta = $venta->ventacabecera($_GET['id']);

    //Confiugracion de la pagina
    /*
     *
     * P -> vertical
     * mm -> milimetros
     * A4 -> tiopo de hoja
     *  */
    $pdf = new PDF_Invoice('P', 'mm', 'A4');
    $pdf->AddPage(); //Añadimos una pagina

    //enviamos datos de la empresa al metodo addSociete
    $pdf->addSociete(
        $empresa,
        $documento . "\n" .
        "Direccion: " . $direccion . "\n" .
        "Telefono: " . $telefono . "\n" .
        "Email: " . $empresa);

    //enviamos informacion de tipo de factura
    $pdf->fact_dev(
        $rpsta['tipo_comprobante'],
        $rpsta['serie_comprobante'] . '-' . $rpsta['num_comprobante']
    );


    $pdf->temporaire( "INGE GUSTAVO" ); //marca de agua
    $pdf->addDate($rpsta['fecha']); //fecha factura
    $pdf->addClient($rpsta['idcliente']); // NUMERO CLIENTE
    $pdf->addPageNumber("1");
    //enviamos los datos del cliente
    $pdf->addClientAdresse(
        utf8_decode($rpsta['cliente']) . "\n" .
        "Domicilio: " . utf8_decode($rpsta['direccion']) . "\n" .
        $rpsta['tipo_documento'] . ': ' . $rpsta['num_documento'] . "\n" .
        "Email: " . $rpsta['email'] . "\n" .
        "Telefono: " . $rpsta['telefono']
    );
    $pdf->addReglement("Factura Resolucion #1");
    $pdf->addEcheance($rpsta['fecha']);
    $pdf->addNumTVA($rpsta['idventa']);
    $pdf->addReference("Articulos adquiridos");
    //Establecemos las columnas que va tener la seccion donde se mostrarael detalle de la venta
    //Columna => ANCHO PIXELES
    $cols = array(
        "CODIGO" => 23,
        "DESCRIPCION" => 78,
        "CANTIDAD" => 22,
        "P.U" => 25,
        "DSCTO" => 20,
        "SUBOTOTAL" => 22
    );
    $pdf->addCols($cols);
    //Alineamos las columnas por individual
    //Columna => alineacion L c r
    $cols = array(
        "CODIGO" => "L",
        "DESCRIPCION" => "L",
        "CANTIDAD" => "C",
        "P.U" => "R",
        "DSCTO" => "R",
        "SUBOTOTAL" => "C"
    );

    $pdf->addLineFormat( $cols);
    $pdf->addLineFormat($cols);
    //Actualizamos el valor de la coordenada "y", y que sera la ubicacion desde donde empezamos a mostrar los datos
    $y = 110;

    //obtenemos todos los detalles de la venta actual
    $rpsta2 = $venta->ventadetalle($_GET['id']);

    foreach ($rpsta2 as $dato) {
        $line = array(
            "CODIGO" => $dato['codigo'],
            "DESCRIPCION" => $dato['articulo'],
            "CANTIDAD" => $dato['cantidad'],
            "P.U" => $dato['precio_venta'],
            "DSCTO" => $dato['descuento'],
            "SUBOTOTAL" => $dato['subtotal']
        );
        //vamos añadiendo las filas al PDF, en base a la posicion inicial
        $size = $pdf->addLine($y, $line);
        //aumantamos la y para que haga el salto de linea
        $y += $size + 2;
    }

   /* $pdf->addCadreTVAs();
    //$pdf->addCadreTVAs();
    $pdf->addTVAs($rpsta['impuesto'], $rpsta['total_venta'], "COP ");
    $pdf->addCadreEurosFrancs();
    $pdf->Output("Reporte de Venta");*/
    $tot_prods = array();
    $tab_tva = array();
    $params  = array( "RemiseGlobale" => 1,
        "remise_tva"     => 1,       // {la remise s'applique sur ce code TVA}
        "remise"         => 0,       // {montant de la remise}
        "remise_percent" => 10,      // {pourcentage de remise sur ce montant de TVA}
        "FraisPort"     => 1,
        "portTTC"        => 10,      // montant des frais de ports TTC
        // par defaut la TVA = 19.6 %
        "portHT"         => 0,       // montant des frais de ports HT
        "portTVA"        => 19.6,    // valeur de la TVA a appliquer sur le montant HT
        "AccompteExige" => 1,
        "accompte"         => 0,     // montant de l'acompte (TTC)
        "accompte_percent" => 15,    // pourcentage d'acompte (TTC)
        "Remarque" => "Venta total" );

    //$pdf->addTVAs( $params, $tab_tva, $tot_prods);

    $pdf->addCadreEurosFrancs();
    $pdf->Output();
} else {
    echo 'No tiene permiso para visualizar el reporte';
}
