@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-3">
            <x-user-menu :page="'profiel'" />
        </div>
        <div class="col-md-9">
            <h1 class="mb-4">{{ __('Profiel bewerken') }}</h1>
            @if (session('error'))
                <div class="alert alert-danger">
                    {!! session('error') !!}
                </div>
            @endif
            @if (session('success'))
                <div class="alert alert-success">
                    {!! session('success') !!}
                </div>
            @endif
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                @if(session()->get('2fa'))
                <li class="nav-item" role="presentation">
                  <button class="nav-link text-dark" id="general-tab" data-bs-toggle="tab" data-bs-target="#general-tab-pane" type="button" role="tab" aria-controls="general-tab-pane" aria-selected="true">Algemeen</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link active text-dark" id="google2fa-tab" data-bs-toggle="tab" data-bs-target="#google2fa-tab-pane" type="button" role="tab" aria-controls="google2fa-tab-pane" aria-selected="false">Google2fa</button>
                </li>
                @else
                <li class="nav-item" role="presentation">
                  <button class="nav-link active text-dark" id="general-tab" data-bs-toggle="tab" data-bs-target="#general-tab-pane" type="button" role="tab" aria-controls="general-tab-pane" aria-selected="true">Algemeen</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link text-dark" id="google2fa-tab" data-bs-toggle="tab" data-bs-target="#google2fa-tab-pane" type="button" role="tab" aria-controls="google2fa-tab-pane" aria-selected="false">Google2fa</button>
                </li>
                @endif
              </ul>
            <div class="card mb-5">

                <div class="card-body">
                    <div class="tab-content" id="myTabContent">
                        @if(session()->get('2fa'))
                        <div class="tab-pane fade" id="general-tab-pane" role="tabpanel" aria-labelledby="general-tab" tabindex="0">
                        @else
                        <div class="tab-pane fade show active" id="general-tab-pane" role="tabpanel" aria-labelledby="general-tab" tabindex="0">
                        @endif
                            <form method="POST" action="{{ route('user.profile.update', $user) }}">
                                @csrf
                                @method('put')
                                <div class="mb-3">
                                    <x-errored-label for="name" :value="__('Naam')" :field="'name'" />
                                    <input type="text" class="form-control" id="exampleFormControlInput1" name="name" autofocus value="{{ old('title') ?? $user->name }}">
                                </div>
                                <div class="mb-3">
                                    <x-errored-label for="email" :value="__('E-mailadress')" :field="'email'" />
                                    <input type="text" class="form-control" id="exampleFormControlInput1" name="email" autofocus value="{{ old('title') ?? $user->email }}">
                                </div>
        
                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('user.profile.index') }}" class=" btn btn-link text-dark text-decoration-none">Annuleren</a>
                                    <button class="btn btn-success mb-3">Bijwerken</button>
                                </div>
                            </form>
                        </div>
                        @if (session()->get('2fa'))
                            <div class="tab-pane fade show active" id="google2fa-tab-pane" role="tabpanel" aria-labelledby="google2fa-tab" tabindex="0">
                        @else
                            <div class="tab-pane fade" id="google2fa-tab-pane" role="tabpanel" aria-labelledby="google2fa-tab" tabindex="0">
                        @endif
                        <h2>Two Factor Authenticatie</h2>
                        <div class="panel-body">
                            <p>Twee-factor-authenticatie (2FA) versterkt de toegangsbeveiliging door twee methoden (ook wel factoren genoemd) te vereisen om uw identiteit te verifiëren. Tweefactorauthenticatie beschermt tegen phishing, social engineering en brute force-aanvallen met wachtwoorden en beveiligt uw aanmeldingen tegen aanvallers die zwakke of gestolen inloggegevens misbruiken.</p>

                            @if(!isset($data['user']->passwordSecurity))
                            <p>Om tweefactorauthenticatie op uw account in te schakelen, moet u de volgende stappen uitvoeren</p>
                            <strong>
                                <ol>
                                    <li>Klik op activatie knop genereren om een unieke code voor uw profiel te genereren</li>
                                    <li>Controleer de OTP van de mobiele Google Authenticator-app</li>
                                </ol>
                            </strong>
                               <form class="form-horizontal" method="POST" action="{{ route('2fa.generateSecret') }}">
                                   {{ csrf_field() }}
                                    <div class="form-group">
                                            <button type="submit" class="btn btn-success float-end">
                                                Code genereren om 2FA in te schakelen
                                            </button>
                                    </div>
                               </form>
                            @elseif(!$data['user']->passwordSecurity->google2fa_enable)

                                <strong>1. Scan de barcode met de Google Authenticator App:</strong><br/>

                               	{!! $data['google2fa_url'] !!}

                           		<br/><br/>

								<strong>2. Voer de 2FA code in om uw 2FA te activeren</strong><br/><br/>

								<form class="form-horizontal" method="POST" action="{{ route('2fa.enable') }}">
								{{ csrf_field() }}
                               	    <div class="form-group mb-3 {{ $errors->has('verify-code') ? ' has-error' : '' }}">
                                        <label for="verify-code" class="col-md-4 control-label">Authenticator Code</label>

                                            <input id="verify-code" type="password" class="form-control" name="verify-code" required>

                                            @if ($errors->has('verify-code'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('verify-code') }}</strong>
                                            </span>
                                            @endif
                               	    </div>
                                    <div class="form-group mb-2">
                                            <button type="submit" class="btn btn-success float-end">
                                                    2FA inschakelen
                                            </button>
                                    </div>
                               	</form>
                           	@elseif($data['user']->passwordSecurity->google2fa_enable)
                               <p>
                                2FA is momenteel <strong>ingeschakeld</strong> voor uw account.
                               </p>
                               @if(count($user->socialProviders) > 0)
                               <p>
                                   Wilt u uw 2FA uitschakelen? druk op "2FA uitschakelen"
                                </p>
                                @else
                                <p>
                                    Wilt u uw 2FA uitschakelen? Voer dan hieronder uw huidig wachtwoord in en druk op "2FA uitschakelen"
                                    om de 2FA weer uit te schakelen.
                                 </p>
                                @endif

                               <form class="form-horizontal" method="POST" action="{{ route('2fa.disable') }}">
                                <div class="form-group mb-3 {{ $errors->has('current-password') ? ' has-error' : '' }}">
                                    @if(count($user->socialProviders) == 0)
                                    <label for="change-password" class="col-md-4 control-label">Huidig wachtwoord</label>
                                        <input id="current-password" type="password" class="form-control" name="current-password" required>
                                        @endif

                                        @if ($errors->has('current-password'))
                                            <span class="help-block">
                                            <strong>{{ $errors->first('current-password') }}</strong>
                                        </span>
                                        @endif
                                </div>
                                        {{ csrf_field() }}
                                    <button type="submit" class="btn btn-success float-end">2FA uitschakelen</button>
                               </form>
                            @endif
                        </form>
                    </div>
                        </div>
                      </div>


                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script src="{{ asset('/js/editor.js') }}" defer></script>
@endsection