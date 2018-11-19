<?php 
// ==========================================================
// SEM PERMISSAO
// ==========================================================

//verificar a sessão.
if(!isset($_SESSION['a'])){
    exit();
}

?>

<div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-6 card m-3 p-3">
                <div class="text-center">
                    <h1> <i class="fa fa-exclamation-triangle" style="color: red" aria-hidden="true"></i> </h1>
                    <p class="text-center">Necessaria permissão de administrador para acessar essa funcionalidade.</p>
                    <a href="?a=home" class="btn btn-primary btn-size-150">Voltar</a> 
                </div>
            </div>        
        </div>
</div>