# Esquema do Banco de Dados - Multirão Bem (Oficial)

Este documento detalha a estrutura completa e atualizada das tabelas, tipos de dados e relacionamentos do sistema, refletindo o estado atual do banco de dados.

---

## 🧩 Tabelas do Sistema

### 0. `users` (Autenticação Administrativa)
Armazena os usuários com permissão de acesso ao dashboard.

| Coluna | Tipo | Descrição |
| :--- | :--- | :--- |
| `id` | BIGINT UNSIGNED (PK) | Identificador único do usuário. |
| `name` | VARCHAR(255) | Nome completo do usuário. |
| `email` | VARCHAR(255) | E-mail de login (único). |
| `role` | VARCHAR(255) | Nível de acesso (admin, user). Padrão: 'user'. |
| `ativo` | BOOLEAN | Status do usuário (1=Ativo, 0=Inativo). Padrão: 1. |
| `email_verified_at` | TIMESTAMP | Data de verificação do e-mail (NULL por padrão). |
| `password` | VARCHAR(255) | Senha criptografada (Bcrypt). |
| `remember_token` | VARCHAR(100) | Token para persistência de sessão. |
| `created_at` | TIMESTAMP | Data de criação. |
| `updated_at` | TIMESTAMP | Data de atualização. |

---

### 1. `responsaveis`
Armazena as informações detalhadas dos pais ou responsáveis legais.

| Coluna | Tipo | Descrição |
| :--- | :--- | :--- |
| `id` | INT (PK) | Identificador único do responsável. |
| `nome` | VARCHAR(255) | Nome completo. |
| `email` | VARCHAR(255) | E-mail de contato. |
| `telefone` | VARCHAR(20) | Telefone principal. |
| `telefone_secundario` | VARCHAR(20) | Telefone opcional. |
| `acesso_local` | VARCHAR(50) | Facilidade de acesso (Fácil, Médio, Difícil). |
| `consentimento_lgpd` | BOOLEAN | Aceite dos termos da LGPD. |
| `data_consentimento` | TIMESTAMP | Data/hora do consentimento. |
| `parentesco` | VARCHAR(50) | Grau de parentesco com a criança. |
| `estado_civil` | VARCHAR(50) | Estado civil do responsável. |
| `data_nascimento` | DATE | Data de nascimento do responsável. |
| `idade` | INT | Idade calculada/informada. |
| `grau_instrucao` | VARCHAR(100) | Nível de escolaridade. |
| `cpf` | VARCHAR(20) | CPF (único). |
| `rg` | VARCHAR(20) | RG. |
| `tem_cadastro_unico` | BOOLEAN | Se possui CadÚnico. |
| `recebe_transferencia_renda` | BOOLEAN | Se recebe Bolsa Família/Auxílio. |
| `recebe_bpc` | BOOLEAN | Se recebe BPC. |
| `profissao` | VARCHAR(100) | Ocupação atual. |
| `desempregado` | BOOLEAN | Status de emprego. |
| `created_at` | TIMESTAMP | Data de criação. |
| `updated_at` | TIMESTAMP | Data da última atualização. |

---

### 2. `criancas`
Dados principais da criança vinculada ao processo de matrícula.

| Coluna | Tipo | Descrição |
| :--- | :--- | :--- |
| `id` | INT (PK) | Identificador único da criança. |
| `responsavel_id` | INT (FK) | Referência ao responsável. |
| `nome` | VARCHAR(255) | Nome completo da criança. |
| `data_nascimento` | DATE | Data de nascimento. |
| `idade_declarada` | INT | Idade no momento da inscrição. |
| `sexo` | VARCHAR(20) | Sexo/Gênero. |
| `cor_raca` | VARCHAR(50) | Autodeclaração de cor/raça. |
| `naturalidade` | VARCHAR(100) | Cidade/Estado de nascimento. |
| `data_inscricao` | DATE | Data da pré-inscrição. |
| `data_matricula` | DATE | Data da efetivação da matrícula. |
| `data_desligamento` | DATE | Data de saída da ONG. |
| `motivo_desligamento` | TEXT | Justificativa da saída. |
| `limite_idade` | INT | Validação de idade para o programa. |
| `possui_deficiencia` | BOOLEAN | Indicador de PCD. |
| `cpf` | VARCHAR(20) | CPF da criança. |
| `rg` | VARCHAR(20) | RG da criança. |
| `certidao_nascimento` | VARCHAR(100) | Número da certidão. |
| `certidao_folha` | VARCHAR(50) | Folha da certidão. |
| `certidao_livro` | VARCHAR(50) | Livro da certidão. |
| `escola` | VARCHAR(255) | Nome da instituição de ensino. |
| `tipo_escola` | VARCHAR(50) | Pública ou Privada. |
| `serie` | VARCHAR(100) | Ano escolar atual. |
| `periodo_escolar` | VARCHAR(50) | Turno Escolar Atual (Manhã/Tarde). |
| `periodo_ong` | VARCHAR(50) | Turno desejado para alocação na ONG. |
| `esta_na_escola` | BOOLEAN | Se está frequentando a escola. |
| `status` | VARCHAR(50) | Status atual (Ex: 'PREENCHER', 'PENDENTE_MATRICULA', 'APROVADO', 'EM_TURMA', 'EVADIDA'). |
| `data_evasao` | DATE | Data em que a criança deixou de frequentar a turma. |
| `motivo_evasao` | VARCHAR(255) | Justificativa para a evasão. |
| `observacao_evasao` | TEXT | Detalhes adicionais sobre a saída. |
| `created_at` | TIMESTAMP | Data de criação. |
| `updated_at` | TIMESTAMP | Data da última atualização. |

---
### crianca_responsavel
| Coluna           | Tipo        | Descrição                                               |
| :--------------- | :---------- | :------------------------------------------------------ |
| `id`             | INT (PK)    | Identificador único da relação.                         |
| `crianca_id`     | INT (FK)    | Referência ao `id` da tabela `criancas`.                |
| `responsavel_id` | INT (FK)    | Referência ao `id` da tabela `responsaveis`.            |
| `parentesco`     | VARCHAR(50) | Tipo de vínculo (Ex: 'MAE', 'PAI', 'AVO', 'TIO').       |
| `principal`      | TINYINT(1)  | Indica se é o responsável principal (1 = sim, 0 = não). |
| `created_at`     | TIMESTAMP   | Data de criação do vínculo.                             |
| `updated_at`     | TIMESTAMP   | Data da última atualização.                             |


crianca_responsavel.crianca_id → criancas.id (ON DELETE CASCADE)
crianca_responsavel.responsavel_id → responsaveis.id (ON DELETE CASCADE)_

---

### 3. `moradias`
Dados detalhados sobre a residência da família.

| Coluna | Tipo | Descrição |
| :--- | :--- | :--- |
| `id` | INT (PK) | Identificador único. |
| `crianca_id` | INT (FK) | Referência à criança. |
| `endereco` | VARCHAR(255) | Logradouro e número. |
| `complemento` | VARCHAR(100) | Apartamento, bloco, etc. |
| `cep` | VARCHAR(20) | CEP. |
| `bairro` | VARCHAR(100) | Bairro. |
| `ponto_referencia` | VARCHAR(255) | Local próximo conhecido. |
| `situacao_habitacional` | VARCHAR(100) | Própria, Alugada, Cedida, etc. |
| `numero_comodos` | INT | Quantidade de cômodos na casa. |
| `numero_moradores` | INT | Total de pessoas que residem no local. |
| `condicao_moradia` | VARCHAR(50) | Alvenaria, Madeira, etc. |
| `created_at` | TIMESTAMP | Registro de criação. |
| `updated_at` | TIMESTAMP | Registro de atualização. |

---

### 4. `contatos`
Armazena múltiplos telefones e pessoas de contato associadas ao responsável.

| Coluna | Tipo | Descrição |
| :--- | :--- | :--- |
| `id` | INT (PK) | Identificador único. |
| `responsavel_id` | INT (FK) | Referência ao responsável. |
| `tipo` | VARCHAR(50) | Recado, WhatsApp, Trabalho, etc. |
| `numero` | VARCHAR(20) | Número do telefone. |
| `pessoa_contato` | VARCHAR(255) | Nome da pessoa (se for recado). |
| `created_at` | TIMESTAMP | Registro de criação. |

---

### 5. `familiares`
Composição familiar e socioeconômica das pessoas que coabitam com a criança.

| Coluna | Tipo | Descrição |
| :--- | :--- | :--- |
| `id` | INT (PK) | Identificador único. |
| `crianca_id` | INT (FK) | Referência à criança. |
| `nome` | VARCHAR(255) | Nome do familiar. |
| `data_nascimento` | DATE | Data de nascimento do familiar. |
| `idade` | INT | Idade. |
| `grau_parentesco` | VARCHAR(50) | Relação com a criança. |
| `grau_instrucao` | VARCHAR(100) | Escolaridade do familiar. |
| `estuda` | BOOLEAN | Se frequenta escola/faculdade. |
| `inserido_cca` | BOOLEAN | Se já está no sistema CCA. |
| `profissao` | VARCHAR(100) | Ocupação. |
| `ocupacao` | VARCHAR(100) | Detalhes da ocupação. |
| `renda` | DECIMAL(10,2) | Valor da renda individual. |
| `fatores_risco` | TEXT | Descrição de vulnerabilidades. |
| `created_at` | TIMESTAMP | Registro de criação. |

---

### 6. `turmas`
Configuração e gestão de turmas.

| Coluna | Tipo | Descrição |
| :--- | :--- | :--- |
| `id` | INT (PK) | Identificador único. |
| `nome` | VARCHAR(255) | Nome da turma. |
| `capacidade` | INT | Máximo de alunos. |
| `ativa` | BOOLEAN | Status da turma. |
| `created_at` | TIMESTAMP | Criação. |
| `updated_at` | TIMESTAMP | Atualização. |

---

### 7. `inscricoes`
Gerencia o fluxo de status do processo de inscrição/matrícula.

| Coluna | Tipo | Descrição |
| :--- | :--- | :--- |
| `id` | INT (PK) | Identificador único. |
| `crianca_id` | INT (FK) | Referência à criança. |
| `status` | VARCHAR(50) | Status (Padrão: 'PREENCHER'). |
| `consentimento_lgpd` | BOOLEAN | Confirmação de aceite. |
| `data_criacao` | TIMESTAMP | Início do processo. |

---

### 8. `anamnese`
Dados sensíveis de saúde armazenados em formato JSON.

| Coluna | Tipo | Descrição |
| :--- | :--- | :--- |
| `id` | INT (PK) | Identificador único. |
| `crianca_id` | INT (FK) | Referência à criança. |
| `dados_json` | LONGTEXT | Objeto JSON com histórico médico. |
| `updated_at` | TIMESTAMP | Última modificação. |

---

### 9. `logs_auditoria`
Registro de ações para conformidade LGPD e segurança.

| Coluna | Tipo | Descrição |
| :--- | :--- | :--- |
| `id` | INT (PK) | Identificador único. |
| `usuario_id` | INT | Admin que realizou a ação. |
| `acao` | VARCHAR(255) | Descrição da alteração. |
| `tabela_afetada` | VARCHAR(50) | Tabela modificada. |
| `registro_id` | INT | ID do registro afetado. |
| `detalhes` | TEXT | Log detalhado da mudança. |
| `data_hora` | TIMESTAMP | Momento da ação. |

---

### 10. `mensagens` (Comunicação Interna)
Sistema de troca de informações entre a equipe sobre as crianças.

| Coluna | Tipo | Descrição |
| :--- | :--- | :--- |
| `id` | BIGINT UNSIGNED (PK) | Identificador único. |
| `remetente_id` | BIGINT UNSIGNED (FK) | Usuário que enviou. |
| `destinatario_id` | BIGINT UNSIGNED (FK) | Usuário que recebeu. |
| `crianca_id` | INT (FK, NULL) | Criança relacionada (opcional). |
| `mensagem` | TEXT | Conteúdo da mensagem. |
| `lida` | BOOLEAN | Status de leitura (0=Não lida, 1=Lida). |
| `created_at` | TIMESTAMP | Data de envio. |
| `updated_at` | TIMESTAMP | Data de atualização. |

---

## 🔗 Relacionamentos (Foreign Keys)

- `criancas.responsavel_id` -> `responsaveis.id` (ON DELETE CASCADE)
- `moradias.crianca_id` -> `criancas.id` (ON DELETE CASCADE)
- `contatos.responsavel_id` -> `responsaveis.id` (ON DELETE CASCADE)
- `familiares.crianca_id` -> `criancas.id` (ON DELETE CASCADE)
- `inscricoes.crianca_id` -> `criancas.id` (ON DELETE CASCADE)
- `anamnese.crianca_id` -> `criancas.id` (ON DELETE CASCADE)
- `mensagens.remetente_id` -> `users.id` (ON DELETE CASCADE)
- `mensagens.destinatario_id` -> `users.id` (ON DELETE CASCADE)
- `mensagens.crianca_id` -> `criancas.id` (ON DELETE SET NULL)

---

## 🛠️ Alterações Pendentes

### Arquitetura de Rematrícula (Fase 6)

#### Nova Tabela: `anos_letivos`
| Coluna | Tipo | Descrição |
| :--- | :--- | :--- |
| `id` | INT (PK) | Identificador único. |
| `ano` | INT (Unique) | Ano (Ex: 2026). |
| `status_ativo` | BOOLEAN | Indica se é o ano letivo atual para novas matrículas. |
| `created_at` | TIMESTAMP | Registro de criação. |
| `updated_at` | TIMESTAMP | Registro de atualização. |

#### Nova Tabela: `matriculas`
Desacopla os dados anuais da criança do seu cadastro fixo.
| Coluna | Tipo | Descrição |
| :--- | :--- | :--- |
| `id` | INT (PK) | Identificador único. |
| `crianca_id` | INT (FK) | Referência à criança. |
| `ano_letivo_id` | INT (FK) | Referência ao ano letivo. |
| `turma_id` | INT (FK, NULL) | Referência à turma alocada no ano. |
| `escola` | VARCHAR(255) | Instituição de ensino no ano. |
| `tipo_escola` | VARCHAR(50) | Pública ou Privada. |
| `serie` | VARCHAR(100) | Série/Ano escolar no período. |
| `periodo_escolar` | VARCHAR(50) | Turno na escola regular. |
| `periodo_ong` | VARCHAR(50) | Turno desejado na ONG. |
| `status` | VARCHAR(50) | Status da matrícula no ano (Ex: 'REMATRICULADA', 'EVADIDA'). |
| `data_matricula` | DATE | Data da efetivação neste ano. |
| `created_at` | TIMESTAMP | Registro de criação. |
| `updated_at` | TIMESTAMP | Registro de atualização. |

#### Alteração na Tabela: `anamnese`
- Adição da coluna `ano_letivo_id` (INT, FK) para permitir histórico de saúde por ano letivo.

### Adição de Novos Anexos de Documentos (Melhoria)
Tabela: `criancas`
- `anexo_rg` (VARCHAR): RG da criança.
- `anexo_cpf` (VARCHAR): CPF da criança.
- `anexo_comprovante_residencia` (VARCHAR): Comprovante de residência da família.
- `anexo_comprovante_escolaridade` (VARCHAR): Comprovante de escolaridade da criança.
- `anexo_comprovante_renda` (VARCHAR): Comprovante de renda familiar.

---
*Última atualização oficial: 08/05/2026*
