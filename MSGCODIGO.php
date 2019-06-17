<?php 


$MSGCODIGO = $_REQUEST['MSGCODIGO'];
if ($MSGCODIGO=='0')
{		
		echo "
		criarNotificacao('Sucesso','O cadastro da configuração foi realizado com sucesso!','success');";
}
if ($MSGCODIGO=='1')
{
		echo "
		criarNotificacao('Erro','Não foi possível cadastrar a configuração!','erro');";
}

if ($MSGCODIGO=='2')
{
		echo "
		criarNotificacao('Sucesso','Cadastro/Alteração da senha foi realizado com sucesso!','success');";
}
if ($MSGCODIGO=='3')
{
		echo "
		criarNotificacao('Erro','Não foi possível Cadastrar/Alterar a Senha!','danger');";
}
if ($MSGCODIGO=='4')
{
		echo "
		criarNotificacao('Sucesso','Alteração do usuário foi realizado com sucesso!','success');";
}
if ($MSGCODIGO=='5')
{
		echo "
		criarNotificacao('Erro','Não foi possível Alterar o usuário!','erro');";
}
if ($MSGCODIGO=='6')
{
		echo "
		criarNotificacao('Sucesso','Usuário cadastrado com sucesso!','sucess');";
}
if ($MSGCODIGO=='7')
{
		echo "
		criarNotificacao('Erro','Não foi possível Cadastrar o usuário!','erro');";
}
if ($MSGCODIGO=='8')
{
		echo "
		criarNotificacao('Erro','Não foi possível enviar nova senha!','erro');";
}
if ($MSGCODIGO=='9')
{
		echo "
		criarNotificacao('Success','Nova senha enviado para o email informado!','success');";
}
if ($MSGCODIGO=='10')
{	
		echo "
		criarNotificacao('Erro','Usuário ou senha inválido!','danger');";
}

// PRODUTOR
if ($MSGCODIGO=='11')
{
		echo "
		criarNotificacao('Sucesso','Produtor cadastrado com sucesso!','sucess');";
}
if ($MSGCODIGO=='12')
{
		echo "
		criarNotificacao('Erro','Não foi possível Cadastrar o produtor!','erro');";
}
if ($MSGCODIGO=='13')
{
		echo "
		criarNotificacao('Sucesso','Alteração do produtor foi realizado com sucesso!','success');";
}
if ($MSGCODIGO=='14')
{
		echo "
		criarNotificacao('Erro','Não foi possível alterar o produtor!','erro');";
}
// PROPRIEDADE
if ($MSGCODIGO=='15')
{
		echo "
		criarNotificacao('Sucesso','Propriedade cadastrada com sucesso!','sucess');";
}
if ($MSGCODIGO=='16')
{
		echo "
		criarNotificacao('Erro','Não foi possível cadastrar a propriedade!','erro');";
}
if ($MSGCODIGO=='17')
{
		echo "
		criarNotificacao('Sucesso','Alteração da propriedade foi realizada com sucesso!','success');";
}
if ($MSGCODIGO=='18')
{
		echo "
		criarNotificacao('Erro','Não foi possível alterar a propriedade!','erro');";
}


// TECNICO
if ($MSGCODIGO=='19')
{
		echo "
		criarNotificacao('Sucesso','Sucesso!','success');";
}
if ($MSGCODIGO=='20')
{
		echo "
		criarNotificacao('Erro','Não foi possível cadastrar o técnico!','erro');";
}
if ($MSGCODIGO=='21')
{
		echo "
		criarNotificacao('Sucesso','Alteração do técnico foi realizada com sucesso!','success');";
}
if ($MSGCODIGO=='22')
{
		echo "
		criarNotificacao('Erro','Não foi possível alterar o técnico!','erro');";
}



// VISITA TÉCNICA
if ($MSGCODIGO=='23')
{
		echo "
		criarNotificacao('Sucesso','Visita Técnica cadastrada com sucesso!','sucess');";
}
if ($MSGCODIGO=='24')
{
		echo "
		criarNotificacao('Erro','Não foi possível cadastrar a visita técnica!','erro');";
}
if ($MSGCODIGO=='25')
{
		echo "
		criarNotificacao('Sucesso','Alteração na visita técnica foi realizada com sucesso!','success');";
}
if ($MSGCODIGO=='26')
{
		echo "
		criarNotificacao('Erro','Não foi possível alterar a visita técnica!','erro');";
}

if ($MSGCODIGO=='91')
{
		echo "
		criarNotificacao('Excluir','Projeto excluído com sucesso!','success');";
}
if ($MSGCODIGO=='92')
{
		echo "
		criarNotificacao('Incluir','Projeto adicionado com sucesso!','success');";
}
if ($MSGCODIGO=='93')
{
		echo "
		criarNotificacao('Incluir','Não foi possível cadastrar o projeto. Verifique o preenchimento dos campos!','danger');";
}
if ($MSGCODIGO=='94')
{
		echo "
		criarNotificacao('Alterar','Projeto alterado com sucesso!','success');";
}
if ($MSGCODIGO=='95')
{
		echo "
		criarNotificacao('Alterar','Não foi possível alterar o projeto. Verifique o preenchimento dos campos!','danger');";
}


if ($MSGCODIGO=='81')
{
		echo "
		criarNotificacao('Excluir','Experimento excluído com sucesso!','success');";
}
if ($MSGCODIGO=='82')
{
		echo "
		criarNotificacao('Incluir','Experimento adicionado com sucesso!','success');";
}
if ($MSGCODIGO=='83')
{
		echo "
		criarNotificacao('Incluir','Não foi possível cadastrar o experimento. Verifique o preenchimento dos campos!','danger');";
}
if ($MSGCODIGO=='84')
{
		echo "
		criarNotificacao('Alterar','experimento alterado com sucesso!','success');";
}
if ($MSGCODIGO=='85')
{
		echo "
		criarNotificacao('Alterar','Não foi possível alterar o experimento. Verifique o preenchimento dos campos!','danger');";
}
if ($MSGCODIGO=='71')
{
		echo "
		criarNotificacao('Adicionar ocorrência','Ocorrências adicionadas com sucesso!','success');";
}
if ($MSGCODIGO=='72')
{
		echo "
		criarNotificacao('Excluir pontos duplicados','Pontos duplicados excluído com sucesso!','success');";
}
if ($MSGCODIGO=='73')
{
		echo "
		criarNotificacao('Filtro Fora do Município','Pontos fora do município de origem verificado!','success');";
}
if ($MSGCODIGO=='74')
{
		echo "
		criarNotificacao('Filtro Fora Limite Brasil','Pontos fora do limit do Brasil verificado!','success');";
}
if ($MSGCODIGO=='75')
{
		echo "
		criarNotificacao('Filtro Automático','Filtro automático executado!','success');";
}

if ($MSGCODIGO=='76')
{
		echo "
		criarNotificacao('Modelagem','Não foi possível realizar a modelagem ! Número mínimo de ocorrências: 10','erro');";
}

if ($MSGCODIGO=='77')
{
		echo "
		criarNotificacao('Modelagem','Não foi possível realizar a modelagem !','erro');";
}

if ($MSGCODIGO=='78')
{
		echo "
		criarNotificacao('Modelagem','Não foi possível realizar a modelagem ! Seleciona uma variável abiótica na aba Pré-tratamento > Dados Abióticos.','erro');";
}
if ($MSGCODIGO=='79')
{
		echo "
		criarNotificacao('Sucesso','Nome alterado com sucesso!','success');";
}
if ($MSGCODIGO=='80')
{
		echo "
		criarNotificacao('Erro','Não foi possível alterar o nome do experimento!','error');";
}
if ($MSGCODIGO=='86')
{
		echo "
		criarNotificacao('Sucesso','Calculo de correlação concluído com sucesso.','success');";
}
?>

var permanotice, tooltip, _alert;
	
	function criarNotificacao(titulo,texto,tipo)
	{
            new PNotify({
                title: titulo,
                type: tipo,
                text: texto,
                nonblock: {
                    nonblock: true
                },
                before_close: function (PNotify) {
                    // You can access the notice's options with this. It is read only.
                    //PNotify.options.text;

                    // You can change the notice's options after the timer like this:
                    PNotify.update({
                        title: PNotify.options.title + " - Enjoy your Stay",
                        before_close: null
                    });
                    PNotify.queueRemove();
                    return false;
                }
            });

        
	};
