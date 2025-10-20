<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TrackTrain Chat</title>
  <link rel="stylesheet" href="../css/chat.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
 
</head>
<body>

  

    <div class="phone-content">
      <div class="header">
        <a href="dashboard3.php"><i class="fas fa-arrow-left back-icon"></i></a>
        <div class="icon-title">
          <i class="fas fa-clipboard-list header-icon"></i>
          <h2>Chat com Atendente</h2>
        </div>
      </div>

      <div class="chat-container">
        <div class="chat-header">
          Chat TrackTrain
        </div>
        <div class="chat-messages" id="chatMessages">
          <div class="message received">Olá! Como posso ajudar você hoje?</div>
        </div>
        <form class="chat-input-area" id="chatForm" autocomplete="off">
          <input type="text" id="chatInput" placeholder="Digite sua mensagem..." required />
          <button type="submit">&#9658;</button>
        </form>
      </div>
    </div>
  </div>

  <script>
    document.getElementById('backBtn').addEventListener('click', () => {
      window.location.href = "dashboard3.html";
    });

    const chatForm = document.getElementById('chatForm');
    const chatInput = document.getElementById('chatInput');
    const chatMessages = document.getElementById('chatMessages');

    chatForm.addEventListener('submit', function(e) {
      e.preventDefault();
      const text = chatInput.value.trim();
      if (text) {
        const sentMsg = document.createElement('div');
        sentMsg.className = 'message sent';
        sentMsg.textContent = text;
        chatMessages.appendChild(sentMsg);

        setTimeout(() => {
          const receivedMsg = document.createElement('div');
          receivedMsg.className = 'message received';
          receivedMsg.textContent = "Um atendente já vai te atender";
          chatMessages.appendChild(receivedMsg);
          chatMessages.scrollTop = chatMessages.scrollHeight;
        }, 800);

        chatInput.value = '';
        chatMessages.scrollTop = chatMessages.scrollHeight;
      }
    });
  </script>

</body>
</html>
