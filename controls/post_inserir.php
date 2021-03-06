<?php
    //verificar a sessão.
    if(!isset($_SESSION['a'])){
        exit();
    }
    //Instancia do Banco
    $gestor = new cl_gestorBD();
    $data = new DateTime();

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $titulo  =  funcoes::TratarCampo($_POST['post_text_titulo']);
        $autor  =  funcoes::TratarCampo($_POST['post_text_autor']);
        $conteudo  =  funcoes::TratarCampo($_POST['post_text_content']);

        //definição de parametros/dados
        $parametros = [
            ':ds_title'             =>  $titulo,
            ':ds_content'           =>  $conteudo,
            ':nm_autor'             =>  $autor,
            ':dt_register'          =>  $data->format('Y-m-d H:i:s'),
            ':dt_updated'           =>  $data->format('Y-m-d H:i:s')
        ];
        //Inserçao do post na tabela tab_card
        $gestor->EXE_NON_QUERY(
            'INSERT INTO tab_post(ds_title, ds_content, nm_autor, dt_register, dt_updated)
            VALUES(:ds_title, :ds_content, :nm_autor, :dt_register, :dt_updated)', $parametros);

        //Log
        funcoes::CriarLOG('Nova postagem Inserida com sucesso.', $_SESSION['nm_user']);

        //header("Location:?a=home");
        echo('<meta http-equiv="refresh" content="0;URL=?a=home">');
        exit();
    }
?>