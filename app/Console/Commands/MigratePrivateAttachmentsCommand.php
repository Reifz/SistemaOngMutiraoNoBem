<?php

namespace App\Console\Commands;

use App\Models\Crianca;
use App\Models\Responsavel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class MigratePrivateAttachmentsCommand extends Command
{
    protected $signature = 'lgpd:migrate-private-attachments {--execute : Copia, verifica e remove os arquivos do disco público}';

    protected $description = 'Localiza anexos legados públicos e os migra para o armazenamento privado';

    private int $found = 0;
    private int $migrated = 0;
    private int $missing = 0;

    public function handle(): int
    {
        $execute = (bool) $this->option('execute');

        Crianca::query()->select(['id', ...$this->childFields()])->chunkById(100, function ($children) use ($execute) {
            foreach ($children as $child) {
                foreach ($this->childFields() as $field) {
                    $this->processPath($child->{$field}, "criancas:{$child->id}:{$field}", $execute);
                }
            }
        });

        Responsavel::query()->select(['id', 'anexo_rg'])->chunkById(100, function ($guardians) use ($execute) {
            foreach ($guardians as $guardian) {
                $this->processPath($guardian->anexo_rg, "responsaveis:{$guardian->id}:anexo_rg", $execute);
            }
        });

        $this->table(['Encontrados', 'Migrados', 'Referências sem arquivo'], [[
            $this->found,
            $this->migrated,
            $this->missing,
        ]]);

        if (!$execute) {
            $this->warn('Simulação concluída. Execute novamente com --execute após revisar o resultado e confirmar o backup.');
        }

        return self::SUCCESS;
    }

    private function processPath(?string $path, string $reference, bool $execute): void
    {
        if (!$path) {
            return;
        }

        if (Storage::disk('local')->exists($path)) {
            return;
        }

        if (!Storage::disk('public')->exists($path)) {
            $this->missing++;
            $this->error("Arquivo ausente: {$reference}");
            return;
        }

        $this->found++;
        $this->line(($execute ? 'Migrando' : 'Migraria').": {$reference}");

        if (!$execute) {
            return;
        }

        $contents = Storage::disk('public')->get($path);
        if (!Storage::disk('local')->put($path, $contents)) {
            throw new RuntimeException("Falha ao gravar arquivo privado: {$reference}");
        }

        if (Storage::disk('local')->size($path) !== Storage::disk('public')->size($path)) {
            Storage::disk('local')->delete($path);
            throw new RuntimeException("A verificação de tamanho falhou: {$reference}");
        }

        Storage::disk('public')->delete($path);
        $this->migrated++;
    }

    private function childFields(): array
    {
        return [
            'anexo_certidao',
            'anexo_excel_matricula',
            'anexo_rg',
            'anexo_cpf',
            'anexo_comprovante_residencia',
            'anexo_comprovante_escolaridade',
            'anexo_comprovante_renda',
        ];
    }
}
