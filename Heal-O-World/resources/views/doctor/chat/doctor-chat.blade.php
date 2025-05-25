@extends('layout.menu-consultation-doctor')

@section('content')
<style>
  .chat-container {
    display: flex;
    height: calc(100vh - 100px); /* врахування хедера */
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }

  .chat-sidebar {
    width: 100%;
    background-color: #f9fafb;
    padding: 1rem;
    overflow-y: auto;
    border-right: 1px solid #e5e7eb;
  }

  .chat-card {
    display: flex;
    align-items: center;
    background: #ffffff;
    padding: 12px 16px;
    margin-bottom: 10px;
    border-radius: 10px;
    border: 1px solid #e5e7eb;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    text-decoration: none;
    color: #1f2937;
    transition: background 0.2s ease, transform 0.2s ease;
  }

  .chat-card:hover {
    background-color: #f0fdf4; /* світло-зелений */
    transform: scale(1.01);
  }

  .avatar {
    width: 40px;
    height: 40px;
    background-color: #10b981;
    color: white;
    font-weight: bold;
    font-size: 0.9rem;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 12px;
    flex-shrink: 0;
  }

  .chat-info {
    flex: 1;
    overflow: hidden;
  }

  .chat-name {
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 2px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .chat-preview {
    font-size: 0.875rem;
    color: #6b7280;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  .chat-time {
    font-size: 0.75rem;
    color: #9ca3af;
    margin-left: 8px;
    white-space: nowrap;
  }

  .chat-main {
    flex: 1;
    padding: 2rem;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    color: #6b7280;
    background-color: #ffffff;
  }
</style>

<div class="chat-container">
    <aside class="chat-sidebar">
        <h3 class="text-xl font-bold mb-4 text-gray-800">Чати з пацієнтами</h3>

        @forelse($chats as $chat)
            @php
                $patient = $chat->patient;
                $initials = strtoupper(mb_substr($patient->first_name, 0, 1) . mb_substr($patient->last_name, 0, 1));
                $lastMessage = $chat->messages->last();
            @endphp
            <a href="{{ route('chat.show', $chat->id) }}" class="chat-card">
                <div class="avatar">{{ $initials }}</div>
                <div class="chat-info">
                    <div class="chat-name">{{ $patient->first_name . $patient->last_name }}</div>
                    <div class="chat-preview">
                        {{ $lastMessage ? Str::limit($lastMessage->message, 40) : 'Немає повідомлень' }}
                    </div>
                </div>
                @if($lastMessage)
                    <div class="chat-time">{{ $lastMessage->created_at->format('H:i') }}</div>
                @endif
            </a>
        @empty
            <p class="text-gray-500">Немає активних чатів</p>
        @endforelse
    </aside>
</div>
@endsection
