<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Box</title>
    <style>
        /* Reset some default styles */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        .chat-container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .chat-header {
            background-color: #007bff;
            color: #fff;
            padding: 16px;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        .chat-header h2 {
            font-size: 18px;
            font-weight: bold;
        }

        .chat-messages {
            padding: 16px;
            height: 400px;
            overflow-y: scroll;
        }

        .chat-message {
            display: flex;
            margin-bottom: 12px;
        }

        .chat-message.right {
            justify-content: flex-end;
        }

        .message-content {
            background-color: #f1f0f0;
            padding: 8px 12px;
            border-radius: 16px;
            max-width: 70%;
        }

        .chat-message.right .message-content {
            background-color: #007bff;
            color: #fff;
        }

        .chat-input {
            display: flex;
            align-items: center;
            padding: 16px;
            border-top: 1px solid #e0e0e0;
        }

        .chat-input input {
            flex-grow: 1;
            padding: 8px 12px;
            border: 1px solid #e0e0e0;
            border-radius: 20px;
            font-size: 14px;
        }

        .chat-input button {
            margin-left: 12px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 20px;
            padding: 8px 16px;
            font-size: 14px;
            cursor: pointer;
        }

        .chat-input button:hover {
            background-color: #0056b3;
        }

        @media (max-width: 600px) {
            .chat-container {
                margin: 10px;
            }

            .chat-messages {
                height: 300px;
            }

            .message-content {
                max-width: 80%;
            }
        }
    </style>
</head>
<body>
    <div class="chat-container">
        <div class="chat-header">
            <h2>Chat Box</h2>
        </div>
        <div class="chat-messages" id="chat-messages">
            @foreach ($messages as $message)
                <div class="chat-message {{ $message->from_user_id == auth()->id() ? 'right' : 'left' }}">
                    <div class="message-content" style="background-color: {{ $message->from_user_id == auth()->id() ? '#007bff' : '#f1f0f0' }}; color: {{ $message->from_user_id == auth()->id() ? '#fff' : '#333' }};">
                        {{ $message->message }}
                    </div>
                </div>
            @endforeach
        </div>
    
        <div class="chat-input">
            <form method="post" action="{{ route('messages.store') }}" id="message-form">
                @csrf
                <select name="to_user_id" class="recipient-select" required>
                    <option value="">Select Recipient</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
                <input type="text" name="message" id="message-input" placeholder="Type your message" required>
                <button id="send-button" type="submit">Send</button>
            </form>
        </div>
    </div>
    
    
    <script>
        // Simulating message reception
        function receiveMessage(message, fromUser) {
            let chatMessages = document.getElementById('chat-messages');
            let newMessage = document.createElement('div');
            let alignment = fromUser === 'You' ? 'right' : 'left';
            let bgColor = alignment === 'right' ? '#007bff' : '#f1f0f0';
            let textColor = alignment === 'right' ? '#fff' : '#333';
    
            newMessage.innerHTML = `
                <div class="chat-message ${alignment}">
                    <div class="message-content" style="background-color: ${bgColor}; color: ${textColor};">${message}</div>
                </div>
            `;
            chatMessages.appendChild(newMessage);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
    
        // Send message functionality
        document.getElementById('message-form').addEventListener('submit', function(event) {
            event.preventDefault();
            let messageInput = document.getElementById('message-input');
            let message = messageInput.value.trim();
            if (message !== '') {
                this.submit();
            } else {
                alert('Please enter a message.');
            }
        });
    </script>
</body>
</html>