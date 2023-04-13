<div class="col-8 offset-2">
    <div class="quiz-warp">
        <label for="" id="get_quiz_{{ $quiz->id }}">{{ $quiz->quiz }}</label>
        @if ($answers->firstWhere('quiz', $quiz->id) != null)
            @if ($answers->firstWhere('quiz', $quiz->id)->answer_type == 2)
                <audio controls>
                    <source src="{{ URL::asset('answer_contents/' . $answers->firstWhere('quiz', $quiz->id)->answer) }}"
                        type="audio/mp3">
                </audio>
            @else
                <input type="text" id="old_ans_{{ $quiz->id }}" disabled class="form-control"
                    value="{{ $answers->firstWhere('quiz', $quiz->id)->answer }}">
            @endif
        @endif
        @if ($canEdit)
            <button class="btn btn-danger no-shadow me-2" type="button" id="voice_rec_{{ $quiz->id }}"
                onclick="record({{ $quiz->id }})"><i class="bi bi-mic-fill">Voice Answer</i></button>
            <button class="btn btn-primary " type="button" data-bs-toggle="collapse"
                data-bs-target="#collapse_{{ $quiz->id }}" aria-expanded="false"
                aria-controls="collapse_{{ $quiz->id }}">
                <i class="bi bi-textarea-t"></i> Text
                Answer
            </button>

            <div class="collapse" id="collapse_{{ $quiz->id }}">
                <div class="card card-body x p-0">
                    <form action="{{ route('saveAnswer') }}" method="POST" class="mb-0 mt-2" id="form_id">
                        @csrf
                        <div class="quiz-model-warp">
                            <input type="hidden" name="quiz" id="quiz_no" value="{{ $quiz->id }}">
                            <input type="hidden" name="answer_type" id="answer_type" value="1">
                            <textarea type="text" class="form-control" id="answer" name="answer"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Answer</button>
                    </form>
                </div>
            </div>
        @elseif ($answers->firstWhere('quiz', $quiz->id) == null)
            <input type="text" disabled class="form-control x is-invalid" value="You haven't gave any answer">
        @endif
    </div>
</div>
