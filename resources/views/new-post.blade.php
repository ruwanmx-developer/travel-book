@extends('layouts.app')
@section('body')

    <body id="new-post">
    @endsection
    @include('include.navbar')
    @section('content')
        <div class="container">

            <div class="row">
                <div class="col-8 offset-2">
                    <div class="new-post-card mt-5">
                        <div class="form-title">Add New Post</div>
                        <form method="POST" class="mb-0" action="{{ route('savePost') }}" enctype='multipart/form-data'>
                            @csrf
                            <div class="mb-3">
                                <label for="description" class="form-label">Enter Description</label>
                                <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description"
                                    placeholder="Enter your experience..."></textarea>
                                @error('description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="content" class="form-label">Add Image or Video</label>
                                <input name="content" type="file"
                                    class="form-control
                                @error('content') is-invalid @enderror"
                                    id="content" aria-label="Upload" accept="image/x-png,image/gif,image/jpeg,video/mp4">
                                @error('content')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="btn-wrap">
                                <button type="submit" class="btn btn-primary">Upload</button>
                            </div>
                    </div>



                    </form>
                </div>
            </div>
        @endsection
