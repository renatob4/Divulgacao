<?php

   // ==========================================================
   // FORMULARIO DE LOGIN
   // ==========================================================

    //verificar a sessão.
    if(!isset($_SESSION['a'])){
        exit();
    }      
    //====================================================================================== 

    $erro = false;
    $mensagem = '';
    $mensagem_enviada = false;
    
    //verificar se existe um post
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

       $text_email = $_POST['text_email'];
       $gestor = new cl_gestorBD();
       //parametros
       $parametros = [
           ':ds_email'   =>   $text_email
       ];
       //pesquisar na base de dados para ver se existe o email
       $dados = $gestor->EXE_QUERY(
           'SELECT * FROM tab_user WHERE ds_email = :ds_email', $parametros);

       //verifica se foi encontrado um endereço de email relacionado
       if(count($dados) == 0){
            //login inválido
            $erro = true;
            $mensagem = 'O E-mail informado não esta relacionado a esta conta.';
        }
        else{
            //login válido. Gerar nova senha e enviar.
            $nova_senha =  funcoes::CriarCodigoAlfanumerico(12);

        //======================================================================================  

            $email = new emails();
            //preparação dos dados do email.
            $temp = [
                $dados[0]['ds_email'],
                'Recuperação de password',
                "<div style='background-color: aliceblue; padding: 20px;border: 1px solid black'>
                <h4 style='color:green;'>Nova mensagem do Site! <label style='color:black;'>- Recuperação de password</label></h4>
                <hr>
                <h5 style='color:black;'>Nova senha temporária: <label style='font-weight:normal;color:grey;'>$nova_senha</label></h5>
                <hr>
                </div>
                </div>"
            ];
            //enviar o email
            $mensagem_enviada = $email->EnviarEmail($temp);


        //====================================================================================== 

            //alterar a senha na base de dados
            if($mensagem_enviada){
                $id_utilizador = $dados[0]['cd_login'];
                $parametros = [
                    ':cd_login'       => $id_utilizador,
                    ':cd_password'    => md5($nova_senha)
                ];
                $gestor->EXE_NON_QUERY(
                    'UPDATE tab_user
                     SET cd_password = :cd_password
                     WHERE cd_login = :cd_login', $parametros);

            //log
            funcoes::CriarLOG('utilizador '.$dados[0]['nm_user'].': Solicitou a recuperação da password.', $dados[0]['nm_user']);
            }
            else{
                //mensagem de erro
                $erro = true;
                $mensagem = 'ATENÇÃO: ERRO ao enviar a nova senha. Certifique-se de que o e-mail é válido!.';
            }     
        }
    }

?>

<!--________________________________________________________________________ HTML ______________________________________________________________________________________-->

<?php if($mensagem_enviada == false): ?>
                <!--Apresentação da mensagem de erro ao recuperar-->
                <?php if($erro): ?>
                <div class="alert alert-danger text-center"><?php echo $mensagem ?></div>
                <?php endif; ?>
                <!--Apresentação do formulario de recuperação-->
                <div class="container-fluid p-0">
                    <div class="row mr-1 ml-1 mt-2 borda-painel shadow-strong">
                        <div class="col-md-4 card m-0 p-3">
                            <form action="?a=recuperar_senha" method="post">
                                <div class="text-center">
                                    <h5 id="green">RECUPERAR SENHA</h5>
                                        <p>Indique abaixo o e-mail vinculado a sua conta, para onde enviaremos a sua nova senha.</p>
                                    </div>
                                <div class="form-group">
                                    <input type="email" name="text_email" class="form-control shadow" maxlength="50" placeholder="E-mail" required>
                                </div>
                                <div class="form-group text-center">
                                    <a href="?a=home" class="btn btn-primary shadow">Cancelar</a>
                                    <button role="submit" class="btn btn-primary shadow">Recuperar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
    <?php else : ?>
                <!--Apresentação da mensagem de sucesso ao recuperar-->
                <div class="container-fluid p-0">
                    <div class="row mr-1 ml-1 mt-2 borda-painel shadow-strong">
                        <div class="col-md-4 card m-3 p-3">                            
                            <div class="text-center">
                                <h3>Senha recuperada com sucesso!</h3><hr><p>Verifique seu e-mail e utilize a senha provisória recebida para fazer login.</p>   
                                <a href="?a=home" class="btn btn-primary btn-size-150">Voltar</a>
                                <a href="?a=login" class="btn btn-primary btn-size-150">Fazer login</a>
                            </div>
                        </div>
                    </div>
                </div>
<?php endif;?>
