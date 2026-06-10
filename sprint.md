# 🏃‍♂️ Sprint Log - Sistema ONG (Laravel 11 & LGPD)

Acompanhamento do ciclo de desenvolvimento do sistema de gestão da ONG, utilizando Laravel 11 para garantir segurança e conformidade com a LGPD.

---

## 📋 Roadmap de Desenvolvimento (Ciclo 1 - Concluído)

### 🟢 Fase 1: Fundação e Pré-Inscrição (Segurança Inicial)
- [✅] Configuração do Ambiente e Instalação Laravel 11
- [✅] Configuração de Drivers e Banco de Dados
- [✅] Esquema de Banco Inicial (Responsável, Criança, Log)
- [✅] Formulário Público de Pré-inscrição (Consentimento LGPD)

### 🟡 Fase 2: Triagem e Dashboard Administrativo
- [✅] Instalação do Laravel Breeze e Dashboard Admin
- [✅] Listagem de Pré-inscrições (Status: `PREENCHER`)
- [✅] Lógica de Aprovação Inicial (Status: `PREENCHER` -> `PENDENTE_MATRICULA`)
- [✅] **NAVBAR:** Implementação de abas numeradas (1. Triagem, 2. Matrícula, 3. Anamnese)
- [✅] **FILTROS:** Migração de todos os filtros de busca e navegação para o método **POST**

### 🟠 Fase 3: Matrícula e Censo Socioeconômico (Fluxo Interno)
- [✅] Implementar Módulo de **Dados Pessoais** (CPF, RG, Certidão)
- [✅] Implementar Módulo de **Moradia e Habitação** (Situação habitacional, cômodos)
- [✅] Implementar Módulo de **Composição Familiar** (Cadastro de moradores, ocupação, renda)
- [✅] Implementar Módulo de **Gestão de Contatos** (Múltiplos telefones/recados)
- [✅] Sistema de Upload de Arquivos/Anexos (Estrutura de formulário pronta)
- [✅] Integração visual total com o Layout Administrativo (`x-app-layout`)
- [✅] Redirecionamento e Registro de Auditoria (LGPD) pós-matrícula

### 🔴 Fase 4: Anamnese e Dados Sensíveis (CONCLUÍDO)
- [✅] Implementar Formulário de Anamnese (Acesso restrito após matrícula aprovada)
- [✅] Lógica de Aprovação da Anamnese (Status: `ANAMNESE_CONCLUIDA`)
- [✅] **LGPD:** Criptografia nativa para campos de saúde (Dados Sensíveis)
- [✅] **CRUD:** Preencher, Visualizar, Editar e PDF (Novos campos de melhoras.md)

### 🔵 Fase 5: Gestão de Turmas e Alocação Final
- [✅] Interface de Gestão de Turmas (CRUD completo: Criar, Editar, Listar, Excluir)
- [✅] Lógica de Alocação de crianças em turmas (Status: `EM_TURMA`)
- [✅] Interface de alocação/remoção diretamente no prontuário da turma.

---

## 🚀 Ciclo 2: Refatoração e Melhorias de UX (melhoras.md)

### 🛠️ Ponto 1: Arquitetura e Filtros por Fase
- [✅] **Refatoração de Controllers:** Criar `TriagemController`, `MatrículaController` e `AnamneseController` independentes.
- [✅] **Filtros Específicos:** Implementar filtros de busca personalizados dentro de cada controlador/aba.

### 🛠️ Ponto 2 & 3: Transparência e Edição de Dados
- [✅] **Logs de Auditoria:** Criar interface para exibição das observações e histórico de alterações (LGPD).
- [✅] **Melhoria nos Logs de E-mail:** Implementação de listeners globais para rastreamento de envios.
- [✅] **Personalização de Marca:** Customização do nome do app, logo e rodapé nos e-mails enviados.
- [✅] **Múltiplos Familiares:** Permitir a adição de "N" familiares na matrícula (Seção 4).
- [✅] **UX de Login:** Personalização da mensagem de erro de autenticação para português.
- [✅] **Download Excel:** Botão para baixar a "Ficha Mãe" na gestão de matrículas.
- [✅] **Anexo Excel:** Upload e visualização da ficha preenchida no prontuário da criança.
- [✅] **Visualização de Matrícula:** Implementar tela de visualização completa dos dados digitados e documentos anexados.
- [✅] **Edição de Matrícula:** Permitir a correção/atualização de dados após a inserção inicial.

### 📄 Ponto 4 & 5: Relatórios (PDF)
- [✅] **Botão de PDF:** Adicionar atalho de geração de PDF diretamente na tela de visualização da matrícula.
- [✅] **Expansão de Campos:** Incluir todos os dados do Censo Socioeconômico e Moradia no PDF oficial.

---

## 🚀 Ciclo 3: Pesquisa Geral e Refinamento de Turmas (melhoras.md)

### 🔍 Ponto 1: Gestão de Turmas Aprimorada
- [✅] **Ações Rápidas:** Botões de "Matrícula", "Anamnese" e "Arquivos" diretamente na lista de alunos da turma.
- [✅] **Busca Reativa:** Integração com Tom Select para tornar a alocação de crianças pesquisável.
- [✅] **Identidade Visual:** Aplicação rigorosa das cores roxo e amarelo em todas as telas de Turmas.

### 🔍 Ponto 2: Central de Crianças (Pesquisa Geral)
- [✅] **Nova Aba:** Renomeada para "5. Crianças" no menu principal.
- [✅] **Filtros e Legibilidade:** Interface de busca simplificada e mais legível para o cliente final.
- [✅] **Acesso Total:** Botões de Matrícula, Anamnese e Arquivos integrados nos resultados da busca.

---

## 🚀 Ciclo 4: Monitoramento e Relatório de Evasão (melhoras.md)

### 📊 Sprint 1: Infraestrutura e Dados (CONCLUÍDO)
- [✅] **Banco de Dados:** Criação de colunas `data_evasao`, `motivo_evasao` e `observacao_evasao`.
- [✅] **Eloquent:** Atualização do model `Crianca` com novos campos e casts de data.
- [✅] **Documentação:** Atualização do `database_schema.md` com a nova estrutura.

### 📊 Sprint 3: Central de Relatórios (CONCLUÍDO)
- [✅] **Interface:** Desenvolvimento da tela de relatório com filtros por data e turma.
- [✅] **Identidade Visual:** Aplicação das cores roxo e amarelo em toda a interface.
- [✅] **Exportação:** Botão para extrair relatório completo em PDF, respeitando os filtros aplicados.
- [✅] **Estatísticas:** Cards dinâmicos e análise automática do "Principal Motivo".
- [✅] **Navegação:** Adição da aba "6. Evasão" no menu principal.

---

## 🚀 Ciclo 5: Refinamentos Finais e Identidade (melhoras.md)

### 🎨 Identidade Visual e Navegação (CONCLUÍDO)
- [✅] **Busca Inteligente:** Adição do campo "Período Escolar" na pesquisa de alocação de turmas.
- [✅] **Unificação de Ações:** Botão "Ver Histórico" substituindo a lista extensa de botões em Turmas e Pesquisa.
- [✅] **Branding PDF:** Padronização de todos os PDFs com as cores Roxo e Amarelo.
- [✅] **UX Relatório:** Simplificação visual do Relatório de Evasão para evitar poluição cromática.

---

## 🚀 Ciclo 6: Preparação para Apresentação (Ajustes de Demo)

### 📊 Sprint 1: Massa de Dados (CONCLUÍDO)
- [✅] **Seeder de Demonstração:** Criação do `DemonstracaoSeeder` para popular todas as fases do sistema.
- [✅] **Diversidade de Status:** Inserção de registros em Triagem, Matrícula, Anamnese, Turmas e Evasão.
- [✅] **Ambiente Pronto:** Banco de dados populado com 16 crianças e seus respectivos responsáveis e históricos.
- [✅] **Logs de Auditoria:** Implementação de histórico completo de logs no seeder para simular a jornada de cada criança.

### 📊 Sprint 2: Notificações e UX (CONCLUÍDO)
- [✅] **E-mail Administrativo:** Inclusão do período escolar e período na ONG na notificação de nova pré-inscrição.

---

## 🚀 Ciclo 7: Refinamentos Finais e UX

### 🎨 Identidade Visual e Legibilidade
- [✅] **Destaque de Auditoria:** Ajuste fino no destaque do nome do usuário nos históricos (aumento de fonte sem fundo colorido).

---

## 📍 Status Atual

**Última Atualização:** 09/06/2026
**Ponto de Parada:** Sistema populado e pronto para demonstração ao cliente.
**Status Geral:** 🟢 Pronto para Showroom.

---

## 🚀 Próximos Passos (Imediato)
1. Planejar relatórios de "Abandono de Processo" (Pré-inscrições que não avançaram).
2. Monitorar o uso real do sistema de rematrícula.

