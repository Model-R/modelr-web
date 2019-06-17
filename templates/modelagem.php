<script src="js/jquery.min.js"></script>

<!-- PNotify -->
<script type="text/javascript" src="js/notify/pnotify.core.js"></script>
<script type="text/javascript" src="js/notify/pnotify.buttons.js"></script>
<script type="text/javascript" src="js/notify/pnotify.nonblock.js"></script>	
<script src="js/cover.js"></script>

<div class="modal fade" id="modelagemModal" tabindex="-1" role="dialog" aria-labelledby="modelagemModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modelagemModalLabel">Modelagem</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="font-size: 16px;text-align: justify;">
                <p>
					Etapa de criação dos modelos com os dados limpos na etapa de pré-processamento e as
					variáveis preditoras selecionadas.
				</p>
				<p>
					Nessa etapa é realizada a seleção/escolha dos parâmetros a serem utilizados: tipo de
					particionamento, número de repetições, número de partições; número de pontos, TSS,
					buffer e resolução. Nessa etapa também é realizada a seleção/escolha dos algoritmos
					para a modelagem: Mahalanobis, Maxent, GLM, Bioclim, Random Forest, Domain e
					SVM.
				</p>
            </div>
        </div>
    </div>
</div>