# 📚 Esquema do Banco de Dados - Multirão Bem (Atualizado)

Este documento descreve a estrutura completa do banco de dados após a unificação com os novos requisitos.

---

# 🧩 Tabelas do Sistema

## 0. `users`
Armazena usuários administrativos.

| Coluna | Tipo | Descrição |
|---|---|---|
| id | BIGINT (PK) | Identificador único |
| name | VARCHAR(255) | Nome |
| email | VARCHAR(255) | Email |
| email_verified_at | TIMESTAMP | Verificação |
| password | VARCHAR(255) | Senha |
| remember_token | VARCHAR(100) | Token |
| created_at | TIMESTAMP | Criação |
| updated_at | TIMESTAMP | Atualização |

---

## 1. `responsaveis`
Dados do responsável familiar.

| Coluna | Tipo |
|---|---|
| id | INT (PK) |
| nome | VARCHAR(255) |
| email | VARCHAR(255) |
| telefone | VARCHAR(20) |
| telefone_secundario | VARCHAR(20) |
| acesso_local | VARCHAR(50) |
| consentimento_lgpd | BOOLEAN |
| data_consentimento | TIMESTAMP |
| parentesco | VARCHAR(50) |
| estado_civil | VARCHAR(50) |
| data_nascimento | DATE |
| idade | INT |
| grau_instrucao | VARCHAR(100) |
| cpf | VARCHAR(20) |
| rg | VARCHAR(20) |
| tem_cadastro_unico | BOOLEAN |
| recebe_transferencia_renda | BOOLEAN |
| recebe_bpc | BOOLEAN |
| profissao | VARCHAR(100) |
| desempregado | BOOLEAN |
| created_at | TIMESTAMP |
| updated_at | TIMESTAMP |

---

## 2. `criancas`
Dados principais da criança.

| Coluna | Tipo |
|---|---|
| id | INT (PK) |
| responsavel_id | INT (FK) |
| nome | VARCHAR(255) |
| data_nascimento | DATE |
| idade_declarada | INT |
| sexo | VARCHAR(20) |
| cor_raca | VARCHAR(50) |
| naturalidade | VARCHAR(100) |
| data_inscricao | DATE |
| data_matricula | DATE |
| data_desligamento | DATE |
| motivo_desligamento | TEXT |
| limite_idade | INT |
| possui_deficiencia | BOOLEAN |
| cpf | VARCHAR(20) |
| rg | VARCHAR(20) |
| certidao_nascimento | VARCHAR(100) |
| certidao_folha | VARCHAR(50) |
| certidao_livro | VARCHAR(50) |
| escola | VARCHAR(255) |
| tipo_escola | VARCHAR(50) |
| serie | VARCHAR(100) |
| periodo_escolar | VARCHAR(50) |
| esta_na_escola | BOOLEAN |
| status | VARCHAR(50) |
| created_at | TIMESTAMP |
| updated_at | TIMESTAMP |

---

## 3. `moradias`
Dados da residência.

| Coluna | Tipo |
|---|---|
| id | INT (PK) |
| crianca_id | INT (FK) |
| endereco | VARCHAR(255) |
| complemento | VARCHAR(100) |
| cep | VARCHAR(20) |
| bairro | VARCHAR(100) |
| ponto_referencia | VARCHAR(255) |
| situacao_habitacional | VARCHAR(100) |
| numero_comodos | INT |
| numero_moradores | INT |
| condicao_moradia | VARCHAR(50) |
| created_at | TIMESTAMP |
| updated_at | TIMESTAMP |

---

## 4. `contatos`
Telefones do responsável.

| Coluna | Tipo |
|---|---|
| id | INT (PK) |
| responsavel_id | INT (FK) |
| tipo | VARCHAR(50) |
| numero | VARCHAR(20) |
| pessoa_contato | VARCHAR(255) |
| created_at | TIMESTAMP |

---

## 5. `familiares`
Pessoas que moram na casa.

| Coluna | Tipo |
|---|---|
| id | INT (PK) |
| crianca_id | INT (FK) |
| nome | VARCHAR(255) |
| data_nascimento | DATE |
| idade | INT |
| grau_parentesco | VARCHAR(50) |
| grau_instrucao | VARCHAR(100) |
| estuda | BOOLEAN |
| inserido_cca | BOOLEAN |
| profissao | VARCHAR(100) |
| ocupacao | VARCHAR(100) |
| renda | DECIMAL(10,2) |
| fatores_risco | TEXT |
| created_at | TIMESTAMP |

---

## 6. `turmas`
Configuração das turmas.

| Coluna | Tipo |
|---|---|
| id | INT (PK) |
| nome | VARCHAR(255) |
| capacidade | INT |
| ativa | BOOLEAN |
| created_at | TIMESTAMP |
| updated_at | TIMESTAMP |

---

## 7. `inscricoes`
Controle de inscrição.

| Coluna | Tipo |
|---|---|
| id | INT (PK) |
| crianca_id | INT (FK) |
| status | VARCHAR(50) |
| consentimento_lgpd | BOOLEAN |
| data_criacao | TIMESTAMP |

---

## 8. `anamnese`
Dados médicos em JSON.

| Coluna | Tipo |
|---|---|
| id | INT (PK) |
| crianca_id | INT (FK) |
| dados_json | LONGTEXT |
| updated_at | TIMESTAMP |

---

## 9. `logs_auditoria`
Auditoria do sistema.

| Coluna | Tipo |
|---|---|
| id | INT (PK) |
| usuario_id | INT |
| acao | VARCHAR(255) |
| tabela_afetada | VARCHAR(50) |
| registro_id | INT |
| detalhes | TEXT |
| data_hora | TIMESTAMP |

---

# 🔗 Relacionamentos

- criancas.responsavel_id → responsaveis.id
- moradias.crianca_id → criancas.id
- contatos.responsavel_id → responsaveis.id
- familiares.crianca_id → criancas.id
- inscricoes.crianca_id → criancas.id
- anamnese.crianca_id → criancas.id

---

# ✅ Considerações

- Estrutura normalizada
- Preparada para crescimento
- Evita redundância
- Facilita relatórios e manutenção

---

*Última atualização: 14/04/2026*
