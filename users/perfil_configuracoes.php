<?php

   // ==========================================================
   // PERFIL - MENU INICIAL
   // PERMISSAO NECESSARIA INDICE = 0
   // ==========================================================

    //verificar a sessão.
    if(!isset($_SESSION['a'])){
        exit();
    }

    $erro = false;
    $mensagem = '';

    //Verifica se utilizador tem permissão
    if(!funcoes::Permissao(1)){
        $erro = true;
        $mensagem = 'Não a tem permissão necessaria para acessar essa funcionalidade';
    }

    //Vai buscar todas as informações do utilizador
    $gestor = new cl_gestorBD();
    $parametros = [
        ':cd_login'    =>  $_SESSION['cd_login']
    ];

    $dados = $gestor->EXE_QUERY(
        'SELECT * FROM tab_user 
         WHERE cd_login = :cd_login', $parametros);

?>

<?php if($erro) :?>

    <div class="text-center m-3">
        <h3><?php echo $mensagem ?></h3>
        <a href="?a=home" class="btn btn-primary btn-size-150">Voltar</a>
    </div>

<?php else : ?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col card m-3 p-3">
                <h4 class="text-center">PERFIL DE UTILIZADOR</h4>
                <!--DADOS DO UTILIZADOR-->
                <h5 class="mb-5 mt-3"><i class="fa fa-user mr-1" aria-hidden="true"></i><?php echo $dados[0]['nm_user'] ?></h5>
                <h5 class="mb-3"><i class="far fa-id-badge mr-1" aria-hidden="true"></i>Login:  <label id="grey"><?php echo $dados[0]['cd_login']?></label><a href="?a=perfil_alterar_login" class="btn btn-outline-success m-0 ml-3"><i class="fas fa-edit"></i></a></h5>
                <h5 class="mb-3"><i class="fa fa-key mr-1" aria-hidden="true"></i>Senha:  <label id="grey"><?php echo str_repeat("*", 6)?></label><a href="?a=perfil_alterar_senha" class="btn btn-outline-success m-0 ml-3"><i class="fas fa-edit"></i></a></h5>  
                <h5 class="mb-3"><i class="fa fa-envelope mr-1" aria-hidden="true"></i>Email:  <label id="grey"><?php echo $dados[0]['ds_email']?></label><a href="?a=perfil_alterar_email" class="btn btn-outline-success m-0 ml-3"><i class="fas fa-edit"></i></a></h5>
                <!--DADOS DO CONTEÚDO DO SITE-->
                <hr><h4 class="text-center">GERENCIAR CONTEÚDO DO SITE</h4>
                 <!--Voltar--> 
                <div class="text-center">
                    <hr><a href="?a=home" class="btn btn-primary btn-size-150 m-2">Voltar</a>
                </div>
            </div>  
        </div>
    </div>

<?php endif;?>