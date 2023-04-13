<div class="photo-card">
    {{-- <div class="d-flex align-items-center">
        <div class="name">
            {{ $photo->user->name }}
        </div>
        <div class="right d-flex align-items-center justify-content-end">
            <span>20</span>&nbsp;&nbsp;<i class="bi bi-suit-heart-fill"></i>
           <i class="bi bi-suit-heart"></i>
</div>
</div> --}}
    <div class="image">
        <img src="{{ URL::asset('post_contents/' . $photo->content_url) }}" alt="">
    </div>
</div>
