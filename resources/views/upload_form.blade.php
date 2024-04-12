<!DOCTYPE html>
<html>
<head>
    <title>Upload Image</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center div-form">
            <div class="col-md-8">
            <h1>Upload Images here!</h1>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form action="{{ route('image.upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="images" class="form-label">Choose Images:</label>
                        <input type="file" class="form-control" id="images" name="images[]" multiple>
                    </div>
                    <button type="submit" class="btn btn-primary">Upload Image</button>
                </form>

                <a href="{{ route('image.list') }}" class="btn btn-secondary mt-3">View All Uploaded Files</a>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
