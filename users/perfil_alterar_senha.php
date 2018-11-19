
<?php 
    // ========================================
    // PERFIL - ALTERAR SENHA
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
        //busca os valores inseridos nos inputs
        $password_atual = $_POST['text_password_atual'];
        $password_nova_1 = $_POST['text_password_nova_1'];
        $password_nova_2 = $_POST['text_password_nova_2'];

        $gestor = new cl_gestorBD();

        // verifica se a password atual está correta
        $parametros = [
            ':cd_login'       => $_SESSION['cd_login_partner'],
            ':cd_password'    => md5($password_atual)
        ];
        $dados = $gestor->EXE_QUERY(
            'SELECT cd_login, cd_password FROM tab_partner
             WHERE cd_login = :cd_login
             AND cd_password = :cd_password',$parametros);

        if(count($dados) == 0){
            //password atual errada
            $erro = true;
            $mensagem = 'A password atual não coincide.';
        }
        if(!$erro){
            //verificar se as duas passwords novas coincidem
            if($password_nova_1 != $password_nova_2){
                $erro = true;
                $mensagem = 'A nova password a sua repetição não correspondem.';
            }
        }
        // atualizar a password na bd        
        if(!$erro){
            
            $data_atualizacao = new DateTime();
            $parametros = [
                ':cd_login'    => $_SESSION['cd_login_partner'],
                ':cd_password' => md5($password_nova_1),
                ':dt_updated'  => $data_atualizacao->format('Y-m-d H:i:s')
            ];
            $gestor->EXE_NON_QUERY(
                'UPDATE tab_partner SET
                 cd_password = :cd_password,
                 dt_updated = :dt_updated 
                 WHERE cd_login = :cd_login          
                ', $parametros);
            
            $sucesso = true;
            $mensagem = 'Password atualizada com sucesso.';
            //LOG
            funcoes::CriarLOG('Utilizador '.$_SESSION['cd_login_partner'].': alterou a sua password. ',$_SESSION['nm_partner']);
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
            <h4 class="text-center">ALTERAR SENHA</h4>
            <hr>
            <!-- formulário -->
            <form action="?a=perfil_alterar_senha" method="post">
                    <div class="col-sm-4 offset-sm-4 justify-content-center">
                        <div class="form-group">
                            <label>Password atual:</label>
                            <input type="text" class="form-control" name="text_password_atual" title="No mínimo 3 e no máximo 20 caracteres." pattern=".{3,20}" required>
                        </div>
                    </div>
                    <div class="col-sm-4 offset-sm-4 justify-content-center">
                        <div class="form-group">
                            <label>Nova password:</label>
                            <input type="text" class="form-control" name="text_password_nova_1" title="No mínimo 3 e no máximo 20 caracteres." pattern=".{3,20}" required>
                        </div>
                    </div>
                    <div class="col-sm-4 offset-sm-4 justify-content-center">
                        <div class="form-group">
                            <label>Repetir a nova password:</label>
                            <input type="text" class="form-control" name="text_password_nova_2" title="No mínimo 3 e no máximo 20 caracteres." pattern=".{3,20}" required>
                        </div>
                    </div>
                    <div class="text-center">
                        <a href="?a=perfil" class="btn btn-primary btn-size-150">Voltar</a>
                        <button role="submit" class="btn btn-primary btn-size-150">Alterar</button>                    
                    </div>
            </form>

        </div>        
    </div>
</div>


