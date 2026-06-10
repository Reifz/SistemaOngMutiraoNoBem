<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pré-Inscrição - Mutirão no Bem</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #3f226b;
            --secondary-color: #fede30;
            --accent-color: #3f226b;
            --bg-color: #f4f7f6;
            --text-color: #333;
            --error-color: #e74c3c;
            --success-color: #27ae60;
        }

        * { box-sizing: border-box; }
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
            line-height: 1.6;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        header {
            text-align: center;
            margin-bottom: 40px;
            border-bottom: 2px solid #eee;
            padding-bottom: 20px;
        }

        .logo-img {
            max-width: 200px;
            height: auto;
            margin-bottom: 15px;
        }

        header h1 { color: var(--primary-color); margin-bottom: 10px; }
        header p { color: #666; font-size: 0.9em; }

        .info-section {
            background: #fdf2e9;
            padding: 20px;
            border-left: 5px solid var(--primary-color);
            margin-bottom: 30px;
            border-radius: 4px;
        }

        .info-section h3 { margin-top: 0; color: var(--primary-color); }

        h2 {
            color: var(--primary-color);
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
            margin-top: 30px;
        }

        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 5px; font-weight: 600; }
        
        input[type="text"],
        input[type="email"],
        select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
        }

        input:focus, select:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 5px rgba(63, 34, 107, 0.3);
        }

        .radio-group {
            /* display: flex; */
            gap: 15px;
            flex-wrap: wrap;
            margin-top: 5px;
        }

        .radio-item {
            display: flex;
            align-items: center;
            gap: 5px;
            background: #f9f9f9;
            padding: 8px 15px;
            border-radius: 20px;
            border: 1px solid #eee;
            cursor: pointer;
        }

        .btn-submit {
            background-color: var(--primary-color);
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 6px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            transition: background 0.3s;
            margin-top: 20px;
        }

        .btn-submit:hover { background-color: #2e194e; }

        .alert {
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
        }
        .alert-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }

        .error-message { color: var(--error-color); font-size: 0.85em; margin-top: 5px; }

        .lgpd-box {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 6px;
            margin-top: 20px;
            font-size: 0.9em;
        }

        @media (max-width: 600px) {
            .container { padding: 20px; }
        }
    </style>
</head>
<body>

    <div class="container">
        <header>
            <img src="{{ asset('logo.png') }}" alt="Logo Mutirão no Bem" class="logo-img">
            <h1>Mutirão no Bem</h1>
            <p>Seja bem-vindo(a) ao nosso processo de pré-inscrição</p>
        </header>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="info-section" style="text-align: justify;">
            <h3>Informações Importantes</h3>
            <ul>
                <li>O preenchimento desta Ficha apenas manifesta o interesse de fazer a inscrição.</li>
                <li>Somente após receber CONFIRMAÇÃO o(a) educando(a) estará matriculado.</li>
                <li>Favor verificar se o telefone foi informado corretamente - entraremos em contato através dele.</li>
            </ul>
            <h3 style="color: #3f226b"><b><strong>Inscrições Abertas</strong></b></h3>
            <p><strong>Público:</strong> Crianças de 6 a 11 anos.</p>

            <p>
                <p><b><strong>Sobre a entidade</strong></b></p>
                <div style="text-align: justify;">
                    O Mutirão no Bem é uma entidade sem fins lucrativos classificada como OSCIP. 
                    Atende crianças e adolescentes, na faixa etária de 06 a 14 anos. 
                    Se dedica a atender crianças e adolescentes com a proposta de EDUCAR PARA A VIDA. 
                    Sua atuação está focada no processo de orientar para a transformação individual e a evolução, 
                    formando assim indivíduos com caráter, índole e dignidade, auxiliando-os a forjar uma personalidade 
                    elevada e nobre e favorecendo o desenvolvimento e a prática de valores e competências humanas em mais alto grau.
                </div>


                <p><b>Objetivo:</b> Apoiar famílias, em comunidades onde há vulnerabilidade social, no desenvolvimento pessoal das crianças e adolescentes a fim de garantir a eles seus 
                direitos e contribuir na formação de cidadãos mais conscientes de si e do próximo.</p>

                <p><b>Localização:</b> Estamos localizados na zona sul de São Paulo, no território do Cidade Dutra - CEP 04810-050.</p>

                <p><b>Veja mais em:</b></p>

                <p><a href="https://www.mutiraonobem.org.br" target="_blank">www.mutiraonobem.org.br</a></p>
                <p><a href="https://www.instagram.com/mutiraonobem" target="_blank">Instagram @mutiraonobem</a></p>
                <p><a href="https://www.facebook.com/mutiraonobem" target="_blank">Facebook/mutiraonobem</a></p>
                <p><a href="https://www.youtube.com/@mutiraonobem" target="_blank">Youtube @mutiraonobem</a></p>

            </p>
        </div>

        <form action="{{ route('pre-inscricao.store') }}" method="POST">
            @csrf

            <h2>Dados da Criança</h2>
            
            <div class="form-group">
                <label for="crianca_nome"><b>Nome completo da criança</b></label>
                <input type="text" id="crianca_nome" name="crianca_nome" value="{{ old('crianca_nome') }}" required>
            </div>

            {{-- <div class="form-group">
                <label>Idade da Criança</label>
                <div class="radio-group">
                    @foreach([6, 7, 8, 9, 10, 11] as $idade)
                        <label class="radio-item">
                            <input type="radio" name="crianca_idade" value="{{ $idade }}" {{ old('crianca_idade') == $idade ? 'checked' : '' }} required>
                            {{ $idade }} anos
                        </label>
                        <br>
                    @endforeach
                </div>
            </div> --}}

            <div class="form-group">
                <label for="crianca_idade"><b>Idade da Criança</b></label>
                <select name="crianca_idade" id="crianca_idade" required>
                    @foreach([6, 7, 8, 9, 10, 11] as $idade)
                        <option value="{{ $idade }}" {{ old('crianca_idade') == $idade ? 'selected' : '' }}>
                            {{ $idade }} anos
                        </option>
                    @endforeach
                </select>
            </div>


            <div class="form-group">
                <label for="crianca_escola"><b>Estuda em qual escola?</b></label>
                <input type="text" id="crianca_escola" name="crianca_escola" value="{{ old('crianca_escola') }}" required>
            </div>

            <div class="form-group">
                <label for="crianca_serie"><b>Está em qual série?</b></label>
                <select id="crianca_serie" name="crianca_serie" required>
                    <option value="">Selecione...</option>
                    @foreach(['Pré', '1º ano', '2º ano', '3º ano', '4º ano', '5º ano', '6º ano'] as $serie)
                        <option value="{{ $serie }}" {{ old('crianca_serie') == $serie ? 'selected' : '' }}>{{ $serie }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="crianca_periodo"><b>Período ATUAL da criança (na escola)</b></label>
                <select id="crianca_periodo" name="crianca_periodo" required>
                    <option value="">Selecione...</option>
                    @foreach(['Manhã', 'Tarde', 'Não sei'] as $periodo)
                        <option value="{{ $periodo }}" {{ old('crianca_periodo') == $periodo ? 'selected' : '' }}>{{ $periodo }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="crianca_periodo_ong"><b>Período que deseja alocar a criança na ONG</b></label>
                <select id="crianca_periodo_ong" name="crianca_periodo_ong" required>
                    <option value="">Selecione...</option>
                    @foreach(['Manhã', 'Tarde'] as $periodo)
                        <option value="{{ $periodo }}" {{ old('crianca_periodo_ong') == $periodo ? 'selected' : '' }}>{{ $periodo }}</option>
                    @endforeach
                </select>
                <p style="font-size: 0.75em; color: var(--error-color); margin-top: 5px;">
                    <strong>Atenção:</strong> A alocação na ONG deve ser feita no período oposto ao da escola (contra-turno).
                </p>
            </div>

            <h2>Dados do Responsável</h2>

            <div class="form-group">
                <label for="responsavel_nome"><b>Nome do(a) responsável</b></label>
                <input type="text" id="responsavel_nome" name="responsavel_nome" value="{{ old('responsavel_nome') }}" required>
            </div>

            <div class="form-group">
                <label for="responsavel_email"><b>E-mail para contato</b></label>
                <input type="email" id="responsavel_email" name="responsavel_email" value="{{ old('responsavel_email') }}" required placeholder="exemplo@email.com">
            </div>

            <div class="form-group">
                <label for="acesso_local"><b>Estamos na Cidade Dutra, zona sul de SP, CEP 04810-050. Como é o acesso para você?</b></label>
                <select id="acesso_local" name="acesso_local" required>
                    <option value="">Selecione...</option>
                    @foreach(['Fácil', 'Médio', 'Difícil'] as $acesso)
                        <option value="{{ $acesso }}" {{ old('acesso_local') == $acesso ? 'selected' : '' }}>{{ $acesso }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="responsavel_telefone"><b>Qual o melhor telefone para contato?</b></label>
                <input type="text" id="responsavel_telefone" name="responsavel_telefone" value="{{ old('responsavel_telefone') }}" required placeholder="(00) 00000-0000">
            </div>

            <div class="form-group">
                <label for="responsavel_telefone_secundario"><b>Qual o segundo telefone para contato?</b></label>
                <input type="text" id="responsavel_telefone_secundario" name="responsavel_telefone_secundario" value="{{ old('responsavel_telefone_secundario') }}" placeholder="(00) 00000-0000">
            </div>

            <div class="lgpd-box">
                <label style="display: flex; align-items: flex-start; gap: 10px; cursor: pointer;">
                    <input type="checkbox" name="consentimento_lgpd" value="1" required {{ old('consentimento_lgpd') ? 'checked' : '' }}>
                    <span>Estou de acordo com o processamento dos dados acima para fins de pré-inscrição e entendo que a ONG Mutirão no Bem entrará em contato para dar continuidade ao processo.</span>
                </label>
            </div>

            <button type="submit" class="btn-submit">Enviar Pré-Inscrição</button>
        </form>

        <footer style="margin-top: 50px; text-align: center; color: #888; font-size: 0.8em;">
            <p>Mutirão no Bem | Cidade Dutra, São Paulo - SP</p>
            <p>www.mutiraonobem.org.br</p>
        </footer>
    </div>

</body>
</html>
