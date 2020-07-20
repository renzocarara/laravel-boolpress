@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1>{{ __('messages.account_title') }}</h1>
            <div class="card">
                <div class="card-header">{{ __('messages.account_subtitle', ['name' => Auth::user()->name]) }}</div>

                <div class="card-body">
                    <h2>{{ __('messages.account_details_title')}}</h2>
                    <ul>
                        {{-- NOTA: posso anche sfruttare direttamente la relazione e scrivere, --}}
                        {{-- anzichè: $user_details->firstname --}}
                        {{-- così: Auth::user()->userDetail->firstname --}}
                        <li>{{ __('messages.firstname') }}: {{ $user_details->firstname }}</li>
                        <li>{{ __('messages.lastname') }}: {{ $user_details->lastname }}</li>
                        {{-- visualizzo il API token, se esiste --}}
                        <li>API token: {{ Auth::user()->api_token ?? '-'}}</li>
                    </ul>
                     {{-- questo pulsante mim serve per generare un API token per l'utente --}}
                     {{-- utilizzando il quale può accedere con successo alle chiamate API --}}
                    <form action="{{ route('admin.token') }}" method="post">
                        @csrf
                        <input class="btn btn-primary" type="submit" value="Richiedi api_token">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
