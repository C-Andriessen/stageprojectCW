<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Company;
use App\Models\Project;
use App\Models\ProjectsUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{

    public function home()
    {
        $tz = now();
        $projects = Project::where('start_date', '<=', $tz)
            ->where('end_date', '>', $tz)
            ->orderBy('start_date', 'DESC')
            ->paginate(9);
        return view('projects.index', compact('projects'));
    }

    public function show(Project $project)
    {
        $tz = now();
        $projectLinks = Project::where('start_date', '<=', $tz)
            ->where('end_date', '>', $tz)
            ->orderBy('start_date', 'DESC')
            ->limit(5)
            ->get();
        return view('projects.single', compact('project', 'projectLinks'));
    }

    //admin functions
    public function adminIndex()
    {
        $this->authorize('isAdmin', User::class);
        $projects = Project::orderBy('created_at', 'DESC')->paginate(10);

        return view('admin.project.index', compact('projects'));
    }

    public function create()
    {
        $this->authorize('isAdmin', User::class);
        $companies = Company::orderby('name')->get();
        return view('admin.project.create', compact('companies'));
    }

    public function store(StoreProjectRequest $request)
    {
        $project = new Project;
        $project->title = $request->title;
        $project->introduction = $request->introduction;
        $project->description = $request->description;
        if ($request->image)
        {
            $imageName = time() . uniqid() . '.' . $request->image->extension();
            $request->image->move(public_path('images/projects'), $imageName);
            $project->image = $imageName;
        }
        $project->start_date = $request->start_date;
        $project->end_date = $request->end_date;
        $project->company_id = $request->company;
        $project->employee_id = $request->employee;
        $project->save();
        return redirect(route('admin.projects.index'))->with('status', __($project->title . ' is aangemaakt'));
    }

    public function editInfo(Project $project)
    {
        $this->authorize('isAdmin', User::class);
        $companies = Company::orderby('name')->get();
        return view('admin.project.info.index', compact('project', 'companies'));
    }

    public function updateInfo(UpdateProjectRequest $request, Project $project)
    {
        $project->title = $request->title;
        $project->introduction = $request->introduction;
        $project->description = $request->description;
        if ($request->image)
        {
            if ($project->image)
            {
                unlink(public_path('/images/projects/' . $project->image));
            }
            $imageName = time() . uniqid() . '.' . $request->image->extension();
            $request->image->move(public_path('images/projects'), $imageName);
            $project->image = $imageName;
        }
        $project->start_date = $request->start_date;
        $project->end_date = $request->end_date;
        $project->company_id = $request->company;
        $project->employee_id = $request->employee;
        $project->save();
        return redirect(route('admin.projects.edit.info', compact('project')))->with('status', __('Informatie is bijgewerkt'));
    }

    public function destroy(Project $project)
    {
        $this->authorize('isAdmin', User::class);
        if ($project->image)
        {
            unlink(public_path('/images/projects' . $project->image));
        }
        $project->delete();
        return redirect(route('admin.projects.index'))->with('status', __('"' . $project->title . '" is verwijderd!'));
    }

    public function destroyImg(Project $project)
    {
        $this->authorize('isAdmin', User::class);
        unlink(public_path('/images/projects/' . $project->image));
        $project->image = NULL;
        $project->save();
        return redirect(route('admin.projects.edit.info', compact('project')))->with('status', __('De afbeelding is verwijderd.'));
    }

    public function userIndex()
    {
        $projects = ProjectsUsers::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->paginate(10);
        return view('user.projects.index', compact('projects'));
    }

    public function userShow(Project $project)
    {
        $this->authorize('show', $project);
        return view('user.projects.single', compact('project'));
    }

    public function company(Project $project)
    {
        $this->authorize('isAdmin', User::class);
        return view('admin.project.company.index', compact('project'));
    }
}
