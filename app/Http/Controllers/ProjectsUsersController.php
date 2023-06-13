<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProjectUserRequest;
use App\Http\Requests\StoreProjectsUsersRequest;
use App\Http\Requests\UpdateProjectsUsersRequest;
use App\Models\Project;
use App\Models\ProjectsUsers;
use App\Models\Role;
use App\Models\User;

class ProjectsUsersController extends Controller
{
    public function index(Project $project)
    {
        $this->authorize('isAdmin', User::class);

        $projectUsers = ProjectsUsers::where('project_id', $project->id)->orderBy('created_at', 'DESC')->get();
        return view('admin.project.users.index', compact('project', 'projectUsers'));
    }

    public function create(Project $project)
    {
        $this->authorize('isAdmin', User::class);

        $projectUsers = ProjectsUsers::where('project_id', $project->id)->get();
        $users = User::all();
        foreach ($projectUsers as $projectUser)
        {
            $users = $users->where('id', '!=', $projectUser->user_id);
        }

        $roles = Role::all();
        return view('admin.project.users.create', compact('project', 'users', 'roles'));
    }

    public function store(StoreProjectsUsersRequest $request, Project $project)
    {
        $projectUser = new ProjectsUsers;
        $projectUser->project_id = $project->id;
        $projectUser->user_id = $request->user;
        $projectUser->role_id = $request->role;

        $projectUser->save();

        return redirect(route('admin.projects.users.index', compact('project')))->with('status', __('Gebruiker is toegevoegd'));
    }

    public function destroy(ProjectsUsers $projectUser)
    {
        $this->authorize('isAdmin', User::class);
        $projectUser->delete();
        return redirect(route('admin.projects.users.edit'))->with('status', __('"' . $projectUser->user->name . '" is verwijderd van het project'));
    }

    public function edit(ProjectsUsers $projectUser)
    {
        $this->authorize('isAdmin', User::class);
        $project = $projectUser->project;
        $roles = Role::all();
        return view('admin.project.users.edit', compact('projectUser', 'project', 'roles'));
    }

    public function update(UpdateProjectsUsersRequest $request, ProjectsUsers $projectUser)
    {
        $projectUser->role_id = $request->role;
        $projectUser->save();

        $project = $projectUser->project;

        return redirect(route('admin.projects.users.index', compact('project')))->with('status', __('"' . $projectUser->user->name . '" is bijgewerkt'));
    }
}
