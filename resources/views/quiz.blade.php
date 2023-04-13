@extends('layouts.app')
@include('include.navbar')
@section('content')
    <div class="container">

        @if (!$canEdit)
            <div class="row">
                <div class="col-8 offset-2">
                    <div class="alert alert-danger mb-0 mt-3" role="alert">
                        <i class="bi bi-exclamation-triangle-fill"></i> You can't answer this survay. Its available to users
                        only
                        15 days withing the registration date
                    </div>

                </div>
            </div>
        @endif
        <div class="row">
            @foreach ($quizes as $quiz)
                @include('include.quiz-post')
            @endforeach
        </div>

        <script>
            var isRecording = false

            const recorder = new MicRecorder({
                bitRate: 128
            });

            function record(x) {
                if (isRecording) {
                    recorder
                        .stop()
                        .getMp3().then(([buffer, blob]) => {
                            const file = new File(buffer, 'me-at-thevoice.mp3', {
                                type: blob.type,
                                lastModified: Date.now()
                            });
                            document.getElementById('voice_rec_' + x).innerHTML =
                                '<i class="bi bi-mic-fill">Voice Answer</i>';
                            isRecording = false
                            let formData = new FormData();
                            formData.append("quiz", x);
                            formData.append("answer", file);
                            formData.append("answer_type", 2);

                            const request = new XMLHttpRequest();
                            request.onreadystatechange = function() {
                                if (request.readyState == XMLHttpRequest.DONE) {
                                    window.location.href = "{{ route('quiz') }}";
                                }
                            }
                            request.open("POST", "{{ route('saveAnswer') }}");
                            request.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'))
                            request.send(formData);

                        }).catch((e) => {
                            alert('We could not retrieve your message');
                            console.log(e);
                        });
                } else {
                    recorder.start().then(() => {
                        isRecording = true
                        document.getElementById('voice_rec_' + x).innerHTML = '<i class="bi bi-stop-circle"> Stop</i>';
                    }).catch((e) => {
                        console.error(e);
                    });
                }
            }
        </script>
    </div>
@endsection
