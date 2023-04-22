@extends('layouts.app')
@section('body')

    <body id="new-post">
    @endsection
    @include('include.navbar')
    @section('content')
        <div class="container">

            <div class="row">
                <div class="col-8 offset-2">
                    <div class="new-post-card mt-5">
                        <div class="form-title">Add New Post</div>
                        <button type="button" class="btn btn-primary" id="liveToastBtn">Show live toast</button>

                        <div class="toast-container position-fixed bottom-0 end-0 p-3">
                            <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                                <div class="toast-header">
                                    <img src="..." class="rounded me-2" alt="...">
                                    <strong class="me-auto">Bootstrap</strong>
                                    <small>11 mins ago</small>
                                    <button type="button" class="btn-close" data-bs-dismiss="toast"
                                        aria-label="Close"></button>
                                </div>
                                <div class="toast-body">
                                    Hello, world! This is a toast message.
                                </div>
                            </div>
                        </div>

                        @if ($state)
                            <div class="alert alert-danger mt-3" role="alert">
                                You have to answer the survay questions first to add new posts.
                            </div>
                        @else
                            <form method="POST" class="mb-0" action="{{ route('savePost') }}"
                                enctype='multipart/form-data'>
                                @csrf
                                <div class="mb-3">
                                    <label for="description" class="form-label">Enter Description</label>
                                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description"
                                        placeholder="Enter your experience..."></textarea>
                                    @error('description')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="content" class="form-label">Add Image or Video</label>
                                    <input name="content" type="file"
                                        class="form-control
                                @error('content') is-invalid @enderror"
                                        id="content" aria-label="Upload"
                                        accept="image/x-png,image/gif,image/jpeg,video/mp4">
                                    @error('content')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <label for="form-label">Select your location </label>
                                <div id="map_canvas" style="width:100%; height:300px" class="mb-3"></div>

                                <div class="row mb-3">
                                    <div class="col-6">
                                        <label for="form-label">Latitude</label>
                                        <input size="30" class="form-control" type="text" id="latbox"
                                            name="lat" required>
                                    </div>
                                    <div class="col-6">
                                        <label for="form-label">Longitude</label>
                                        <input size="30" class="form-control" type="text" id="lngbox"
                                            name="log" required>
                                    </div>
                                </div>
                                <div class="btn-wrap">
                                    <button type="submit" class="btn btn-primary">Upload</button>
                                </div>

                            </form>
                        @endif
                    </div>
                </div>


                <script type="text/javascript">
                    var map;

                    const toastTrigger = document.getElementById('liveToastBtn')
                    const toastLiveExample = document.getElementById('liveToast')

                    if (toastTrigger) {
                        const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample)
                        toastTrigger.addEventListener('click', () => {
                            toastBootstrap.show()
                        })
                    }

                    function initialize() {
                        var myLatlng = new google.maps.LatLng(6.935, 79.8439);

                        var myOptions = {
                            zoom: 8,
                            center: myLatlng,
                            mapTypeId: google.maps.MapTypeId.ROADMAP
                        }
                        map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

                        var marker = new google.maps.Marker({
                            draggable: true,
                            position: myLatlng,
                            map: map,
                            title: "Your location"
                        });

                        // google.maps.event.addListener(marker, 'click', function(overlay, point) {
                        //     document.getElementById("latbox").value = lat();
                        //     document.getElementById("lngbox").value = lng();
                        // });
                        google.maps.event.addListener(marker, 'click', function(event) {
                            document.getElementById("latbox").value = event.latLng.lat();
                            document.getElementById("lngbox").value = event.latLng.lng();
                        });
                        google.maps.event.addListener(marker, 'dragend', function(event) {
                            document.getElementById("latbox").value = this.getPosition().lat();
                            document.getElementById("lngbox").value = this.getPosition().lng();
                        });

                        google.maps.event.addListener(marker, 'click', function(event) {
                            document.getElementById("latbox").value = this.getPosition().lat();
                            document.getElementById("lngbox").value = this.getPosition().lng();
                        });
                    }
                    initialize()
                </script>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
                <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&callback=initialize"></script>
            @endsection
