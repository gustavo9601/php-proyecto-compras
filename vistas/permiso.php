<?php
require_once 'header.php';
if (@$_SESSION['acceso'] == 1) {
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
                            <h1 class="box-title">Permiso
                                <button class="btn btn-success" onclick="mostrarform(true)" id="btnagregar"><i
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
                                <th> Nombre</th>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                <th> Nombre</th>
                                </tfoot>
                            </table>
                        </div>
                    </div><!-- /.box -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
    <!--Fin-Contenido-->

    <?php
    require_once 'footer.php'
    ?>
    <script src="../vistas/scripts/permiso.js"></script>
    <?php

} else {
    require_once 'noacceso.php';
}
?>