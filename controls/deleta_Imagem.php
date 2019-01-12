<?php
    //verificar a sessão.
    if(!isset($_SESSION['a'])){
        exit();
    }

    if((!isset($_GET['img']) || !isset($_GET['sender'])) || ($_GET['sender'] != 'body' && $_GET['sender'] != 'card' && $_GET['sender'] != 'product')){
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
                ':img_body'         =>  '',
                ':dt_updated'       => $data->format('Y-m-d H:i:s')
            ];
            $acesso->EXE_NON_QUERY('UPDATE tab_imagem SET img_body = :img_body, dt_updated = :dt_updated WHERE cd_img = :cd_img', $parametros);
    
            //Apaga a imagem do diretório.
            if($img != 'images/welcome.jpg')
            unlink("./".$img);

            echo('<meta http-equiv="refresh" content="0;URL=?a=home">');
            exit();
        }

    } elseif($sender == 'card'){

        if(isset($_GET['flag'])){
            $parametros = [
                ':img_front_card' => $img
            ];
            $path = $acesso->EXE_QUERY('SELECT * FROM tab_card WHERE img_front_card = :img_front_card', $parametros);
            //Verifica no banco se retornou resultado.
            if(count($path) == 0){
                $erro = true;
            }
            if (!$erro) {
                //Atualiza o banco com o nome vazio da imagem.
                $parametros = [
                    ':cd_card'          => $path[0]['cd_card'],
                    ':img_front_card'   =>  '',
                    ':dt_updated'       => $data->format('Y-m-d H:i:s')
                ];
                $acesso->EXE_NON_QUERY('UPDATE tab_card SET img_front_card = :img_front_card, dt_updated = :dt_updated WHERE cd_card = :cd_card', $parametros);
                //Apaga a imagem do diretório.
                unlink("./".$img);
            }
        } else {
            $parametros = [
                ':img_card' => $img
            ];
            $path = $acesso->EXE_QUERY('SELECT * FROM tab_card WHERE img_card = :img_card', $parametros);
            //Verifica no banco se retornou resultado.
            if(count($path) == 0){
                $erro = true;
            }
            if (!$erro) {
                //Atualiza o banco com o nome vazio da imagem.
                $parametros = [
                    ':cd_card'          => $path[0]['cd_card'],
                    ':img_card'         =>  '',
                    ':dt_updated'       => $data->format('Y-m-d H:i:s')
                ];
                $acesso->EXE_NON_QUERY('UPDATE tab_card SET img_card = :img_card, dt_updated = :dt_updated WHERE cd_card = :cd_card', $parametros);
                //Apaga a imagem do diretório.
                unlink("./".$img);
            }
        }

        echo('<meta http-equiv="refresh" content="0;URL=?a=home">');
        exit();
    
    } elseif($sender == 'product'){

        $parametros = [
            ':img_product' => $img
        ];
        $path = $acesso->EXE_QUERY('SELECT * FROM tab_product WHERE img_product = :img_product', $parametros);
        //Verifica no banco se retornou resultado.
        if(count($path) == 0){
            $erro = true;
        }
        if(!$erro){
            //Atualiza o banco com o nome vazio da imagem.
            $parametros = [
                ':cd_product'       => $path[0]['cd_product'],
                ':img_product'         =>  '',
                ':dt_updated'       => $data->format('Y-m-d H:i:s')
            ];
            $acesso->EXE_NON_QUERY('UPDATE tab_product SET img_product = :img_product, dt_updated = :dt_updated WHERE cd_product = :cd_product', $parametros);
            //Apaga a imagem do diretório.
            unlink("./".$img);

            echo('<meta http-equiv="refresh" content="0;URL=?a=produtos">');
            exit();
        }
    }
?>