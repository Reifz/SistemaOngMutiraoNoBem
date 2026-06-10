# UNIVERSIDADE PAULISTA - UNIP

## CURSO DE [CIENCIA DA COMPUTACAO / SISTEMAS DE INFORMACAO]

**RELATORIO INDIVIDUAL DE ATIVIDADE DE EXTENSAO IV**

**CRIACAO DE ROTA PUBLICA DE PRE-TRIAGEM E IMPLEMENTACAO NO SITE INSTITUCIONAL .ORG DA ONG MULTIRAO BEM**

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

Este relatorio apresenta a quarta atividade individual de extensao realizada para a ONG Multirao Bem, com foco na criacao de uma rota publica de pre-triagem e na sua disponibilizacao no site institucional de dominio `.org` da entidade. A atividade consistiu no planejamento, desenvolvimento, validacao e integracao de um formulario publico para entrada inicial de dados de familias interessadas no atendimento da ONG. A rota foi estruturada para funcionar sem autenticacao administrativa, mantendo a area interna protegida, e para coletar informacoes essenciais da crianca, do responsavel, do contato, da escola, do periodo de interesse e do consentimento para tratamento de dados pessoais. A implementacao foi realizada no sistema web desenvolvido em Laravel 13.4, PHP 8.3+, Blade, Tailwind CSS, Vite e banco relacional MariaDB/MySQL. A publicacao do formulario no site `.org` ampliou o acesso das familias ao processo de atendimento, reduziu a dependencia de fichas fisicas e mensagens informais, e permitiu que a equipe da ONG recebesse solicitacoes iniciais de forma padronizada, rastreavel e mais segura. A atividade caracteriza-se como extensao universitaria por aplicar conhecimentos de desenvolvimento web, experiencia do usuario, seguranca da informacao e LGPD em beneficio de uma organizacao social externa a universidade.

**Palavras-chave:** rota publica; pre-triagem; formulario web; LGPD; extensao universitaria.

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

A ONG Multirao Bem realiza atendimento socioeducativo de criancas e familias, necessitando de um fluxo organizado para receber interessados, verificar dados iniciais e encaminhar casos para analise da equipe. Antes da digitalizacao, o primeiro contato poderia ocorrer por mensagens, conversas presenciais, anotacoes ou fichas em papel, criando risco de perda de informacao, duplicidade de cadastros e dificuldade para acompanhar a ordem de chegada das solicitacoes.

Nesse contexto, foi desenvolvida uma rota publica de pre-triagem. A finalidade dessa rota foi criar uma porta de entrada digital, acessivel pelo site institucional `.org` da ONG, para que os responsaveis pudessem registrar os dados iniciais da crianca antes da analise administrativa. A pre-triagem nao substitui a avaliacao da equipe, mas organiza a coleta inicial e envia as informacoes para o sistema interno.

A atividade se enquadra como extensao universitaria porque atende a uma demanda real de uma organizacao externa a universidade. O trabalho aplicou conhecimentos de Engenharia de Software, desenvolvimento web, validacao de formularios, seguranca da informacao, experiencia do usuario e protecao de dados pessoais, gerando beneficio direto para a rotina institucional da ONG e para as familias atendidas.

## 2 JUSTIFICATIVA E ENQUADRAMENTO EXTENSIONISTA

A etapa inicial de atendimento e uma das mais importantes para uma instituicao social. Quando o primeiro cadastro e feito de maneira informal, a equipe pode ter dificuldade para identificar quem solicitou vaga, qual crianca precisa de atendimento, qual responsavel deve ser contatado e quais dados ja foram informados. Essa situacao gera retrabalho e pode prejudicar familias que dependem de uma resposta organizada.

A criacao da rota publica de pre-triagem buscou resolver esse problema por meio de um formulario unico, padronizado e integrado ao sistema de gestao da ONG. A disponibilizacao desse formulario no site institucional `.org` tornou o processo mais acessivel, pois o responsavel pode iniciar a solicitacao diretamente pelo canal oficial da entidade, sem precisar depender exclusivamente de atendimento presencial ou troca de mensagens.

Do ponto de vista extensionista, a atividade atende aos criterios previstos para a extensao universitaria: interacao com a comunidade externa, aplicacao de conhecimento academico, resposta a uma necessidade concreta, impacto social e desenvolvimento formativo do aluno. A area tematica principal e **Tecnologia e Producao**, pois a solucao desenvolvida utiliza tecnologia da informacao para qualificar o processo de atendimento da ONG. Tambem ha relacao com Educacao, Saude e Direitos Humanos, pois a instituicao atende criancas e familias que necessitam de acompanhamento organizado e responsavel.

A atividade foi desenvolvida como projeto de extensao universitario, nao sendo contabilizada como estagio ou atividade complementar, em conformidade com o Art. 23 do Regulamento de Extensao da UNIP.

## 3 OBJETIVOS

### 3.1 Objetivo geral

Criar, validar e disponibilizar uma rota publica de pre-triagem no site institucional `.org` da ONG Multirao Bem, permitindo que familias registrem dados iniciais de atendimento de forma padronizada, segura e integrada ao sistema interno da instituicao.

### 3.2 Objetivos especificos

- Definir o fluxo de entrada publica para interessados no atendimento da ONG.
- Criar uma rota publica acessivel sem login administrativo.
- Desenvolver formulario de pre-triagem com campos objetivos e linguagem clara.
- Coletar dados essenciais da crianca, responsavel, contato, escola, serie, periodo e observacoes iniciais.
- Registrar aceite de consentimento para tratamento de dados pessoais conforme a LGPD.
- Validar os campos obrigatorios antes do envio.
- Evitar que a rota publica exponha telas ou dados administrativos.
- Integrar o formulario ao banco de dados do Sistema Multirao Bem.
- Encaminhar as solicitacoes recebidas para a tela interna de triagem da equipe.
- Disponibilizar o acesso ao formulario no site institucional `.org` da ONG.
- Produzir evidencias da criacao, testes e publicacao da funcionalidade.

## 4 METODOLOGIA

A metodologia adotada foi incremental e orientada ao fluxo real de atendimento da ONG. Inicialmente, foi analisado o problema do primeiro contato das familias com a instituicao. Em seguida, foram definidos os dados minimos necessarios para uma pre-triagem, evitando tanto a coleta insuficiente quanto a exigencia excessiva de informacoes antes da analise da equipe.

Depois da definicao dos campos, a funcionalidade foi transformada em rota publica, controller, validacoes, view Blade e persistencia no banco de dados. O desenvolvimento considerou a separacao entre area publica e area administrativa: a familia acessa apenas o formulario de pre-triagem, enquanto a equipe da ONG acessa os registros recebidos em ambiente autenticado.

A interface foi desenvolvida com foco em clareza e responsividade, permitindo uso em computador e celular. Foram utilizados componentes visuais simples, mensagens de erro por campo, confirmacao de envio e orientacao objetiva sobre o tratamento dos dados pessoais.

Por fim, a rota foi vinculada ao site institucional `.org` da ONG. Essa etapa consistiu em disponibilizar o link publico do formulario no canal oficial da entidade, permitindo que o acesso externo fosse feito de forma direta e reconhecivel pelas familias.

## 5 DESENVOLVIMENTO DA ATIVIDADE

### 5.1 Levantamento do fluxo de pre-triagem

O primeiro passo foi separar conceitualmente a pre-triagem da triagem interna. A pre-triagem corresponde ao preenchimento inicial realizado pelo responsavel, em ambiente publico, antes de qualquer aprovacao ou analise administrativa. A triagem interna, por sua vez, e realizada pela equipe da ONG em area protegida do sistema, com possibilidade de verificar dados, entrar em contato com a familia e encaminhar a crianca para as proximas etapas.

Essa separacao foi importante para proteger o fluxo institucional. A rota publica deve receber dados, mas nao deve permitir visualizacao de listas, alteracao de status, acesso a documentos, consulta de criancas cadastradas ou qualquer acao administrativa.

### 5.2 Criacao da rota publica

A rota publica foi definida no arquivo de rotas web do Laravel, em area separada das rotas protegidas por autenticacao. O objetivo foi permitir que qualquer responsavel com o link pudesse acessar o formulario, sem exigir usuario e senha, mas mantendo o restante do sistema fechado para a equipe autorizada.

Foram previstas duas acoes principais:

- exibicao do formulario de pre-triagem, por meio de requisicao `GET`;
- envio dos dados preenchidos, por meio de requisicao `POST`.

Essa divisao segue o padrao web convencional e facilita a manutencao. A rota de exibicao apresenta a tela ao usuario, enquanto a rota de envio executa a validacao, registra as informacoes e retorna a confirmacao de recebimento.

### 5.3 Desenvolvimento do formulario de pre-triagem

O formulario foi criado para reunir informacoes essenciais, suficientes para que a ONG compreenda o perfil inicial da solicitacao. Entre os grupos de dados previstos estao:

- dados da crianca, como nome completo, data de nascimento e idade aproximada;
- dados escolares, como escola, serie, periodo e situacao de estudo;
- dados do responsavel, como nome, parentesco, telefone, WhatsApp e e-mail;
- endereco ou bairro, quando necessario para avaliacao territorial;
- periodo de interesse ou disponibilidade da familia;
- observacoes iniciais sobre necessidades, contexto familiar ou motivo da procura;
- aceite de consentimento para tratamento de dados pessoais.

A organizacao dos campos buscou reduzir erros de preenchimento. Informacoes relacionadas foram agrupadas em blocos logicos, com rotulos claros e campos obrigatorios apenas quando necessarios para o primeiro contato. Essa escolha respeita o principio de minimizacao de dados da LGPD, pois evita solicitar informacoes excessivas antes da etapa formal de matricula.

### 5.4 Validacao dos dados enviados

No envio do formulario, o sistema executa validacoes para garantir consistencia minima das informacoes. Campos como nome da crianca, nome do responsavel, telefone de contato e aceite LGPD foram tratados como obrigatorios. Campos de e-mail e data foram validados conforme formato esperado.

Quando ha erro de preenchimento, o usuario recebe mensagens de orientacao e pode corrigir os dados antes do envio definitivo. Essa abordagem melhora a qualidade dos registros recebidos e reduz retrabalho da equipe da ONG, que passa a lidar com solicitacoes mais completas e padronizadas.

### 5.5 Consentimento LGPD e protecao de dados pessoais

A pre-triagem envolve dados pessoais de criancas e responsaveis. Por isso, o formulario inclui campo de consentimento para tratamento de dados, informando que as informacoes serao usadas pela ONG para fins de analise inicial, contato e continuidade do processo de atendimento.

O registro do consentimento e parte essencial da implementacao, pois demonstra cuidado com a Lei Geral de Protecao de Dados Pessoais. Alem disso, a rota publica foi planejada para coletar apenas dados necessarios a etapa inicial. Informacoes mais sensiveis, como dados detalhados de saude, permanecem reservadas para etapas internas posteriores, como matricula e anamnese, com controle de acesso administrativo.

### 5.6 Integracao com o banco de dados e status inicial

Apos o envio valido, o sistema registra a solicitacao no banco de dados relacional. O cadastro recebe status inicial correspondente a pre-triagem ou aguardando analise, permitindo que a equipe identifique quais registros ainda precisam ser avaliados.

Essa integracao evita que as solicitacoes fiquem perdidas em mensagens ou anotacoes. Cada envio passa a gerar um registro estruturado, consultavel no sistema interno, com data de criacao e dados padronizados. A partir desse ponto, a equipe pode iniciar a triagem, aprovar o prosseguimento, solicitar informacoes complementares ou rejeitar a solicitacao quando nao houver aderencia aos criterios da instituicao.

### 5.7 Encaminhamento para a area interna de triagem

O principal resultado operacional da rota publica e alimentar a tela interna de triagem. A equipe autenticada consegue visualizar os cadastros recebidos, filtrar por status, verificar dados do responsavel, entrar em contato e decidir o proximo encaminhamento.

Essa divisao melhora a seguranca e a organizacao. A familia tem acesso apenas ao formulario publico e a mensagem de confirmacao. A equipe tem acesso ao painel interno, onde ocorre a analise institucional. Dessa forma, a funcionalidade atende ao objetivo de abrir um canal publico sem comprometer dados administrativos ou prontuarios existentes.

### 5.8 Implementacao no site institucional .org

Depois da criacao e validacao da rota, o formulario de pre-triagem foi disponibilizado no site institucional `.org` da ONG Multirao Bem. A implementacao no site teve como finalidade tornar o recurso acessivel pelo canal oficial da entidade, facilitando a divulgacao para familias, responsaveis, parceiros e equipe.

A integracao pode ser realizada por meio de botao, item de menu, chamada em pagina de atendimento ou link direto para a rota publica. O ponto central e que o usuario externo nao precise acessar a area administrativa do sistema. Ao clicar no link de pre-triagem no site `.org`, o responsavel e direcionado ao formulario publico, preenche as informacoes e recebe a confirmacao de envio.

Essa publicacao fortalece a confiabilidade do processo, pois o acesso ocorre pelo dominio institucional da ONG. Tambem reduz o risco de circulacao de links informais ou formularios paralelos, concentrando a entrada de dados em um canal oficial.

### 5.9 Usabilidade e acessibilidade do formulario

A interface do formulario foi desenvolvida para ser simples, responsiva e adequada ao publico externo. Como muitas familias podem acessar o site pelo celular, a tela foi organizada para funcionar bem em dispositivos moveis, com campos legiveis, botoes claros e sequencia de preenchimento natural.

Tambem foi considerada a linguagem utilizada no formulario. O texto precisa ser objetivo, sem termos tecnicos desnecessarios, para que o responsavel compreenda o que esta sendo solicitado. A confirmacao de envio informa que a pre-triagem foi recebida e que a continuidade depende da analise da equipe da ONG.

### 5.10 Testes e validacao

A funcionalidade foi testada com dados de demonstracao, simulando diferentes perfis de responsaveis e criancas. Os testes verificaram:

- abertura da rota publica sem login;
- bloqueio de acesso as telas administrativas sem autenticacao;
- preenchimento completo do formulario;
- mensagens de erro para campos obrigatorios;
- registro correto no banco de dados;
- armazenamento do consentimento LGPD;
- exibicao do registro na tela interna de triagem;
- funcionamento do link publicado no site `.org`;
- responsividade em tela de celular e computador.

Esses testes foram importantes para garantir que a rota cumprisse seu papel de porta de entrada publica sem fragilizar a seguranca do sistema.

## 6 RESULTADOS E IMPACTO SOCIAL

A atividade resultou na criacao de um canal publico e oficial para inicio do processo de atendimento da ONG Multirao Bem. Os principais resultados foram:

- Rota publica de pre-triagem acessivel sem login administrativo.
- Formulario estruturado para coleta inicial de dados.
- Registro de consentimento LGPD.
- Validacao dos campos obrigatorios.
- Integracao com o banco de dados do sistema.
- Encaminhamento automatico dos registros para a triagem interna.
- Publicacao do acesso no site institucional `.org` da ONG.
- Reducao da dependencia de fichas fisicas, mensagens soltas e anotacoes manuais.
- Melhor organizacao da fila inicial de interessados.
- Maior rastreabilidade do primeiro contato das familias.

O impacto social esta na melhoria do acesso e da organizacao do atendimento. Ao disponibilizar a pre-triagem no site oficial, a ONG facilita que familias iniciem o contato de forma clara e padronizada. A equipe, por sua vez, recebe dados mais organizados, consegue priorizar analises e reduz o risco de perder solicitacoes importantes.

Embora a atividade tenha natureza tecnica, seu efeito ocorre diretamente sobre o servico social prestado. Uma entrada de dados mais organizada contribui para atendimento mais rapido, melhor comunicacao com responsaveis e maior controle sobre as etapas de acolhimento.

## 7 AVALIACAO E AUTOAVALIACAO

A avaliacao da atividade considerou a aderencia da rota publica ao fluxo real da ONG, a clareza do formulario, a seguranca da separacao entre area publica e area administrativa, a integracao com a triagem interna e a adequacao a LGPD.

Uma dificuldade relevante foi equilibrar simplicidade e completude. Um formulario muito longo poderia afastar familias ou dificultar o preenchimento pelo celular. Um formulario muito curto poderia gerar retrabalho para a equipe. A solucao adotada foi coletar apenas dados essenciais para a primeira analise, deixando informacoes mais detalhadas para etapas posteriores.

Como autoavaliacao, a atividade fortaleceu competencias em desenvolvimento web com Laravel, organizacao de rotas publicas, validacao de formularios, construcao de interfaces responsivas, separacao entre area publica e area autenticada, e tratamento responsavel de dados pessoais. Tambem evidenciou a importancia de pensar a tecnologia a partir da realidade de quem vai utilizar o sistema, especialmente familias e equipes de uma organizacao social.

## 8 CONSIDERACOES FINAIS

A criacao da rota publica de pre-triagem representou uma etapa importante na consolidacao do Sistema Multirao Bem como ferramenta de atendimento institucional. A funcionalidade aproximou o sistema da comunidade externa, pois permitiu que o primeiro contato das familias ocorresse diretamente pelo site oficial `.org` da ONG.

O trabalho atende aos principios da extensao universitaria porque conecta conhecimento academico a uma necessidade concreta da sociedade. A solucao nao se limitou a criar um formulario tecnico; ela organizou a entrada de solicitacoes, apoiou a equipe administrativa, fortaleceu a protecao de dados e contribuiu para melhorar o acesso das familias ao processo de atendimento.

Reforca-se que esta atividade nao se caracteriza como estagio ou atividade complementar, mas como atividade de extensao, conforme o Art. 23 do Regulamento de Extensao da UNIP.

## REFERENCIAS

BRASIL. Lei n. 13.709, de 14 de agosto de 2018. Lei Geral de Protecao de Dados Pessoais (LGPD). Diario Oficial da Uniao: Brasilia, DF, 2018.

BRASIL. Ministerio da Educacao. Conselho Nacional de Educacao. Resolucao CNE/CES n. 7, de 18 de dezembro de 2018. Estabelece as diretrizes para a extensao na educacao superior brasileira. Diario Oficial da Uniao: Brasilia, DF, 2018.

LARAVEL. Laravel Documentation. Disponivel em: https://laravel.com/docs. Acesso em: [DATA DE ACESSO].

NIELSEN, Jakob. Usabilidade na web: projetando websites com qualidade. Rio de Janeiro: Elsevier, 2007.

TAILWIND LABS. Tailwind CSS Documentation. Disponivel em: https://tailwindcss.com/docs. Acesso em: [DATA DE ACESSO].

UNIVERSIDADE PAULISTA. Regulamento das Atividades de Extensao. Sao Paulo: UNIP, [s.d.].

UNIVERSIDADE PAULISTA. Manual de Extensao CC e SI - Marques e Chacara Santo Antonio. Sao Paulo: UNIP, [s.d.].

## APENDICE A - EVIDENCIAS RECOMENDADAS

- Print da rota publica de pre-triagem aberta pelo navegador.
- Print do link ou botao de acesso publicado no site institucional `.org` da ONG.
- Print do formulario em tela de celular.
- Print das mensagens de validacao de campos obrigatorios.
- Print da mensagem de confirmacao apos envio.
- Print do registro recebido na tela interna de triagem.
- Print do codigo da rota publica no arquivo de rotas.
- Print do controller responsavel pelo recebimento da pre-triagem.
- Print da view Blade do formulario.
- Print do registro de consentimento LGPD.
- Print dos testes com dados de demonstracao.
- Declaracao da ONG confirmando a disponibilizacao ou validacao da rota publica.

## APENDICE B - TEXTO PARA RELATORIO SINTESE NA PLATAFORMA

Desenvolvi uma rota publica de pre-triagem para a ONG Multirao Bem, integrada ao Sistema Multirao Bem e disponibilizada no site institucional de dominio `.org` da entidade. A atividade envolveu levantamento do fluxo inicial de atendimento, criacao de formulario publico, validacao de campos, registro de consentimento LGPD, integracao com banco de dados e encaminhamento dos cadastros recebidos para a tela interna de triagem da equipe. O formulario permite que responsaveis informem dados iniciais da crianca, contato, escola, periodo de interesse e observacoes, sem acessar a area administrativa do sistema. Como resultado, a ONG passou a contar com um canal oficial e padronizado para receber solicitacoes, reduzindo fichas fisicas, mensagens informais e risco de perda de informacoes. A atividade foi individual e devera ser comprovada por prints da rota publica, do site `.org`, do formulario, do codigo-fonte, dos registros internos e por declaracao da instituicao.
