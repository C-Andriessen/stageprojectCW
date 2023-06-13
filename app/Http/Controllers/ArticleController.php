<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use App\Models\User;

class ArticleController extends Controller
{

    public function index()

    {
        $tz = now();
        $articles = Article::where('start_date', '<=', $tz)
            ->where('end_date', '>', $tz)
            ->orderBy('start_date', 'DESC')
            ->paginate(9);
        return view('index', compact('articles'));
    }

    public function adminIndex()
    {
        $this->authorize('isAdmin', User::class);
        $articles = Article::orderBy('created_at', 'DESC')->paginate(10);
        return view('admin.articles.index', compact('articles'));
    }

    public function adminCreate()
    {
        $this->authorize('isAdmin', User::class);
        return view('admin.articles.create');
    }

    public function adminStore(StoreArticleRequest $request)
    {
        $articles = new Article;
        $articles->title = $request->title;
        $articles->introduction = $request->introduction;
        $articles->content = $request->content;
        $articles->start_date = $request->start_date;
        $articles->end_date = $request->end_date;
        if ($request->image)
        {
            $imageName = time() . uniqid() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $articles->image = $imageName;
        }
        $request->user()->created_articles()->save($articles);
        return redirect(route('admin.articles.index'))->with('status', __('Het artikel: "' . $articles->title . '" is toegevoegd!'));
    }
    public function adminEdit(Article $article)
    {
        $this->authorize('isAdmin', User::class);
        return view('admin.articles.edit', compact('article'));
    }

    public function adminUpdate(Article $article, UpdateArticleRequest $request)
    {
        $old_title = $article->title;
        $article->title = $request->title;
        $article->introduction = $request->introduction;
        $article->content = $request->content;
        $article->start_date = $request->start_date;
        $article->end_date = $request->end_date;
        if ($request->image)
        {
            if ($article->image)
            {
                unlink(public_path('/images/' . $article->image));
            }
            $imageName = time() . uniqid() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $article->image = $imageName;
        }
        $article->save();
        return redirect(route('admin.article.index'))->with('status', __('Het artikel: "' . $old_title . '" is bijgewerkt!'));
    }

    //user functions
    public function userIndex()
    {
        $this->authorize('createStore', Article::class);
        $articles = request()->user()->created_articles()->orderBy('created_at', 'DESC')->paginate(10);
        return view('user.articles.index', compact('articles'));
    }

    public function create()
    {
        $this->authorize('createStore', Article::class);
        return view('user.articles.create');
    }

    public function store(StoreArticleRequest $request)
    {
        $articles = new Article;
        $articles->title = $request->title;
        $articles->introduction = $request->introduction;
        $articles->content = $request->content;
        $articles->start_date = $request->start_date;
        $articles->end_date = $request->end_date;
        if ($request->image)
        {
            $imageName = time() . uniqid() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $articles->image = $imageName;
        }
        $request->user()->created_articles()->save($articles);
        return redirect(route('user.articles.index'))->with('status', __('Het artikel: "' . $articles->title . '" is toegevoegd!'));
    }
    public function edit(Article $article)
    {
        $this->authorize('editUpdate', $article);
        return view('user.articles.edit', compact('article'));
    }

    public function update(Article $article, UpdateArticleRequest $request)
    {
        $old_title = $article->title;
        $article->title = $request->title;
        $article->introduction = $request->introduction;
        $article->content = $request->content;
        $article->start_date = $request->start_date;
        $article->end_date = $request->end_date;
        if ($request->image)
        {
            if ($article->image)
            {
                unlink(public_path('/images/' . $article->image));
            }
            $imageName = time() . uniqid() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $article->image = $imageName;
        }
        $article->save();
        return redirect(route('admin.article.index'))->with('status', __('Het artikel: "' . $old_title . '" is bijgewerkt!'));
    }



    // general functions
    public function show(Article $article)
    {
        $articleLinks = Article::orderBy('start_date', 'DESC')->limit(5)->get();
        return view('articles.single', compact('article', 'articleLinks'));
    }

    public function delete(Article $article)
    {
        $this->authorize('delete', $article);
        if ($article->image)
        {
            unlink(public_path('/images/' . $article->image));
        }
        $article->delete();
        return back()->with('status', __('"' . $article->title . '" is verwijderd!'));
    }

    public function deleteImage(Article $article)
    {
        $this->authorize('delete', $article);
        unlink(public_path('/images/' . $article->image));
        $article->image = NULL;
        $article->save();
        return back()->with('status', __('De afbeelding is verwijderd.'));
    }
}
