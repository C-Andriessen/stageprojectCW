@props(['page' => NULL])
<div class="card">
    <div class="card-body">
        <div class="d-flex flex-column justify-content-start">
            <div class="{{ $page == 'gebruikers' ? 'bg-success rounded' : '' }}">
                <a href="{{ route('admin.users.index') }}" class="btn btn-link text-decoration-none {{ $page == 'gebruikers' ? 'text-light' : 'text-dark' }}">Gebruikers</a>
            </div>
            <div class="{{ $page == 'artikelen' ? 'bg-success rounded' : '' }}">
                <a href="{{ route('admin.article.index') }}" class="btn btn-link text-decoration-none {{ $page == 'artikelen' ? 'text-light' : 'text-dark' }}">Artikelen</a>
            </div>
            <div class="{{ $page == 'projecten' ? 'bg-success rounded' : '' }}">
                <a href="{{ route('admin.projects.index') }}" class="btn btn-link text-decoration-none {{ $page == 'projecten' ? 'text-light' : 'text-dark' }}">Projecten</a>
            </div>
            <div class="{{ $page == 'bedrijven' ? 'bg-success rounded' : '' }}">
                <a href="{{ route('admin.companies.index') }}" class="btn btn-link text-decoration-none {{ $page == 'bedrijven' ? 'text-light' : 'text-dark' }}">Bedrijven</a>
            </div>
            <div class="{{ $page == 'producten' ? 'bg-success rounded' : '' }}">
                <a href="{{ route('admin.products.index') }}" class="btn btn-link text-decoration-none {{ $page == 'producten' ? 'text-light' : 'text-dark' }}">Producten</a>
            </div>
            <div class="{{ $page == 'bestellingen' ? 'bg-success rounded' : '' }}">
                <a href="{{ route('admin.orders.index') }}" class="btn btn-link text-decoration-none {{ $page == 'bestellingen' ? 'text-light' : 'text-dark' }}">Bestellingen</a>
            </div>
            <div class="{{ $page == 'categorie' ? 'bg-success rounded' : '' }}">
                <a href="{{ route('admin.category.index') }}" class="btn btn-link text-decoration-none {{ $page == 'categorie' ? 'text-light' : 'text-dark' }}">Categorie</a>
            </div>
            <div class="{{ $page == 'rollen' ? 'bg-success rounded' : '' }}">
                <a href="{{ route('admin.role.index') }}" class="btn btn-link text-decoration-none {{ $page == 'rollen' ? 'text-light' : 'text-dark' }}">Rollen</a>
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