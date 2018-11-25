<?php 
// ========================================
// setup - inserir utilizadores
// ========================================
// verificar a sessão
if(!isset($_SESSION['a'])){
    exit();
} 

//inserir o utilizador admin
$gestor = new cl_gestorBD();
//limpar os dados dos utilizadores
$gestor->EXE_NON_QUERY('DELETE FROM tab_user');
$gestor->EXE_NON_QUERY('ALTER TABLE tab_user AUTO_INCREMENT = 1');
$data = new DateTime();

//--------------------------------------------------------- utilizador 1 - admin

//definição de parametros
$parametros = [
    ':cd_login'       => 'admin',
    ':cd_password'    => md5('admin'),
    ':nm_user'        => 'Administrador',
    ':ds_email'       => 'rrcosta94@gmail.com',
    ':cd_permition'   => str_repeat('1', 32),
    ':dt_register'    => $data->format('Y-m-d H:i:s'),
    ':dt_updated'     => $data->format('Y-m-d H:i:s')
];

//inserir o admin
$gestor->EXE_NON_QUERY(
    'INSERT INTO tab_user(cd_login, cd_password, nm_user, ds_email, cd_permition, dt_register, dt_updated)
     VALUES(:cd_login, :cd_password, :nm_user, :ds_email, :cd_permition, :dt_register, :dt_updated)', $parametros);


//--------------------------------------------------------- utilizador 2 - Ana

//definição de parametros
$parametros = [
    ':cd_login'       => 'Ana',
    ':cd_password'    => md5('ana'),
    ':nm_user'        => 'Ana Oliveira',
    ':ds_email'       => 'ana.oliveira@gmail.com',
    ':cd_permition'   => '0'.str_repeat('1', 31),
    ':dt_register'    => $data->format('Y-m-d H:i:s'),
    ':dt_updated'     => $data->format('Y-m-d H:i:s')
];

//inserir o socio
$gestor->EXE_NON_QUERY(
    'INSERT INTO tab_user(cd_login, cd_password, nm_user, ds_email, cd_permition, dt_register, dt_updated)
     VALUES(:cd_login, :cd_password, :nm_user, :ds_email, :cd_permition, :dt_register, :dt_updated)', $parametros);

?>

<div class="alert alert-success text-center mt-2 mb-2">Utilizadores inseridos com sucesso.</div>