<?php

namespace App\Http\Controllers;

use App\Contracts\Services\MessageServiceInterface;
use App\Http\Requests\SendMessageRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class MessageController extends Controller
{
    protected string $serviceInterface = MessageServiceInterface::class;

    public function showOne($messageId)
    {
        return $this->service->showOne($messageId);
    }

    public function showAllWithUser($projectId, $userId)
    {
        $this->checkPermission($projectId);

        return $this->service->showAllWithUser($projectId, $userId);
    }

    public function showAllInProject($projectId)
    {
        $this->checkPermission($projectId);

        return $this->service->showAllInProject($projectId);
    }

    public function send(SendMessageRequest $request, $projectId, $userId)
    {
        $role = DB::table('model_has_roles')->where('model_id', $userId)->get('role_id')->first();
        $role = Role::findById($role->role_id);

        $this->checkPermission($role->name);
        $this->checkPermission('project' . $projectId);

        return $this->service->send($request, $projectId, $userId);
    }
}
