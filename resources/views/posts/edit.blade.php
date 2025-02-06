@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Post</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('posts.update', $post) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="post_title" class="form-label">Title</label>
                            <input type="text" class="form-control @error('post_title') is-invalid @enderror" 
                                id="post_title" name="post_title" value="{{ old('post_title', $post->post_title) }}" required>
                            @error('post_title')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Content</label>
                            <textarea class="form-control @error('content') is-invalid @enderror" 
                                id="content" name="content" rows="6" required>{{ old('content', $post->content) }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Update Post</button>
                            <a href="{{ route('posts.show', $post) }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 