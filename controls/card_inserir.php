<?php
    //verificar a sessão.
    if(!isset($_SESSION['a'])){
        exit();
    }

    //Instancia do Banco
    $gestor = new cl_gestorBD();
    $data = new DateTime();

    //Verifica se ja existe o limite de 6 cards na base.
    $result = $gestor->EXE_QUERY('SELECT * FROM tab_card');
    if(count($result) >= 6){  
        //header("Location:?a=home");
        echo('<meta http-equiv="refresh" content="0;URL=?a=home">');  
        exit();
    }

    //definição de parametros/dados
    $parametros = [
        ':ds_title'             =>  'Título do Card',
        ':ds_content'           =>  'Aqui ficam expostas noticias, atualizações, promoções ou avisos importantes que precisem ficar destacados.',
        ':dt_register'          =>  $data->format('Y-m-d H:i:s'),
        ':dt_updated'           =>  $data->format('Y-m-d H:i:s')
    ];
    //Inserçao do card na tabela tab_card
    $gestor->EXE_NON_QUERY(
        'INSERT INTO tab_card(ds_title, ds_content, dt_register, dt_updated)
        VALUES(:ds_title, :ds_content, :dt_register, :dt_updated)', $parametros);

    //header("Location:?a=home");
    echo('<meta http-equiv="refresh" content="0;URL=?a=home">');
    exit();
?>