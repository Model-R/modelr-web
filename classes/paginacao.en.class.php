<?php
class Paginacao
{
	var $conn; // a conexão
    var $ID;
    var $sql; // a seleção sem o filtro
	var $filtro; // o filtro a ser aplicado ao sql/
	var $order; // como será ordenado o resultado
	var $numero_colunas = 1; // quantidade de colunas por linha // se for = 1 é sinal que é listagem por linha
	var $numero_linhas = 5; // quantidade de linhas por páginas
	var $quadro; // conteúdo em a ser exibido
	var $altura_linha = '20px'; // altura do quadro em pixel
	var $largura_coluna = '10px';
	var $tamanho_imagem = 0; // tamanho da imagem = 0 se não existir imagem;
	var $mostra_informe = 'T';//
	var $pagina ;
	var $separador;
	 // linha que separa as rows;
	
	function desenha($row)
	{
	   // exemmplo de quadro
	   //echo '<td height="135" valign="top">';
	   //echo $imagem.'<br>'.$row['nomepessoa'];
	   //echo '</td>';
	}
	
	function desenhacabeca($row)
	{
	}

	function pegaPaginaInicio($p,$total,$por_pagina)
	{
	   if ($total >10){
		  if ($p <= $por_pagina) {
			  $pag_inicio = 1;
			  if ($p > ($por_pagina / 2))
			  {
				 $pag_inicio = $pag_inicio;
			  }
		  }
		  else 
		  {
			  $pag_inicio = ceil($p/$por_pagina);
			  $pag_inicio = ($pag_inicio-1)*$por_pagina+1;
			  if ($p>=($pag_inicio+10))
			  {
				   $pag_inicio = $pag_inicio + 10;
			  }
		  }
	   }
	   else
	   {
	       $pag_inicio = 1;
	   }
	   return $pag_inicio;
	}

	function pegaInforme($p,$numero_por_paginas,$num_registros,$total_paginas)
	{
		
		
    	  $informe = " Mostrando ". (($p*$numero_por_paginas)-($numero_por_paginas-1))." - ".($p*$numero_por_paginas)." de ".$num_registros." em ".$total_paginas." Paginas";
		  return $informe;
	}

	function paginar()
	{
		  $p = $this->pagina;
		  if (empty($p))
		  {
		  	$p = 1;
		  }
	      $col = $this->numero_colunas;
       	  $row = $this->numero_linhas;
		  if (empty($row))
		  {
		  	$row=10;
		  }
		  $tam = $this->tamanho_imagem;
		  $sql = $this->sql;
		  $separador = $this->separador;
		  $t = $this->tamanho_imagem;
		  $o = $this->order;
		  $mostra_informe = $this->mostra_informe;
		  $res = pg_query($this->conn,$sql);
   		  $num_registros = pg_num_rows($res);
		  $numero_por_paginas=$row*$col;
		  $total_paginas = ceil($num_registros/$numero_por_paginas);
		  $pag_inicio = $this->pegaPaginaInicio($p,$total_paginas,$numero_por_paginas);
		  $sql .= $sql_ordem ." offset ".($p-1)*$numero_por_paginas." limit ".$numero_por_paginas."";
		  $res = pg_query($this->conn,$sql);
   		  $informe = $this->pegaInforme($p,$numero_por_paginas,$num_registros,$total_paginas);
		?>  

		<table border="0" class="table table-striped table-bordered table-hover" >
		<tbody> 
			<?php
				$d = 0;
				while ($row2=pg_fetch_array($res))
				{
				   if ($d==0)
				   {
						$this->desenhacabeca($row2);
						$d++;
				   }
				   if ($c==0) {echo "<tr>";  }
				   $c++;
				   
				   $this->desenha($row2);
					 if ($c==$col) {$c=0; echo "</tr>";
					 if ($separador == 'T'){
					 ?>
					 <tr><td colspan="<?php echo $col;?>"><hr></td></tr>
					 <?php }
					 }
	
				} ?>
				 				
		</tbody>
		</table>

		<table align="center" width="100%" class="table">
          <tr> 
            <td align="left"><?php echo $informe;?></td>
            <td align="center">Mostrar <select name='cmboxqtdrowspaginacao' id='cmboxqtdrowspaginacao' onChange="montapaginacao(<?php echo $p;?>,this.value)">
		<option value="10" <?php if ($row=='10') echo "SELECTED";?>>10</option>
		<option value="20" <?php if ($row=='20') echo "SELECTED";?>>20</option>
		<option value="50" <?php if ($row=='50') echo "SELECTED";?>>50</option>
		<option value="100" <?php if ($row=='100') echo "SELECTED";?>>100</option>
		<option value="10000" <?php if ($row=='10000') echo "SELECTED";?>>Todas</option>
		</select> Registros</td>
            <td align="right">
			<?php
			?>
			<a class="btn btn-default btn-xs" onClick="montapaginacao(<?php echo '1';?>,document.getElementById('cmboxqtdrowspaginacao').value)"><?php echo "Primeria";?></a>
			<?php if ($p!=1){
			?>
			<a class="btn btn-default btn-xs" onClick="montapaginacao(<?php echo $p-1;?>,document.getElementById('cmboxqtdrowspaginacao').value)"><?php echo "Anterior";?></a>
			<?php } ?>
<?php			
			for ($pag = $pag_inicio ; $pag < $pag_inicio + 10; $pag++)
			{
			   $classetabela = "btn-default btn-xs";
			   if ($pag==$p){
			   	 $classetabela = 'btn btn-primary btn-xs'; 
			   }
			   if ($pag <= $total_paginas){
			    ?><a class="btn <?php echo $classetabela;?>" onClick="montapaginacao(<?php echo $pag;?>,document.getElementById('cmboxqtdrowspaginacao').value)"><?php echo $pag;?></a>
			<?php 
			    }
			} ?>   
			<?php if ($p!=$total_paginas){
			?>
			<a class="btn btn-default btn-xs" onClick="montapaginacao(<?php echo $p+1;?>,document.getElementById('cmboxqtdrowspaginacao').value)"><?php echo "Proxima";?></a>
			<?php } ?>
			<a  class="btn btn-default btn-xs" onClick="montapaginacao(<?php echo $total_paginas;?>,document.getElementById('cmboxqtdrowspaginacao').value)"><?php echo " Ultima";?></a>
			</td>
          </tr>
		</table>	
	<?php 
	}
}
?>