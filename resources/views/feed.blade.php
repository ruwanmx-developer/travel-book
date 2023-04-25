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
                                <div class="w-100">
                                    <div class="name">
                                        {{ $member->name }}
                                    </div>
                                </div>
                                @if (Auth::user()->role == 'admin')
                                    <div id="member_active_{{ $member->id }}">
                                        @if ($member->state == '1')
                                            <i class="bi bi-eye-fill" onclick="blockUser({{ $member->id }})"></i>
                                        @else
                                            <i class="bi bi-eye-slash-fill" onclick="unblockUser({{ $member->id }})"></i>
                                        @endif
                                    </div>
                                @endif
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
                            @if ($post->block == null || $post->user->id == Auth::user()->id || Auth::user()->role == 'admin')
                                @include('include.feed-post')
                            @endif
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true"
                data-bs-autohide="false">
                <div class="toast-header">
                    <strong class="me-auto">Survay</strong>
                    <small>{{ 15 - $dtc4->days }} days to complete</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    Hello <strong>{{ Auth::user()->name }}</strong>, you have <strong>{{ 15 - $dtc4->days }}</strong> days
                    to complete the
                    survay questions on
                    the site. If you don't fill those <strong>your account will remove after {{ 15 - $dtc4->days }}
                        days</strong>.
                </div>
            </div>
        </div>

        <script>
            @if ($dtc4->days <= 15 && !$qc3 && Auth::user()->role != 'admin')
                const toastLive = document.getElementById('liveToast')
                const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLive)
                toastBootstrap.show()
            @endif

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

            function blockPost(x) {

                let cmt = document.getElementById('block_for_' + x).value;

                let wrap = document.getElementById('block_wrap_' + x);

                let formData = new FormData();
                formData.append("post", x);
                formData.append("content", cmt);

                const request = new XMLHttpRequest();
                request.onreadystatechange = function() {
                    if (request.readyState == XMLHttpRequest.DONE) {
                        var data = JSON.parse(request.response)
                        if (data.block == true) {
                            var html = '<div class="post-block" id="block_id_' + data.id + '">' +
                                '<div>' +
                                '<div>This post is blocked by Admin</div>' +
                                '<div class="reason">' + data.reason + '</div>' +
                                '<button class="btn btn-primary mt-2" onclick="unblockPost(' + data.id +
                                ')">Unblock</button>' +
                                '</div>' +
                                '</div>';
                            wrap.innerHTML = html;
                            document.getElementById('block_for_' + x).value = "";
                        }
                    }
                }
                request.open("POST", "{{ route('blockPost') }}");
                request.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'))
                request.send(formData);
            }

            function unblockPost(x) {

                let wrap = document.getElementById('block_wrap_' + x);

                let formData = new FormData();
                formData.append("post", x);

                const request = new XMLHttpRequest();
                request.onreadystatechange = function() {
                    if (request.readyState == XMLHttpRequest.DONE) {
                        var data = JSON.parse(request.response)
                        if (data.unblock == true) {
                            wrap.innerHTML = "";
                            document.getElementById('block_for_' + x).value = "";
                        }
                    }
                }
                request.open("POST", "{{ route('unblockPost') }}");
                request.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'))
                request.send(formData);
            }

            function blockUser(x) {
                let wrap = document.getElementById('member_active_' + x);
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This user won't able to login again!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, block user!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        let formData = new FormData();
                        formData.append("user_id", x);

                        const request = new XMLHttpRequest();
                        request.onreadystatechange = function() {
                            if (request.readyState == XMLHttpRequest.DONE) {
                                var data = JSON.parse(request.response)
                                if (data.block == true) {
                                    wrap.innerHTML = '<i class="bi bi-eye-slash-fill" onclick="unblockUser(' + data
                                        .user + ')"></i>';
                                }
                            }
                        }
                        request.open("POST", "{{ route('blockUser') }}");
                        request.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'))
                        request.send(formData);
                    }
                })
            }

            function unblockUser(x) {
                let wrap = document.getElementById('member_active_' + x);
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This user will able to login again!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, unblock user!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        let formData = new FormData();
                        formData.append("user_id", x);

                        const request = new XMLHttpRequest();
                        request.onreadystatechange = function() {
                            if (request.readyState == XMLHttpRequest.DONE) {
                                var data = JSON.parse(request.response)
                                if (data.unblock == true) {
                                    wrap.innerHTML =
                                        '<i class="bi bi-eye-fill" onclick="blockUser(' + data.user + ')"></i>';
                                }
                            }
                        }
                        request.open("POST", "{{ route('unblockUser') }}");
                        request.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'))
                        request.send(formData);
                    }
                })
            }
        </script>
    @endsection
