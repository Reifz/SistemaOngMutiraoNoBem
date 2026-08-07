# Cuidados com a LGPD no Sistema Mutirão no Bem

## Objetivo

Este documento descreve os cuidados técnicos adotados pelo sistema para proteger os dados pessoais tratados pela ONG Mutirão no Bem, especialmente dados de crianças, responsáveis e informações de saúde.

As medidas abaixo contribuem para a segurança e a prestação de contas previstas na Lei Geral de Proteção de Dados Pessoais (Lei nº 13.709/2018). Entretanto, sua existência não representa, isoladamente, uma declaração ou certificação de conformidade jurídica integral. A adequação à LGPD também depende de políticas internas, contratos, treinamento, gestão de incidentes e orientação jurídica.

## Dados tratados pelo sistema

O sistema pode tratar, entre outros:

- dados de identificação de crianças e responsáveis;
- informações de contato e endereço;
- dados escolares, familiares e socioeconômicos;
- documentos anexados, como RG, CPF, certidões e comprovantes;
- informações de saúde registradas na anamnese;
- histórico de matrícula, rematrícula, evasão e desistência;
- registros de usuários internos e suas ações no sistema.

Dados de crianças e dados de saúde exigem proteção reforçada. O acesso deve observar o melhor interesse da criança e ocorrer somente quando necessário para a atividade institucional correspondente.

## 1. Consentimento na pré-inscrição

O formulário público exige uma manifestação afirmativa do responsável antes do envio. A pessoa declara estar de acordo com o tratamento dos dados para a finalidade de pré-inscrição e continuidade do atendimento pela ONG.

No servidor, o consentimento é validado como obrigatório e aceito. Quando a pré-inscrição é registrada, o sistema armazena:

- a confirmação do consentimento (`consentimento_lgpd`);
- a data e hora da manifestação (`data_consentimento`).

Essa combinação permite demonstrar que houve uma ação afirmativa e quando ela ocorreu. O texto apresentado ao responsável limita a finalidade informada à pré-inscrição e ao contato para continuidade do processo.

## 2. Controle de acesso por função

As áreas internas exigem autenticação e verificação de e-mail. O sistema aplica controle de acesso baseado em papéis, separando funções como:

- triagem;
- matrícula;
- saúde;
- educador;
- auditor;
- administrador.

Cada área sensível possui middleware de autorização. Por exemplo, informações de saúde ficam na área destinada ao papel de saúde, relatórios de evasão ficam restritos ao auditor e documentos de matrícula são acessados pelo papel correspondente.

Contas inativas são impedidas de autenticar e também são rejeitadas pelos controles de acesso por papel e pelo middleware administrativo. Isso reduz o risco de ex-colaboradores ou usuários desativados manterem acesso por uma sessão existente.

## 3. Proteção especial dos dados de saúde

Os dados de anamnese são armazenados no campo `dados_json` utilizando o cast criptografado nativo do Laravel (`encrypted:array`). Assim, o conteúdo é cifrado antes de ser persistido no banco e decifrado apenas pela aplicação, com a chave configurada no ambiente.

Cuidados operacionais necessários:

- a `APP_KEY` deve ser forte, mantida em segredo e nunca versionada;
- cópias de segurança da chave devem ser protegidas;
- a perda da chave torna os dados criptografados irrecuperáveis;
- a troca da chave exige um procedimento controlado de rotação e recriptografia.

## 4. Armazenamento privado de documentos

Anexos pessoais são armazenados em `storage/app/private`, fora da pasta pública do site. O sistema não expõe diretamente o caminho físico do arquivo.

O download ocorre por uma rota autenticada e autorizada. O controlador:

- aceita somente tipos e campos de documentos previamente permitidos;
- verifica a existência do registro e do arquivo;
- registra o acesso no log de auditoria;
- envia cabeçalhos para impedir cache compartilhado ou persistente;
- utiliza `X-Content-Type-Options: nosniff`.

Existe ainda o comando `lgpd:migrate-private-attachments`, destinado a localizar anexos legados no armazenamento público, copiar e verificar os arquivos no armazenamento privado e remover a cópia pública quando executado com a opção apropriada.

## 5. Validação de arquivos enviados

Os documentos enviados na matrícula passam por validação de tipo e tamanho. Imagens e PDFs são limitados aos formatos previstos e ao tamanho máximo de 5 MB. Planilhas de matrícula aceitam apenas XLS ou XLSX, também com limite de 5 MB.

Essa validação reduz o risco de armazenamento de arquivos arbitrários, abuso de espaço e envio acidental de formatos não esperados. Ela não substitui antivírus ou análise antimalware quando o sistema for disponibilizado em produção.

## 6. Auditoria e rastreabilidade

O sistema mantém registros de auditoria com:

- usuário responsável;
- ação executada;
- tabela e registro afetados;
- detalhes da operação;
- data e hora.

São auditadas ações relevantes como acesso a documentos, alterações cadastrais, exportações de PDFs, mudanças de status, evasões, desistências, configurações e gerenciamento de usuários.

Os logs apoiam investigação de acessos indevidos e prestação de contas. O conteúdo dos logs deve evitar a reprodução desnecessária de dados pessoais sensíveis e seu acesso também deve ser restrito.

## 7. Autenticação e proteção de credenciais

As senhas são armazenadas por hash, nunca em texto puro. O sistema oferece recuperação de senha por token, confirmação de senha para operações sensíveis e limitação de tentativas de login.

O rate limiting considera a combinação de e-mail e endereço IP e bloqueia temporariamente tentativas excessivas. A pré-inscrição pública e o envio de links de verificação também possuem limitação de frequência.

## 8. Proteções das respostas HTTP

As respostas do sistema recebem cabeçalhos de segurança que ajudam a reduzir riscos no navegador:

- `X-Content-Type-Options: nosniff`;
- `X-Frame-Options: DENY`;
- `Referrer-Policy: strict-origin-when-cross-origin`;
- restrição de câmera, microfone e geolocalização;
- HSTS quando a requisição utiliza HTTPS.

O ambiente de produção deve obrigatoriamente usar HTTPS válido para proteger dados e credenciais durante o transporte.

## 9. Minimização e limitação de finalidade

O formulário público coleta um conjunto mais limitado de informações para a etapa de pré-inscrição. Dados documentais, socioeconômicos e de saúde são solicitados nas etapas internas correspondentes do atendimento.

O controle por papéis busca assegurar que cada profissional veja apenas as áreas necessárias para sua função. Exportações e relatórios mais abrangentes possuem restrições adicionais e registro de auditoria.

## 10. Integridade e consistência dos registros

Operações que alteram vários registros utilizam transações de banco para reduzir a possibilidade de gravações parciais. A alocação e remoção de crianças em turmas validam o vínculo, a capacidade, o status da criança e a situação da turma, mantendo também a matrícula do ano ativo sincronizada.

Turmas com crianças ou histórico de matrículas não podem ser excluídas, preservando a integridade e a rastreabilidade do histórico institucional.

## 11. Tratamento seguro de erros

Falhas internas são registradas nos logs técnicos, enquanto o usuário recebe uma mensagem genérica. Isso evita expor caminhos do servidor, consultas, estrutura do banco ou outras informações que poderiam facilitar ataques ou revelar dados pessoais.

Os arquivos de log precisam ter acesso restrito, retenção definida e monitoramento para impedir que detalhes técnicos ou pessoais permaneçam armazenados indefinidamente.

## 12. Testes de segurança existentes

O projeto possui testes automatizados para verificar, entre outros comportamentos:

- impedimento de acesso de um papel a áreas sensíveis de outro papel;
- bloqueio de usuário genérico em áreas restritas;
- exigência de papel autorizado para baixar documentos;
- registro de auditoria no download de documentos;
- cabeçalhos de não armazenamento em cache;
- impedimento de acesso administrativo por administrador inativo;
- preservação da integridade das turmas e matrículas.

## Medidas organizacionais ainda necessárias

Os seguintes pontos não estão integralmente resolvidos apenas pelo código e devem fazer parte do programa de privacidade da ONG:

- identificar e documentar o controlador, operadores e encarregado pelo tratamento;
- manter aviso de privacidade completo e acessível aos responsáveis;
- definir bases legais para cada atividade, sem depender de consentimento quando outra base for a adequada;
- documentar o tratamento de dados de crianças conforme seu melhor interesse;
- disponibilizar canal para solicitações dos titulares;
- estabelecer procedimentos de acesso, correção, portabilidade, anonimização e eliminação;
- definir prazos de retenção para cadastros, documentos, mensagens, logs e backups;
- criar política de descarte seguro e anonimização;
- estabelecer plano de resposta e comunicação de incidentes;
- controlar fornecedores de hospedagem, e-mail, backup e outros operadores por contrato;
- revisar periodicamente permissões e desligar acessos imediatamente quando necessário;
- treinar colaboradores sobre sigilo, phishing, compartilhamento e uso correto dos dados;
- avaliar antivírus ou análise antimalware para documentos enviados;
- proteger backups com criptografia, restrição de acesso e testes de restauração;
- manter o PHP, Laravel, bibliotecas e servidor atualizados.

## Checklist para produção

- [ ] HTTPS obrigatório e certificado válido.
- [ ] `APP_DEBUG=false`.
- [ ] `APP_KEY` protegida e com backup seguro.
- [ ] Credenciais fora do repositório e com rotação definida.
- [ ] Anexos legados migrados para armazenamento privado.
- [ ] Permissões de `storage` e logs restritas ao usuário do servidor.
- [ ] Backups criptografados, testados e com retenção definida.
- [ ] Contas e papéis revisados periodicamente.
- [ ] Aviso de privacidade e canal do titular publicados.
- [ ] Plano de incidentes aprovado e testado.
- [ ] Dependências e runtime atualizados e suportados.

## Referências internas da implementação

- `resources/views/pre_inscricao.blade.php`
- `app/Http/Controllers/PreInscricaoController.php`
- `app/Models/Anamnese.php`
- `app/Http/Controllers/AttachmentController.php`
- `app/Console/Commands/MigratePrivateAttachmentsCommand.php`
- `app/Http/Middleware/RoleMiddleware.php`
- `app/Http/Middleware/AdminMiddleware.php`
- `app/Http/Middleware/SecurityHeadersMiddleware.php`
- `app/Http/Requests/Auth/LoginRequest.php`
- `app/Models/LogAuditoria.php`
- `config/filesystems.php`
- `routes/web.php`
- `tests/Feature/SecurityAccessTest.php`

