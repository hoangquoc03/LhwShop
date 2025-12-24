<div id="floating-buttons">
    <!-- Nút Back to Top -->
    <button id="back-to-top"
        class="mt-[200px] btn btn-primary rounded-circle shadow d-flex align-items-center justify-content-center">
        <i class="ti-angle-up"></i>
    </button>


    <!-- CHAT FLOAT BUTTON -->
    <button id="chat-toggle" class="chat-fab">
        <i class="ti-comments"></i>
    </button>

    <!-- CHAT BOX -->
    <div id="chatbox" class="chatbox">
        <div class="chatbox-header">
            💬 LW Shop – Tư vấn 24/7
            <button id="chat-close">✕</button>
        </div>

        <div id="chat-messages" class="chatbox-body">
            <div id="chat-categories" class="chat-categories" style="display:none;">

            </div>
        </div>

        <div class="chatbox-footer">
            <input id="chat-input" placeholder="Nhập tên sản phẩm hoặc nhu cầu..." />
            <button id="chat-send">Gửi</button>
        </div>
    </div>
</div>
<style>
    #floating-buttons {
        position: fixed;
        right: 20px;
        bottom: 20px;
        display: flex;
        flex-direction: column;
        gap: 14px;
        z-index: 9999;
    }

    /* Back to top */
    #back-to-top {
        width: 52px;
        height: 52px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Chat button */
    .chat-fab {
        width: 52px;
        height: 52px;
        border-radius: 50%;
        background: #25d366;
        color: #fff;
        border: none;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.25);
    }

    .chat-fab {
        position: fixed;
        bottom: 20px;
        right: 20px;
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: #1e88e5;
        color: #fff;
        border: none;
        cursor: pointer;
        box-shadow: 0 6px 18px rgba(0, 0, 0, .25);
        z-index: 9999;
        font-size: 22px;
    }

    .chatbox {
        position: fixed;
        bottom: 90px;
        right: 20px;
        width: 360px;
        max-height: 540px;
        background: #fff;
        border-radius: 14px;
        display: none;
        box-shadow: 0 10px 30px rgba(0, 0, 0, .3);
        overflow: hidden;
        z-index: 9999;
        font-family: Arial, sans-serif;
    }

    .chatbox-header {
        background: linear-gradient(135deg, #1e88e5, #1565c0);
        color: #fff;
        padding: 12px;
        font-weight: bold;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .chatbox-header button {
        background: none;
        border: none;
        color: #fff;
        font-size: 18px;
        cursor: pointer;
    }

    .chatbox-body {
        padding: 12px;
        height: 360px;
        overflow-y: auto;
        background: #f5f7fa;
    }

    .chatbox-footer {
        display: flex;
        padding: 10px;
        border-top: 1px solid #ddd;
        gap: 6px;
    }

    .chatbox-footer input {
        flex: 1;
        padding: 10px;
        border-radius: 8px;
        border: 1px solid #ccc;
    }

    .chatbox-footer button {
        background: #1e88e5;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 0 16px;
        cursor: pointer;
    }

    .msg {
        margin-bottom: 10px;
        display: flex;
    }

    .msg.user {
        justify-content: flex-end;
    }

    .msg.user .bubble {
        background: #1e88e5;
        color: #fff;
        border-radius: 16px 16px 0 16px;
    }

    .msg.bot .bubble {
        background: #fff;
        color: #333;
        border-radius: 16px 16px 16px 0;
    }

    .bubble {
        padding: 10px 12px;
        max-width: 80%;
        box-shadow: 0 2px 6px rgba(0, 0, 0, .1);
        font-size: 14px;
    }

    .chat-categories {
        text-align: center;
        margin-bottom: 12px;
    }

    .chat-categories button {
        background: #e3f2fd;
        border: 1px solid #1e88e5;
        color: #1e88e5;
        border-radius: 20px;
        padding: 6px 14px;
        margin: 4px;
        cursor: pointer;
        font-size: 13px;
    }

    .chatbox-body a {
        color: #1e88e5;
        font-weight: bold;
        text-decoration: none;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        const chatBox = document.getElementById('chatbox');
        const chatMessages = document.getElementById('chat-messages');
        const chatInput = document.getElementById('chat-input');
        const chatToggle = document.getElementById('chat-toggle');
        const chatClose = document.getElementById('chat-close');
        const chatSend = document.getElementById('chat-send');

        if (!chatBox || !chatToggle) {
            console.error(' Không tìm thấy chat DOM');
            return;
        }

        /* =====================
            UI EVENTS
        ===================== */
        chatToggle.addEventListener('click', () => {
            chatBox.style.display = 'block';

            if (!chatMessages.dataset.started) {
                send('__start__');
                chatMessages.dataset.started = '1';
            }
        });

        chatClose.addEventListener('click', () => {
            chatBox.style.display = 'none';
        });

        chatSend.addEventListener('click', sendMessage);

        chatInput.addEventListener('keydown', e => {
            if (e.key === 'Enter') sendMessage();
        });

        /* =====================
            MESSAGE FUNCTIONS
        ===================== */
        function sendMessage() {
            const msg = chatInput.value.trim();
            if (!msg) return;
            send(msg);
            chatInput.value = '';
        }

        function addMessage(type, html) {
            const div = document.createElement('div');
            div.className = `msg ${type}`;
            div.innerHTML = `<div class="bubble">${html}</div>`;
            chatMessages.appendChild(div);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        /* =====================
            CORE SEND
        ===================== */
        async function send(msg) {

            if (msg !== '__start__' && !msg.startsWith('__category__')) {
                addMessage('user', msg);
            }

            const loading = document.createElement('div');
            loading.className = 'msg bot';
            loading.innerHTML = `<div class="bubble"><i>Đang tư vấn...</i></div>`;
            chatMessages.appendChild(loading);

            try {
                const res = await fetch("{{ route('chat.ai') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document
                            .querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        message: msg
                    })
                });

                const data = await res.json();
                chatMessages.removeChild(loading);
                addMessage('bot', data.reply);

            } catch (e) {
                chatMessages.removeChild(loading);
                addMessage('bot', '<span style="color:red">❌ Lỗi kết nối</span>');
            }
        }

        /* =====================
            CLICK CATEGORY
        ===================== */
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('chat-category')) {
                send('__category__:' + e.target.dataset.id);
            }
        });

    });
</script>
