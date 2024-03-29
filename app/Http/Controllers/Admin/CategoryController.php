<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    public function index()
    {
        $category = Category::all();
        return view('admin.category.index', compact('category'));
    }

    public function add()
    {
        return view('admin.category.add');
    }

    public function insert(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'slug' => 'required',
                'image' => 'required',
            ],
            [
                'name.required' => 'Nama harus diisi!',
                'slug.required' => 'Slug harus ada!',
                'image.required' => 'Gambar harus ada!',
            ]
        );
        $category = new Category();
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time() . '.' . $ext;
            $file->move('assets/uploads/category/', $filename);
            $category->image = $filename;
        }

        $category->name = $request->input('name');
        $category->slug = $request->input('slug');
        $category->description = $request->input('description');
        $category->status = $request->input('status') == TRUE ? '1' : '0';
        $category->popular = $request->input('popular') == TRUE ? '1' : '0';
        $category->save();

        return redirect('categories')->with('status', 'Kategori Sukses Ditambahkan');
    }

    public function edit($id)
    {
        $category = Category::find($id);
        return view('admin.category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'name' => 'required',
                'slug' => 'required',
                'description' => 'required',
            ],
            [
                'name.required' => 'Nama harus diisi!',
                'slug.required' => 'Slug harus ada!',
                'description.required' => 'Deskripsi harus diisi!',
            ]
        );

        $category = Category::find($id);
        if ($request->hasFile('image')) {
            $path = 'assets/uploads/category/' . $category->image;
            if (File::exists(public_path($path))) {
                File::delete(public_path($path));
            }

            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = time() . '.' . $ext;
            $file->move('assets/uploads/category', $filename);
            $category->image = $filename;
            $category->name = $request->input('name');
            $category->slug = $request->input('slug');
            $category->description = $request->input('description');
            $category->status = $request->input('status') == TRUE ? '1' : '0';
            $category->popular = $request->input('popular') == TRUE ? '1' : '0';
            $category->update();
        } else {
            $category->name = $request->input('name');
            $category->slug = $request->input('slug');
            $category->description = $request->input('description');
            $category->status = $request->input('status') == TRUE ? '1' : '0';
            $category->popular = $request->input('popular') == TRUE ? '1' : '0';
            $category->update();
        }

        return redirect('categories')->with('status', 'Kategori Sukses diubah');
    }

    public function destroy($id)
    {
        $category = Category::find($id);
        if ($category->image) {
            $path = 'assets/uploads/category/' . $category->image;
            if (File::exists($path)) {
                File::delete($path);
            }
        }
        $category->delete();

        return redirect('categories')->with('status', 'Kategori Berhasil dihapus');
    }

    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Category::class, 'slug', $request->name);

        return response()->json(['slug' => $slug]);
    }
}
