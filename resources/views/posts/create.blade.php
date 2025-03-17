@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Create a New Post</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title:</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">Content:</label>
            <textarea name="content" class="form-control" id="postContent" rows="4" required></textarea>
            <small id="charCount" class="text-muted">0 / 280</small>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Upload Image:</label>
            <input type="file" name="image" class="form-control">
        </div>

        <div class="mb-3">
            <label for="platform" class="form-label">Platform:</label>
            <select name="platform" class="form-control" required>
                <option value="facebook">Facebook</option>
                <option value="twitter">Twitter</option>
                <option value="instagram">Instagram</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="scheduled_at" class="form-label">Schedule Time:</label>
            <input type="datetime-local" name="scheduled_at" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Schedule Post</button>
    </form>
</div>

<script>
document.getElementById('postContent').addEventListener('input', function () {
    let charCount = this.value.length;
    document.getElementById('charCount').textContent = charCount + ' / 280';
});
</script>

@endsection
