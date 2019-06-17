<!DOCTYPE html>
<!--
Template Name: Dwindle
Author: <a href="http://www.os-templates.com/">OS Templates</a>
Author URI: http://www.os-templates.com/
Licence: Free to use under our free template licence terms
Licence URI: http://www.os-templates.com/template-terms
-->
<html>
<head>
<title>Model-R</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link href="layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
<link href="layout/styles/style-about.css" rel="stylesheet" type="text/css" media="all">
</head>
<body id="top">
<?php
    include_once 'templates/login.php';
    include_once 'templates/pass.php';
?>
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<div class="wrapper row0">
  <div id="topbar" class="clear"> 
    <!-- ################################################################################################ -->
    <div class="fl_left">
      <ul class="nospace inline">
        <li><i class="fa fa-phone"></i>(21) 3204-2124</li>
        <li><i class="fa fa-envelope-o"></i>modelr.jbrj@gmail.com</li>
      </ul>
    </div>
    <div class="fl_right">
      <ul class="faico clear">
       <!--<li><a class="faicon-facebook" href="#"><i class="fa fa-facebook"></i></a></li>
        <li><a class="faicon-pinterest" href="#"><i class="fa fa-pinterest"></i></a></li>
        <li><a class="faicon-twitter" href="#"><i class="fa fa-twitter"></i></a></li>
        <li><a class="faicon-dribble" href="#"><i class="fa fa-dribbble"></i></a></li>
        <li><a class="faicon-linkedin" href="#"><i class="fa fa-linkedin"></i></a></li>-->
        <li><a class="faicon-google-plus" href="https://github.com/Model-R"><i class="fa fa-github"></i></a></li>
        <!--<li><a class="faicon-rss" href="#"><i class="fa fa-rss"></i></a></li>-->
      </ul>
    </div>
    <!-- ################################################################################################ -->
  </div>
</div>
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<?php
    include_once 'layout/templates/nav.php';
?>
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<div class="wrapper row3 bgded" style="background-image:url('images/demo/backgrounds/rsz_1fundo-jb.jpg');">
  <div class="overlay">
    <div id="breadcrumb" class="clear"> 
      <!-- ################################################################################################ -->
      <ul>
        <li><a href="#">Model-R</a></li>
        <li><a href="#">Sobre</a></li>
      </ul>
      <!-- ################################################################################################ -->
    </div>
  </div>
</div>
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<div class="wrapper row4">
  <main class="container clear"> 
    <!-- main body -->
    <!-- ################################################################################################ -->
    <div class="content"> 
      <!-- ################################################################################################ -->
      <div id="about">
          <header class="heading">Sobre</header>
			<p>
				O arcabouço computacional escalável para modelagem de nicho ecológico (Model-R) foi desenvolvido 
				com o objetivo de unificar ferramentas de modelagem de nicho ecológico pré-existentes em uma 
				interface web que automatiza etapas do processamento e performance de modelagem, em ambiente R. 
				Esta ferramenta inclui pacotes associados ao pré-processamento como a aquisição e limpeza de 
				dados bióticos (ex RJabot, uma funcionalidade que permite pesquisar e recuperar dados de ocorrências 
				do Jabot), ferramentas multi-projeção que podem ser aplicadas a diferentes conjuntos de dados 
				temporais e espaciais e ferramentas de pós-processamento associadas aos modelos gerados. O ModelR 
				possui atualmente sete algoritmos implementados e disponíveis para modelagem: BIOCLIM, Distância 
				de Mahalanobis, Maxent, GLM, RandomForests, SVM e DOMAIN. Os algoritmos, assim como todo o processo 
				de modelagem, podem ser parametrizados usando ferramentas de linha de comando ou através da interface 
				web.             
			</p>
			<p>
			Existe também uma versão da interface do Model-R desenvolvida em R, que pode ser baixada e instalada localmente, 
			disponível no <a href="https://github.com/Model-R">Github</a>.
			</p>

      </div>
      <!-- ################################################################################################ -->
    </div>
    <!-- ################################################################################################ -->
  </main>
</div>

<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<div class="wrapper row6">
  <div id="copyright" class="clear"> 
    <!-- ################################################################################################ -->
    <p class="fl_left">Copyright &copy; 2018 Jardim Botânico do Rio de Janeiro - Todos os direitos reservados.</a></p>
    <p class="fl_right">Template by <a target="_blank" href="http://www.os-templates.com/" title="Free Website Templates">OS Templates</a></p>
    <!-- ################################################################################################ -->
  </div>
</div>
<!-- JAVASCRIPTS -->
<script src="layout/scripts/jquery.min.js"></script> 
<script src="layout/scripts/jquery.mobilemenu.js"></script>
</body>
</html>