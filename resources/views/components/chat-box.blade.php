<div class="chat-box-container">
    <div class="chat-box-header">
        <h3>AI Assistant</h3>
        <button class="minimize-button" id="minimizeButton">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
        </button>
    </div>
    <div class="chat-messages" id="chatMessages">
        <div class="message ai">
            Hello! I'm your EduInsight assistant. How can I help you today?
        </div>
        <div class="suggested-questions">
            <button class="suggested-question" onclick="askQuestion('How do I check my grades?')">How do I check my grades?</button>
            <button class="suggested-question" onclick="askQuestion('What are the available courses?')">What are the available courses?</button>
            <button class="suggested-question" onclick="askQuestion('How can I pay my fees?')">How can I pay my fees?</button>
            <button class="suggested-question" onclick="askQuestion('What is the admission process?')">What is the admission process?</button>
        </div>
    </div>
    <div class="chat-input-container">
        <form id="chatForm" class="chat-form">
            <input type="text" id="messageInput" placeholder="Type your message..." class="chat-input" autocomplete="off">
            <button type="submit" class="send-button" id="sendButton">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="22" y1="2" x2="11" y2="13"></line>
                    <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                </svg>
            </button>
        </form>
    </div>
</div>

<style>
.chat-box-container {
    position: fixed;
    bottom: 20px;
    right: 20px;
    width: 350px;
    height: 500px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    transition: transform 0.3s ease;
    z-index: 1000;
}

.chat-box-container.minimized {
    transform: translateY(calc(100% - 50px));
}

.chat-box-header {
    padding: 15px;
    background: #4a90e2;
    color: white;
    display: flex;
    justify-content: space-between;
    align-items: center;
    cursor: pointer;
}

.chat-box-header h3 {
    margin: 0;
    font-size: 1.1rem;
}

.minimize-button {
    background: none;
    border: none;
    color: white;
    cursor: pointer;
    padding: 5px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.chat-messages {
    flex: 1;
    padding: 15px;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.chat-input-container {
    padding: 15px;
    border-top: 1px solid #eee;
}

.chat-form {
    display: flex;
    gap: 10px;
}

.chat-input {
    flex: 1;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 20px;
    outline: none;
    transition: border-color 0.3s;
}

.chat-input:focus {
    border-color: #4a90e2;
}

.send-button {
    background: #4a90e2;
    border: none;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    color: white;
    transition: background 0.3s;
}

.send-button:hover {
    background: #357abd;
}

.send-button:disabled {
    background: #ccc;
    cursor: not-allowed;
}

.message {
    margin-bottom: 5px;
    max-width: 80%;
    padding: 10px 15px;
    border-radius: 15px;
    position: relative;
    word-wrap: break-word;
}

.message.user {
    margin-left: auto;
    background: #4a90e2;
    color: white;
    border-radius: 15px 15px 0 15px;
}

.message.ai {
    background: #f0f0f0;
    border-radius: 15px 15px 15px 0;
}

.typing-indicator {
    display: flex;
    gap: 5px;
    padding: 10px 15px;
    background: #f0f0f0;
    border-radius: 15px 15px 15px 0;
    width: fit-content;
}

.typing-indicator span {
    width: 8px;
    height: 8px;
    background: #666;
    border-radius: 50%;
    animation: typing 1s infinite ease-in-out;
}

.typing-indicator span:nth-child(2) {
    animation-delay: 0.2s;
}

.typing-indicator span:nth-child(3) {
    animation-delay: 0.4s;
}

@keyframes typing {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-5px); }
}

.error-message {
    background: #ffebee;
    color: #c62828;
    padding: 10px 15px;
    border-radius: 15px;
    margin: 10px 0;
    text-align: center;
}

.suggested-questions {
    display: flex;
    flex-direction: column;
    gap: 8px;
    margin: 10px 0;
}

.suggested-question {
    background: #f0f0f0;
    border: none;
    border-radius: 15px;
    padding: 8px 15px;
    text-align: left;
    cursor: pointer;
    transition: background 0.3s;
    font-size: 0.9rem;
    color: #333;
}

.suggested-question:hover {
    background: #e0e0e0;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatForm = document.getElementById('chatForm');
    const messageInput = document.getElementById('messageInput');
    const chatMessages = document.getElementById('chatMessages');
    const sendButton = document.getElementById('sendButton');
    const minimizeButton = document.getElementById('minimizeButton');
    const chatContainer = document.querySelector('.chat-box-container');

    // Minimize/Maximize functionality
    minimizeButton.addEventListener('click', function(e) {
        e.stopPropagation();
        chatContainer.classList.toggle('minimized');
    });

    chatContainer.querySelector('.chat-box-header').addEventListener('click', function(e) {
        if (e.target === this) {
            chatContainer.classList.remove('minimized');
        }
    });

    function addMessage(text, type) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${type}`;
        messageDiv.textContent = text;
        chatMessages.appendChild(messageDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    function addTypingIndicator() {
        const indicator = document.createElement('div');
        indicator.className = 'typing-indicator';
        indicator.innerHTML = '<span></span><span></span><span></span>';
        chatMessages.appendChild(indicator);
        chatMessages.scrollTop = chatMessages.scrollHeight;
        return indicator;
    }

    function addErrorMessage(text) {
        const errorDiv = document.createElement('div');
        errorDiv.className = 'error-message';
        errorDiv.textContent = text;
        chatMessages.appendChild(errorDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    chatForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        const message = messageInput.value.trim();
        if (!message) return;

        // Disable input and button while processing
        messageInput.disabled = true;
        sendButton.disabled = true;

        // Add user message
        addMessage(message, 'user');
        messageInput.value = '';

        // Add typing indicator
        const typingIndicator = addTypingIndicator();

        try {
            const response = await fetch('/api/chat', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ message })
            });

            const data = await response.json();

            // Remove typing indicator
            typingIndicator.remove();

            if (response.ok) {
                addMessage(data.response, 'ai');
            } else {
                addErrorMessage(data.error || 'Sorry, there was an error processing your request.');
            }
        } catch (error) {
            console.error('Error:', error);
            typingIndicator.remove();
            addErrorMessage('Sorry, there was an error processing your request.');
        } finally {
            // Re-enable input and button
            messageInput.disabled = false;
            sendButton.disabled = false;
            messageInput.focus();
        }
    });

    // Auto-focus input when chat is opened
    messageInput.addEventListener('focus', function() {
        chatContainer.classList.remove('minimized');
    });
});

function askQuestion(question) {
    const messageInput = document.getElementById('messageInput');
    messageInput.value = question;
    document.getElementById('chatForm').dispatchEvent(new Event('submit'));
}
</script> 