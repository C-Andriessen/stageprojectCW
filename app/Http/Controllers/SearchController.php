<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Company;
use App\Models\Order;
use App\Models\Product;
use App\Models\Project;
use App\Models\ProjectsUsers;
use App\Models\Role;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function articleAdminSearch(Request $request)
    {
        $this->authorize('isAdmin', User::class);
        $articles = Article::where('title', 'LIKE', '%' . $request->search . '%')->paginate(30);
        return view('admin.articles.index', compact('articles'));
    }

    public function articleUserSearch(Request $request)
    {
        $articles = $request
            ->user()
            ->created_articles()
            ->where('title', 'LIKE', '%' . $request->search . '%')
            ->orderBy('created_at', 'DESC')
            ->paginate(30);
        return view('user.articles.index', compact('articles'));
    }

    public function projectAdminSearch(Request $request)
    {
        $this->authorize('isAdmin', User::class);
        $projects = Project::where('title', 'like', '%' . $request->search . '%')->orderBy('created_at', 'DESC')->paginate(30);

        return view('admin.project.index', compact('projects'));
    }

    public function projectUserSearch(Request $request)
    {
        $projects = ProjectsUsers::where('user_id', Auth::user()->id)->where('title', 'like', '%' . $request->search . '%')->orderBy('created_at', 'DESC')->paginate(30);
        return view('user.projects.index', compact('projects'));
    }

    public function projectAdminUserSearch(Request $request, Project $project)
    {
        $this->authorize('isAdmin', User::class);

        $projectUsers = ProjectsUsers::where('project_id', $project->id)->whereRelation('user', 'name', 'like', '%' . $request->search . '%')->orderBy('created_at', 'DESC')->paginate(30);
        return view('admin.project.users.index', compact('project', 'projectUsers'));
    }

    public function userSearch(Request $request)
    {
        $this->authorize('isAdmin', User::class);
        $users = User::where('role_id', '!=', Role::ADMIN)->where('name', 'LIKE', '%' . $request->search . '%')->paginate(30);
        return view('admin.users.index', compact('users'));
    }

    public function roleSearch(Request $request)
    {
        $this->authorize('isAdmin', User::class);
        $roles = Role::where('id', '!=', Role::ADMIN)
            ->where('id', '!=', Role::USER)
            ->where('name', 'LIKE', '%' . $request->search . '%')
            ->paginate(30);
        return view('admin.role.index', compact('roles'));
    }

    public function adminOpenTaskSearch(Project $project, Request $request)
    {
        $this->authorize('isAdmin', User::class);
        $tasks = Task::where('completed', false)->where('title', 'LIKE', '%' . $request->search . '%')->orderBy('start_date')->paginate(30);
        return view('admin.project.task.open', compact('project', 'tasks'));
    }

    public function adminCompletedTaskSearch(Project $project, Request $request)
    {
        $this->authorize('isAdmin', User::class);
        $tasks = Task::where('completed', true)->where('title', 'LIKE', '%' . $request->search . '%')->orderBy('start_date')->paginate(30);
        return view('admin.project.task.completed', compact('project', 'tasks'));
    }

    public function openTaskSearch(Request $request)
    {
        $tasks = Task::orWhereRelation('project', 'title', 'like', '%' . $request->search . '%')
            ->orWhere('title', 'LIKE', '%' . $request->search . '%')
            ->where('user_id', request()->user()->id)
            ->where('completed', false)
            ->orderBy('start_date')->paginate(30);

        return view('user.tasks.open', compact('tasks'));
    }

    public function completedTaskSearch(Request $request)
    {
        $tasks = Task::orWhereRelation('project', 'title', 'like', '%' . $request->search . '%')
            ->orWhere('title', 'LIKE', '%' . $request->search . '%')
            ->where('user_id', request()->user()->id)
            ->where('completed', true)
            ->orderBy('start_date')->paginate(10);
        return view('user.tasks.completed', compact('tasks'));
    }

    public function companySearch(Request $request)
    {
        $this->authorize('isAdmin', User::class);
        $companies = Company::where('name', 'LIKE', '%' . $request->search . '%')->orderBy('created_at', 'DESC')->paginate(30);
        return view('admin.companies.index', compact('companies'));
    }

    public function productSearch(Request $request)
    {
        $this->authorize('isAdmin', User::class);
        $products = Product::where('name', 'LIKE', '%' . $request->search . '%')->orderByDesc('created_at')->paginate(30);
        return view('admin.products.index', compact('products'));
    }
    public function orderSearch(Request $request)
    {
        $this->authorize('isAdmin', User::class);
        $orders = Order::orWhere('id', 'LIKE', '%' . $request->search . '%')->orWhere('customer_name', 'LIKE', '%' . $request->search . '%')->orderByDesc('created_at')->paginate(30);
        return view('admin.orders.index', compact('orders'));
    }

    public function categorySearch(Request $request)
    {
        $this->authorize('isAdmin', User::class);
        $categories = Category::where('name', 'LIKE', '%' . $request->search . '%')->orderByDesc('created_at')->paginate(30);
        return view('admin.category.index', compact('categories'));
    }
}
