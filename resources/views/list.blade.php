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
    <script src="{{ asset('js/jquery.min.js') }}"></script>
</head>
<body>
    <div class="container">
        <h1>Uploaded Images</h1>

        <!-- sort files -->
        <form action="{{ route('image.list') }}" method="GET" class="mb-3">
            <div class="row">
                <div class="col-md-6">
                    <label for="sort_by" class="form-label">Sort by:</label>
                    <select name="sort_by" id="sort_by" class="form-select" onchange="this.form.submit()">
                        <option value="upload_at" {{ $sortBy === 'upload_at' ? 'selected' : '' }}>Upload Date</option>
                        <option value="name" {{ $sortBy === 'name' ? 'selected' : '' }}>Name</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="sort_order" class="form-label">Sort order:</label>
                    <select name="sort_order" id="sort_order" class="form-select" onchange="this.form.submit()">
                        <option value="desc" {{ $sortOrder === 'desc' ? 'selected' : '' }}>Descending</option>
                        <option value="asc" {{ $sortOrder === 'asc' ? 'selected' : '' }}>Ascending</option>
                    </select>
                </div>
            </div>
        </form>


        @if(count($images) > 0)
            <form action="{{ route('images.download') }}" method="post">
                <div class="row">
                    @csrf
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    @foreach($images as $image)
                        <div class="col-md-3">
                            <div class="thumbnail">
                                <input type="checkbox" class="form-check-input" name="selected_images[]" value="{{ $image->id }}">
                                <img src="{{ asset($image->path) }}" alt="{{ $image->name }}" class="img-thumbnail" onclick="openModal('{{ asset($image->path) }}')">
                                <p>{{ $image->name }}</p>
                                <p>Uploaded at:{{ $image->upload_at}}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
             
                {{ $images->links() }} 
            <!-- to download files in zip -->
                <button type="submit" class="btn btn-primary">Download Selected Images</button>
            </form>
            <a href="{{ route('image.upload') }}" class="btn btn-secondary mt-3">Upload new images</a>    

        @else
            <p>No images uploaded yet.</p>
        @endif
    </div>

    <!-- Modal for displaying full-size images -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <img src="" id="fullSizeImage" class="img-fluid mx-auto d-block" alt="Full Size Image">
                </div>
            </div>
        </div>
    </div>
</body>
<script src="{{ asset('js/app.js') }}"></script>
<script>
    function openModal(fullSizeImagePath) {
        // Set the src attribute of the modal's img element
        document.getElementById('fullSizeImage').src = fullSizeImagePath;
        // Show the modal
        $('#imageModal').modal('show');
    }

    $(".form-check-input").on('click',function(){
        $('div.alert.alert-danger').remove();
    });
</script>

</html>