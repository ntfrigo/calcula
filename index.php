<?php
	include_once("basedados.php");
	
	if(isset($_POST['botao_calcular'])) 
  {
    $valor_investir = $_POST['valor_investir'];
    $prazo_meses = $_POST['prazo_meses'];
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
    <link href="dashboard.css" rel="stylesheet">
    
	<script src="http://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script src="http://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	<script src="http://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>    

  </head>
  <body>
    
<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">Company name</a>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <!--input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search"-->
  <div class="navbar-nav">
    <div class="nav-item text-nowrap">
      <a class="nav-link px-3" href="#">Sign out</a>
    </div>
  </div>
</header>

<div class="container-fluid">
  <div class="row">
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="position-sticky pt-3">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">
              <span data-feather="home"></span>
              Menu
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#" data-toggle="modal" data-target="#telaModalInserir">
              <span data-feather="file"></span>
              Cadastro
            </a>
          </li>         
        </ul>

   </div>
    </nav>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
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
                    <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" name="valor_investir"  id="valor_investir" required>
                </div>
            </div>
            <div class="col-sm-6">
                  <div class="input-group input-group-sm mb-3">
                      <span class="input-group-text" id="inputGroup-sizing-sm">Prazo:</span>
                      <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-sm" name="prazo_meses"  id="prazo_meses" required>
                  </div>
            </div>
          </div>
          <button class="w-100 btn btn-primary btn-lg btn-sm" type="submit" name="botao_calcular">Calcular</button>
        </form>
      </div>
    </div>

    <br>

      <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">Descricao</th>
              <th scope="col">%</th>
              <th scope="col">Pre</th>
              <th scope="col">Ativo</th>
              <th scope="col">%%</th>
              <th scope="col">Futuro</th>
              <th scope="col">Bruto</th>
              <th scope="col">IR</th>
              <th scope="col">Liquido</th>
              <th scope="col">Total</th>
              <th scope="col">btn</th>
            </tr>
          </thead>
          <tbody>
		  
		      <?php  
          
          
          if(isset($_POST['botao_calcular'])) 
          {
              $result = mysqli_query($mysqli, "SELECT * FROM invest.modelos");
    
              while($user_data = mysqli_fetch_array($result)) 
              {         
                $prazo_anos = $prazo_meses/12;
                $prazo_dias = $prazo_meses*30;
                $percent_tot = 10.50;
                $valor_futuro = ($valor_investir)*pow((1+($percent_tot/100)),$prazo_anos);
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
                
                $valor_ir = $lucro_bruto * ($taxa_ir / 100);
                $lucro_liquido = $lucro_bruto - $valor_ir;
                $total_liquido = $valor_investir + $lucro_liquido;

                    //unset($strResult, $vp, $i, $n);
                    
                echo "<tr>";
                echo "<td>".$user_data['descricao']."</td>";
                echo "<td>".$user_data['percent_cdi']."</td>";
                echo "<td>".number_format((float)$user_data['prefixado'], 2)."</td>";    
                echo "<td>".$user_data['ativo']."</td>";    
                
                echo "<td>".number_format((float)$percent_tot, 2)."</td>";    
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
									    <form action="editar.php" method="post" class="form-signin">
									      <input id="id" class="form-control" value="'.$user_data['idmodelo'].'" name="id" type="hidden"> 									    
									      <input type="text" class="form-control" placeholder="nome" name="nome" value="'.$user_data['descricao'].'" required autofocus>    
									      <input type="email" class="form-control" placeholder="e-mail" name="email" value="'.$user_data['percent_cdi'].'" required>

                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancelar</button>
                        <button class="btn btn-lg btn-primary btn-block btn-sm" type="submit">Salvar</button>
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
									    <form action="Excluir.php" method="post" class="form-signin">
								        <h5 class="modal-title" id="telaModalExcluirLabel">Deseja realmente excluir a informação selecionada?</h5>
									      <input id="id" class="form-control" value="'.$user_data['idmodelo'].'" name="id" type="hidden"> 									    

                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancelar</button>
                        <button class="btn btn-lg btn-primary btn-block btn-sm" type="submit">Confirmar</button>
                      </div>

                      </form>
								      </div>
								    </div>
								  </div>
								</div>	

								<!-- Modal Excluir -->';	


              }

            }
          ?>
		  		  
          </tbody>
        </table>
      </div>
    </main>
  </div>
</div>


	<!-- Modal Adicionar -->

	<div class="modal fade" id="telaModalInserir" tabindex="-1" role="dialog" aria-labelledby="telaModalInserirLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="telaModalInserirLabel">Novo</h5>
	        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
	      </div>
	      <div class="modal-body">	      	
			<form method="post" action="inserir.php" class="needs-validation">


       <div class="input-group input-group-sm mb-3">
          <span class="input-group-text" id="inputGroup-sizing-sm">Descrição</span>
          <input type="text" class="form-control" aria-describedby="inputGroup-sizing-sm" name="descricao" required autofocus>
          <div class="invalid-feedback">Informe a descrição.</div>
        </div>

<div class="input-group input-group-sm mb-3">
  <span class="input-group-text" id="inputGroup-sizing-sm">percent_cdi</span>
  <input type="text" class="form-control" aria-describedby="inputGroup-sizing-sm" name="percent_cdi" required>
</div>

<div class="input-group input-group-sm mb-3">
  <span class="input-group-text" id="inputGroup-sizing-sm">prefixado</span>
  <input type="text" class="form-control" aria-describedby="inputGroup-sizing-sm" name="prefixado" required>
</div>


<div class="input-group input-group-sm mb-3">
  <span class="input-group-text" id="inputGroup-sizing-sm">ativo</span>
  <input type="text" class="form-control" aria-describedby="inputGroup-sizing-sm" name="ativo" required>
</div>

        <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancelar</button>
				<button class="btn btn-lg btn-primary btn-block btn-sm" type="submit">Salvar</button>
      </div>

			</form>
	      </div>
	    </div>
	  </div>
	</div>

	<!-- Modal Adicionar -->		



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="dashboard.js"></script>

  </body>
</html>
