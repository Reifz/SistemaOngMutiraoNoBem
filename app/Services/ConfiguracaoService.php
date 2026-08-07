<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class ConfiguracaoService
{
    protected static $filePath = 'configuracoes.json';

    /**
     * Obtém um valor de configuração pelo nome da chave.
     */
    public static function get(string $key, $default = null)
    {
        if (!Storage::disk('local')->exists(self::$filePath)) {
            return $default;
        }

        $config = json_decode(Storage::disk('local')->get(self::$filePath), true);

        if (!is_array($config)) {
            return $default;
        }

        return $config[$key] ?? $default;
    }

    /**
     * Salva ou atualiza um valor de configuração.
     */
    public static function set(string $key, $value): void
    {
        $config = [];
        if (Storage::disk('local')->exists(self::$filePath)) {
            $decoded = json_decode(Storage::disk('local')->get(self::$filePath), true);
            if (is_array($decoded)) {
                $config = $decoded;
            }
        }

        $config[$key] = $value;

        Storage::disk('local')->put(self::$filePath, json_encode($config, JSON_PRETTY_PRINT));
    }
}
