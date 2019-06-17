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
<link href="layout/styles/Main.css" rel="stylesheet" type="text/css" media="all">
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body id="top">
<?php
    include_once 'templates/login.php';
    include_once 'templates/pass.php';	
	include_once 'templates/pretratamento.php';
	include_once 'templates/modelagem.php';
	include_once 'templates/posprocessamento.php';
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
    <div id="intro" class="clear"> 
      <!-- ################################################################################################ -->
      <article class="one_third first"><i class="fa fa-pencil-square-o"></i>
        <h3 class="heading">Pré-tratamento</h3>
        <p class="topic-description">
			Etapa de aquisição, verificação e limpeza de dados, utilizando filtros geográficos para reduzir 
			a autocorrelação dos dados e ferramentas para verificação e remoção de multicoinearidade na seleção 
			das variáveis preditoras.
		</p>
        <p class="nospace" data-toggle="modal" data-target="#pretratamentoModal"><a class="btn" href="#">Saiba Mais &raquo;</a></p>
      </article>
      <article class="one_third"><i class="fa fa-gears"></i>
        <h3 class="heading">Modelagem</h3>
        <p class="topic-description">
			Etapa de criação dos modelos utilizando algoritmos, os dados limpos na etapa de pré-processamento e as variáveis preditoras selecionadas.
		</p>
        <p class="nospace" data-toggle="modal" data-target="#modelagemModal"><a class="btn" href="#">Saiba Mais &raquo;</a></p>
      </article>
      <article class="one_third"><i class="fa fa-globe"></i>
        <h3 class="heading">Pós-processamento</h3>
        <p class="topic-description">
			Etapa de recorte dos modelos de nicho para aproximação do modelo de distribuição de espécie.
		</p>
        <p class="nospace" data-toggle="modal" data-target="#posprocessamentoModal"><a class="btn" href="#">Saiba Mais &raquo;</a></p>
      </article>
      <!-- ################################################################################################ -->
    </div>
  </div>
</div>
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!--<div class="wrapper row5 bgded" style="background-image:url('images/demo/backgrounds/1.png');"></div>-->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<?php
    include_once 'layout/templates/footer.php';
?>
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

<script>
function includeHTML() {
  var z, i, elmnt, file, xhttp;
  /*loop through a collection of all HTML elements:*/
  z = document.getElementsByTagName("*");
  for (i = 0; i < z.length; i++) {
    elmnt = z[i];
    /*search for elements with a certain atrribute:*/
    file = elmnt.getAttribute("w3-include-html");
    if (file) {
      /*make an HTTP request using the attribute value as the file name:*/
      xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4) {
          if (this.status == 200) {elmnt.innerHTML = this.responseText;}
          if (this.status == 404) {elmnt.innerHTML = "Page not found.";}
          /*remove the attribute, and call this function once more:*/
          elmnt.removeAttribute("w3-include-html");
          includeHTML();
        }
      } 
      xhttp.open("GET", file, true);
      xhttp.send();
      /*exit the function:*/
      return;
    }
  }
}
</script>

<script>
includeHTML();
</script>

</body>
</html>