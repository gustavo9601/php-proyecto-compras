<?php
require_once 'header.php';
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
                            <h1 class="box-title">Proveedor
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
                                <th>Tipo Documento</th>
                                <th>Numero Documento</th>
                                <th>Telefono</th>
                                <th>Email</th>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                <th>Opciones</th>
                                <th>Nombre</th>
                                <th>Tipo Documento</th>
                                <th>Numero Documento</th>
                                <th>Telefono</th>
                                <th>Email</th>
                                </tfoot>
                            </table>
                        </div>
                        <!--Formulario de registro-->
                        <div class="panel-body" id="formularioregistros">
                            <form name="formulario" id="formulario" action="" method="post">
                                <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                    <label for="">Nombre :</label>
                                    <input class="form-control" type="text" name="nombre" id="nombre" maxlength="100"
                                           placeholder="Nombre Proveedor :" required>
                                    <input type="hidden" name="idpersona" id="idpersona">
                                    <input type="hidden" name="tipo_persona" id="tipo_persona" value="Proveedor">
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                    <label for="tipo_documento">Tipo Documento :</label>
                                    <select class="form-control select-picker" name="tipo_documento" id="tipo_documento"
                                            required>
                                        <option value="DNI">DNI</option>
                                        <option value="RUT">RUT</option>
                                        <option value="CEDULA">CEDULA</option>
                                    </select>
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                    <label for="">Numero Documento :</label>
                                    <input class="form-control" type="text" name="num_documento" id="num_documento"
                                           maxlength="100"
                                           placeholder="Numero :">
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                    <label for="">Direccion :</label>
                                    <input class="form-control" type="text" name="direccion" id="direccion"
                                           maxlength="100"
                                           placeholder="Direccion :">
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                    <label for="">Telefono :</label>
                                    <input class="form-control" type="text" name="telefono" id="telefono"
                                           maxlength="100"
                                           placeholder="Telefono :">
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                    <label for="">Email :</label>
                                    <input class="form-control" type="email" name="email" id="email" maxlength="100"
                                           placeholder="Email :">
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
    <script src="../vistas/scripts/proveedor.js"></script>
    <?php

} else {
    require_once 'noacceso.php';
}
?>