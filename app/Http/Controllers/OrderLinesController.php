<?php

namespace App\Http\Controllers;

use App\Models\OrderLine;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderLinesController extends Controller
{
    public function showCart()
    {
        $user = User::find(Auth::id());
        $cart = $user->getCart();
        return view('cart.show')->with('cart', $cart);
    }

    public function addToCart(Request $request, $id)
    {
        $request->validate([
            'stock' => 'required|gt:0'
        ]);
        $product = Product::find($id);
        if ($product->stock < $request->stock) {
            flash('Insufficient stock of product ' . $product->name);
            return redirect()->back();
        }
        $user = User::find(Auth::id());
        $cart = $user->getCart();
        $orderLine = new OrderLine([
            'order_id' => $cart->id,
            'product_id' => $id,
            'stock' => $request->stock,
            'unitPrice' => $request->unitPrice,
            'linePrice' => $request->stock * $request->unitPrice
        ]);
        $cart->totalItems += $orderLine->stock;
        $cart->totalPrice += $orderLine->linePrice;
        $cart->tax += $orderLine->linePrice * 0.21;
        $cart->total = $cart->totalPrice + $cart->tax;
        $orderLine->save();
        $cart->save();
        flash('Product successfully added to the cart.')->success()->important();
        return redirect()->back();
    }

    public function updateOrderLine(Request $request, $id)
    {
        $orderLine = OrderLine::find($id);
        $product = $orderLine->product;
        $request->validate([
            'stock' => 'required|gt:0|lte:' . $product->stock
        ]);
        $order = $orderLine->order;

        // Borramos datos de la orden
        $order->totalItems -= $orderLine->stock;
        $order->totalPrice -= $orderLine->linePrice;
        $order->tax -= $orderLine->linePrice * 0.21;
        $order->total = $order->totalPrice + $order->tax;

        // Actualizamos la orderline
        $orderLine->stock = $request->stock;
        $orderLine->linePrice = $orderLine->stock * $orderLine->unitPrice;
        $orderLine->save();

        // Actualizamos la orden con los nuevos datos
        $order->totalItems += $orderLine->stock;
        $order->totalPrice += $orderLine->linePrice;
        $order->tax += $orderLine->linePrice * 0.21;
        $order->total = $order->totalPrice + $order->tax;
        $order->save();
        flash('Product successfully update from the cart.')->warning()->important();
        return redirect()->route('cart');
    }

    public function destroyOrderLine($id)
    {
        $orderLine = OrderLine::find($id);
        $order = $orderLine->order;
        $order->totalItems -= $orderLine->stock;
        $order->totalPrice -= $orderLine->linePrice;
        $order->tax -= $orderLine->linePrice * 0.21;
        $order->total = $order->totalPrice + $order->tax;
        $orderLine->delete();
        $order->save();
        flash('Product successfully deleted from the cart.')->warning()->important();
        return redirect()->route('cart');
    }
}
