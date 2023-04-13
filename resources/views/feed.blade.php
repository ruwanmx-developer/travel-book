@extends('layouts.app')

@section('body')

    <body id="feed">
    @endsection
    @include('include.navbar')
    @section('content')
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-3">

                    <div class="sticky-top left-panel">
                        @if (Auth::user()->role != 'admin')
                            <a class="btn btn-primary w-100 mb-3" href="{{ route('new-post') }}"> <i
                                    class="bi bi-cloud-plus"></i>
                                Share Your Experiences</a>
                        @else
                            <div class="title">
                                Member List
                            </div>
                        @endif
                        @if (count($members) == 0)
                            <div class="alert alert-info text-center">
                                There are no members registerd in this system yet.
                            </div>
                        @endif
                        @foreach ($members as $member)
                            <div class="member-wrap align-items-center">
                                <div class="line-1"></div>
                                <div class="image">
                                    <img src="{{ URL::asset('uploads/' . $member->image) }}" alt="">
                                </div>
                                <div>
                                    <div class="name">
                                        {{ $member->name }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
                <div class="col-5">
                    <div class="row justify-content-center">
                        @if (count($posts) == 0)
                            <div class="alert alert-info text-center mt-4">
                                There are no feed posts to show.
                            </div>
                        @endif
                        @foreach ($posts as $post)
                            @include('include.feed-post')
                        @endforeach
                    </div>
                </div>

            </div>
        </div>

        <script>
            @if (Auth::user()->role == 'admin')
                function toggleLike(x) {
                    return
                }
            @else
                function toggleLike(x) {
                    var heart = document.getElementById('like_' + x);
                    let formData = new FormData();
                    formData.append("post_id", x);

                    const request = new XMLHttpRequest();
                    request.onreadystatechange = function() {
                        if (request.readyState == XMLHttpRequest.DONE) {
                            var data = JSON.parse(request.response)
                            if (data.isLiked == 1) {
                                heart.innerHTML = '<span class="like-count">' + data.count +
                                    '</span><i onclick="toggleLike(' +
                                    x + ')" class="bi bi-suit-heart-fill"></i>'
                            } else {
                                heart.innerHTML = '<span class="like-count">' + data.count +
                                    '</span><i onclick="toggleLike(' +
                                    x + ')" class="bi bi-suit-heart"></i>'

                            }
                        }
                    }
                    request.open("POST", "{{ route('changeLike') }}");
                    request.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'))
                    request.send(formData);
                }
            @endif


            function deletePost(x) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        let formData = new FormData();
                        formData.append("post_id", x);

                        const request = new XMLHttpRequest();
                        request.onreadystatechange = function() {
                            if (request.readyState == XMLHttpRequest.DONE) {
                                var data = JSON.parse(request.response)
                                if (data.deleted == true) {
                                    $('#post_feed_' + x).fadeOut();
                                }
                            }
                        }
                        request.open("POST", "{{ route('deletePost') }}");
                        request.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'))
                        request.send(formData);
                    }
                })

            }

            function addComment(x) {

                let cmt = document.getElementById('cmt_for_' + x).value;

                let formData = new FormData();
                formData.append("post", x);
                formData.append("content", cmt);

                const request = new XMLHttpRequest();
                request.onreadystatechange = function() {
                    if (request.readyState == XMLHttpRequest.DONE) {
                        var data = JSON.parse(request.response)
                        if (data.add == true) {
                            var html = '<div class="comment d-flex ">' +
                                '<div class = "profile" > ' +
                                '<img src = "uploads/' + data.image + '"alt = "" > ' +
                                '</div>' +
                                '<div > ' +
                                '<div class = "name" >' + data.name + '</div>' +
                                '<div class = "text" >' + data.cmt + '</div>' +
                                '</div>' +
                                '</div>';
                            var pre = document.getElementById('comment_box_' + x).innerHTML;
                            document.getElementById('comment_box_' + x).innerHTML = html + pre;
                            document.getElementById('cmt_for_' + x).value = "";
                        }
                    }
                }
                request.open("POST", "{{ route('saveComment') }}");
                request.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'))
                request.send(formData);
            }
        </script>
    @endsection
