<?php
require_once 'header.php';

//validacion si tiene permisos
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
                                <th>Nombre</th>
                                <th>Descripcion</th>
                                <th>Estado</th>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                <th>Opciones</th>
                                <th>Nombre</th>
                                <th>Descripcion</th>
                                <th>Estado</th>
                                </tfoot>
                            </table>
                        </div>
                        <!--Formulario de registro-->
                        <div class="panel-body" id="formularioregistros">
                            <form name="formulario" id="formulario" action="" method="post">
                                <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                    <label for="">Nombre:</label>
                                    <input type="hidden" name="idcategoria" id="idcategoria">
                                    <input class="form-control" type="text" name="nombre" id="nombre" maxlength="50"
                                           placeholder="Nombre:" required>
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                    <label for="">Descripcion:</label>
                                    <input class="form-control" type="text" name="descripcion" maxlength="256"
                                           id="descripcion" placeholder="Descripcion:">
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
    <script src="../vistas/scripts/categoria.js"></script>
    <?php

}else{
    require_once 'noacceso.php';
}
?>