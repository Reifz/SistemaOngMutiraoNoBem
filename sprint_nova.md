# 🚀 Nova Sprint - Melhorias Multirão Bem (2026)

Este documento organiza as novas demandas do cliente solicitadas em `melhoras.md`, ordenadas por facilidade de implementação e dependência técnica (linha do tempo).

---

## 📅 Visão Geral das Sprints

| Fase | Título | Complexidade | Foco |
| :--- | :--- | :--- | :--- |
| **Fase 1** | UI/UX & Quick Wins | Baixa | Ajustes visuais e filtros rápidos |
| **Fase 2** | Ajustes de Dados e Regras | Média | Mudanças em formulários e validações |
| **Fase 3** | Lógica Automática e Relatórios | Média | Automatização de processos e exportação |
| **Fase 4** | Gestão de Acessos | Média/Alta | CRUD de usuários e permissões (RBAC) |
| **Fase 5** | Comunicação Interna | Média | Sistema de mensagens entre usuários |
| **Fase 6** | Arquitetura de Rematrícula | Alta | Histórico de anos letivos e novas matrículas |

---

## 🛠️ Detalhamento das Etapas

### 🟢 Fase 1: UI/UX & Quick Wins (Fácil)
Ajustes imediatos que melhoram a usabilidade do sistema sem impactar a arquitetura.

- [x] **Ajuste Turmas:** Remover o campo "período" na listagem de inserção de crianças (Item 9).
- [x] **Listagem Crianças:** Adicionar colunas de "Contato Responsável" (com link WhatsApp) e "E-mail" (Item 10).
- [x] **Filtros Evasão:** Adicionar filtro por período (Manhã/Tarde) na tela de evasão (Item 12).
- [x] **Cards Evasão:** Implementar cards de contagem por período no topo da tela de evasão (Item 13).
- [x] **Dashboard Aniversariantes:** Criar seção para listar crianças que fazem aniversário no dia atual (Item 7).
- [x] **Dashboard Alerta Triagem:** Lógica para avisar sobre crianças paradas na triagem há mais de 7 dias (Item 3).

### 🟡 Fase 2: Ajustes de Dados e Regras (Moderada)
Alterações que envolvem pequenas mudanças no banco de dados ou regras de negócio existentes.

- [x] **Pre-inscrição (DB):** Renomear label de período e adicionar campo "Período desejado na ONG" (Item 14).
    - *Nota:* Requer criação de coluna no banco de dados.
- [x] **Regra de Matrícula:** Alterar validação para exigir apenas 1 documento da criança e 1 do responsável para habilitar "Aprovar para Anamnese" (Item 5).

### 🟠 Fase 3: Lógica Automática e Relatórios (Moderada)
Implementação de automações e exportação de dados mais robusta.

- [x] **Idade e Série Automática:** Criar lógica para atualização automática em 1º de Janeiro (Data dinâmica) (Item 6).
    - *Nota:* Usar Accessors no Model e um Command agendado ou verificação de "virada de ano".
- [x] **PDF Filtrado:** Implementar exportação de PDF da listagem de crianças respeitando os filtros aplicados (Item 11).

### 🔴 Fase 4: Gestão de Acessos (Concluída)
Segurança e níveis de permissão.

- [x] **CRUD Usuários:** Tela de gestão de usuários (Criar, Editar, Inativar) (Item 1).
- [x] **Roles (RBAC):** Implementar tipos de usuário (Admin e User) e proteger rotas/menus (Item 1).
    - *Nota:* Admin faz tudo; User não vê gestão de usuários.

### 🔵 Fase 5: Comunicação Interna (Moderada)
Recursos para facilitar a troca de informações entre a equipe.

- [x] **Sistema de Mensagens:** Criar caixa de entrada/envio de mensagens internas entre usuários sobre crianças específicas (Item 2).

### 🟣 Fase 6: Arquitetura de Rematrícula (Concluída)
Transformar o sistema de matrícula única em um sistema histórico por Ano Letivo.

- [x] **Nova Estrutura de Dados:** 
    - Criar tabela `anos_letivos` (id, ano, status_ativo).
    - Criar tabela `matriculas` para desacoplar dados variáveis da criança (Série, Escola, Turma, Status) do cadastro fixo (Nome, CPF, RG).
- [x] **Migração de Dados:** Script para mover os dados atuais para a primeira "Safra" (2026).
- [x] **Lógica de Rematrícula Inteligente:** Botão que duplica os dados do ano anterior para o novo ano, permitindo edição rápida.

---



PONTO. **RESPOSTA DO DESENVOLVEDOR**:

    - **Análise Técnica**: 
        - Transformar o sistema de matrícula única em histórico por **Ano Letivo**.
        - Criação da tabela `anos_letivos` para controle de períodos (ex: 2026, 2027).
        - Criação da tabela `matriculas` para desacoplar dados que mudam anualmente (Escola, Série, Turma, Status) do cadastro fixo da criança.
        - Ajuste na tabela `anamnese` para suportar registros por Ano Letivo.

    - **Fluxo de UI (Nova Aba: REMATRÍCULA)**:
        - Terá 2 sub-etapas claras: **Matrícula** e **Anamnese**.
        - Crianças ativas no ano anterior aparecem como `PENDENTE_REMATRICULA_MATRICULA`.
        - Dados são pré-preenchidos do ano anterior para edição rápida.
        - Aprovação da Matrícula -> Status: `PENDENTE_REMATRICULA_ANAMNESE`.
        - Aprovação da Anamnese -> Status: `REMATRICULADA` (Pronta para alocação em nova turma).

    - **Plano de Ação (Amanhã)**:
        1. **Migrações**: Criar `anos_letivos`, `matriculas` e atualizar `anamnese`. Script para migrar dados atuais (2026).
        2. **Modelos**: Refatorar `Crianca.php`, criar `Matricula.php` e `AnoLetivo.php` com as devidas relações.
        3. **Interface**: Criar tela de Rematrícula e atualizar o perfil da criança para exibir o histórico anual.
        4. **Funcionalidades**: Manter recursos de PDF, Edição e Auditoria integrados à nova estrutura.

**Status da Sprint:** 🟠 Em Execução (Fase 6 planejada para amanhã)

**Última Atualização:** 28/05/2026
