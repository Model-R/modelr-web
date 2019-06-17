<script src="js/jquery.min.js"></script>

<!-- PNotify -->
<script type="text/javascript" src="js/notify/pnotify.core.js"></script>
<script type="text/javascript" src="js/notify/pnotify.buttons.js"></script>
<script type="text/javascript" src="js/notify/pnotify.nonblock.js"></script>	
<script src="js/cover.js"></script>

<link href="./templates/css/passoapasso" rel="stylesheet" type="text/css" media="all">

<div class="modal fade" id="passoapassoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4>Fluxo de Experimento</h4>
			</div>
			<div class="modal-body">
				<!-- Indicators -->
				<div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="false">
				  <!-- Wrapper for slides -->
				  <div class="carousel-inner">
					<div class="item active">
						<div>
							<img class="modal-image" src="./templates/imagens/imagem1.PNG" alt="Experimentos">
						</div>
						<div class="modal-paragraph">
							<p>
								Lista de Experimentos. No campo “Ação” dois comando podem ser executados. O primeiro leva o usuário para a visualização detalhada do Experimento. O segundo limpa todos os dados. No campo “Status” o usuário pode verificar a situação do Experimento
							</p>
							<p>
								Botão "Filtrar" - Neste campo o usuário pode filtrar a lista de experimentos pelo título.
							</p>
							<p>							
								Botões "Novo" e "Excluir" - Botões para criar e excluir experimentos. Para excluir um experimento ele precisa estar marcado na lista.
							</p>
							<p>								
								Botões "PDF" e "CSV" - Botões para download da lista de experimentos. Opções de PDF e CSV.
							</p>
						</div>
					</div>

					<div class="item">
					    <div>
							<img class="modal-image" src="./templates/imagens/pre tratamento dados bioticos.PNG" alt="Dados Bióticos">
						</div>
						<div class="modal-paragraph">
							<p>
								Tela Dados Bióticos - Aquisição.
								Nesta tela o usuário pode buscar as ocorrências das espécies que deseja no JABOT e GBIF ou enviar um CSV com os dados das espécies que deseja adicionar. Clicando em “Instruções”, o usuário pode verificar o formato padrão do CSV .
							</p>
							<p>
								Tela Dados Bióticos - Limpeza de Dados.
								Lista de filtros disponíveis para execução. O usuário pode clicar em cada um deles separadamente para executá-los. Todos os pontos cadastrados no experimento serão afetados.
								Caso o usuário tenha selecionado "Executar filtros automaticamente" na criação do experimento, essa lista não irá aparecer.
							</p>
						</div>
					</div>

					<div class="item">
					    <div>
							<img class="modal-image" src="./templates/imagens/pre tratamento dados abioticos.PNG" alt="Dados Abióticos">
						</div>
						<div class="modal-paragraph">
							<p>
								Tela Dados Abióticos - Seleção.
								O usuário pode escolher quais dados deseja utilizar na modelagem do seu experimento. É possível escolher entre WordClim v1, WordClim v2 e BioOracle.
							</p>
							<p>
								Tela Dados Abióticos - Extensão.
								O usuário pode desenhar no mapa qual a extensão geográfica da modelagem que deseja executar.
							</p>
						</div>
					</div>
				  
				  <div class="item">
						<div>
							<img class="modal-image" src="./templates/imagens/modelagem parametros.PNG" alt="Parâmetros">
						</div>
						<div class="modal-paragraph">
							<p>
								Tela Modelagem - Parâmetros.
								É possível escolher os parâmetros para a modelagem.
							</p>
						</div>
					</div>

					<div class="item">
					    <div>
							<img class="modal-image" src="./templates/imagens/modelagem resultados.PNG" alt="Resultados">
						</div>
						<div class="modal-paragraph">
							<p>
								Tela Modelagem - Resultados.
								O usuário pode visualizar os resultados dos seus modelos.
							</p>
						</div>
					</div>

					<div class="item">
					    <div>
							<img class="modal-image" src="./templates/imagens/pos processamento mapa.PNG" alt="Pós-processamento">
						</div>
						<div class="modal-paragraph">
							<p>
								Tela Pós-processamento - Mapa.
								 O modelo final gerado é exposto no Mapa. É possível a realização de cortes no modelo final.
							</p>
						</div>
						</div>
				  </div>

				  <!-- Left and right controls -->
				  <a class="left carousel-control" href="#myCarousel" data-slide="prev">
					<span class="glyphicon glyphicon-chevron-left"></span>
					<span class="sr-only">Previous</span>
				  </a>
				  <a class="right carousel-control" href="#myCarousel" data-slide="next">
					<span class="glyphicon glyphicon-chevron-right"></span>
					<span class="sr-only">Next</span>
				  </a>
				  
				  <ol class="carousel-indicators">
						<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
						<li data-target="#myCarousel" data-slide-to="1"></li>
						<li data-target="#myCarousel" data-slide-to="2"></li>
						<li data-target="#myCarousel" data-slide-to="3"></li>
						<li data-target="#myCarousel" data-slide-to="4"></li>
						<li data-target="#myCarousel" data-slide-to="5"></li>
					</ol>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">
					Fechar
				</button>
				<!-- <button type="button" class="btn btn-primary">Save changes</button> -->
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>


<!--
<div id="passoapassoModal" class="modal fade">
  <div class="modal-dialog"> 
    <div class="modal-content"> 
		<div class="modal-body"> 
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img class="d-block w-100" src="..." alt="First slide">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" src="..." alt="Second slide">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100" src="..." alt="Third slide">
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
		</div>
    </div>
  </div>
</div>-->