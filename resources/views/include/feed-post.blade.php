<div class="col-12" id="post_feed_{{ $post->id }}">
    <div class="feed-card pt-3">
        <div id="block_wrap_{{ $post->id }}">
            @if ($post->block != null)
                <div class="post-block" id="block_id_{{ $post->id }}">
                    <div>
                        @if (Auth::user()->role == 'admin')
                            <div>This post is blocked by Admin</div>
                            <div class="reason">{{ $post->block }}</div>

                            <button class="btn btn-primary mt-2"
                                onclick="unblockPost({{ $post->id }})">Unblock</button>
                        @else
                            <div>Your post has been blocked by Admin.<br>Only you can see this warning!</div>
                            <div class="reason">{{ $post->block }}</div>
                            <i class="bi bi-trash3-fill" onclick="deletePost({{ $post->id }})"></i>
                        @endif
                    </div>
                </div>
            @endif
        </div>
        <div class="line-1"></div>
        <div class="profile px-3">
            <div class="image d-flex align-items-center justify-content-center">
                <img src="{{ URL::asset('uploads/' . $post->user->image) }}" alt="">
            </div>
            <div class="author">
                <div>
                    <div class="profile-name">
                        posted by <span>{{ $post->user->name }}</span>
                    </div>
                    <div class="profile-time">
                        posted at {{ \Carbon\Carbon::parse($post->user->created_at)->format('Y M d h:m') }} <i
                            class="bi bi-geo-alt-fill"></i>
                    </div>
                </div>
            </div>
            <div class="right d-flex justify-content-end align-items-center" id="like_{{ $post->id }}">
                <span class="like-count">{{ $likes->firstWhere('post_id', $post->id)->likes ?? 0 }}</span>
                @if ($userLikes->firstWhere('post_id', $post->id))
                    <i onclick="toggleLike({{ $post->id }})" class="bi bi-suit-heart-fill"></i>
                @else
                    <i onclick="toggleLike({{ $post->id }})" class="bi bi-suit-heart"></i>
                @endif
            </div>
        </div>
        <div class="content">

            <div class="caption px-3">
                {{ $post->description }}
            </div>
            @if ($post->content_type === 1)
                <div class="image d-flex justify-content-center">
                    <img src="{{ URL::asset('post_contents/' . $post->content_url) }}" alt="">
                </div>
            @else
                <div class="video">
                    <video controls>
                        <source src="{{ URL::asset('post_contents/' . $post->content_url) }}" type="video/mp4">
                    </video>
                </div>
            @endif
        </div>

        <div class="accordion" id="accordion_{{ $post->id }}">
            <div class="accordion-item">
                <h2 class="accordion-header d-flex align-items-center">
                    @if (Auth::user()->role == 'admin')
                        <i class="bi bi-exclamation-octagon-fill"></i>
                    @elseif($post->user->id == Auth::user()->id)
                        <i class="bi bi-trash3-fill" onclick="deletePost({{ $post->id }})"></i>
                    @endif
                    <button class="accordion-button p-3 collapsed x" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapse_{{ $post->id }}" aria-expanded="false"
                        aria-controls="collapse_{{ $post->id }}">
                        {{ count($comments->where('post', $post->id)) }} Comments
                    </button>
                </h2>
                <div id="collapse_{{ $post->id }}" class="accordion-collapse collapse"
                    data-bs-parent="#accordion_{{ $post->id }}">
                    <div class="accordion-body p-2 py-0">
                        @if (Auth::user()->role != 'admin')
                            <div class="input-group mb-2">
                                <input type="text" id="cmt_for_{{ $post->id }}" class="form-control"
                                    placeholder="Enter your comment.." name="content">
                                <button class="btn btn-primary" onclick="addComment({{ $post->id }})">Save</button>
                            </div>
                        @else
                            <div class="input-group mb-2">
                                <input type="text" id="block_for_{{ $post->id }}" class="form-control red"
                                    placeholder="Enter the reason to block.." name="content">
                                <button class="btn btn-danger" onclick="blockPost({{ $post->id }})">Block</button>
                            </div>
                        @endif
                        <div class="cmt-box" id="comment_box_{{ $post->id }}">
                            @foreach ($comments->where('post', $post->id) as $comment)
                                @include('include.comment')
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
