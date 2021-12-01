<?php

namespace App\Contracts\Services;

use App\Http\Requests\SendMessageRequest;
use App\Models\Message;

interface MessageServiceInterface
{
    /**
     * @param $messageId
     * @return Message
     */
    public function showOne($messageId): Message;

    /**
     * @param $projectId
     * @param $userId
     * @return Message
     */
    public function showAllWithUser($projectId, $userId): Message;

    /**
     * @param $projectId
     * @return Message
     */
    public function showAllInProject($projectId): Message;

    /**
     * @param SendMessageRequest $request
     * @param $projectId
     * @param $userId
     * @return Message
     */
    public function send(SendMessageRequest $request, $projectId, $userId): Message;
}
