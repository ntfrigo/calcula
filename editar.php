<?php
include_once("basedados.php");

session_start();
$_SESSION["mostraAlerta"]=null;
$_SESSION["mensagemAlerta"]=null;

if(isset($_POST['Submit_Editar'])) 
{
    try {
        $id = $_POST['form_edit_idmodelo'];
        $descricao = $_POST['form_edit_descricao'];
        $isento_ir = isset($_POST['form_edit_isento_ir']) ? "S" : "N";
        $ativo = isset($_POST['form_edit_ativo']) ? "S" : "N";

        $campoVisivel = "";
        if($_POST['form_edit_prefixado'] == 1)
        { 
            $taxa_aa = floatval($_POST['form_edit_taxa_aa']);
            $campoVisivel = "taxa_aa=$taxa_aa";
        } else {
            $percent_cdi = floatval($_POST['form_edit_percent_cdi']);
            $campoVisivel = "percent_cdi=$percent_cdi";
        }
       
        $sql = "UPDATE invest.modelos SET descricao='$descricao',$campoVisivel,ativo='$ativo',isento_ir='$isento_ir' WHERE idmodelo=$id";
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