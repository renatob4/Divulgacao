<?php
    //verificar a sessão.
    if(!isset($_SESSION['a'])){
        exit();
    }

    //Instancia do banco de dados.
    $acesso = new cl_gestorBD();
    //busca o conteúdo da pagina no banco de dados.
    $conteudo = $acesso->EXE_QUERY('SELECT * FROM tab_content');
?>
<!-- ________________________________________________________CONTEÚDO DA PAGINA INICIAL__________________________________________________________ -->

        <!-- Barra divisoria branca -->
        <div class="row barra-branca"></div>
        <!-- Imagem Painel -->
        <div class="row">
            <div class="imagem-painel">
                <div class="posicao-botao">
                    <button class="btn btn-primary botao">Call to Action!</button>
                </div>
            </div>
        </div>

        <!-- Nome da empresa e slogan -->
         <!-- <div class="row">
            <div class="col-xs-6 col-xs-offset-3 text-center espaco-services mt-2 pb-0">
                <h1><?php //echo $conteudo[0]['nm_company']?></h1>
                <p><?php //echo $conteudo[0]['ds_slogan']?></p>
            </div>
         </div> -->

        <!-- Apresentação da empresa, texto. -->
        <hr>
            <div class="row m-1">
                <div class="col-md-8 p-0">
                    <div class="text-center p-4">
                        <h4 class="mb-3">Apresentação</h4>
                        <!-- Dados contidos no campo 'ds_presentation' do banco de dados -->
                        <?php echo $conteudo[0]['ds_presentation']?>
                    </div>
                </div>

                <div class="col-md-4 p-0">
                    <div class="card painel-direito text-center p-4 ml-3">
                        <h4 id="black"><i class="fas fa-phone-square mr-2 "></i>Fale conosco:</h4><hr>
                        <h5>Telefone: (13)3594-5439</h5>
                        <h5>WhatsApp: (13)98195-7691</h5><hr>
                        <p id="black">Ou envie um e-mail direto <a href="?a=contatos">Aqui</a></p>
                    </div>
                </div>
            </div>
        <hr>

        <!-- Cards de texto -->
        <div class="row">
                <!-- Coluna 1-->
                <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="panel panel-default text-center espaco-paineis">
                    <p class="titulo-painel">APP DESIGN</p>
                    <p>Irure enim ipsum ullamco ut sint exercitation consectetur et do nostrud. Amet minim cupidatat nostrud Lorem laboris eu in sit ad dolore. Incididunt mollit anim aliqua nisi pariatur proident ad qui nulla.</p>
                    <button class="btn btn-primary">Mais informações</button>
                    </div>              
                </div>
                <!-- Coluna 2-->
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="panel panel-default text-center espaco-paineis">
                        <p class="titulo-painel">WEB DESIGN</p>
                        <p>Irure enim ipsum ullamco ut sint exercitation consectetur et do nostrud. Amet minim cupidatat nostrud Lorem laboris eu in sit ad dolore. Incididunt mollit anim aliqua nisi pariatur proident ad qui nulla.</p>
                        <button class="btn btn-primary">Mais informações</button>
                    </div>              
                </div>
                <!-- Coluna 3-->
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="panel panel-default text-center espaco-paineis">
                        <p class="titulo-painel">GRAPHICS DESIGN</p>
                        <p>Irure enim ipsum ullamco ut sint exercitation consectetur et do nostrud. Amet minim cupidatat nostrud Lorem laboris eu in sit ad dolore. Incididunt mollit anim aliqua nisi pariatur proident ad qui nulla.</p>
                        <button class="btn btn-primary">Mais informações</button>
                    </div>              
                </div>   
        </div>

<!-- ______________________________________________________________________________________________________________________________________ -->



