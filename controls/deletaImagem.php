<?php

    //verificar a sessão.
    if(!isset($_SESSION['a'])){
        exit();
    }

    if((!isset($_GET['img']) || !isset($_GET['sender'])) || $_GET['sender'] != 'body'){
        //header("Location:?a=home");
        echo('<meta http-equiv="refresh" content="0;URL=?a=home">');
        exit();
    }else{
        $img = $_GET['img'];
        $sender = $_GET['sender'];
    }

    $acesso = new cl_gestorBD();
    $data = new DateTime();
    $erro = false;

    if($sender == 'body')
    {
        $parametros = [
            ':img_body' => $img
        ];
        $path = $acesso->EXE_QUERY('SELECT * FROM tab_imagem WHERE img_body = :img_body', $parametros);
        //Verifica no banco se retornou resultado.
        if(count($path) == 0){
            $erro = true;
        }

        if(!$erro){
            //Atualiza o banco com o nome vazio da imagem.
            $parametros = [
                ':cd_img'           => $path[0]['cd_img'],
                ':img_body'     =>  '',
                ':dt_updated'       => $data->format('Y-m-d H:i:s')
            ];
            $acesso->EXE_NON_QUERY('UPDATE tab_imagem SET img_body = :img_body, dt_updated = :dt_updated WHERE cd_img = :cd_img', $parametros);
    
            //Apaga a imagem do diretório.
            if($img != 'images/welcome.jpg')
            unlink("./".$img);
        }
    }

    // Redireciona
    echo('<meta http-equiv="refresh" content="0;URL=?a=home">');
?>