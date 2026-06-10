<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Listagem de Crianças - Multirão Bem</title>
    <style>
        body { font-family: sans-serif; font-size: 10px; color: #333; line-height: 1.2; margin: 0; padding: 0; }
        @page { margin: 1cm; }
        .header { text-align: center; border-bottom: 2px solid #3f226b; padding-bottom: 5px; margin-bottom: 10px; }
        .header h1 { font-size: 16px; color: #3f226b; margin: 0; text-transform: uppercase; }
        .header p { margin: 2px 0; font-size: 9px; }
        
        .filter-box { background: #faf5ff; padding: 8px; border-left: 4px solid #fede30; margin-bottom: 15px; }
        .filter-text { font-size: 10px; font-weight: bold; color: #3f226b; text-transform: uppercase; }

        table { width: 100%; border-collapse: collapse; margin-top: 10px; table-layout: fixed; }
        th { background: #3f226b; color: white; text-align: left; padding: 8px; font-size: 9px; text-transform: uppercase; border: 1px solid #3f226b; }
        td { padding: 6px; border: 1px solid #ddd; font-size: 9px; vertical-align: top; word-wrap: break-word; }
        tr:nth-child(even) { background: #f9fafb; }
        
        .badge { 
            padding: 2px 6px; 
            border-radius: 10px; 
            font-size: 8px; 
            font-weight: bold; 
            text-transform: uppercase;
            display: inline-block;
        }
        .status-PREENCHER { background: #f3f4f6; color: #1f2937; }
        .status-APROVADA { background: #dcfce7; color: #166534; }
        .status-EM_TURMA { background: #f5f3ff; color: #5b21b6; }
        .status-REJEITADO { background: #fee2e2; color: #991b1b; }
        .status-EVADIDA { background: #fffbeb; color: #92400e; border: 1px solid #fede30; }
        
        .footer { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 8px; color: #999; border-top: 1px solid #eee; padding-top: 5px; }
    </style>
</head>
<body>
    <div class="header">
        <table style="width: 100%; border: none;">
            <tr>
                <td style="width: 15%; border: none; text-align: left; vertical-align: middle;">
                    <img src="{{ public_path('logo.png') }}" style="width: 70px;">
                </td>
                <td style="width: 85%; border: none; text-align: center; vertical-align: middle;">
                    <h1>RELATÓRIO DE PESQUISA / LISTAGEM DE CRIANÇAS</h1>
                    <p><b>Educandário Mutirão no Bem - Cidade Dutra</b></p>
                    <p>Gerado em: {{ date('d/m/Y H:i') }} | Multirão Bem &copy; {{ date('Y') }}</p>
                </td>
            </tr>
        </table>
    </div>

    <div class="filter-box">
        <span class="filter-text">FILTROS APLICADOS:</span>
        <br>
        <span class="filter-text" style="color: #666; font-size: 9px;">
            @if($nome) Nome: <b>{{ $nome }}</b> | @endif
            Turma: <b>{{ $turma ? $turma->nome : 'Todas' }}</b>
        </span>
    </div>

    <table>
        <thead>
            <tr>
                <th width="25%">Criança</th>
                <th width="8%">Idade</th>
                <th width="15%">Turma</th>
                <th width="15%">Série / Período</th>
                <th width="15%">Responsável</th>
                <th width="12%">Contato</th>
                <th width="10%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($criancas as $crianca)
                <tr>
                    <td><b>{{ $crianca->nome }}</b></td>
                    <td>{{ $crianca->idade }} anos</td>
                    <td>{{ $crianca->turma->nome ?? 'Sem Turma' }}</td>
                    <td>{{ $crianca->serie }} - {{ $crianca->periodo_escolar }}</td>
                    <td>{{ $crianca->responsavel->nome ?? '---' }}</td>
                    <td>
                        {{ $crianca->responsavel->telefone ?? '---' }}
                        @if(!empty($crianca->responsavel->telefone_secundario))
                            <br><small>2º: {{ $crianca->responsavel->telefone_secundario }}</small>
                        @endif
                    </td>
                    <td>
                        <span class="badge status-{{ $crianca->status }}">
                            {{ str_replace('_', ' ', $crianca->status) }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; color: #999; padding: 20px;">Nenhuma criança encontrada com os filtros informados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Este documento é para uso interno da ONG Mutirão no Bem. Gerado em {{ date('d/m/Y H:i:s') }}
    </div>
</body>
</html>
