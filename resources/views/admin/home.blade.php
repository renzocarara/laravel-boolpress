{{-- url: 'admin'
nome route: 'admin.home'
nome view: 'home'
controller:  'HomeController' (nella cartella Controllers\Admin\)
metodo che la richiama: 'index'  --}}

{{-- Questa è la pagina principale del lato "back-office" (privato quindi) --}}

{{-- Qui ci arrivo dopo che l'utente ha esguito con successo l'autenticazione --}}
{{-- cioè ci arrivo dalla view preconfezionata di login di Laravel --}}
{{-- App\Http\Controllers\Auth\LoginController@login --}}


{{-- utilizza una barra di navigazione 'privata' ('admin-navbar') differente da quella pubblica ('public-navbar')--}}
{{-- entrmbe i file delle navbar sono sotto views/layouts/partials/ --}}

@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Pannello di amministrazione</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    Bacheca amministrazione, da qui, tu amministartore, puoi manipolare il tuo DB!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection