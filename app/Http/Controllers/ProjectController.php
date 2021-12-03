<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

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
    public function create(Request $request)
    {
        $project = Project::query()->create($request->toArray());
        Permission::create(['name' => 'project' . $project->id]);
        return $project;
    }
}
