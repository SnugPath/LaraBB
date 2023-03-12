@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        {{ __('This is only available outside of the theme, so it goes to the default place') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
