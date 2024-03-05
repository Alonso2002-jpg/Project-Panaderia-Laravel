<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\OrderLine;
use App\Models\Product;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class OrdersController extends Controller
{

    public function createOrder(Request $request)
    {
        $request->validate([
            'name' => 'min:3|max:50|required',
            'lastName' => 'min:3|max:75|required',
            'dni' => 'regex:/^\d{8}[a-zA-a]$/|required',
            'street' => 'min:5|max:100|required',
            'number' => 'sometimes|min:1|max:7',
            'city' => 'min:3|max:50|required',
            'province' => 'min:3|max:70|required',
            'country' => 'min:3|max:70|required',
            'postCode' => 'regex:/^\d{5}$/|required',
            'additionalInfo' => 'sometimes|max:150'
        ]);
        $cart = Session::get('cart');
        $order = new Order();
        $order->user_id = Auth::id();
        $order->save();

        foreach($cart as $item) {
            $product = Product::find($item['product_id']);
            $orderLine = new OrderLine();
            $orderLine->order_id = $order->id;
            $orderLine->product_id = $product->id;
            $orderLine->stock = $item['stock'];
            $product->stock -= $orderLine->stock;
            $orderLine->unitPrice = $product->price;
            $orderLine->linePrice = $product->price * $orderLine->stock;
            $order->totalItems += $orderLine->stock;
            $order->totalPrice += $orderLine->linePrice;
            $order->tax += $orderLine->linePrice * 0.21;
            $order->total = $order->totalPrice + $order->tax;
            $product->save();
            $orderLine->save();
            $order->save();
        }
        Session::forget('cart');
        Session::forget('totalItems');
        Session::put('totalItems', 0);
        // AQUI FALTA CREAR LA FACTURA

        flash('Product successfully added to the cart.')->success()->important();
        return redirect()->back();
    }


    public function getOrders()
    {
        $orders = Order::all();
        return view('orders.index')->with('orders', $orders);
    }

    public function getMeOrders()
    {
        $orders = Order::where('user_id', Auth::id())->get();
        return view('orders.index')->with('orders', $orders);
    }

    public function getOrderById($id)
    {
        $order = Order::find($id);
        return view('orders.show')->with('order', $order);
    }

    public function getMeOrderById($id)
    {
        $order = Order::find($id)
            ->where('user_id', Auth::id())
            ->first();
        return view('orders.show')->with('order', $order);
    }

    public function storeOrder(Request $request){
        $user = User::find(Auth::id());
        $addresses = $user->addresses();
        $cart = Session::get('cart');
        return view('orders.store')->with('cart', $cart)->with('address', $addresses);
    }

    public function returnOrderById($id)
    {
        try {
            $order = Order::find($id);
            foreach ($order->orderLines() as $orderline) {
                $product = Product::find($orderline->product_id);
                $product->stock += $orderline->stock;
                $product->save();
            }
            $order->delete();
            return redirect()->route('orders.index');
        } catch (Exception $e) {
            flash('Error returning the order' . $e->getMessage())->error()->important();
            return redirect()->back();
        }
    }

    public function returnMeOrderById($id)
    {
        try {
            $order = Order::find($id)
                ->where('user_id', Auth::id())
                ->first();
            foreach ($order->orderLine as $orderline) {
                $product = Product::find($orderline->product_id);
                $product->stock += $orderline->stock;
                $product->save();
            }
            $order->delete();
            return redirect()->route('orders.index');
        } catch (Exception $e) {
            flash('Error returning the order' . $e->getMessage())->error()->important();
            return redirect()->back();
        }
    }


    public function destroyOrderById($id)
    {
        try {
            $order = Order::find($id);
            $order->delete();
            flash('Order ' . $order->id . ' deleted successfully.')->error()->important();
            return redirect()->route('orders.index');
        } catch (Exception $e) {
            flash('Error deleting the order' . $e->getMessage())->error()->important();
            return redirect()->back();
        }
    }

    public function destroyMeOrderById($id)
    {
        try {
            $order = Order::find($id)
                ->where('user_id', Auth::id())
                ->first();
            $order->delete();
            flash('Order ' . $order->id . ' deleted successfully.')->error()->important();
            return redirect()->route('orders.index');
        } catch (Exception $e) {
            flash('Error deleting the order' . $e->getMessage())->error()->important();
            return redirect()->back();
        }
    }
}
