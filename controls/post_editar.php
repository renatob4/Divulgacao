<?php
    //verificar a sessão.
    if(!isset($_SESSION['a'])){
        exit();
    }
    //Instancia do banco de dados.
    $acesso = new cl_gestorBD();
    $data = new DateTime();

    //Pega o codigo do post na URL
    if(isset($_GET['post']))
        $cd_post = $_GET['post'];
    else
        header("Location:?a=home");    

    //pesquisa se existe post com esse codigo na base
    $parametros = [
        ':cd_post'   =>  $cd_post
    ];
    $post = $acesso->EXE_QUERY('SELECT * FROM tab_post WHERE cd_post = :cd_post', $parametros);
     
    //Se não existir post de mesmo codigo na base ele encerra.
    if(count($post) == 0){
        header("Location:?a=home");
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        //Pega os valores do form
        if(isset($_POST['posttext_titulo']) && isset($_POST['posttext_content']) && isset($_POST['posttext_autor'])){
            $novo_titulo  =  $_POST['posttext_titulo'];
            $novo_conteudo  =  $_POST['posttext_content'];
            $novo_autor  =  $_POST['posttext_autor'];
        }

        //Atualizar os dados no card no banco
        $parametros = [
            ':cd_post'      =>  $cd_post,
            ':ds_title'     =>  $novo_titulo,
            ':nm_autor'     =>  $novo_autor,
            ':ds_content'   =>  $novo_conteudo,
            ':dt_updated'   =>  $data->format('Y-m-d H:i:s')
        ];  
        //Atualizar a DB
        $acesso->EXE_NON_QUERY('UPDATE tab_post SET ds_title = :ds_title, ds_content = :ds_content, nm_autor = :nm_autor, dt_updated = :dt_updated
                                WHERE cd_post = :cd_post', $parametros);

        //redireciona após terminar a atualização.
        header("Location:?a=home");                        
    }
?>

<div class="card borda-painel text-left mt-3 p-0 m-0">
    <div class="p-2">
        <div class="row p-0">
            <div id="black" class="col-sm-6 text-left m-0"><h6><i class="fas fa-flag mr-2"></i><?php echo $post[0]['ds_title']?> | <label id="grey"><?php echo $post[0]['nm_autor']?></label></h6></div>                                  
            <div id="grey" class="col text-right mr-2"><h6><i class="far fa-clock mr-2"></i><?php echo $post[0]['dt_updated']?></h6></div>                               
        </div><hr class="mb-1 mt-0">
        <p><?php echo $post[0]['ds_content']?></p>
    </div>
</div>

<div class="row mt-5">
    <div class="col p-0">
        <div class="card painel-direito p-3">
            <h5 id="black" class="text-left mb-3">Edite as informações do POST acima:</h5>
            <form method="POST" action="?a=post_editar&post=<?php echo $post[0]['cd_post']?>">
                <div class="form-row">
                        <div class="col-md-8">
                            <label><b><i class="far fa-star mr-2"></i>Título:</b></label>
                            <input type="text" name="posttext_titulo" class="form-control" value="<?php echo $post[0]['ds_title']?>" required>
                        </div>
                        <div class="col-md-4">
                            <label><b><i class="far fa-user mr-2"></i>Autor:</b></label>
                            <input type="text" name="posttext_autor" class="form-control" value="<?php echo $post[0]['nm_autor']?>" required>
                        </div>                      
                    </div>
                <div class="form-goup mt-2">
                    <label><b><i class="fas fa-file-alt mr-2"></i>Conteúdo:</b></label>
                    <textarea type="text" 
                                name="posttext_content" 
                                class="form-control" 
                                rows="5" 
                                required><?php echo $post[0]['ds_content']?></textarea>
                </div>
                <div class="text-right p-0 mr-0 mt-2">
                    <a href="?a=post_deletar&post=<?php echo $post[0]['cd_post']?>" class="btn btn-danger borda-painel mr-2"><i class="fas fa-trash mr-1"></i>Apagar</a>
                    <button type="submit" class="btn btn-success borda-painel"><i class="fas fa-edit mr-1"></i>Aplicar alterações</button>
                </div>
            </form>
        </div>
    </div>
</div>