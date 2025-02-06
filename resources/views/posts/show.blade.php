@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="mb-0">{{ $post->title }}</h1>
                        @can('update', $post)
                        <div>
                            <a href="{{ route('posts.edit', $post) }}" class="btn btn-outline-primary me-2">
                                <i class="fas fa-edit me-1"></i>Edit
                            </a>
                            <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger" 
                                    onclick="return confirm('Are you sure you want to delete this post?')">
                                    <i class="fas fa-trash-alt me-1"></i>Delete
                                </button>
                            </form>
                        </div>
                        @endcan
                    </div>

                    <div class="mb-4 text-muted">
                        <div class="d-flex align-items-center">
                            <i class="far fa-user me-2"></i>
                            <span class="me-3">{{ $post->user->name }}</span>
                            <i class="far fa-calendar-alt me-2"></i>
                            <span class="me-3">{{ $post->created_at->format('M d, Y') }}</span>
                            <i class="far fa-clock me-2"></i>
                            <span>{{ $post->created_at->format('h:i A') }}</span>
                        </div>
                    </div>

                    <div class="post-content mb-4">
                        {{ $post->content }}
                    </div>

                    <div class="text-muted small">
                        <i class="fas fa-history me-1"></i>Last updated {{ $post->updated_at->diffForHumans() }}
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('posts.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Back to Posts
                </a>
            </div>
        </div>
    </div>
</div>
@endsection 