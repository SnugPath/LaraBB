@extends('layouts.admin')
@section('title', 'Categories')
@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-6">
                <h1>Categories</h1>
            </div>
            <div class="col-sm-6 text-end">
                <a href="" class="btn btn-primary">Create New</a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @if (count($categories) === 0)
                    <div class="center-error">
                        <p>It seems that there are no items to display</p>
                        <p>Create a new one!</p>
                    </div>
                @else
                    Exist!
                @endif
            </div>
        </div>
    </div>

@endsection
