<?php 
// ========================================
// setup - inserir conteúdo do site
// ========================================

// verificar a sessão
if(!isset($_SESSION['a'])){
    exit();
} 

$gestor = new cl_gestorBD();

//limpar os dados dos utilizadores
$gestor->EXE_NON_QUERY('DELETE FROM tab_content');
$gestor->EXE_NON_QUERY('DELETE FROM tab_link');
$gestor->EXE_NON_QUERY('DELETE FROM tab_card');
$gestor->EXE_NON_QUERY('DELETE FROM tab_adress');
$gestor->EXE_NON_QUERY('DELETE FROM tab_activity');
$gestor->EXE_NON_QUERY('DELETE FROM tab_card');
$gestor->EXE_NON_QUERY('DELETE FROM tab_imagem');
$gestor->EXE_NON_QUERY('DELETE FROM tab_code');
$gestor->EXE_NON_QUERY('DELETE FROM tab_config');

$gestor->EXE_NON_QUERY('ALTER TABLE tab_content AUTO_INCREMENT = 1');
$gestor->EXE_NON_QUERY('ALTER TABLE tab_link AUTO_INCREMENT = 1');
$gestor->EXE_NON_QUERY('ALTER TABLE tab_card AUTO_INCREMENT = 1');
$gestor->EXE_NON_QUERY('ALTER TABLE tab_adress AUTO_INCREMENT = 1');
$gestor->EXE_NON_QUERY('ALTER TABLE tab_activity AUTO_INCREMENT = 1');
$gestor->EXE_NON_QUERY('ALTER TABLE tab_card AUTO_INCREMENT = 1');
$gestor->EXE_NON_QUERY('ALTER TABLE tab_imagem AUTO_INCREMENT = 1');
$gestor->EXE_NON_QUERY('ALTER TABLE tab_code AUTO_INCREMENT = 1');
$gestor->EXE_NON_QUERY('ALTER TABLE tab_config AUTO_INCREMENT = 1');

$data = new DateTime();

//--------------------------------------------------------------------------------- TABELA tab_content

//definição de parametros/dados
$parametros = [
    ':nm_company'           => 'Empresa',
    ':ds_presentation'      => 'Coloque aqui uma descrição breve sobre o negócio/empresa, seu ramo de atividade, seus produtos ou serviços, seus objetivos, o foco, os diferenciais ou o que tem a oferecer de bom para o mundo. Também é interessante conter um pouco da história da empresa no mercado ou algo que convide o consumidor a conhecer mais sobre o negocio ou entrar em contato. Palavras chaves e frases de impacto também são super bem vindas e por fim, insira uma imagem a seu gosto para ilustrar sua apresentação ou remova a imagem padrão welcome e deixe so o texto, é por sua conta. Seja criativo e Boa divulgação!.',
    ':ds_email'             => 'empresa@contato.com',
    ':ds_document'          => '00.000.000/0001-12',
    ':cd_phone_1'           => '0000000000',
    ':cd_phone_2'           => '0000000000',
    ':ds_text_footer'       => 'Texto que fica exposto no rodapé, também pode conter o slogan da empresa, um convite ou agradecimento.',
    ':lnk_map'              => '',
    ':dt_register'          => $data->format('Y-m-d H:i:s'),
    ':dt_updated'           => $data->format('Y-m-d H:i:s')
];

//inserir o conteúdo
$gestor->EXE_NON_QUERY(
    'INSERT INTO tab_content(nm_company, ds_presentation, ds_email, ds_document, cd_phone_1, cd_phone_2, ds_text_footer, lnk_map, dt_register, dt_updated)
     VALUES(:nm_company, :ds_presentation, :ds_email, :ds_document, :cd_phone_1, :cd_phone_2, :ds_text_footer, :lnk_map, :dt_register, :dt_updated)', $parametros);

//--------------------------------------------------------------------------------- TABELA TAB_LINK

//definição de parametros/dados
$parametros = [
    ':ds_link_face'         => 'https://www.facebook.com/',
    ':ds_link_twit'         => 'https://twitter.com/login?lang=pt',
    ':ds_link_linked'       => 'https://br.linkedin.com/',
    ':ds_link_insta'        => 'https://www.instagram.com/',
    ':ds_link_olx'          => '',
    ':ds_link_market'       => '',
    ':dt_register'          => $data->format('Y-m-d H:i:s'),
    ':dt_updated'           => $data->format('Y-m-d H:i:s')
];

//inserir os links
$gestor->EXE_NON_QUERY(
    'INSERT INTO tab_link(ds_link_face, ds_link_twit, ds_link_linked, ds_link_insta, ds_link_olx, ds_link_market, dt_register, dt_updated)
     VALUES(:ds_link_face, :ds_link_twit, :ds_link_linked, :ds_link_insta, :ds_link_olx, :ds_link_market, :dt_register, :dt_updated)', $parametros);

//--------------------------------------------------------------------------------- TABELA TAB_ADRESS

//definição de parametros/dados
$parametros = [
    ':ds_adress'            => '',
    ':ds_city'              => '',
    ':cd_uf'                => '',
    ':dt_register'          => $data->format('Y-m-d H:i:s'),
    ':dt_updated'           => $data->format('Y-m-d H:i:s')
];

//inserir os links
$gestor->EXE_NON_QUERY(
    'INSERT INTO tab_adress(ds_adress, ds_city, cd_uf, dt_register, dt_updated)
     VALUES(:ds_adress, :ds_city, :cd_uf, :dt_register, :dt_updated)', $parametros);

//--------------------------------------------------------------------------------- TABELA TAB_ACTIVITY

//definição de parametros/dados
$parametros = [
    ':ds_activity'          => '',
    ':dt_register'          => $data->format('Y-m-d H:i:s'),
    ':dt_updated'           => $data->format('Y-m-d H:i:s')
];

//inserir os links
$gestor->EXE_NON_QUERY(
    'INSERT INTO tab_activity(ds_activity, dt_register, dt_updated)
     VALUES(:ds_activity, :dt_register, :dt_updated)', $parametros);

//--------------------------------------------------------------------------------- TABELA TAB_CARD

//inserir os cards (Especificamente 3 como conteudo padrão.)
for($i = 0; $i < 3; $i++){
    //definição de parametros/dados
    $parametros = [
        ':ds_title'             =>  'Título do Card ',
        ':ds_content'           =>  'Aqui ficam expostas noticias, atualizações, promoções ou avisos importantes que precisem ficar destacados.',
        ':img_card'             =>  '',
        ':dt_register'          =>  $data->format('Y-m-d H:i:s'),
        ':dt_updated'           =>  $data->format('Y-m-d H:i:s')
    ];
    //Inserçao do card na tabela tab_card
    $gestor->EXE_NON_QUERY(
        'INSERT INTO tab_card(ds_title, ds_content, img_card, dt_register, dt_updated)
        VALUES(:ds_title, :ds_content, :img_card, :dt_register, :dt_updated)', $parametros);
}

//--------------------------------------------------------------------------------- TABELA TAB_IMAGEM

$parametros = [
    ':img_header'           => 'images/logo.png',
    ':img_panel'            => 'images/panel.jpg',
    ':img_body'             => '',
    ':dt_register'          => $data->format('Y-m-d H:i:s'),
    ':dt_updated'           => $data->format('Y-m-d H:i:s')
];

//inserir as imagens do conteudo
$gestor->EXE_NON_QUERY('INSERT INTO tab_imagem(img_header, img_panel, img_body, dt_register, dt_updated) 
                        VALUES(:img_header, :img_panel, :img_body, :dt_register ,:dt_updated)', $parametros);

//--------------------------------------------------------------------------------- TABELA TAB_CODE

$parametros = [
    ':lnk_script'          => "<div id='fb-root'></div> <script>(function(d, s, id) {   var js, fjs = d.getElementsByTagName(s)[0];   if (d.getElementById(id)) return;   js = d.createElement(s); js.id = id;   js.src = 'https://connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v3.2';   fjs.parentNode.insertBefore(js, fjs); }(document, 'script', 'facebook-jssdk'));</script>",
    ':dt_updated'          => $data->format('Y-m-d H:i:s')
];

//inserir as imagens do conteudo
$gestor->EXE_NON_QUERY('INSERT INTO tab_code(lnk_script, dt_updated) 
                        VALUES(:lnk_script,:dt_updated)', $parametros);

//--------------------------------------------------------------------------------- TABELA TAB_CONFIG

$parametros = [
    ':st_contact'           => 1,
    ':st_service'           => 1,
    ':st_product'           => 1,
    ':st_adress'            => 1,
    ':st_activity'          => 1,
    ':st_comment'           => 1,
    ':st_fbpage'            => 1,
    ':st_map'               => 1,
    ':st_document'          => 1,
    ':st_card'              => 1,
    ':st_post'              => 1,
    ':sp_relevance'         => 1,
    ':sp_amount'            => 10,
    ':ss_relevance'         => 1,
    ':ss_amount'            => 10,
    ':dt_register'          => $data->format('Y-m-d H:i:s'),
    ':dt_updated'           => $data->format('Y-m-d H:i:s')
];

//inserir as imagens do conteudo
$gestor->EXE_NON_QUERY('INSERT INTO tab_config(st_contact, st_service, st_product, st_adress, st_activity, st_comment, st_fbpage, st_map, st_document, st_card, st_post, sp_relevance, sp_amount, ss_relevance, ss_amount, dt_register, dt_updated)
                        VALUES(:st_contact, :st_service, :st_product, :st_adress, :st_activity, :st_comment, :st_fbpage, :st_map, :st_document, :st_card, :st_post, :sp_relevance, :sp_amount, :ss_relevance, :ss_amount, :dt_register, :dt_updated)', $parametros);

?>
<div class="alert alert-success text-center mt-2 mb-2">Conteúdo inserido com sucesso.</div>