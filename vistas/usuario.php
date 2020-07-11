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
                        <h1 class="box-title">Usuarios
                            <button id="btnagregar" class="btn btn-success" onclick="mostrarform(true)"><i
                                        class="fa fa-plus-circle"></i> Agregar
                            </button>
                        </h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                            <thead>
                            <th>Opciones</th>
                            <th>Nombre</th>
                            <th>Tipo Doc</th>
                            <th>Numero Doc</th>
                            <th>Telefono</th>
                            <th>Email</th>
                            <th>Login</th>
                            <th>Imagen</th>
                            <th>Estado</th>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                            <th>Opciones</th>
                            <th>Nombre</th>
                            <th>Tipo Doc</th>
                            <th>Numero Doc</th>
                            <th>Telefono</th>
                            <th>Email</th>
                            <th>Login</th>
                            <th>Imagen</th>
                            <th>Estado</th>
                            </tfoot>
                        </table>
                    </div>
                    <!--Formulario de registro-->
                    <div class="panel-body" id="formularioregistros">
                        <form name="formulario" id="formulario" action="" method="post">
                            <div class="form-group col-lg-12 col-md-12 col-xs-12">
                                <label for="">Nombre(*):</label>
                                <input type="hidden" name="idusuario" id="idusuario">
                                <input class="form-control" type="text" name="nombre" id="nombre" maxlength="100"
                                       placeholder="Nombre:" required>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                <label for="">Tipo Doc(*):</label>
                                <select class="form-control selectpicker" data-live-search="true" required
                                        name="tipo_documento" id="tipo_documento">
                                    <option value="DNI">DNI</option>
                                    <option value="RUC">CEDULA</option>
                                    <option value="CEDULA">CEDULA</option>
                                </select>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                <label for="">Numero Doc(*):</label>
                                <input class="form-control" type="text" name="num_documento" id="num_documento"
                                       maxlength="100"
                                       placeholder="Numero Documento" required>
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                <label for="">Direccion :</label>
                                <input class="form-control" type="text" name="direccion" id="direccion" maxlength="100"
                                       placeholder="Direccion">
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                <label for="">Telefono :</label>
                                <input class="form-control" type="text" name="telefono" id="telefono" maxlength="100"
                                       placeholder="Telefono">
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                <label for="">Email :</label>
                                <input class="form-control" type="email" name="email" id="email" maxlength="100"
                                       placeholder="Email">
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                <label for="">Cargo :</label>
                                <input class="form-control" type="text" name="cargo" id="cargo" maxlength="100"
                                       placeholder="Cargo">
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                <label for="">Login :</label>
                                <input class="form-control" type="text" name="login" id="login" maxlength="100"
                                       placeholder="Login" required>
                            </div>

                            <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                <label for="">Clave :</label>
                                <input class="form-control" type="password" name="clave" id="clave" maxlength="100"
                                       placeholder="Clave" required>
                            </div>

                            <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                <label for="">Permisos:</label>
                                <!--Lista de permisos-->
                                <ul id="permisos" style="list-style: none">

                                </ul>
                            </div>

                            <div class="form-group col-lg-6 col-md-6 col-xs-12">
                                <label for="">Imagen :</label>
                                <input class="form-control" type="file" name="imagen" id="imagen">
                                <input type="hidden" name="imagenactual" id="imagenactual">
                                <img src="" alt="" style="width: 150px; height: 120px;" id="imagenmuestra">
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
<script src="../vistas/scripts/usuario.js"></script>

    <?php
} else {
    require_once 'noacceso.php';
}
?>