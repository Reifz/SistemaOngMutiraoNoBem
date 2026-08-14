<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PreInscricaoController;
use App\Http\Controllers\TriagemController;
use App\Http\Controllers\MatriculaController;
use App\Http\Controllers\AnamneseController;
use App\Http\Controllers\ConfiguracaoController;
use App\Http\Controllers\TurmaController;
use App\Http\Controllers\PesquisaController;
use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\AttachmentController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', function () {
        $aniversariantes = \App\Models\Crianca::whereMonth('data_nascimento', now()->month)
            ->whereDay('data_nascimento', now()->day)
            ->get();

        $alertasTriagem = \App\Models\Crianca::where('status', 'PREENCHER')
            ->where('created_at', '<=', now()->subDays(5))
            ->get();

        return view('home', compact('aniversariantes', 'alertasTriagem'));
    })->middleware('role:triagem,matricula,saude,educador,auditor')->name('home');

    // Rota de compatibilidade para evitar erros de 'dashboard' não definido
    Route::get('/dashboard', function() {
        return redirect()->route('home');
    })->middleware('role:triagem,matricula,saude,educador,auditor')->name('dashboard');

    Route::middleware('role:matricula,triagem,saude,educador,auditor')->group(function () {
        Route::get('/pesquisa', [PesquisaController::class, 'index'])->name('pesquisa.index');
        Route::get('/pesquisa/pdf', [PesquisaController::class, 'pdf'])->middleware('role:matricula,auditor')->name('pesquisa.pdf');
    });

    Route::middleware('role:triagem')->group(function () {
        Route::match(['get', 'post'], '/triagem', [TriagemController::class, 'index'])->name('triagem.index');
        Route::get('/triagem/visualizar/{id}', [TriagemController::class, 'onlyRead'])->name('triagem.onlyRead');
        Route::get('/triagem/{id}', [TriagemController::class, 'show'])->name('triagem.show');
        Route::post('/triagem/{id}/status', [TriagemController::class, 'updateStatus'])->name('triagem.status');
    });

    Route::middleware('role:matricula')->group(function () {
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
    Route::post('/matricula/{id}/desistir', [MatriculaController::class, 'desistir'])->name('matricula.desistir');
    Route::get('/download-ficha-mae', [MatriculaController::class, 'downloadFichaMae'])->name('matricula.download_ficha_mae');
    Route::get('/anexos/{tipo}/{id}/{campo}', [AttachmentController::class, 'show'])->name('anexos.show');
    });

    Route::middleware('role:auditor')->group(function () {
        Route::get('/relatorios/evasao', [RelatorioController::class, 'evasao'])->name('relatorios.evasao');
        Route::get('/relatorios/evasao/pdf', [RelatorioController::class, 'pdf'])->name('relatorios.evasao.pdf');
    });

    Route::middleware('role:saude')->group(function () {
    Route::match(['get', 'post'], '/anamnese', [AnamneseController::class, 'index'])->name('anamnese.index');
    Route::get('/anamnese/preencher/{id}', [AnamneseController::class, 'formulario'])->name('anamnese.formulario');
    Route::post('/anamnese/preencher/{id}', [AnamneseController::class, 'store'])->name('anamnese.store');
    Route::get('/anamnese/visualizar/{id}', [AnamneseController::class, 'show'])->name('anamnese.show');
    Route::get('/anamnese/editar/{id}', [AnamneseController::class, 'edit'])->name('anamnese.edit');
    Route::get('/anamnese/pdf/{id}', [AnamneseController::class, 'pdf'])->name('anamnese.pdf');
    });

    Route::middleware('role:matricula,saude')->group(function () {
    Route::match(['get', 'post'], '/rematricula', [\App\Http\Controllers\RematriculaController::class, 'index'])->name('rematricula.index');
    Route::get('/rematricula/anos', [\App\Http\Controllers\RematriculaController::class, 'anosIndex'])->name('rematricula.anos.index');
    Route::post('/rematricula/ano', [\App\Http\Controllers\RematriculaController::class, 'storeAno'])->name('rematricula.ano.store');
    Route::patch('/rematricula/ano/{anoLetivo}', [\App\Http\Controllers\RematriculaController::class, 'updateAno'])->name('rematricula.ano.update');
    Route::post('/rematricula/ano/{id}/ativar', [\App\Http\Controllers\RematriculaController::class, 'ativarAno'])->name('rematricula.ano.ativar');
    Route::post('/rematricula/{id}/iniciar', [\App\Http\Controllers\RematriculaController::class, 'iniciar'])->name('rematricula.iniciar');
    Route::post('/rematricula/{id}/confirmar-dados', [\App\Http\Controllers\RematriculaController::class, 'confirmarDados'])->name('rematricula.confirmar_dados');
    Route::post('/rematricula/{id}/confirmar-anamnese', [\App\Http\Controllers\RematriculaController::class, 'confirmarAnamnese'])->name('rematricula.confirmar_anamnese');
    });

    Route::middleware('role:matricula,educador')->group(function () {
    Route::post('/turmas/{id}/alocar', [TurmaController::class, 'alocar'])->name('turmas.alocar');
    Route::post('/turmas/{id}/remover-crianca', [TurmaController::class, 'removerCrianca'])->name('turmas.remover-crianca');
    Route::resource('turmas', TurmaController::class);
    });

    Route::middleware(['admin'])->group(function () {
        Route::resource('usuarios', App\Http\Controllers\UserController::class)
            ->parameters(['usuarios' => 'usuario'])
            ->except(['show', 'destroy']);
        Route::post('/usuarios/{usuario}/toggle-status', [App\Http\Controllers\UserController::class, 'toggleStatus'])
            ->name('usuarios.toggle-status');

        Route::get('/configuracoes', [ConfiguracaoController::class, 'index'])->name('configuracoes.index');
        Route::post('/configuracoes', [ConfiguracaoController::class, 'store'])->name('configuracoes.store');
    });

    Route::get('/mensagens', [App\Http\Controllers\MensagemController::class, 'index'])->name('mensagens.index');
    Route::get('/mensagens/create', [App\Http\Controllers\MensagemController::class, 'create'])->name('mensagens.create');
    Route::post('/mensagens', [App\Http\Controllers\MensagemController::class, 'store'])->name('mensagens.store');
    Route::get('/mensagens/{mensagem}', [App\Http\Controllers\MensagemController::class, 'show'])->name('mensagens.show');
    Route::delete('/mensagens/{mensagem}', [App\Http\Controllers\MensagemController::class, 'destroy'])->name('mensagens.destroy');
});

Route::get('/pre-inscricao', [PreInscricaoController::class, 'index'])->name('pre-inscricao.index');
Route::post('/pre-inscricao', [PreInscricaoController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('pre-inscricao.store');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
