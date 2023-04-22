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
                        <a href="{{ route('answers') }}" class="no-link">
                            <div class="title">
                                Manage Questions
                            </div>
                        </a>
                        <div class="title">
                            Member List
                        </div>
                        @if (count($members) == 0)
                            <div class="alert alert-info text-center">
                                There are no members registerd in this system yet.
                            </div>
                        @endif
                        @foreach ($members as $member)
                            <a class="no-link" href="{{ route('answer', $member->id) }}">
                                <div class="member-wrap align-items-center" onclick="loadAnswers($member->id)">
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
                            </a>
                        @endforeach

                    </div>

                </div>
                <div class="col-5">
                    <div class="row justify-content-center">
                        <div class="row">
                            @if ($def)
                                @foreach ($quizes as $quiz)
                                    @include('include.quiz-answer')
                                @endforeach
                            @else
                                <div class="col-12">
                                    <div class="quiz-warp a">
                                        <label for="">Add New Question</label>
                                        <div>
                                            <form action="{{ route('addQuiz') }}" method="POST" class="mb-0">
                                                @csrf
                                                @method('PUT')
                                                <input type="text" class="form-control" name="quiz">
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </form>
                                        </div>

                                    </div>
                                </div>

                                @foreach ($quizes as $quiz)
                                    @include('include.quiz-out-answer')
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <script>
            function disableQuiz(x) {
                let formData = new FormData();
                formData.append("id", x);
                formData.append("state", 0);

                const request = new XMLHttpRequest();
                request.onreadystatechange = function() {
                    if (request.readyState == XMLHttpRequest.DONE) {
                        window.location.href = "{{ route('answers') }}";
                    }
                }
                request.open("POST", "{{ route('stateQuiz') }}");
                request.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'))
                request.send(formData);
            }

            function enableQuiz(x) {
                let formData = new FormData();
                formData.append("id", x);
                formData.append("state", 1);

                const request = new XMLHttpRequest();
                request.onreadystatechange = function() {
                    if (request.readyState == XMLHttpRequest.DONE) {
                        window.location.href = "{{ route('answers') }}";
                    }
                }
                request.open("POST", "{{ route('stateQuiz') }}");
                request.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'))
                request.send(formData);
            }

            function deleteQuiz(x) {
                let formData = new FormData();
                formData.append("id", x);

                const request = new XMLHttpRequest();
                request.onreadystatechange = function() {
                    if (request.readyState == XMLHttpRequest.DONE) {
                        window.location.href = "{{ route('answers') }}";
                    }
                }
                request.open("POST", "{{ route('deleteQuiz') }}");
                request.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'))
                request.send(formData);
            }
        </script>
    @endsection
