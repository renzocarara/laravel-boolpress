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
                        <li>{{ __('messages.firstname') }}: {{ $user_details->firstname }}</li>
                        <li>{{ __('messages.lastname') }}: {{ $user_details->lastname }}</li>
                        <li>API token: {{ Auth::user()->api_token ?? '-'}}</li>
                    </ul>
                    {{-- <form action="{{ route('admin.token') }}" method="post">
                        @csrf
                        <input class="btn btn-primary" type="submit" value="Richiedi api_token">
                    </form> --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
