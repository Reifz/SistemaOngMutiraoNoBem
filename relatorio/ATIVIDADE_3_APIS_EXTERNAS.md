# UNIVERSIDADE PAULISTA - UNIP

## CURSO DE [CIENCIA DA COMPUTACAO / SISTEMAS DE INFORMACAO]

**RELATORIO INDIVIDUAL DE ATIVIDADE DE EXTENSAO III**

**INTEGRACOES, COMUNICACAO INSTITUCIONAL E AUTOMACAO DE DOCUMENTOS NO SISTEMA DA ONG MULTIRAO BEM**

**Aluno(a):** [SEU NOME COMPLETO]  
**RA:** [SEU RA]  
**Professor(a) orientador(a):** [NOME DO PROFESSOR]  
**Area tematica da extensao:** Tecnologia e Producao  
**Instituicao parceira:** ONG Multirao Bem  
**Periodo de realizacao:** [DATA INICIAL] a [DATA FINAL]  
**Carga horaria:** [CARGA HORARIA]

[CIDADE - UF]  
2026

\newpage

## RESUMO

Este relatorio apresenta a terceira atividade individual de extensao realizada para a ONG Multirao Bem, com foco em integracoes, comunicacao institucional, automacao documental e relatorios gerenciais. A atividade complementou o sistema web por meio de notificacoes por e-mail, links diretos de contato via WhatsApp, central interna de mensagens, geracao de documentos em PDF e relatorios de evasao. A aplicacao foi desenvolvida em Laravel 13.4, PHP 8.3+, Blade, Tailwind CSS, DomPDF e recursos nativos de notificacao, eventos de e-mail e autenticacao. As funcionalidades implementadas contribuem para agilizar o contato com responsaveis, registrar comunicacoes internas, gerar evidencias documentais e oferecer indicadores para tomada de decisao da ONG. A atividade caracteriza-se como extensao porque aplica conhecimentos de integracao de sistemas, automacao e comunicacao digital em beneficio de uma organizacao social externa, fortalecendo a gestao do atendimento a criancas e familias.

**Palavras-chave:** integracao de sistemas; notificacoes; PDF; comunicacao digital; extensao universitaria.

\newpage

## SUMARIO

1. Introducao  
2. Justificativa e enquadramento extensionista  
3. Objetivos  
4. Metodologia  
5. Desenvolvimento da atividade  
6. Resultados e impacto social  
7. Avaliacao e autoavaliacao  
8. Consideracoes finais  
Referencias  
Apendices

\newpage

## 1 INTRODUCAO

A digitalizacao dos dados da ONG Multirao Bem, realizada nas atividades anteriores, criou a base necessaria para novos recursos de comunicacao, automacao e acompanhamento gerencial. Entretanto, apenas armazenar dados nao seria suficiente para melhorar a rotina da instituicao. A equipe tambem precisava ser avisada sobre novas pre-inscricoes, entrar em contato rapidamente com responsaveis, registrar mensagens internas, gerar documentos e obter relatorios para analisar casos de evasao.

A terceira atividade de extensao concentrou-se nesses pontos. Foram implementados recursos que conectam o sistema a servicos de comunicacao e automatizam a producao de documentos, reduzindo tarefas repetitivas e melhorando a rastreabilidade do atendimento.

Essa atividade se enquadra como extensao porque utiliza tecnologia da informacao para resolver problemas reais de uma instituicao externa a universidade, com impacto na qualidade administrativa e social do atendimento prestado a criancas e familias.

## 2 JUSTIFICATIVA E ENQUADRAMENTO EXTENSIONISTA

Em uma ONG, a comunicacao com responsaveis e a organizacao documental sao partes essenciais do atendimento. Atrasos no contato, perda de registros ou dificuldade para gerar comprovantes podem comprometer a continuidade do processo de triagem, matricula e acompanhamento.

A integracao de notificacoes, links de WhatsApp, mensagens internas e PDFs atende a uma necessidade concreta: transformar dados cadastrados em acoes praticas. Assim, quando uma pre-inscricao e recebida, a equipe pode ser notificada; quando precisa falar com um responsavel, pode acionar o contato de forma mais rapida; quando precisa comprovar ou consultar informacoes, pode gerar documentos padronizados.

A area tematica principal e **Tecnologia e Producao**, pois a atividade desenvolve automacoes e recursos digitais para melhorar processos institucionais. Tambem se relaciona com Educacao, Saude e Direitos Humanos, porque apoia uma instituicao que atende criancas e familias.

## 3 OBJETIVOS

### 3.1 Objetivo geral

Implementar recursos de comunicacao, integracao e automacao documental no Sistema Multirao Bem, ampliando a capacidade da ONG de acompanhar atendimentos, contatar responsaveis e produzir evidencias institucionais.

### 3.2 Objetivos especificos

- Enviar notificacoes por e-mail apos nova pre-inscricao.
- Notificar a equipe administrativa da ONG sobre novos cadastros.
- Disponibilizar link direto de contato via WhatsApp para responsaveis.
- Criar central de mensagens internas entre usuarios do sistema.
- Gerar PDFs de matricula, anamnese, listagem de criancas e relatorio de evasao.
- Criar relatorio gerencial de evasao com filtros e indicadores.
- Registrar logs relacionados a envio de e-mails e geracao de documentos.
- Fornecer evidencias documentais para acompanhamento e prestacao de contas.

## 4 METODOLOGIA

A metodologia utilizada foi incremental e orientada a fluxos de comunicacao. Foram analisados pontos do processo em que a equipe da ONG precisava agir a partir das informacoes cadastradas: recebimento de pre-inscricao, contato com responsavel, consulta de dados, envio de mensagem interna e geracao de documentos.

Cada necessidade foi transformada em funcionalidade. As notificacoes foram implementadas com o sistema nativo de Notifications do Laravel. Os contatos via WhatsApp foram estruturados com links `wa.me`, utilizando telefone do responsavel. Os documentos foram automatizados com DomPDF, a partir de views Blade especificas para impressao. Os relatorios foram implementados com consultas filtradas e calculos gerenciais.

A validacao ocorreu por meio dos registros de demonstracao, dos fluxos de pre-inscricao, das telas de consulta e dos downloads de PDF.

## 5 DESENVOLVIMENTO DA ATIVIDADE

### 5.1 Notificacoes por e-mail

No fluxo de pre-inscricao, o `PreInscricaoController` dispara duas notificacoes apos o cadastro: uma para o responsavel e outra para a equipe administrativa. A notificacao ao responsavel confirma o recebimento do interesse de vaga e orienta que a equipe entrara em contato. A notificacao administrativa informa dados da crianca e do responsavel para que a triagem seja iniciada.

As classes `PreInscricaoRecebidaNotification` e `NovaInscricaoAdminNotification` foram desenvolvidas com o canal `mail` do Laravel. Essa implementacao reduz a chance de uma pre-inscricao passar despercebida e melhora a resposta institucional.

### 5.2 Registro tecnico dos envios de e-mail

O `AppServiceProvider` registra eventos de envio de e-mail por meio de listeners para `MessageSending` e `MessageSent`. Esses eventos gravam informacoes como destinatario e assunto nos logs da aplicacao.

Esse recurso auxilia no diagnostico de falhas de envio e contribui para auditoria tecnica, permitindo verificar se o sistema tentou enviar ou concluiu notificacoes.

### 5.3 Contato via WhatsApp

Foram incluidos links diretos para WhatsApp em telas de triagem, matricula, pesquisa e notificacao administrativa. Os links utilizam o formato `https://wa.me/55...`, com telefone do responsavel tratado para remover caracteres nao numericos quando necessario.

Esse recurso nao substitui o atendimento humano, mas reduz etapas manuais. A equipe deixa de copiar e colar numeros e passa a abrir o contato diretamente a partir do prontuario ou da lista de pesquisa.

### 5.4 Central de mensagens internas

O modulo de mensagens permite comunicacao entre usuarios autenticados do sistema. O `MensagemController` implementa caixa de entrada, mensagens enviadas, criacao, visualizacao, marcacao de leitura e exclusao.

As mensagens podem ser vinculadas a uma crianca, permitindo que observacoes internas fiquem relacionadas ao prontuario. Isso contribui para a continuidade do atendimento quando mais de um colaborador acompanha o mesmo caso.

### 5.5 Geracao de documentos em PDF

A automacao documental foi implementada com DomPDF. O sistema gera:

- PDF de matricula completa, com dados da crianca, responsavel, moradia, familiares e historico.
- PDF de anamnese, com dados de saude registrados no ano letivo.
- PDF de listagem de criancas filtradas por nome ou turma.
- PDF de relatorio de evasao.

Esses documentos auxiliam a ONG quando ha necessidade de arquivo fisico, reuniao, prestacao de contas ou conferencia dos dados.

### 5.6 Relatorio de evasao

O `RelatorioController` implementa relatorio de evasao com filtros por data, turma e periodo. O sistema calcula total de matriculados, total de evadidos, taxa de evasao e principal motivo de saida. Tambem separa indicadores por periodo da manha e da tarde.

Esse recurso transforma dados operacionais em informacao gerencial. Em vez de apenas registrar que uma crianca saiu, a ONG passa a conseguir observar padroes, motivos recorrentes e periodos com maior incidencia.

### 5.7 Pesquisa geral e exportacao

O `PesquisaController` permite consultar criancas por nome ou turma e exportar a listagem em PDF. Esse recurso facilita a localizacao de registros e a producao de listas para reunioes, acompanhamento interno ou organizacao das turmas.

### 5.8 Evidencias e validacao com dados de demonstracao

O `DemonstracaoSeeder` cria cenarios com diferentes status, como pre-inscricoes pendentes, criancas em turma, registros evadidos, casos aguardando anamnese e alertas de triagem. Esses dados foram usados para validar se os relatorios, notificacoes, links e documentos respondiam aos cenarios esperados.

## 6 RESULTADOS E IMPACTO SOCIAL

A atividade resultou em um conjunto de automacoes que ampliam a utilidade do sistema para a ONG. Os principais resultados foram:

- Envio de e-mail ao responsavel apos pre-inscricao.
- Envio de e-mail administrativo para nova pre-inscricao.
- Link direto de WhatsApp nas telas de atendimento.
- Mensagens internas entre usuarios do sistema.
- Geracao automatica de PDFs de matricula, anamnese, listagem e evasao.
- Relatorio gerencial de evasao com taxa, periodo e motivo principal.
- Logs tecnicos para acompanhamento de envios de e-mail.
- Melhoria da rastreabilidade documental.

O impacto social esta na agilidade de comunicacao e na capacidade da ONG de agir com base nos dados. Uma pre-inscricao comunicada rapidamente, uma familia contatada sem demora e um relatorio de evasao disponivel para analise sao melhorias que afetam a qualidade do atendimento institucional.

## 7 AVALIACAO E AUTOAVALIACAO

A avaliacao da atividade considerou se os recursos implementados reduziram tarefas repetitivas, facilitaram o contato com responsaveis e transformaram dados em documentos e indicadores.

Uma dificuldade tecnica foi integrar diferentes formas de saida da informacao: e-mail, WhatsApp, mensagens internas, PDFs e relatorios. Cada recurso possui finalidade diferente e exigiu cuidado para manter coerencia com o fluxo da ONG e com a protecao de dados pessoais.

Como autoavaliacao, a atividade fortaleceu competencias em notificacoes Laravel, eventos de e-mail, automacao documental com DomPDF, consultas gerenciais, filtros, geracao de relatorios e comunicacao digital. Tambem reforcou a importancia de criar tecnologia que ajude a equipe a agir, e nao apenas a armazenar informacoes.

## 8 CONSIDERACOES FINAIS

A terceira atividade complementou o sistema Multirao Bem com recursos de comunicacao e automacao essenciais para a rotina da ONG. As funcionalidades implementadas permitem que informacoes cadastradas se convertam em notificacoes, contatos, mensagens, documentos e indicadores.

A atividade atende aos principios da extensao universitaria porque conecta conhecimento tecnico a uma demanda social concreta, contribuindo para a organizacao e a efetividade do atendimento de uma instituicao externa a universidade.

Reforca-se que esta atividade nao se caracteriza como estagio ou atividade complementar, mas como atividade de extensao, conforme o Art. 23 do Regulamento de Extensao da UNIP.

## REFERENCIAS

BRASIL. Lei n. 13.709, de 14 de agosto de 2018. Lei Geral de Protecao de Dados Pessoais (LGPD). Diario Oficial da Uniao: Brasilia, DF, 2018.

BARRYVDH. Laravel DomPDF. Disponivel em: https://github.com/barryvdh/laravel-dompdf. Acesso em: [DATA DE ACESSO].

LARAVEL. Laravel Documentation. Disponivel em: https://laravel.com/docs. Acesso em: [DATA DE ACESSO].

META. WhatsApp Click to Chat. Disponivel em: https://faq.whatsapp.com/. Acesso em: [DATA DE ACESSO].

UNIVERSIDADE PAULISTA. Regulamento das Atividades de Extensao. Sao Paulo: UNIP, [s.d.].

UNIVERSIDADE PAULISTA. Manual de Extensao CC e SI - Marques e Chacara Santo Antonio. Sao Paulo: UNIP, [s.d.].

## APENDICE A - EVIDENCIAS RECOMENDADAS

- Print do e-mail de confirmacao de pre-inscricao.
- Print do e-mail administrativo de nova pre-inscricao.
- Print dos links de WhatsApp nas telas de triagem, matricula ou pesquisa.
- Print da central de mensagens internas.
- PDF de matricula completa gerado pelo sistema.
- PDF de anamnese gerado pelo sistema.
- PDF de listagem de criancas.
- PDF de relatorio de evasao.
- Print do `RelatorioController`.
- Print das classes de notificacao.
- Print dos logs de envio de e-mail.
- Declaracao da ONG confirmando o uso ou validacao das funcionalidades.

## APENDICE B - TEXTO PARA RELATORIO SINTESE NA PLATAFORMA

Desenvolvi recursos de integracao, comunicacao e automacao documental no Sistema Multirao Bem, projeto de extensao voltado ao apoio da ONG Multirao Bem. A atividade incluiu notificacoes por e-mail para responsaveis e administracao, links diretos para WhatsApp, central de mensagens internas, geracao de PDFs de matricula, anamnese, listagem de criancas e relatorio de evasao. Tambem foram implementados indicadores gerenciais, como taxa de evasao, filtros por periodo e principal motivo de saida. Como resultado, a ONG passou a contar com meios mais ageis de contato, documentos padronizados e informacoes para tomada de decisao. As principais dificuldades foram integrar diferentes canais de comunicacao e garantir que os dados fossem usados com responsabilidade. A atividade foi individual e devera ser comprovada por prints das notificacoes, telas, PDFs gerados, codigo-fonte e declaracao da instituicao.
