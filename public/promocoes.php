<?php
    //verificar a sessão.
    if (!isset($_SESSION['a'])) {
        exit();
    }

    //Instancia do banco de dados.
    $acesso = new cl_gestorBD();
    $data_db = new DateTime();
    $data_atual = new DateTime();
    $erro = false;
    $mensagem = "";

    $config = $acesso->EXE_QUERY('SELECT * FROM tab_config');
    $code = $acesso->EXE_QUERY('SELECT * FROM tab_code');
    $promotion = $acesso->EXE_QUERY('SELECT * FROM tab_promotion');
    $cupom = $acesso->EXE_QUERY('SELECT * FROM tab_cupom');

    if($config[0]['st_promotion'] == 0){
        //header("Location:?a=home");
        echo('<meta http-equiv="refresh" content="0;URL=?a=home">');
        exit();
    }
    if($code[0]['lnk_script'] == ''){
        //header("Location:?a=home");
        echo('<meta http-equiv="refresh" content="0;URL=?a=home">');
        exit();
    }
    if($code[0]['id_app'] == ''){
        //header("Location:?a=home");
        echo('<meta http-equiv="refresh" content="0;URL=?a=home">');
        exit();
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        // Tratamento reCAPTCHA
        $url = "https://www.google.com/recaptcha/api/siteverify";
        $respon = $_POST['g-recaptcha-response'];
        $data = array('secret' => "6LdQZYQUAAAAAJ0NbPhpWGikmpVES57JKmQVLQAJ", 'response' => $respon);
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        $jsom = json_decode($result);

        // Se o Recaptcha for resolvido com sucesso então o código prossegue.
        if ($jsom->success) {
            
            $nm_customer = strtoupper($_POST['nm_customer']);
            $_SESSION['cupom'] = strtoupper(funcoes::CriarCodigoAlfanumerico(6));

            $data_validade = new DateTime();
            $arg = "P".$promotion[0]['qt_days']."D";
            $data_validade->add(new DateInterval($arg));
            $_SESSION['dt_validade'] = $data_validade->format('d/m/Y');
    
            $parametros = [
                ':cd_cupom'             =>  $_SESSION['cupom'],
                ':ds_discount'          =>  5,
                ':ds_type'              =>  $promotion[0]['ds_type'],
                ':nm_customer'          =>  $nm_customer,
                ':dt_valid'             =>  $data_validade->format('Y/m/d'),
                ':dt_register'          =>  $data_db->format('Y-m-d H:i:s')
            ];
            $acesso->EXE_NON_QUERY(
                'INSERT INTO tab_cupom(cd_cupom, ds_discount, ds_type, nm_customer, dt_valid, dt_register)
                 VALUES(:cd_cupom, :ds_discount, :ds_type, :nm_customer, :dt_valid, :dt_register)', $parametros);
            
            $mensagem = 'Cupom gerado com sucesso!.';

            //Log
            funcoes::CriarLOG('Novo cupom gerado com sucesso.', 'Cliente');

            echo('<meta http-equiv="refresh" content="0;URL=?a=promocoes">');
            exit();
        }
        else{
            $mensagem = "Por gentileza, resolva o reCaptcha para sabermos que você não é um robô.";
            echo('<meta http-equiv="refresh" content="0;URL=?a=promocoes">');
            exit();
         }
    }

?>
<?php if(!isset($_SESSION['cupom'])):?>
<div class="row mr-1 ml-1 mt-3 border-none">
    <div class="col-md-6 m-0 p-0 border-none">
        <div class="text-center p-0">
            <label class="pc_pmt"><?php echo $promotion[0]['ds_type'] == 'pc' ? $promotion[0]['ds_discount'].'%' : 'R$'.$promotion[0]['ds_discount'];?></label>
            <p class="title_pmt mt-0"><B>GARANTA JÁ SEU CUPOM DE DESCONTO!</B></p>
            <label id="green" class="Obs3 mb-4">Depois utilize o cupom em algum produto ou serviço.</label>
        </div>
    </div>
    <div class="col-md-6 border-none">
        <div class="text-center p-3">
            <p class="title2_pmt mt-3 mb-0">BASTA COMPARTILHAR A NOSSA PÁGINA:</p>
            <div class="form-row">
                <div class="col text-left">
                    <div class="row">
                        <div class="col text-center">
                            <button id="shareBtn" class="btn btn-primary btnshare shadow-strong mb-3 mt-4" onclick="share('<?php echo 'http://$_SERVER[HTTP_HOST]'?>')">
                                <i id="white" class="fab fa-facebook-square mr-2"></i><b>Compartilhar</b>
                            </button>
                            <label id="black" class="Obs3">Após a sua ação o botão de gerar cupons será liberado!</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col pt-2 pb-2 text-center">
                            <form action="?a=promocoes" method="POST">
                                <label id="lbl" class="title2_pmt" style="color: rgb(110,39,43); opacity: 0.7;"><b>INSIRA SEU NOME:</b></label>
                                <input id="nmc" class="form-control shadow mr-2" type="text" name="nm_customer" maxlength="50" placeholder="Compartilhe para ativar" disabled="true" required>
                                <div class="row mt-2 m-0 p-0">
                                    <div class="col-sm-7 p-0 m-0">
                                        <div id="captcha" class="g-recaptcha cap ds-element" data-sitekey="6LdQZYQUAAAAADpC60g28DqxTeKYX1npukOXTe9L"></div>
                                    </div>
                                    <div class="col-sm-5 p-0 m-0">
                                        <button id="gcp" class="btn btn-danger mt-1 p-3 shadow-strong" style="background-color: rgb(110,39,43); border: none; font-size: 1.2em;" disabled="true"><b>GERAR CUPOM</b><i class="fas fa-hourglass-start ml-2"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php else:?>
<div class="row mr-1 ml-1 mt-3 border-none">
    <div class="col p-3 text-center">
        <p class="title_pmt mt-0"><B>PARABÉNS!</B></p>
        <p id="green" class="title2_pmt mb-3">Tire uma foto ou anote o código de seu cupom e leve ou envie para o responsável. O cupom será valido em um produto ou serviço.</p>
    </div>
    <div class="col p-3 text-center">
        <div class="card cupom-card border-none mt-3 p-2 mb-2 shadow-strong">
            <div class="row m-0 p-0 prbdiv-g">
                <div class="col text-left p-0">
                    <label id="gold">CUPOM</label>
                </div>
                <div class="col p-0 text-right">
                    <label class="mr-2"><b>VAL.</b></label><label id="gold"><?php echo $_SESSION['dt_validade'];?></label>
                </div>
            </div>
            <div class="row m-0 p-0">
                <div class="col-sm-8 p-0 text-left">
                    <div class="cupom-font m-0 p-0"><?php echo $_SESSION['cupom'];?></div>
                </div>
                <div class="col-sm-4 p-0 text-right">
                    <div class="cupom-pc"><?php echo $promotion[0]['ds_type'] == 'pc' ? $promotion[0]['ds_discount'].'%' : 'R$'.$promotion[0]['ds_discount'];?></div>
                </div>
            </div>    
        </div>
    </div>
</div>
<?php endif;?>
<?php
    if(isset($_SESSION['dt_validade'])){
        unset($_SESSION['dt_validade']);
    }
    if(isset($_SESSION['cupom'])){
        unset($_SESSION['cupom']);
    }
?>