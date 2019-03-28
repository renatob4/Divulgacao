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

    if($config[0]['st_service'] == 0){
        //header("Location:?a=home");
        echo('<meta http-equiv="refresh" content="0;URL=?a=servicos">');
        exit();
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        //captura dos dados do form
        $cd_service = funcoes::TratarCampo(strtoupper($_POST['cd_service']));
        $nm_service = funcoes::TratarCampo(strtoupper($_POST['nm_service']));
        $vl_service = funcoes::TratarCampo($_POST['vl_service']);
        $ds_descricao = funcoes::TratarCampo($_POST['ds_desc_service']);
        
        $radio = $_POST['pmtsradio'];

        //Verifica se ja existe produto com o mesmo código.
        $parametros = [
            ':cd_alternative_service'    =>    $cd_service
        ];
        $servicos = $acesso->EXE_QUERY('SELECT * FROM tab_service WHERE cd_alternative_service = :cd_alternative_service', $parametros);
        if(count($servicos) != 0){
            $erro = true;
            $mensagem = "Ja existe outro Serviço com o mesmo código: (".$servicos[0]['cd_alternative_service'].")";
        }

        if(!$erro){
            //definição de parametros/dados
            $parametros = [
                ':cd_alternative_service'             =>  $cd_service,
                ':nm_service'                         =>  $nm_service,
                ':vl_service'                         =>  $vl_service,
                ':ds_description'                     =>  $ds_descricao,
                ':st_promotion'                       =>  $radio,
                ':dt_register'                        =>  $data->format('Y-m-d H:i:s'),
                ':dt_updated'                         =>  $data->format('Y-m-d H:i:s')
            ];
            //Inserçao do card na tabela tab_card
            $acesso->EXE_NON_QUERY(
                'INSERT INTO tab_service(cd_alternative_service, nm_service, vl_service, ds_description, st_promotion, dt_register, dt_updated)
                 VALUES(:cd_alternative_service, :nm_service, :vl_service, :ds_description, :st_promotion, :dt_register, :dt_updated)', $parametros);
             
            $mensagem = 'Novo serviço cadastrado com sucesso!'; 

            //Log
            funcoes::CriarLOG(''.$mensagem , $_SESSION['nm_user']);
        }

        //Resultado das operações.
        if($erro){
            $_SESSION['resultado'] = $mensagem;
            //header("Location:?a=home");
            echo('<meta http-equiv="refresh" content="0;URL=?a=servicos">');
            exit();
        }else{
            $_SESSION['resultado'] = $mensagem;
            //header("Location:?a=home");
            echo('<meta http-equiv="refresh" content="0;URL=?a=servicos">');
            exit();
        }
    }
?>