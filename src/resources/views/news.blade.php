@extends('blades.template')
@section('title', 'Новости')
@section('content')

<div class="container">
  <h3 class="display-6 pt-3">Новости</h3>

  @foreach ($posts as $post)
  <div class="bg-light mb-4 p-3">
    <div class="d-flex flex-row gap-4 justify-content-start">
    
      @if ($post->img)
        <img src="images/posts/{{ $post->img }}" alt="img" width="160" class="img-fluid h-100">
      @endif  

      <div class="w-100">
        <h3>{{ $post->name }}</h3>
        <p>{{ $post->text }}</p>
      </div>


    </div>
    <div class="d-flex flex-row justify-content-between mt-3">
      <div>
        @auth
          <form action="{{ route('posts.like', $post) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-sm {{ $post->liked ? 'btn-primary' : 'btn-outline-primary' }}">
              ♥ {{ $post->likes }}
            </button>
          </form>
        @else
          <a href="{{ route('login') }}" class="btn btn-sm btn-outline-secondary">
            ♥ {{ $post->likes }}
          </a>
        @endauth
      </div>
      <p class="text-muted">Опубликовано: {{ $post->created_at }}</p>
    </div>
  </div>
  @endforeach
</div>

@endsection