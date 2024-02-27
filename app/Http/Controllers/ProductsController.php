<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Provider;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    public function index(Request $request){
        $products = Product::filtrar($request->search, $request->category, $request->provider)->orderBy($request->orderBy ?? 'id' , $request->order ?? 'asc')->paginate($request->paginate ?? 5);
        return view('products.index')->with('products', $products);
    }

    public function show($id){
       $product = Product::find($id);
       return view('products.show')->with('product', $product);
    }

    public function create(){
        $categories = Category::where('id', '<>', 1)->get();
        $providers = Provider::where('id', '<>', 1)->get();
        return view('products.create')->with('categories', $categories)->with('providers', $providers);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'min:3|max:120|required|unique:products,name',
            'description' => 'max:255|sometimes',
            'price' => 'required|regex:/^\d{1,6}(\.\d{1,2})?$/',
            'stock' => 'required|integer|max:10000',
            'category' => 'sometimes|exists:category,id',
            'provider' => 'sometimes|exists:provider,id'
        ]);

        try{
            $product = new Product($request->all());
            $product->category_id = $request->category ?? 1;
            $product->provider_id = $request->provider ?? 1;
            $product->save();
            flash('Product ' . $product->name . ' created successfully.')->success()->important();
            return redirect()->route('products.index');
        } catch (Exception $e){
            flash('Error creating the product. '. $e->getMessage())->error()->important();
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        $product = Product::find($id);
        $categories = Category::where('id', '<>', 1)->get();
        $providers = Provider::where('id', '<>', 1)->get();
        return view('products.edit')
            ->with('product', $product)
            ->with('category', $categories)
            ->with('provider', $providers);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'min:3|max:120|required|unique:products,name,' . $id,
            'description' => 'max:255|sometimes',
            'price' => 'required|regex:/^\d{1,6}(\.\d{1,2})?$/',
            'stock' => 'required|integer|max:10000',
            'category' => 'sometimes|exists:category,id',
            'provider' => 'sometimes|exists:provider,id',
        ]);
        try {
            $product = Product::find($id);
            $product->update($request->all());
            $product->description = $product->description ?? " ";
            $product->category_id = $request->category ?? 1;
            $product->provider_id = $request->provider ?? 1;
            $product->save();
            flash('Product ' . $product->name . ' updated successfully.')->warning()->important();
            return redirect()->route('products.index');
        } catch (Exception $e) {
            flash('Error updating the product' . $e->getMessage())->error()->important();
            return redirect()->back();
        }
    }

    public function editImage($id)
    {
        $product = Product::find($id);
        return view('products.image')->with('product', $product);
    }

    public function updateImage(Request $request, $id){
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        try{
            $product = Product::find($id);
            if($product->image != Product::$IMAGE_DEFAULT && Storage::exists('public/' . $product->image)){
                Storage::delete('public/' . $product->image);
            }

            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $fileToSave = $product->id . '.' . $extension;
            $product->image = $image->storeAs('products', $fileToSave, 'public');
            $product->save();
            flash('Product ' . $product->name . ' updated successfully.')->warning()->important();
            return redirect()->route('products.index');
        } catch (Exception $e){
            flash('Error updating the product'  . $e->getMessage())->error()->important();
            return redirect()->back();
        }
    }


    public function destroy($id)
    {
        try {
            $product = Product::find($id);
            if ($product->image != Product::$IMAGE_DEFAULT && Storage::exists('public/' . $product->image)) {
                Storage::delete('public/' . $product->image);
            }
            $product->delete();
            flash('Product ' . $product->name . ' deleted successfully.')->error()->important();
            return redirect()->route('products.index');
        } catch (Exception $e) {
            flash('Error deleting the product' . $e->getMessage())->error()->important();
            return redirect()->back();
        }
    }
}
