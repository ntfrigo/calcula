<?php
	include_once("basedados.php");

    session_start();

    $botao_calcular = false;

	if(isset($_POST['botao_calcular'])) 
    {
        $valor_investir = $_POST['valor_investir'];
        $prazo_meses = $_POST['prazo_meses'];
        unset($_POST['botao_calcular']);
        $botao_calcular = true;
	}
	else
	{
		$valor_investir = 0;
		$prazo_meses = 0;			
	}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Calcular investimentos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
    <link href="dashboard.css" rel="stylesheet">
</head>

<body>

    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 shadow" href="#">
        Calculadora
        </a>
       
        <div class="d-flex align-items-center">
          <a class="link-light me-3" href="#" data-toggle="modal" data-target="#telaModalInserir">
            <i class="fas fa-plus-circle fa-lg"></i>
          </a>
          <a class="link-light me-3" href="#">
          <i class="fas fa-comments-dollar fa-lg"></i>
          </a>
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            <main class="col-md-12 ms-sm-auto col-lg-12 px-md-4">
                <br>
                <div class="row g-5">
                    <div class="col-md-5 col-lg-4 order-md-last">
                        <h4 class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-primary">Dados informados</span>
                        </h4>
                        <ul class="list-group mb-3">
                            <li class="list-group-item d-flex justify-content-between lh-sm">
                                <div>
                                    <h6 class="my-0">Taxa CDI</h6>
                                </div>
                                <span class="text-muted">10,50</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between lh-sm">
                                <div>
                                    <h6 class="my-0">Prazo em meses</h6>
                                </div>
                                <span class="text-muted"><?php echo $prazo_meses ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Valor informado</span>
                                <strong><?php echo "R$ ".number_format((float)$valor_investir, 2) ?></strong>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-7 col-lg-8">
                        <h4 class="mb-3">Informe o valor:</h4>
                        <form class="needs-validation" novalidate action="index.php" method="POST">

                            <div class="row g-3">
                                <div class="col-sm-6">
                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Valor:</span>
                                        <input type="text" class="form-control" aria-label="Sizing example input"
                                            aria-describedby="inputGroup-sizing-sm" name="valor_investir"
                                            id="valor_investir" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="input-group input-group-sm mb-3">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">Prazo:</span>
                                        <input type="text" class="form-control" aria-label="Sizing example input"
                                            aria-describedby="inputGroup-sizing-sm" name="prazo_meses" id="prazo_meses"
                                            required>
                                    </div>
                                </div>
                            </div>
                            <button class="w-100 btn btn-primary btn-lg btn-sm" type="submit"
                                name="botao_calcular">Calcular</button>
                        </form>
                    </div>
                </div>

                <br>

                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th scope="col">Descricao</th>
                                <th scope="col">% CDI</th>
                                <th scope="col">Taxa a.a.</th>
                                <th scope="col">Valor bruto</th>
                                <th scope="col">Lucro bruto</th>
                                <th scope="col">Desconto IR</th>
                                <th scope="col">Lucro liquido</th>
                                <th scope="col">Total liquido</th>
                                <th scope="col">Ação</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php  
          
          if($botao_calcular === true) 
          {
              $result = mysqli_query($mysqli, "SELECT * FROM invest.modelos where ativo = 'S'");
    
              while($user_data = mysqli_fetch_array($result)) 
              {         
                $is_prefixado = $user_data['prefixado'] == "S";
                $is_isento_ir = $user_data['isento_ir'] == "S";
                
                $taxa_aplicada = 0;
                $percent_tot = 10.50;
                $taxa_aa = number_format((float)$user_data['taxa_aa'], 2);
                $percent_cdi = number_format((float)$user_data['percent_cdi'], 2);

                if($is_prefixado === true){
                    $taxa_aplicada = $taxa_aa;
                }else{
                    $taxa_aplicada = ($percent_cdi * $percent_tot) / 100;
                }                

                $prazo_anos = $prazo_meses / 12;
                $prazo_dias = $prazo_meses * 30;
                
                $valor_futuro = $valor_investir * pow((1+($taxa_aplicada/100)),$prazo_anos);
                $lucro_bruto = $valor_futuro - $valor_investir;
                $taxa_ir = 22.5;
                
                if ($prazo_dias <= 180) {
                    $taxa_ir = 22.5;
                } elseif ($prazo_dias <= 360) {
                    $taxa_ir = 20.0;
                } elseif ($prazo_dias <= 720) {
                    $taxa_ir = 17.5;
                } else {
                    $taxa_ir = 15.0;
                }
                
                if ($is_isento_ir === true) {
                    $taxa_ir = 0;
                }


                $valor_ir = $lucro_bruto * ($taxa_ir / 100);
                $lucro_liquido = $lucro_bruto - $valor_ir;
                $total_liquido = $valor_investir + $lucro_liquido;


                $status_ativo = $user_data['ativo'] === "S" ? "checked":"";
                $status_isento = $user_data['isento_ir'] === "S" ? "checked":"";

                    
                echo "<tr>";
                echo "<td>".$user_data['descricao']."</td>";
                echo "<td>".($is_prefixado === true ? "" : $user_data['percent_cdi']."%")."</td>";
                
                echo "<td>".number_format((float)$taxa_aplicada, 2)."</td>";    
                echo "<td>".number_format((float)$valor_futuro, 2)."</td>";    
                echo "<td>".number_format((float)$lucro_bruto, 2)."</td>";    
                echo "<td>".number_format((float)$valor_ir, 2)."</td>";    
                echo "<td>".number_format((float)$lucro_liquido, 2)."</td>";    
                echo "<td>".number_format((float)$total_liquido, 2)."</td>"; 
                

			  				echo '<td>                
                <button class="btn btn-primary  btn-sm" data-toggle="modal" data-target="#telaModalEditar'.$user_data['idmodelo'].'">Editar</button>		  			
                <button class="btn btn-danger  btn-sm" data-toggle="modal" data-target="#telaModalExcluir'.$user_data['idmodelo'].'">Excluir</button>
                </td>';		

                echo "</tr>";   
                
                echo '<!-- Modal Editar -->

								<div class="modal fade" id="telaModalEditar'.$user_data['idmodelo'].'" tabindex="-1" role="dialog" aria-labelledby="telaModalEditarLabel" aria-hidden="true">
								  <div class="modal-dialog" role="document">
								    <div class="modal-content">
								      <div class="modal-header">
								        <h5 class="modal-title" id="telaModalEditarLabel">Editar</h5>
								        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
								      </div>
								      <div class="modal-body">
									    <form method="post" action="editar.php" class="needs-validation" id="form_editar">
									      
                                        <input class="form-control" value="'.$user_data['idmodelo'].'" id="form_edit_idmodelo"  name="form_edit_idmodelo"  type="hidden"> 										    
                                        <input class="form-control" value="'.$is_prefixado.'"          id="form_edit_prefixado" name="form_edit_prefixado" type="hidden"> 	
                                                                                
                                        <div class="input-group input-group-sm mb-3">
                                            <span class="input-group-text" id="inputGroup-sizing-sm">Descrição</span>
                                            <input type="text" class="form-control" aria-describedby="inputGroup-sizing-sm" name="form_edit_descricao" value="'.$user_data['descricao'].'" required autofocus>
                                            <div class="invalid-feedback">Informe a descrição.</div>
                                        </div>';

                                            if ($is_prefixado === true) 
                                            {
                                    echo '<div class="input-group input-group-sm mb-3" id="div_edit_taxa_aa">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">taxa_aa</span>
                                    <input type="text" class="form-control" aria-describedby="inputGroup-sizing-sm" name="form_edit_taxa_aa" value='.$taxa_aa.'>
                                    </div>';
                                            }
                                            else{
                                    echo '<div class="input-group input-group-sm mb-3" id="div_edit_percent_cdi">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">percent_cdi</span>
                                    <input type="text" class="form-control" aria-describedby="inputGroup-sizing-sm" name="form_edit_percent_cdi" value='.$percent_cdi.'>
                                    </div>';
                                            }

                                    echo '  <div class="input-group input-group-sm mb-3">
                                                <input class="form-check-input me-2" type="checkbox" name="form_edit_isento_ir" id="form_edit_isento_ir" '.$status_isento.' />
                                                <label class="form-check-label" for="form_edit_isento_ir">isento ir</label>
                                            </div>

                                            
                                            <div class="input-group input-group-sm mb-3">
                                                <input class="form-check-input me-2" type="checkbox" name="form_edit_ativo" id="form_edit_ativo" '.$status_ativo.' />
                                                <label class="form-check-label" for="form_edit_ativo">Ativo</label>
                                            </div>





                                            <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancelar</button>
                                            <button class="btn btn-lg btn-success btn-block btn-sm" type="submit" name="Submit_Editar">Salvar</button>
                                        </div>

                                        </form>
								      </div>
								    </div>
								  </div>
								</div>	

								<!-- Modal Editar -->';		  

                echo '<!-- Modal Excluir -->

								<div class="modal fade" id="telaModalExcluir'.$user_data['idmodelo'].'" tabindex="-1" role="dialog" aria-labelledby="telaModalExcluirLabel" aria-hidden="true">
								  <div class="modal-dialog" role="document">
								    <div class="modal-content">
								      <div class="modal-header">
								        <h5 class="modal-title" id="telaModalExcluirLabel">Excluir</h5>
								        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
								      </div>
								      <div class="modal-body">
									    <form action="Excluir.php" method="post" class="form-signin"  id="form_deletar">									      
                                        <input class="form-control" value="'.$user_data['idmodelo'].'" id="form_del_idmodelo"  name="form_del_idmodelo"  type="hidden"> 	

								        <h5 class="modal-title" id="telaModalExcluirLabel">Deseja realmente excluir a informação selecionada?</h5>

                                            <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancelar</button>
                                            <button class="btn btn-lg btn-success btn-block btn-sm" type="submit"  name="Submit_Excluir">Confirmar</button>
                                        </div>

                                        </form>
								      </div>
								    </div>
								  </div>
								</div>	

								<!-- Modal Excluir -->';	


              }
              $botao_calcular = false;
            }
          ?>

                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>


    <!-- Modal Adicionar -->

    <div class="modal fade" id="telaModalInserir" tabindex="-1" role="dialog" aria-labelledby="telaModalInserirLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="telaModalInserirLabel">Novo</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="inserir.php" class="needs-validation" id="form_inserir">

                        <div class="input-group input-group-sm mb-3">
                            <span class="input-group-text" id="inputGroup-sizing-sm">Descrição</span>
                            <input type="text" class="form-control" aria-describedby="inputGroup-sizing-sm"
                                name="form_ins_descricao" required autofocus>
                            <div class="invalid-feedback">Informe a descrição.</div>
                        </div>

                        <div class="input-group input-group-sm mb-3">
                            <input class="form-check-input me-2" type="checkbox" id="prefixado_inserir"
                                name="form_ins_prefixado" />
                            <label class="form-check-label" for="prefixado_inserir">prefixado</label>
                        </div>

                        <div class="input-group input-group-sm mb-3" id="divpercent_cdi">
                            <span class="input-group-text" id="inputGroup-sizing-sm">percent_cdi</span>
                            <input type="text" class="form-control" aria-describedby="inputGroup-sizing-sm"
                                name="form_ins_percent_cdi">
                        </div>

                        <div class="input-group input-group-sm mb-3" id="divtaxa_aa">
                            <span class="input-group-text" id="inputGroup-sizing-sm">taxa_aa</span>
                            <input type="text" class="form-control" aria-describedby="inputGroup-sizing-sm"
                                name="form_ins_taxa_aa">
                        </div>

                        <div class="input-group input-group-sm mb-3">
                            <input class="form-check-input me-2" type="checkbox" name="form_ins_isento_ir"
                                id="isento_ir" />
                            <label class="form-check-label" for="isento_ir">isento ir</label>
                        </div>


                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary btn-sm"
                                data-dismiss="modal">Cancelar</button>
                            <button class="btn btn-lg btn-success btn-block btn-sm" type="submit"
                                name="Submit_Inserir">Salvar</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Adicionar -->




    <script src="http://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="http://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="dashboard.js"></script>


<?php
    if(isset($_SESSION["mostraAlerta"]) && $_SESSION["mostraAlerta"] != null)
    {
        echo '<script type="text/javascript">
        fireNotif("'.$_SESSION["mensagemAlerta"].'", "'.$_SESSION["mostraAlerta"].'", 5000); 
        </script>';    

        $_SESSION["mostraAlerta"]=null;
        $_SESSION["mensagemAlerta"]=null;
    }
?>
</body>

</html>