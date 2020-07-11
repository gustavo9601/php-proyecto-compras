<?php
require_once 'header.php';

//validacion si tiene permisos
if (@$_SESSION['consultac'] == 1) {
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
                            <h1 class="box-title">Consulta de compras por fecha
                            </h1>
                            <div class="box-tools pull-right">
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <!-- centro -->
                        <div class="panel-body table-responsive" id="listadoregistros">
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label for="">Fecha Inicio</label>
                                <input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio"
                                       value="01/01/2017">
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <label for="">Fecha Final</label>
                                <input type="date" class="form-control" name="fecha_fin" id="fecha_fin"
                                       value="<?php echo date("Y-m-d"); ?>">
                            </div>
                            <table id="tbllistado"
                                   class="table table-striped table-bordered table-condensed table-hover">
                                <thead>
                                <th>Fecha</th>
                                <th>Usuario</th>
                                <th>Proveedor</th>
                                <th>Comprobante</th>
                                <th>Numero</th>
                                <th>Total Compra</th>
                                <th>Impuesto</th>
                                <th>Estado</th>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                <th>Fecha</th>
                                <th>Usuario</th>
                                <th>Proveedor</th>
                                <th>Comprobante</th>
                                <th>Numero</th>
                                <th>Total Compra</th>
                                <th>Impuesto</th>
                                <th>Estado</th>
                                </tfoot>
                            </table>
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
    <script src="../vistas/scripts/comprasfecha.js"></script>
    <?php

} else {
    require_once 'noacceso.php';
}
?>