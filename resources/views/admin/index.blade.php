@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>
                    <div class="card-body">
                        <p id="times-clicked-counter">Your email is {{ $user->email }}</p>
                        <button class="btn btn-primary" id="increment-count-button"></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
