<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Post;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminController extends Controller
{
    private const ORDER_STATUSES = ['Новый заказ', 'В работе', 'Доставлен', 'Отменен'];

    public function dashboard(): View
    {
        return view('admin.dashboard', [
            'stats' => [
                'products' => Product::count(),
                'categories' => Category::count(),
                'orders' => Order::count(),
                'users' => User::count(),
                'reviews' => Review::count(),
                'posts' => Post::count(),
            ],
            'orderStats' => collect(self::ORDER_STATUSES)->mapWithKeys(
                fn (string $status) => [$status => Order::where('status', $status)->count()]
            ),
            'recentOrders' => Order::with('orderUser')->latest()->limit(6)->get(),
        ]);
    }

    public function products(Request $request): View
    {
        $products = Product::with('ProductCategory')
            ->when($request->filled('q'), fn ($query) => $query->where('name_product', 'like', '%'.$request->q.'%'))
            ->when($request->filled('category'), fn ($query) => $query->where('id_category', $request->category))
            ->orderBy('id_product', 'desc')
            ->paginate(12)
            ->withQueryString();

        return view('admin.products.index', [
            'products' => $products,
            'categories' => Category::orderBy('category')->get(),
        ]);
    }

    public function createProduct(): View
    {
        return view('admin.products.form', [
            'product' => new Product(),
            'categories' => Category::orderBy('category')->get(),
        ]);
    }

    public function storeProduct(Request $request): RedirectResponse
    {
        $data = $this->validateProduct($request, true);
        $images = $this->saveProductImages($request);
        $data = array_merge($data, $images);
        $data['img2'] ??= $data['img1'];
        $data['img3'] ??= $data['img1'];
        $data['id_product'] = (int) Product::max('id_product') + 1;

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Товар добавлен.');
    }

    public function editProduct(Product $product): View
    {
        return view('admin.products.form', [
            'product' => $product,
            'categories' => Category::orderBy('category')->get(),
        ]);
    }

    public function updateProduct(Request $request, Product $product): RedirectResponse
    {
        $data = array_merge($this->validateProduct($request), $this->saveProductImages($request));
        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Карточка товара обновлена.');
    }

    public function categories(Request $request): View
    {
        return view('admin.categories', [
            'categories' => Category::withCount('CategoryProduct')
                ->when($request->filled('q'), fn ($query) => $query->where('category', 'like', '%'.$request->q.'%'))
                ->orderBy('category')
                ->paginate(15)
                ->withQueryString(),
        ]);
    }

    public function storeCategory(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'category' => ['required', 'string', 'max:50', Rule::unique('categories', 'category')],
        ]);
        $data['id_category'] = (int) Category::max('id_category') + 1;
        Category::create($data);

        return back()->with('success', 'Категория добавлена.');
    }

    public function updateCategory(Request $request, Category $category): RedirectResponse
    {
        $category->update($request->validate([
            'category' => ['required', 'string', 'max:50', Rule::unique('categories', 'category')->ignore($category->id_category, 'id_category')],
        ]));

        return back()->with('success', 'Категория обновлена.');
    }

    public function orders(Request $request): View
    {
        $orders = Order::with(['orderUser', 'items.product'])
            ->when($request->filled('q'), function ($query) use ($request) {
                $term = $request->q;
                $query->where(function ($nested) use ($term) {
                    $nested->where('id', $term)
                        ->orWhereHas('orderUser', fn ($users) => $users
                            ->where('firstname', 'like', '%'.$term.'%')
                            ->orWhere('lastname', 'like', '%'.$term.'%')
                            ->orWhere('email', 'like', '%'.$term.'%'));
                });
            })
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->status))
            ->when($request->filled('payment'), fn ($query) => $query->where('payment_type', $request->payment))
            ->when($request->filled('date_from'), fn ($query) => $query->whereDate('created_at', '>=', $request->date_from))
            ->when($request->filled('date_to'), fn ($query) => $query->whereDate('created_at', '<=', $request->date_to))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.orders.index', [
            'orders' => $orders,
            'statuses' => self::ORDER_STATUSES,
            'paymentTypes' => Order::query()->whereNotNull('payment_type')->distinct()->pluck('payment_type'),
            'orderStats' => collect(self::ORDER_STATUSES)->mapWithKeys(
                fn (string $status) => [$status => Order::where('status', $status)->count()]
            ),
        ]);
    }

    public function showOrder(Order $order): View
    {
        $order->load(['orderUser', 'items.product']);

        return view('admin.orders.show', [
            'order' => $order,
            'statuses' => self::ORDER_STATUSES,
        ]);
    }

    public function updateOrderStatus(Request $request, Order $order): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(self::ORDER_STATUSES)],
            'cancellation_reason' => ['nullable', 'string', 'max:255'],
        ]);

        if ($data['status'] !== 'Отменен') {
            $data['cancellation_reason'] = null;
        }

        $order->update($data);

        return back()->with('success', 'Статус заказа обновлён.');
    }

    public function users(Request $request): View
    {
        return view('admin.users', [
            'users' => User::withCount('userOrders')
                ->when($request->filled('q'), function ($query) use ($request) {
                    $term = $request->q;
                    $query->where(function ($nested) use ($term) {
                        $nested->where('firstname', 'like', '%'.$term.'%')
                            ->orWhere('lastname', 'like', '%'.$term.'%')
                            ->orWhere('email', 'like', '%'.$term.'%')
                            ->orWhere('phone', 'like', '%'.$term.'%');
                    });
                })
                ->orderByDesc('id')
                ->paginate(15)
                ->withQueryString(),
        ]);
    }

    public function updateUserRole(Request $request, User $user): RedirectResponse
    {
        $data = $request->validate(['role' => ['required', Rule::in(['admin', 'user'])]]);

        if ($request->user()->is($user) && $data['role'] !== 'admin') {
            return back()->withErrors(['role' => 'Нельзя снять роль администратора у своей учётной записи.']);
        }

        $user->update($data);

        return back()->with('success', 'Роль пользователя обновлена.');
    }

    public function reviews(Request $request): View
    {
        return view('admin.reviews', [
            'reviews' => Review::query()
                ->leftJoin('users', 'users.id', '=', 'reviews.id_user')
                ->select('reviews.*', 'users.firstname as user_firstname', 'users.lastname as user_lastname', 'users.email as user_email')
                ->when($request->filled('q'), fn ($query) => $query->where('reviews.text', 'like', '%'.$request->q.'%'))
                ->orderByDesc('reviews.id_review')
                ->paginate(15)
                ->withQueryString(),
        ]);
    }

    public function posts(Request $request): View
    {
        return view('admin.posts.index', [
            'posts' => Post::when($request->filled('q'), fn ($query) => $query
                ->where('name', 'like', '%'.$request->q.'%')
                ->orWhere('text', 'like', '%'.$request->q.'%'))
                ->latest()
                ->paginate(12)
                ->withQueryString(),
        ]);
    }

    public function createPost(): View
    {
        return view('admin.posts.form', ['post' => new Post()]);
    }

    public function storePost(Request $request): RedirectResponse
    {
        $data = $this->validatePost($request);
        if ($request->hasFile('img')) {
            $data['img'] = $this->saveImage($request->file('img'), 'posts');
        }
        $data['likes'] = 0;
        Post::create($data);

        return redirect()->route('admin.posts.index')->with('success', 'Новость опубликована.');
    }

    public function editPost(Post $post): View
    {
        return view('admin.posts.form', compact('post'));
    }

    public function updatePost(Request $request, Post $post): RedirectResponse
    {
        $data = $this->validatePost($request);
        if ($request->hasFile('img')) {
            $data['img'] = $this->saveImage($request->file('img'), 'posts');
        }
        $post->update($data);

        return redirect()->route('admin.posts.index')->with('success', 'Новость обновлена.');
    }

    private function validateProduct(Request $request, bool $creating = false): array
    {
        return $request->validate([
            'name_product' => ['required', 'string', 'max:50'],
            'price' => ['required', 'integer', 'min:0'],
            'characteristic' => ['required', 'string'],
            'description' => ['required', 'string', 'max:5000'],
            'id_category' => ['required', Rule::exists('categories', 'id_category')],
            'inventory' => ['required', 'integer', 'min:0'],
            'action' => ['nullable', 'boolean'],
            'news' => ['nullable', 'boolean'],
            'img1' => [$creating ? 'required' : 'nullable', 'image', 'max:4096'],
            'img2' => ['nullable', 'image', 'max:4096'],
            'img3' => ['nullable', 'image', 'max:4096'],
        ]);
    }

    private function saveProductImages(Request $request): array
    {
        $images = [];
        foreach (['img1', 'img2', 'img3'] as $field) {
            if ($request->hasFile($field)) {
                $images[$field] = $this->saveImage($request->file($field), 'products');
            }
        }

        return $images;
    }

    private function validatePost(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'text' => ['required', 'string'],
            'img' => ['nullable', 'image', 'max:4096'],
        ]);
    }

    private function saveImage($file, string $directory): string
    {
        $filename = Str::uuid().'.'.$file->getClientOriginalExtension();
        $file->move(public_path('images/'.$directory), $filename);

        return $filename;
    }
}
