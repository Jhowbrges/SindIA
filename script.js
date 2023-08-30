
        const chatMessages = document.getElementById('chat-messages');
        const userInput = document.getElementById('user-input');
        const sendButton = document.getElementById('send-button');

        function appendMessage(role, content) {
            const messageDiv = document.createElement('div');
            messageDiv.className = `message ${role}`;
    
        // Formatar o conteúdo para exibir como HTML
            const formattedContent = formatTextForDisplay(content);
            messageDiv.innerHTML = formattedContent;

            chatMessages.appendChild(messageDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        async function sendMessage() {
            const userMessage = userInput.value;
            if (userMessage.trim() === '') {
                return;
            }

            appendMessage('user-message', userMessage);
            userInput.value = '';

            const response = await fetch('/api/api.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ userMessage })
            });

            const data = await response.json();
            const chatbotReply = data.reply;

            appendMessage('chatbot-message', chatbotReply);
        }
        function formatTextForDisplay(text) {
       // Dividir respostas mais longas em parágrafos
            const paragraphs = text.split('\n');
            const formattedParagraphs = paragraphs.map(paragraph => `<p>${paragraph}</p>`);

            // Combinar os parágrafos formatados
            return formattedParagraphs.join('');
        }

        sendButton.addEventListener('click', sendMessage);
        userInput.addEventListener('keydown', (event) => {
            if (event.key === 'Enter') {
                sendMessage();
            }
        });
