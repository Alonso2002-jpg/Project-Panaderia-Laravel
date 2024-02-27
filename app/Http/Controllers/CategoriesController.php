<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Exception;
use Illuminate\Http\Request;

class CategoriesController extends Controller{

    public function index(Request $request){
        $categories = Category::search($request->search)->orderBy('id', 'asc')->paginate(5);
        return view('categories.index')->with('categories', $categories);
    }

    public function create(){
        return view('categories.create');
    }

    public function store(Request $request){
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

    public function edit($id){
        try {
            $category = Category::find($id);
            if($category && $id != 1){
                return view('categories.edit')->with('category', $category);
            }else{
                flash('Invalid route')->error()->important();
                return redirect()->route('categories.index');
            }
        }catch (Exception $e){
            flash('Invalid route')->error()->important();
            return redirect()->route('categories.index');
        }
    }

    public function update(Request $request, $id){
        $request->validate([
            'name' => 'min:4|max:120|required|unique:categories,name,' .$id,
        ]);

        try{
            $category = Category::find($id);
            $category->name = strtoupper($request->name);
            $category->save();
            flash('Category ' . $category->name . ' successfully updated')->warning()->important();
            return redirect()->route('categories.index');
        }catch (Exception $e){
            flash('There is already another category with the same name')->error()->important();
            return redirect()->back();
        }
    }

    public function destroy($id){
        if($id != 1){
            try{
                $category = Category::find($id);
                $category->updateProductWithOutCategory($id);
                $category->delete();
                flash('Category ' . $category->name . ' successfully removed')->error()->important();
                return redirect()->route('categories.index');
            }catch (Exception $e){
                flash('Error when deleting Category' . $e->getMessage())->error()->important();
                return redirect()->back();
            }
        }else{
            flash('Invalid route')->error()->important();
            return redirect()->back();
        }
    }
}
