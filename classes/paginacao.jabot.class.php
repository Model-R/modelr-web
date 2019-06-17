<link rel="stylesheet" type="text/css" href="css/styles.css"/>
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
	var $codbasedados;
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

	function pegaInforme($p,$numero_por_paginas,$num_registros)
	{
    	  $informe = " Mostrando ". (($p*$numero_por_paginas)-($numero_por_paginas-1))." - ".($p*$numero_por_paginas)." do total de ".$num_registros." distribu&iacute;do(s) em ".$total_paginas." p&aacute;ginas";
		  return $informe;
	}

	function paginar()
	{
		  $p = $this->pagina;
	      $col = $this->numero_colunas;
       	  $row = $this->numero_linhas;
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
		  //$sql_ordem = $this->order;
		  $sql .= $sql_ordem ." offset ".($p-1)*$numero_por_paginas." limit ".$numero_por_paginas."";
		 // echo $sql .'-'. $this->codbasedados;
		  $res = pg_query($this->conn,$sql);
   		  $informe = $this->pegaInforme($p,$numero_por_paginas,$num_registros);
		?>  

        <table width="100%" border="0">
		  <?php if ($mostra_informe=='T'){?>
          <tr> 
            <td align="center"><?php echo $informe;?></td>
          </tr>
		  <?php } //?>
          <tr> 
          	<td>
				<table border="0" class="tab_cadrehov" >
				 
			<?php
				$d = 0;
				while ($row2=pg_fetch_array($res))
				{
				   if ($d==0)
				   {
						$this->desenhacabeca($row2);
						$d++;
				   }
				   if ($c==0) {echo "<tr class='tab_bg_1'>";  }
				   $c++;
				   
				   $this->desenha($row2);
					 if ($c==$col) {$c=0; echo "</tr>";
					 if ($separador == 'T'){
					 ?>
					 <tr><td colspan="<?php echo $col;?>"><hr></td></tr>
					 <?php }
					 }
	
				} ?>
				  </tr>				
				  </table>
			</td>
          </tr>
		 <?php if ($mostra_informe=='T'){?>
          <tr> 
            <td align="center"><?php echo $informe;?></td>
          </tr>
		  <?php } ?>
          <tr> 
            <td align="center">
			<?php
			?>
			<a  onClick="montapaginacao(<?php echo '1';?>,'<?php echo $t;?>','<?php echo $o;?>')"><?php echo "Primeira";?></a>
			<?php if ($p!=1){
			?>
			<a  onClick="montapaginacao(<?php echo $p-1;?>,'<?php echo $t;?>','<?php echo $o;?>')"><?php echo "Anterior";?></a>
			<?php } ?>
<?php			
			for ($pag = $pag_inicio ; $pag < $pag_inicio + 10; $pag++)
			{
			   if ($pag <= $total_paginas){
			    if ($pag==$p) echo "[";?><a  onClick="montapaginacao(<?php echo $pag;?>,'<?php echo $t;?>','<?php echo $o;?>')"><?php echo $pag;?></a><?php if ($pag==$p) echo "]";?>
			<?php 
			    }
			} ?>   
			<?php if ($p!=$total_paginas){
			?>
			<a  onClick="montapaginacao(<?php echo $p+1;?>,'<?php echo $t;?>','<?php echo $o;?>')"><?php echo "pr&oacute;xima";?></a>
			<?php } ?>
			<a  onClick="montapaginacao(<?php echo $total_paginas;?>,'<?php echo $t;?>','<?php echo $o;?>')"><?php echo " &Uacute;ltima";?></a>
			
				</td>
          </tr>
        </table>	
	<?php 
	}
}
?>