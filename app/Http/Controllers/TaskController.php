<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function adminOpen(Project $project)
    {
        $this->authorize('isAdmin', User::class);
        $tasks = Task::where('completed', false)->where('project_id', $project->id)->orderBy('start_date')->paginate(10);
        return view('admin.project.task.open', compact('project', 'tasks'));
    }

    public function adminCompleted(Project $project)
    {
        $this->authorize('isAdmin', User::class);
        $tasks = Task::where('completed', true)->where('project_id', $project->id)->orderBy('start_date')->paginate(10);
        return view('admin.project.task.completed', compact('project', 'tasks'));
    }

    public function create(Project $project)
    {
        $this->authorize('isAdmin', User::class);
        $users = $project->users()->orderBy('name')->get();
        return view('admin.project.task.create', compact('project', 'users'));
    }

    public function store(StoreTaskRequest $request, Project $project)
    {
        $task = new Task;
        $task->title = $request->title;
        $task->description = $request->description;
        $task->start_date = $request->start_date;
        $task->end_date = $request->end_date;
        $task->user_id = $request->user;
        $task->project_id = $project->id;
        $task->save();
        return redirect(route('admin.projects.tasks.open', compact('project')))->with('status', __('Taak toegevoegd'));
    }

    public function edit(Project $project, Task $task)
    {
        $this->authorize('isAdmin', User::class);
        $users = $project->users()->orderBy('name')->get();
        return view('admin.project.task.edit', compact('task', 'users', 'project'));
    }

    public function update(UpdateTaskRequest $request, Project $project, Task $task)
    {
        $task->title = $request->title;
        $task->description = $request->description;
        $task->start_date = $request->start_date;
        $task->end_date = $request->end_date;
        $task->user_id = $request->user;
        $task->save();
        return redirect(route('admin.projects.tasks.open', compact('project')))->with('status', __('Taak "' . $task->title . '" bijgewerkt'));
    }

    public function destroy(Project $project, Task $task)
    {
        $this->authorize('isAdmin', User::class);
        $task->delete();
        return redirect(route('admin.projects.tasks.open', compact('project')))->with('status', __('Taak "' . $task->title . '" verwijderd'));
    }

    public function open()
    {
        $tasks = Task::where('user_id', request()->user()->id)->where('completed', false)->orderBy('start_date')->paginate(10);
        return view('user.tasks.open', compact('tasks'));
    }

    public function completed()
    {
        $tasks = Task::where('user_id', request()->user()->id)->where('completed', true)->orderBy('start_date')->paginate(10);
        return view('user.tasks.completed', compact('tasks'));
    }

    public function approve(Task $task)
    {
        $this->authorize('approve', $task);
        $task->completed = true;
        $task->save();
        return response('done');
    }

    public function unapprove(Task $task)
    {
        $this->authorize('approve', $task);
        $task->completed = false;
        $task->save();
        return redirect(route('user.tasks.completed'))->with('status', __($task->title . ' is open gezet'));
    }

    public function unapproveJs(Task $task)
    {
        $this->authorize('approve', $task);
        $task->completed = false;
        $task->save();
        return response('done');
    }

    public function show(Task $task)
    {
        $this->authorize('show', $task);
        return view('user.tasks.single', compact('task'));
    }
}
