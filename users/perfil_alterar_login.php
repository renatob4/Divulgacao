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
    <div class="alert alert-danger text-center">
        <?php echo $mensagem ?>
    </div>
<?php endif; ?>

<?php if($sucesso) : ?>
    <div class="alert alert-success text-center">
        <?php echo $mensagem ?>
    </div>
<?php endif; ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col card m-3 p-3">
            <h4 class="text-center">ALTERAR LOGIN DA CONTA</h4>
            <hr>
                <!--Apresenta o email atual-->
                <div><strong>Login atual:</strong> <?php echo $_SESSION['cd_login'] ?></div>
            <hr>

            <!-- formulário -->
            <form action="?a=perfil_alterar_login" method="post">
                    <div class="col-sm-4 offset-sm-4 justify-content-center">
                        <div class="form-group">
                            <label>Novo Login:</label>
                            <input type="text" class="form-control" name="text_novo_login" title="No mínimo 5 e no máximo 30 caracteres." pattern=".{5,30}" required>
                        </div>
                    </div>
                   
                    <div class="text-center">
                        <a href="?a=home" class="btn btn-primary btn-size-150">Voltar</a>
                        <button role="submit" class="btn btn-primary btn-size-150">Alterar</button>                    
                    </div>
            </form>

        </div>        
    </div>
</div>