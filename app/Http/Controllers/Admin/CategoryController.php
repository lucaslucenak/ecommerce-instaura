<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryFormRequest;

class CategoryController extends Controller
{
    public function index() {
        return view('admin.category.index');
    }
    
    public function create() {
        return view('admin.category.create');
    }

    public function store(CategoryFormRequest $request) {
        $validatedData = $request->validated();

        $category = new Category;
        $category->name = $validatedData['name'];
        $category->slug = Str::slug($validatedData['slug']);
        $category->description = $validatedData['description'];

        if ($request->hasFile('image')) {
            $file = $request->file('image');

            $fileExtesion = $file->getClientOriginalExtension();
            $fileName = time() . '.' . $fileExtesion; 

            $file->move('uploads/category/', $fileName);

            $category->image = $fileName;
        }

        $category->meta_title = $validatedData['meta_title'];
        $category->meta_keyword = $validatedData['meta_keyword'];
        $category->meta_description = $validatedData['meta_description'];

        $category->status = $request->status == true ? '1' : '0';

        $category->save();

        return redirect('admin/category')->with('message', 'Category Successfully Added');
    }

    public function edit(Category $category) {
        return $category;
    }
}
