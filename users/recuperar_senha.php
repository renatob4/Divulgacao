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
                'Site Pessoal - Recuperação de password',
                '<h4><strong>Nova senha temporária:</strong></h4><h3>'.$nova_senha.'</h3>'
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
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-md-4 card m-3 p-3">
                        
                            <form action="?a=recuperar_senha" method="post">
                                <div class="text-center">
                                    <h3>Recuperar Password</h3>
                                        <p>Indique abaixo o e-mail vinculado a sua conta, para onde enviaremos a sua nova senha.</p>
                                    </div>
                                <div class="form-group">
                                    <input type="email" name="text_email" class="form-control" placeholder="E-mail" required>
                                </div>
                                
                                <div class="form-group text-center">
                                    <a href="?a=home" class="btn btn-primary btn-size-150">Cancelar</a>
                                    <button role="submit" class="btn btn-primary btn-size-150">Recuperar</button>
                                </div>
                            </form>       
                        </div>        
                    </div>
                </div>
    <?php else : ?>
                <!--Apresentação da mensagem de sucesso ao recuperar-->
                <div class="container-fluid">
                        <div class="row justify-content-center">
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
