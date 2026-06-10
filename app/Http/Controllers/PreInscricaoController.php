<?php

namespace App\Http\Controllers;

use App\Models\Responsavel;
use App\Models\Crianca;
use App\Notifications\PreInscricaoRecebidaNotification;
use App\Notifications\NovaInscricaoAdminNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class PreInscricaoController extends Controller
{
    /**
     * Exibe o formulário de pré-inscrição.
     */
    public function index()
    {
        return view('pre_inscricao');
    }

    /**
     * Processa o envio do formulário.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            // Dados da Criança
            'crianca_nome' => 'required|string|max:255',
            'crianca_idade' => 'required|integer|between:6,11',
            'crianca_escola' => 'required|string|max:255',
            'crianca_serie' => 'required|string|max:100',
            'crianca_periodo' => 'required|in:Manhã,Tarde,Não sei',
            'crianca_periodo_ong' => 'required|in:Manhã,Tarde',
            
            // Dados do Responsável
            'responsavel_nome' => 'required|string|max:255',
            'responsavel_email' => 'required|email|max:255',
            'responsavel_telefone' => 'required|string|max:20',
            'responsavel_telefone_secundario' => 'nullable|string|max:20',
            'acesso_local' => 'required|in:Fácil,Médio,Difícil',
            'consentimento_lgpd' => 'required|accepted',
        ]);

        try {
            DB::beginTransaction();

            // 1. Criar ou atualizar o responsável (baseado no email)
            $responsavel = Responsavel::updateOrCreate(
                ['email' => $validated['responsavel_email']],
                [
                    'nome' => $validated['responsavel_nome'],
                    'telefone' => $validated['responsavel_telefone'],
                    'telefone_secundario' => $validated['responsavel_telefone_secundario'] ?? null,
                    'acesso_local' => $validated['acesso_local'],
                    'consentimento_lgpd' => true,
                    'data_consentimento' => now(),
                ]
            );

            // 2. Criar a criança vinculada ao responsável
            $crianca = Crianca::create([
                'responsavel_id' => $responsavel->id,
                'nome' => $validated['crianca_nome'],
                'data_nascimento' => now()->subYears($validated['crianca_idade'])->format('Y-01-01'), // Data aproximada (1º de Jan do ano calculado)
                'idade' => $validated['crianca_idade'],
                'escola' => $validated['crianca_escola'],
                'serie' => $validated['crianca_serie'],
                'periodo_escolar' => $validated['crianca_periodo'] ?? 'Não sei',
                'periodo_ong' => $validated['crianca_periodo_ong'],
                'data_inscricao' => now(),
                'status' => 'PREENCHER',
            ]);

            DB::commit();

            // Disparar notificações por e-mail
            // 1. Notifica o responsável
            try {
                $responsavel->notify(new PreInscricaoRecebidaNotification($crianca->nome));
            } catch (\Exception $e) {
                Log::warning('Falha ao enviar e-mail para o responsável: ' . $e->getMessage());
            }

            // 2. Notifica o dono da ONG
            try {
                Notification::route('mail', 'EMAIL@gmail.com')
                    ->notify(new NovaInscricaoAdminNotification($crianca, $responsavel));
            } catch (\Exception $e) {
                Log::warning('Falha ao enviar e-mail para o administrador: ' . $e->getMessage());
            }

            return redirect()->back()->with('success', 'Pré-inscrição enviada com sucesso! Entraremos em contato em breve.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao salvar pré-inscrição: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Ocorreu um erro ao processar sua inscrição. Por favor, tente novamente.'])->withInput();
        }
    }
}
