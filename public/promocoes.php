<?php
    //verificar a sessão.
    if (!isset($_SESSION['a'])) {
        exit();
    }
    //Instancia do banco de dados.
    $acesso = new cl_gestorBD();
    $data = new DateTime();
    $config = $acesso->EXE_QUERY('SELECT * FROM tab_config');

    if($config[0]['st_promotion'] == 0){
        //header("Location:?a=home");
        echo('<meta http-equiv="refresh" content="0;URL=?a=home">');
        exit();
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
       //echo "teste";
    }

?>
<div class="row mr-1 ml-1 mt-3 border-none">
    <div class="col-md-6 m-0 p-0 border-none">
        <div class="text-center p-0">
            <label class="pc_pmt">5%</label>
            <p class="title_pmt mt-0"><B>GARANTA JÁ SEU CUPOM DE DESCONTO!</B></p>
            <label class="Obs3">Depois use o cupom em algum produto ou serviço a sua escolha!</label>
        </div>
    </div>
    <div class="col-md-6 border-none">
        <div class="text-center p-3">
            <p class="title2_pmt mt-2 mb-0">BASTA CURTIR E COMPARTILHAR A NOSSA PÁGINA:</p>
            <div class="form-row">
                <div class="col text-left">
                    <div class="row">
                        <div class="col text-center">
                            <button id="likeBtn" class="btn btn-primary btnshade shadow mr-1 mt-2 pr-3 pl-3"><i id="white" class="far fa-thumbs-up"></i></button>
                            <button id="shareBtn" class="btn btn-primary btnshade shadow mb-3 mt-4" onclick="share('<?php echo 'https://zenit.games/priston/'?>')">
                                <i id="white" class="fab fa-facebook-square mr-2"></i><b>Compartilhar</b>
                            </button>
                            <label class="Obs3">Se ja curtiu apenas compartilhe, após a sua ação o botão de gerar cupons será liberado!</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col pt-2 pb-2 text-center">
                            <form action="?a=promocoes" method="POST">
                                <label id="lbl" class="title2_pmt" style="color: rgb(110,39,43); opacity: 0.7;"><b>INSIRA SEU NOME:</b></label>
                                <input id="nmc" class="form-control shadow mr-2" type="text" name="nm_customer" disabled="true" placeholder="Primeiro compartilhe para ativar os controles" required>
                                <button id="gcp" class="btn btn-danger mt-2 shadow" style="background-color: rgb(110,39,43); border: none;" disabled="true"><b>GERAR CUPOM</b><i class="fas fa-hourglass-start ml-2"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>