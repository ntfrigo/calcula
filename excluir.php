<?php

include_once("basedados.php");

if(isset($_POST['Submit_Excluir'])) 
{
    try {
        $id = $_POST['form_del_idmodelo'];

        $sql = "DELETE FROM modelos WHERE idmodelo=$id";
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