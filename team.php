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
<link href="layout/styles/style-team.css" rel="stylesheet" type="text/css" media="all">

<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

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
        <li><a href="#">Equipe</a></li>
      </ul>
      <!-- ################################################################################################ -->
    </div>
  </div>
</div>
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->

<section id="team" class="intro pb-5">
<h5 class="section-title h1">Equipe</h5>
    <div class="container">
	
		<div class="d-md-flex h-md-100">

			<!-- First Half -->

			<div class="col-md-6 p-0 bg-white h-md-100 loginarea">
				<h3 class="role-title" onClick="toggleTeam('coordenadora')">Coordenadora</h3>
				<div id="coordenadora" class="row">
					<!-- Team member -->
					<div class="col-xs-12 col-sm-6 col-md-4">
						<div class="image-flip" ontouchstart="this.classList.toggle('hover');">
							<div class="mainflip">
								<div class="frontside">
									<div class="card">
										<div class="card-body text-center">
											<p><img class=" img-fluid card-background-image" src="images/demo/backgrounds/rsz_1fundo-jb.jpg"></p>
											<p><img class=" img-fluid" src="images/equipe/marinez.png" alt="card image"></p>
											<h4 class="card-title">Marinez Siqueira</h4>
											<p class="card-text"></p>
											<a href="#" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
										</div>
									</div>
								</div>
								<div class="backside">
									<div class="card">
										<div class="card-body text-center mt-4">
											<p class="card-text">Possui graduação em Ciências Biológicas pela Universidade Estadual de Campinas (1988), mestrado em Ecologia pela Universidade Estadual de Campinas (1994) e doutorado em Ciências da Engenharia Ambiental pela Universidade de São Paulo (2005). Atualmente é Pesquisador Associado do Instituto de Pesquisas do Jardim Botânico do Rio de Janeiro. Tem experiência nas áreas de Ecologia Vegetal, Modelagem Ecológica, Sistemas de Informação e Banco de Dados, atuando principalmente em modelagem de distribuição em diferentes formações vegetais, principalmente com espécies arbóreas. Tem experiência no uso de Sistemas de Informação Geográfica para análises espaciais envolvendo distribuição de espécies. </p>
											<a href="http://lattes.cnpq.br/1373735074676560"><img src="images/lattes.png" alt="Currículo Lattes" class="lattes"></a>
											<!--<ul class="list-inline">
												<li class="list-inline-item">
													<a class="social-icon text-xs-center" target="_blank" href="#">
														<i class="fa fa-facebook"></i>
													</a>
												</li>
												<li class="list-inline-item">
													<a class="social-icon text-xs-center" target="_blank" href="#">
														<i class="fa fa-twitter"></i>
													</a>
												</li>
												<li class="list-inline-item">
													<a class="social-icon text-xs-center" target="_blank" href="#">
														<i class="fa fa-skype"></i>
													</a>
												</li>
												<li class="list-inline-item">
													<a class="social-icon text-xs-center" target="_blank" href="#">
														<i class="fa fa-google"></i>
													</a>
												</li>
											</ul>-->
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<h3 class="role-title" onClick="toggleTeam('colaboradores')">Colaboradores</h3>
				<div id="colaboradores" class="row">
					<!-- ./Team member -->
					<!-- Team member -->
					<div class="col-xs-12 col-sm-6 col-md-4">
						<div class="image-flip" ontouchstart="this.classList.toggle('hover');">
							<div class="mainflip">
								<div class="frontside">
									<div class="card">
										<div class="card-body text-center">
											<p><img class=" img-fluid card-background-image" src="images/demo/backgrounds/rsz_1fundo-jb.jpg"></p>
											<p><img class=" img-fluid" src="images/equipe/luizmanoel.png" alt="card image"></p>
											<h4 class="card-title">Luiz Manoel Rocha Gadelha Júnior</h4>
											<p class="card-text"></p>
											<a href="#" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
										</div>
									</div>
								</div>
								<div class="backside">
									<div class="card">
										<div class="card-body text-center mt-4">
											<p class="card-text">Possui graduação em Matemática pela Universidade de Brasília (1997), mestrado em Ciência da Computação pela Universidade de Brasília (2000) e doutorado em Engenharia de Sistemas e Computação pela Universidade Federal do Rio de Janeiro (2012). Atualmente é Tecnologista Pleno no Laboratório Nacional de Computação Científica. Tem experiência nas áreas de gerência de dados científicos, computação de alto desempenho e segurança computacional, atuando principalmente nos seguintes temas: proveniência, workflows científicos paralelos e distribuídos, bioinformática e informática na biodiversidade.</p>
											<a href="http://lattes.cnpq.br/9851093795076823"><img src="images/lattes.png" alt="Currículo Lattes" class="lattes"></a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- ./Team member -->
					<!-- Team member -->
					<div class="col-xs-12 col-sm-6 col-md-4">
						<div class="image-flip" ontouchstart="this.classList.toggle('hover');">
							<div class="mainflip">
								<div class="frontside">
									<div class="card">
										<div class="card-body text-center">
											<p><img class=" img-fluid card-background-image" src="images/demo/backgrounds/rsz_1fundo-jb.jpg"></p>
											<p><img class=" img-fluid" src="images/equipe/luisalexandre.png" alt="card image"></p>
											<h4 class="card-title">Luís Alexandre Estevão da Silva</h4>
											<p class="card-text"></p>
											<a href="#" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
										</div>
									</div>
								</div>
								<div class="backside">
									<div class="card">
										<div class="card-body text-center mt-4">
											<p class="card-text">Doutorado em Engenharia de Sistemas e Computação pela Universidade Federal do Rio de Janeiro (Banco de Dados - COPPE / UFRJ - 2013). Mestrado em Engenharia de Sistemas e Computação pelo Instituto Militar de Engenharia (Banco de Dados - IME - 2000). Tecnologista Pleno (Analista de Dados - desde 2002). Docente do Mestrado Profissional em Biodiversidade em Unidades de Conservação na Escola Nacional de Botânica Tropical, Assessor de Dados da Diretoria de Pesquisas, Coordenador do Núcleo de Computação Científica e Geoprocessamento (NCCG) e Chefe da Equipe Temática de Informações Científicas do Instituto de Pesquisas Jardim Botânico do Rio de Janeiro. Professor Adjunto do curso de Engenharia de Computação e pesquisador na Universidade Católica de Petrópolis (UCP) desde 2000. Professor da graduação em Sistemas de Informação e pesquisador bolsista na modalidade Pesquisa Produtividade da Universidade Estácio de Sá desde 2003. Tem experiência na área de Ciência da Computação e no desenvolvimento de sistemas para a biodiversidade. Realiza pesquisas na linha de Banco de Dados, especialmente em Mineração de Dados aplicada aos dados da biodiversidade, com ênfase nos algoritmos de agrupamento e associação.</p>
											<a href="http://lattes.cnpq.br/4001922228786610"><img src="images/lattes.png" alt="Currículo Lattes" class="lattes"></a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- ./Team member -->
					<!-- Team member -->
					<div class="col-xs-12 col-sm-6 col-md-4">
						<div class="image-flip" ontouchstart="this.classList.toggle('hover');">
							<div class="mainflip">
								<div class="frontside">
									<div class="card">
										<div class="card-body text-center">
											<p><img class=" img-fluid card-background-image" src="images/demo/backgrounds/rsz_1fundo-jb.jpg"></p>
											<p><img class=" img-fluid" src="images/equipe/guilhermegall.png" alt="card image"></p>
											<h4 class="card-title">Guilherme Magalhães Gall</h4>
											<p class="card-text"></p>
											<a href="#" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
										</div>
									</div>
								</div>
								<div class="backside">
									<div class="card">
										<div class="card-body text-center mt-4">
											<p class="card-text">Possui graduação em Formação em Tecnologia da Informação e Comunicação pelo Instituto Superior de Tecnologia em Ciências da Computação de Petrópolis (2010). Tem experiência na área de Tecnologia da Informação, com ênfase em Administração de Sistemas.</p>
											<a href="http://lattes.cnpq.br/4624133335288514"><img src="images/lattes.png" alt="Currículo Lattes" class="lattes"></a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- ./Team member -->
					<!-- Team member -->
					<div class="col-xs-12 col-sm-6 col-md-4">
						<div class="image-flip" ontouchstart="this.classList.toggle('hover');">
							<div class="mainflip">
								<div class="frontside">
									<div class="card">
										<div class="card-body text-center">
											<p><img class=" img-fluid card-background-image" src="images/demo/backgrounds/rsz_1fundo-jb.jpg"></p>
											<p><img class=" img-fluid" src="images/equipe/rafael.png" alt="card image"></p>
											<h4 class="card-title">Rafael Oliveira Lima</h4>
											<p class="card-text"></p>
											<a href="#" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
										</div>
									</div>
								</div>
								<div class="backside">
									<div class="card">
										<div class="card-body text-center mt-4">
											<p class="card-text">Possui graduação pela Universidade Federal Fluminense (2010). Atualmente é técnico 2-ii - regime jurídico único do Instituto de Pesquisa Jardim Botânico do Rio de Janeiro. Tem experiência na área de Ciência da Computação, com ênfase em Arquitetura de Sistemas de Computação.</p>
											<a href="http://lattes.cnpq.br/6565160336065983"><img src="images/lattes.png" alt="Currículo Lattes" class="lattes"></a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- ./Team member -->
					<!-- Team member -->
					<div class="col-xs-12 col-sm-6 col-md-4">
						<div class="image-flip" ontouchstart="this.classList.toggle('hover');">
							<div class="mainflip">
								<div class="frontside">
									<div class="card">
										<div class="card-body text-center">
											<p><img class=" img-fluid card-background-image" src="images/demo/backgrounds/rsz_1fundo-jb.jpg"></p>
											<p><img class=" img-fluid" src="images/equipe/felipesodre.png" alt="card image"></p>
											<h4 class="card-title">Felipe Sodré Mendes Barros</h4>
											<p class="card-text"></p>
											<a href="#" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
										</div>
									</div>
								</div>
								<div class="backside">
									<div class="card">
										<div class="card-body text-center mt-4">
											<p class="card-text">Geógrafo formado pela PUC-Rio, em 2010, possui pós-graduação em 'Análise Ambiental e Gestão do Território' pela ENCE/IBGE e mestrado em Biodiversidade pela Escola Nacional de Botanica Tropical (ENBT) / Jardim Botanico do Rio de Janeiro (JBRJ). Atua nas áreas de Meio Ambiente, Sustentabilidade e Análise Espacial através das ferramentas e tecnologias de Sensoriamento Remoto, Geoprocessamento e Modelagem espacial . Possui conhecimento em banco de dados geográficos (PostGIS), diversos softwares de Sistemas de Informações Geográficas (QGIS, ArcGIS) e em sistemas de análise de dados (R). Pesquisador associado do Instituto Internacional para Sustentabilidade (IIS) de 2013 à Janeiro de 2017.</p>
											<a href="http://lattes.cnpq.br/8403301812573195"><img src="images/lattes.png" alt="Currículo Lattes" class="lattes"></a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- ./Team member -->
					<!-- Team member -->
					<div class="col-xs-12 col-sm-6 col-md-4">
						<div class="image-flip" ontouchstart="this.classList.toggle('hover');">
							<div class="mainflip">
								<div class="frontside">
									<div class="card">
										<div class="card-body text-center">
											<p><img class=" img-fluid card-background-image" src="images/demo/backgrounds/rsz_1fundo-jb.jpg"></p>
											<p><img class=" img-fluid" src="images/equipe/renata.png" alt="card image"></p>
											<h4 class="card-title">Renata de Toledo Capellão</h4>
											<p class="card-text"></p>
											<a href="#" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
										</div>
									</div>
								</div>
								<div class="backside">
									<div class="card">
										<div class="card-body text-center mt-4">
											<p class="card-text">Graduada em Ciências Biológicas com bacharelado em Genética pela Universidade Federal do Rio de Janeiro (2013). Durante a graduação, foi bolsista de Iniciação Científica no Laboratório de Biologia Evolutiva Teórica e Aplicada (LBETA- UFRJ). Em 2016, completou o mestrado no Programa de Pós Graduação em Genética na Universidade Federal do Rio de Janeiro (PGGen - UFRJ), sob orientação do professor Carlos Eduardo Guerra Schrago. Possui ampla experiência na área de Biologia Computacional, com ênfase em análises estatísticas de dados em larga escala, inferências de parâmetros macroevolutivos e populacionais e estimativas temporais de escalas evolutivas. Atuação principal voltada para área Biologia evolutiva, com forte interesse em biogeografia histórica, filogeografia, estudos de vulnerabilidade populacional e análises e desenvolvimento de estratégias para conservação da biodiversidade.</p>
											<a href="http://lattes.cnpq.br/6427808691075674"><img src="images/lattes.png" alt="Currículo Lattes" class="lattes"></a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- ./Team member -->
				</div>
			</div>
				
			<!-- Second Half -->

			<div class="col-md-6 p-0 bg-white h-md-100 loginarea">
				<h3 class="role-title" onClick="toggleTeam('bolsistas')">Pesquisadores</h3>
				<div id="bolsistas" class="row">
					<!-- Team member -->
					<div class="col-xs-12 col-sm-6 col-md-4">
						<div class="image-flip" ontouchstart="this.classList.toggle('hover');">
							<div class="mainflip">
								<div class="frontside">
									<div class="card">
										<div class="card-body text-center">
											<p><img class=" img-fluid card-background-image" src="images/demo/backgrounds/rsz_1fundo-jb.jpg"></p>
											<p><img class=" img-fluid" src="images/equipe/andreasanchez.png" alt="card image"></p>
											<h4 class="card-title">Andrea Sánchez Tapia</h4>
											<p class="card-text"></p>
											<a href="#" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
										</div>
									</div>
								</div>
								<div class="backside">
									<div class="card">
										<div class="card-body text-center mt-4">
											<p class="card-text">Bióloga (Universidade Nacional da Colômbia, 2006), Especialista em Gestão Ambiental (COPPE/UFRJ, 2008), Mestre em Ecologia (UFRJ, 2011). Estudante de doutorado do Programa de Pós-graduação em Botânica na Escola Nacional de Botânica Tropical (ENBT-JBRJ 2013-2017). Experiência em ecologia de comunidades vegetais com ênfase em ecologia quantitativa, estruturação de comunidades, ecologia da restauração e modelos de nicho ecológico.</p>
											<a href="http://lattes.cnpq.br/8900415459588165"><img src="images/lattes.png" alt="Currículo Lattes" class="lattes"></a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- ./Team member -->
					<!-- Team member -->
					<div class="col-xs-12 col-sm-6 col-md-4">
						<div class="image-flip" ontouchstart="this.classList.toggle('hover');">
							<div class="mainflip">
								<div class="frontside">
									<div class="card">
										<div class="card-body text-center">
											<p><img class=" img-fluid card-background-image" src="images/demo/backgrounds/rsz_1fundo-jb.jpg"></p>
											<p><img class=" img-fluid" src="images/equipe/diogo.png" alt="card image"></p>
											<h4 class="card-title">Diogo Souza Bezerra Rocha</h4>
											<p class="card-text"></p>
											<a href="#" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
										</div>
									</div>
								</div>
								<div class="backside">
									<div class="card">
										<div class="card-body text-center mt-4">
											<p class="card-text">Doutor em Ecologia e Conservação da Biodiversidade pela Universidade Estadual de Santa Cruz (UESC). Mestre em Botânica pelo Programa de Pós-Graduação em Botânica da Universidade Estadual de Feira de Santana (UEFS) . Bacharel em Ciências Biológicas, com ênfase em Ecologia pela UEFS. Tem experiência em ambiente de programação R e programas de Sistema de Informação Geográfica (SIG) como o ArcGIS. Desenvolve pesquisa nos seguintes temas: Fitossociologia / estrutura de comunidades, Modelagem de Distribuição de Espécies e Mata Atlântica.</p>
											<a href="http://lattes.cnpq.br/7375573875959020"><img src="images/lattes.png" alt="Currículo Lattes" class="lattes"></a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- ./Team member -->
					<!-- Team member -->
					<div class="col-xs-12 col-sm-6 col-md-4">
						<div class="image-flip" ontouchstart="this.classList.toggle('hover');">
							<div class="mainflip">
								<div class="frontside">
									<div class="card">
										<div class="card-body text-center">
											<p><img class=" img-fluid card-background-image" src="images/demo/backgrounds/rsz_1fundo-jb.jpg"></p>
											<p><img class=" img-fluid" src="images/equipe/saramortara.png" alt="card image"></p>
											<h4 class="card-title">Sara Ribeiro Mortara</h4>
											<p class="card-text"></p>
											<a href="#" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
										</div>
									</div>
								</div>
								<div class="backside">
									<div class="card">
										<div class="card-body text-center mt-4">
											<p class="card-text">Sou Bacharel e Licenciada em Ciências Biológicas pela Universidade de São Paulo (USP/ESALQ), mestre pelo programa de Ecologia e Conservação da Biodiversidade na Universidade Estadual de Santa Cruz (UESC) e doutora em Ecologia pela Universidade de São Paulo. Sou pós-doutoranda do Núcleo de Computação Científica e Geoprocessamento do Jardim Botânico do Rio de Janeiro e pesquisadora associada ao Laboratório de Ecologia Teórica do IB-USP. Meu principal interesse é em teoria em Ecologia de Comunidades e Conservação e meu trabalho envolve relacionar dados empíricos com modelos estatísticos para compreender os processos que afetam comunidades e subsidiar ações de conservação.</p>
											<a href="http://lattes.cnpq.br/1367565226603309"><img src="images/lattes.png" alt="Currículo Lattes" class="lattes"></a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- ./Team member -->
					<!-- Team member -->
					<div class="col-xs-12 col-sm-6 col-md-4">
						<div class="image-flip" ontouchstart="this.classList.toggle('hover');">
							<div class="mainflip">
								<div class="frontside">
									<div class="card">
										<div class="card-body text-center">
											<p><img class=" img-fluid card-background-image" src="images/demo/backgrounds/rsz_1fundo-jb.jpg"></p>
											<p><img class=" img-fluid" src="images/equipe/kelefirmiano.png" alt="card image"></p>
											<h4 class="card-title">Kele Rocha Firmiano</h4>
											<p class="card-text"></p>
											<a href="#" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
										</div>
									</div>
								</div>
								<div class="backside">
									<div class="card">
										<div class="card-body text-center mt-4">
											<p class="card-text">Graduada em Ciências Biológicas pela Universidade Federal de Minas Gerais. Mestre e Doutora em Ecologia, Conservação e Manejo da Vida Silvestre pela Universidade Federal de Minas Gerais. Atualmente é bolsista no Programa de Capacitação Institucional (CNPq) no Instituto Nacional da Mata Atlântica (INMA), baseada no Instituto de Pesquisas Jardim Botânico do Rio de Janeiro onde investiga os impactos de mudanças climáticas na distribuição de espécies arbóreas e arbustivas da Bacia Hidrográfica do Rio Doce. Possui experiência em ecologia de ecossistemas aquáticos com ênfase em comunidades de macroinvertebrados bentônicos bioindicadores de qualidade água. Principais trabalhos abordam: limiares ecológicos, perda de biodiversidade, uso e ocupação do solo, atributos funcionais, dispersão, metacomunidades e filtros ambientais.</p>
											<a href="http://lattes.cnpq.br/9930203288918332"><img src="images/lattes.png" alt="Currículo Lattes" class="lattes"></a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- ./Team member -->
					<!-- Team member -->
					<div class="col-xs-12 col-sm-6 col-md-4">
						<div class="image-flip" ontouchstart="this.classList.toggle('hover');">
							<div class="mainflip">
								<div class="frontside">
									<div class="card">
										<div class="card-body text-center">
											<p><img class=" img-fluid card-background-image" src="images/demo/backgrounds/rsz_1fundo-jb.jpg"></p>
											<p><img class=" img-fluid" src="images/equipe/brunocarvalho.png" alt="card image"></p>
											<h4 class="card-title">Bruno Moreira de Carvalho</h4>
											<p class="card-text"></p>
											<a href="#" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
										</div>
									</div>
								</div>
								<div class="backside">
									<div class="card">
										<div class="card-body text-center mt-4">
											<p class="card-text">Doutor em Ecologia e Evolução pela Universidade do Estado do Rio de Janeiro (2016), com estágio de doutorado sanduíche na London School of Hygiene and Tropical Medicine, University of London, Inglaterra (2015). Mestre em Biologia Parasitária pelo Instituto Oswaldo Cruz, Fundação Oswaldo Cruz (2011). Graduação em Ciências Biológicas pela Universidade Estácio de Sá nas habilitações Bacharelado (2008) e Licenciatura (2006). Entomologista especializado em mapeamentos da distribuição potencial de vetores de doenças em cenários de mudanças climáticas através de modelagem de nicho ecológico. Atualmente é bolsista pelo Programa de Capacitação Institucional nível DA (CNPq) no Instituto Nacional da Mata Atlântica (INMA), baseado no Instituto de Pesquisas Jardim Botânico do Rio de Janeiro. Principais trabalhos incluem os tópicos: ecologia de doenças, biogeografia, mudanças climáticas, modelagem matemática, análise espacial, biologia e taxonomia de flebotomíneos, eco-epidemiologia das leishmanioses.</p>
											<a href="http://lattes.cnpq.br/5725434538672496"><img src="images/lattes.png" alt="Currículo Lattes" class="lattes"></a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- ./Team member -->
					<!-- Team member -->
					<div class="col-xs-12 col-sm-6 col-md-4">
						<div class="image-flip" ontouchstart="this.classList.toggle('hover');">
							<div class="mainflip">
								<div class="frontside">
									<div class="card">
										<div class="card-body text-center">
											<p><img class=" img-fluid card-background-image" src="images/demo/backgrounds/rsz_1fundo-jb.jpg"></p>
											<p><img class=" img-fluid" src="images/equipe/tainarocha.png" alt="card image"></p>
											<h4 class="card-title">Tainá Carreira da Rocha</h4>
											<p class="card-text"></p>
											<a href="#" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
										</div>
									</div>
								</div>
								<div class="backside">
									<div class="card">
										<div class="card-body text-center mt-4">
											<p class="card-text">Tem doutorado pelo Programa de Pós-Graduação em Zoologia do Museu Paraense Emílio Goeldi/ UFPa. Mestrado pelo Programa de Pós-Graduação em Biologia Ambiental do Instituto de Estudos Costeiros/ UFPa. Graduada em licenciatura plena em ciência biológicas pela Universidade Federal do Pará (UFPa). Tem como principal linha de pesquisa as mudanças globais (mudanças climáticas e de uso e cobertura do solo) e suas implicações para biodiversidade e conservação, utilizando como ferramenta análises espaciais (SIG) e modelos de nicho ecológico, desenvolvidos e testados através da plataforma R. Atua na linha de pesquisa biogeografia, para compreender padrões de distribuição de espécies de aves dos biomas Amazônia e Mata Atlântica. E atua na docência e extensão no ensino Fundamental e Médio.</p>
											<a href="http://lattes.cnpq.br/3678449749062447"><img src="images/lattes.png" alt="Currículo Lattes" class="lattes"></a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- ./Team member -->
					<!-- Team member -->
					<div class="col-xs-12 col-sm-6 col-md-4">
						<div class="image-flip" ontouchstart="this.classList.toggle('hover');">
							<div class="mainflip">
								<div class="frontside">
									<div class="card">
										<div class="card-body text-center">
											<p><img class=" img-fluid card-background-image" src="images/demo/backgrounds/rsz_1fundo-jb.jpg"></p>
											<p><img class=" img-fluid" src="images/equipe/marcos.png" alt="card image"></p>
											<h4 class="card-title">Marcos Guimarães Antunes</h4>
											<p class="card-text"></p>
											<a href="#" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
										</div>
									</div>
								</div>
								<div class="backside">
									<div class="card">
										<div class="card-body text-center mt-4">
											<p class="card-text">Possui graduação em Ciência da Computação pela Universidade Federal do Rio de Janeiro (2017). Atualmente é desenvolvedor - Uplay Tecnologia Ltda. Tem experiência no desenvolvimento de aplicações front-end (HTML, CSS, JavaScript e Angular Material) e Chatbots para Facebook Messenger.</p>
											<a href="http://lattes.cnpq.br/6480779747844836"><img src="images/lattes.png" alt="Currículo Lattes" class="lattes"></a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- ./Team member -->
				</div>
			</div>
			
		</div>
	
    </div> <!--  container -->
	
</section>

<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<div class="wrapper row6 footer">
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
function toggleTeam(cargo){
	var display = document.getElementById(cargo).style.display;
	if(display == '' || display == 'block' || display == 'flex' || !display){
		document.getElementById(cargo).style.display = 'none';
	} else {
		document.getElementById(cargo).style.display = 'flex'
	}
}
</script>
</body>
</html>