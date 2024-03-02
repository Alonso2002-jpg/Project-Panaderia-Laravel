<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{
    public function getOrders()
    {
        $orders = Order::where('open', false)->get();
        return view('orders.index')->with('orders', $orders);
    }

    public function getMeOrders()
    {
        $orders = Order::where('user_id', Auth::id())
            ->where('open', false)
            ->get();
        return view('orders.index')->with('orders', $orders);
    }

    public function getOrderById($id)
    {
        $order = Order::where('id', $id)
            ->where('open', false)
            ->first();
        return view('orders.show')->with('order', $order);
    }

    public function getMeOrderById($id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('open', false)
            ->first();
        return view('orders.show')->with('order', $order);
    }

    public function storeOrder(Request $request){
        $user = User::find('id', Auth::id());
        $addresses = $user->addresses();
        $order = $user->getCart();
        return view('orders.store')->with('order', $order)->with('address', $addresses);
    }

    public function returnOrderById($id)
    {
        try {
            $order = Order::where('id', $id)
                ->where('open', false)
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

    public function returnMeOrderById($id)
    {
        try {
            $order = Order::where('id', $id)
                ->where('user_id', Auth::id())
                ->where('open', false)
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
            $order = Order::where('id', $id)
                ->where('open', false)
                ->first();
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
            $order = Order::where('id', $id)
                ->where('user_id', Auth::id())
                ->where('open', false)
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
