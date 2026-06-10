# Guia Completo para o Relatorio de Extensao - Sistema ONG Multirao Bem

Este guia consolida o que precisa aparecer no relatorio de extensao com base em:

- `1_regulamento_de_extensao.pdf`
- `Manual de Extensao CC e SI - Marques e Chacara.pdf`
- `Modelo de projeto de Extensao - Demais series.pdf`
- Documentos tecnicos ja preparados na pasta `relatorio`

Use este arquivo como checklist para montar ou revisar o relatorio final antes de enviar na plataforma da UNIP.

---

## 1. Enquadramento da Atividade

O projeto deve ser apresentado como uma atividade de extensao porque envolve a aplicacao de conhecimento academico em beneficio de uma organizacao externa a universidade.

Para ficar aderente aos manuais, deixe claro que houve:

- **Interacao com a comunidade externa:** atendimento a uma demanda real da ONG Multirao Bem.
- **Participacao ativa do aluno:** levantamento de requisitos, modelagem, desenvolvimento, testes, validacao e registro das atividades.
- **Objetivo formativo:** aplicacao pratica de Engenharia de Software, banco de dados, seguranca da informacao, UX e integracao de APIs.
- **Impacto social:** melhoria dos processos de atendimento de criancas, familias e equipe tecnica da ONG.

Area tematica recomendada:

- **Principal:** Tecnologia e Producao.
- **Secundarias, se o formulario permitir:** Educacao, Saude, Direitos Humanos e Justica.

> Confirme na plataforma do aluno ou com o coordenador qual area tematica deve ser marcada oficialmente. O mais seguro para este projeto e Tecnologia e Producao.

---

## 2. Requisitos do Regulamento da UNIP

O relatorio deve demonstrar os criterios centrais do regulamento:

- **Art. 4 - Principios:** respeito a etica, equidade, responsabilidade social, beneficios sociais, formacao cidada e atendimento a legislacao.
- **Art. 7 - Formulario/projeto:** instituto, curso, identificacao da atividade, objetivo, descricao, publico-alvo, docente responsavel, criterios de participacao, duracao, cronograma e necessidades especificas.
- **Art. 8 - Criterios de avaliacao:** relevancia para a comunidade, desenvolvimento do aluno, exequibilidade do projeto e atencao a preceitos eticos e legais.
- **Art. 12 - Registro:** as atividades devem ser registradas em formulario proprio.
- **Art. 16 - Responsabilidade do aluno:** preencher ficha de atividades, entregar descricao das atividades e anexar documentos comprobatorios.
- **Art. 20 a 22 - Avaliacao:** incluir autoavaliacao critica e evidencias do beneficio social.
- **Art. 23 - Restricao:** extensao nao pode ser contabilizada como estagio nem como atividade complementar.

Ponto importante: extensao corresponde a pelo menos 10% da carga horaria total do curso, conforme a curricularizacao da extensao e a Resolucao CNE/CES no 7/2018.

---

## 3. Diferenca Entre Extensao, Atividade Complementar e Estagio

Nao descreva o projeto como estagio, freelancing, voluntariado generico ou atividade complementar.

Use esta linha de raciocinio:

- **Extensao:** atividade planejada, com comunidade externa, objetivo formativo, impacto social e registro institucional.
- **Atividade complementar:** pode enriquecer a formacao, mas nao necessariamente envolve intervencao social.
- **Estagio:** pratica profissional supervisionada, com regras proprias. Nao e o caso deste relatorio.

Frase util:

> A atividade foi desenvolvida como projeto de extensao universitario, nao sendo contabilizada como estagio ou atividade complementar, em conformidade com o Art. 23 do Regulamento de Extensao da UNIP.

---

## 4. Estrutura Recomendada do Relatorio Final

Use esta estrutura se o professor nao tiver enviado um modelo especifico:

1. **Capa**
   - Universidade Paulista - UNIP.
   - Curso.
   - Nome do aluno.
   - RA.
   - Titulo do projeto.
   - Cidade e ano.

2. **Titulo do Projeto**
   - Sugestao: `Transformacao Digital e Gestao Estruturada da ONG Multirao Bem`.

3. **Apresentacao / Justificativa**
   - Contexto da ONG.
   - Problema encontrado: fichas em papel, planilhas, retrabalho, risco de perda de dados, dificuldade de rastreabilidade.
   - Relevancia social: atendimento de criancas e familias, apoio a equipe administrativa e tecnica.
   - Relacao com o curso: aplicacao de desenvolvimento web, banco de dados, seguranca e integracao de sistemas.

4. **Objetivo Geral**
   - Implementar uma plataforma digital para organizar o fluxo de pre-inscricao, matricula, anamnese, turmas, comunicacao e registros administrativos da ONG Multirao Bem.

5. **Objetivos Especificos**
   - Digitalizar o processo de pre-inscricao.
   - Estruturar banco de dados relacional com historico anual.
   - Proteger dados sensiveis conforme a LGPD.
   - Automatizar triagem, matricula, anamnese e alocacao em turmas.
   - Gerar documentos e relatorios em PDF.
   - Melhorar a comunicacao com responsaveis por e-mail, WhatsApp e dados de endereco registrados de forma estruturada.
   - Fornecer evidencias e indicadores para tomada de decisao da ONG.

6. **Metodologia**
   - Levantamento de necessidades com a ONG.
   - Modelagem do banco de dados.
   - Desenvolvimento incremental dos modulos.
   - Testes com dados de demonstracao.
   - Validacao dos fluxos com usuarios da ONG.
   - Registro de evidencias, prints, fotos, materiais gerados e feedbacks.

7. **Publico-Alvo**
   - Equipe administrativa da ONG.
   - Equipe tecnica, como pedagogos, psicologos ou responsaveis por acompanhamento.
   - Criancas atendidas pela instituicao.
   - Familias e responsaveis legais.

8. **Desenvolvimento Tecnico**
   - Laravel 13.4 com PHP 8.3+.
   - Padrao MVC.
   - Vite, Blade e Tailwind CSS.
   - MariaDB/MySQL.
   - Eloquent ORM e migrations.
   - DomPDF para documentos.
   - Integracoes com WhatsApp, SMTP, mensagens internas e geracao de documentos em PDF.
   - Logs de auditoria e criptografia AES-256.

9. **Resultados Alcancados**
   - Digitalizacao de fichas e processos.
   - Reducao de retrabalho administrativo.
   - Melhor controle de triagem, matricula, anamnese e turmas.
   - Protecao de dados sensiveis.
   - Geracao de documentos padronizados.
   - Melhor comunicacao com responsaveis.
   - Base de dados historica para acompanhamento anual.

10. **Avaliacao do Impacto**
    - Quantas pessoas ou setores foram atendidos.
    - Como a rotina da ONG mudou.
    - Quais problemas foram reduzidos.
    - Feedbacks ou relatos da equipe.
    - Evidencias: fotos, listas, prints, documentos gerados, declaracao assinada.

11. **Autoavaliacao**
    - Aprendizados tecnicos.
    - Aprendizados eticos e sociais.
    - Dificuldades enfrentadas.
    - Melhorias futuras.

12. **Consideracoes Finais**
    - Retomar o impacto social e formativo.
    - Reforcar a aderencia a extensao universitaria.

13. **Referencias**
    - Regulamento de Extensao da UNIP.
    - Manual de Extensao CC e SI.
    - Resolucao CNE/CES no 7/2018.
    - LGPD - Lei no 13.709/2018.
    - Documentacao do Laravel, Tailwind, DomPDF e demais tecnologias.

14. **Anexos**
    - Ficha de atividades.
    - Declaracao da ONG.
    - Fotos.
    - Prints do sistema.
    - Prints do codigo ou repositorio.
    - PDFs gerados pelo sistema.
    - Lista de presenca ou registro de validacao, se houver.
    - Feedbacks/depoimentos da ONG.

---

## 5. Relatorio Sintese na Plataforma da UNIP

O manual orienta o preenchimento do campo **Relatorio Sintese** na Area do Aluno, em `Atividades Complementares e de Extensao > Atividades de Extensao`.

Esse campo deve conter:

1. **Breve relato da atividade realizada**
   - Explique o que foi feito.
   - Informe se foi atividade individual ou em grupo.
   - Se foi em grupo, informe o numero de alunos participantes.

2. **Discussao e resultados alcancados**
   - Descreva os resultados concretos.
   - Informe quantas pessoas foram atendidas ou quais setores da ONG foram beneficiados.
   - Mostre impacto social, nao apenas entrega tecnica.

3. **Consideracoes finais**
   - Dificuldades enfrentadas.
   - Sugestoes de melhoria.
   - Aprendizados tecnicos, eticos e sociais.
   - Observacoes relevantes.

Importante:

- Podem existir de 1 a 10 relatorios, desde que totalizem a carga horaria de extensao do curso.
- A atividade pode ser feita em grupo, mas o relatorio deve ser entregue individualmente.
- Anexos devem ser enviados com fotos, certificados, depoimentos, imagens, prints e outros materiais comprobatorios.

---

## 6. Dados Tecnicos do Projeto Multirao Bem

Use estes dados para a fundamentacao tecnica:

- **Tecnologia principal:** Laravel 13.4, PHP 8.3+, Blade, Vite e Tailwind CSS.
- **Arquitetura:** MVC com separacao entre Models, Views, Controllers, Services e migrations.
- **Banco de dados:** MariaDB/MySQL com 13 tabelas principais, incluindo criancas, responsaveis, vinculos familiares, moradia, familia, anamnese, anos letivos, turmas, matriculas, mensagens, usuarios e logs de auditoria.
- **Seguranca:** criptografia AES-256 para dados sensiveis e logs de auditoria para rastreabilidade.
- **LGPD:** coleta de consentimento, protecao de dados de saude e controle de acesso administrativo.
- **Automacao:** geracao de fichas e prontuarios em PDF.
- **Integracoes:** WhatsApp para comunicacao rapida, SMTP para notificacoes por e-mail, mensagens internas e geracao de PDFs.
- **Validacao:** seeder/showroom com 14 cenarios de teste para demonstracao e revisao dos fluxos.

---

## 7. Sugestao de Descricao da Atividade

Use ou adapte este texto:

> Desenvolvimento de uma plataforma de gestao para a ONG Multirao Bem, envolvendo levantamento de requisitos, modelagem de dados, desenvolvimento web, seguranca da informacao e validacao de fluxos administrativos. O sistema abrange pre-inscricao publica, matricula socioeconomica, anamnese digital, gestao de turmas, comunicacao com responsaveis e geracao de documentos em PDF. A atividade aplicou conceitos de Engenharia de Software para resolver gargalos operacionais reais da instituicao, fortalecendo a rastreabilidade, a protecao de dados sensiveis e a qualidade do atendimento prestado a criancas e familias.

---

## 8. Sugestao de Metodologia

> A metodologia foi organizada em ciclos incrementais. Inicialmente, foram levantadas as necessidades da ONG e identificados os principais problemas dos processos manuais. Em seguida, foi realizada a modelagem do banco de dados relacional, contemplando dados de criancas, responsaveis, composicao familiar, anamnese, turmas e historico anual de matriculas. Depois, foram desenvolvidos os modulos web em Laravel 13.4, com interface em Blade e Tailwind CSS. A cada ciclo, os fluxos foram testados com dados de demonstracao e revisados conforme a aderencia as necessidades da instituicao. Por fim, foram reunidas evidencias da execucao, como prints do sistema, registros tecnicos, documentos gerados e comprovacao da validacao pela ONG.

---

## 9. Sugestao de Resultados e Impacto

Evite dizer apenas que "o sistema foi entregue". O manual pede impacto social e avaliacao da contribuicao para a comunidade.

Resultados que podem ser mencionados:

- Substituicao de fichas fisicas e planilhas por banco de dados centralizado.
- Reducao do tempo de triagem e matricula.
- Melhor rastreabilidade de alteracoes administrativas.
- Protecao de dados de saude e dados socioeconomicos.
- Organizacao de historico anual de matriculas.
- Agilidade na comunicacao com responsaveis.
- Acesso rapido a prontuarios e fichas em PDF.
- Melhoria na capacidade da ONG de acompanhar criancas e familias.

Indicadores/evidencias que fortalecem o relatorio:

- Numero de registros de teste usados na validacao.
- Numero de modulos implementados.
- Pessoas/setores da ONG beneficiados.
- Antes/depois do processo manual e digital.
- Feedback da equipe da ONG.
- Prints dos fluxos principais.
- Declaracao assinada pela instituicao.

---

## 10. Avaliacao e Autoavaliacao

Inclua uma secao propria de avaliacao. Os PDFs destacam que a extensao deve passar por avaliacao critica e evidenciar impacto.

Perguntas para responder:

- O que mudou para a ONG?
- Que problema social ou operacional foi enfrentado?
- Como o aluno aplicou conhecimentos do curso?
- Que dificuldades surgiram?
- Que competencias foram desenvolvidas?
- Que melhorias futuras poderiam ser feitas?
- A comunidade atendida percebeu valor na solucao?

Texto modelo:

> A avaliacao da atividade considerou a aderencia do sistema as necessidades reais da ONG, a capacidade de reduzir retrabalho administrativo, a organizacao dos dados das familias atendidas e a protecao de informacoes sensiveis. Tambem foram considerados registros de validacao, prints dos modulos, documentos gerados e percepcoes da equipe da instituicao. A autoavaliacao demonstrou desenvolvimento tecnico em arquitetura web, banco de dados e seguranca, alem de amadurecimento etico diante do tratamento de dados pessoais de criancas e familias.

---

## 11. Evidencias e Anexos Obrigatorios

Monte os anexos com foco em comprovar a atividade extensionista.

Checklist recomendado:

- [ ] Ficha de atividades da UNIP preenchida.
- [ ] Visto do professor responsavel, se exigido pelo campus.
- [ ] Declaracao assinada e carimbada pela ONG.
- [ ] Fotos de reuniao, apresentacao, validacao ou uso do sistema na ONG.
- [ ] Prints das telas principais: pre-inscricao, triagem, matricula, anamnese, turmas, dashboard e PDFs.
- [ ] Prints do codigo ou repositorio: migrations, controllers, models, services e logs.
- [ ] PDF de ficha de matricula ou anamnese gerado pelo sistema.
- [ ] Evidencia de integracao: WhatsApp, e-mail, mensagens internas ou PDFs.
- [ ] Lista de presenca, registro de validacao ou ata simples de reuniao, se houver.
- [ ] Feedback/depoimento da ONG, se possivel.
- [ ] Termo de cessao de imagem e conteudo, se forem usadas fotos identificaveis de pessoas.
- [ ] Carta de apresentacao, se o campus exigir para contato com instituicao parceira.

Ponto de atencao:

- Prints de codigo ajudam a comprovar autoria, mas nao substituem evidencias de impacto social e interacao com a ONG.

---

## 12. Como Preencher o Modelo de Projeto

Se o professor pedir o modelo formal de projeto de extensao, use este preenchimento como base:

- **Titulo do Projeto:** Transformacao Digital e Gestao Estruturada da ONG Multirao Bem.
- **Curso(s) envolvido(s):** Ciencia da Computacao e/ou Sistemas de Informacao.
- **Area Tematica:** Tecnologia e Producao.
- **Apresentacao / Justificativa:** a ONG realizava registros manuais e precisava de uma solucao segura para organizar atendimentos, dados socioeconomicos, anamnese e turmas.
- **Objetivo Geral:** desenvolver e validar uma plataforma web para apoiar a gestao da ONG.
- **Objetivos Especificos:** digitalizar processos, proteger dados, melhorar triagem, gerar documentos, integrar comunicacao e criar historico anual.
- **Metodologia:** levantamento de requisitos, modelagem, desenvolvimento incremental, testes, validacao e registro de evidencias.
- **Publico-Alvo:** equipe da ONG, criancas atendidas, familias e responsaveis.
- **Resultados Esperados:** reducao de retrabalho, dados mais seguros, melhor atendimento, melhor rastreabilidade e apoio a decisao.
- **Avaliacao:** validacao pela ONG, evidencias documentais, feedbacks, prints, indicadores de uso e autoavaliacao.
- **Cronograma:** organizar por meses ou etapas.
- **Responsaveis:** aluno, professor/coordenador e representante da ONG.
- **Necessidade de Recursos / Custos:** computador, internet, ambiente local/servidor, ferramentas de desenvolvimento; sem custos adicionais relevantes, se aplicavel.

---

## 13. Cronograma Sugerido

Adapte as datas conforme o periodo real da atividade:

| Etapa | Atividade | Evidencia |
| --- | --- | --- |
| 1 | Levantamento de requisitos com a ONG | anotacoes, fotos, declaracao |
| 2 | Modelagem do banco de dados | DER, migrations, prints |
| 3 | Desenvolvimento da pre-inscricao e triagem | prints do sistema |
| 4 | Desenvolvimento de matricula, familia e moradia | prints e testes |
| 5 | Desenvolvimento da anamnese e seguranca LGPD | prints, codigo, PDF |
| 6 | Gestao de turmas e historico anual | prints, testes |
| 7 | Integracoes, comunicacao e notificacoes | prints WhatsApp, e-mail, mensagens e PDFs |
| 8 | Validacao, showroom e ajustes | registros de teste, feedback |
| 9 | Organizacao dos anexos e relatorio final | arquivo final e comprovantes |

---

## 14. Modelo de Declaracao para a ONG Assinar

Solicite que a ONG imprima em papel timbrado, se possivel.

> **DECLARACAO DE ATIVIDADE DE EXTENSAO**
>
> Declaramos que o(a) aluno(a) **[SEU NOME]**, RA **[SEU RA]**, do curso de **[SEU CURSO]** da Universidade Paulista - UNIP, realizou atividade de extensao junto a **ONG Multirao Bem**.
>
> A atividade consistiu no levantamento de necessidades, desenvolvimento, testes e validacao de uma plataforma web de gestao institucional, contemplando pre-inscricao, matricula socioeconomica, anamnese digital, gestao de turmas, comunicacao com responsaveis, geracao de documentos e protecao de dados sensiveis.
>
> A solucao contribuiu para a organizacao dos processos internos da instituicao, reducao de retrabalho administrativo, melhoria da rastreabilidade das informacoes e apoio ao atendimento de criancas e familias acompanhadas pela ONG.
>
> As atividades foram realizadas no periodo de **[DATA INICIAL]** a **[DATA FINAL]**, totalizando aproximadamente **[CARGA HORARIA]** horas.
>
> **[CIDADE]**, **[DATA]**.
>
> _________________________________________________
>
> **Assinatura e carimbo do responsavel pela ONG Multirao Bem**

---

## 15. Checklist Final Antes de Enviar

- [ ] O relatorio mostra interacao real com comunidade externa.
- [ ] A area tematica foi informada.
- [ ] O texto explica relevancia social, nao apenas codigo.
- [ ] A metodologia descreve etapas concretas.
- [ ] O publico-alvo esta claro.
- [ ] Os resultados indicam impacto para a ONG.
- [ ] Existe autoavaliacao critica.
- [ ] A LGPD foi mencionada como preceito etico/legal.
- [ ] O Art. 23 foi respeitado: nao tratar como estagio ou atividade complementar.
- [ ] O relatorio individual esta pronto, mesmo que a atividade tenha sido em grupo.
- [ ] A ficha de atividades foi preenchida.
- [ ] Os anexos comprovam execucao e impacto.
- [ ] A declaracao da ONG foi assinada.
- [ ] O termo de cessao de imagem foi providenciado, se houver fotos de pessoas identificaveis.
