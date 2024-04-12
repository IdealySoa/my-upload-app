<!DOCTYPE html>
<html>
<head>
    <title>Upload Image</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/jquery.min.js') }}"></script>
</head>
<body>
    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div>
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('image.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="images[]" multiple><br><br>
        <button type="submit">Upload Image</button>
    </form>
    <button><a href="{{route('image.list')}}" target="_self">View all uploaded files</a></button>
</body>
<script src="{{ asset('js/app.js') }}"></script>
</html>
