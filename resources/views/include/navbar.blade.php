<nav class="navbar navbar-expand-md  fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand">Travel Book</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('feed') }}"><i class="bi bi-newspaper"></i> &nbsp;Feed</a>
                </li>
                @if (Auth::user()->role == 'admin')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('answers') }}"><i class="bi bi-question-circle"></i>
                            &nbsp;Survay Answers</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('quiz') }}"><i class="bi bi-question-circle"></i>
                            &nbsp;Survay</a>
                    </li>
                @endif
            </ul>
            <div class="d-flex">
                <div class="user">
                    <img src="{{ URL::asset('uploads/' . Auth::user()->image) }}" alt="">
                    {{ Auth::user()->name }}
                </div>
                <a class="btn btn-primary" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</nav>
