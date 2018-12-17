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
$gestor->EXE_NON_QUERY('ALTER TABLE tab_content AUTO_INCREMENT = 1');
$gestor->EXE_NON_QUERY('ALTER TABLE tab_link AUTO_INCREMENT = 1');
$gestor->EXE_NON_QUERY('ALTER TABLE tab_card AUTO_INCREMENT = 1');

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

//--------------------------------------------------------------------------------- TABELA TAB_CARD

//inserir os cards (Especificamente 3 como conteudo padrão.)
for($i = 0; $i < 3; $i++){
    //definição de parametros/dados
    $parametros = [
        ':ds_title'             =>  'Título do Card ',
        ':ds_content'           =>  'Aqui ficam expostas noticias, atualizações, promoções ou avisos importantes que precisem ficar destacados.',
        ':dt_register'          =>  $data->format('Y-m-d H:i:s'),
        ':dt_updated'           =>  $data->format('Y-m-d H:i:s')
    ];
    //Inserçao do card na tabela tab_card
    $gestor->EXE_NON_QUERY(
        'INSERT INTO tab_card(ds_title, ds_content, dt_register, dt_updated)
        VALUES(:ds_title, :ds_content, :dt_register, :dt_updated)', $parametros);
}

//--------------------------------------------------------------------------------- TABELA TAB_IMAGEM

$parametros = [
    ':img_header'           => 'images/logo.png',
    ':img_panel'            => 'images/panel.jpg',
    ':img_body'             => 'images/welcome.jpg',
    ':dt_updated'           => $data->format('Y-m-d H:i:s')
];

//inserir as imagens do conteudo
$gestor->EXE_NON_QUERY('INSERT INTO tab_imagem(img_header, img_panel, img_body, dt_updated) 
                        VALUES(:img_header, :img_panel, :img_body, :dt_updated)', $parametros);

//--------------------------------------------------------------------------------- TABELA TAB_CONFIG

$parametros = [
    ':st_contact'           => 1,
    ':st_map'               => 1,
    ':st_document'          => 1,
    ':st_card'              => 1,
    ':st_post'              => 1,
    ':dt_updated'           => $data->format('Y-m-d H:i:s')
];

//inserir as imagens do conteudo
$gestor->EXE_NON_QUERY('INSERT INTO tab_config(st_contact, st_map, st_document, st_card, st_post, dt_updated) 
                        VALUES(:st_contact, :st_map, :st_document, :st_card, :st_post, :dt_updated)', $parametros);

?>
<div class="alert alert-success text-center mt-2 mb-2">Conteúdo inserido com sucesso.</div>