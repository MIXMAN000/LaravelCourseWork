@extends('admin.layout')
@section('title', 'Новости')
@section('content')
<div class="admin-page-heading"><div><p class="admin-eyebrow">Контент</p><h1>Новости</h1><p>Создавайте публикации и редактируйте существующие.</p></div><a class="btn btn-primary btn-lg" href="{{ route('admin.posts.create') }}">＋ Добавить новость</a></div>
<section class="admin-panel"><form class="admin-filters" method="get"><div class="search-control flex-grow-1"><svg><use href="#i-search"/></svg><input class="form-control" name="q" value="{{ request('q') }}" placeholder="Поиск по заголовку или тексту"></div><button class="btn btn-primary">Найти</button></form><div class="posts-grid">
@forelse($posts as $post)<article class="post-card">@if($post->img)<img src="{{ asset('images/posts/'.$post->img) }}" alt="{{ $post->name }}">@else<div class="post-placeholder"><svg><use href="#i-news"/></svg></div>@endif<div class="post-content"><div class="post-meta"><span>{{ optional($post->created_at)->format('d.m.Y') }}</span><span>♥ {{ $post->likes }}</span></div><h2>{{ $post->name }}</h2><p>{{ str($post->text)->limit(180) }}</p><a class="btn btn-outline-primary" href="{{ route('admin.posts.edit', $post) }}">Редактировать</a></div></article>@empty<div class="empty-state">Новости не найдены.</div>@endforelse
</div><div class="panel-pagination">{{ $posts->links() }}</div></section>
@endsection
