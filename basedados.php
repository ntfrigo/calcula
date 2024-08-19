<?php
$databaseHost = 'localhost';
$databaseName = 'invest';
$databaseUsername = 'root';
$databasePassword = '';
$mysqli = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName);

$consulta_modelos_ativos = mysqli_query($mysqli, "SELECT * FROM invest.modelos where ativo = 'S'");

?>
