<?php
include_once("basedados.php");

session_start();
$_SESSION["mostraAlerta"]=null;
$_SESSION["mensagemAlerta"]=null;

if(isset($_POST['Submit_AtualizaSelic'])) 
{
    try {
        $taxa = floatval($_POST['form_edit_taxa_selic']);       
        $sql = "UPDATE invest.selic SET taxa=$taxa";
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