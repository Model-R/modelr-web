<?php @session_start();
$tokenUsuario = md5('seg'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']);
if ($_SESSION['donoDaSessao'] != $tokenUsuario)
{
//	header('Location: index.php');
}
	  require_once('classes/conexao.class.php');
	  $Conexao = new Conexao;
	  $conn = $Conexao->Conectar();
	  
?>
<div class="top_nav">

                <div class="nav_menu">
                    <nav class="" role="navigation">
                        
                           <ul class="nav navbar-nav navbar-left">
                            <li class="">
							<a href="consexperimento.php" class="user-profile dropdown-toggle">
                                    <img src="images/R.sh-600x600.png" alt="">Model-R
                                </a>
							</li>
							</ul>
                        

                        <ul class="nav navbar-nav navbar-right">
                            <li class="">
                                <a href="javascript:;" class="user-profile nav-user dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <img src="images/user.png" alt=""><?php echo $_SESSION['s_nome'];?>
                                    <span class=" fa fa-angle-down"></span>
                                </a>
								
                                <ul class="dropdown-menu dropdown-usermenu animated fadeInDown pull-right">
                                    <li>
                                        <a href="consexperimento.php">
                                            <!--<span class="badge bg-red pull-right">50%</span>-->
                                            <span>Meus Experimentos</span>
                                        </a>
                                    </li>
									<?php if (($_SESSION['s_idtipousuario'])==2)
									{
										?>
										<li><a href="consusuario.php">  Cadastro Usuário</a>
										</li>
									<?php	
									}
									?>
									<li><a href="trocarsenha.php">  Trocar Senha</a>
                                    </li>
                                    <li><a href="manual_modelr.pdf"><i class="fa fa-file-pdf-o pull-right"></i> Manual</a>
                                    </li>
                                    <li><a href="index.php"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                                    </li>
                                </ul>
                            </li>
							
							<?php $sql = '
							select * from modelr.experiment e where
 iduser = '.$_SESSION['s_idusuario'];
 //echo $sql;
								  $res = @pg_exec($conn,$sql);
								  $conta = @pg_num_rows($res);
								  $sql.=' order by name desc
								  limit 6 ';
								  $res = @pg_exec($conn,$sql);
								  ?>

                            <li role="presentation" class="dropdown">
                                <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                                    <i class="fa fa-envelope-o"></i>
                                    <span class="badge bg-green"><?php echo $conta;?></span>
                                </a>
                                <ul id="menu1" class="dropdown-menu list-unstyled msg_list animated fadeInDown" role="menu">
                                    
									<?php 
									$c = 0;
									while ($row = pg_fetch_array($res))
									{
										$c++;
									?>
									<li>
                                        <a>
                                            <!--<span class="image">
                                        <img src="images/user.png" alt="Profile Image" />
                                    </span>-->
                                            <span>
                                        <span><b>Experimento: </b><?php echo $row['name'];?></span>
                                            <span class="time"><?php //echo date('d/m/Y',strtotime($row['datavisita']));?></span>
                                            </span>
                                            <span class="message">Descrição: </b><?php echo $row['description'];?>
                                         
                                    </span>
                                        </a>
                                    </li>
									<?php } ?>
									
                                   
                                    <li>
                                        <div class="text-center">
                                            <a href="consexperimento.php">
                                                <strong>Visualizar todos</strong>
                                                <i class="fa fa-angle-right"></i>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </li>

                        </ul>
                    </nav>
                </div>

            </div>
            <!-- /top navigation -->
<?php 
?>
