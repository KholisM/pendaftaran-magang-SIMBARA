// Chatbot logic
const chatbotData = {
    questions: {
      'durasi magang': 'Program magang berlangsung selama 3-6 bulan, disesuaikan dengan kebutuhan SKS institusi pendidikan masing-masing.',
      'persyaratan': 'Persyaratan magang:\n- Mahasiswa aktif D3/D4/S1\n- Minimal semester 5\n- Melampirkan surat pengantar dari kampus\n- CV\n- Surat dari Kesbangpol',
      'proses seleksi': 'Proses seleksi terdiri dari:\n1. Seleksi administrasi\n2. Penempatan sesuai keahlian',
      'biaya': 'Program magang di Dinas Sosial Kota Bogor tidak dipungut biaya apapun.',
      'bidang magang': 'Bidang magang yang tersedia:\n- Pengembangan Aplikasi\n- Infrastruktur Jaringan\n- Keamanan Sistem\n- Manajemen Data\n- Digital Marketing',
      'sertifikat': 'Ya, peserta akan mendapatkan sertifikat resmi setelah menyelesaikan program magang.',
      'default': 'Maaf, saya tidak memahami pertanyaan Anda. Silakan pilih pertanyaan dari tombol di bawah atau ajukan pertanyaan dengan lebih spesifik.'
    }
  };
  
  function toggleChatbot() {
    const container = document.getElementById('chatbot-container');
    if (container.style.display === 'none' || container.style.display === '') {
      container.style.display = 'flex';
      // Add welcome message if chat is empty
      if (document.getElementById('chat-messages').children.length === 0) {
        addBotMessage('Halo! Saya adalah Assistant DINSOS. Ada yang bisa saya bantu tentang program magang?');
      }
    } else {
      container.style.display = 'none';
    }
  }
  
  function addMessage(message, isUser = false) {
    const chatMessages = document.getElementById('chat-messages');
    const messageDiv = document.createElement('div');
    messageDiv.className = `message ${isUser ? 'user-message' : 'bot-message'}`;
    messageDiv.textContent = message;
    chatMessages.appendChild(messageDiv);
    chatMessages.scrollTop = chatMessages.scrollHeight;
  }
  
  function addBotMessage(message) {
    addMessage(message, false);
  }
  
  function addUserMessage(message) {
    addMessage(message, true);
  }
  
  function findAnswer(question) {
    question = question.toLowerCase();
    for (const [key, value] of Object.entries(chatbotData.questions)) {
      if (question.includes(key)) {
        return value;
      }
    }
    return chatbotData.questions.default;
  }
  
  function askQuestion(question) {
    addUserMessage(question);
    setTimeout(() => {
      const answer = findAnswer(question);
      addBotMessage(answer);
    }, 500);
  }
  
  function sendMessage() {
    const input = document.getElementById('user-input');
    const message = input.value.trim();
    
    if (message) {
      addUserMessage(message);
      input.value = '';
      
      setTimeout(() => {
        const answer = findAnswer(message);
        addBotMessage(answer);
      }, 500);
    }
  }
  
  // Handle enter key in input
  document.getElementById('user-input').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
      sendMessage();
    }
  });