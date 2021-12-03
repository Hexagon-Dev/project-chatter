<?php

namespace App\Services;

use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class MessageService extends UserService
{
    public function showAllWithUser($chatId): array
    {
        return Message::query()
            ->where('chat_id', $chatId)
            ->get()
            ->toArray();
    }

    /**
     * @param string $content
     * @param Chat $chat
     * @param User $user
     * @return Message|Model
     */
    public function send(string $content, Chat $chat, User $user): Message
    {
        return Message::query()->create([
            'chat_id' => $chat->id,
            'content' => $content,
            'user_id' => $user->id,
        ]);
    }
}
