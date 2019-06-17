<section id="footer">
	<div>
		<div class="row text-center text-xs-center text-sm-left text-md-left">
			<div class="col-xs-12 col-sm-4 col-md-4">
				<h5 class="green-letter">Apoio</h5>
				<div id="partners">
					<ul class="list-unstyled quick-links">
						<div class="row">
							<li><img src="layout/images/capes.PNG" onClick="abrirProjeto('capes')"></img></li>
							<li><img src="layout/images/cnpq.PNG" onClick="abrirProjeto('cnpq')"></img></li>
							<li><img src="layout/images/sibbr.png" onClick="abrirProjeto('sibbr')"></img></li>
						</div>
						<div  class="row">
							<li><img src="layout/images/mctic.png"></img></li>
							<li><img src="layout/images/mec.png"></img></li>
						</div>
					</ul>
				</div>
			</div>
			<div class="col-xs-12 col-sm-4 col-md-4">
				<h5 class="green-letter">Parceiros</h5>
				<div id="suppoters">
					<ul class="list-unstyled quick-links">
						<div  class="row">
							<li><img src="layout/images/lncc.png"></img></li>
							<li><img src="layout/images/s dumont.png"></img></li>
						</div>
					</ul>
				</div>
			</div>
			<div class="col-xs-12 col-sm-4 col-md-4">
				<h5 class="green-letter">Endereço</h5>
				<div id="contact">
					<div class="row">
						<p class="address green-letter">
							Instituto de Pesquisas Jardim Botânico do Rio de Janeiro<br>
							Rua Pacheco Leão, 915 - Dipeq<br>
							Jardim Botânico - Rio de Janeiro - RJ<br>
							CEP: 22.460-030<br>
							Tel: (21)3204-2072<br>
						</p>
						<div class="images">
							<img src="layout/images/jb.PNG"></img>
							<img src="layout/images/mma.png"></img>
						</div>
					</div>
				</div>
				<!--<ul class="list-unstyled quick-links">
					<li><a href="javascript:void();"><i class="fa fa-angle-double-right"></i>Home</a></li>
					<li><a href="javascript:void();"><i class="fa fa-angle-double-right"></i>About</a></li>
					<li><a href="javascript:void();"><i class="fa fa-angle-double-right"></i>FAQ</a></li>
					<li><a href="javascript:void();"><i class="fa fa-angle-double-right"></i>Get Started</a></li>
					<li><a href="https://wwwe.sunlimetech.com" title="Design and developed by"><i class="fa fa-angle-double-right"></i>Imprint</a></li>
				</ul>-->
			</div>
		</div>
		<!--<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 mt-2 mt-sm-5">
				<ul class="list-unstyled list-inline social text-center">
					<li class="list-inline-item"><a href="javascript:void();"><i class="fa fa-facebook"></i></a></li>
					<li class="list-inline-item"><a href="javascript:void();"><i class="fa fa-twitter"></i></a></li>
					<li class="list-inline-item"><a href="javascript:void();"><i class="fa fa-instagram"></i></a></li>
					<li class="list-inline-item"><a href="javascript:void();"><i class="fa fa-google-plus"></i></a></li>
					<li class="list-inline-item"><a href="javascript:void();" target="_blank"><i class="fa fa-envelope"></i></a></li>
				</ul>
			</div>
			</hr>
		</div>	-->
	</div>
</section>

<script>
function abrirProjeto(projeto) {
	console.log('e')
	window.location.replace("https://model-r.jbrj.gov.br/v3/projects.php?projeto=" + projeto);
}

</script>