@extends('layouts.app')

@section('body')

    <body id="photo">
    @endsection
    @include('include.navbar')
    @section('content')
        <div class="container p-4">
            <div id="images-wrapper">
                @foreach ($photos as $photo)
                    @include('include.photo-post')
                @endforeach
            </div>
        </div>
    @endsection
