@extends('layout.menu-consultation-patient')

@section('content')
<style>
    .chat-container {
        max-width: 700px;
        margin: 2rem auto;
        padding: 1.5rem;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        display: flex;
        flex-direction: column;
        height: 80vh;
    }

    .chat-header {
        font-size: 1.8rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 1.5rem;
        text-align: center;
    }

    .messages {
        flex-grow: 1;
        overflow-y: auto;
        padding-right: 10px;
        margin-bottom: 1rem;
    }

    .message {
        max-width: 70%;
        padding: 12px 18px;
        margin-bottom: 12px;
        border-radius: 20px;
        position: relative;
        font-size: 1rem;
        line-height: 1.3;
        word-wrap: break-word;
    }

    .message.sent {
        background-color: #27ae60;
        color: white;
        align-self: flex-end;
        border-bottom-right-radius: 4px;
    }

    .message.received {
        background-color: #ecf0f1;
        color: #2c3e50;
        align-self: flex-start;
        border-bottom-left-radius: 4px;
    }

    .message time {
        display: block;
        font-size: 0.75rem;
        color: rgba(255,255,255,0.7);
        margin-top: 6px;
        text-align: right;
    }

    .message.received time {
        color: #7f8c8d;
    }

    form.chat-form {
        display: flex;
        gap: 10px;
    }

    form.chat-form input[type="text"] {
        flex-grow: 1;
        padding: 12px 16px;
        border: 2px solid #bdc3c7;
        border-radius: 25px;
        font-size: 1rem;
        transition: border-color 0.3s;
    }

    form.chat-form input[type="text"]:focus {
        outline: none;
        border-color: #27ae60;
        box-shadow: 0 0 8px rgba(39, 174, 96, 0.5);
    }

    form.chat-form button {
        background-color: #27ae60;
        color: white;
        padding: 12px 24px;
        border: none;
        border-radius: 25px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    form.chat-form button:hover {
        background-color: #219150;
    }

    /* Scrollbar styling */
    .messages::-webkit-scrollbar {
        width: 8px;
    }
    .messages::-webkit-scrollbar-track {
        background: #f0f0f0;
        border-radius: 10px;
    }
    .messages::-webkit-scrollbar-thumb {
        background: #bdc3c7;
        border-radius: 10px;
    }
</style>

<div class="chat-container">
    <h2 class="chat-header">
        Ваш чат з лікарем: {{ $chat->doctor->fullName() ?? 'Лікар' }}
    </h2>

    <div class="messages">
        @if($chat->messages->isEmpty())
            <p style="text-align:center; color:#6b7280; font-style: italic;">Повідомлень ще немає. Почніть спілкування!</p>
        @else
            @foreach($chat->messages as $message)
                <div class="message {{ $message->sender_id === auth()->id() ? 'sent' : 'received' }}">
                    <p>{{ $message->message }}</p>
                    <time>{{ $message->created_at->format('d.m.Y H:i') }}</time>
                </div>
            @endforeach
        @endif
    </div>

    <form action="{{ route('patient.chat.send', $chat->id) }}" method="POST" class="chat-form" autocomplete="off">
        @csrf
        <input type="text" name="message" placeholder="Напишіть повідомлення..." required>
        <button type="submit">Відправити</button>
    </form>
</div>
@endsection
