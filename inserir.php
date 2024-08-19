<?php 
include_once("basedados.php");

session_start();
$_SESSION["mostraAlerta"]=null;
$_SESSION["mensagemAlerta"]=null;

if(isset($_POST['Submit_Inserir'])) 
{
    try {
        $descricao = $_POST['form_ins_descricao'];

        $percent_cdi = floatval($_POST['form_ins_percent_cdi']);
        $taxa_aa = floatval($_POST['form_ins_taxa_aa']);

        if(isset($_POST['form_ins_prefixado']))
        { 
            $prefixado = "S";
            $percent_cdi = 0;
        } else {
            $prefixado = "N";
            $taxa_aa = 0;
        }

        $isento_ir = isset($_POST['form_ins_isento_ir']) ? "S" : "N";
        
        $sql = "INSERT INTO modelos (descricao, percent_cdi, taxa_aa, prefixado, ativo, isento_ir) VALUES ('$descricao', $percent_cdi, $taxa_aa, '$prefixado', 'S', '$isento_ir')";
        $result = mysqli_query($mysqli, $sql );

        $_SESSION["mostraAlerta"] = "success";
        $_SESSION["mensagemAlerta"] = "Registro salvo com sucesso!";   

    } catch (Exception $e) {
        $_SESSION["mostraAlerta"] = "error";
        $_SESSION["mensagemAlerta"] = $e->getMessage();
    }
    
    header("Location: /");
}

?>