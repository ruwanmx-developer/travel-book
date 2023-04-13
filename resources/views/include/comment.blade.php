<div class="comment d-flex ">
    <div class="profile">
        <img src="{{ URL::asset('uploads/' . $comment->user->image) }}" alt="">
    </div>
    <div>
        <div class="name">{{ $comment->user->name }}</div>
        <div class="text">{{ $comment->content }}</div>
    </div>
</div>
