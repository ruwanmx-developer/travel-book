<div class="col-12">
    <div class="quiz-warp a">
        <label for="" id="get_quiz_{{ $quiz->id }}">{{ $quiz->quiz }}</label>
        @if ($answers->firstWhere('quiz', $quiz->id) != null)
            @if ($answers->firstWhere('quiz', $quiz->id)->answer_type == 2)
                <audio controls>
                    <source src="{{ URL::asset('answer_contents/' . $answers->firstWhere('quiz', $quiz->id)->answer) }}"
                        type="audio/mp3">
                </audio>
            @else
                <textarea type="text" id="old_ans_{{ $quiz->id }}" disabled class="form-control">{{ $answers->firstWhere('quiz', $quiz->id)->answer }}</textarea>
            @endif
        @endif
    </div>
</div>
