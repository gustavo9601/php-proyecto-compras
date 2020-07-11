<?php
require_once 'header.php';

//validacion si tiene permisos
if (@$_SESSION['compras'] == 1) {
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
                            <h1 class="box-title">Categoria
                                <button class="btn btn-success" onclick="mostrarform(true)"><i
                                            class="fa fa-plus-circle"></i> Agregar
                                </button>
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
                                <th>Fecha</th>
                                <th>Proveedor</th>
                                <th>Usuario</th>
                                <th>Docuemnto</th>
                                <th>Numero</th>
                                <th>Total de compra</th>
                                <th>Estado</th>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                <th>Opciones</th>
                                <th>Fecha</th>
                                <th>Proveedor</th>
                                <th>Usuario</th>
                                <th>Docuemnto</th>
                                <th>Numero</th>
                                <th>Total de compra</th>
                                <th>Estado</th>
                                </tfoot>
                            </table>
                        </div>
                        <!--Formulario de registro-->
                        <div class="panel-body" id="formularioregistros">
                            <form name="formulario" id="formulario" action="" method="post">
                                <div class="form-group col-lg-8 col-md-8 col-xs-12">
                                    <label for="">Proveedor (*):</label>
                                    <input type="hidden" name="idingreso" id="idingreso">
                                    <select class="form-control selectpicker" data-live-search="true" name="idproveedor"
                                            id="idproveedor" required>

                                    </select>
                                </div>
                                <div class="form-group col-lg-4 col-md-4 col-xs-12">
                                    <label for="">Fecha (*):</label>
                                    <input class="form-control" type="date" name="fecha_hora" maxlength="256"
                                           id="fecha_hora" required>
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                    <label for="">Tipo Comprobante (*):</label>
                                    <select class="form-control selectpicker" data-live-search="true"
                                            name="tipo_comprobante" id="tipo_comprobante" required>
                                        <option value="Boleta">Boleta</option>
                                        <option value="Factura">Factura</option>
                                        <option value="Ticket">Ticket</option>
                                    </select>
                                </div>
                                <div class="form-group col-lg-2 col-md-2 col-xs-6">
                                    <label for="">Serie:</label>
                                    <input class="form-control" type="text" name="serie_comprobante" maxlength="7"
                                           id="serie_comprobante" placeholder="Serie">
                                </div>
                                <div class="form-group col-lg-2 col-md-2 col-xs-6">
                                    <label for="">Numero:</label>
                                    <input class="form-control" type="text" name="num_comprobante" maxlength="10"
                                           id="num_comprobante" placeholder="Numero" required>
                                </div>
                                <div class="form-group col-lg-2 col-md-2 col-xs-6">
                                    <label for="">Impuesto:</label>
                                    <input class="form-control" type="text" name="impuesto" maxlength="10"
                                           id="impuesto" placeholder="Impuesto" required>
                                </div>
                                <div class="form-group col-lg-3 col-md-3 col-xs-12">
                                    <a href="#myModal" data-toggle="modal">
                                        <button id="btnAgregarArt" type="button" class="btn btn-primary"><span
                                                    class="fa fa-plus"></span> Agregar Articulos
                                        </button>
                                    </a>
                                </div>


                                <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                                    <table id="detalles"
                                           class="table table-striped table-bordered table-condensed table-hove">
                                        <thead style="background: #A9D0F5;">
                                        <th>Opciones</th>
                                        <th>Articulo</th>
                                        <th>Cantidad</th>
                                        <th>Precio Compra</th>
                                        <th>Precio Venta</th>
                                        <th>Subtotal</th>
                                        </thead>
                                        <tfoot>
                                        <th>TOTAL</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th><h4 id="total">S/ 0.00</h4>
                                            <input type="hidden" name="total_compra" id="total_compra">
                                        </th>
                                        </tfoot>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12" id="guardar">
                                    <button class="btn btn-primary" type="submit" id="btnGuardar"><i
                                                class="fa fa-save"></i> Guardar
                                    </button>
                                    <button class="btn btn-danger" id="btnCancelar" type="button"
                                            onclick="cancelarform();"><i class="fa fa-arrow-circle-left"></i> Cancelar
                                    </button>
                                </div>
                            </form>
                        </div>
                        <!--Fin centro -->
                    </div><!-- /.box -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </section><!-- /.content -->


        <!--Ventana Modal-->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Seleccione un Articulo</h4>
                    </div>
                    <div class="modal-body">
                        <table id="tblarticulos"
                               class="table table-striped table-bordered table-condensed table-hove">
                            <thead>
                            <th>Opciones</th>
                            <th>Nombre</th>
                            <th>Categoria</th>
                            <th>Codigo</th>
                            <th>Stock</th>
                            <th>Imagen</th>
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
                            </tfoot>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.content-wrapper -->
    <!--Fin-Contenido-->

    <?php
    require_once 'footer.php'
    ?>
    <script src="../vistas/scripts/ingreso.js"></script>
    <?php

} else {
    require_once 'noacceso.php';
}
?>