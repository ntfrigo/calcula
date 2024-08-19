<?php
function CalcularRendimentos($user_data, $valor_investir, $prazo_meses, $taxa_selic) {
    $retorno = array();

    $is_prefixado = $user_data['prefixado'] == "S";
    $is_isento_ir = $user_data['isento_ir'] == "S";
    
    $taxa_aa = number_format((float)$user_data['taxa_aa'], 2);
    $percent_cdi = number_format((float)$user_data['percent_cdi'], 2);

    $taxa_aplicada = CalcularTaxaAplicada($is_prefixado, $taxa_aa, $percent_cdi, $taxa_selic);          

    $prazo_anos = $prazo_meses / 12;
    $prazo_dias = $prazo_meses * 30;
    
    $valor_futuro = $valor_investir * pow((1+($taxa_aplicada / 100)), $prazo_anos);
    $lucro_bruto = $valor_futuro - $valor_investir;
    $taxa_ir = CalcularIR($prazo_dias, $is_isento_ir);
    
    $valor_ir = $lucro_bruto * ($taxa_ir / 100);
    $lucro_liquido = $lucro_bruto - $valor_ir;
    $total_liquido = $valor_investir + $lucro_liquido;

    $retorno['is_prefixado'] = $is_prefixado;
    $retorno['is_isento_ir'] = $is_isento_ir;    
    $retorno['taxa_aa'] = $taxa_aa;
    $retorno['percent_cdi'] = ($is_prefixado === true ? "" : $percent_cdi."%");    
    $retorno['valor_futuro'] = $valor_futuro;
    $retorno['taxa_aplicada'] = $taxa_aplicada;
    $retorno['lucro_bruto'] = $lucro_bruto;    
    $retorno['valor_ir'] = $valor_ir;
    $retorno['lucro_liquido'] = $lucro_liquido;
    $retorno['total_liquido'] = $total_liquido;
    $retorno['status_ativo'] = $user_data['ativo'] === "S" ? "checked":"";
    $retorno['status_isento'] = $user_data['isento_ir'] === "S" ? "checked":"";

    return $retorno;
}

function CalcularTaxaAplicada($is_prefixado, $taxa_aa, $percent_cdi, $taxa_selic) {

    if($is_prefixado === true){
        return $taxa_aa;
    }else{
        return ($percent_cdi * $taxa_selic) / 100;
    }    
}
function CalcularIR($prazo_dias, $is_isento_ir) {

    if ($is_isento_ir === true) {
        return 0;
    }

    if ($prazo_dias <= 180) {
        return 22.5;
    } elseif ($prazo_dias <= 360) {
        return 20.0;
    } elseif ($prazo_dias <= 720) {
        return 17.5;
    } else {
        return 15.0;
    }    
}

?>