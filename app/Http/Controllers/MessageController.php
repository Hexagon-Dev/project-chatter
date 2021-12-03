<?php

namespace App\Http\Controllers;

use App\Contracts\Services\MessageServiceInterface;
use App\Http\Requests\SendMessageRequest;
use App\Http\Requests\ShowMessageRequest;
use App\Models\Project;

use Illuminate\Auth\Access\AuthorizationException;
use Throwable;

class MessageController extends Controller
{
    protected string $serviceInterface = MessageServiceInterface::class;

    /**
     * @throws AuthorizationException
     */
    public function showAllWithUser(ShowMessageRequest $request, $projectId, $userId)
    {
        $type = $request->validated()['chat_type'];

        /** @var Project $project */
        $project = Project::query()->findOrFail($projectId);

        $chat = $project->getChat($type, $userId);

        $this->validateAccess($request->user(), $type, $projectId);

        return $this->service->showAllWithUser($chat->id);
    }

    /**
     * @throws AuthorizationException|Throwable
     */
    public function send(SendMessageRequest $request)
    {
        $data = $request->validated();
        $user = $request->user();

        /** @var Project $project */
        $project = Project::query()->findOrFail($request->project_id);

        $data['chat_user_id'] = $data['chat_user_id'] ?? null;

        $chat = $project->getChat($data['chat_type'], $data['chat_user_id']);

        $this->validateAccess($user, $data['chat_type'], $data['project_id']);

        return $this->service->send($data['msg_content'], $chat, $user);
    }

    /**
     * @throws AuthorizationException
     */
    public function validateAccess($user, $type, $projectId): void
    {
        $this->checkPermission($type);

        if ($user->project_id != $projectId) {
            throw new AuthorizationException('You don\'t have access to this project');
        }
    }
}
