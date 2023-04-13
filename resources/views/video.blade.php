@extends('layouts.app')
@include('include.navbar')
@section('content')
    <div class="container">

        <div class="row">
            @for ($i = 0; $i < 10; $i++)
                @include('include.photo-post')
            @endfor
        </div>



    </div>
@endsection
