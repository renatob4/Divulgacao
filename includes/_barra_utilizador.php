<?php
    // ==========================================================
    // Barra do utilizador
    // ==========================================================
    //verificar a sessão.
    if(!isset($_SESSION['a'])){
        exit();
    }
    $classe = 'barra_utilizador_inativo';
    //vefifica se existe login ativo
    if(funcoes::VerificarLogin()){
        $nome_utilizador = $_SESSION['nm_user'];
        $classe = 'barra_utilizador_ativo';
    }
    //Instancia do banco de dados.
    $acesso = new cl_gestorBD();
    $prospects = $acesso->EXE_QUERY('SELECT * FROM tab_prospect');
?>
<div class="barra_utilizador fixed-to p-2">
    <?php if(funcoes::VerificarLogin()):?>
    <div class="dropdown">
        <span class="mr-3"><i id="green" class="fa fa-user mr-3"></i><?php echo $nome_utilizador;?></span>
        <button class="btn btn-secondary dropdown-toggle mr-1" type="button" id="d1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cog"></i></button>
        <div class="dropdown-menu" aria-labelledby="d1">
            <div class="text-center"><a class="dropdown-item" href="?a=configuracoes"><strong>Configurações</strong></a></div>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="?a=promocoes"><i id="green" class="fas fa-percentage mr-2"></i>Promoções</a>
            <a class="dropdown-item" href="?a=prospects"><i id="green" class="fas fa-chart-line mr-2"></i>Prospects</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="?a=perfil_alterar_login"><i id="green" class="fas fa-id-badge mr-2"></i>Alterar Login</a>
            <a class="dropdown-item" href="?a=perfil_alterar_senha"><i id="green" class="fas fa-key mr-2"></i>Alterar Senha</a>
            <a class="dropdown-item" href="?a=perfil_alterar_email"><i id="green" class="fas fa-at mr-2"></i>Alterar Email</a>
            <div class="dropdown-divider"></div>
            <div class="text-center"><a class="dropdown-item" href="?a=logout"><strong>Logout</strong></a></div>
        </div>
    </div>
    <?php else:?>
    <div class="p-2"><span class="<?php echo $classe ?>"><i class="fa fa-user"></i> Nenhum usuário ativo | <a href="?a=login" class="mr-1" ><i class="fas fa-sign-in-alt"></i>Login</a></span></div>
    <?php endif;?>
</div>