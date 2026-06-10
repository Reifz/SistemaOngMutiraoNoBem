<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PreInscricaoController;
use App\Http\Controllers\TriagemController;
use App\Http\Controllers\MatriculaController;
use App\Http\Controllers\AnamneseController;
use App\Http\Controllers\TurmaController;
use App\Http\Controllers\PesquisaController;
use App\Http\Controllers\RelatorioController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', function () {
        // Dados para a tela de apresentação (Home)
        $aniversariantes = \App\Models\Crianca::whereMonth('data_nascimento', now()->month)
            ->whereDay('data_nascimento', now()->day)
            ->get();

        $alertasTriagem = \App\Models\Crianca::where('status', 'PREENCHER')
            ->where('created_at', '<=', now()->subDays(7))
            ->get();

        return view('home', compact('aniversariantes', 'alertasTriagem'));
    })->name('home');

    // Rota de compatibilidade para evitar erros de 'dashboard' não definido
    Route::get('/dashboard', function() {
        return redirect()->route('home');
    })->name('dashboard');

    // Pesquisa Geral
    Route::get('/pesquisa', [PesquisaController::class, 'index'])->name('pesquisa.index');
    Route::get('/pesquisa/pdf', [PesquisaController::class, 'pdf'])->name('pesquisa.pdf');

    // Aba 1: Triagem
    Route::match(['get', 'post'], '/triagem', [TriagemController::class, 'index'])->name('triagem.index');
    Route::get('/triagem/{id}', [TriagemController::class, 'show'])->name('triagem.show');
    Route::get('/triagem/visualizar/{id}', [TriagemController::class, 'onlyRead'])->name('triagem.onlyRead');
    Route::post('/triagem/{id}/status', [TriagemController::class, 'updateStatus'])->name('triagem.status');

    // Aba 2: Matrícula
    Route::match(['get', 'post'], '/matricula', [MatriculaController::class, 'index'])->name('matricula.index');
    Route::get('/matricula/preencher/{id}', [MatriculaController::class, 'formulario'])->name('matricula.formulario');
    Route::post('/matricula/preencher/{id}', [MatriculaController::class, 'store'])->name('matricula.store');
    Route::get('/matricula/{id}/show', [MatriculaController::class, 'show'])->name('matricula.show');
    Route::get('/matricula/{id}/historico', [MatriculaController::class, 'historico'])->name('matricula.historico');
    Route::get('/matricula/{id}/edit', [MatriculaController::class, 'edit'])->name('matricula.edit');
    Route::post('/matricula/{id}/update', [MatriculaController::class, 'update'])->name('matricula.update');
    Route::post('/matricula/{id}/aprovar', [MatriculaController::class, 'aprovar'])->name('matricula.aprovar');
    Route::get('/matricula/{id}/pdf', [MatriculaController::class, 'pdf'])->name('matricula.pdf');
    Route::post('/matricula/{id}/evadir', [MatriculaController::class, 'evadir'])->name('matricula.evadir');
    Route::get('/download-ficha-mae', [MatriculaController::class, 'downloadFichaMae'])->name('matricula.download_ficha_mae');

    // Relatórios
    Route::get('/relatorios/evasao', [RelatorioController::class, 'evasao'])->name('relatorios.evasao');
    Route::get('/relatorios/evasao/pdf', [RelatorioController::class, 'pdf'])->name('relatorios.evasao.pdf');

    // Aba 3: Anamnese
    Route::match(['get', 'post'], '/anamnese', [AnamneseController::class, 'index'])->name('anamnese.index');
    Route::get('/anamnese/preencher/{id}', [AnamneseController::class, 'formulario'])->name('anamnese.formulario');
    Route::post('/anamnese/preencher/{id}', [AnamneseController::class, 'store'])->name('anamnese.store');
    Route::get('/anamnese/visualizar/{id}', [AnamneseController::class, 'show'])->name('anamnese.show');
    Route::get('/anamnese/editar/{id}', [AnamneseController::class, 'edit'])->name('anamnese.edit');
    Route::get('/anamnese/pdf/{id}', [AnamneseController::class, 'pdf'])->name('anamnese.pdf');

    // Aba Rematrícula
    Route::match(['get', 'post'], '/rematricula', [\App\Http\Controllers\RematriculaController::class, 'index'])->name('rematricula.index');
    Route::get('/rematricula/anos', [\App\Http\Controllers\RematriculaController::class, 'anosIndex'])->name('rematricula.anos.index');
    Route::post('/rematricula/ano', [\App\Http\Controllers\RematriculaController::class, 'storeAno'])->name('rematricula.ano.store');
    Route::post('/rematricula/ano/{id}/ativar', [\App\Http\Controllers\RematriculaController::class, 'ativarAno'])->name('rematricula.ano.ativar');
    Route::post('/rematricula/{id}/iniciar', [\App\Http\Controllers\RematriculaController::class, 'iniciar'])->name('rematricula.iniciar');

    // Aba 4: Gestão de Turmas
    Route::post('/turmas/{id}/alocar', [TurmaController::class, 'alocar'])->name('turmas.alocar');
    Route::post('/turmas/{id}/remover-crianca', [TurmaController::class, 'removerCrianca'])->name('turmas.remover-crianca');
    Route::resource('turmas', TurmaController::class);

    // Gestão de Usuários (RBAC) - Apenas Administradores
    Route::middleware(['admin'])->group(function () {
        Route::resource('usuarios', App\Http\Controllers\UserController::class)
            ->parameters(['usuarios' => 'usuario'])
            ->except(['show', 'destroy']);
        Route::post('/usuarios/{usuario}/toggle-status', [App\Http\Controllers\UserController::class, 'toggleStatus'])
            ->name('usuarios.toggle-status');
    });

    // Central de Mensagens (Acesso Geral)
    Route::get('/mensagens', [App\Http\Controllers\MensagemController::class, 'index'])->name('mensagens.index');
    Route::get('/mensagens/create', [App\Http\Controllers\MensagemController::class, 'create'])->name('mensagens.create');
    Route::post('/mensagens', [App\Http\Controllers\MensagemController::class, 'store'])->name('mensagens.store');
    Route::get('/mensagens/{mensagem}', [App\Http\Controllers\MensagemController::class, 'show'])->name('mensagens.show');
    Route::delete('/mensagens/{mensagem}', [App\Http\Controllers\MensagemController::class, 'destroy'])->name('mensagens.destroy');
});

// Rotas públicas de Pré-Inscrição
Route::get('/pre-inscricao', [PreInscricaoController::class, 'index'])->name('pre-inscricao.index');
Route::post('/pre-inscricao', [PreInscricaoController::class, 'store'])->name('pre-inscricao.store');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
