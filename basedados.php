<?php
$databaseHost = 'localhost';
$databaseName = 'invest';
$databaseUsername = 'root';
$databasePassword = '';
$mysqli = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName);

$consulta_modelos_ativos = mysqli_query($mysqli, "SELECT * FROM invest.modelos where ativo = 'S'");


function consulta_taxa_selic($mysqli) {
    
    $retorno = mysqli_query($mysqli, "SELECT taxa FROM invest.selic");
    $row = mysqli_fetch_assoc($retorno);
    return $row['taxa'];
}

?>
