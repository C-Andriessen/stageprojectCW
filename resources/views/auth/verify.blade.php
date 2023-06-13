@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verifieer je email') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        {{ __('Een verificatie email is verstuurd naar je email') }}
                    </div>
                    @endif

                    {{ __('Voor je doorgaat check je email of je een verificatie email hebt ontvangen') }}
                    {{ __('Als je geen email hebt ontvangen') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('Klik hier om een nieuwe te versturen') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection