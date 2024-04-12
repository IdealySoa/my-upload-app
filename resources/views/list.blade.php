<!DOCTYPE html>
<html>
<head>
    <title>Uploaded Images</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        .thumbnail {
            width: 200px; /* Set the width of each thumbnail */
            margin-bottom: 20px; /* Add margin between thumbnails */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Uploaded Images</h1>

        @if(count($images) > 0)
            <div class="row">
                @foreach($images as $image)
                    <div class="col-md-3">
                        <div class="thumbnail">
                            <img src="{{ asset($image->path) }}" alt="{{ $image->name }}" class="img-thumbnail">
                            <p>{{ $image->name }}</p>
                            <p>Uploaded at:{{ $image->upload_at}}</p>
                        </div>
                    </div>
                @endforeach
            </div>
             
            {{ $images->links() }} 
        @else
            <p>No images uploaded yet.</p>
        @endif
    </div>
</body>
</html>