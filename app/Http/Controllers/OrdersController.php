<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\OrderLine;
use App\Models\Product;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class OrdersController extends Controller
{
    /**
     * Creates a new order with the items in the shopping cart.
     *
     * Validates the incoming request data for creating an order, including personal and shipping details.
     * Retrieves the shopping cart from the session. For each item in the cart, it finds the corresponding
     * product in the database, creates an order line with product details and quantity, and updates the product's
     * stock. It calculates the total items, total price, taxes, and grand total for the order. After saving all
     * changes, it clears the shopping cart from the session and resets the total items count to 0. A success flash
     * message is shown, and the user is redirected back. This method assumes additional steps may be required for
     * completing the order process, such as generating an invoice.
     *
     * @param \Illuminate\Http\Request $request Contains the data needed for the order and shipping details.
     * @return \Illuminate\Http\RedirectResponse Redirects back with a success message.
     */

    public function createOrder(Request $request)
    {
        $request->validate([
            'name' => 'min:3|max:50|required',
            'lastName' => 'min:3|max:75|required',
            'dni' => 'regex:/^\d{8}[a-zA-Z]$/|required',
            'street' => 'min:5|max:100|required',
            'number' => 'sometimes|min:1|max:7',
            'city' => 'min:3|max:50|required',
            'province' => 'min:3|max:70|required',
            'postCode' => 'regex:/^\d{5}$/|required',
            'additionalInfo' => 'sometimes|max:150',
            'card' => 'required|regex:/^\d{16}$/',
            'expiry' => 'required|regex:/^[0-9]{2}\/[0-9]{2}$/',
            'cvv' => 'required|regex:/^\d{3}$/'
        ]);
        $adress = new Address($request->all());
        $adress->country = "Spain";
        $adress->user_id = Auth::id();
        $cart = Session::get('cart', []);
        $order = new Order();
        $order->user_id = Auth::id();
        $order->save();
        $adress->save();

        foreach ($cart as $item) {
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

        flash('Order successfully made.')->success()->important();
        return $this->generateInvoice($order, $order->orderLines, $adress);
    }

    /**
     * @param $order
     * @param $orderLines
     * @param $address
     * @return mixed
     *
     * Este metodo genera el pdf de la orden, recibe la order, las lineas de pedidos y la direccion, busca al usuario autenticado
     * y con esos datos genera la factura completa que se descargara para el usuario.
     */
    public function generateInvoice($order, $orderLines, $address)
    {
        $user = User::find(Auth::id());
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('pdf.invoice', ['user' => $user, 'order' => $order, 'address' => $address, 'orderLines' => $orderLines]);
        return $pdf->download(Carbon::now() . $order->id . '.pdf');
    }
    /**
     * Retrieves all orders and displays them.
     *
     * Fetches all orders from the database without applying any filters. This method is
     * intended to display a comprehensive list of all orders, typically for administrative
     * purposes. The orders are then passed to the view responsible for listing them.
     *
     * @return \Illuminate\View\View Returns a view displaying all orders.
     */
    public function getOrders()
    {
        $orders = Order::all();
        return view('orders.index')->with('orders', $orders);
    }

    /**
     * Retrieves and displays orders for the authenticated user.
     *
     * Fetches orders from the database that belong to the currently authenticated user,
     * identified by their user ID. This method ensures that users can only access their own
     * orders, maintaining privacy and security. The retrieved orders are then passed to the
     * view responsible for listing them.
     *
     * @return \Illuminate\View\View Returns a view displaying the orders of the authenticated user.
     */

    public function getMeOrders()
    {
        $orders = Order::where('user_id', Auth::id())->get();
        return view('orders.index')->with('orders', $orders);
    }

    /**
     * Displays details of a specific order.
     *
     * Finds an order by its ID and passes it to the view responsible for displaying its details.
     * This method allows for the detailed viewing of an order's information, including items,
     * quantities, prices, and other relevant data associated with the order. It's useful for
     * reviewing individual orders, either by the customer or the administration.
     *
     * @param int|string $id The ID of the order to display.
     * @return \Illuminate\View\View Returns a view displaying the specified order's details.
     */

    public function getOrderById($id)
    {
        $order = Order::find($id);
        return view('orders.show')->with('order', $order);
    }

    /**
     * Retrieves and displays a specific order for the authenticated user.
     *
     * Attempts to find an order by its ID, ensuring it belongs to the currently authenticated user.
     * This method provides an additional layer of security by ensuring that users can only access
     * their own orders. If the order is found, it is passed to the view responsible for displaying
     * its details. If the order does not belong to the authenticated user or does not exist, this
     * method may not return the intended results, indicating the need for proper handling or redirection.
     *
     * @param int|string $id The ID of the order to retrieve.
     * @return \Illuminate\View\View Returns a view displaying the specified order, if it belongs to the authenticated user.
     */
    public function getMeOrderById($id)
    {
        $order = Order::find($id)
            ->where('user_id', Auth::id())
            ->first();
        return view('orders.show')->with('order', $order);
    }

    /**
     * Prepares to store a new order by displaying relevant information to the user.
     *
     * Fetches the current user based on their authenticated session and retrieves their addresses.
     * Also retrieves the current state of the shopping cart from the session. This method is designed
     * to provide the user with a summary of their cart items along with their addresses before finalizing
     * the order. It returns a view where the user can review their order and select an address for shipping.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View Returns a view with the cart items and user addresses for order finalization.
     */

    public function storeOrder(Request $request)
    {
        $user = User::find(Auth::id());
        $addresses = $user->addresses();
        $cart = Session::get('cart');
        return view('orders.store')->with('cart', $cart)->with('address', $addresses);
    }

    /**
     * Processes the return of an order by the customer.
     *
     * Attempts to find an order by its ID. If found, iterates through each order line associated with
     * the order, retrieving the product for each order line and replenishing the stock by the quantity
     * specified in the order line. After updating the stock for all products in the order, it deletes
     * the order to reflect its return. Redirects to the orders index page upon successful return processing.
     * If an error occurs during the process, it captures the exception, displays an error message, and redirects
     * back to the previous page. This method ensures that the stock levels are accurately restored and the order
     * is removed, simulating a return process.
     *
     * @param int|string $id The ID of the order to be returned.
     * @return \Illuminate\Http\RedirectResponse Redirects to the orders index route or back with an error message.
     */

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

    /**
     * Processes the return of an order by the authenticated user.
     *
     * Attempts to find an order by its ID that belongs to the currently authenticated user.
     * If found, iterates through each order line, replenishing the stock for each product based
     * on the quantity specified in the order line. After adjusting the stock levels, it deletes
     * the order to reflect its return. This method ensures that stock levels are correctly restored
     * and that users can only return their own orders, enhancing security and data integrity. Redirects
     * to the orders index page upon successful order return. In case of any exceptions, it captures the
     * error, displays an error message, and redirects back to the previous page.
     *
     * @param int|string $id The ID of the order to be returned by the authenticated user.
     * @return \Illuminate\Http\RedirectResponse Redirects to the orders index route or back with an error message.
     */

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

    /**
     * Deletes a specific order by ID.
     *
     * Attempts to find an order by its ID and deletes it from the database. This action is irreversible
     * and should be used with caution. Upon successful deletion, a flash message confirming the deletion
     * is displayed, and the user is redirected to the orders index route. If the order cannot be found
     * or if an error occurs during the deletion process, an error message is displayed, and the user is
     * redirected back to the previous page. This method ensures that specific orders can be removed
     * from the system when necessary, with appropriate feedback provided to the user.
     *
     * @param int|string $id The ID of the order to be deleted.
     * @return \Illuminate\Http\RedirectResponse Redirects to the orders index route with a flash message or back with an error.
     */

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

    /**
     * Deletes a specific order belonging to the authenticated user.
     *
     * Attempts to find an order by its ID that belongs to the currently authenticated user. If found,
     * the order is deleted from the database. This ensures that users can only delete their own orders,
     * maintaining privacy and security. Upon successful deletion, a flash message confirming the action
     * is displayed, and the user is redirected to the orders index route. If the order cannot be found,
     * or if an error occurs during the deletion process, an error message is displayed, and the user is
     * redirected back to the previous page. This method provides a secure way for users to manage and
     * remove their orders when necessary.
     *
     * @param int|string $id The ID of the order to be deleted by the authenticated user.
     * @return \Illuminate\Http\RedirectResponse Redirects to the orders index route with a flash message or back with an error.
     */

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
