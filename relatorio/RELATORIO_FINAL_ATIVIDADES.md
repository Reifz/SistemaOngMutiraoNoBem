# UNIVERSIDADE PAULISTA – UNIP
## CURSO DE [SEU CURSO - EX: CIÊNCIA DA COMPUTAÇÃO / SISTEMAS DE INFORMAÇÃO]

---

**RELATÓRIO DE ATIVIDADES DE EXTENSÃO: TRANSFORMAÇÃO DIGITAL E GESTÃO ESTRUTURADA DA ONG MULTIRÃO BEM**

---

**[SEU NOME COMPLETO]**
**RA: [SEU RA]**

---
**[CIDADE – UF]**
**2026**

\newpage

### 1. INTRODUÇÃO
O presente relatório detalha o projeto de extensão desenvolvido para a ONG Multirão Bem, uma instituição dedicada ao atendimento socioeducativo de crianças. Antes da intervenção, a ONG operava com processos manuais baseados em fichas de papel e planilhas isoladas, o que dificultava a rastreabilidade dos dados e a segurança das informações sensíveis. 

O projeto consistiu na criação de uma plataforma web robusta, utilizando o framework **Laravel 11**, para gerenciar todo o ciclo de vida do aluno: desde a pré-inscrição pública até a alocação em turmas e acompanhamento de saúde. Esta iniciativa cumpre o papel da extensão universitária ao aplicar tecnologias de ponta para solucionar problemas operacionais reais, promovendo a eficiência administrativa e o impacto social através da tecnologia.

### 2. OBJETIVOS
- **Geral:** Implementar um ecossistema digital completo para a gestão acadêmica e socioeconômica da ONG Multirão Bem.
- **Específicos:** 
    - **Automatização do Fluxo de Entrada:** Criar um formulário público de pré-inscrição com coleta de consentimento LGPD.
    - **Conformidade Legal (LGPD):** Implementar criptografia AES-256 para dados de saúde (Anamnese) e trilhas de auditoria para todas as ações administrativas.
    - **Gestão Histórica:** Estruturar o banco de dados para suportar múltiplos anos letivos e processos de rematrícula.
    - **Inteligência de Dados:** Desenvolver relatórios de evasão e dashboards de monitoramento (aniversariantes, alertas de triagem).

### 3. DESENVOLVIMENTO (FUNDAMENTAÇÃO TÉCNICA E ARQUITETURA)
O desenvolvimento foi fundamentado em práticas modernas de Engenharia de Software, garantindo que o sistema seja sustentável e seguro.

#### 3.1. Stack Tecnológica e Arquitetura
O sistema utiliza o framework **Laravel 11** sob a linguagem **PHP 8.3**. A arquitetura segue o padrão **MVC (Model-View-Controller)**, o que permitiu a separação clara entre a lógica de negócio, a gestão de dados (via Eloquent ORM) e a interface do usuário (Blade Templates e Tailwind CSS). O uso do **Vite** como empacotador garantiu uma interface responsiva e de alta performance.

#### 3.2. Modelagem de Dados Relacional
O banco de dados (MariaDB/MySQL) foi estruturado com 13 tabelas principais. Um dos maiores desafios técnicos foi a migração da arquitetura de "Matrícula Única" para a de **"Histórico Anual"**. Criamos a tabela `anos_letivos` e `matriculas`, permitindo que a mesma criança tenha registros históricos diferentes (série, escola, turma) a cada ano, preservando a integridade do prontuário ao longo do tempo.

#### 3.3. Segurança e Privacidade (LGPD)
Em estrito cumprimento à Lei Geral de Proteção de Dados (Art. 4º do Regulamento UNIP), implementamos:
- **Criptografia AES-256:** Todos os dados clínicos do módulo de Anamnese são criptografados antes de serem persistidos.
- **Logs de Auditoria:** Uma tabela dedicada (`logs_auditoria`) registra cada ação realizada por qualquer administrador, permitindo rastrear quem alterou, aprovou ou visualizou dados críticos.
- **Gestão de Consentimento:** O formulário público exige o aceite dos termos de privacidade pelo responsável legal no momento da inscrição.

### 4. METODOLOGIA (CICLO DE DESENVOLVIMENTO)
O projeto seguiu uma metodologia ágil dividida em seis ciclos incrementais:
1. **Fundação:** Configuração do ambiente e formulário público de pré-inscrição.
2. **Triagem e Dashboard:** Implementação da lógica de aprovação e filtros de busca por fase.
3. **Censo Socioeconômico:** Módulos complexos de moradia, composição familiar e múltiplos contatos.
4. **Prontuário de Saúde (Anamnese):** Desenvolvimento do sistema de anamnese com 7 sub-módulos e exportação para PDF.
5. **Gestão de Turmas:** CRUD completo de turmas e lógica de alocação/desvínculo de alunos.
6. **Refinamento e Showroom:** Implementação de relatórios de evasão, notificações e um seeder de demonstração com 16 registros reais para validação.

### 5. RESULTADOS E IMPACTO SOCIAL
O sistema atingiu o estado de "Pronto para Showroom", com os seguintes marcos:
- **Redução Burocrática:** O tempo médio de triagem de uma criança foi reduzido de dias para minutos, com notificações automáticas por e-mail para a equipe.
- **Qualidade da Informação:** A equipe técnica (pedagogos e psicólogos) agora acessa o prontuário completo e anamnese de qualquer dispositivo, com relatórios gerados em PDF seguindo a identidade visual (Roxo/Amarelo) da ONG.
- **Análise Estatística:** O módulo de evasão identifica automaticamente o principal motivo de desligamento, permitindo que a ONG tome medidas preventivas.
- **Escalabilidade:** O sistema já está preparado para a virada do ano letivo de 2026 para 2027 com um único comando automatizado (`app:virada-ano-letivo`).

### 6. AUTOAVALIAÇÃO E CONCLUSÃO
O desenvolvimento deste projeto de extensão foi um divisor de águas na minha formação acadêmica. Mais do que escrever código, foi necessário entender as vulnerabilidades sociais das famílias atendidas pela ONG para desenhar fluxos de trabalho que fossem, ao mesmo tempo, rigorosos tecnicamente e humanos socialmente. A transição de um sistema simples para uma plataforma de gestão histórica me ensinou a importância da arquitetura escalável e da proteção de dados em um mundo regido pela LGPD. Concluo que a tecnologia é, de fato, uma das ferramentas mais potentes para a promoção da justiça social e eficiência institucional.

---

### 7. REFERÊNCIAS
- LARAVEL. **Laravel Framework Documentation v11.x**. Disponível em: https://laravel.com/docs.
- BRASIL. **Lei Geral de Proteção de Dados Pessoais (LGPD)**. Lei nº 13.709/2018.
- UNIP. **Regulamento das Atividades de Extensão**. Vice-Reitoria de Extensão, 2018.
- TAILWIND LABS. **Tailwind CSS Documentation**. Disponível em: https://tailwindcss.com.

---

### 8. ANEXOS (DOCUMENTOS COMPROBATÓRIOS)
*   [ ] **Ficha de Atividades (UNIP):** Preenchida e visada pelo professor.
*   [ ] **Declaração de Atividades:** Assinada pelo responsável da ONG Multirão Bem.
*   [ ] **Prontuário Digital:** Prints das telas de Matrícula e Anamnese Criptografada.
*   [ ] **Evidência de Código:** Prints das Migrations e Controllers no VS Code.
*   [ ] **Fotos da Intervenção:** Registros de reuniões e testes na sede da ONG.
