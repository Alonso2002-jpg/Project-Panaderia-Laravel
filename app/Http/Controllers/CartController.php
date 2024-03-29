<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;


class CartController extends Controller
{
    /**
     * Displays the shopping cart.
     *
     * Retrieves the current shopping cart from the session. If there is no cart in the session,
     * it initializes an empty array as the cart. Returns the cart view with the cart data to display
     * the items currently in the shopping cart.
     *
     * @return \Illuminate\View\View Returns a view displaying the shopping cart.
     */
    public function showCart()
    {
        $cart = Session::get('cart', []);
        $cartItems = [];
        $totalPrice = 0;
        foreach ($cart as $item) {
            $product = $this->getProduct($item['product_id']);
            $totalPrice += $product->price * $item['stock'];
            $cartItems[] = [
                'product' => $product,
                'quantity' => $item['stock'],
            ];
        }

        return view('cart.cart')->with('cartItems', $cartItems)->with('totalPrice', $totalPrice);
    }

    public function payment()
    {
        $user = User::find(Auth::id());
        $address = $user->addresses()->orderBy('id', 'desc')->first();
        $cart = Session::get('cart', []);
        $totalPrice = 0;
        foreach ($cart as $item) {
            $product = $this->getProduct($item['product_id']);
            $totalPrice += $product->price * $item['stock'];
        }
        $tax = $totalPrice * 0.21;
        $total = $totalPrice + $tax;
        return view('layouts.payment')
            ->with('totalPrice', $totalPrice)
            ->with('tax', $tax)
            ->with('total', $total)
            ->with('address', $address);
    }

    /**
     * Updates the quantity of a specific product in the shopping cart.
     *
     * Validates the requested stock quantity against the available stock of the product.
     * If the validation passes, it updates the quantity of the specified product in the
     * shopping cart stored in the session. It also updates the total number of items in
     * the cart. Redirects back to the previous page upon successful update or in case of
     * an error with an appropriate flash message.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse Redirects back with a success or error message.
     */
    public function updateCartLine(Request $request)
    {
        try {
            $product = $this->getProduct($request->id);

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
        } catch (Exception $e) {
            flash('Error updating cart line ' . $e->getMessage())->error()->important();
            return redirect()->back();
        }
    }

    /**
     * Removes a specific product line from the shopping cart.
     *
     * Iterates through the cart items stored in the session to find the product line
     * matching the key provided in the request. Upon finding the matching item, it deducts
     * the quantity of that item from the total items count and removes the item from the cart.
     * Updates the cart and total items in the session. Redirects back to the previous page
     * upon successful removal or in case of an error with an appropriate flash message.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse Redirects back with a success or error message.
     */
    public function destroyCartLine(Request $request)
    {
        try {
            $cart = Session::get('cart', []);
            $totalItems = Session::get('totalItems', 0);

            foreach ($cart as $key => $item) {
                if ($key == $request->key) {
                    $totalItems = max(0, $totalItems - $cart[$key]['stock']);
                    unset($cart[$key]);
                    break;
                }
            }
            $cart = array_values($cart);
            Session::put('cart', $cart);
            Session::put('totalItems', $totalItems);
            return redirect()->back();
        } catch (Exception $e) {
            flash('Error updating cart line ' . $e->getMessage())->error()->important();
            return redirect()->back();
        }
    }

    private function getProduct($id)
    {
        return Cache::has($id) ? Cache::get($id) : Product::find($id);
    }
}
