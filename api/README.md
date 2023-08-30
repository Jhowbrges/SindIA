# Projeto de Chatbot SindIA (Síndico com IA)

Este projeto implementa um chatbot chamado SindIA que fornece informações sobre administração condominial. O chatbot é capaz de responder a perguntas relacionadas ao condomínio "Condomínio Edifício Elza Soares".

## Configuração

Antes de executar o projeto, você precisará configurar a chave de API do ChatGPT. Edite o arquivo `index.php` e atualize a variável `$api_key` com sua chave de API válida.

## Estrutura da Conversa

O chatbot utiliza uma estrutura de conversa que é montada a partir de um arquivo de texto `roles.txt`. Este arquivo contém informações sobre os papéis e conteúdo de cada mensagem. A estrutura da conversa é utilizada para definir as mensagens iniciais e suas respectivas funções.

## Funcionalidades

- **Saudação e Apresentação**: O chatbot inicia com uma mensagem de saudação e apresentação, fornecendo informações sobre o propósito do SindIA.

- **Informações do Condomínio**: O chatbot oferece informações importantes sobre o condomínio "Condomínio Edifício Elza Soares", incluindo nome, história, valores do condomínio e regras.

- **Resposta a Perguntas do Usuário**: O chatbot é capaz de responder a perguntas específicas sobre o condomínio e suas regras.

- **Busca de Informações de Convenção**: O chatbot pode buscar informações específicas de convenção a partir de palavras-chave fornecidas pelo usuário.

## Utilização

1. Configure a chave de API no arquivo `index.php`.
2. Execute o projeto em um servidor PHP.
3. Envie uma mensagem de usuário via POST para o endpoint `index.php`.
4. O chatbot responderá com informações relevantes ou buscará informações específicas de acordo com a interação do usuário.

## Autor

Nome: Jhonatan Borges
Contato: jhotimao@hotmail.com

## Licença

Este projeto está licenciado sob a Licença MIT - veja o arquivo [LICENSE](LICENSE) para detalhes.
