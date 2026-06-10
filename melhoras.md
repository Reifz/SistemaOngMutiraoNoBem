NOVAS ALTERAÇÕES:

TIVE UMA REUNIÃO COM O CLIENTE E TEM VARIAS ALTERAÇÕES PARA FAZER AQUI VAI: 

OBSERVAÇÕES: 
 - COMO É MUITA COISA CRIE SPRINTS E ORDENE OS PONTOS QUE PRECISAM SER EXECUTADOS PRIMEIRO
 - Se for preciso criar colunas e tabelas no banco tudo bem
 - Cuidado para não alterar muito a logica existente, o sistema está perfeito

---
### 📝 ANÁLISE TÉCNICA E DÚVIDAS
*Abaixo, cada ponto recebeu comentários técnicos e perguntas para alinhamento.*
---

1 - Crud Usuarios
    criar um crud para usuarios, da mesma forma que criamos no register. Agora teremos editar, excluir, inativar.
    no crud, ter opção "tipo de usuario" ( admin pu user )
    Apenas admin pode criar e editar usuarios
    > **Técnico:** Etapa Moderada. Precisamos adicionar a coluna `role` na tabela `users` e proteger as rotas com Middleware.
    > **Dúvida:** O usuário "user" terá acesso a quais abas? (Apenas visualização ou pode preencher matrículas também?) 
    > **Resposta:** O usuário user pode fazer quase tudo no sistema, menos visualizar e mexer tela de usuarios.

2-  Conversas entre usuarios (ALERTA: ESSA ETAPA É NIVEL DIFICIL)
    Ter uma aba nova, como se fosse uma caixa de mensagens
    A logica:
    - Ao enviar nova "mensagem": vai ser possivel selecionar o user(destino), posso selecionar a criança e digitar a mensagem. Exemplo: Para Renta(user), Sobre criança joão, mensagem: quem foi que aprovou isso hoje?

    Essa mensagem vai ser registrada no banco de dados e para o user da Renata, vai aparecer que uma nova mensagem com cadastrada para ela, ou seja, não precisa ser em tempo real

    Renata vai poder visualizar todos os dados da mensagem e enviar uma resposta da mesma forma dita antes "Ao enviar nova "mensagem""
    Importante presevar o historico de mensagens
    > **Técnico:** Etapa Difícil. Requer criação da tabela `mensagens` (remetente, destinatário, crianca_id, texto, lida).
    > **Dúvida:** Essas mensagens devem aparecer também dentro do prontuário da criança para que outros admins vejam o histórico de conversas sobre ela no futuro?

3 - SOBRE A TRIAGEM
    Avisar no dashboard, todas as criança que estão no status ainda de aprovação de triagem após ficar 7 dias paradas
    Exemplo: 
    CRIANÇA X DA TRIAGEM Y ESTÁ A 7 DIAS PARADA [ botão para ir até a triagem]
    CRIANÇA Z DA TRIAGEM W ESTÁ A 7 DIAS PARADA [ botão para ir até a triagem]
    > **Técnico:** Etapa Simples. Lógica de SQL comparando `created_at` com a data atual no Dashboard.

5 - NA TELA DE MATRICULA TANTO EM PREENCHER, EDITAR
    hoje temos a regra que todos os documentos precisam ser preenchidos, mas apenas um dos documentos da criança e apenas  um dos documentos do responsavel precisa ser preenchido para habilitar o botão "aprovar para anamnese"
    > **Técnico:** Etapa Moderada. Alteração na regra de validação do formulário e na lógica do botão de status.

6 - ATUALIZAR IDADE AUTOMATICA E SERIE 
    Cliente pediu para atualizar automaticamente a idade da criança se baseando na data de nascimento, (exemplo: se ela foi cadastrada com 6 anos em 2026 em 2027 terá 7 anos)
    Também atualizar automaticamente a serie da criança, (Exemplo: se ela se cadastrou na 1° serie em 2026, logo em 2027 ela vai ser do 2° serie)
    > **Técnico:** Etapa Moderada. Idade será um `Accessor` (virtual) no Model. A série requer um processo de "virada de ano".
    > **Dúvida:** A atualização da série deve ser automática em 1º de Janeiro ou deve haver um botão "Virar Ano Letivo" para o Admin disparar manualmente?
    > **Resposta:** A atualização da série deve ser automática em 1º de Janeiro! Se puder deixar essa data dinamica, pois o cliente poderia mudar a data de virada

7 - NA TELA DE DASHBOARD 
    Aparecer todas as crianças aniversáriantes do dia
    > **Técnico:** Etapa Simples. Nova seção no Dashboard com filtro de dia/mês.

8 - LOGICA PARA UMA REMATRICULA (ALERTA: ESSA ETAPA É NIVEL DIFICIL)
    Tentar exemplificar o pedido do cliente: Na virada do ano é preciso fazer uma rematricula, então é pensar em uma lógica para rematricula
    Segundo ele, a rematricula vai recomeçar na parte de matricula com os dados já preenchidos antes, indo para anmase com os dados também anteriomente já preenchidos, pois poucas coisas vão mudar.
    Ele disse que é importante o sistema guardar os dados ( matricula, anmese ) de por exemplo matricula 2025 e matricula 2026 referente a criança
    > **Técnico:** Etapa Difícil. Requer uma mudança na arquitetura para suportar "safras" ou "anos letivos".
    > **Dúvida:** Devemos criar uma tabela `historico_dados` para salvar o "print" de como os dados estavam no ano anterior, ou você prefere que a criança tenha múltiplas matrículas vinculadas?
    > **Resposta:**  Multiplas matriculas é melhor

9 - NA TELA DE TURMAS 
    QUANDO FOR INSERIR UMA CRIANÇA NA TELA NA TURMAS, tem o nome, idade e periodo, ele pediu para remover o periodo
    > **Técnico:** Etapa Simples. Ajuste visual na View de alocação.

10 - NA TELA DE CRIANÇAS ADICIONAR COLUNAS 
    NA LISTAGEM adicionar colunas: Contato do responsavel(com link do wa.me) e email responsável
    > **Técnico:** Etapa Simples. Formatação de string para gerar o link do WhatsApp.

11 - NA TELA DE CRIANÇAS 
    Poder exportar para PDF as crianças filtradas
    Respeitar as cores e identidade visual do projeto
    > **Técnico:** Etapa Moderada. Integrar o DomPDF com os filtros de busca da tela.

12 -  NA TELA DE EVASÃO TER FILTRO NOVO
    TER FILTRO QUE BUSCA POR PERIODO DA CRIANÇA (TODOS, MANHA, TARDE...)
    > **Técnico:** Etapa Simples. Adição de campo no formulário de busca e parâmetro na query.

13 - NA TELA DE EVASÃO
    TER UM CARD PARA ANALISAR A EVASÃO POR PERIODO EXEMPLO ( CARD DE MANHA: -----) (CARD DE TARDE: -------)
    > **Técnico:** Etapa Simples. Agregadores (count) por período no topo da página.

14 - NA TELA DE Pre inscricao ADICIONAR CAMPO
    NO CAMPO EXISTENTE DE PERIODO DA CRIANÇA ( TROCAR O LABEL PARA PERIODO ATUAL DA CRIANÇA)
    ADICIONAR CAMPO BAIXO, "PERIODO QUE DESEJA ALOCAR A CRIANÇA NA ONG" ( com texto pequeno com alert de atenção )
    > **Técnico:** Etapa Simples. Requer nova coluna no banco e ajuste no formulário público.
    > **Dúvida:** O "Período Atual" é o que ela faz na escola normal? E o "Período na ONG" é onde ela ficará no contra-turno?
    > **Resposta:** Perfeito, isso mesmo
