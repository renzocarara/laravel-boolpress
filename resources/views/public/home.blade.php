{{-- view pubblica principale --}}
@extends('layouts.public')

@section('content')
<div class="container">
    <div class="row">
        <div id="home-column" class="col-12 position-relative">
            <div class="overlay"></div>
            <div id="home-welcome-wrapper" class="d-flex text-white">
                <h1 class="m-auto">{{ __('messages.home_title') }}</h1>
            </div>
        </div>
    </div>
</div>
@endsection
