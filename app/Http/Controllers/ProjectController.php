<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Spatie\Permission\Models\Permission;

class ProjectController extends Controller
{
    public function showAll()
    {
        return Project::all();
    }
    public function showOne($id)
    {
        return Project::query()->where('id', $id);
    }
    public function create()
    {
        $project = Project::query()->create();
        $projectId = $project->get('id');
        Permission::create(['name' => 'project' . $projectId]);
    }
}
