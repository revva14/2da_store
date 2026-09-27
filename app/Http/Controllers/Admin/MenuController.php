<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MenuController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('name')->get();

        return view('admin.menu', compact('products'));
    }

    public function create()
    {
        return view('admin.menu-form', [
            'product'    => new Product(),
            'categories' => Product::categoryMeta(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = Str::slug($data['name']) . '-' . Str::lower(Str::random(4));

        if ($request->hasFile('img')) {
            $data['img'] = $this->storeImage($request->file('img'));
        }

        Product::create($data);

        return redirect('/admin/menu')->with('success', 'Menu baru berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        return view('admin.menu-form', [
            'product'    => $product,
            'categories' => Product::categoryMeta(),
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $data = $this->validated($request);

        if ($request->hasFile('img')) {
            $this->deleteImage($product->img);
            $data['img'] = $this->storeImage($request->file('img'));
        }

        $product->update($data);

        return redirect('/admin/menu')->with('success', 'Menu berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        $this->deleteImage($product->img);
        $product->delete();

        return back()->with('success', 'Menu berhasil dihapus.');
    }

    // dipanggil dari tombol +/- stepper stok (AJAX) supaya beneran tersimpan
    public function updateStock(Request $request, Product $product)
    {
        $request->validate(['step' => 'required|integer']);

        $product->stock = max(0, $product->stock + $request->integer('step'));
        if ($product->stock === 0) {
            $product->is_active = false;
        }
        $product->save();

        return response()->json([
            'stock'     => $product->stock,
            'is_active' => $product->is_active,
        ]);
    }

    // dipanggil dari switch status jual (AJAX)
    public function toggleStatus(Product $product)
    {
        $product->is_active = ! $product->is_active;
        $product->save();

        return response()->json(['is_active' => $product->is_active]);
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'name'   => 'required|string|max:120',
            'desc'   => 'nullable|string|max:500',
            'cats'   => 'required|in:gurih,manis,minuman',
            'price'  => 'required|integer|min:0',
            'sku'    => 'nullable|string|max:30',
            'stock'  => 'required|integer|min:0',
            'img'    => 'nullable|image|max:2048',
        ]);

        // checkbox: kalau tidak dicentang, browser tidak mengirim field-nya sama
        // sekali, jadi harus dibaca manual biar bisa "dimatikan" juga.
        $data['is_hot']    = $request->boolean('is_hot');
        $data['is_active'] = $request->boolean('is_active');

        unset($data['img']); // img ditangani terpisah lewat storeImage()

        return $data;
    }

    private function storeImage($file): string
    {
        $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
            . '.' . $file->getClientOriginalExtension();

        // disimpan di public/images supaya path-nya sama persis dengan yang
        // dipakai menulogin.blade.php: asset('images/' . $p['img'])
        $file->move(public_path('images'), $filename);

        return $filename;
    }

    private function deleteImage(?string $filename): void
    {
        if ($filename && file_exists(public_path('images/' . $filename))) {
            @unlink(public_path('images/' . $filename));
        }
    }
}

