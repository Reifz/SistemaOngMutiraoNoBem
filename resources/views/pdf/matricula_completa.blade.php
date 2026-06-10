<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ficha de Matrícula - {{ $crianca->nome }}</title>
    <style>
        body { font-family: sans-serif; font-size: 10px; color: #333; line-height: 1.2; margin: 0; padding: 0; }
        @page { margin: 1cm; }
        .header { text-align: center; border-bottom: 2px solid #3f226b; padding-bottom: 5px; margin-bottom: 10px; }
        .header h1 { font-size: 16px; color: #3f226b; margin: 0; text-transform: uppercase; }
        .header p { margin: 2px 0; font-size: 9px; }
        
        .section { margin-bottom: 10px; }
        .section-title { background: #f3f4f6; padding: 4px 8px; font-weight: bold; border-left: 4px solid #3f226b; text-transform: uppercase; margin-bottom: 5px; font-size: 11px; }
        
        .grid { width: 100%; border-collapse: collapse; table-layout: fixed; }
        .grid td, .grid th { padding: 4px; border: 1px solid #ddd; vertical-align: top; word-wrap: break-word; }
        
        .label { font-weight: bold; color: #3f226b; font-size: 8px; text-transform: uppercase; display: block; margin-bottom: 1px; }
        .value { font-size: 10px; display: block; min-height: 12px; }
        
        .footer { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 8px; color: #999; border-top: 1px solid #eee; padding-top: 5px; }
        .bg-highlight { background-color: #faf5ff; }
        
        .signature-box { margin-top: 30px; }
        .signature-line { border-top: 1px solid #000; width: 220px; margin: 10px auto 0 auto; text-align: center; font-size: 9px; padding-top: 2px; }
        
        table.compact-table { font-size: 9px; }
        table.compact-table th { background: #f9fafb; font-size: 8px; text-align: left; }
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
                    <h1>FICHA DE INSCRIÇÃO / MATRÍCULA / DESLIGAMENTO</h1>
                    <p><b>Educandário Mutirão no Bem - Cidade Dutra</b></p>
                    <p>Protocolo Interno: #{{ str_pad($crianca->id, 6, '0', STR_PAD_LEFT) }} | Gerado em: {{ date('d/m/Y H:i') }}</p>
                </td>
            </tr>
        </table>
    </div>

    <!-- SEÇÃO 1: DADOS DA CRIANÇA -->
    <div class="section">
        <div class="section-title">1. Dados da Criança / Adolescente</div>
        <table class="grid">
            <tr>
                <td colspan="3"><span class="label">Nome Completo</span><span class="value">{{ $crianca->nome }}</span></td>
                <td><span class="label">Idade</span><span class="value">{{ $crianca->idade }} anos</span></td>
                <td><span class="label">Sexo</span><span class="value">{{ $crianca->sexo }}</span></td>
            </tr>
            <tr>
                <td><span class="label">Nascimento</span><span class="value">{{ $crianca->data_nascimento ? $crianca->data_nascimento->format('d/m/Y') : '---' }}</span></td>
                <td><span class="label">Cor/Raça</span><span class="value">{{ $crianca->cor_raca ?? '---' }}</span></td>
                <td><span class="label">Naturalidade</span><span class="value">{{ $crianca->naturalidade ?? '---' }}</span></td>
                <td><span class="label">PCD</span><span class="value">{{ $crianca->possui_deficiencia ? 'SIM' : 'NÃO' }}</span></td>
                <td><span class="label">Está na Escola</span><span class="value">{{ $crianca->esta_na_escola ? 'SIM' : 'NÃO' }}</span></td>
            </tr>
            <tr>
                <td><span class="label">Inscrição</span><span class="value">{{ $crianca->data_inscricao ? $crianca->data_inscricao->format('d/m/Y') : '---' }}</span></td>
                <td><span class="label">Matrícula</span><span class="value">{{ $crianca->data_matricula ? $crianca->data_matricula->format('d/m/Y') : '---' }}</span></td>
                <td colspan="2"><span class="label">Desligamento (Data/Motivo)</span><span class="value">{{ $crianca->data_desligamento ? $crianca->data_desligamento->format('d/m/Y') : '---' }} | {{ $crianca->motivo_desligamento ?? '---' }}</span></td>
                <td><span class="label">CPF</span><span class="value">{{ $crianca->cpf ?? '---' }}</span></td>
            </tr>
            <tr>
                <td colspan="2"><span class="label">Escola</span><span class="value">{{ $crianca->escola ?? '---' }} ({{ $crianca->tipo_escola ?? '---' }})</span></td>
                <td><span class="label">Série/Ano</span><span class="value">{{ $crianca->serie ?? '---' }}</span></td>
                <td><span class="label">Período</span><span class="value">{{ $crianca->periodo_escolar ?? '---' }}</span></td>
                <td><span class="label">RG</span><span class="value">{{ $crianca->rg ?? '---' }}</span></td>
            </tr>
            <tr>
                <td colspan="5"><span class="label">Certidão de Nascimento (Nº / Folha / Livro)</span><span class="value">{{ $crianca->certidao_nascimento ?? '---' }} / {{ $crianca->certidao_folha ?? '---' }} / {{ $crianca->certidao_livro ?? '---' }}</span></td>
            </tr>


    <!-- GENITORES -->
    @php
        $mae = $crianca->responsaveis->where('pivot.parentesco', 'MAE')->first();
        $pai = $crianca->responsaveis->where('pivot.parentesco', 'PAI')->first();
    @endphp

            <tr class="">
                <td colspan="2"><span class="label">Mãe</span><span class="value">{{ $mae->nome ?? 'NÃO DECLARADO' }}</span></td>
                <td><span class="label">Nascimento</span><span class="value">{{ ($mae && $mae->data_nascimento) ? $mae->data_nascimento->format('d/m/Y') : '---' }}</span></td>
                <td><span class="label">Idade</span><span class="value">{{ $mae->idade ?? '---' }}</span></td>
                <td><span class="label">Profissão</span><span class="value">{{ $mae->profissao ?? '---' }} {{ ($mae && $mae->desempregado) ? '(Desempregada)' : '' }}</span></td>
            </tr>
            <tr>
                <td colspan="2"><span class="label">Pai</span><span class="value">{{ $pai->nome ?? 'NÃO DECLARADO' }}</span></td>
                <td><span class="label">Nascimento</span><span class="value">{{ ($pai && $pai->data_nascimento) ? $pai->data_nascimento->format('d/m/Y') : '---' }}</span></td>
                <td><span class="label">Idade</span><span class="value">{{ $pai->idade ?? '---' }}</span></td>
                <td><span class="label">Profissão</span><span class="value">{{ $pai->profissao ?? '---' }} {{ ($pai && $pai->desempregado) ? '(Desempregado)' : '' }}</span></td>
            </tr>
        </table>
    </div>

    <!-- SEÇÃO 2: MORADIA -->
    <div class="section">
        <div class="section-title">2. Moradia</div>
        <table class="grid">
            <tr>
                <td colspan="2"><span class="label">Endereço / Complemento</span><span class="value">{{ $crianca->moradia->endereco ?? '---' }} {{ isset($crianca->moradia->complemento) ? ' - '.$crianca->moradia->complemento : '' }}</span></td>
                <td><span class="label">Bairro</span><span class="value">{{ $crianca->moradia->bairro ?? '---' }}</span></td>
                <td><span class="label">CEP</span><span class="value">{{ $crianca->moradia->cep ?? '---' }}</span></td>
            </tr>
            <tr>
                <td colspan="2"><span class="label">Ponto de Referência</span><span class="value">{{ $crianca->moradia->ponto_referencia ?? '---' }}</span></td>
                <td><span class="label">Habitação / Condição</span><span class="value">{{ $crianca->moradia->situacao_habitacional ?? '---' }} / {{ $crianca->moradia->condicao_moradia ?? '---' }}</span></td>
                <td><span class="label">Cômodos / Moradores</span><span class="value">{{ $crianca->moradia->numero_comodos ?? '0' }} / {{ $crianca->moradia->numero_moradores ?? '0' }}</span></td>
            </tr>
        </table>
    </div>

    <!-- SEÇÃO 3: CONTATOS -->
    <div class="section">
        <div class="section-title">3. Telefones e Contatos</div>
        <table class="grid">
            @php $contatos = $crianca->responsavel->contatos; @endphp
            @for ($i = 0; $i < count($contatos); $i += 3)
            <tr>
                @for ($j = $i; $j < $i + 3; $j++)
                    @if(isset($contatos[$j]))
                        <td><span class="label">{{ $contatos[$j]->tipo }}</span><span class="value">{{ $contatos[$j]->numero }} {{ $contatos[$j]->pessoa_contato ? "" : '' }}</span></td>
                    @else
                        <td style="border:none"></td>
                    @endif
                @endfor
            </tr>
            @endfor
            @if(count($contatos) == 0)
                <tr><td colspan="3" style="text-align: center; color: #999 italic;">Nenhum contato registrado.</td></tr>
            @endif
        </table>
    </div>

    <!-- SEÇÃO 4: COMPOSIÇÃO FAMILIAR -->
    <div class="section">
        <div class="section-title">4. Composição Familiar (Quem mora na casa)</div>
        <table class="grid compact-table">
            <thead>
                <tr>
                    <th width="20%">Nome</th>
                    <th width="12%">Nasc.</th>
                    <th width="15%">Parentesco</th>
                    <th width="15%">Instrução</th>
                    <th width="10%">CCA?</th>
                    <th width="15%">Profissão</th>
                    <th width="13%">Renda</th>
                </tr>
            </thead>
            <tbody>
                @forelse($crianca->familiares as $familiar)
                <tr>
                    <td>{{ $familiar->nome }}</td>
                    <td>{{ $familiar->data_nascimento ? $familiar->data_nascimento->format('d/m/Y') : '---' }}</td>
                    <td>{{ $familiar->grau_parentesco }}</td>
                    <td>{{ $familiar->grau_instrucao }} {{ $familiar->estuda ? '(Estuda)' : '' }}</td>
                    <td>{{ $familiar->inserido_cca ? 'SIM' : 'NÃO' }}</td>
                    <td>{{ $familiar->profissao }}</td>
                    <td>R$ {{ number_format($familiar->renda, 2, ',', '.') }}</td>
                </tr>
                {{-- @if($familiar->fatores_risco)
                <tr>
                    <td colspan="7" style=""><span class="label">Risco/Vulnerabilidade:</span> {{ $familiar->fatores_risco }}</td>
                </tr>
                @endif --}}
                @empty
                <tr><td colspan="7" style="text-align: center; color: #999;">Nenhum familiar registrado.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- SEÇÃO 5: RESPONSÁVEL FAMILIAR -->
    <div class="section">
        <div class="section-title">5. Responsável Familiar (Com quem o educando mora)</div>
        <table class="grid">
            <tr>
                <td colspan="2"><span class="label">Nome do Responsável</span><span class="value">{{ $crianca->responsavel->nome }}</span></td>
                <td><span class="label">Parentesco</span><span class="value">{{ $crianca->responsavel->parentesco }}</span></td>
                <td><span class="label">Estado Civil</span><span class="value">{{ $crianca->responsavel->estado_civil }}</span></td>
            </tr>
            <tr>
                <td><span class="label">Nascimento / Idade</span><span class="value">{{ $crianca->responsavel->data_nascimento ? $crianca->responsavel->data_nascimento->format('d/m/Y') : '---' }} ({{ $crianca->responsavel->idade }} anos)</span></td>
                <td><span class="label">CPF</span><span class="value">{{ $crianca->responsavel->cpf }}</span></td>
                <td><span class="label">RG</span><span class="value">{{ $crianca->responsavel->rg }}</span></td>
                <td><span class="label">Instrução</span><span class="value">{{ $crianca->responsavel->grau_instrucao }}</span></td>
            </tr>
            <tr>
                <td><span class="label">Profissão</span><span class="value">{{ $crianca->responsavel->profissao ?? '---' }} {{ $crianca->responsavel->desempregado ? '(Desempregado)' : '' }}</span></td>
                <td><span class="label">CadÚnico</span><span class="value">{{ $crianca->responsavel->tem_cadastro_unico ? 'SIM' : 'NÃO' }}</span></td>
                <td><span class="label">Transferência Renda</span><span class="value">{{ $crianca->responsavel->recebe_transferencia_renda ? 'SIM' : 'NÃO' }}</span></td>
                <td><span class="label">BPC</span><span class="value">{{ $crianca->responsavel->recebe_bpc ? 'SIM' : 'NÃO' }}</span></td>
            </tr>
            @if($crianca->responsavel->fatores_risco)
            <tr>
                <td colspan="4"><span class="label">Fatores de Risco ou Vulnerabilidade Social (Responsável)</span><span class="value">{{ $crianca->responsavel->fatores_risco }}</span></td>
            </tr>
            @endif
        </table>
    </div>

    <div class="signature-box">
        <p style="text-align: center; margin-bottom: 30px; font-size: 9px;">Declaro para os devidos fins que as informações acima são verdadeiras e estou ciente das responsabilidades legais.</p>
        <table style="width: 100%;">
            <tr>
                <td style="width: 50%; text-align: center;">
                    <div class="signature-line">Assinatura do Responsável</div>
                    <div style="font-size: 8px; margin-top: 2px;">{{ $crianca->responsavel->nome }}</div>
                </td>
                <td style="width: 50%; text-align: center;">
                    <div class="signature-line">Assinatura do Funcionário (ONG)</div>
                    <div style="font-size: 8px; margin-top: 2px;">Educandário Mutirão no Bem</div>
                </td>
            </tr>
        </table>
    </div>

    <div class="footer">
        Este documento é de uso interno da ONG Mutirão no Bem. Gerado em {{ date('d/m/Y H:i:s') }}
    </div>

</body>
</html>