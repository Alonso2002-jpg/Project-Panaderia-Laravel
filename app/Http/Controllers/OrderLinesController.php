<?php

namespace App\Http\Controllers;

use App\Models\OrderLine;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderLinesController extends Controller
{
    public function addToCart(Request $request)
    {
        $request->validate([
            'stock' => 'required|gt:0'
        ]);

        $user = User::find(Auth::id());
        $cart = $user->getCart();
        $orderLine = new OrderLine([
            'product_id' => $productId,
            'quantity' => $quantity,
        ]);

        $order->orderLines()->save($orderLine);

        // Puedes redirigir o responder según tus necesidades
        return redirect()->route('ruta_a_redirigir');
    }
}
