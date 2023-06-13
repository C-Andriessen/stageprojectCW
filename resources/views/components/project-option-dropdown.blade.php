@props(['project'])

<div class="dropdown">
    <button class="btn btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        Opties
    </button>
    <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="{{ route('admin.projects.users.create', $project) }}">Gebruiker toevoegen</a></li>
        <li><a class="dropdown-item" href="{{ route('admin.projects.tasks.create', $project) }}">Taak toevoegen</a></li>
    </ul>
</div>