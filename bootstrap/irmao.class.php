<?php
class Irmao	
{
	var $conn;
	var $idirmao;
	var $ime;
	var $nome;
	var $idsituacao;
	var $rg;
	var $orgaoexpedicao;
	var $dataexpedicao;
	var $cpf;
	var $datanascimento;
	var $cidadenascimento;
	var $idestadonascimento;
	var $idpaisnascimento;
	var $naturalizadoem;
	
	var $idestadocivil;
	var $idprofissao;
	var $idreligiao;
	
	
	var $registrogob;
	var $datainscricao;
	var $idrito;
	var $numeroato;
	var $assinante;
	var $valorassinatura;
	var $assinaturagraal;
	var $valorgraal;

	var $idtipologradouro;
	var $rua;
	var $numero;
	var $bairro;
	var $cidade;
	var $idestado;
	var $cep;
	var $telefone;
	var $email;

	var $conjuge;
	var $qtdfilhos;
	var $qtdfilhas;

	var $pai;
	var $mae;
	
	var $observacao;

	var $idultimograu; // ultimo grau na tabela irmao has elevacao
	var $idultimocorpo; // função que retorno o ultimo corpo pela data de elevacao na tabela irmao has elevacao
	var $idultimocorpoatividade;
	var $ultimoanopagto;// função que retorno o ultimo ano pela data de irmaohasatividade

	var $novoirmao;
	var $mudancagrau;
	var $mudancaatividade;
	var $senha;

	var $idpais;
	var $celular;
	
	var $complemento;// endereco residencial
	var $caixapostal;
	var $telefoneresidecial;
	var $telefoneresidecial2;
	
	
	var $idultimaelevacao; // campo atualizado por uma trigger
	

	function pegaUltimoIrmaoCadastrado()
	{
		$sql = 'select max(idirmao) from irmao';
		$res = pg_exec($this->conn,$sql);
		$row = pg_fetch_array($res);
		return $row[0];
	}
		
	
	function atualizarElevacao()
	{
		
			$sql = 'update irmao set idcorpo = pegaultimocorpo(idirmao)';
			$result = pg_exec($this->conn,$sql);
			return $result;
	}
	
	function incluir()
	{	
		if (empty($this->ime))
		{
			$sql = 'select max(cast(ime as int))+1 from irmao';
			$result = pg_exec($this->conn,$sql);
			$row = pg_fetch_array($result);
			$ime = str_pad($row[0], 6, "0", STR_PAD_LEFT);
		}
		else
		{
			$ime = str_pad($this->ime, 6, "0", STR_PAD_LEFT);
 		}
		$sql = "insert into irmao (ime,registrogob,datainscricao,nome,
		idsituacao,
		rg,orgaoexpedicao,dataexpedicao,cpf,
		datanascimento,cidadenascimento,idestadonascimento,idpaisnascimento,naturalizadoem
		idestadocivil,idprofissao,idreligiao,
		idrito,
		numeroato,assinante,valorassinatura,assinaturagraal,
		valorgraal,idtipologradouro,rua,numero,bairro,cidade,
		idestado,cep,telefone,email,
		conjuge,qtdfilhos,qtdfilhas,pai,mae,observacao)
		 values ('".$ime."','".$this->registrogob."',	'now()',	'".$this->nome."',
		 '".$this->idsituacao."',
		 '".$this->rg."','".$this->orgaoexpedicao."','".$this->dataexpedicao."','".$this->cpf."',
		 '".$this->datanascimento."','".$this->cidadenascimento."',".$this->idestadonascimento.",'".$this->idpaisnascimento."','".$this->naturalizadoem."',
		 ".$this->idestadocivil.",".$this->idprofissao.",".$this->idreligiao.",".$this->idrito.",
		 '".$this->numeroato."','".$this->assinante."',	".$this->valorassinatura.",'".$this->assinaturagraal."',
		".$this->valorgraal.",".$this->idtipologradouro.",	'".$this->rua."','".$this->numero."','".$this->bairro."','".$this->cidade."',
		".$this->idestado.",'".$this->cep."',	'".$this->telefone."',	'".$this->email."',
		'".$this->conjuge."',".$this->qtdfilhos.",".$this->qtdfilhas.",	'".$this->pai."',	'".$this->mae."',	'".$this->observacao."')";

		echo $sql;
		exit;
		$resultado = pg_exec($this->conn,$sql);

		if ($resultado){
			$sql = 'select currval(\'irmao_idirmao_seq\')';
			$resultado = pg_exec($this->conn,$sql);
			$row = pg_fetch_array($resultado);
	    	return $row[0];
	   	}
	   	else
	   	{
	    	return false;
	   	}
	}
	
	function alterar($id)
	{
	$sql = "update irmao set registrogob='".$this->registrogob."',datainscricao='".$this->datainscricao."',nome='".$this->nome."',
		datanascimento='".$this->datanascimento."',cidadenascimento='".$this->cidadenascimento."',idestadonascimento='".$this->idestadonascimento."',idsituacao='".$this->idsituacao."',
		idestadocivil=".$this->idestadocivil.",idreligiao=".$this->idreligiao.",idprofissao=".$this->idprofissao.",idrito=".$this->idrito.",
		numeroato='".$this->numeroato."',assinante='".$this->assinante."',valorassinatura=".$this->valorassinatura.",assinaturagraal='".$this->assinaturagraal."',
		valorgraal=".$this->valorgraal.",idtipologradouro=".$this->idtipologradouro.",rua='".$this->rua."',numero='".$this->numero."',bairro='".$this->bairro."',cidade='".$this->cidade."',
		idestado=".$this->idestado.",cep='".$this->cep."',telefone='".$this->telefone."',email='".$this->email."',
		conjuge='".$this->conjuge."',qtdfilhos=".$this->qtdfilhos.",qtdfilhas=".$this->qtdfilhas.",pai='".$this->pai."',mae='".$this->mae."',observacao='".$this->observacao."' where idirmao = ".$id;
	   $resultado = pg_exec($this->conn,$sql);
	  // echo $sql;
	   if ($resultado){
			// preciso colocar isso aqui dentro de um trigger
			$sql='  update irmao set idultimaelevacao = (
			select idirmaohaselevacao from
			irmaohaselevacao,grau 
			where irmaohaselevacao.idirmao = irmao.idirmao
			and irmaohaselevacao.idirmao = irmao.idirmao
			and irmaohaselevacao.idgrau = grau.idgrau
			order by grau.codgrau desc
			limit 1)  where irmao.idirmao ='.$this->idirmao;;
			$resultado = pg_exec($this->conn,$sql);
	   
	   	  echo "Alterado com sucesso!";
	      return true;
	   }
	   else
	   {
	      return false;
	   }
	}

	function excluir($id)
	{
		$sql = "BEGIN;
		delete from irmaohaselevacao where idirmao = '".$id."';	
		delete from atividadeirmao where idirmao = '".$id."';	
		delete from irmao where idirmao = '".$id."'; 
		COMMIT";
	   	$resultado = pg_exec($this->conn,$sql);
       	if ($resultado){
	     	return true;
	   	}
	   	else
	   	{
			$resultado = pg_exec($this->conn,'ROLLBACK');
	    	return false;
	   	}
	}

    function incluirElevacao($idirmao,$idgrau,$idcorpo,$numerodiploma,$dataelevacao)
	{
		$data = substr($dataelevacao,6,4).'-'.substr($dataelevacao,3,2).'-'.substr($dataelevacao,0,2);
		$sql = "insert into irmaohaselevacao (idirmao,idgrau,idcorpo,numerodiploma,dataelevacao,datalancamento) values 
		(".$idirmao.",".$idgrau.",".$idcorpo.",'".$numerodiploma."','".$data."',now());";
		$resultado = pg_exec($this->conn,$sql);
//        echo $sql;	
//		exit;
		if ($resultado){
	     	return true;
	   	}
	   	else
	   	{
	    	return false;
	   	}
	}
	
	
	 function excluirElevacao($idelevacao)
	{
		$sql = "delete from irmaohaselevacao where idirmaohaselevacao=".$idelevacao;
		$resultado = pg_exec($this->conn,$sql);
		if ($resultado){
	     	return true;
	   	}
	   	else
	   	{
	    	return false;
	   	}
	}
	
	function incluirEmissaoCertificado($idgrau,$idirmao,$idirmaohaselevacao)
	{  
		$sql = "delete from emissaocertificado2 where idirmaohaselevacao = ".$idirmaohaselevacao.";";
		$sql.= "insert into emissaocertificado2 (idgrau,idirmao,idirmaohaselevacao,situacao)
				values (".$idgrau.",".$idirmao.",".$idirmaohaselevacao.",'A')";
		$resultado = pg_exec($this->conn,$sql);
//        echo $sql;
//		exit;
		if ($resultado){
	     	return true;
	   	}
	   	else
	   	{
	    	return false;
	   	}
	}

	function incluirEmissaoCartaoGrau($idgrau,$idirmao,$idirmaohaselevacao)
	{  
	
		$sql = "delete from emissaocartao where idirmaohaselevacao = ".$idirmaohaselevacao.";";
		$sql.= "insert into emissaocartao (tipocartao,idgrau,idirmao,idirmaohaselevacao,situacao)
				values ('2',".$idgrau.",".$idirmao.",".$idirmaohaselevacao.",'A')";
		$resultado = pg_exec($this->conn,$sql);
//        echo $sql;
//		exit;
		if ($resultado){
	     	return true;
	   	}
	   	else
	   	{
	    	return false;
	   	}
	}
	
	function incluirEmissaoCartaoAtividade($anopagamento,$idirmao,$idatividadeirmao)
	{  
	
		$sql = "delete from emissaocartao where idatividadeirmao = ".$idatividadeirmao.";";
		$sql.= "insert into emissaocartao (tipocartao,idirmao,idatividadeirmao,situacao)
				values ('1',".$idirmao.",".$idatividadeirmao.",'A')";
		$resultado = pg_exec($this->conn,$sql);
//        echo $sql;
//		exit;
		if ($resultado){
	     	return true;
	   	}
	   	else
	   	{
	    	return false;
	   	}
	}
	
	
	function excluirEmissaoCertificado($id)
	{  
		$sql = "update emissaocertificado2 set situacao = 'E' where emissaocertificado2 = ".$id;
		$resultado = pg_exec($this->conn,$sql);
//        echo $sql;
//		exit;
		if ($resultado){
	     	return true;
	   	}
	   	else
	   	{
	    	return false;
	   	}
	}
	
	function excluirEmissaoCartaoAtividade($id)
	{  
		$sql = "update emissaocartao set situacao = 'E' where idemissaocartao = ".$id;
		$resultado = pg_exec($this->conn,$sql);
//        echo $sql;
//		exit;
		if ($resultado){
	     	return true;
	   	}
	   	else
	   	{
	    	return false;
	   	}
	}
	
	
	
	function excluirEmissaoCartaoGrau($id)
	{  
		$sql = "update emissaocartao set situacao = 'E' where idemissaocartao = ".$id;
		$resultado = pg_exec($this->conn,$sql);
//        echo $sql;
//		exit;
		if ($resultado){
	     	return true;
	   	}
	   	else
	   	{
	    	return false;
	   	}
	}
	
	function incluirAtividade($idirmao,$anopagamento,$datalancamento,$idcorpo)
	{
		if (empty($idcorpo))
		{
			$idcorpo = 'null';
		}
		$data = substr($datalancamento,6,4).'-'.substr($datalancamento,3,2).'-'.substr($datalancamento,0,2);
		
		$sql = "insert into atividadeirmao (idirmao,anopagamento,datalancamento,idcorpo) values (".$idirmao.",".$anopagamento.",now(),".$idcorpo.");";
		$resultado = pg_exec($this->conn,$sql);
        //echo $sql;	
		if ($resultado){
	     	return true;
	   	}
	   	else
	   	{
	    	return false;
	   	}
	}
	function excluirAtividade($idatividadeirmao)
	{
		$sql = "delete from atividadeirmao where idatividadeirmao = ".$idatividadeirmao;
		$resultado = @pg_exec($this->conn,$sql);
       	if ($resultado){
	     	return true;
	   	}
	   	else
	   	{
	    	return false;
	   	}
	}

	function alterarSenha($idirmao,$senha)
	{
		$sql = "update irmao set senha='".$senha."' where idirmao = ".$idirmao;
		//echo $sql;
		$resultado = pg_exec($this->conn,$sql);
       	if ($resultado){
	     	return true;
	   	}
	   	else
	   	{
	    	return false;
	   	}
	}
	function alterarEmail($idirmao,$email)
	{
		$sql = "update irmao set email='".$email."' where idirmao = ".$idirmao;
		//echo $sql;
		$resultado = pg_exec($this->conn,$sql);
       	if ($resultado){
	     	return true;
	   	}
	   	else
	   	{
	    	return false;
	   	}
	}

	function alterarCPF($idirmao,$cpf)
	{
		$sql = "update irmao set cpf='".$cpf."' where idirmao = ".$idirmao;
//		echo $sql;
//		exit;
		$resultado = pg_exec($this->conn,$sql);
       	if ($resultado){
	     	return true;
	   	}
	   	else
	   	{
	    	return false;
	   	}
	}


	function autenticaIrmao($ime,$senha)
	{
		$ime = preg_replace('/[^[:alnum:]_]/', '',$ime);
		$senha = preg_replace('/[^[:alnum:]_]/', '',$senha);
	
		$sql = "select count(*) from irmao where ime = '".$ime."' and senha = '".$senha."'";
		
		$res = pg_exec($this->conn,$sql);
		$row = pg_fetch_array($res);
		if ($row[0]=='1')
		{
	     	return true;
	   	}
	   	else
	   	{
	    	return false;
	   	}
	}


	function alterarAtividade($idirmao,$idatividadeirmao,$anopagamento,$datalancamento)
	{
		$data = substr($datalancamento,6,4).'-'.substr($datalancamento,3,2).'-'.substr($datalancamento,0,2);
		$sql = "update atividadeirmao set anopagamento=".$anopagamento.", datalancamento='".$data."' where idatividadeirmao = ".$idatividadeirmao;
		$resultado = pg_exec($this->conn,$sql);
       	if ($resultado){
	     	return true;
	   	}
	   	else
	   	{
	    	return false;
	   	}
	}

	function pegaUltimoCorpoAtividade($idirmao)
	{
		$sql = "select idcorpo from atividadeirmao ai 
where ai.idirmao = '".$idirmao."' order by ai.anopagamento desc ";
		$res = pg_exec($this->conn,$sql);
		$row = pg_fetch_array($res);
		return $row[0];
	}
	
	function getDados($row)
	{
		   	$this->idirmao = $row['idirmao'];
		   	$this->ime = $row['ime'];
			$this->nome = $row['nome'];
			$this->idsituacao = $row['idsituacao'];
			$this->rg = $row['rg'];
			$this->orgaoexpedicao = $row['orgaoexpedicao'];
			$this->dataexpedicao = $row['dataexpedicao'];
			$this->cpf = $row['cpf'];
		   	$this->datanascimento = $row['datanascimento'];
		   	$this->cidadenascimento = $row['cidadenascimento'];
			$this->idestadonascimento = $row['idestadonascimento'];
			$this->idpaisnascimento = $row['idpaisnascimento'];
			
			$this->naturalizadoem = $row['naturalizadoem'];

			$this->idestadocivil = $row['idestadocivil'];
		   	$this->idprofissao = $row['idprofissao'];
		   	$this->idreligiao = $row['idreligiao'];
			

			$this->registrogob = $row['registrogob'];
			$this->datainscricao = $row['datainscricao'];
		   	$this->idrito = $row['idrito'];
			$this->numeroato = $row['numeroato'];
			$this->assinante = $row['assinante'];
			$this->valorassinatura = $row['valorassinatura'];
			$this->assinaturagraal = $row['assinaturagraal'];
			$this->valorgraal = $row['valorgraal'];
			$this->idtipologradouro = $row['idtipologradouro'];
			$this->rua = $row['rua'];
			$this->numero = $row['numero'];
			$this->bairro = $row['bairro'];
			$this->cidade = $row['cidade'];
			$this->idestado = $row['idestado'];
			$this->cep = $row['cep'];
		   	$this->telefone = $row['telefone'];
			
		   	$this->email = $row['email'];
		   	$this->conjuge = $row['conjuge'];
		   	$this->qtdfilhos = $row['qtdfilhos'];
		   	$this->qtdfilhas = $row['qtdfilhas'];
		   	$this->pai = $row['pai'];
		   	$this->mae = $row['mae'];

		   	$this->observacao = $row['observacao'];
			
			$this->idultimograu = $row['idgrau'];
			$this->idultimocorpo = $row['idcorpo'];
			$this->idultimocorpoatividade = $row['idultimocorpoatividade'];
			$this->ultimoanopagto = $row['ultimoanopagto'];

			$this->novoirmao = $row['novoirmao'];
			$this->mudancagrau = $row['mudancagrau'];
			$this->mudancaatividade = $row['mudancaatividade'];
			$this->senha = $row['senha'];
			
			
			$this->idultimaelevacao = $row['idultimaelevacao'];
			
			/*$sql = 'select * from irmaohaselevacao ihe where idelevacao = '.$this->idultimaelevacao;
			$res = pg_exec($this->conn,$sql);
			$row = pg_fetch_array($res);
			$this->idultimograu = $row['idgrau'];
			$this->idultimocorpo = $row[''];
*/
	}
	
	
	function listaCombo($nomecombo,$id,$refresh)
	{
	   	$sql = "select *,pegaultimocorpoatividade(idirmao) as idultimocorpoatividade from irmao order by nome ";
		$res = pg_exec($this->conn,$sql);
		$s = '';
		if ($refresh == 'S')
		{
			$s = " onChange='submit();'";
		}
		$html = "<select name='".$nomecombo."' id = '".$nomecombo."' ".$s."  style='width : 300px;'>";
		$html .= "<option value=''>Selecione o irmao</Option>";
		while ($row = pg_fetch_array($res))
		{
			$s = '';
			if ($id == $row['idirmao'])
			{
			   $s = "selected";
			}
		   $html.="<option value='".$row['idirmao']."' ".$s." >".$row['nome']."</option> ";
	    }
		$html .= '</select>';
		return $html;	
	}
	
	function getById($id)
	{
		if (empty($id)){
	    	$id = 0;
	   	}
	   	$sql = 'select * from irmao i left join irmaohaselevacao ihe on
		i.idultimaelevacao = ihe.idirmaohaselevacao
		where
		i.idirmao = '.$id;
		
		$result = pg_exec($this->conn,$sql);
		if (pg_num_rows($result)>0){
	    	$row = pg_fetch_array($result);
		   	$this->getDados($row);
			return 1;
		}
		else
		{
    		return 0;
		}
	}

	function getByIME($ime)
	{
		if (empty($ime)){
	    	$ime = '0';
	   	}
	   	$sql = 'select irmao.*,pegaultimograu(irmao.idirmao) as idultimograu, pegaultimocorpo(irmao.idirmao) as idultimocorpo
		, pegaultimoanopagto(irmao.idirmao) as ultimoanopagto,pegaultimocorpoatividade(idirmao) as idultimocorpoatividade
from irmao
where ime = \''.$ime.'\'';
		
		$result = pg_exec($this->conn,$sql);
		if (pg_num_rows($result)>0){
	    	$row = pg_fetch_array($result);
		   	$this->getDados($row);
			return 1;
		}
		else
		{
    		return 0;
		}
	}
	
	function proximoIME()
	{
		$sql = 'select max(cast(ime as int))+1 from irmao';
		$result = pg_exec($this->conn,$sql);
		$row = pg_fetch_array($result);
		$ime = str_pad($row[0], 6, "0", STR_PAD_LEFT);
		return $ime;
	}


	function conta()
	{
		$sql = "select count(*) from irmao " ;
		$result = pg_query($this->conn,$sql);
		$row=pg_fetch_row($result);
		return $row[0];
	}
}
?>