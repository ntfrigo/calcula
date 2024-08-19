<?php
	include_once("basedados.php");
	include("telas.php");
	include("calculos.php");

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
                                    $taxa_selic = 10.50;
                                    while($user_data = mysqli_fetch_array($consulta_modelos_ativos))
                                    {
                                        CarregaItensLista($user_data, $valor_investir, $prazo_meses, $taxa_selic);                                        
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

    <?php CarregaTelaInserir(); ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="http://code.jquery.com/jquery-3.3.1.min.js"></script>
    <!--script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script-->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="http://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
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