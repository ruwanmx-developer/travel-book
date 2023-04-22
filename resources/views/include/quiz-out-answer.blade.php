<div class="col-12">
    <div class="quiz-warp a @if ($quiz->status == 0) dis @endif">
        <label for="" id="get_quiz_{{ $quiz->id }}">{{ $quiz->quiz }}</label>
        <i class="bi bi-pencil-fill" data-bs-toggle="collapse" data-bs-target="#collapse_{{ $quiz->id }}"
            aria-expanded="false" aria-controls="collapse_{{ $quiz->id }}"></i>

        @if ($quiz->status == 1)
            <i class="bi bi-eye-fill" onclick="disableQuiz({{ $quiz->id }})"></i>
        @else
            <i class="bi bi-eye-slash-fill" onclick="enableQuiz({{ $quiz->id }})"></i>
        @endif
        <i class="bi bi-trash3-fill" onclick="deleteQuiz({{ $quiz->id }})"></i>
        <div class="collapse" id="collapse_{{ $quiz->id }}">
            <div>
                <form action="{{ route('editQuiz') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="qid" value="{{ $quiz->id }}">
                    <input type="text" class="form-control" name="quiz" id="change_quiz_{{ $quiz->id }}">
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
