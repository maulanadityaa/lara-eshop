<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('admin.product.index', compact('products'));
    }

    public function add()
    {
        $category = Category::all();
        return view('admin.product.add', compact('category'));
    }

    public function insert(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'slug' => 'required',
                'image' => 'required',
                'description' => 'required',
                'stock' => 'required|gt:5',
                'original_price' => 'required',
                'sell_price' => 'required',
                'size' => 'required',
            ],
            [
                'name.required' => 'Nama harus diisi!',
                'slug.required' => 'Slug harus ada!',
                'image.required' => 'Gambar harus ada!',
                'description.required' => 'Deskripsi harus diisi!',
                'stock.required' => 'Stok harus ada!',
                'original_price.required' => 'Harga Asli harus diisi!',
                'sell_price.required' => 'Harga Jual harus diisi!',
                'size.required' => 'Ukuran harus ada!',
            ]
        );

        $products = new Product();
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time() . '.' . $ext;
            $file->move('assets/uploads/product/', $filename);
            $products->image = $filename;
        }

        $products->cate_id = $request->cate_id;
        $products->name = $request->name;
        $products->slug = $request->slug;
        $products->description = $request->description;
        $products->original_price = $request->original_price;
        $products->sell_price = $request->sell_price;
        $products->stock = $request->stock;
        $products->size = $request->size;
        $products->status = $request->status == TRUE ? '1' : '0';
        $products->trending = $request->trending == TRUE ? '1' : '0';
        $products->save();

        return redirect('products')->with('status', 'Produk Sukses ditambahkan');
    }

    public function edit($id)
    {
        $products = Product::find($id);
        return view('admin.product.edit', compact('products'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'name' => 'required',
                'slug' => 'required',
                'description' => 'required',
                'stock' => 'required',
                'original_price' => 'required',
                'sell_price' => 'required',
                'size' => 'required',
            ],
            [
                'name.required' => 'Nama harus diisi!',
                'slug.required' => 'Slug harus ada!',
                'description.required' => 'Deskripsi harus diisi!',
                'stock.required' => 'Stok harus ada!',
                'original_price.required' => 'Harga Asli harus diisi!',
                'sell_price.required' => 'Harga Jual harus diisi!',
                'size.required' => 'Ukuran harus ada!',
            ]
        );

        $products = Product::find($id);
        if ($request->hasFile('image')) {
            $path = 'assets/uploads/product/' . $products->image;
            if (File::exists(public_path($path))) {
                File::delete(public_path($path));
            }

            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time() . '.' . $ext;
            $file->move('assets/uploads/product/', $filename);
            $products->image = $filename;
            $products->name = $request->input('name');
            $products->slug = Str::slug($products->name);
            $products->description = $request->input('description');
            $products->original_price = $request->input('original_price');
            $products->sell_price = $request->input('sell_price');
            $products->stock = $request->input('stock');
            $products->size = $request->input('size');
            $products->status = $request->input('status') == TRUE ? '1' : '0';
            $products->trending = $request->input('trending') == TRUE ? '1' : '0';
            $products->update();
        } else {
            $products->name = $request->input('name');
            $products->slug = Str::slug($products->name);
            $products->description = $request->input('description');
            $products->original_price = $request->input('original_price');
            $products->sell_price = $request->input('sell_price');
            $products->stock = $request->input('stock');
            $products->size = $request->input('size');
            $products->status = $request->input('status') == TRUE ? '1' : '0';
            $products->trending = $request->input('trending') == TRUE ? '1' : '0';
            $products->update();
        }



        return redirect('products')->with('status', 'Produk Sukses diubah');
    }

    public function destroy($id)
    {
        $products = Product::find($id);
        if ($products->image) {
            $path = 'assets/uploads/product/' . $products->image;
            if (File::exists($path)) {
                File::delete($path);
            }
        }
        $products->delete();

        return redirect('products')->with('status', 'Produk Berhasil dihapus');
    }

    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Product::class, 'slug', $request->name);

        return response()->json(['slug' => $slug]);
    }
}
