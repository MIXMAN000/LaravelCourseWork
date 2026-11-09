@extends('admin.layout')
@section('title', 'Отзывы')
@section('content')
<div class="admin-page-heading"><div><p class="admin-eyebrow">Обратная связь</p><h1>Отзывы</h1><p>Просматривайте оценки и комментарии покупателей.</p></div></div>
<section class="admin-panel"><form class="admin-filters" method="get"><div class="search-control flex-grow-1"><svg><use href="#i-search"/></svg><input class="form-control" name="q" value="{{ request('q') }}" placeholder="Поиск по тексту отзыва"></div><button class="btn btn-primary">Найти</button></form><div class="reviews-grid">
@forelse($reviews as $review)<article class="review-card"><div class="review-head"><div class="user-cell"><span>{{ mb_strtoupper(mb_substr($review->user_firstname ?: 'П',0,1)) }}</span><div><strong>{{ $review->user_firstname ? $review->user_firstname.' '.$review->user_lastname : 'Пользователь #'.$review->id_user }}</strong><small>{{ $review->user_email ?: 'Аккаунт не найден' }}</small></div></div><span class="review-id">#{{ $review->id_review }}</span></div><div class="review-stars">@for($i=1; $i<=5; $i++)<span class="{{ $i <= (int) $review->rating ? 'filled' : '' }}">★</span>@endfor</div><p>{{ $review->text }}</p></article>@empty<div class="empty-state">Отзывы не найдены.</div>@endforelse
</div><div class="panel-pagination">{{ $reviews->links() }}</div></section>
@endsection
