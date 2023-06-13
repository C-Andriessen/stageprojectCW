@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-3">
            <x-user-menu :page="'profiel'" />
        </div>
        <div class="col-md-9">
            <div class="d-flex justify-content-between flex-md-row flex-column">
                <h1 class="mb-4">{{ __('Profiel') }}</h1>
                <div>
                    <a href="{{ route('user.profile.edit', Auth::user()) }}" class="btn btn-success mb-3">Bewerken</a>
                </div>
            </div>
            <div class="card mb-5">

                <div class="card-body">
                    @if (session('status'))
                    <x-alert />
                    @endif
                    <div class="mb-3">
                        <p><strong>Naam</strong></p>
                        <p>{{ Auth::user()->name }}</p>
                    </div>
                    <div class="mb-3">
                        <p><strong>Email</strong></p>
                        <p>{{ Auth::user()->email }}</p>
                    </div>
                    <div class="mb-3">
                        <p><strong>Aantal artikelen</strong></p>
                        <a href="{{ route('user.articles.index') }}">{{ count(Auth::user()->created_articles) }} artikelen</a>
                    </div>
                    <div class="mb-3">
                        <p><strong>Rol</strong></p>
                        <p>{{ ucfirst(strtolower(Auth::user()->role->name)) }}</p>
                    </div>
                    <div class="mb-3">
                        <p><strong>2fa</strong></p>
                        @if(Auth::user()->passwordSecurity)
                        <p>{{ Auth::user()->passwordSecurity->google2fa_enable ? 'Ingeschakeld' : 'Uitgeschakeld' }}</p>
                        @else
                        <p>Niet ingesteld</p>
                        @endif
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection