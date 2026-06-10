<?php

namespace App\Http\Controllers;

use App\Models\Mensagem;
use App\Models\User;
use App\Models\Crianca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MensagemController extends Controller
{
    /**
     * Exibe a caixa de entrada de mensagens.
     */
    public function index()
    {
        $mensagensRecebidas = Mensagem::with(['remetente', 'crianca'])
            ->where('destinatario_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'recebidas');

        $mensagensEnviadas = Mensagem::with(['destinatario', 'crianca'])
            ->where('remetente_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'enviadas');

        return view('mensagens.index', compact('mensagensRecebidas', 'mensagensEnviadas'));
    }

    /**
     * Exibe o formulário de nova mensagem.
     */
    public function create(Request $request)
    {
        $users = User::where('id', '!=', Auth::id())
            ->where('ativo', true)
            ->orderBy('name')
            ->get();
            
        $criancas = Crianca::orderBy('nome')->get();
        
        $destinatario_id = $request->query('destinatario_id');
        $crianca_id = $request->query('crianca_id');

        return view('mensagens.create', compact('users', 'criancas', 'destinatario_id', 'crianca_id'));
    }

    /**
     * Salva uma nova mensagem.
     */
    public function store(Request $request)
    {
        $request->validate([
            'destinatario_id' => 'required|exists:users,id',
            'crianca_id' => 'nullable|exists:criancas,id',
            'mensagem' => 'required|string',
        ]);

        Mensagem::create([
            'remetente_id' => Auth::id(),
            'destinatario_id' => $request->destinatario_id,
            'crianca_id' => $request->crianca_id,
            'mensagem' => $request->mensagem,
        ]);

        return redirect()->route('mensagens.index')
            ->with('success', 'Mensagem enviada com sucesso!');
    }

    /**
     * Exibe uma mensagem específica.
     */
    public function show(Mensagem $mensagem)
    {
        // Verifica se o usuário tem permissão para ver a mensagem
        if ($mensagem->remetente_id !== Auth::id() && $mensagem->destinatario_id !== Auth::id()) {
            abort(403);
        }

        // Se o destinatário estiver visualizando, marca como lida
        if ($mensagem->destinatario_id === Auth::id() && !$mensagem->lida) {
            $mensagem->update(['lida' => true]);
        }

        return view('mensagens.show', compact('mensagem'));
    }

    /**
     * Remove uma mensagem (apenas do remetente ou destinatário local).
     */
    public function destroy(Mensagem $mensagem)
    {
        if ($mensagem->remetente_id !== Auth::id() && $mensagem->destinatario_id !== Auth::id()) {
            abort(403);
        }

        $mensagem->delete();

        return redirect()->route('mensagens.index')
            ->with('success', 'Mensagem excluída com sucesso!');
    }
}
