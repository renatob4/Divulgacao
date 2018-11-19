<?php 
    // ========================================
    // PERFIL - ALTERAR EMAIL
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
        $novo_email = $_POST['text_novo_email'];


        $gestor = new cl_gestorBD();

        // verifica se o novo email esta a ser utilizado por outro usuário
        $parametros = [
            ':cd_login'    => $_SESSION['cd_login_partner'],
            ':ds_email'    =>  $novo_email
        ];
        $dados = $gestor->EXE_QUERY(
            'SELECT cd_login, ds_email FROM tab_partner
             WHERE cd_login <> :cd_login
             AND ds_email = :ds_email', $parametros);

        if(count($dados) != 0){
            //Outro utilizador com o mesmo email
            $erro = true;
            $mensagem = 'Já existe outro Sócio com o mesmo email.';
        }
       
        // atualizar o email na base     
        if(!$erro){
            
            $data_atualizacao = new DateTime();
            $parametros = [
                ':cd_login'    => $_SESSION['cd_login_partner'],
                ':ds_email'    => $novo_email,
                ':dt_updated'  => $data_atualizacao->format('Y-m-d H:i:s')
            ];
            $gestor->EXE_NON_QUERY(
                'UPDATE tab_partner SET
                 ds_email = :ds_email,
                 dt_updated = :dt_updated 
                 WHERE cd_login = :cd_login          
                ', $parametros);
            
            $sucesso = true;
            $mensagem = 'Email atualizado com sucesso.';

            //Atualiza o email exibido na pagina
            $_SESSION['ds_email'] = $novo_email;

            //LOG
            funcoes::CriarLOG('Utilizador '.$_SESSION['cd_login_partner'].': alterou o seu Email.',$_SESSION['nm_partner']);
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
            <h4 class="text-center">ALTERAR E-MAIL DA CONTA</h4>
            <hr>
                <!--Apresenta o email atual-->
                <div><strong>Email atual:</strong> <?php echo $_SESSION['ds_email'] ?></div>
            <hr>

            <!-- formulário -->
            <form action="?a=perfil_alterar_email" method="post">
                    <div class="col-sm-4 offset-sm-4 justify-content-center">
                        <div class="form-group">
                            <label>Novo e-mail:</label>
                            <input type="email" class="form-control" name="text_novo_email" title="No mínimo 5 e no máximo 50 caracteres." pattern=".{5,50}" required>
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