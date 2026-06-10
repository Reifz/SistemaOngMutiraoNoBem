# UNIVERSIDADE PAULISTA - UNIP

## CURSO DE [CIENCIA DA COMPUTACAO / SISTEMAS DE INFORMACAO]

**RELATORIO INDIVIDUAL DE ATIVIDADE DE EXTENSAO I**

**ENGENHARIA E MODELAGEM DE DADOS RELACIONAIS PARA GESTAO SOCIAL DA ONG MULTIRAO BEM**

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

Este relatorio apresenta a primeira atividade individual de extensao realizada para a ONG Multirao Bem, com foco na engenharia e modelagem de dados relacionais do sistema de gestao institucional. A atividade teve como finalidade substituir registros manuais e informacoes dispersas por uma base de dados estruturada, segura e preparada para acompanhar criancas, responsaveis, matriculas, moradia, composicao familiar, anamnese, turmas, mensagens e logs de auditoria. O desenvolvimento foi realizado em um projeto Laravel 13.4, com PHP 8.3+, migrations, models Eloquent e banco relacional MariaDB/MySQL. A modelagem incorporou principios de integridade referencial, historico anual de matriculas, rastreabilidade de acoes administrativas e protecao de dados sensiveis, especialmente informacoes de saude armazenadas com criptografia nativa do Laravel. Como resultado, a ONG passou a contar com uma estrutura tecnica capaz de reduzir riscos de perda de informacao, apoiar a continuidade dos atendimentos e fornecer base para os modulos web desenvolvidos nas atividades seguintes. A atividade caracteriza-se como extensao por aplicar conhecimento academico em resposta a uma necessidade concreta de uma instituicao externa, gerando beneficio social e formacao cidada.

**Palavras-chave:** extensao universitaria; banco de dados; Laravel; LGPD; ONG Multirao Bem.

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

A ONG Multirao Bem realiza atendimento socioeducativo de criancas e familias, mantendo informacoes importantes sobre pre-inscricao, responsaveis, condicoes socioeconomicas, escola, saude, turmas e acompanhamento institucional. Antes da intervencao tecnologica, parte significativa desses dados dependia de registros manuais, documentos fisicos ou planilhas isoladas, o que dificultava a consulta historica, a seguranca da informacao e a continuidade do atendimento.

Diante dessa realidade, foi desenvolvida a primeira atividade de extensao do projeto: a estruturacao da base de dados relacional do sistema Multirao Bem. Essa etapa foi essencial porque todo o funcionamento posterior do sistema web dependeria da qualidade da modelagem, da consistencia das relacoes e da capacidade de preservar dados ao longo dos anos letivos.

A atividade foi realizada como projeto de extensao universitaria, com aplicacao direta de conhecimentos de Banco de Dados, Engenharia de Software, seguranca da informacao e legislacao de protecao de dados. Conforme o Regulamento de Extensao da UNIP, a acao nao se caracteriza como estagio ou atividade complementar, mas como intervencao planejada junto a uma comunidade externa, com objetivo formativo e impacto social.

## 2 JUSTIFICATIVA E ENQUADRAMENTO EXTENSIONISTA

A extensao universitaria exige a interacao entre universidade e sociedade, a participacao ativa do estudante e a geracao de beneficio social. A presente atividade atende a esses criterios porque respondeu a uma necessidade real da ONG Multirao Bem: organizar informacoes de criancas e familias de forma confiavel, segura e rastreavel.

O problema enfrentado pela instituicao nao era apenas tecnico. A ausencia de uma base unica dificultava a visualizacao do historico da crianca, a identificacao de responsaveis, a consulta de dados socioeconomicos e o controle de etapas do atendimento. Em uma organizacao que lida com informacoes de criancas, familiares e dados de saude, a modelagem inadequada poderia gerar perda de dados, duplicidade, falhas de atendimento e riscos relacionados a Lei Geral de Protecao de Dados Pessoais (LGPD).

O enquadramento tematico da atividade e **Tecnologia e Producao**, pois a solucao desenvolvida utiliza tecnologia da informacao para aprimorar processos produtivos e administrativos de uma organizacao social. Tambem ha relacao indireta com Educacao, Saude e Direitos Humanos, visto que o sistema apoia o atendimento de criancas e familias em contexto social.

## 3 OBJETIVOS

### 3.1 Objetivo geral

Projetar e implementar uma base de dados relacional para sustentar o sistema de gestao da ONG Multirao Bem, garantindo integridade, seguranca, rastreabilidade e capacidade de acompanhamento historico dos atendimentos.

### 3.2 Objetivos especificos

- Levantar as entidades principais envolvidas no fluxo da ONG.
- Modelar tabelas para criancas, responsaveis, contatos, familia, moradia, anamnese, turmas, anos letivos, matriculas, inscricoes, mensagens, usuarios e auditoria.
- Criar relacionamentos coerentes entre as entidades por meio de chaves estrangeiras.
- Permitir multiplos responsaveis para uma mesma crianca por meio de tabela associativa.
- Separar dados permanentes da crianca de dados variaveis por ano letivo.
- Registrar trilhas de auditoria para acoes administrativas relevantes.
- Proteger dados sensiveis de saude por meio de criptografia.
- Criar dados de demonstracao para validar o fluxo do sistema.

## 4 METODOLOGIA

A metodologia adotada foi aplicada e incremental, partindo do levantamento de requisitos ate a implementacao fisica do banco de dados. Inicialmente, foram identificadas as informacoes que a ONG precisava registrar para atender criancas e familias: dados cadastrais, responsaveis, contatos, escola, composicao familiar, moradia, situacao socioeconomica, anamnese, turma, evasao e historico anual.

Em seguida, as informacoes foram agrupadas em entidades relacionais e convertidas em migrations do Laravel. O uso de migrations permitiu versionar a estrutura do banco, registrar alteracoes sucessivas e manter coerencia entre ambiente de desenvolvimento e ambiente de validacao.

Tambem foram criados models Eloquent para representar as entidades da aplicacao. Essa estrategia permitiu mapear relacionamentos como `hasMany`, `belongsTo`, `belongsToMany` e `hasOne`, reduzindo consultas manuais e deixando o sistema preparado para os controllers e views das etapas seguintes.

Por fim, foi criado um seeder de demonstracao com registros simulados, turmas, ano letivo ativo, status de atendimento e logs de auditoria. Essa base de testes serviu para validar se a modelagem atendia aos cenarios esperados pela ONG.

## 5 DESENVOLVIMENTO DA ATIVIDADE

### 5.1 Estrutura relacional principal

A base de dados foi estruturada em tabelas institucionais e operacionais. Entre as tabelas principais do dominio da ONG estao:

- `criancas`, para dados centrais da crianca atendida.
- `responsaveis`, para dados dos responsaveis legais ou familiares.
- `crianca_responsavel`, para vincular uma crianca a mais de um responsavel.
- `contatos`, para multiplos telefones ou contatos de recado.
- `familiares`, para composicao familiar e dados socioeconomicos.
- `moradias`, para endereco, CEP, bairro, condicao habitacional e numero de moradores.
- `inscricoes`, para registro da pre-inscricao e seu status.
- `anamnese`, para dados de saude da crianca.
- `turmas`, para organizacao de grupos, turno, capacidade e faixa etaria.
- `anos_letivos`, para controle de ciclos anuais.
- `matriculas`, para historico escolar e institucional por ano letivo.
- `mensagens`, para comunicacao interna entre usuarios.
- `logs_auditoria`, para rastreabilidade das acoes.
- `users`, para usuarios administrativos, perfis e controle de acesso.

Essa divisao permitiu separar informacoes de natureza diferente. Dados permanentes, como nome da crianca e dados basicos, ficam em `criancas`; dados que podem mudar a cada ano, como serie, escola, status e turma, ficam em `matriculas`; dados sensiveis de saude ficam em `anamnese`; e acoes administrativas ficam em `logs_auditoria`.

### 5.2 Relacionamentos e integridade referencial

A modelagem utilizou chaves estrangeiras para reduzir inconsistencias. A tabela `criancas` se relaciona com `responsaveis`, `turmas`, `moradias`, `familiares`, `anamnese`, `matriculas`, `inscricoes` e `logs_auditoria`. A tabela `crianca_responsavel` permite representar arranjos familiares reais, como mae, pai, avo ou outro responsavel associado a uma mesma crianca.

Essa decisao foi importante porque a realidade das familias atendidas pela ONG nao segue sempre um unico padrao. Algumas criancas podem morar com um responsavel diferente da mae ou do pai, podem ter contatos de recado e podem possuir mais de um adulto vinculado ao acompanhamento institucional.

### 5.3 Historico anual de matriculas

Um ponto central da atividade foi a criacao da tabela `anos_letivos` e da tabela `matriculas`. Antes dessa separacao, dados como escola, serie, periodo e status ficariam presos ao cadastro principal da crianca, dificultando a preservacao historica.

Com a estrutura anual, uma mesma crianca pode ter uma matricula em 2026, outra em 2027 e assim sucessivamente. Isso permite acompanhar rematriculas, mudancas de serie, alteracoes de turma, evasao, desligamento e retorno, sem apagar registros anteriores. Essa decisao melhora a memoria institucional da ONG e permite analises futuras sobre permanencia e evasao.

### 5.4 Protecao de dados sensiveis e LGPD

A tabela `anamnese` armazena dados de saude em um campo `dados_json`. No model `Anamnese`, esse campo foi configurado com o cast `encrypted:array`, recurso nativo do Laravel que criptografa e descriptografa automaticamente o conteudo. Essa abordagem foi adotada porque dados de saude sao sensiveis e exigem tratamento cuidadoso conforme a LGPD.

A pre-inscricao tambem registra consentimento LGPD do responsavel e data do consentimento. Assim, a base de dados contempla tanto a protecao tecnica dos dados quanto o registro da autorizacao de tratamento.

### 5.5 Logs de auditoria

A tabela `logs_auditoria` foi criada para registrar usuario, acao, tabela afetada, registro, detalhes e data/hora. Essa estrutura foi usada posteriormente nos fluxos de triagem, matricula, anamnese, turmas, rematricula e evasao.

Os logs contribuem para transparencia e prestacao de contas, pois permitem identificar quando determinada crianca mudou de status, quem realizou a alteracao e qual foi a justificativa. Em uma organizacao social, esse controle e relevante para evitar perda de contexto e melhorar a confiabilidade do atendimento.

### 5.6 Dados de demonstracao

O `DemonstracaoSeeder` foi criado para popular o banco com ano letivo ativo, turmas e registros simulados em diferentes fases: pre-inscricao, triagem atrasada, aguardando anamnese, em turma, evadida e pendente de aprovacao. Tambem foram incluidos logs de auditoria simulando eventos reais do fluxo.

Esse recurso permitiu validar a modelagem com cenarios variados, testar filtros, indicadores e fluxos antes da utilizacao pela ONG.

## 6 RESULTADOS E IMPACTO SOCIAL

A atividade resultou em uma base relacional preparada para sustentar a gestao completa da ONG Multirao Bem. A instituicao passou a ter uma estrutura capaz de centralizar informacoes que antes poderiam ficar dispersas em fichas, planilhas ou documentos fisicos.

Os principais resultados foram:

- Organizacao dos dados de criancas, responsaveis, familia, moradia, anamnese e turmas.
- Reducao do risco de duplicidade e perda de informacoes.
- Possibilidade de acompanhamento historico por ano letivo.
- Registro de consentimento e protecao de dados sensiveis.
- Rastreabilidade de acoes administrativas.
- Preparacao tecnica para dashboards, relatorios e automacao documental.
- Base de dados de demonstracao com 14 cenarios simulados para validacao dos fluxos.

O impacto social esta na melhoria da capacidade da ONG de acompanhar criancas e familias com maior seguranca, continuidade e confiabilidade. Embora a atividade tenha sido tecnica, seu resultado apoia diretamente o atendimento social realizado pela instituicao.

## 7 AVALIACAO E AUTOAVALIACAO

A avaliacao da atividade considerou a aderencia da modelagem as necessidades reais da ONG, a consistencia dos relacionamentos, a protecao de dados sensiveis e a capacidade de sustentar fluxos futuros de atendimento.

Durante o desenvolvimento, uma dificuldade relevante foi traduzir a complexidade social dos atendimentos em uma estrutura relacional simples o suficiente para ser mantida, mas completa o bastante para representar responsaveis, familiares, moradia, escola, saude e historico anual.

Do ponto de vista formativo, a atividade fortaleceu competencias em modelagem de dados, normalizacao, integridade referencial, migrations, Eloquent ORM, seguranca e LGPD. Tambem evidenciou que um banco de dados mal estruturado pode prejudicar diretamente a qualidade de um servico social.

## 8 CONSIDERACOES FINAIS

A primeira atividade de extensao consolidou a base tecnica do sistema Multirao Bem. A modelagem relacional permitiu transformar demandas institucionais da ONG em uma estrutura persistente, segura e preparada para evoluir.

A acao atende aos principios da extensao universitaria porque aplicou conhecimento academico em beneficio de uma organizacao externa, gerando impacto social indireto, mas essencial: a melhoria da gestao das informacoes usadas no atendimento de criancas e familias.

Reforca-se que esta atividade nao se caracteriza como estagio ou atividade complementar, mas como atividade de extensao, conforme o Art. 23 do Regulamento de Extensao da UNIP.

## REFERENCIAS

BRASIL. Lei n. 13.709, de 14 de agosto de 2018. Lei Geral de Protecao de Dados Pessoais (LGPD). Diario Oficial da Uniao: Brasilia, DF, 2018.

DATE, C. J. Introducao a sistemas de bancos de dados. Rio de Janeiro: Elsevier, 2004.

ELMASRI, Ramez; NAVATHE, Shamkant B. Sistemas de banco de dados. 6. ed. Sao Paulo: Pearson, 2011.

LARAVEL. Laravel Documentation. Disponivel em: https://laravel.com/docs. Acesso em: [DATA DE ACESSO].

UNIVERSIDADE PAULISTA. Regulamento das Atividades de Extensao. Sao Paulo: UNIP, [s.d.].

UNIVERSIDADE PAULISTA. Manual de Extensao CC e SI - Marques e Chacara Santo Antonio. Sao Paulo: UNIP, [s.d.].

## APENDICE A - EVIDENCIAS RECOMENDADAS

- Prints das migrations principais.
- Prints dos models `Crianca`, `Responsavel`, `Anamnese`, `Matricula` e `AnoLetivo`.
- Print do campo `dados_json` com cast `encrypted:array`.
- Print da tabela ou migration `logs_auditoria`.
- Print do `DemonstracaoSeeder`.
- Diagrama entidade-relacionamento, se disponivel.
- Declaracao da ONG confirmando a atividade.

## APENDICE B - TEXTO PARA RELATORIO SINTESE NA PLATAFORMA

Desenvolvi a modelagem e a estrutura relacional do banco de dados do Sistema Multirao Bem, projeto de extensao voltado ao apoio administrativo da ONG Multirao Bem. A atividade envolveu levantamento de entidades, criacao de migrations, definicao de relacionamentos, historico anual de matriculas, logs de auditoria e protecao de dados sensiveis de anamnese por criptografia. Como resultado, a ONG passou a contar com uma base estruturada para registrar criancas, responsaveis, familiares, moradia, turmas, matriculas, anamnese e acoes administrativas. A atividade contribuiu para reduzir riscos de perda de informacao, melhorar a rastreabilidade e preparar a instituicao para uma gestao digital mais segura. As principais dificuldades foram transformar processos sociais complexos em uma modelagem consistente e garantir aderencia a LGPD. A atividade foi individual e devera ser comprovada por prints do banco, codigo, registros de teste e declaracao da ONG.
