<?php
    //verificar a sessão.
    if(!isset($_SESSION['a'])){
        exit();
    }
    //verifica se existe post definido
    if(!isset($_GET['p'])){
        //header("Location:?a=home");
        echo('<meta http-equiv="refresh" content="0;URL=?a=produtos">');
        exit();
    } 

    //Instancia do banco de dados.
    $acesso = new cl_gestorBD();
    //Pega o codigo do produto na URL
    $cd_produto = $_GET['p'];

    //pesquisa se existe produto com esse codigo na base
    $parametros = [
        ':cd_product'   =>  $cd_produto
    ];
    $result = $acesso->EXE_QUERY('SELECT * FROM tab_product WHERE cd_product = :cd_product', $parametros);

    //Se não existir card de mesmo codigo na base ele encerra.
    if(count($result) == 0){
        echo('<meta http-equiv="refresh" content="0;URL=?a=produtos">');
        exit();
    } 

    //Atualizar a DB
    $acesso->EXE_NON_QUERY('DELETE FROM tab_product WHERE cd_product = :cd_product', $parametros);

    $img = $result[0]['img_product'];
    if($img != ''){
        //Apaga a imagem do diretório.
        unlink("./".$img);
    }

    //Log
    funcoes::CriarLOG('Produto '.$result[0]['cd_alternative_product'].' removido com sucesso.', $_SESSION['nm_user']);
    
    //header("Location:?a=home");
    echo('<meta http-equiv="refresh" content="0;URL=?a=produtos">');
    exit();
?>