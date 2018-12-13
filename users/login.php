<?php

   // ==========================================================
   // FORMULARIO DE LOGIN
   // ==========================================================

    //verificar a sessão.
    if(!isset($_SESSION['a'])){
        exit();
    }

    $erro = true;
    $mensagem = '';

    //Verificar se foi feito um POST
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        //verificar se os dados do login estão corretos
        $gestor = new cl_gestorBD();

        //preparação dos parametros
        $parametros = [
            ':cd_login'       =>  $_POST['text_utilizador'], 
            ':cd_password'    =>  md5($_POST['text_password'])
        ];

        //procurar o utilizador na base de dados
        $dados = $gestor->EXE_QUERY(
            'SELECT * FROM tab_user
             WHERE cd_login = :cd_login
             AND cd_password = :cd_password', $parametros);   
             
        if(count($dados) == 0){
            //login inválido
            $erro = true;
            $mensagem = 'Dados de login inválido.';
        }
        else{
            //login válido
            $erro = false;
            funcoes::IniciarSessao($dados);
            $mensagem = 'Login efetuado com sucesso!.';

            //Log
            funcoes::CriarLOG('utilizador '.$_SESSION['cd_login'].': '.$mensagem, $_SESSION['nm_user']);
        }     
    }

?>

<?php if($erro) : //===============================================?>
<?php 
    if($mensagem != ''){
            echo '<div class="alert alert-danger text-center">'.$mensagem.'</div>';
    }       
?>
<div class="container-fluid">
    <div class="row justify-content-center mt-4">
        <div class="col-md-4 card bg-secondary m-3 p-3 pt-4 pb-4 borda-painel">      
            <!-- <form action="?a=login" method="post">
                <div class="form-group row">
                    <label for="iL" class="col-sm-1 col-form-label"><i class="fas fa-user m-1"></i></label>
                    <div class="col-sm-10">
                        <input id="iL" class="form-control" type="text" name="text_utilizador" class="form-control" placeholder="Utilizador">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="iP" class="col-sm-1 col-form-label"><i class="fas fa-key m-1"></i></label>
                    <div class="col-sm-12">
                        <input id="iP" class="form-control" type="password" name="text_password" class="form-control" placeholder="Password">
                    </div>
                </div>
                <div class="form-group text-center mt-3">
                        <button role="submit" class="btn btn-primary btn-size-150">Login</button>
                </div>
            </form> -->
            <form action="?a=login" method="post">
                <div class="form-group">
                    <input type="text" name="text_utilizador" class="form-control" placeholder="Utilizador" required>
                </div>
                <div class="form-group">
                    <input type="password" name="text_password" class="form-control" placeholder="Password" required>
                </div>
                <div class="form-group text-center">
                    <button role="submit" class="btn btn-primary btn-size-150">Login</button>
                    <a href="?a=home" class="btn btn-primary btn-size-150">Voltar</a>
                </div>
            </form>
            <div class="text-center">
                <a style="color: white" href="?a=recuperar_senha">Recuperar senha</a>
            </div>          
        </div>        
    </div>
</div>
<?php else : //====================================================?>
    <div class="container-fluid">
        <div class="row justify-content-center mt-3">
            <div class="col-md-4 card m-3 p-3 text-center borda-painel">          
                <p>Bem-vindo, <strong><?php echo $dados[0]['nm_user'] ?></strong> </p>
                <a href="?a=home" class="btn btn-primary">Avançar</a>
            </div>        
        </div>
    </div>
<?php endif; ?>


