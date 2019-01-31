<?php 
    // ========================================
    // PERFIL - ALTERAR Login
    // ========================================

    // verificar a sessão
    if(!isset($_SESSION['a'])){
        exit();
    }

    //define o erro
    $erro = false;
    $sucesso = false;
    $mensagem = '';

    //verifica se foi feito post
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        //busca o valor inseridos nos inputs
        $novo_login = $_POST['text_novo_login'];

        $gestor = new cl_gestorBD();
        // verifica se o novo login esta a ser utilizado por outro usuário
        $parametros = [
            ':cd_user'      => $_SESSION['cd_user'],
            ':cd_login'     => $novo_login
        ];
        $dados = $gestor->EXE_QUERY(
            'SELECT cd_user, cd_login FROM tab_user
             WHERE cd_user <> :cd_user
             AND cd_login = :cd_login', $parametros);

        if(count($dados) != 0){
            //Outro utilizador com o mesmo email
            $erro = true;
            $mensagem = 'Já existe outro usuário com o mesmo Login.';
        }
       
        // atualizar o login na base     
        if(!$erro){
            $data_atualizacao = new DateTime();

            $parametros = [
                ':cd_user'     => $_SESSION['cd_user'],
                ':cd_login'    => $novo_login,
                ':dt_updated'  => $data_atualizacao->format('Y-m-d H:i:s')
            ];
            $gestor->EXE_NON_QUERY(
                'UPDATE tab_user SET
                 cd_login = :cd_login,
                 dt_updated = :dt_updated 
                 WHERE cd_user = :cd_user         
                ', $parametros);
            
            $sucesso = true;
            $mensagem = 'Login atualizado com sucesso.';

            //Atualiza o email exibido na pagina
            $_SESSION['cd_login'] = $novo_login;

            //LOG
            funcoes::CriarLOG('Utilizador '.$_SESSION['cd_login'].': alterou o seu Login.',$_SESSION['nm_user']);
        }
    }
?>

<!--________________________________________________________________________ HTML ____________________________________________________________________________-->

<?php if($erro) : ?>
    <div class="alert alert-danger text-center shadow mr-1 ml-1 mt-2">
        <?php echo $mensagem ?>
    </div>
<?php endif; ?>

<?php if($sucesso) : ?>
    <div class="alert alert-success text-center shadow mr-1 ml-1 mt-2">
        <?php echo $mensagem ?>
    </div>
<?php endif; ?>

<div class="container p-0">
    <div class="row ml-1 mr-1 mt-2 borda-painel shadow-strong">
        <div class="col card">
            <h5 class="text-center mt-3">ALTERAR LOGIN DA CONTA</h5>
            <hr class="mt-2"><div id="green"><strong>LOGIN ATUAL:</strong><label id="black" class="ml-2"><?php echo $_SESSION['cd_login'] ?></label></div><hr class="mt-2">
            <!-- formulário -->
            <form action="?a=perfil_alterar_login" method="post">
                <div class="col-sm-4 offset-sm-4 justify-content-center">
                    <div class="form-group">
                        <label><b><i id="grey" class="fas fa-id-badge mr-2"></i>Novo Login:</b></label>
                        <input type="text" class="form-control shadow" name="text_novo_login" title="No mínimo 5 e no máximo 30 caracteres." pattern=".{5,30}" required>
                    </div>
                </div>
                <div class="text-center mb-3">
                    <a href="?a=home" class="btn btn-primary btn-size-150 shadow">Voltar</a>
                    <button role="submit" class="btn btn-primary btn-size-150 shadow">Alterar</button>                    
                </div>
            </form>
        </div>        
    </div>
</div>