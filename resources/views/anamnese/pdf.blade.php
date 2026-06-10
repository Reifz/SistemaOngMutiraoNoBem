<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Anamnese - {{ $crianca->nome }}</title>
    <style>
        body { font-family: sans-serif; font-size: 10px; color: #333; line-height: 1.2; margin: 0; padding: 0; }
        @page { margin: 1cm; }
        .header { text-align: center; border-bottom: 2px solid #3f226b; padding-bottom: 5px; margin-bottom: 10px; }
        .header h1 { font-size: 16px; color: #3f226b; margin: 0; text-transform: uppercase; }
        .header p { margin: 2px 0; font-size: 9px; }

        .section { margin-bottom: 10px; page-break-inside: avoid; }
        .section-title { background: #f3f4f6; padding: 4px 8px; font-weight: bold; border-left: 4px solid #3f226b; text-transform: uppercase; margin-bottom: 5px; font-size: 11px; color: #3f226b; }
        
        .grid { width: 100%; border-collapse: collapse; table-layout: fixed; }
        .grid td { padding: 4px; border: 1px solid #ddd; vertical-align: top; word-wrap: break-word; }
        
        .label { font-weight: bold; color: #3f226b; font-size: 8px; text-transform: uppercase; display: block; margin-bottom: 1px; }
        .value { font-size: 10px; display: block; min-height: 12px; }
        
        .footer { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 8px; color: #999; border-top: 1px solid #eee; padding-top: 5px; }
        .bg-highlight { background-color: #faf5ff; padding: 8px; border-left: 4px solid #fede30; margin-bottom: 15px; }
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
                    <h1>ANAMNESE E HISTÓRICO DE DESENVOLVIMENTO</h1>
                    <p><b>Educandário Mutirão no Bem - Cidade Dutra</b></p>
                    <p>Relatório de Saúde (LGPD) | Gerado em: {{ date('d/m/Y H:i') }}</p>
                </td>
            </tr>
        </table>
    </div>

    <div class="bg-highlight">
        <table class="grid" style="border: none;">
            <tr>
                <td style="border: none; width: 60%;">
                    <span class="label">Criança / Paciente:</span>
                    <span class="value" style="font-size: 14px; font-weight: bold; color: #3f226b;">{{ $crianca->nome }}</span>
                </td>
                <td style="border: none; width: 40%; text-align: right;">
                    <span class="label">Data de Preenchimento:</span>
                    <span class="value">{{ isset($dados['data_preenchimento']) ? date('d/m/Y', strtotime($dados['data_preenchimento'])) : 'Não informado' }}</span>
                </td>
            </tr>
            <tr>
                <td style="border: none;">
                    <span class="label">Responsável Legal:</span>
                    <span class="value">{{ $crianca->responsavel->nome }}</span>
                </td>
                <td style="border: none; text-align: right;">
                    <span class="label">Respondido por:</span>
                    <span class="value">{{ $dados['respondido_por'] ?? 'Não informado' }}</span>
                </td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Dados Pessoais</div>
        <table class="grid">
            <tr>
                <td>
                    <span class="label">Apelidos:</span>
                    <span class="value">{{ $dados['apelidos'] ?? 'N/A' }}</span>
                </td>
                <td>
                    <span class="label">Apelidos indesejados:</span>
                    <span class="value">{{ $dados['apelidos_indesejados'] ?? 'N/A' }}</span>
                </td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Esquema Familiar</div>
        <table class="grid">
            <tr>
                <td>
                    <span class="label">Responsável pela rotina:</span>
                    <span class="value">{{ $dados['responsavel_rotina'] ?? 'N/A' }}</span>
                </td>
                <td>
                    <span class="label">Motivo:</span>
                    <span class="value">{{ $dados['motivo_responsavel_rotina'] ?? 'N/A' }}</span>
                </td>
            </tr>
            <tr>
                <td>
                    <span class="label">Parentes por perto?</span>
                    <span class="value">{{ $dados['parentes_proximos'] ?? 'N/A' }}</span>
                </td>
                <td>
                    <span class="label">Situação dos pais:</span>
                    <span class="value">{{ $dados['situacao_pais'] ?? 'N/A' }}</span>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <span class="label">Dinâmica de guarda e convivência:</span>
                    <span class="value">{{ $dados['dinamica_guarda_convivencia'] ?? 'N/A' }}</span>
                </td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">História Escolar</div>
        <table class="grid">
            <tr>
                <td><span class="label">Idade entrada:</span> <span class="value">{{ $dados['idade_entrada_escola'] ?? 'N/A' }}</span></td>
                <td><span class="label">Ed. Infantil?</span> <span class="value">{{ $dados['frequentou_educacao_infantil'] ?? 'N/A' }}</span></td>
            </tr>
            <tr>
                <td><span class="label">Reprovado?</span> <span class="value">{{ $dados['reprovado'] ?? 'N/A' }}</span></td>
                <td><span class="label">Reforço?</span> <span class="value">{{ $dados['reforco'] ?? 'N/A' }}</span></td>
            </tr>
            <tr>
                <td><span class="label">Dificuldade aprendizagem:</span> <span class="value">{{ $dados['dificuldade_aprendizagem'] ?? 'N/A' }}</span></td>
                <td><span class="label">Problemas professores:</span> <span class="value">{{ $dados['problema_professores'] ?? 'N/A' }}</span></td>
            </tr>
            <tr>
                <td colspan="2">
                    <span class="label">Comportamento na escola:</span>
                    <span class="value">{{ $dados['comportamento_escola'] ?? 'N/A' }}</span>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <span class="label">Queixas ou problemas aparentes:</span>
                    <span class="value">{{ $dados['queixas_problemas_escola'] ?? 'N/A' }}</span>
                </td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">História de Vida</div>
        <table class="grid">
            <tr>
                <td><span class="label">Criança desejada?</span> <span class="value">{{ $dados['desejada'] ?? 'N/A' }}</span></td>
                <td><span class="label">Causou transtornos pais?</span> <span class="value">{{ $dados['causou_transtorno_pais'] ?? 'N/A' }}</span></td>
            </tr>
            <tr>
                <td colspan="2">
                    <span class="label">Problemas desenvolvimento (Fala, andar, etc):</span>
                    <span class="value">{{ $dados['problemas_desenvolvimento'] ?? 'N/A' }}</span>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <span class="label">Características marcantes:</span>
                    <span class="value">{{ $dados['caracteristicas_crianca'] ?? 'N/A' }}</span>
                </td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Histórico Clínico</div>
        <table class="grid">
            <tr>
                <td colspan="2">
                    <span class="label">Tratamento especializado:</span>
                    <span class="value">{{ $dados['tratamento_especializado'] ?? 'N/A' }}</span>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <span class="label">Dificuldades apresentadas:</span>
                    <span class="value">
                        @php $dificuldades = $dados['dificuldades_especificas'] ?? []; @endphp
                        {{ implode(', ', (array)$dificuldades) ?: 'Nenhuma informada' }}
                    </span>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <span class="label">Problemas de saúde com acompanhamento:</span>
                    <span class="value">{{ $dados['problemas_saude_especificos'] ?? 'N/A' }}</span>
                </td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Família Ampliada e Relações</div>
        <table class="grid">
            <tr>
                <td colspan="2">
                    <span class="label">Fator marcante/impactante presenciado:</span>
                    <span class="value">{{ $dados['fator_marcante'] ?? 'N/A' }}</span>
                </td>
            </tr>
            <tr>
                <td><span class="label">Relação familiar:</span> <span class="value">{{ $dados['relacao_familiares'] ?? 'N/A' }}</span></td>
                <td><span class="label">Atitude pais sem limite:</span> <span class="value">{{ $dados['atitude_pais_limites'] ?? 'N/A' }}</span></td>
            </tr>
            <tr>
                <td><span class="label">Reação criança limite:</span> <span class="value">{{ $dados['reacao_crianca_limites'] ?? 'N/A' }}</span></td>
                <td><span class="label">Quem protege?</span> <span class="value">{{ $dados['protege_crianca'] ?? 'N/A' }}</span></td>
            </tr>
            <tr>
                <td><span class="label">Auxilia estudos:</span> <span class="value">{{ $dados['auxilia_estudos'] ?? 'N/A' }}</span></td>
                <td><span class="label">Responsabilidade casa:</span> <span class="value">{{ $dados['responsabilidades_casa'] ?? 'N/A' }}</span></td>
            </tr>
            <tr>
                <td><span class="label">Relação colegas:</span> <span class="value">{{ $dados['relacao_colegas'] ?? 'N/A' }}</span></td>
                <td><span class="label">O que mais gosta:</span> <span class="value">{{ $dados['gosta_na_crianca'] ?? 'N/A' }}</span></td>
            </tr>
            <tr>
                <td colspan="2">
                    <span class="label">O que desagrada/incomoda:</span>
                    <span class="value">{{ $dados['desagrada_na_crianca'] ?? 'N/A' }}</span>
                </td>
            </tr>
        </table>
    </div>

    <div class="footer">
        Este documento é de uso interno da ONG Mutirão no Bem. Gerado em {{ date('d/m/Y H:i:s') }}
    </div>

</body>
</html>