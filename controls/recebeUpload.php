<?php
    /****** Upload de imagens ******/

    //verificar a sessão.
    if(!isset($_SESSION['a'])){
        exit();
    }

    $acesso = new cl_gestorBD();
    $data = new DateTime();
    $mensagem = '';
    $img = $acesso->EXE_QUERY('SELECT * FROM tab_imagem');

    if(!isset($_GET['sender']) || ($_GET['sender'] != 'header' && $_GET['sender'] != 'body' && $_GET['sender'] != 'panel')){
        //header("Location:?a=home");
        echo('<meta http-equiv="refresh" content="0;URL=?a=home">');
        exit();
    }else{
        $sender = $_GET['sender'];
    }

    // verifica se foi enviado um arquivo
    if (isset($_FILES['arquivo']['name']) && $_FILES['arquivo']['error'] == 0){

        // echo 'Você enviou o arquivo: <strong>'.$_FILES['arquivo']['name'].'</strong><br/>';
        // echo 'Este arquivo é do tipo: <strong>'.$_FILES['arquivo']['type'].'</strong ><br/>';
        // echo 'Temporáriamente foi salvo em: <strong>'.$_FILES['arquivo']['tmp_name'].'</strong><br/>';
        // echo 'Seu tamanho é: <strong>'.$_FILES['arquivo']['size'].' </strong>Bytes<br/><br/>';
        
        $arquivo_tmp = $_FILES['arquivo']['tmp_name'];
        $nome = $_FILES['arquivo']['name'];
    
        // Pega a extensão
        $extensao = pathinfo($nome, PATHINFO_EXTENSION);
        // Converte a extensão para minúsculo
        $extensao = strtolower($extensao);
    
        // Somente imagens, .jpg;.jpeg;.gif;.png, Aqui eu enfileiro as extensões permitidas e separo por ';' Isso serve apenas para eu poder pesquisar dentro desta String
        if (strstr('.jpg;.jpeg;.gif;.png', $extensao)){

            // Cria um nome único para esta imagem, Evita que duplique as imagens no servidor, Evita nomes com acentos, espaços e caracteres não alfanuméricos
            $novoNome = uniqid(time()).'.'.$extensao;
            // Concatena a pasta com o nome
            $destino = './images/'.$novoNome;
        
            // tenta mover o arquivo para o destino
            if(@move_uploaded_file($arquivo_tmp, $destino)){

                if($sender == 'header'){
                    if($img[0]['img_header'] != 'images/logo.png'){
                        //Apaga a imagem antiga do diretorio do site.
                        unlink("./".$img[0]['img_header']);
                    }
                    //Atualiza o banco com o nome da nova imagem.
                    $parametros = [
                        ':cd_img'           => 1,
                        ':img_header'       => "images/".$novoNome,
                        ':dt_updated'       => $data->format('Y-m-d H:i:s')
                    ];
                    $acesso->EXE_NON_QUERY('UPDATE tab_imagem SET img_header = :img_header, dt_updated = :dt_updated WHERE cd_img = :cd_img', $parametros);

                }elseif($sender == 'body'){
                    if($img[0]['img_body'] != 'images/welcome.jpg' && $img[0]['img_body'] != ''){
                        //Apaga a imagem antiga do diretorio do site.
                        unlink("./".$img[0]['img_body']);
                    }
                    //Atualiza o banco com o nome da nova imagem.
                    $parametros = [
                        ':cd_img'           => 1,
                        ':img_body'       => "images/".$novoNome,
                        ':dt_updated'       => $data->format('Y-m-d H:i:s')
                    ];
                    $acesso->EXE_NON_QUERY('UPDATE tab_imagem SET img_body = :img_body, dt_updated = :dt_updated WHERE cd_img = :cd_img', $parametros);

                }elseif($sender == 'panel'){
                    if($img[0]['img_panel'] != 'images/panel.jpg'){
                        //Apaga a imagem antiga do diretorio do site.
                        unlink("./".$img[0]['img_panel']);
                    }
                    //Atualiza o banco com o nome da nova imagem.
                    $parametros = [
                        ':cd_img'           => 1,
                        ':img_panel'       => "images/".$novoNome,
                        ':dt_updated'       => $data->format('Y-m-d H:i:s')
                    ];
                    $acesso->EXE_NON_QUERY('UPDATE tab_imagem SET img_panel = :img_panel, dt_updated = :dt_updated WHERE cd_img = :cd_img', $parametros);
                }

                $mensagem = 'Arquivo salvo com sucesso!.';
                
            }else{
                $mensagem = 'Erro ao salvar o arquivo. Aparentemente você não tem permissão de escrita.<br />';
            }
        }else{
            $mensagem = 'Você poderá enviar apenas arquivos "*.jpg;*.jpeg;*.gif;*.png"<br/>';
        }
    }else{
        $mensagem = 'Você não enviou nenhum arquivo!';
    }
    
    //header("Location:?a=home");
    echo('<meta http-equiv="refresh" content="0;URL=?a=home">');
    exit();
?>