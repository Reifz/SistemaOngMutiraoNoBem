<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Data de Virada do Ano Letivo
    |--------------------------------------------------------------------------
    |
    | Esta data define quando o sistema deve incrementar automaticamente a 
    | série escolar das crianças. O formato deve ser 'MM-DD'.
    | Padrão: '01-01' (1º de Janeiro).
    |
    */
    'data_virada_ano_letivo' => env('DATA_VIRADA_ANO_LETIVO', '01-01'),
];
