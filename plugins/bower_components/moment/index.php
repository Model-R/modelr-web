<?php session_start();
require_once('classes/conexao.class.php');
$Conexao = new Conexao;
$conn = $Conexao->Conectar();

$sql = "select count(*) from atividadeirmao ai where
ai.datalancamento >= '2017-01-01' ";
//now()- interval '30 days'";

$res = pg_exec($conn,$sql);
$row = pg_fetch_array($res);
$qtdatividade30dias = $row[0];

$sql = "select count(*) from irmaohaselevacao ihe where
ihe.datalancamento >= '2017-01-01'";
//now()- interval '30 days'";

$res = pg_exec($conn,$sql);
$row = pg_fetch_array($res);
$qtdelevacoes30dias = $row[0];



?><!DOCTYPE html>
<html lang="en">
<head>
<?php


$qtdatividade30dias
?>


<?php include "head.php";?>
</head>

<body>
    <!-- Preloader -->
    <div class="preloader">
        <div class="cssload-speeding-wheel"></div>
    </div>
    <div id="wrapper">
        <!-- Navigation -->
		<?php include "menutop.php";?>

        <!-- Left navbar-header -->
		<?php include "menu.php";?>

        <!-- Left navbar-header end -->
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row bg-title">
                    
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12">
                        <div class="white-box">
                            <div class="row row-in">
                                <div class="col-lg-4 col-sm-6 row-in-br">
                                    <div class="col-in row">
                                        <div class="col-md-6 col-sm-6 col-xs-6"> <i data-icon="E" class="linea-icon linea-basic"></i>
                                            <h5 class="text-muted vb">ATIVIDADES LANÇADAS<br>(2017)</h5>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-6">
                                            <h3 class="counter text-right m-t-15 text-danger"><?php echo $qtdatividade30dias;?></h3>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%"> <span class="sr-only">40% Complete (success)</span> </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6 row-in-br  b-r-none">
                                    <div class="col-in row">
                                        <div class="col-md-6 col-sm-6 col-xs-6"> <i class="linea-icon linea-basic" data-icon="&#xe01b;"></i>
                                            <h5 class="text-muted vb">ELEVAÇÕES LANÇADAS<BR>(2017)</h5>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-6">
                                            <h3 class="counter text-right m-t-15 text-megna"><?php echo $qtdelevacoes30dias;?></h3>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-megna" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%"> <span class="sr-only">40% Complete (success)</span> </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-6 row-in-br">
                                    <div class="col-in row">
                                        <div class="col-md-6 col-sm-6 col-xs-6"> <i class="linea-icon linea-basic" data-icon="&#xe00b;"></i>
                                            <h5 class="text-muted vb">INCLUSÕES<br>(2017)</h5>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-6">
                                            <h3 class="counter text-right m-t-15 text-primary">157</h3>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%"> <span class="sr-only">40% Complete (success)</span> </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <!--row -->
                <!-- /.row -->
                
                <!--row -->
                <div class="row">
				                   <div class="col-md-12 col-lg-6 col-sm-12">
                        <div class="white-box">
                            <h3 class="box-title">ÚLTIMAS ATIVIDADES LANÇADAS
              <div class="col-md-3 col-sm-4 col-xs-6 pull-right">
              </div>
            </h3>
                            <div class="table-responsive">
                                <table class="table ">
                                    <thead>
                                        <tr>
                                            <th>Ano Pagto</th>
                                            <th>Data Lançamento</th>
                                            <th>Cód. Corpo</th>
                                            <th>Irmao</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php 
									$sql = "select * from atividadeirmao ai, irmao i, corpo c, tipocorpo tc where
									ai.idirmao = i.idirmao and
									ai.idcorpo = c.idcorpo and
									c.idtipocorpo = tc.idtipocorpo order by datalancamento desc limit 7";
									$res = pg_exec($conn,$sql);
									while ($row = pg_fetch_array($res))
									{
										?>
                                        <tr>
                                            <td class="txt-oflo"><?php echo $row['anopagamento'];?></td>
                                            <td class="txt-oflo"><?php echo date('d/m/Y',strtotime($row['datalancamento']));?></td>
                                            <td class="txt-oflo"><?php echo $row['idtipocorpo'].$row['codcorpo'];?></td>
                                            <td class="txt-oflo"><?php echo $row['nome'];?></td>
                                        </tr>
									<?php } ?>
                                    </tbody>
                                </table>
                                <!--<a href="#">Check all the sales</a>--> </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6 col-sm-12">
                        <div class="white-box">
                            <h3 class="box-title">ÚLTIMAS ELEVAÇÕES
              <div class="col-md-3 col-sm-4 col-xs-6 pull-right">
              </div>
            </h3>
                            <div class="table-responsive">
                                <table class="table ">
                                    <thead>
                                        <tr>
                                            <th>Grau</th>
                                            <th>Data Lançamento</th>
                                            <th>Cód. Corpo</th>
                                            <th>Irmao</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php 
									$sql = "select * from irmaohaselevacao ihe, irmao i, grau g, corpo c, tipocorpo tc
where
ihe.idirmao = i.idirmao and
ihe.idgrau = g.idgrau and
ihe.idcorpo = c.idcorpo and
c.idtipocorpo = tc.idtipocorpo
order by ihe.datalancamento desc
limit 7";
									$res = pg_exec($conn,$sql);
									while ($row = pg_fetch_array($res))
									{
										?>
                                        <tr>
                                            <td class="txt-oflo"><?php echo $row['codgrau'];?></td>
                                            <td class="txt-oflo"><?php echo date('d/m/Y',strtotime($row['datalancamento']));?></td>
                                            <td class="txt-oflo"><?php echo $row['idtipocorpo'].$row['codcorpo'];?></td>
                                            <td class="txt-oflo"><?php echo $row['nome'];?></td>
                                        </tr>
									<?php } ?>
                                    </tbody>
                                </table>
                                <!--<a href="#">Check all the sales</a> --></div>
                        </div>
                    </div>
                </div>
				<!--
				<div class="row">
                    <div class="col-md-12 col-lg-12 col-sm-12">
                        <div class="white-box">
                            <h3 class="box-title">Comparativo de Inclusões, Elevações e Atividade</h3>
                            <ul class="list-inline text-right">
                                <li>
                                    <h5><i class="fa fa-circle m-r-5" style="color: #00bfc7;"></i>Inclusões</h5>
                                </li>
                                <li>
                                    <h5><i class="fa fa-circle m-r-5" style="color: #fb9678;"></i>Elevações</h5>
                                </li>
                                <li>
                                    <h5><i class="fa fa-circle m-r-5" style="color: #9675ce;"></i>Atividade</h5>
                                </li>
                            </ul>
                            <div id="morris-area-chart" style="height: 340px;"></div>
                        </div>
                    </div>
                </div>
				-->
                <!-- /.row -->
                <!--row -->
                <!-- /.row -->
                <!-- .right-sidebar -->
               
                <!-- /.right-sidebar -->
            </div>
            <!-- /.container-fluid -->
            <?php include "rodape.php";?>
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
    <!-- jQuery -->
    <script src="../plugins/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="bootstrap/dist/js/tether.min.js"></script>
    <script src="bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../plugins/bower_components/bootstrap-extension/js/bootstrap-extension.min.js"></script>
    <!-- Menu Plugin JavaScript -->
    <script src="../plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
    <!--slimscroll JavaScript -->
    <script src="js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="js/waves.js"></script>
    <!--Counter js -->
    <script src="../plugins/bower_components/waypoints/lib/jquery.waypoints.js"></script>
    <script src="../plugins/bower_components/counterup/jquery.counterup.min.js"></script>
    <!--Morris JavaScript -->
    <script src="../plugins/bower_components/raphael/raphael-min.js"></script>
    <script src="../plugins/bower_components/morrisjs/morris.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="js/custom.min.js"></script>
    <script src="js/dashboard1.js"></script>
    <!-- Sparkline chart JavaScript -->
    <script src="../plugins/bower_components/jquery-sparkline/jquery.sparkline.min.js"></script>
    <script src="../plugins/bower_components/jquery-sparkline/jquery.charts-sparkline.js"></script>
    <script src="../plugins/bower_components/toast-master/js/jquery.toast.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        /*$.toast({
            heading: 'Welcome to Elite admin',
            text: 'Use the predefined ones, or specify a custom position object.',
            position: 'top-right',
            loaderBg: '#ff6849',
            icon: 'info',
            hideAfter: 3500,

            stack: 6
        })
		*/
    });
    </script>
    <!--Style Switcher -->
    <script src="../plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
</body>

</html>
