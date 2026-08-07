<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\LogAuditoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::orderBy('name')->paginate(15);
        return view('usuarios.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('usuarios.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:admin,triagem,matricula,saude,educador,auditor,user'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'ativo' => true,
        ]);

        LogAuditoria::create([
            'usuario_id' => auth()->id(),
            'acao' => 'Acesso: Criou usuário',
            'tabela_afetada' => 'users',
            'registro_id' => $user->id,
            'detalhes' => "Papel atribuído: {$user->role}",
            'data_hora' => now(),
        ]);

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuário criado com sucesso!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $usuario)
    {
        return view('usuarios.edit', ['user' => $usuario]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $usuario)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,'.$usuario->id],
            'role' => ['required', 'in:admin,triagem,matricula,saude,educador,auditor,user'],
        ]);

        if ($usuario->is(auth()->user()) && $request->role !== 'admin') {
            return back()->with('error', 'Você não pode remover seu próprio acesso administrativo.');
        }

        $roleAnterior = $usuario->role;

        $usuario->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        if ($request->filled('password')) {
            $request->validate([
                'password' => ['confirmed', Rules\Password::defaults()],
            ]);
            $usuario->update([
                'password' => Hash::make($request->password),
            ]);
        }

        LogAuditoria::create([
            'usuario_id' => auth()->id(),
            'acao' => 'Acesso: Atualizou usuário',
            'tabela_afetada' => 'users',
            'registro_id' => $usuario->id,
            'detalhes' => "Papel anterior: {$roleAnterior}; papel atual: {$usuario->role}; senha alterada: ".($request->filled('password') ? 'sim' : 'não'),
            'data_hora' => now(),
        ]);

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuário atualizado com sucesso!');
    }

    /**
     * Alterna o status ativo/inativo do usuário.
     */
    public function toggleStatus(User $usuario)
    {
        if ($usuario->id === auth()->id()) {
            return back()->with('error', 'Você não pode desativar seu próprio usuário.');
        }

        $usuario->update([
            'ativo' => !$usuario->ativo,
        ]);

        LogAuditoria::create([
            'usuario_id' => auth()->id(),
            'acao' => 'Acesso: Alterou status de usuário',
            'tabela_afetada' => 'users',
            'registro_id' => $usuario->id,
            'detalhes' => 'Novo status: '.($usuario->ativo ? 'ativo' : 'inativo'),
            'data_hora' => now(),
        ]);

        $status = $usuario->ativo ? 'ativado' : 'desativado';
        return back()->with('success', "Usuário {$status} com sucesso!");
    }
}
