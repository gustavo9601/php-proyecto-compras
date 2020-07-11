<?php
require_once 'header.php';

//validacion si tiene permisos
if (@$_SESSION['escritorio'] == 1) {

    //invocamos la consulta
    require_once '../modelos/Consultas.php';
    $consulta = NEW Consultas();


    $rspta = $consulta->totalcomprahoy();
    $totalc = $rspta['total_compra'];

    $rspta = $consulta->totalventahoy();
    $totalv = $rspta['total_venta'];

    //para los graficso de ultimos 10 dias
    $compras10 = $consulta->comprasultimos_10dias();
    $fechasc = '';
    $totalsc = '';
    foreach ($compras10 as $dato) {
        $fechasc = $fechasc . '"' . $dato['fecha'] . '",';
        $totalsc = $totalsc . $dato['total'] . ',';
    }
    //quitamos la utilma coma, par pasarselo a canvas y se pueda graficar
    $fechasc = substr($fechasc, 0, -1);
    $totalsc = substr($totalsc, 0, -1);






    //para el grafico de ultimos 10 meses
    $ventas12 = $consulta->ventasultimos_12meses();
    $fechasv = '';
    $totalsv = '';
    foreach ($ventas12 as $dato) {
        $fechasv = $totalsv . '"' . $dato['fecha'] . '",';
        $totalsv = $totalsv . $dato['total'] . ',';
    }
    //quitamos la utilma coma, par pasarselo a canvas y se pueda graficar
    $fechasv = substr($fechasv, 0, -1);
    $totalsv = substr($totalsv, 0, -1);


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
                            <h1 class="box-title">Escritorio
                            </h1>
                            <div class="box-tools pull-right">
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <!-- centro -->
                        <div class="panel-body">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                <div class="small-box bg-aqua">
                                    <div class="inner">
                                        <h4 style="font-size: 17px;">
                                            <strong>
                                                <?php
                                                echo $totalc;
                                                ?>
                                            </strong>
                                        </h4>
                                        <p>Compras</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-bag">
                                        </i>
                                    </div>
                                    <a href="ingreso.php" class="small-box-footer">Compras
                                        <i class="fa fa-arrow-circle-right"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                <div class="small-box bg-navy">
                                    <div class="inner">
                                        <h4 style="font-size: 17px;">
                                            <strong>
                                                <?php
                                                echo $totalv;
                                                ?>
                                            </strong>
                                        </h4>
                                        <p>Ventas
                                        <p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-bag">
                                        </i>
                                    </div>
                                    <a href="venta.php" class="small-box-footer">Ventas
                                        <i class="fa fa-arrow-circle-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!--Formulario de registro-->
                        <div class="panel-body">
                            <div class="col-lg-6 col-md-6 col-xs-12">
                                <div class="box box-primary ">
                                    <div class="box-header with-border">
                                        Compras de los ultimos 10 dias
                                    </div>
                                    <div class="box-body">
                                        <!--Contenedor de los graficos-->
                                        <canvas id="compras" width="400" height="300">

                                        </canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-xs-12">
                                <div class="box box-primary ">
                                    <div class="box-header with-border">
                                        Ventas de los ultimos 12 meses
                                    </div>
                                    <div class="box-body">
                                        <!--Contenedor de los graficos-->
                                        <canvas id="ventas" width="400" height="300">

                                        </canvas>
                                    </div>
                                </div>
                            </div>
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


 <!--   <?php /*echo  $fechasc . "<br>"*/?>
    --><?php /*echo $totalsc */?>

    <!--Referencia de libreria de graficas-->
    <script src="../public/js/Chart.min.js"></script>
    <script src="../public/js/Chart.bundle.min.js"></script>
    <script type="text/javascript">



        /*Grafico #1 de 10 dias de compras*/
        var ctx = document.getElementById("compras").getContext('2d');
        var compras = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [<?php echo $fechasc ?>],  //eje Y
                datasets: [{
                    label: '# Compras de los ultimos 10 Dias',
                    data: [<?php echo $totalsc ?>],  // eje X
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });




        /*Grafico #2 12 meses ventas*/
        var ctx = document.getElementById("ventas").getContext('2d');
        var ventas = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [<?php echo $fechasv ?>],  //eje Y
                datasets: [{
                    label: '# Ventas de los utlimos 12 meses',
                    data: [<?php echo $totalsv ?>],  // eje X
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
    <?php

} else {
    require_once 'noacceso.php';
}
?>