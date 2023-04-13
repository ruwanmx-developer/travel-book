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
                            @if ($quizes)
                                @foreach ($quizes as $quiz)
                                    @include('include.quiz-answer')
                                @endforeach
                            @else
                                <div class="alert alert-info mt-4">
                                    Select a member to view their answers for the survay.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    @endsection
