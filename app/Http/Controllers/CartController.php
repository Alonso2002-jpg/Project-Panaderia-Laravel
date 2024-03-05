<?php

namespace App\Http\Controllers;

use App\Models\OrderLine;
use App\Models\Product;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class CartController extends Controller
{
    public function showCart()
    {
        $cart = Session::get('cart', []);
        return view('cart')->with('cart', $cart);
    }

    public function updateCartLine(Request $request)
    {
        try{
            $product = Product::find($request->id);

            $request->validate([
                'stock' => 'required|gt:0|lte:' . $product->stock,
            ]);

            $cart = Session::get('cart', []);
            $totalItems = Session::get('totalItems', 0);

            foreach ($cart as $key => $item) {
                if ($key == $request->key) {
                    $totalItems -= $cart[$key]['stock'];
                    $cart[$key]['stock'] = $request->stock;
                    $totalItems += $cart[$key]['stock'];
                    break;
                }
            }
            Session::put('cart', $cart);
            Session::put('totalItems', $totalItems);
            return redirect()->back();
        } catch (Exception $e){
            flash('Error updating cart line .' . $request->key)->error()->important();
            return redirect()->back();
        }
    }

    public function destroyCartLine(Request $request)
    {
        try{
            $cart = Session::get('cart', []);
            $totalItems = Session::get('totalItems', 0);

            foreach ($cart as $key => $item) {
                if ($key == $request->key) {
                    $totalItems = max(0, $totalItems - $cart[$key]['stock']);
                    unset($cart[$key]);
                    break;
                }
            }
            Session::put('cart', $cart);
            Session::put('totalItems', $totalItems);
            return redirect()->back();
        } catch (Exception $e){
            flash('Error updating cart line .' . $request->key)->error()->important();
            return redirect()->back();
        }
    }
}
