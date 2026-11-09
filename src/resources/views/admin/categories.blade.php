@extends('admin.layout')
@section('title', 'Категории')
@section('content')
<div class="admin-page-heading"><div><p class="admin-eyebrow">Каталог</p><h1>Категории</h1><p>Добавляйте категории и меняйте их названия.</p></div><button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#newCategory">＋ Добавить категорию</button></div>
<section class="admin-panel">
    <form class="admin-filters" method="get"><div class="search-control flex-grow-1"><svg><use href="#i-search"/></svg><input class="form-control" name="q" value="{{ request('q') }}" placeholder="Поиск категории"></div><button class="btn btn-primary">Найти</button></form>
    <div class="table-responsive"><table class="table admin-table align-middle mb-0"><thead><tr><th>ID</th><th>Название</th><th>Товаров</th><th>Действия</th></tr></thead><tbody>
    @forelse($categories as $category)
        <tr><td>#{{ $category->id_category }}</td><td><strong>{{ $category->category }}</strong></td><td>{{ $category->category_product_count }}</td><td><button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editCategory{{ $category->id_category }}">Редактировать</button></td></tr>
        <div class="modal fade" id="editCategory{{ $category->id_category }}" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><form method="post" action="{{ route('admin.categories.update', $category) }}" class="modal-content">@csrf @method('PUT')<div class="modal-header"><h5 class="modal-title">Редактировать категорию</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body"><label class="form-label">Название</label><input class="form-control" name="category" value="{{ $category->category }}" required maxlength="50"></div><div class="modal-footer"><button type="button" class="btn btn-light" data-bs-dismiss="modal">Отмена</button><button class="btn btn-primary">Сохранить</button></div></form></div></div>
    @empty<tr><td colspan="4" class="empty-state">Категории не найдены.</td></tr>@endforelse
    </tbody></table></div><div class="panel-pagination">{{ $categories->links() }}</div>
</section>
<div class="modal fade" id="newCategory" tabindex="-1"><div class="modal-dialog modal-dialog-centered"><form method="post" action="{{ route('admin.categories.store') }}" class="modal-content">@csrf<div class="modal-header"><h5 class="modal-title">Новая категория</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body"><label class="form-label">Название</label><input class="form-control" name="category" value="{{ old('category') }}" placeholder="Например, Стратегии" required maxlength="50"></div><div class="modal-footer"><button type="button" class="btn btn-light" data-bs-dismiss="modal">Отмена</button><button class="btn btn-primary">Добавить</button></div></form></div></div>
@endsection
