@extends('admin.layouts.default')
@section('title', 'LaraBB — Dashboard')
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>
                    <div class="card-body">
                        <p id="times-clicked-counter">Times clicked: :(</p>
                        <button class="btn btn-primary" id="increment-count-button">Increment</button>
                        {{ var_dump(\App\Helpers\Sidebar::render()) }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
