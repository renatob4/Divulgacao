<?php
    // ==========================================================
    // PROSPECTS
    // ==========================================================

    //verificar a sessão.
    if (!isset($_SESSION['a'])) {
        exit();
    }

    //Vai buscar todas as informações do utilizador
    $gestor = new cl_gestorBD();

    //Verifica se foi definida clear
    if(isset($_GET['clear'])){
        if(isset($_SESSION['texto_pesquisa'])){
            unset($_SESSION['texto_pesquisa']);
        }
    }

    //Veficica se ocorreu um POST
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if($_POST['text_pesquisa'] != ''){
            $_SESSION['texto_pesquisa'] = $_POST['text_pesquisa'];
        }
    }

    //carregar os dados dos clientes
    $prospects = null;
    //paginação
    $total_clientes = 0;
    $pagina = 1;

    if(isset($_GET['p'])){
        $pagina = $_GET['p'];
    }

    $itens_por_pagina = 10;
    $item_inicial = ($pagina * $itens_por_pagina) - $itens_por_pagina;

    if(isset($_SESSION['texto_pesquisa'])){
        //Pesquisa com filtro       
        $parametros = ['pesquisa'   =>  '%'.$_SESSION['texto_pesquisa'].'%'];

        $prospects = $gestor->EXE_QUERY('SELECT * FROM tab_prospect 
                                        WHERE nm_prospect LIKE :pesquisa 
                                        OR ds_email LIKE :pesquisa 
                                        ORDER BY nm_prospect ASC 
                                        LIMIT '.$item_inicial.','.$itens_por_pagina, $parametros);

        $total_clientes = count($gestor->EXE_QUERY('SELECT * FROM tab_prospect WHERE nm_prospect LIKE :pesquisa OR ds_email LIKE :pesquisa ORDER BY nm_prospect ASC', $parametros));

    } else {
        //Pesquisa sem filtro       
         $prospects = $gestor->EXE_QUERY('SELECT * FROM tab_prospect ORDER By dt_register ASC LIMIT '.$item_inicial.','.$itens_por_pagina);
         $total_clientes = count($gestor->EXE_QUERY('SELECT * FROM tab_prospect'));
    }

?>
<div class="row mr-1 ml-1 mt-2 borda-painel shadow-strong">
    <div class="col p-0">
        <div class="card p-0">
            <div class="pr-3 pl-3 pt-3 p-0 m-0">
                <div class="text-center">
                    <h5 id="green">CLIENTES PROSPECTS</h5><hr>
                    <p>Clientes prospects são aquelas pessoas que de alguma forma ja demonstram interesse em manter um relacionamento com a sua empresa.
                    Neste caso em particular os clientes que enviaram mensagem para o seu email através do site e tiveram seus dados capturados para futuras ações de marketing, mala direta, dentre outros.</p>
                </div>
                <label id="grey" class="table-padding">Obs. Aconcelhavel consultar a tabela em um computador ou tela maior do que um smartphone.</label>
            </div>
            <div class="pt-0 table-padding m-0">
                <nav class="navbar navbar-light line shadow borda-b">
                    <a class="navbar-brand"><h6 class="ml-0 mt-3 p-0">POSSÍVEIS CLIENTES: <label id="grey"><?php echo $total_clientes?> <?php echo $total_clientes > 1 ? 'Prospects' : 'Prospect'; ?></label></h6></a>
                    <form class="form-inline text-right p-0 m-0" action="?a=prospects" method="post">
                        <input type="search" class="form-control mr-sm-2 borda-text largura" name="text_pesquisa" placeholder="Pesquisar" value="<?php echo (isset($_SESSION['texto_pesquisa'])) ? $_SESSION['texto_pesquisa'] : ''; ?>">
                        <button class="btn btn-primary p-2 text-center mt-2 mb-2"><i class="fa fa-search" aria-hodden="true"></i></button>
                        <a href="?a=prospects&clear=true" class="btn btn-secondary text-center ml-1 p-2"><i class="fa fa-times" aria-hodden="true"></i></a>
                    </form>
                </nav>
                <!--Inicio da tabela-->
                <div class="table-responsive ml-0 mr-0 shadow mb-2 borda-b">
                    <table class="table table-striped table-bordered table-hover borda mb-0">
                        <!--Cabeçalho da tabela-->
                        <thead class="thead-dark">
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Contato</th>
                            <th>Pesquisa</th>
                            <th>Data do contato</th>
                        </thead>
                        <!--Corpo/Dados da tabela-->
                            <?php foreach ($prospects as $prospect) : ?>
                            <tr>
                                <td><?php echo $prospect['nm_prospect']?></a></td>
                                <td><a href="mailto:<?php echo $prospect['ds_email'] ?>"><?php echo $prospect['ds_email'] ?></a></td>
                                <td><?php echo $prospect['cd_phone']?></td>
                                <td><?php echo $prospect['ds_channel']?></td>
                                <td><?php echo $prospect['dt_register']?></td>
                            </tr>
                            <?php endforeach; ?>    
                    </table>
                </div>

                <div class="row mt-0 mb-3 mr-1 ml-1">
                    <!--Pagina Atual-->
                    <div class="col-sm-6 text-left">
                        <label style="opacity: 0.5"><?php echo 'Pagina: ' . $pagina ?></label>
                    </div>
                    <!--Mecanismo de paginação-->
                    <div class="col-sm-6 text-right">
                        <?php funcoes::Paginacao('?a=prospects', $pagina, $itens_por_pagina, $total_clientes) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>