<?php
    //verificar a sessão.
    if(!isset($_SESSION['a'])){
        exit();
    }

    if(isset($_GET['sender'])){
        $sender = $_GET['sender'];
    }else{
        //header("Location:?a=home");
        echo('<meta http-equiv="refresh" content="0;URL=?a=home">');
        exit();
    }

    //Instancia do banco de dados.
    $acesso = new cl_gestorBD();  
    $data = new DateTime();
    $config = $acesso->EXE_QUERY('SELECT * FROM tab_config');

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        if($sender == 'products'){
            $cfg_relevance = $_POST['cfg_rel'];
            $cfg_amount = $_POST['cfg_amount'];
            $parametros = [
                ':cd_config'     =>  $config[0]['cd_config'],
                ':sp_relevance'  =>  $cfg_relevance,
                ':sp_amount'     =>  $cfg_amount,
                ':dt_updated'    =>  $data->format('Y-m-d H:i:s')
            ];  
            $acesso->EXE_NON_QUERY('UPDATE tab_config SET sp_relevance = :sp_relevance, sp_amount = :sp_amount, dt_updated = :dt_updated WHERE cd_config = :cd_config', $parametros);
            
            //Log
            funcoes::CriarLOG('Configuração de vizualização padrão de produtos alterada.' , $_SESSION['nm_user']);

            //header("Location:?a=home");
            echo('<meta http-equiv="refresh" content="0;URL=?a=produtos">');
            exit();
        }
        
        if($sender == 'services'){
            $cfg_relevance = $_POST['cfg_rel_service'];
            $cfg_amount = $_POST['cfg_amount_service'];
            $parametros = [
                ':cd_config'     =>  $config[0]['cd_config'],
                ':ss_relevance'  =>  $cfg_relevance,
                ':ss_amount'     =>  $cfg_amount,
                ':dt_updated'    =>  $data->format('Y-m-d H:i:s')
            ];  
            $acesso->EXE_NON_QUERY('UPDATE tab_config SET ss_relevance = :ss_relevance, ss_amount = :ss_amount, dt_updated = :dt_updated WHERE cd_config = :cd_config', $parametros);
            
            //Log
            funcoes::CriarLOG('Configuração de vizualização padrão de serviços alterada.' , $_SESSION['nm_user']);
            
            //header("Location:?a=home");
            echo('<meta http-equiv="refresh" content="0;URL=?a=servicos">');
            exit();
        }
    }
?>