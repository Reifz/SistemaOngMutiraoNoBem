<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Relatório de Evasão - Multirão Bem</title>
    <style>
        body { font-family: sans-serif; font-size: 10px; color: #333; line-height: 1.2; margin: 0; padding: 0; }
        @page { margin: 1cm; }
        .header { text-align: center; border-bottom: 2px solid #3f226b; padding-bottom: 5px; margin-bottom: 10px; }
        .header h1 { font-size: 16px; color: #3f226b; margin: 0; text-transform: uppercase; }
        .header p { margin: 2px 0; font-size: 9px; }
        
        .period-box { background: #faf5ff; padding: 8px; border-left: 4px solid #fede30; margin-bottom: 15px; }
        .period-text { font-size: 10px; font-weight: bold; color: #3f226b; text-transform: uppercase; }

        .stats-container {
            display: table;
            width: 100%;
            table-layout: fixed;
            border-spacing: 8px 0;
            margin-bottom: 20px;
        }
        .stat-card { 
            display: table-cell; 
            width: 25%; 
            padding: 10px; 
            border: 1px solid #e5e7eb; 
            border-radius: 8px; 
            vertical-align: top;
            text-align: center;
        }
        .stat-card.roxo { border-top: 5px solid #3f226b; background: #f5f3ff; }
        .stat-card.amarelo { border-top: 5px solid #fede30; background: #fffbeb; }
        .stat-card.gray { border-top: 5px solid #6b7280; background: #f9fafb; }
        
        .stat-label { font-size: 7px; font-weight: bold; color: #6b7280; text-transform: uppercase; margin-bottom: 5px; margin-top: 0; }
        .stat-value { font-size: 16px; font-weight: 900; color: #3f226b; margin: 0; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background: #3f226b; color: white; text-align: left; padding: 8px; font-size: 9px; text-transform: uppercase; border: 1px solid #3f226b; }
        td { padding: 6px; border: 1px solid #ddd; font-size: 9px; }
        tr:nth-child(even) { background: #f9fafb; }
        
        .badge { 
            padding: 2px 6px; 
            border-radius: 10px; 
            font-size: 8px; 
            font-weight: bold; 
            text-transform: uppercase;
        }
        .badge-motivo { background: #fffbeb; color: #3f226b; border: 1px solid #fede30; }
        
        .footer { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 8px; color: #999; border-top: 1px solid #eee; padding-top: 5px; }
        h3 { color: #3f226b; font-size: 12px; margin-bottom: 5px; text-transform: uppercase; border-bottom: 1px solid #fede30; padding-bottom: 2px; display: inline-block; }
    </style>
</head>
<body>
    <div class="header">
        <table style="width: 100%; border: none;">
            <tr>
                <td style="width: 20%; border: none; text-align: left; vertical-align: middle;">
                    <img src="{{ public_path('logo.png') }}" style="width: 80px;">
                </td>
                <td style="width: 80%; border: none; text-align: center; vertical-align: middle;">
                    <h1>RELATÓRIO DE EVASÃO E DESLIGAMENTOS</h1>
                    <p><b>Educandário Mutirão no Bem - Cidade Dutra</b></p>
                    <p>Gerado em: {{ date('d/m/Y H:i') }} | Multirão Bem &copy; {{ date('Y') }}</p>
                </td>
            </tr>
        </table>
    </div>

    <div class="period-box">
        <span class="period-text">PERÍODO: {{ $dataInicio->format('d/m/Y') }} ATÉ {{ $dataFim->format('d/m/Y') }}</span>
        <br>
        <span class="period-text" style="color: #666; font-size: 9px;">TURMA: <b>{{ $turmaNome }}</b> | PERÍODO: <b>{{ $periodoNome }}</b></span>
    </div>

    <div class="stats-container">
        <div class="stat-card gray">
            <p class="stat-label">Total Matriculados</p>
            <p class="stat-value">{{ $totalMatriculados }}</p>
        </div>
        <div class="stat-card roxo">
            <p class="stat-label">Total Evasões</p>
            <p class="stat-value">{{ $totalEvadidos }}</p>
        </div>
        <div class="stat-card roxo">
            <p class="stat-label">Taxa de Evasão</p>
            <p class="stat-value">{{ number_format($taxaEvasao, 1) }}%</p>
        </div>
        <div class="stat-card amarelo">
            <p class="stat-label">Principal Motivo</p>
            <p class="stat-value" style="font-size: 10px;">{{ $motivoPrincipal->motivo_evasao ?? 'N/A' }}</p>
        </div>
    </div>

    <h3>Listagem Detalhada de Evasões</h3>
    <table>
        <thead>
            <tr>
                <th width="30%">Criança</th>
                <th width="25%">Responsável</th>
                <th width="15%">Data Saída</th>
                <th width="30%">Motivo</th>
            </tr>
        </thead>
        <tbody>
            @forelse($evadidos as $crianca)
                <tr>
                    <td><b>{{ $crianca->nome }}</b></td>
                    <td>{{ $crianca->responsavel->nome ?? 'N/A' }}</td>
                    <td>{{ $crianca->data_evasao ? $crianca->data_evasao->format('d/m/Y') : '---' }}</td>
                    <td>
                        <span class="badge badge-motivo">{{ $crianca->motivo_evasao }}</span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center; color: #999; padding: 20px;">Nenhuma evasão registrada para este período.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Este documento é para uso interno da ONG Mutirão no Bem. Gerado em {{ date('d/m/Y H:i:s') }}
    </div>
</body>
</html>
