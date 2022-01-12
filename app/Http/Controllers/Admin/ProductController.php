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
        // $validatedData = new Product();
        // $request->validate([
        //     'cate_id' => 'required',
        //     'name' => 'required|max:191',
        //     'slug' => 'required|unique:products',
        //     'desciption' => 'required',
        //     'original_price' => 'required',
        //     'sell_price' => 'required',
        //     'stock' => 'required',
        //     'size' => 'required',
        //     'image' => 'required',
        //     'trending' => 'required',
        //     'status' => 'required',
        // ]);

        $products = new Product();
        if($request->hasFile('image')){
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move('assets/uploads/product/', $filename);
            $products->image = $filename;
        }

        // $product = Product::create([
        //     'cate_id' => $request->input('cate_id'),
        //     'name' => $request->input('name'),
        //     'slug' => $request->input('slug'),
        //     'description' => $request->input('description'),
        //     'original_price' => $request->input('original_price'),
        //     'sell_price' => $request->input('sell_price'),
        //     'stock' => $request->input('stock'),
        //     'size' => $request->input('size'),
        //     'status' => $request->input('status') == TRUE ? '1':'0',
        //     'trending' => $request->input('trending') == TRUE ? '1':'0',
        //     'image' => $namaImg,
        // ]);

        $products->cate_id = $request->cate_id;
        $products->name = $request->name;
        $products->slug = $request->slug;
        $products->description = $request->description;
        $products->original_price = $request->original_price;
        $products->sell_price = $request->sell_price;
        $products->stock = $request->stock;
        $products->size = $request->size;
        $products->status = $request->status == TRUE ? '1':'0';
        $products->trending = $request->trending == TRUE ? '1':'0';
        $products->save();

        return redirect('products')->with('status', 'Produk Sukses ditambahkan');
        // if($products){
        //     return redirect('products')->with('status', 'Produk Sukses ditambahkan');
        // } else{
        //     return redirect('products')->with('status', 'Produk Gagal ditambahkan');
        // }

        // return dd($validatedData);
    }

    public function edit($id)
    {
        $products = Product::find($id);
        return view('admin.product.edit', compact('products'));
    }

    public function update(Request $request, $id)
    {
        $products = Product::find($id);
        if($request->hasFile('image')){
            $path = 'assets/uploads/product/'.$products->image;
            if(File::exists($path)){
                File::delete($path);
            }

            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move('assets/uploads/product/', $filename);
            $products->image = $filename;
        }

        $products->name = $request->input('name');
        $products->slug = Str::slug($products->name);
        $products->description = $request->input('description');
        $products->original_price = $request->input('original_price');
        $products->sell_price = $request->input('sell_price');
        $products->stock = $request->input('stock');
        $products->size = $request->input('size');
        $products->status = $request->input('status') == TRUE ? '1':'0';
        $products->trending = $request->input('trending') == TRUE ? '1':'0';
        $products->update();

        return redirect('products')->with('status', 'Produk Sukses diubah');
    }

    public function destroy($id)
    {
        $products = Product::find($id);
        if($products->image){
            $path = 'assets/uploads/product/'.$products->image;
            if(File::exists($path)){
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
