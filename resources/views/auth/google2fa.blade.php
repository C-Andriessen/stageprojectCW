@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <h1 class="mb-3">Twee staps verificatie</h1>
                <div class="card">
                    <div class="card-body">
                        <p>
                            Tweefactorauthenticatie (2FA) versterkt de toegangsbeveiliging door twee methoden (ook wel factoren genoemd)
                            te vereisen om uw identiteit te verifiëren. Tweefactorauthenticatie beschermt tegen phishing,
                            social engineering en brute force-aanvallen met wachtwoorden en beveiligt uw aanmeldingen
                            tegen aanvallers die misbruik maken van zwakke of gestolen inloggegevens.
                        </p>
                        <p>Voer de pincode van Google Authenticator in Schakel 2FA in</p>
                        <form action="{{ route('2fa.verify') }}" method="POST">
                            @csrf
                                    <label for="message" class="form-label">Eenmalig wachtwoord</label>
    
                                        <input id="message" type="text" class="form-control mb-3 @error('message') is-invalid @enderror" name="one_time_password">
    
                                        @error('message')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <button class="btn btn-success float-end mb-3" type="submit">Authenticate</button>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
