<?php

require_once('classes/conexao.class.php');
require_once('classes/experimento.class.php');

$clConexao = new Conexao;
$conn = $clConexao->Conectar();

$Experimento = new Experimento();
$Experimento->conn = $conn;

$op=$_REQUEST['op'];
$id=$_REQUEST['id'];

if ($op=='A')
{
	$Experimento->getById($id);
	$idexperiment = $Experimento->idexperiment;
	$name = $Experimento->name;
    $description = $Experimento->description;
    $grupo = $Experimento->group;
}

?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><a href="consexperimento.php">Informações</a></h2>
                <div class="clearfix">
                </div>
            </div>
            <div class="x_content">
                <form name='frm' id='frm' action='exec.experimento.php' method="post" class="form-horizontal form-label-left" novalidate>
                    <input id="op" value="<?php echo $op;?>" name="op" type="hidden">
                    <input id="id" value="<?php echo $id;?>" name="id" type="hidden">
                    <div class="">
                        <div>
                            <div class="item form-group info-field">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="edtexperimento">Experimento <span class="required">*</span>
                            </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="edtexperimento" value="<?php echo $name;?>"  name="edtexperimento" class="form-control col-md-7 col-xs-12" required="required">
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <div class="item form-group info-field">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="edtdescricao">Descrição
                            </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="edtdescricao" value="<?php echo $description;?>"  name="edtdescricao" class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <div class="item form-group info-field">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="edtgrupo">Grupo
                            </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="edtgrupo" value="<?php echo $grupo;?>"  name="edtgrupo" class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>
                        </div>
                        <?php if ($op!='I')
                        {?>
                        <div class="new_experiment_send_button">
                            <button id="send" type="button" onclick="enviarExp()" class="btn btn-info" data-toggle="tooltip" data-placement="top" title data-original-title="Salvar informações">Salvar</button>

                            <?php
                            $sql = "select idoccurrence,idexperiment,iddatasource,taxon,collector,collectnumber,server,
                            path,file,occurrence.idstatusoccurrence,pathicon,statusoccurrence,country,majorarea,minorarea,
                            case when lat2 is not null then lat2 else lat end as lat,
                            case when long2 is not null then long2
                            else long end as long
                            from modelr.occurrence, modelr.statusoccurrence where 
                            occurrence.idstatusoccurrence = statusoccurrence.idstatusoccurrence and
                            (occurrence.idstatusoccurrence = 4 or occurrence.idstatusoccurrence = 17) and
                            idexperiment = ".$id;

                            $res = pg_exec($conn,$sql);
                            $total = pg_num_rows($res);
                            ?>
                        </div>
                        <?php } ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="custom_notifications" class="custom-notifications dsp_none">
        <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
        </ul>
        <div class="clearfix"></div>
        <div id="notif-group" class="tabbed_notifications"></div>
    </div>

    <script src="js/custom.js"></script>
    <!-- form validation -->
    <script src="js/validator/validator.js"></script>
	
	<script src="js/loading.js"></script>	

    <!-- PNotify -->
    <script type="text/javascript" src="js/notify/pnotify.core.js"></script>
    <script type="text/javascript" src="js/notify/pnotify.buttons.js"></script>
    <script type="text/javascript" src="js/notify/pnotify.nonblock.js"></script>	
    
<script>
    function enviarExp(){
        exibe('loading');
        if ((document.getElementById('edtexperimento').value==''))
        {
            criarNotificacao('Atenção','Verifique o preenchimento','warning');
        }
        else
        {
            document.getElementById('frm').action='exec.experimento.php';
            document.getElementById('frm').submit();
        }
    }
</script>