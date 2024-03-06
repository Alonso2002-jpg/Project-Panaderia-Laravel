<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Provider;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductsController extends Controller
{
    public function index(Request $request){
        $products = Product::filtrar($request->search, $request->category, $request->provider)->orderBy($request->orderBy ?? 'id' , $request->order ?? 'asc')->paginate($request->paginate ?? 5);
        $categories = Category::all();
        $providers = Provider::all();
        return view('products.index')->with('products', $products)
            ->with('categories', $categories)
            ->with('providers', $providers);
    }

    public function addToCart(Request $request, $id){
        try {
            $product = Product::find($id);
            $request->validate([
                'stock' => 'required|gt:0|lte:' . $product->stock,
            ]);
            $cart = Session::get('cart', []);
            $totalItems = Session::get('totalItems', 0);
            $totalItems += $request->stock;
            $newItem = [
                'product_id' => $product->id,
                'stock' => $request->stock,
            ];
            $cart[] = $newItem;
            Session::put('cart', $cart);
            Session::put('totalItems', $totalItems);
            flash($request->stock . ' ' . $product->name . ' added to cart.')->success()->important();
            return redirect()->back();
        } catch (Exception $e) {
            flash('Error adding ' . $product->name . ' to cart.')->error()->important();
            return redirect()->back();
        }
    }

    public function show($id){
        if(Cache::has($id)){
            $product = Cache::get($id);
        } else {
            $product = Product::find($id);
        }
       $relatedProducts = Product::where('category_id', '=', $product->category_id)->where('id', "<>", $id)->get();
       Cache::put($id, $product, 300);
       return view('products.show')->with('product', $product)->with('relatedProducts', $relatedProducts);
    }

    public function create(){
        $categories = Category::where('id', '<>', 1)->get();
        $providers = Provider::where('id', '<>', 1)->get();
        return view('products.create')->with('categories', $categories)->with('providers', $providers);
    }

    public function getProductsByCategory($id){
        $products = Product::where('category_id', "=", $id)->orderBy('id', 'asc')->paginate(5);
        return view('products.index')->with('products', $products);
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
            $product->id = Str::uuid();
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
            $cart = Session::get('cart', []);
            $totalItems = Session::get('totalItems', 0);
            $totalToRemove = 0;

            foreach ($cart as $key => $item) {
                if ($item['product_id'] == $id) {
                    $totalToRemove += $item['stock'];
                    unset($cart[$key]);
                }
            }
            Session::put('cart', array_values($cart));
            Session::put('totalItems', max(0, $totalItems - $totalToRemove));
            Cache::forget($product->id);
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
            Cache::forget($product->id);
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
            $cart = Session::get('cart', []);

            $totalItems = Session::get('totalItems', 0);
            $totalToRemove = 0;

            foreach ($cart as $key => $item) {
                if ($item['product_id'] == $id) {
                    $totalToRemove += $item['stock'];
                    unset($cart[$key]);
                }
            }
            Session::put('cart', array_values($cart));
            Session::put('totalItems', max(0, $totalItems - $totalToRemove));
            Cache::forget($product->id);
            flash('Product ' . $product->name . ' deleted successfully.')->error()->important();
            return redirect()->route('products.index');
        } catch (Exception $e) {
            flash('Error deleting the product' . $e->getMessage())->error()->important();
            return redirect()->back();
        }
    }
}
