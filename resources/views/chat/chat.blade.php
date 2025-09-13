@extends('layouts.app')

@section('title', 'المحادثة')

<style>
body {
    background: #f0f2f5;
    font-family: 'Cairo', sans-serif;
    margin: 0;
    padding: 0;
}
.chat-container {
    width: 70%;
    max-width: 900px;
    height: 80vh;
    margin: 40px auto;
    display: flex;
    flex-direction: column;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    background: #fff;
}
.chat-header {
    background: linear-gradient(135deg, #6a11cb, #2575fc);
    color: #fff;
    padding: 15px 20px;
    text-align: center;
    font-size: 22px;
    font-weight: 600;
    letter-spacing: 0.3px;
    border-bottom-left-radius: 15px;
    border-bottom-right-radius: 15px;
}
.chat-header div.title {
    font-size: 20px;
    font-weight: 700;
    margin-top: 5px;
}
.chat-header span {
    font-size: 16px;
    font-weight: 400;
    display: block;
    margin-top: 3px;
    color: #e0e0e0;
}
.chat-messages {
    flex: 1;
    padding: 20px;
    overflow-y: auto;
    background: #e5e5ea;
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.message {
    max-width: 60%;
    padding: 12px 18px;
    border-radius: 20px;
    position: relative;
    word-wrap: break-word;
    line-height: 1.4;
    box-shadow: 0 1px 4px rgba(0,0,0,0.1);
}
.message.sent {
    background: #0084ff;
    color: #fff;
    align-self: flex-end;
    border-bottom-right-radius: 4px;
}
.message.received {
    background: #f1f0f0;
    color: #050505;
    align-self: flex-start;
    border-bottom-left-radius: 4px;
}
.message small {
    display: block;
    font-size: 10px;
    margin-top: 4px;
    opacity: 0.6;
}
.chat-form {
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 12px;
    background: #fff;
    border-top: 1px solid #ddd;
    gap: 8px;
}
.chat-form input {
    flex: 1;
    max-width: 85%;
    border: none;
    padding: 12px 16px;
    border-radius: 25px;
    background: #f0f2f5;
    outline: none;
    font-size: 14px;
}
.chat-form button {
    background: #0084ff;
    color: #fff;
    border: none;
    border-radius: 50%;
    width: 45px;
    height: 45px;
    cursor: pointer;
    font-size: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>

<div class="chat-container">
    <div class="chat-header">
        💬
        <div class="title">المحادثة</div>
        <span>مع {{ $receiver->name }}</span>
    </div>

    <div id="chat-messages" class="chat-messages"></div>

    <form id="chat-form" class="chat-form">
        <input type="text" id="chat-input" placeholder="اكتب رسالة..." required>
        <button type="submit"><i class="bi bi-send"></i></button>
    </form>
</div>

<input type="hidden" id="receiver_id" value="{{ $receiver->id }}">
<script>
document.addEventListener('DOMContentLoaded', function() {

    const authId = {{ Auth::id() }};
    const receiverId = document.getElementById('receiver_id').value;
    const chatMessages = document.getElementById('chat-messages');
    const chatForm = document.getElementById('chat-form');
    const chatInput = document.getElementById('chat-input');

    function appendMessage(msg, isSender) {
        const div = document.createElement('div');
        div.classList.add('message', isSender ? 'sent' : 'received');
        div.dataset.id = msg.id;
        div.innerHTML = `
            ${msg.message}
            <small>${msg.created_at}</small>
            ${isSender ? `
            <div class="actions">
                <button onclick="editMessage(${msg.id}, '${msg.message}')">✏️</button>
                <button onclick="deleteMessage(${msg.id})">🗑️</button>
            </div>` : ''}
        `;
        chatMessages.appendChild(div);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    async function fetchMessages() {
        try {
            let res = await fetch(`/chat/messages/${receiverId}`);
            let data = await res.json();
            chatMessages.innerHTML = '';
            data.forEach(msg => appendMessage(msg, msg.sender_id == authId));
        } catch(err) {
            console.error(err);
        }
    }

    chatForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        let text = chatInput.value.trim();
        if (!text) return;

        try {
            let res = await fetch(`/chat/send`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ receiver_id: receiverId, message: text })
            });

            if (!res.ok) {
                let errorText = await res.text();
                console.error("Server Error:", errorText);
                return;
            }

            let msg = await res.json();
            appendMessage(msg, true);
            chatInput.value = '';
        } catch (err) {
            console.error(err);
        }
    });

    window.editMessage = async function(id, oldText) {
        let newText = prompt("✏️ عدل رسالتك:", oldText);
        if(newText && newText !== oldText) {
            try {
                let res = await fetch(`/chat/update/${id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ message: newText })
                });
                if(res.ok) {
                    let msgDiv = document.querySelector(`.message[data-id="${id}"]`);
                    msgDiv.querySelector('small').innerText = 'تم التعديل';
                    msgDiv.childNodes[0].textContent = newText;
                }
            } catch(err) {
                console.error(err);
            }
        }
    };

    window.deleteMessage = async function(id) {
        if(confirm("🗑️ هل أنت متأكد من الحذف؟")) {
            try {
                let res = await fetch(`/chat/delete/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                if(res.ok) {
                    document.querySelector(`.message[data-id="${id}"]`).remove();
                }
            } catch(err) {
                console.error(err);
            }
        }
    };

    fetchMessages();
    setInterval(fetchMessages, 5000);

});
</script>
