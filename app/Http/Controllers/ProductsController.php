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
    /**
     * Displays a paginated list of products, optionally filtered and sorted.
     *
     * Retrieves products from the database, applying filters based on the search term, category,
     * and provider if provided in the request. Additionally, allows sorting of products by a specified
     * field in either ascending or descending order. The number of products per page can also be customized
     * through the request. Along with the filtered and sorted products, it fetches all categories and
     * providers for filter dropdowns in the UI. Returns the products index view, passing the products,
     * categories, and providers for display and further filtering.
     *
     * @param \Illuminate\Http\Request $request Contains optional filters (search term, category, provider),
     *        sorting parameters (field and order), and pagination settings.
     * @return \Illuminate\View\View Returns a view with the filtered, sorted, and paginated list of products,
     *         along with all categories and providers for filtering.
     */

    public function index(Request $request)
    {
        $products = Product::filtrar($request->search, $request->category, $request->provider)->orderBy($request->orderBy ?? 'id', $request->order ?? 'asc')->paginate($request->paginate ?? 5);
        $categories = Category::all();
        $providers = Provider::all();
        return view('products.index')->with('products', $products)
            ->with('categories', $categories)
            ->with('providers', $providers);
    }

    public function products()
    {
        $products = Product::orderBy('id', 'asc')->paginate(5);
        return view('products.gestion')->with('products', $products);
    }

    /**
     * Adds a specified quantity of a product to the shopping cart.
     *
     * First, it attempts to find the product by its ID. It then validates the requested stock quantity
     * against the available stock of the product to ensure the request can be fulfilled. If validation
     * passes, it retrieves the current shopping cart from the session or initializes it if it doesn't exist.
     * It updates the total items count in the cart by adding the requested stock quantity. A new cart item
     * is created with the product's ID and the requested quantity, which is then added to the cart. The updated
     * cart and total items count are saved back to the session. A success flash message is displayed, indicating
     * the product has been added to the cart, and the user is redirected back to the previous page. If any error
     * occurs during this process, an error flash message is displayed, and the user is redirected back.
     *
     * @param \Illuminate\Http\Request $request Contains the stock quantity to be added to the cart.
     * @param int|string $id The ID of the product to add to the cart.
     * @return \Illuminate\Http\RedirectResponse Redirects back with a flash message indicating success or failure.
     */

    public function addToCart(Request $request, $id)
    {
        try {
            $product = $this->getProduct($id);
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
            Cache::put($id, $product, 300);
            flash($request->stock . ' ' . $product->name . ' added to cart.')->success()->important();
            return redirect()->back();
        } catch (Exception $e) {
            flash('Error adding ' . $product->name . ' to cart.' . $e->getMessage())->error()->important();
            return redirect()->back();
        }
    }

    /**
     * Displays details of a specific product, along with related products.
     *
     * Checks if the product details are already cached using the product's ID. If not, it fetches the
     * product from the database. It then retrieves related products from the same category as the viewed
     * product, excluding the viewed product itself. The viewed product is cached for future requests to
     * reduce database load. Returns the product details view, passing the product and its related products
     * for display. This approach enhances user experience by providing suggestions for similar products.
     *
     * @param int|string $id The ID of the product to display.
     * @return \Illuminate\View\View Returns a view displaying the product details and related products.
     */

    public function show($id)
    {
        $product = $this->getProduct($id);
        $relatedProducts = Product::where('category_id', '=', $product->category_id)->where('id', "<>", $id)->get();
        Cache::put($id, $product, 300);
        return view('products.show')->with('product', $product)->with('relatedProducts', $relatedProducts);
    }

    /**
     * Displays the form for creating a new product.
     *
     * Fetches categories and providers from the database, excluding those with an ID of 1,
     * potentially to avoid using a default or generic category/provider. This ensures that
     * users are presented with relevant categories and providers when creating a new product.
     * Returns the product creation view, passing the filtered categories and providers for
     * selection in the product form. This method facilitates the addition of new products to
     * the inventory by providing the necessary data for product categorization and sourcing.
     *
     * @return \Illuminate\View\View Returns a view with the form for creating a new product,
     *         including lists of categories and providers for selection.
     */

    public function create()
    {
        $categories = Category::where('id', '<>', 1)->get();
        $providers = Provider::where('id', '<>', 1)->get();
        return view('products.create')->with('categories', $categories)->with('providers', $providers);
    }

    /**
     * Displays a paginated list of products filtered by category.
     *
     * Retrieves products from the database filtered by the specified category ID.
     * The products are ordered by ID in ascending order and paginated to limit the number
     * of products displayed per page. Returns the products index view, passing the filtered
     * products for display. This method allows users to view products belonging to a specific
     * category, improving navigation and product discovery.
     *
     * @param int|string $id The ID of the category by which to filter the products.
     * @return \Illuminate\View\View Returns a view displaying the filtered products.
     */

    public function getProductsByCategory($id)
    {
        $products = Product::where('category_id', "=", $id)->orderBy('id', 'asc')->paginate(5);
        return view('products.index')->with('products', $products);
    }

    /**
     * Stores a new product in the database.
     *
     * Validates the incoming request data for creating a product, including its name, description,
     * price, stock, category, and provider. If validation passes, it attempts to create a new product
     * with the provided data. If successful, a success flash message is displayed, indicating the product
     * has been created, and the user is redirected to the products index route. If any error occurs during
     * the creation process, an error flash message is displayed, and the user is redirected back to the
     * previous page with a message indicating the error. This method ensures proper validation and handling
     * of errors during the product creation process.
     *
     * @param \Illuminate\Http\Request $request Contains the data needed for creating the product.
     * @return \Illuminate\Http\RedirectResponse Redirects to the products index route with a flash message or back with an error.
     */

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

        try {
            $product = new Product($request->all());
            $product->id = Str::uuid();
            $product->category_id = $request->category ?? 1;
            $product->provider_id = $request->provider ?? 1;
            $product->save();
            flash('Product ' . $product->name . ' created successfully.')->success()->important();
            return redirect()->route('products.index');
        } catch (Exception $e) {
            flash('Error creating the product. ' . $e->getMessage())->error()->important();
            return redirect()->back();
        }
    }

    /**
     * Displays the form for editing an existing product.
     *
     * Fetches the product from the database based on its ID. Also retrieves categories and providers
     * from the database, excluding those with an ID of 1, potentially to avoid using a default or generic
     * category/provider. Returns the product edit view, passing the product along with lists of categories
     * and providers for selection in the product form. This method facilitates the editing of existing products
     * by providing the necessary data for product categorization and sourcing.
     *
     * @param int|string $id The ID of the product to edit.
     * @return \Illuminate\View\View Returns a view with the form for editing an existing product,
     *         including lists of categories and providers for selection.
     */

    public function edit($id)
    {
        $product = $this->getProduct($id);
        $categories = Category::where('id', '<>', 1)->get();
        $providers = Provider::where('id', '<>', 1)->get();
        Cache::put($id, $product, 300);
        return view('products.edit')
            ->with('product', $product)
            ->with('category', $categories)
            ->with('provider', $providers);
    }

    /**
     * Updates an existing product in the database.
     *
     * Validates the incoming request data for updating a product, including its name, description,
     * price, stock, category, and provider. If validation passes, it attempts to find the product
     * by its ID and updates its attributes with the provided data. If successful, the product is saved
     * to the database, and any associated cached data is removed. It also updates the shopping cart
     * to reflect changes in the product's stock if necessary. Finally, a flash message indicating the
     * successful update is displayed, and the user is redirected to the products index route. If any error
     * occurs during the update process, an error flash message is displayed, and the user is redirected back
     * to the previous page with a message indicating the error. This method ensures proper validation,
     * updating, and handling of errors during the product update process.
     *
     * @param \Illuminate\Http\Request $request Contains the data needed for updating the product.
     * @param int|string $id The ID of the product to update.
     * @return \Illuminate\Http\RedirectResponse Redirects to the products index route with a flash message or back with an error.
     */

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
            $product = $this->getProduct($id);
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

    /**
     * Displays the form for editing the image of a product.
     *
     * Fetches the product from the database based on its ID. Returns the product image edit view,
     * passing the product for display. This method facilitates the editing of a product's image by
     * providing the necessary data for image replacement.
     *
     * @param int|string $id The ID of the product for which to edit the image.
     * @return \Illuminate\View\View Returns a view with the form for editing the product's image.
     */

    public function editImage($id)
    {
        $product = $this->getProduct($id);
        Cache::put($id, $product, 300);
        return view('products.image')->with('product', $product);
    }

    /**
     * Updates the image of a product in the database.
     *
     * Validates the incoming request data for updating the product's image, ensuring it meets the
     * requirements for an image file. If validation passes, it attempts to find the product by its ID
     * and updates its image attribute with the provided image file. If successful, the updated product
     * is saved to the database, and any associated cached data is removed. A success flash message indicating
     * the successful image update is displayed, and the user is redirected to the products index route.
     * If any error occurs during the image update process, an error flash message is displayed, and the user
     * is redirected back to the previous page with a message indicating the error. This method ensures proper
     * validation, updating, and handling of errors during the product image update process.
     *
     * @param \Illuminate\Http\Request $request Contains the image file for updating the product's image.
     * @param int|string $id The ID of the product whose image is to be updated.
     * @return \Illuminate\Http\RedirectResponse Redirects to the products index route with a flash message or back with an error.
     */

    public function updateImage(Request $request, $id)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        try {
            $product = $this->getProduct($id);
            if ($product->image != Product::$IMAGE_DEFAULT && Storage::exists('public/' . $product->image)) {
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
        } catch (Exception $e) {
            flash('Error updating the product' . $e->getMessage())->error()->important();
            return redirect()->back();
        }
    }

    /**
     * Deletes a product from the database.
     *
     * Attempts to find the product by its ID and deletes it from the database. If the product has an associated
     * image and it is not the default image, the image file is also deleted from storage. Additionally, the product
     * is removed from any active sessions or carts to ensure consistency. A success flash message indicating the
     * successful deletion of the product is displayed, and the user is redirected to the products index route.
     * If any error occurs during the deletion process, an error flash message is displayed, and the user is redirected
     * back to the previous page with a message indicating the error. This method ensures proper handling of product
     * deletion, including the removal of associated images and updates to active sessions or carts.
     *
     * @param int|string $id The ID of the product to delete.
     * @return \Illuminate\Http\RedirectResponse Redirects to the products index route with a flash message or back with an error.
     */

    public function destroy($id)
    {
        try {
            $product = $this->getProduct($id);
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

    private function getProduct($id){
        return Cache::has($id) ?  Cache::get($id) : Product::find($id);
    }
}
