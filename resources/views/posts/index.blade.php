@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Posts</h2>
                <a href="{{ route('posts.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus-circle me-1"></i>Create Post
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @foreach($posts as $post)
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="card-title mb-0">
                            <a href="{{ route('posts.show', $post) }}" class="text-decoration-none text-dark">
                                {{ $post->title }}
                            </a>
                        </h5>
                        <small class="text-muted">
                            <i class="far fa-clock me-1"></i>{{ $post->created_at->format('M d, Y') }}
                        </small>
                    </div>
                    
                    <p class="card-text text-muted mb-2">{{ Str::limit($post->content, 150) }}</p>
                    
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            <i class="far fa-user me-1"></i>{{ $post->user->name }}
                            <span class="mx-2">•</span>
                            <i class="far fa-clock me-1"></i>{{ $post->created_at->diffForHumans() }}
                        </div>
                        
                        @can('update', $post)
                        <div>
                            <a href="{{ route('posts.edit', $post) }}" class="btn btn-sm btn-outline-primary me-2">
                                <i class="fas fa-edit me-1"></i>Edit
                            </a>
                            <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" 
                                    onclick="return confirm('Are you sure you want to delete this post?')">
                                    <i class="fas fa-trash-alt me-1"></i>Delete
                                </button>
                            </form>
                        </div>
                        @endcan
                    </div>
                </div>
            </div>
            @endforeach

            <div class="d-flex justify-content-center">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
</div>
@endsection 