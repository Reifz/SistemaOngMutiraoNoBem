<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Comprovante de Pré-Inscrição - Mutirão no Bem</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 40px; }
        .header { text-align: center; border-bottom: 2px solid #3f226b; padding-bottom: 20px; margin-bottom: 30px; }
        .header h1 { color: #3f226b; margin: 0; text-transform: uppercase; letter-spacing: 2px; }
        .header p { margin: 5px 0; color: #666; font-size: 14px; }
        
        .content { margin-bottom: 30px; }
        .status-badge { display: inline-block; padding: 5px 15px; background: #fede30; color: #3f226b; border-radius: 4px; font-weight: bold; margin-bottom: 20px; }
        
        .section { margin-bottom: 25px; background: #f9f9f9; padding: 15px; border-radius: 8px; }
        .section h3 { margin-top: 0; color: #3f226b; border-bottom: 1px solid #ddd; padding-bottom: 5px; }
        
        .grid { width: 100%; border-collapse: collapse; }
        .grid td { padding: 8px 0; border-bottom: 1px solid #eee; font-size: 14px; }
        .label { font-weight: bold; color: #555; width: 40%; }
        
        .footer { margin-top: 50px; text-align: center; font-size: 12px; color: #888; border-top: 1px solid #eee; padding-top: 20px; }
        .signature { margin-top: 60px; text-align: center; }
        .signature-line { width: 300px; border-top: 1px solid #333; margin: 0 auto 5px; }
        
        .stamp { position: absolute; top: 40px; right: 40px; opacity: 0.1; }
    </style>
</head>
<body>

    <div class="header">
        <h1>Mutirão no Bem</h1>
        <p>ONG DE ATENDIMENTO A CRIANÇAS E ADOLESCENTES | OSCIP</p>
        <p>Cidade Dutra, São Paulo - SP | www.mutiraonobem.org.br</p>
    </div>

    <div class="content">
        <div style="text-align: center;">
            <div class="status-badge">PRÉ-INSCRIÇÃO APROVADA</div>
            <h2>Comprovante de Seleção Inicial</h2>
            <p>Este documento confirma que a criança abaixo relacionada foi selecionada na triagem inicial e está apta para a fase de Anamnese.</p>
        </div>

        <div class="section">
            <h3>Dados da Criança</h3>
            <table class="grid">
                <tr><td class="label">Nome do Aluno(a):</td><td>{{ $crianca->nome }}</td></tr>
                <tr><td class="label">Idade Selecionada:</td><td>{{ $crianca->idade }} anos</td></tr>
                <tr><td class="label">Escola / Série:</td><td>{{ $crianca->escola }} ({{ $crianca->serie }})</td></tr>
                <tr><td class="label">Protocolo:</td><td>#{{ str_pad($crianca->id, 6, '0', STR_PAD_LEFT) }}</td></tr>
                <tr><td class="label">Data de Aprovação:</td><td>{{ now()->format('d/m/Y H:i') }}</td></tr>
            </table>
        </div>

        <div class="section">
            <h3>Dados do Responsável</h3>
            <table class="grid">
                <tr><td class="label">Nome do Responsável:</td><td>{{ $crianca->responsavel->nome }}</td></tr>
                <tr><td class="label">Telefone de Contato:</td><td>{{ $crianca->responsavel->telefone }}</td></tr>
                <tr><td class="label">E-mail:</td><td>{{ $crianca->responsavel->email }}</td></tr>
            </table>
        </div>

        <div style="background: #fff8e1; border-left: 5px solid #ffc107; padding: 15px; font-size: 13px;">
            <strong>PRÓXIMOS PASSOS:</strong><br>
            A equipe da ONG entrará em contato via telefone para agendar a entrevista de Anamnese. 
            Favor ter em mãos os documentos originais da criança e do responsável no dia agendado.
        </div>
    </div>

    <div class="signature">
        <div class="signature-line"></div>
        <p>Departamento de Triagem - Mutirão no Bem</p>
    </div>

    <div class="footer">
        <p>Documento gerado eletronicamente em {{ now()->format('d/m/Y \à\s H:i') }}.</p>
        <p>Este documento não garante a matrícula final, apenas a aprovação na etapa de triagem.</p>
    </div>

</body>
</html>
