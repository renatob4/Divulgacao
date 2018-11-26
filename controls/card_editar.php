<?php
    //verificar a sessão.
    if(!isset($_SESSION['a'])){
        exit();
    }
    //verifica se existe card definido
    if(!isset($_GET['card'])){
        exit();
    } 

    //Instancia do banco de dados.
    $acesso = new cl_gestorBD();

    //Pega o codigo do card na URL
    $cd_card = $_GET['card'];

    //pesquisa se existe card com esse codigo na base
    $parametros = [
        ':cd_card'   =>  $cd_card
    ];
    $result = $acesso->EXE_QUERY('SELECT * FROM tab_card WHERE cd_card = :cd_card', $parametros);
    
    //Se não existir card de mesmo codigo na base ele encerra.
    if(count($result) == 0){
        header("Location:?a=home");
        exit();
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        //Pega os valores do form
        if(isset($_POST['card_text_titulo']) && isset($_POST['card_text_content'])){
            $novo_titulo  =  $_POST['card_text_titulo'];
            $novo_conteudo  =  $_POST['card_text_content'];
        }else{
            $novo_titulo  =  $_POST['cardtext_titulo'];
            $novo_conteudo  =  $_POST['cardtext_content'];
        } 

        //Atualizar os dados no card no banco
        $parametros = [
            ':cd_card'      =>  $cd_card,
            ':ds_title'     =>  $novo_titulo,
            ':ds_content'   =>  $novo_conteudo
        ];  
        //Atualizar a DB
        $acesso->EXE_NON_QUERY('UPDATE tab_card SET ds_title = :ds_title, ds_content = :ds_content WHERE cd_card = :cd_card', $parametros);
    }

    header("Location:?a=home");
?>




