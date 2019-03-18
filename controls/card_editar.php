<?php
    // ========================================
    // Referente ao forma da Pagina HOME
    // ========================================

    //verificar a sessão.
    if(!isset($_SESSION['a'])){
        exit();
    }
    // verifica se existe card definido
    if(!isset($_GET['card'])){
        //header("Location:?a=home");
        echo('<meta http-equiv="refresh" content="0;URL=?a=home">');
        exit();
    }
    //Pega card da url
    $cd_card = $_GET['card'];

    //Instancia do banco de dados.
    $acesso = new cl_gestorBD();
    $data = new DateTime();

    //pesquisa se existe card com esse codigo na base
    $parametros = [
        ':cd_card'   =>  $cd_card
    ];
    $result = $acesso->EXE_QUERY('SELECT ds_title FROM tab_card WHERE cd_card = :cd_card', $parametros);
    
    //Se não existir card de mesmo codigo na base ele encerra.
    if(count($result) == 0){
        //header("Location:?a=home");
        echo('<meta http-equiv="refresh" content="0;URL=?a=home">');
        exit();
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        //Pega os valores do form
        if(isset($_POST['card_text_titulo']) && isset($_POST['card_text_content'])){
            $novo_titulo  =  funcoes::TratarCampo($_POST['card_text_titulo']);
            $novo_conteudo  =  $_POST['card_text_content'];
        }else{
            $novo_titulo  =  funcoes::TratarCampo($_POST['cardtext_titulo']);
            $novo_conteudo  =  $_POST['cardtext_content'];
        }

        //Atualizar os dados do card no banco.
        $parametros = [
            ':cd_card'      =>  $cd_card,
            ':ds_title'     =>  $novo_titulo,
            ':ds_content'   =>  $novo_conteudo,
            ':dt_updated'   =>  $data->format('Y-m-d H:i:s')
        ];  
        //Atualizar a DB
        $acesso->EXE_NON_QUERY('UPDATE tab_card SET ds_title = :ds_title, ds_content = :ds_content, dt_updated = :dt_updated 
                                WHERE cd_card = :cd_card', $parametros);
    
        //Log
        funcoes::CriarLOG('Card de conteúdo editado.', $_SESSION['nm_user']);

        //Redirecionar
        //header("Location:?a=home");
        echo('<meta http-equiv="refresh" content="0;URL=?a=home">');
        exit();
    }
?>