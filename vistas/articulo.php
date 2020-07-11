<?php
require_once 'header.php';


if (@$_SESSION['almacen'] == 1) {
    ?>

    <!--Contenido-->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h1 class="box-title">Articulos
                                <button id="btnagregar" class="btn btn-success" onclick="mostrarform(true)"><i
                                            class="fa fa-plus-circle"></i> Agregar
                                </button>
                                <a href="../reportes/rparticulos.php" class="btn btn-info" target="_blank"> Reporte</a>
                            </h1>
                            <div class="box-tools pull-right">
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <!-- centro -->
                        <div class="panel-body table-responsive" id="listadoregistros">
                            <table id="tbllistado"
                                   class="table table-striped table-bordered table-condensed table-hover">
                                <thead>
                                <th>Opciones</th>
                                <th>Nombre</th>
                                <th>Categoria</th>
                                <th>Codigo</th>
                                <th>Stock</th>
                                <th>Imagen</th>
                                <th>Estado</th>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                <th>Opciones</th>
                                <th>Nombre</th>
                                <th>Categoria</th>
                                <th>Codigo</th>
                                <th>Stock</th>
                                <th>Imagen</th>
                                <th>Estado</th>
                                </tfoot>
                            </table>
                        </div>
                        <!--Formulario de registro-->
                        <div class="panel-body" id="formularioregistros">
                            <form name="formulario" id="formulario" action="" method="post">
                                <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                    <label for="">Nombre(*):</label>
                                    <input type="hidden" name="idarticulo" id="idarticulo">
                                    <input class="form-control" type="text" name="nombre" id="nombre" maxlength="100"
                                           placeholder="Nombre:" required>
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                    <label for="">Categoria(*):</label>
                                    <select class="form-control selectpicker" data-live-search="true" required
                                            name="idcategoria" id="idcategoria">

                                    </select>
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                    <label for="">Stock(*):</label>
                                    <input class="form-control" type="number" name="stock" id="stock" maxlength="100"
                                           placeholder="Stock:" required>
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                    <label for="">Descripcion:</label>
                                    <input class="form-control" type="text" name="descripcion" maxlength="256"
                                           id="descripcion" placeholder="Descripcion:">
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                    <label for="">Imagen:</label>
                                    <input class="form-control" type="file" name="imagen" id="imagen">
                                    <input type="hidden" name="imagenactual" id="imagenactual">
                                    <!--Input que aacena temporalemnte la ruta  de la imagen actual-->
                                    <img src="" width="150px" height="150px" id="imagenmuestra" alt="">
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                    <label for="">Codigo:</label>
                                    <input class="form-control" type="text" name="codigo" maxlength="256"
                                           id="codigo" placeholder="Codigo de barras:">
                                    <button class="btn btn-success" type="button" onclick="generarbarcode()"><i
                                                class="fa fa-barcode"></i> Generar
                                    </button>
                                    <button class="btn btn-success" type="button" onclick="imprimir()"><i
                                                class="fa fa-print"></i> Imprimir
                                    </button>
                                    <div id="print">
                                        <!--Espacio para codigo de barras-->
                                        <svg id="barcode">
                                        </svg>
                                    </div>
                                </div>
                                <div class="form-group col-lg-12 col-md-12 col-xs-12">
                                    <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> Guardar
                                    </button>
                                    <button class="btn btn-danger" type="button" onclick="cancelarform();"><i
                                                class="fa fa-arrow-circle-left"></i> Cancelar
                                    </button>
                                </div>
                            </form>
                        </div>
                        <!--Fin centro -->
                    </div><!-- /.box -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
    <!--Fin-Contenido-->

    <?php
    require_once 'footer.php'
    ?>
    <!--Lireria de codigo de barras-->
    <script src="../public/js/JsBarcode.all.min.js"></script>
    <!--Libreria para imprimir-->
    <script src="../public/js/jquery.PrintArea.js"></script>

    <script src="../vistas/scripts/articulo.js"></script>

    <?php

} else {
    require_once 'noacceso.php';
}
?>