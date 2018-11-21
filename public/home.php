<?php

    //Código

    //verificar a sessão.
    if(!isset($_SESSION['a'])){
        exit();
    }

    
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

        <!-- Sessão especial texto -->
         <!-- <div class="row">
            <div class="col-xs-6 col-xs-offset-3 text-center espaco-services mt-2 pb-0">
                <h1>SPECIAL SERVICES</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quas sunt accusamus modi, neque nobis nemo sed illum magnam distinctio fuga saepe assumenda.</p>
            </div>
         </div> -->

        <!-- Apresentação -->
        <hr>
            <div class="row m-1">
                <div class="col-md-8 p-0">
                    <div class="text-center p-4">
                        <h4 class="mb-3">Apresentação</h4>
                        Do occaecat officia irure aliquip sint esse. In nulla eu ullamco cupidatat aliqua laboris aliquip quis 
                        excepteur amet laboris eiusmod aute quis. Aute tempor et et laboris reprehenderit Lorem enim reprehenderit.
                        Aute ut excepteur minim in. Et quis proident ad mollit eiusmod id dolore sint non. 
                        Officia magna tempor quis cillum reprehenderit do. Laborum Lorem excepteur quis adipisicing laboris deserunt laboris esse laborum ex reprehenderit sit anim commodo.
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



