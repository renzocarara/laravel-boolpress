@extends('layouts.public')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="mt-5 text-center">
                <h1>{{ __('email.thank_you_title') }}</h1>
                <p>{{ __('email.thank_you_answer') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
