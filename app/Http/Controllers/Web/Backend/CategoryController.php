<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){
        $categorys= Category::all();
        return view('backend.layouts.category.index',compact('categorys'));
    }
    public function create(){
        return view('backend.layouts.category.create');
    }
    public function store(Request $request){
        $request->validate([
            'category_name' => 'required|string|max:255',
            'category_description' => 'required|string|max:255',
        ]);
        Category::create([
            'category_name' => $request->category_name,
            'category_description' => $request->category_description
        ]);
        return redirect()->route('category.index')->with('success', 'New category added successfully');
    }
    public function edit($id){
        $category = Category::find($id);
        return view('backend.layouts.category.edit',compact('category'));
    }
    public function update(Request $request, $id){
        $request->validate([
            'category_name' => 'required|string|max:255',
            'category_description' => 'required|string|max:255',
        ]);
        $category = Category::find($id);
        $category->category_name = $request->category_name;
        $category->category_description = $request->category_description;
        $category->save();
        return redirect()->route('category.index')->with('success', 'Category updated successfully');
    }
    public function destroy($id){
        $category = Category::find($id);
        $category->delete();
        return redirect()->route('category.index')->with('success', 'Category deleted successfully');
    }

}
