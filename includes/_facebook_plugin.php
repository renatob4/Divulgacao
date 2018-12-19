<?php
    include_once('./class/gestorBD.php');
    $gestor = new cl_gestorBD();
    $conteudo = $gestor->EXE_QUERY('SELECT lnk_script FROM tab_content');
?>
<?php echo $conteudo[0]['lnk_script']?>
<!-- <div id="fb-root"></div>
<script>(function(d, s, id) {
var js, fjs = d.getElementsByTagName(s)[0];
if (d.getElementById(id)) return;
js = d.createElement(s); js.id = id;
js.src = 'https://connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v3.2';
fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script> -->