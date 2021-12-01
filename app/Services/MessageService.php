<?php

namespace App\Services;

use App\Http\Requests\SendMessageRequest;
use App\Models\Message;
use Illuminate\Support\Collection;

class MessageService extends UserService
{
    public function showOne($messageId)
    {
        return Message::query()
            ->where('sender_id', $this->userId)
            ->orWhere('recipient_id', $this->userId)
            ->where('message_id', $messageId)
            ->firstOrFail();
    }

    public function showAllWithUser($projectId, $userId): Collection
    {
        $inputMessages = Message::query()
            ->where('project_id', $projectId)
            ->where('sender_id', $userId)
            ->where('recipient_id', $this->user->getAttribute('id'))
            ->firstOrFail();

        $outputMessages = Message::query()
            ->where('project_id', $projectId)
            ->where('sender_id', $this->user->getAttribute('id'))
            ->where('recipient_id', $userId)
            ->firstOrFail();

        $messages = Collection::make($inputMessages)->push($outputMessages);
        dd($messages);
        return $messages;
    }

    public function showAllInProject($projectId): Collection
    {
        $inputMessages = Message::query()
            ->where('project_id', $projectId)
            ->where('sender_id', $this->userId)
            ->firstOrFail();

        $outputMessages = Message::query()
            ->where('project_id', $projectId)
            ->where('recipient_id', $this->userId)
            ->firstOrFail();

        $messages = Collection::make($inputMessages)->push($outputMessages);
        dd($messages);
        return $messages;
    }

    public function send(SendMessageRequest $request, $projectId, $userId)
    {
        $attributes = $request->validated();
        $attributes[] = ['sender_id' => $this->userId];
        $attributes[] = ['project_id' => $projectId];
        $attributes[] = ['recipient_id' => $userId];

        return Message::query()->create($attributes);
    }
}
