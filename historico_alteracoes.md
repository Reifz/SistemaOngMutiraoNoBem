# Histórico de Alterações - Multirão Bem

## [09/06/2026] - Ajuste Visual para Usuários em Logs de Auditoria
- **O que foi feito:** 
    1. Removido o fundo roxo (destaque) do nome do usuário nos logs de auditoria conforme feedback.
    2. Aumentado o tamanho da fonte do nome do auditor para facilitar a identificação visual.
    3. Atualização das views: `matricula/historico.blade.php`, `matricula/show.blade.php`, `triagem/show.blade.php` e `triagem/onlyRead.blade.php`.
- **Motivo:** O estilo anterior com fundo colorido foi considerado visualmente pesado; optou-se por apenas aumentar a fonte para manter o destaque de forma mais limpa.

## [03/06/2026] - Implementação de Logs de Auditoria no Seeder de Demonstração
- **O que foi feito:** 
    1. Atualização do `DemonstracaoSeeder` para incluir a criação automática de `LogAuditoria` para cada etapa do fluxo de cada criança (Pré-inscrição, Triagem, Matrícula, Anamnese, Turma e Evasão).
    2. Inclusão oficial do registro **Manuel Ferraz** no seeder, garantindo que ele tenha seu histórico completo de auditoria persistido.
    3. Re-execução do seeder para popular o sistema com dados reais e rastreáveis.
- **Motivo:** Correção de falha onde os registros de demonstração não possuíam histórico de logs, impedindo a validação da funcionalidade de auditoria (LGPD) na interface.

## [03/06/2026] - Registro de Criança para Demonstração (Manuel Ferraz)
- **O que foi feito:** 
    1. Criação do registro completo da criança **Manuel Ferraz** via script automatizado.
    2. Cadastro da responsável **Maria Ferraz** com todos os dados socioeconômicos.
    3. Preenchimento de todos os módulos da matrícula: **Moradia**, **Composição Familiar** e **Contatos**.
    4. Efetivação da matrícula no Ano Letivo de 2026 com status `APROVADO`.
- **Motivo:** Atendimento à solicitação de popular o sistema com um caso real/demonstração completo para validação dos campos de matrícula e visualização no dashboard.

## [03/06/2026] - Atualização de Notificação de Nova Inscrição (Admin)
- **O que foi feito:** 
    1. Atualização do conteúdo do e-mail enviado ao administrador (`NovaInscricaoAdminNotification`).
    2. Inclusão detalhada do **Período Escolar** e do **Período na ONG** nos dados da criança.
- **Motivo:** Melhorar a clareza das informações recebidas pelo sistema logo no primeiro contato da pré-inscrição, permitindo identificar rapidamente o turno de interesse.

## [03/06/2026] - Integração de Alertas na Tela de Apresentação (Home)
- **O que foi feito:** 
    1. Reversão da rota inicial: o caminho root (`/`) voltou a exibir a tela de apresentação (`home.blade.php`).
    2. **Integração de Dados:** A rota `home` agora busca e injeta automaticamente os **Aniversariantes** e **Alertas de Triagem** diretamente na tela de apresentação.
    3. **Ajuste de Navegação:** Removida a aba dedicada "Dashboard" do menu superior para simplificar a interface.
    4. **Correção de Redirecionamento:** O sistema agora redireciona para a tela de apresentação (`home`) imediatamente após o login.
- **Motivo:** Ajuste conforme feedback para manter a identidade visual da tela de boas-vindas, mas com as informações dinâmicas de alertas integradas.

## [03/06/2026] - Dashboard como Tela Inicial (Home) [REVERTIDO]
- **O que foi feito:** 
    1. Configuração da rota raiz (`/`) e da rota `home` para apontarem diretamente para o `DashboardController@index`.
    2. Atualização da barra de navegação para incluir o link "Dashboard" e garantir que o logo direcione para esta tela.
    3. Desativação da antiga view `home.blade.php` como landing page administrativa.
- **Motivo:** Atendimento à solicitação de exibir informações críticas (Aniversariantes e Alertas) imediatamente após o login.

## [03/06/2026] - Refinamento de Dados e Correção de Rota
- **O que foi feito:** 
    1. Correção da rota `/dashboard` que estava apontando erroneamente para a view `home` em vez do `DashboardController`.
    2. Atualização do `DemonstracaoSeeder` para incluir cenários específicos:
        - **Aniversariantes:** Adicionadas crianças com aniversário na data de hoje para visualização no Dashboard.
        - **Alertas:** Adicionadas crianças em triagem paradas há mais de 7 dias para disparar os alertas visuais.
        - **Anamnese:** Corrigido o status de "Aguardando Anamnese" para `APROVADA`, garantindo que apareçam na lista da Aba 3.
        - **Evasão:** Adicionados registros de evasão para ambos os turnos (Manhã e Tarde) para validar os cards do relatório de evasão.
- **Motivo:** Garantir que todos os componentes visuais do sistema tenham dados reais para a apresentação ao cliente.

## [03/06/2026] - Geração de Dados para Demonstração
- **O que foi feito:** Criação do `DemonstracaoSeeder` para popular o sistema com registros em todos os estágios do fluxo.
- **Motivo:** Preparação do ambiente para apresentação ao cliente.
- **Detalhes:** Inseridos 16 registros abrangendo os status: `PREENCHER`, `PENDENTE_MATRICULA`, `PENDENTE_APROVACAO`, `APROVADO`, `ANAMNESE`, `ANAMNESE_CONCLUIDA`, `TURMA_PENDENTE`, `EM_TURMA` e `EVADIDA`. Criadas também Turmas e Ano Letivo de 2026.

## [02/06/2026] - Validacao da Suite de Testes e Cobertura de Rematricula
- **O que foi feito:** Executada uma bateria de verificacoes do projeto, incluindo lint PHP, migrations em SQLite isolado, compilacao de views Blade, listagem de rotas, build Vite e PHPUnit.
- **Ajustes nos testes:**
    1. Corrigido `tests/Feature/ExampleTest.php` para refletir o comportamento real da rota `/`: visitantes sao redirecionados para login e usuarios autenticados acessam a home.
    2. Criado `tests/Feature/RematriculaFlowTest.php`, cobrindo o inicio de rematricula para novo ano letivo, bloqueio de rematricula duplicada e ciclo completo ate alocacao em nova turma.
- **Correcao aplicada:** Ajustado `RematriculaController::iniciar` para nao deixar transacao de banco aberta quando a rematricula duplicada e recusada.
- **Resultado:** PHPUnit passou com `30 tests` e `115 assertions`. O fluxo completo e a rematricula agora estao cobertos por testes automatizados.
- **Observacoes de ambiente:** O PHP do XAMPP local esta em 8.2.12, mas as dependencias atuais exigem PHP 8.3+ e parte do Symfony instalado exige PHP 8.4. Para rodar a suite foi usado PHP 8.3 com extensoes carregadas por linha de comando.

## [01/06/2026] - Correção e Validação do Fluxo de Rematrícula (Fase 6)
- **O que foi feito:** Ajuste nos controladores principais para suportar a jornada de renovação anual de veteranos.
- **Motivo:** O fluxo de rematrícula estava bloqueado por verificações de status que não reconheciam as crianças veteranas, impedindo a conclusão do ciclo anual.
- **Detalhes Técnicos:**
    1. **MatriculaController:** 
        - Atualizada a função `formulario` para permitir acesso com o status `PENDENTE_REMATRICULA_MATRICULA`.
        - Ajustada a lógica de transição no `store` e `aprovar` para seguir a trilha de rematrícula (`PENDENTE_REMATRICULA_APROVACAO` e `PENDENTE_REMATRICULA_ANAMNESE`).
        - Incluídos os novos status nos filtros de listagem padrão.
    2. **AnamneseController:**
        - Implementada transição automática para o status `REMATRICULADA` ao finalizar a anamnese de um veterano.
        - Atualizados os filtros de listagem para exibir veteranos em processo de renovação.
    3. **TurmaController:**
        - Incluídas crianças com status `REMATRICULADA` na lista de alunos aptos para alocação em novas turmas.
    4. **Testes Automatizados:**
        - Criado e executado o teste `RematriculaFlowTest.php`, validando o ciclo completo: Ativação de Novo Ano -> Início de Rematrícula -> Preenchimento de Dados -> Aprovação -> Anamnese -> Alocação em Turma.
- **Resultado:** O sistema agora processa corretamente tanto novos alunos quanto veteranos, garantindo a integridade do histórico anual.

## [01/06/2026] - Correção de Bugs E2E e Sincronização de Dados (Fase de Estabilidade)
- **O que foi feito:** Correção de falhas críticas identificadas durante testes automatizados ponta a ponta e alinhamento arquitetural entre as tabelas de crianças e matrículas.
- **Motivo:** Garantir a robustez do fluxo de inscrição e evitar divergência de dados causada pela migração para o sistema de matrículas anuais (Fase 6).
- **Detalhes Técnicos:**
    1. **PreInscricaoController:** Corrigido erro de "Undefined array key" ao processar campos opcionais (ex: telefone secundário), garantindo a conclusão da pré-inscrição mesmo com dados parciais.
    2. **MatriculaController:** Corrigida falha de integridade (NOT NULL) no campo `possui_deficiencia` ao converter corretamente valores de checkbox do request.
    3. **Modelo Crianca (Sincronização Automática):** 
        - Implementados Mutators `setStatusAttribute` e `setTurmaIdAttribute`.
        - Agora, qualquer atualização de status ou turma no modelo `Crianca` é automaticamente replicada na tabela `matriculas` do ano letivo atual, resolvendo o problema de "Split Brain" onde a interface mostrava dados antigos da matrícula.
    4. **Testes Automatizados:** 
        - Criado `CompleteSystemFlowTest.php` que valida integralmente o caminho: Pré-inscrição -> Triagem -> Matrícula -> Aprovação -> Anamnese -> Alocação em Turma.
- **Resultado:** Sistema mais estável, com dados sempre sincronizados entre tabelas e um conjunto de testes que garante a integridade dos fluxos principais.

## [29/05/2026] - Implementação da Arquitetura de Rematrícula (Fase 6)
- **O que foi feito:** Migração do sistema de matrícula única para histórico anual por Ano Letivo.
- **Motivo:** Permitir o rastreamento histórico de crianças ao longo dos anos e facilitar o processo de rematrícula, conforme planejado em `sprint_nova.md`.
- **Detalhes Técnicos:**
    1. **Infraestrutura de Dados:**
        - Criadas as tabelas `anos_letivos` e `matriculas`.
        - Atualizada a tabela `anamnese` para vincular registros a anos específicos.
    2. **Migração de Dados:**
        - Desenvolvido e executado script de migração que moveu todos os dados variáveis (status, escola, série, turma) da tabela `criancas` para a nova tabela `matriculas` referente ao ano de 2026.
    3. **Refatoração de Modelos:**
        - Criados os modelos `AnoLetivo` e `Matricula`.
        - Refatorado o modelo `Crianca` com novos relacionamentos e *Accessors* para garantir compatibilidade com o código legado.
    4. **Interface e Navegação:**
        - Adicionada a aba **"Rematrícula"** ao menu principal.
        - Implementado o `RematriculaController` com funcionalidades de listagem, filtragem e início de novo ciclo de rematrícula.
        - Criada a view `rematricula/index.blade.php` seguindo a identidade visual roxo/amarelo.
- **Resultado:** O sistema agora está preparado para gerenciar múltiplos anos letivos, preservando o histórico de cada criança e simplificando a transição entre anos escolares.

## [28/05/2026] - Fase 5: Comunicação Interna (sprint_nova.md)
- **O que foi feito:** 
    1. **Infraestrutura de Mensagens:**
        - Criada a tabela `mensagens` para armazenar comunicações internas vinculadas a crianças.
        - Implementado o Model `Mensagem` com relacionamentos para remetente, destinatário e criança.
    2. **Central de Mensagens:**
        - Desenvolvido `MensagemController` para gestão de caixa de entrada, saída e visualização.
        - Criadas as views de listagem (`index`), envio (`create`) e visualização (`show`).
        - Implementado contador de mensagens não lidas com ícone de notificação na barra de navegação.
    3. **Integração com Prontuário:**
        - Adicionada seção de "Conversas sobre esta criança" na tela de visualização de matrícula.
        - Adicionado botão de atalho para enviar mensagem diretamente do prontuário da criança.
- **Motivo:** Atendimento ao item 2 de `melhoras.md`, facilitando a troca de informações entre a equipe técnica sobre casos específicos.
- **Resultado:** Maior agilidade na comunicação interna e preservação do histórico de discussões sobre cada criança no sistema.

## [28/05/2026] - Fase 4: Gestão de Acessos e RBAC (sprint_nova.md)
- **O que foi feito:** 
    1. **Infraestrutura de Usuários:**
        - Adicionadas colunas `role` e `ativo` na tabela `users` via migration.
        - Criado middleware `AdminMiddleware` para proteção de rotas restritas.
        - Implementada lógica no `LoginRequest` para bloquear o acesso de usuários inativos.
    2. **CRUD de Usuários:**
        - Desenvolvido `UserController` com funções de listagem, criação, edição e alteração de status.
        - Criadas views personalizadas em `resources/views/usuarios` seguindo a identidade visual (Roxo/Amarelo).
        - Implementada funcionalidade de "Inativar" usuários para preservar histórico de auditoria.
    3. **Navegação e Segurança:**
        - Adicionada aba **"Usuários"** no menu principal, visível apenas para administradores.
        - Criados comandos Artisan: `app:list-users` e `app:set-admin-role {email}` para gestão via CLI.
        - Definido o primeiro usuário administrador do sistema.
- **Motivo:** Atendimento ao item 1 da Fase 4 de `sprint_nova.md`, garantindo segurança e controle de permissões.
- **Resultado:** O sistema agora possui níveis de acesso (Admin e User), permitindo que apenas administradores gerenciem a equipe e acessem configurações críticas.

## [27/05/2026] - Fase 3: Lógica Automática e Relatórios (melhoras.md)
- **O que foi feito:** 
    1. **Idade Automática:**
        - Implementado Accessor `idade` no Model `Crianca` para cálculo em tempo real baseado na `data_nascimento`.
        - Atualizadas as views de Dashboard, Triagem, PDF de Comprovante e Formulário de Matrícula para utilizar a idade automática em vez de um campo estático.
    2. **Virada de Ano Letivo:**
        - Criado comando `php artisan app:virada-ano-letivo` para incremento automático das séries escolares (Ex: 1º ano -> 2º ano).
        - Implementado suporte a "Data Dinâmica": a data de virada pode ser configurada via arquivo `config/multirao.php` (Padrão: 01 de Janeiro).
        - Agendamento do comando para execução diária, garantindo a atualização na data correta.
    3. **Exportação de PDF Filtrado:**
        - Adicionada funcionalidade de exportação para PDF na tela de "5. Crianças" (Pesquisa Geral).
        - O relatório respeita os filtros aplicados na tela (Nome e Turma) e utiliza a identidade visual oficial do projeto (Roxo/Amarelo).
- **Motivo:** Atendimento aos itens 6 e 11 de `melhoras.md`, automatizando processos manuais e melhorando a capacidade de extração de dados.
- **Resultado:** Redução de erros humanos na atualização de séries e idades, e maior facilidade para geração de listagens físicas.

## [27/05/2026] - Implementação da Fase 2: Ajustes de Dados e Regras (melhoras.md)
- **O que foi feito:** 
    1. **Banco de Dados:** Adicionada coluna `periodo_ong` na tabela `criancas` para armazenar o turno desejado na ONG.
    2. **Pré-Inscrição Pública:** 
        - Atualizado o label para "Período ATUAL (escola)".
        - Adicionado novo campo obrigatório para o período pretendido na ONG, com alerta visual sobre o contra-turno.
        - Atualizada a validação no `PreInscricaoController`.
    3. **Fluxo de Triagem e Matrícula:** 
        - Exibição do novo campo "Período Desejado (ONG)" nas telas de detalhes da Triagem e Matrícula.
        - Atualizados os labels de turno para evitar confusão entre escola e ONG.
    4. **Regra de Aprovação de Matrícula:** 
        - Relaxada a exigência de documentos para habilitar o botão "Aprovar para Anamnese".
        - Agora o sistema exige apenas **um** documento válido da criança (CPF, RG ou Certidão) e **um** do responsável (CPF, RG ou CNH/Anexo) para avançar, facilitando o fluxo para famílias com documentos pendentes.
- **Motivo:** Atendimento aos itens 5 e 14 de `melhoras.md`, visando melhor coleta de dados e desburocratização do processo de matrícula.
- **Resultado:** Maior clareza no planejamento de turmas (contra-turno) e agilidade na aprovação de matrículas.

## [27/05/2026] - Implementação da Fase 1: UI/UX & Quick Wins (melhoras.md)
- **O que foi feito:** 
    1. **Ajuste em Turmas:** Removida a informação de "Período" do dropdown de alocação de crianças na tela de Turmas para simplificar a interface.
    2. **Central de Crianças (Pesquisa):** Adicionadas colunas de "Responsável" (exibindo nome e e-mail) e "Contato" (com link direto para WhatsApp via `wa.me`).
    3. **Relatório de Evasão:** Implementado novo filtro por **Período** (Manhã/Tarde) e adicionados cards de resumo no topo exibindo o total de evasões e o **principal motivo** específico para cada turno.
    4. **Dashboard Admin:** 
        - Criada seção de **"Aniversariantes de Hoje"** com listagem automática e idade atual.
        - Criado sistema de **"Alertas de Triagem"** para destacar crianças paradas na fase de triagem há mais de 7 dias, com link direto para ação.
- **Motivo:** Atendimento imediato aos itens 3, 7, 9, 10, 12 e 13 de `melhoras.md`, focando em agilidade operacional e engajamento.
- **Resultado:** O dashboard e as telas de listagem agora oferecem informações muito mais ricas e acionáveis para os administradores.

## [27/05/2026] - Planejamento da Nova Sprint (melhoras.md)
- **O que foi feito:** 
    1. Criação do arquivo `sprint_nova.md` contendo o planejamento estratégico das 14 novas melhorias solicitadas pelo cliente.
    2. Organização das tarefas em 5 fases lógicas: UI/UX Quick Wins, Ajustes de Dados, Lógica Automática, Gestão de Acessos e Arquitetura Avançada.
    3. Mapeamento de dependências técnicas e níveis de complexidade para cada item de `melhoras.md`.
- **Motivo:** Organizar o fluxo de trabalho para o próximo ciclo de desenvolvimento, garantindo que as melhorias sejam implementadas de forma lógica e segura.
- **Resultado:** Roteiro claro de implementação pronto para execução, sem alterações diretas no código ou banco nesta etapa.

## [26/05/2026] - Correção de Feedback e Estabilidade de Notificações
- **O que foi feito:** 
    1. Corrigido erro no `AppServiceProvider` que tentava acessar propriedade inexistente (`sentMessage`) ao logar e-mails, o que causava crash em processos com notificações.
    2. Adicionadas mensagens de sucesso/erro (Session Flash) nas telas de Visualização de Matrícula, Triagem e Anamnese, que estavam sem feedback visual após ações.
    3. Adicionada confirmação (`confirm`) ao botão de Aprovar Triagem para evitar cliques acidentais e dar feedback de processamento.
- **Motivo:** Usuários reportaram que botões "não funcionavam", quando na verdade as ações eram concluídas mas não exibiam confirmação ou travavam em erros silenciosos de log.
- **Resultado:** Maior estabilidade no sistema de e-mails e interface mais comunicativa.

## [26/05/2026] - Refinamento de UX: Busca por Período e Unificação de Ações (Histórico)
- **O que foi feito:** 
    1. Atualizada a pesquisa de crianças na tela de Turmas para exibir o **período escolar** (Manhã/Tarde) além de nome e idade, auxiliando na alocação correta por turno.
    2. Unificados os botões de ação (Pré-inscrição, Matrícula, Anamnese, Arquivos) em um único botão **"Ver Histórico"** nas telas de Turmas e Pesquisa Geral.
- **Motivo:** Simplificação da interface e centralização do acesso aos dados da criança através do prontuário histórico, conforme solicitado em `melhoras.md`.
- **Resultado:** Interface mais limpa e busca mais assertiva para os operadores do sistema.

## [26/05/2026] - Correção de Erro na Edição de Matrícula (isVirtual)
- **O que foi feito:** 
    1. Corrigida a inconsistência entre o formulário de edição de matrícula (que enviava `PUT`) e a rota definida no `web.php` (que esperava `POST`).
    2. Identificado que o erro `ReflectionProperty::isVirtual()` era um crash secundário no renderizador de erros devido à incompatibilidade entre o PHP 8.2 local e as dependências do Symfony 8.0 (que exigem PHP 8.4).
    3. Removido o `@method('PUT')` da view `matricula/edit.blade.php`.
- **Motivo:** O erro impedia qualquer alteração nos dados das crianças após a matrícula inicial.
- **Resultado:** Funcionalidade de edição restaurada.

## [26/05/2026] - Diagnóstico e Correção de Erro de Ambiente (Geração de PDF)
- **O que foi feito:** 
    1. Identificado o erro `The PHP GD extension is required` ao tentar gerar PDFs.
    2. Verificação do ambiente: a extensão GD estava desativada no `php.ini` do XAMPP.
    3. Fornecidas instruções para ativação da extensão, remoção de redundâncias no `php.ini` (mysqli) e recomendação de atualização do PHP para compatibilidade com as exigências do `composer.json` (PHP 8.3+).
- **Motivo:** O erro impedia a exportação da Ficha de Matrícula Completa e outros relatórios.
- **Resultado:** Diagnóstico concluído e solução encaminhada ao usuário para ajuste no servidor local.

## [26/05/2026] - Melhorias de UX e Padronização de Identidade Visual (melhoras.md)
- **O que foi feito:** 
    1. Inclusão do botão **"Pré inscrição"** nas listagens de crianças (telas de Turmas e Pesquisa Geral), facilitando o acesso rápido aos dados iniciais.
    2. Reformulação visual do **Relatório de Evasão**: redução da poluição visual, remoção de excesso de cores (indigo/red) e foco total na paleta roxo/amarelo.
    3. Padronização cromática em todos os **PDFs gerados** (Comprovante, Matrícula Completa e Relatório de Evasão), utilizando as cores oficiais `#3f226b` (Roxo) e `#fede30` (Amarelo).
- **Motivo:** Atendimento direto às solicitações de refinamento estético e funcional descritas em `melhoras.md`.
- **Resultado:** O sistema apresenta uma interface mais limpa, profissional e totalmente alinhada à marca da ONG, além de fluxos de navegação mais curtos.

## [23/05/2026] - Central de Relatórios de Evasão (Sprint 3 - Final)
- **O que foi feito:** 
    1. Criação do `RelatorioController` com lógica para cálculo de métricas de retenção.
    2. Desenvolvimento da view **"6. Evasão"** contendo cards de indicadores: Total de Matriculados (Ativos + Saídas), Total de Evasões no período e a Taxa de Evasão (%).
    3. Implementação da análise de causa raiz, exibindo automaticamente o **"Principal Motivo"** de desligamento no período selecionado.
    4. Adição de filtros dinâmicos por **Data Início**, **Data Fim** e **Turma**.
    5. Listagem detalhada dos evadidos com cálculo automático do **tempo de permanência** (meses entre a matrícula e a saída).
    6. Integração da nova aba no menu de navegação administrativa.
- **Motivo:** Entrega da funcionalidade analítica solicitada pelo dono da ONG para gestão estratégica.
- **Resultado:** O sistema agora oferece uma visão clara e baseada em dados sobre por que e quando as crianças estão deixando a instituição.

## [23/05/2026] - Sistema de Registro de Evasão e Desligamento (Sprint 2)
- **O que foi feito:** 
    1. Implementação do botão **"Registrar Saída/Evasão"** na tela de visualização de matrícula.
    2. Criação de um modal interativo para coleta da data de saída, motivo (Mudança, Horário, Inadaptação, etc.) e observações.
    3. Desenvolvimento da lógica de processamento no `MatriculaController`: atualização do status para `EVADIDA`, desvínculo automático da turma e sincronização com a tabela de inscrições.
    4. Registro automático no **Log de Auditoria** contendo o motivo da evasão e a turma anterior para fins históricos.
    5. Proteção nas turmas: crianças evadidas são automaticamente excluídas da lista de novas alocações.
- **Motivo:** Necessidade de monitorar a rotatividade de alunos e manter um histórico fidedigno das saídas.
- **Resultado:** O sistema agora permite realizar a baixa oficial de um aluno com apenas dois cliques, preservando todos os dados para relatórios futuros.

## [22/05/2026] - Refinamento de UX, Identidade Visual e Central de Crianças
- **O que foi feito:** 
    1. Implementação da Central de Pesquisa renomeada para **"5. Crianças"** no menu principal.
    2. Atualização da interface de pesquisa com título **"Pesquisar Crianças"** e layout otimizado para legibilidade.
    3. Padronização das cores primárias (**Roxo e Amarelo**) em todas as telas de Gestão de Turmas (Listagem, Criação, Edição e Visualização).
    4. Inclusão do botão de **"Anamnese"** nas listas de crianças (Turmas e Pesquisa), permitindo acesso rápido ao prontuário de saúde.
    5. Melhoria visual dos botões de ação com efeitos de transição e cores contrastantes (Amarelo para Detalhes/Arquivos, Roxo para Matrícula/Editar).
    6. Integração do Tom Select para busca reativa de crianças durante a alocação em turmas.
- **Motivo:** Atendimento ao feedback "Melhoras sobre as propostas atuais" em `melhoras.md`.
- **Resultado:** O sistema agora possui uma identidade visual mais coesa e ferramentas de busca muito mais potentes e amigáveis ao usuário.

## [22/05/2026] - Implementação de Pesquisa Geral e Melhorias de UX em Turmas (Versão Inicial)
- **O que foi feito:** 
    1. Criação da migration `2026_05_15_000004_create_inscricoes_table.php` para restaurar a tabela de controle de status de inscrição.
    2. Execução da migration no banco de dados.
- **Motivo:** Correção do erro SQL (Table 'ong.inscricoes' doesn't exist) ao tentar aprovar uma matrícula para a fase de Anamnese.
- **Resultado:** O botão de aprovação voltou a funcionar, permitindo a sincronização correta dos status.

## [15/05/2026] - Correção de Erro na Pré-Inscrição (data_nascimento)
- **O que foi feito:** 
    1. Ajuste no `PreInscricaoController` para calcular uma data de nascimento aproximada com base na idade informada, pois o banco de dados exige este campo e o formulário público coleta apenas a idade.
    2. Adição do preenchimento do campo `data_inscricao` no momento da criação do registro.
- **Motivo:** Correção de erro SQL (Field 'data_nascimento' doesn't have a default value) que impedia a conclusão da pré-inscrição pelo site.
- **Resultado:** O formulário público de pré-inscrição voltou a funcionar corretamente.

## [15/05/2026] - Implementação da Alocação de Crianças em Turmas
- **O que foi feito:** 
    1. Adição da coluna `turma_id` na tabela `criancas` com chave estrangeira.
    2. Definição de relacionamentos Eloquent (`belongsTo`/`hasMany`) entre `Crianca` e `Turma`.
    3. Implementação de métodos `alocar` e `removerCrianca` no `TurmaController`, incluindo validação de capacidade máxima.
    4. Reformulação da view `turmas.show` com sistema de alocação dinâmica (sidebar) e lista de alunos matriculados.
    5. Atualização automática de status da criança para `EM_TURMA` ao ser alocada e retorno para `ANAMNESE_CONCLUIDA` ao ser removida.
- **Motivo:** Conclusão da Fase 5, permitindo o encerramento do ciclo de matrícula com a alocação oficial em sala de aula.
- **Resultado:** Fluxo de matrícula completo, desde a pré-inscrição até a entrada efetiva na turma.

## [15/05/2026] - Implementação do Módulo de Gestão de Turmas (CRUD)
- **O que foi feito:** 
    1. Criação de migration para expandir a tabela `turmas` com campos de `turno`, `idade_minima`, `idade_maxima` e `descricao`.
    2. Implementação de CRUD completo no `TurmaController` com registro de logs de auditoria para cada ação (Criar, Editar, Excluir).
    3. Desenvolvimento de views modernas e responsivas: `index.blade.php` (Grid de turmas), `create.blade.php`, `edit.blade.php` e `show.blade.php`.
    4. Integração do módulo na barra de navegação principal como "4. Turmas".
    5. Atualização do Model `Turma` com novos campos fillable e casts de dados.
- **Motivo:** Início da Fase 5 do projeto para permitir a organização pedagógica das crianças.
- **Resultado:** O sistema agora permite o gerenciamento completo de salas e grupos, preparando o terreno para a alocação final dos alunos.

## [12/05/2026] - Implementação Completa do Módulo de Anamnese
- **O que foi feito:** 
    1. Implementação de CRUD completo (Preencher, Visualizar, Editar, PDF) para o módulo de Anamnese.
    2. Adição de todos os campos solicitados em `melhoras.md` (Informação, Dados Pessoais, Esquema Familiar, História Escolar, História de Vida, Histórico Clínico e Família Ampliada).
    3. Atualização do fluxo de status: a criança entra em fase de Anamnese com status `APROVADA` e avança para `ANAMNESE_CONCLUIDA` após o preenchimento.
    4. Criação de views dedicadas: `formulario.blade.php` (Preenchimento/Edição), `show.blade.php` (Visualização) e `pdf.blade.php` (Relatório para impressão).
    5. Atualização do `AnamneseController` para gerenciar as novas rotas e lógica de status.
    6. Garantia de conformidade com a LGPD através da criptografia nativa do Laravel para o campo `dados_json` (Dados Sensíveis de Saúde).
- **Motivo:** Cumprimento da Fase 4 do projeto e atendimento às melhorias detalhadas em `melhoras.md`.
- **Resultado:** O sistema agora possui um módulo robusto e completo para a coleta e gestão de dados de saúde e desenvolvimento das crianças, com suporte a exportação profissional em PDF.

## [08/05/2026] - Melhoria: Novos Campos de Anexos de Documentos na Matrícula
- **O que foi feito:** 
    1. Implementação de 5 novos campos de anexos na tabela `criancas`: `anexo_rg`, `anexo_cpf`, `anexo_comprovante_residencia`, `anexo_comprovante_escolaridade` e `anexo_comprovante_renda`.
- **Motivo:** Atendimento à solicitação de anexar documentos obrigatórios diretamente no prontuário digital.

## [08/06/2026] - Tradução das views de perfil
- **O que foi feito:** Traduzidos os títulos e textos das views de perfil (edit.blade.php e parciais) de inglês para português para melhor acessibilidade do usuário.

## [08/06/2026] - Padronização de Cabeçalhos em PDF
- **O que foi feito:** Padronizados os cabeçalhos de todos os relatórios PDF (Listagem de Crianças, Relatório de Evasão e Anamnese) seguindo a identidade visual da ONG (Roxo/Amarelo) e incluindo o logotipo oficial.
