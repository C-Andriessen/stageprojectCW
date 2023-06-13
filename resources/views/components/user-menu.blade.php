@props(['page' => NULL])
<div class="card">
    <div class="card-body">
        <div class="d-flex flex-column justify-content-start">
            <div class="{{ $page == 'profiel' ? 'bg-success rounded' : '' }}">
                <a href="{{ route('user.profile.index', Auth::user()) }}" class="btn btn-link text-decoration-none {{ $page == 'profiel' ? 'text-light' : 'text-dark' }}">Mijn profiel</a>
            </div>
            <div class="{{ $page == 'artikelen' ? 'bg-success rounded' : '' }}">
                <a href="{{ route('user.articles.index') }}" class="btn btn-link text-decoration-none {{ $page == 'artikelen' ? 'text-light' : 'text-dark' }}">Mijn artikelen</a>
            </div>
            <div class="{{ $page == 'projecten' ? 'bg-success rounded' : '' }}">
                <a href="{{ route('user.projects.index') }}" class="btn btn-link text-decoration-none {{ $page == 'projecten' ? 'text-light' : 'text-dark' }}">Mijn projecten</a>
            </div>
            <div class="{{ $page == 'taken' ? 'bg-success rounded' : '' }}">
                <a href="{{ route('user.tasks.open') }}" class="btn btn-link text-decoration-none {{ $page == 'taken' ? 'text-light' : 'text-dark' }}">Mijn taken</a>
            </div>
            <div>
                <a class="btn btn-link text-decoration-none text-dark" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                    Uitloggen
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>