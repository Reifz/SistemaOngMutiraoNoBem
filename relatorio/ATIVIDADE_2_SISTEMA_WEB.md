# UNIVERSIDADE PAULISTA - UNIP

## CURSO DE [CIENCIA DA COMPUTACAO / SISTEMAS DE INFORMACAO]

**RELATORIO INDIVIDUAL DE ATIVIDADE DE EXTENSAO II**

**DESENVOLVIMENTO DE SISTEMA WEB PARA TRIAGEM, MATRICULA, ANAMNESE E GESTAO DE TURMAS DA ONG MULTIRAO BEM**

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

Este relatorio apresenta a segunda atividade individual de extensao realizada para a ONG Multirao Bem, com foco no desenvolvimento do sistema web responsavel por transformar o fluxo administrativo da instituicao em uma plataforma digital. A atividade compreendeu a implementacao de pre-inscricao publica, triagem, matricula socioeconomica, anamnese, gestao de turmas, rematricula, controle de usuarios, dashboard e historico de atendimento. A aplicacao foi desenvolvida em Laravel 13.4, PHP 8.3+, Blade, Tailwind CSS, Vite e banco relacional MariaDB/MySQL. O sistema utiliza arquitetura MVC, rotas protegidas por autenticacao, controle administrativo, models Eloquent, formularios estruturados, armazenamento de anexos e logs de auditoria. A solucao contribuiu para substituir processos manuais por fluxos digitais rastreaveis, reduzir retrabalho, facilitar a consulta de informacoes e apoiar o atendimento de criancas e familias acompanhadas pela ONG. A atividade caracteriza-se como extensao por aplicar conhecimentos de desenvolvimento web em uma demanda real de uma instituicao externa, promovendo impacto social e desenvolvimento formativo do aluno.

**Palavras-chave:** desenvolvimento web; Laravel; sistema de gestao; extensao universitaria; ONG.

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

A ONG Multirao Bem atua no atendimento de criancas e familias, demandando processos organizados para pre-inscricao, triagem, matricula, coleta de dados socioeconomicos, registro de saude e alocacao em turmas. Antes da digitalizacao, esses processos dependiam de fichas, conferencias manuais e consultas descentralizadas, o que gerava retrabalho e dificultava a continuidade do atendimento.

A segunda atividade de extensao consistiu no desenvolvimento da aplicacao web que operacionaliza a base de dados estruturada na primeira atividade. A plataforma foi criada para permitir que usuarios autenticados da ONG acompanhem o ciclo de atendimento da crianca desde o primeiro interesse de vaga ate a conclusao da anamnese e alocacao em turma.

A atividade se enquadra como extensao porque responde a uma necessidade concreta de uma organizacao social externa a universidade, utilizando conhecimentos de programacao, arquitetura MVC, experiencia do usuario, seguranca da informacao e gestao de processos.

## 2 JUSTIFICATIVA E ENQUADRAMENTO EXTENSIONISTA

A digitalizacao de processos administrativos em uma ONG tem impacto direto na qualidade do atendimento prestado. Quando informacoes de criancas e familias ficam dispersas, a equipe precisa repetir consultas, localizar documentos manualmente e depender de memoria institucional para saber em qual etapa cada atendimento se encontra.

O sistema web desenvolvido buscou resolver esse problema por meio de uma interface organizada, com filtros, status, telas de consulta, formularios completos e historico das acoes. Dessa forma, a tecnologia foi aplicada como meio de fortalecimento institucional e nao apenas como exercicio tecnico.

A area tematica principal e **Tecnologia e Producao**, pois o trabalho desenvolveu um produto de software aplicado a um processo real. A atividade tambem dialoga com Educacao, Saude e Direitos Humanos, pois apoia o atendimento de criancas e familias em situacao de vulnerabilidade ou acompanhamento social.

## 3 OBJETIVOS

### 3.1 Objetivo geral

Desenvolver uma plataforma web para organizar e automatizar o fluxo de atendimento da ONG Multirao Bem, desde a pre-inscricao ate a gestao de turmas.

### 3.2 Objetivos especificos

- Criar formulario publico de pre-inscricao com consentimento LGPD.
- Implementar tela de triagem com filtros, visualizacao e aprovacao/rejeicao.
- Desenvolver modulo de matricula com dados cadastrais, responsaveis, contatos, moradia, familiares e anexos.
- Implementar anamnese digital com dados de saude protegidos.
- Criar gestao de turmas com capacidade, turno, faixa etaria e alocacao de criancas.
- Permitir rematricula e controle por ano letivo.
- Disponibilizar dashboard com alertas operacionais.
- Registrar logs de auditoria em acoes relevantes.
- Criar controle de usuarios e acesso administrativo.

## 4 METODOLOGIA

A metodologia utilizada foi incremental, com desenvolvimento por modulos. Primeiro, foram definidos os fluxos principais da ONG: pre-inscricao, triagem, matricula, anamnese, turma e rematricula. Depois, cada fluxo foi convertido em rotas, controllers, views e models no Laravel.

A implementacao seguiu a arquitetura MVC. Os controllers concentraram a coordenacao dos fluxos, os models representaram as entidades persistidas e as views Blade apresentaram formularios, listagens e telas de consulta. A interface foi desenvolvida com Tailwind CSS, buscando clareza visual, organizacao das informacoes e facilidade de uso para a equipe da ONG.

A validacao foi feita com dados de demonstracao e cenarios simulados, incluindo criancas em diferentes etapas: aguardando triagem, pendente de matricula, pendente de aprovacao, aprovada, com anamnese concluida, em turma e evadida.

## 5 DESENVOLVIMENTO DA ATIVIDADE

### 5.1 Arquitetura da aplicacao

O sistema foi desenvolvido com Laravel 13.4 e PHP 8.3+, utilizando Blade para renderizacao das telas, Vite para empacotamento de assets e Tailwind CSS para estilização. As rotas principais estao organizadas em `routes/web.php`, com areas publicas e areas protegidas por autenticacao.

As rotas publicas atendem a pre-inscricao. As rotas internas exigem usuario autenticado e incluem pesquisa, triagem, matricula, anamnese, rematricula, turmas, usuarios, mensagens e relatorios.

### 5.2 Pre-inscricao publica

O formulario de pre-inscricao permite que o responsavel informe dados da crianca, escola, serie, periodo, dados de contato e aceite LGPD. No `PreInscricaoController`, os dados sao validados, o responsavel e criado ou atualizado por e-mail, e a crianca e registrada com status inicial `PREENCHER`.

Esse modulo representa a porta de entrada digital da ONG. Ele reduz a dependencia de fichas fisicas e permite que a equipe receba informacoes iniciais de forma padronizada.

### 5.3 Triagem

O `TriagemController` implementa a listagem das pre-inscricoes, filtros por status, nome e periodo, visualizacao detalhada e alteracao de status para `PENDENTE_MATRICULA` ou `REJEITADO`. Quando uma crianca e aprovada na triagem, o sistema sincroniza a etapa com a tabela de matriculas do ano letivo ativo.

Cada alteracao relevante gera registro em `logs_auditoria`, garantindo rastreabilidade do processo decisorio.

### 5.4 Matricula socioeconomica

O modulo de matricula foi desenvolvido no `MatriculaController` e contempla um formulario amplo para registrar dados da crianca, mae, pai, responsavel principal, contatos, moradia, familiares e anexos documentais.

O sistema permite armazenar documentos como RG, CPF, certidao, comprovante de residencia, comprovante escolar e comprovante de renda. Tambem registra dados socioeconomicos, como Cadastro Unico, transferencia de renda, BPC, profissao, desemprego e composicao familiar.

Ao finalizar o preenchimento, a crianca muda para status de aprovacao, permitindo que a equipe revise os dados antes de liberar a anamnese. Essa divisao reduz erros e cria um fluxo administrativo mais controlado.

### 5.5 Anamnese digital

O modulo de anamnese permite registrar informacoes de saude associadas a crianca e ao ano letivo ativo. O `AnamneseController` salva os dados em estrutura JSON criptografada, utilizando o model `Anamnese` com cast `encrypted:array`.

Essa funcionalidade e relevante porque dados de saude sao sensiveis e exigem tratamento cuidadoso. A anamnese digital tambem evita perda de formularios fisicos e facilita a consulta pela equipe tecnica autorizada.

### 5.6 Gestao de turmas

O `TurmaController` implementa cadastro, edicao, exclusao, visualizacao e alocacao de criancas em turmas. Cada turma possui nome, turno, capacidade, idade minima, idade maxima, status ativo e descricao.

O sistema impede alocacao acima da capacidade configurada e altera o status da crianca para `EM_TURMA` quando a alocacao e concluida. Tambem permite remover uma crianca da turma, retornando-a ao status adequado para nova alocacao.

### 5.7 Rematricula e ano letivo

O modulo de rematricula utiliza `AnoLetivo`, `Matricula` e `RematriculaController` para permitir controle de periodos e inicio de novos ciclos. Uma crianca pode receber nova matricula em outro ano letivo, preservando o historico anterior.

Esse recurso e essencial para uma ONG que atende criancas de forma continuada, pois evita sobrescrever informacoes antigas e permite acompanhar evolucao escolar e institucional.

### 5.8 Dashboard, pesquisa e usuarios

A tela inicial apresenta informacoes operacionais, como aniversariantes do dia e alertas de triagem com mais de sete dias. O modulo de pesquisa permite consulta geral de criancas e exportacao de listagens em PDF.

O sistema tambem possui controle de usuarios com papel administrativo e status ativo/inativo. Esse controle contribui para seguranca, pois limita acoes sensiveis a perfis autorizados.

## 6 RESULTADOS E IMPACTO SOCIAL

A segunda atividade entregou uma plataforma web funcional para apoiar a rotina administrativa da ONG Multirao Bem. O sistema organiza etapas que antes poderiam depender de fichas, planilhas ou comunicacao informal.

Os principais resultados foram:

- Pre-inscricao digital com consentimento LGPD.
- Triagem com filtros, visualizacao e historico.
- Matricula socioeconomica detalhada.
- Registro de moradia, contatos e familiares.
- Anamnese digital com criptografia.
- Gestao de turmas com controle de capacidade.
- Rematricula e acompanhamento por ano letivo.
- Controle de usuarios administrativos.
- Dashboard com alertas operacionais.
- Logs de auditoria para rastrear alteracoes.

O impacto social esta na melhoria do atendimento institucional. Com dados organizados, a equipe da ONG pode localizar informacoes mais rapidamente, reduzir retrabalho, acompanhar etapas pendentes e prestar atendimento mais consistente a criancas e familias.

## 7 AVALIACAO E AUTOAVALIACAO

A avaliacao da atividade considerou a aderencia dos modulos aos processos da ONG, a clareza dos fluxos, a rastreabilidade das etapas e a capacidade do sistema de reduzir tarefas manuais.

Durante o desenvolvimento, uma das principais dificuldades foi transformar um processo social, com excecoes e variacoes familiares, em um fluxo digital organizado sem engessar o atendimento. Foi necessario equilibrar campos obrigatorios, etapas de aprovacao, dados sensiveis e usabilidade.

Como autoavaliacao, a atividade fortaleceu competencias em desenvolvimento web com Laravel, arquitetura MVC, Eloquent ORM, validacao de formularios, controle de acesso, interface responsiva e seguranca. Tambem trouxe aprendizado etico sobre o cuidado necessario ao lidar com informacoes de criancas, familias e saude.

## 8 CONSIDERACOES FINAIS

O desenvolvimento do sistema web representou uma etapa central do projeto de extensao. A aplicacao converteu a base de dados em uma ferramenta utilizavel pela ONG, permitindo que a tecnologia se tornasse parte do fluxo real de atendimento.

A atividade atende aos criterios da extensao universitaria porque uniu formacao academica, aplicacao pratica, interacao com comunidade externa e beneficio social. O sistema nao foi desenvolvido como produto isolado, mas como resposta a uma necessidade concreta da ONG Multirao Bem.

Reforca-se que esta atividade nao se caracteriza como estagio ou atividade complementar, mas como atividade de extensao, conforme o Art. 23 do Regulamento de Extensao da UNIP.

## REFERENCIAS

BRASIL. Lei n. 13.709, de 14 de agosto de 2018. Lei Geral de Protecao de Dados Pessoais (LGPD). Diario Oficial da Uniao: Brasilia, DF, 2018.

LARAVEL. Laravel Documentation. Disponivel em: https://laravel.com/docs. Acesso em: [DATA DE ACESSO].

NIELSEN, Jakob. Usabilidade na web: projetando websites com qualidade. Rio de Janeiro: Elsevier, 2007.

TAILWIND LABS. Tailwind CSS Documentation. Disponivel em: https://tailwindcss.com/docs. Acesso em: [DATA DE ACESSO].

UNIVERSIDADE PAULISTA. Regulamento das Atividades de Extensao. Sao Paulo: UNIP, [s.d.].

UNIVERSIDADE PAULISTA. Manual de Extensao CC e SI - Marques e Chacara Santo Antonio. Sao Paulo: UNIP, [s.d.].

## APENDICE A - EVIDENCIAS RECOMENDADAS

- Prints do formulario publico de pre-inscricao.
- Prints da tela de triagem.
- Prints do formulario de matricula.
- Prints da anamnese.
- Prints da gestao de turmas.
- Prints do dashboard e pesquisa.
- Prints dos controllers `PreInscricaoController`, `TriagemController`, `MatriculaController`, `AnamneseController` e `TurmaController`.
- Prints dos logs de auditoria.
- Declaracao da ONG confirmando a utilizacao/validacao do sistema.

## APENDICE B - TEXTO PARA RELATORIO SINTESE NA PLATAFORMA

Desenvolvi a plataforma web do Sistema Multirao Bem, voltada a digitalizacao do fluxo de atendimento da ONG Multirao Bem. A atividade envolveu implementacao de pre-inscricao publica com consentimento LGPD, triagem, matricula socioeconomica, anamnese digital, gestao de turmas, rematricula, dashboard, pesquisa e controle de usuarios. O sistema foi desenvolvido em Laravel 13.4, PHP 8.3+, Blade e Tailwind CSS, com arquitetura MVC e registros de auditoria em etapas sensiveis. Como resultado, a ONG passou a contar com um fluxo digital mais organizado, reduzindo retrabalho e melhorando a consulta de informacoes sobre criancas e familias. As principais dificuldades foram adaptar processos sociais complexos a uma interface clara e segura. A atividade foi individual e devera ser comprovada por prints do sistema, codigo-fonte, logs e declaracao da instituicao.
