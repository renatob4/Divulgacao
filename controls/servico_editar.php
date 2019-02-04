<?php
    //verificar a sessão.
    if(!isset($_SESSION['a'])){
        exit();
    }

    //Instancia do banco de dados.
    $acesso = new cl_gestorBD();
    $data = new DateTime();
    $config = $acesso->EXE_QUERY('SELECT * FROM tab_config');

    if($config[0]['st_product'] == 0){
        //header("Location:?a=home");
        echo('<meta http-equiv="refresh" content="0;URL=?a=servicos">');
        exit();
    }
    if(!isset($_GET['s'])){
        //header("Location:?a=home");
        echo('<meta http-equiv="refresh" content="0;URL=?a=servicos">');
        exit();
    }

    //Pega o codigo do produto na URL
    $cd_servico = $_GET['s'];
    $mensagem = '';

    //pesquisa se existe produto com esse codigo na base
    $parametros = [
        ':cd_service'   =>  $cd_servico
    ];
    $servicos = $acesso->EXE_QUERY('SELECT * FROM tab_service WHERE cd_service = :cd_service', $parametros);

    //Se não existir card de mesmo codigo na base ele encerra.
    if(count($servicos) == 0){
        echo('<meta http-equiv="refresh" content="0;URL=?a=servicos">');
        exit();
    }

    //Veficica se ocorreu um POST
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $edit_cd_s  =  strtoupper($_POST['edit_cd_s']);
        $edit_nm_s  =  strtoupper($_POST['edit_nm_s']);
        $edit_vl_s  =  $_POST['edit_vl_s'];
        $edit_desc_s  =  $_POST['edit_desc_s'];
        $edit_radio_s  =  $_POST['edit_radio_s'];

        //Atualizar os dados no produto no banco
        $parametros = [
            ':cd_service'               =>  $servicos[0]['cd_service'],
            ':cd_alternative_service'   =>  $edit_cd_s,
            ':nm_service'               =>  $edit_nm_s,
            ':vl_service'               =>  $edit_vl_s,
            ':ds_description'           =>  $edit_desc_s,
            ':st_promotion'             =>  $edit_radio_s,
            ':dt_updated'               =>  $data->format('Y-m-d H:i:s')
        ];
        //Atualizar a DB
        $acesso->EXE_NON_QUERY('UPDATE tab_service 
                                SET cd_alternative_service = :cd_alternative_service, 
                                nm_service = :nm_service, 
                                vl_service = :vl_service, 
                                ds_description = :ds_description,
                                st_promotion = :st_promotion, 
                                dt_updated = :dt_updated 
                                WHERE cd_service = :cd_service', $parametros);

        $mensagem = "Serviço ".$servicos[0]['cd_alternative_service']." editado com sucesso!";

        //Log
        funcoes::CriarLOG(''.$mensagem , $_SESSION['nm_user']);
    
        //Redirecionar
        //header("Location:?a=home");
        echo('<meta http-equiv="refresh" content="0;URL=?a=servico_editar&s='.$servicos[0]['cd_service'].'">');
        exit();
    }
?>
<div class="row mr-1 ml-1 mt-2">
    <div class="col p-0">
        <div class="card p-3 borda-painel shadow-strong">
            <h5 id="green" class="text-center mt-2 mb-3">EDITE AS INFORMAÇÕES DO SERVIÇO ABAIXO</h5>
            <!-- Card do serviço -->
            <div class="<?php echo $servicos[0]['st_promotion'] == 1 ? 'card borda-produto-p mb-3' : 'card borda-produto mb-3';?>">
                <div class="row m-0">
                    <div class="col-md-9 m-0">
                        <div class="row p-0">
                            <div class="col-md-2 p-2 prbdiv prrdiv-non text-center">
                                <label class="service-img text-center m-0"><i id="grey" class="fas fa-wrench mr-1"></i></label>
                            </div>
                            <div class="col-md-10 prbdiv text-center">
                                <h5><label id="blue" class="mr-2 mt-3"><i class="fas fa-barcode mr-1"></i><?php echo $servicos[0]['cd_alternative_service'];?></label><?php echo $servicos[0]['nm_service'];?></h5>
                                <?php if($servicos[0]['st_promotion'] == 1):?>
                                <i id="gold" class="fas fa-star mr-2 star-s"></i>
                                <?php endif;?>
                            </div>
                        </div>
                        <div class="row p-3">
                            <p class="mb-1" id="black"><?php echo nl2br($servicos[0]['ds_description']);?></p>
                        </div>
                    </div>
                    <div class="col-md-3 card p-2 min-hgt text-center">
                        <label id="black" class="Obs3 price mr-1 mb-0"><strong>R$ <?php echo number_format($servicos[0]['vl_service'],2, ',', '.');?></strong></label>
                        <a href="?a=contatos" class="btn btn-primary mt-2 ml-2 mr-2 p-3">Interessado?</a>
                        <label class="Obs3 mt-2">Fale conosco para contratar.</label>
                        <?php if($servicos[0]['st_promotion'] == 1):?>
                        <p id="green" class="pmtn m-0 p-0"><b>Promoção!</b></p>
                        <?php endif;?>  
                        <?php if(funcoes::VerificarLogin()):?>
                        <hr class="mb-2 mt-2">
                        <div class="card line text-center mt-2 brt">
                            <div class="row p-0 m-0">
                                <div class="col text-center">
                                    <div class="mt-2 mb-2">
                                        <a id="black" href="?a=servico_editar&s=<?php echo $servicos[0]['cd_service'];?>" class="mr-2"><i id="grey" class="fas fa-edit mr-1"></i><b>Editar</b></a>|<a id="black" href="?a=servico_deletar&s=<?php echo $servicos[0]['cd_service'];?>" class="ml-2"><i id="grey" class="fas fa-trash mr-1"></i><b>Apagar</b></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row shadow-strong mt-4 ml-1 mr-1">
    <div class="col p-0">
        <div class="card painel-direito p-0 pl-3 pr-3">
            <h5 id="white" class="mt-3">INFORMAÇÕES DO SERVIÇO</h5><hr class="mb-1 mt-1">
            <form action="?a=servico_editar&s=<?php echo $servicos[0]['cd_service'];?>" method="POST">
            <div class="text-left">
                    <div class="form-row mt-2">
                        <div class="col">
                            <label id="black"><b><i id="black" class="fas fa-barcode mr-2"></i>Código:</b></label>
                            <input type="text" name="edit_cd_s" class="form-control shadow" maxlength="12" value="<?php echo $servicos[0]['cd_alternative_service'];?>" title="Defina um código para o serviço" required>
                        </div>
                        <div class="col">
                            <label id="black"><b>Serviço:</b></label>
                            <input type="text" name="edit_nm_s" class="form-control shadow" maxlength="32" value="<?php echo $servicos[0]['nm_service'];?>" required>
                        </div>
                        <div class="col">
                            <label id="black"><i id="black" class="fas fa-money-bill-alt ml-1 mr-2"></i><b>Preço/Valor:</b></label>
                            <div class="input-group">
                            <div class="input-group-prepend ml-1"><div class="input-group-text shadow"><strong>R$</strong></div></div>
                            <input type="number" value="<?php echo $servicos[0]['vl_service']*1;?>" pattern="[0-9]+([,\.][0-9]+)?" min="0" step="any" name="edit_vl_s" class="form-control shadow" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-goup mt-3">
                        <label id="black"><i id="black" class="fas fa-info-circle mr-2"></i><b>Descrição:</b></label>
                        <textarea type="text" name="edit_desc_s" class="form-control shadow" rows="7" title="Informações do serviço" required><?php echo $servicos[0]['ds_description'];?></textarea>
                    </div>
                    <div class="form-row mt-3 p-0">
                        <div class="col">
                            <div class="form-inline">
                                <label id="black" class="Obs3 ml-1 mr-3"><b>Este serviço esta em promoção?</b></label>
                                <label id="black" class="radio-inline mr-3"><input type="radio" name="edit_radio_s" value=1 <?php echo $servicos[0]['st_promotion'] == 1 ? 'checked' : '';?>>Sim</label>
                                <label id="black" class="radio-inline"><input type="radio" name="edit_radio_s" value=0  <?php echo $servicos[0]['st_promotion'] == 0 ? 'checked' : '';?>>Não</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="text-right mb-3">
                                <a href="?a=servicos" class="btn btn-primary shadow mr-2">Voltar</a>
                                <a href="?a=servico_deletar&s=<?php echo $servicos[0]['cd_service'];?>" class="btn btn-danger shadow mb-0 mr-2">Apagar</a>
                                <button class="btn btn-success shadow">Atualizar Serviço</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>