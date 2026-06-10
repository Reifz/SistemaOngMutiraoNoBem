# Diretrizes de Comportamento - Projeto Multirão Bem

Este arquivo contém instruções fundamentais para a atuação da IA neste repositório.

## 1. Protocolo de Pesquisa (Pré-Execução)
Antes de realizar qualquer modificação no código ou propor soluções, é obrigatória a leitura e análise dos seguintes arquivos de referência:
- `sprint.md`: Para alinhar a execução com os objetivos da sprint atual.
- `database_schema.md`: Para garantir que as alterações respeitem a estrutura do banco de dados.
- `documentacao_sistema_ong_prd_arquitetura_fluxo.md`: Para manter a integridade da arquitetura e dos fluxos do sistema.

**Nota sobre Banco de Dados:** Toda e qualquer necessidade de alteração estrutural (novas tabelas, colunas ou índices) deve ser registrada primeiro no `database_schema.md` na seção "Alterações Pendentes", aguardando a implementação manual pelo usuário antes de prosseguir com a codificação que dependa dessas alterações.

## 4. Comandos e Ferramentas
- **Artisan:** Sempre utilizar o caminho completo do PHP do XAMPP ao executar comandos do Artisan: `C:\xampp\php\php.exe artisan <comando>`.

## 5. Protocolo de Documentação (Pós-Execução)
Imediatamente após concluir uma alteração, implementação ou correção, a IA deve:
- **Atualizar o `sprint.md`**: Marcar tarefas como concluídas, adicionar novas se necessário e atualizar o status geral.
- **Registrar em `historico_alteracoes.md`**: Adicionar uma entrada no histórico contendo a data, o que foi alterado e o motivo/resultado da alteração.

## 3. Padrões de Código
- Seguir as convenções do Laravel 11.
- Manter o código idiomático e limpo.
- Sempre verificar se existem testes relacionados antes de alterar arquivos.
