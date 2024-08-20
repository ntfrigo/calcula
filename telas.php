<?php
function CarregaTelaInserir() {

    echo '<!-- Modal Adicionar -->

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
                            <label class="form-check-label" for="prefixado_inserir">Taxa prefixada</label>
                        </div>

                        <div class="input-group input-group-sm mb-3" id="divpercent_cdi">
                            <span class="input-group-text" id="inputGroup-sizing-sm">% do CDI</span>
                            <input type="text" class="form-control" aria-describedby="inputGroup-sizing-sm"
                                name="form_ins_percent_cdi">
                        </div>

                        <div class="input-group input-group-sm mb-3" id="divtaxa_aa">
                            <span class="input-group-text" id="inputGroup-sizing-sm">Taxa a.a.</span>
                            <input type="text" class="form-control" aria-describedby="inputGroup-sizing-sm"
                                name="form_ins_taxa_aa">
                        </div>

                        <div class="input-group input-group-sm mb-3">
                            <input class="form-check-input me-2" type="checkbox" name="form_ins_isento_ir"
                                id="isento_ir" />
                            <label class="form-check-label" for="isento_ir">Isento IR</label>
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

    <!-- Modal Adicionar -->';
}

function CarregaTelaEditar($idmodelo, $is_prefixado, $status_ativo, $status_isento, $user_data) {

    echo '<!-- Modal Editar -->

    <div class="modal fade" id="telaModalEditar'.$idmodelo.'" tabindex="-1" role="dialog" aria-labelledby="telaModalEditarLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="telaModalEditarLabel">Editar</h5>
            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form method="post" action="editar.php" class="needs-validation" id="form_editar">
              
            <input class="form-control" value="'.$idmodelo.'"     id="form_edit_idmodelo"  name="form_edit_idmodelo"  type="hidden"> 										    
            <input class="form-control" value="'.$is_prefixado.'" id="form_edit_prefixado" name="form_edit_prefixado" type="hidden"> 	
                                                    
            <div class="input-group input-group-sm mb-3">
                <span class="input-group-text" id="inputGroup-sizing-sm">Descrição</span>
                <input type="text" class="form-control" aria-describedby="inputGroup-sizing-sm" name="form_edit_descricao" value="'.$user_data['descricao'].'" required autofocus>
                <div class="invalid-feedback">Informe a descrição.</div>
            </div>';

                if ($is_prefixado === true) 
                {
        echo '<div class="input-group input-group-sm mb-3" id="div_edit_taxa_aa">
        <span class="input-group-text" id="inputGroup-sizing-sm">Taxa a.a.</span>
        <input type="text" class="form-control" aria-describedby="inputGroup-sizing-sm" name="form_edit_taxa_aa" value='.$user_data['taxa_aa'].'>
        </div>';
                }
                else{
        echo '<div class="input-group input-group-sm mb-3" id="div_edit_percent_cdi">
        <span class="input-group-text" id="inputGroup-sizing-sm">% CDI</span>
        <input type="text" class="form-control" aria-describedby="inputGroup-sizing-sm" name="form_edit_percent_cdi" value='.$user_data['percent_cdi'].'>
        </div>';
                }

        echo '  <div class="input-group input-group-sm mb-3">
                    <input class="form-check-input me-2" type="checkbox" name="form_edit_isento_ir" id="form_edit_isento_ir" '.$status_isento.' />
                    <label class="form-check-label" for="form_edit_isento_ir">Isento IR</label>
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
}

function CarregaTelaExcluir($idmodelo, $descricao) {

    echo '<!-- Modal Excluir -->

    <div class="modal fade" id="telaModalExcluir'.$idmodelo.'" tabindex="-1" role="dialog" aria-labelledby="telaModalExcluirLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="telaModalExcluirLabel">Excluir</h5>
            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="Excluir.php" method="post" class="form-signin"  id="form_deletar">									      
                <input class="form-control" value="'.$idmodelo.'" id="form_del_idmodelo"  name="form_del_idmodelo"  type="hidden"> 	

                <h6 class="my-0 text-danger">Deseja realmente excluir a informação a seguir:</h6>
                <br>
                <h6 class="my-0">'.$descricao.', <br><br> Confirma?  <br> &nbsp;  </h6>

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


function CarregaItensLista($user_data, $valor_investir, $prazo_meses, $taxa_selic){
    $idmodelo = $user_data['idmodelo'];
    $retorno = CalcularRendimentos($user_data, $valor_investir, $prazo_meses, $taxa_selic);

    $is_prefixado = $retorno['is_prefixado'];
    $is_isento_ir = $retorno['is_isento_ir'];    
    $taxa_aa = $retorno['taxa_aa'];
    $percent_cdi = $retorno['percent_cdi'];
    $valor_futuro = $retorno['valor_futuro'];
    $taxa_aplicada = $retorno['taxa_aplicada'];
    $lucro_bruto = $retorno['lucro_bruto'];
    $valor_ir = $retorno['valor_ir'];
    $lucro_liquido = $retorno['lucro_liquido'];
    $total_liquido = $retorno['total_liquido'];
    $status_ativo = $retorno['status_ativo'];
    $status_isento = $retorno['status_isento'];

    echo "<tr>";
    echo "<td>".$user_data['descricao']."</td>";
    echo "<td>".$percent_cdi."</td>";
    
    echo "<td>".number_format((float)$taxa_aplicada, 2)."</td>";    
    echo "<td>".number_format((float)$valor_futuro, 2)."</td>";    
    echo "<td>".number_format((float)$lucro_bruto, 2)."</td>";    
    echo "<td>".number_format((float)$valor_ir, 2)."</td>";    
    echo "<td>".number_format((float)$lucro_liquido, 2)."</td>";    
    echo "<td>".number_format((float)$total_liquido, 2)."</td>"; 
    

    echo '<td>                
    <button class="btn btn-primary  btn-sm" data-toggle="modal" data-target="#telaModalEditar'.$idmodelo.'">Editar</button>		  			
    <button class="btn btn-danger  btn-sm" data-toggle="modal" data-target="#telaModalExcluir'.$idmodelo.'">Excluir</button>
    </td>';		

    echo "</tr>";   
    
    CarregaTelaEditar($idmodelo, $is_prefixado, $status_ativo, $status_isento, $user_data);

    CarregaTelaExcluir($idmodelo, $user_data['descricao']);	

}

function CarregaTelaEditarSelic($taxa_selic) {

    echo '<!-- Modal Editar Selic -->

    <div class="modal fade" id="telaModalEditarSelic" tabindex="-1" role="dialog" aria-labelledby="telaModalEditarSelicLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="telaModalEditarSelicLabel">Atualizar Taxa Selic</h5>
            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form method="post" action="atualizar.php" class="needs-validation" id="form_taxa_AtualizaSelic">
              
				<div class="input-group input-group-sm mb-3" id="div_edit_taxa_selic">
				<span class="input-group-text" id="inputGroup-sizing-sm">Taxa Selic</span>
				<input type="text" class="form-control" aria-describedby="inputGroup-sizing-sm" name="form_edit_taxa_selic" value="'.$taxa_selic.'">
				</div>
				
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancelar</button>
                <button class="btn btn-lg btn-success btn-block btn-sm" type="submit" name="Submit_AtualizaSelic">Salvar</button>
            </div>

            </form>
          </div>
        </div>
      </div>
    </div>	

    <!-- Modal Editar Selic -->';	
}



?>