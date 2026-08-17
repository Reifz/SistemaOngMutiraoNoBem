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

    /*
    |--------------------------------------------------------------------------
    | E-mail do Administrador da ONG
    |--------------------------------------------------------------------------
    |
    | Endereço que recebe a notificação de cada nova pré-inscrição pública.
    | Se vazio, a notificação ao administrador não é enviada.
    |
    */
    'admin_email' => env('MUTIRAO_ADMIN_EMAIL'),

    /*
    |--------------------------------------------------------------------------
    | Versão da Aplicação
    |--------------------------------------------------------------------------
    |
    | Lida do arquivo VERSION gerado no build/deploy (git describe ou release
    | do CI). Congelada pelo config:cache em produção. "dev" quando ausente.
    |
    */
    'versao' => trim((string) @file_get_contents(base_path('VERSION'))) ?: 'dev',
];
