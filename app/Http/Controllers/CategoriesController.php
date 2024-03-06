<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{

    public function index(Request $request)
    {
        $categories = Category::search($request->search)->orderBy('id', 'asc')->paginate(3);
        return view('categories.index')->with('categories', $categories);
    }

    public function show($id)
    {
        if(Cache::has('category' . $id)){
            $category = Cache::get('category' . $id);
        } else {
            $category = Category::find($id);
        }
        Cache::put('category' . $id, $category, 300);
        return view('categories.show')->with('category', $category);
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'min:4|max:120|required|unique:categories,name',
        ]);
        try {
            $category = new Category();
            $category->name = strtoupper($request->name);
            $category->save();
            flash('Category ' . $category->name . ' successfully created.')->success()->important();
            return redirect()->route('categories.index');
        } catch (Exception $e) {
            flash('There is already another category with the same name')->error()->important();
            return redirect()->back();
        }

    }

    public function edit($id)
    {
        try {
            $category = Category::find($id);
            if ($category && $id != 0) {
                return view('categories.edit')->with('category', $category);
            } else {
                flash('Invalid route')->error()->important();
                return redirect()->route('categories.index');
            }
        } catch (Exception $e) {
            flash('Invalid route')->error()->important();
            return redirect()->route('categories.index');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'min:4|max:120|required|unique:categories,name,' . $id,
        ]);
        try {
            $category = Category::find($id);
            $category->name = strtoupper($request->name);
            $category->save();
            Cache::forget('category' . $id);
            flash('Category ' . $category->name . ' successfully updated')->success()->important();
            return redirect()->route('categories.index');
        } catch (Exception $e) {
            flash('There is already another category with the same name')->error()->important();
            return redirect()->back();
        }
    }

    public function editImage($id)
    {
        try {
            $category = Category::find($id);
            if ($category) {
                return view('categories.image')->with('category', $category);
            } else {
                flash('Invalid route')->error()->important();
                return redirect()->route('categories.index');
            }
        } catch (Exception $e) {
            flash('Invalid route')->error()->important();
            return redirect()->route('categories.index');
        }
    }

    public function updateImage(Request $request, $id)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        try {
            $category = Category::find($id);
            if ($category->image != Category::$IMAGE_DEFAULT && Storage::exists('public/' . $category->image)) {
                Storage::delete('public/' . $category->image);
            }

            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $fileToSave = Str::uuid() . '.' . $extension;
            $category->image = $image->storeAs('category', $fileToSave, 'public');
            $category->save();
            Cache::forget('category' . $id);
            flash('Category ' . $category->name . ' successfully updated')->warning()->important();
            return redirect()->route('categories.index');
        } catch (Exception $e) {
            flash('Error updating Category ' . $e->getMessage())->error()->important();
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        if ($id != 1) {
            try {
                $category = Category::find($id);
                $category->updateProductWithOutCategory($id);
                $category->delete();
                Cache::forget('category' . $id);
                flash('Category ' . $category->name . ' successfully removed')->success()->important();
                return redirect()->route('categories.index');
            } catch (Exception $e) {
                flash('Error when deleting Category' . $e->getMessage())->error()->important();
                return redirect()->back();
            }
        } else {
            flash('Invalid route')->error()->important();
            return redirect()->back();
        }
    }

    public function recover($id)
    {
        $category = Category::find($id);
        $category->isDelete = false;
        $category->save();
        Cache::forget('category' . $id);
        return redirect()->route('categories.index');
    }
}
