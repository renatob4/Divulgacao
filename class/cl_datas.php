<?php
    // ==========================================================
    // CLASSE PARA TRATAMENTO DE DATAS
    // ==========================================================
    class DATAS
    {
        public static function DataHoraAtualBD()
        {
            //retorna a data e hora atual compativeis com MySQL.
            $data = new DateTime();
            return $data->format('Y-m-d H:i:s');
        }
    }
?>