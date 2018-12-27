<?php
    //verificar a sessão.
    if(!isset($_SESSION['a'])){
        exit();
    }

    //Instancia do banco de dados.
    $acesso = new cl_gestorBD();
    $data = new DateTime();

    $erro = false;
    $mensagem = '';

    // if($config[0]['st_product'] == 0){
    //     //header("Location:?a=home");
    //     echo('<meta http-equiv="refresh" content="0;URL=?a=home">');
    //     exit();
    // }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        //captura dos dados do form
        $cd_produto = $_POST['cd_produto'];
        $nm_produto = $_POST['nm_produto'];
        $ds_unidade = $_POST['ds_unidade'];
        $cat_produto = $_POST['cat_produto'];
        $ds_unidade = $_POST['ds_unidade'];
        $vl_produto = $_POST['vl_produto'];
        $ds_descricao = $_POST['ds_descricao'];

        //Verifica se ja existe produto com o mesmo código.
        $parametros = [
            ':cd_alternative_product'    =>    $cd_produto
        ];
        $produtos = $acesso->EXE_QUERY('SELECT * FROM tab_product WHERE cd_alternative_product = :cd_alternative_product', $parametros);
        if(count($produtos) != 0){
            $erro = true;
            $mensagem = 'Ja existe outro produto com o mesmo código.';
        }

        if(!$erro){
            //definição de parametros/dados
            $parametros = [
                ':cd_alternative_product'             =>  $cd_produto,
                ':nm_product'                         =>  $nm_produto,
                ':ds_category'                        =>  $cat_produto,
                ':vl_product'                         =>  $vl_produto,
                ':ds_description'                     =>  $ds_descricao,
                ':ds_unity'                           =>  $ds_unidade,
                ':img_product'                        =>  '',
                ':dt_register'                        =>  $data->format('Y-m-d H:i:s'),
                ':dt_updated'                         =>  $data->format('Y-m-d H:i:s')
            ];
            //Inserçao do card na tabela tab_card
            $acesso->EXE_NON_QUERY(
                'INSERT INTO tab_product(cd_alternative_product, nm_product, ds_category, vl_product, ds_description, ds_unity, img_product, dt_register, dt_updated)
                VALUES(:cd_alternative_product, :nm_product, :ds_category, :vl_product, :ds_description, :ds_unity, :img_product, :dt_register, :dt_updated)', $parametros);
        }
        //header("Location:?a=home");
        echo('<meta http-equiv="refresh" content="0;URL=?a=produtos">');
        exit();
    }
?>