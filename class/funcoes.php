<?php
    // ==========================================================
    // FUNÇÕES ESTATICAS
    // ==========================================================

    //verificar a sessão.
    if(!isset($_SESSION['a'])){
        exit();
    }

    // ==================== FUNÇÕES =============================
    class funcoes{

        public static function VerificarLogin(){
            //verifica se o utilizador tem sessão ativa
            $resultado = false;
            if(isset($_SESSION['cd_login'])){
                $resultado = true;
            }
            return $resultado;
        }

        public static function IniciarSessao($dados){
            //iniciar a sessão
            $_SESSION['cd_user'] = $dados[0]['cd_user'];
            $_SESSION['cd_login'] = $dados[0]['cd_login'];
            $_SESSION['nm_user'] = $dados[0]['nm_user'];
            $_SESSION['cd_permition'] = $dados[0]['cd_permition'];
            $_SESSION['ds_email'] = $dados[0]['ds_email'];
        }

        public static function DestroiSessao(){
            //Abandona uma Sessão ativa
            unset($_SESSION['cd_user']);
            unset($_SESSION['cd_login']);
            unset($_SESSION['nm_user']);
            unset($_SESSION['cd_permition']);
            unset($_SESSION['ds_email']);
        }

        public static function CriarCodigoAlfanumerico($numChars){
            //Gera uma senha randomica para recuperação do password
            $codigo = '';
            $caracteres = 'abcdefghijlmnopqrstuvxywzABCDEFGHIJLMNOPQRSTUVXYWZ0123456789';
            for($i = 0; $i < $numChars; $i++){
                $codigo .= substr($caracteres, rand(0, strlen($caracteres)) ,1);
            }
            return $codigo;
        }

        public static function FormataTelefone($number){
            $number="(".substr($number,0,2).") ".substr($number,2,-4)."-".substr($number,-4);
            // primeiro substr pega apenas o DDD e coloca dentro do (), segundo subtr pega os números do 3º até faltar 4, insere o hifem, e o ultimo pega apenas o 4 ultimos digitos
            return $number;
        }
        
        public static function CriarLOG($mensagem, $utilizador){
            //cria um registo em LOGS
            $gestor = new cl_gestorBD();
            $data_hora = new DateTime();
            $parametros = [
                ':dt_hour'        => $data_hora->format('Y-m-d H:i:s'),
                ':cd_login'       => $utilizador,
                ':ds_message'     => $mensagem
            ];
            $gestor->EXE_NON_QUERY(
                'INSERT INTO tab_log(dt_hour, cd_login, ds_message)
                 VALUES(:dt_hour, :cd_login, :ds_message)', $parametros);
        }

        public static function Permissao($index){
            //Verifica se o utilizador com sessão ativa tem permissão para determinada funcionalidade
            if(substr($_SESSION['cd_permition'], $index, 1) == 1){
                return true;
            }
            else{
                return false;
            }
        }

        public static function Paginacao($source, $pagina_atual, $itens_por_pagina, $total_itens){
            //Criar e controlar o mecanismo de paginação e navegação
            $max_paginas = floor($total_itens/$itens_por_pagina);

            echo '<div>';
                //pagina anterior
                if($pagina_atual == 1){
                    echo 'Anterior';
                } else{
                    echo '<a href="'.$source.'&p='.($pagina_atual-1).'">Anterior</a>';
                }

                echo " | ";

                //proxima pagina
                if($pagina_atual == $max_paginas){
                    echo 'Próxima';
                } else{
                    echo '<a href="'.$source.'&p='.($pagina_atual+1).'">Próxima</a>';
                }
            echo '</div>';
        }

    }
?>