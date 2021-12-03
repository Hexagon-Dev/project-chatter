<?php

namespace App\Http\Controllers;

use App\Models\Project;

class ChatController extends Controller
{
    public function showAllChats($id)
    {
        $project = Project::query()->findOrFail($id);
        return $project->chats()->get()->toArray();
    }
}
