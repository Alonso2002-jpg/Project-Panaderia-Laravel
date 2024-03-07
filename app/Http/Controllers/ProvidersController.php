<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Provider;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProvidersController extends Controller
{
    /**
     * Displays a paginated list of providers.
     *
     * Retrieves providers from the database, optionally filtered by the search query
     * provided in the request. Providers are ordered by ID in ascending order and paginated
     * to limit the number of providers displayed per page. Returns the providers index view,
     * passing the retrieved providers for display. This method allows users to view a list
     * of providers, facilitating navigation and provider discovery.
     *
     * @param \Illuminate\Http\Request $request The request containing optional search parameters.
     * @return \Illuminate\View\View Returns a view displaying the paginated list of providers.
     */

    public function index(Request $request)
    {
        $providers = Provider::filtrarProvider($request->search)->orderBy('id', 'asc')->paginate(3);
        return view('providers.index')->with('providers', $providers);
    }

    /**
     * Displays detailed information about a provider.
     *
     * Fetches the provider from the database based on its ID. If the provider is found in the cache,
     * it retrieves it from there; otherwise, it fetches it from the database. The retrieved provider
     * is then displayed in the provider show view. This method facilitates viewing detailed information
     * about a specific provider, providing insights into their services and offerings.
     *
     * @param int|string $id The ID of the provider to display.
     * @return \Illuminate\View\View Returns a view displaying detailed information about the provider.
     */

    public function show($id)
    {
        $provider = $this->getProvider($id);
        Cache::put($id, $provider, 300);
        return view('providers.show')->with('provider', $provider);
    }

    /**
     * Displays the form for creating a new provider.
     *
     * Returns the provider creation view, allowing users to input information
     * and create a new provider. This method facilitates the creation of new
     * providers by providing the necessary form for data entry.
     *
     * @return \Illuminate\View\View Returns a view displaying the form for creating a new provider.
     */

    public function create()
    {
        return view('providers.create');
    }

    /**
     * Stores a newly created provider in the database.
     *
     * Validates the incoming request data for creating a provider, ensuring it meets the
     * requirements for name uniqueness, NIF uniqueness, and telephone number format. If validation
     * passes, it creates a new provider instance with the provided data and saves it to the database.
     * A success flash message indicating the successful creation of the provider is displayed,
     * and the user is redirected to the providers index route. If any error occurs during the creation
     * process, an error flash message is displayed, and the user is redirected back to the previous page
     * with a message indicating the error. This method ensures proper validation and handling of provider creation.
     *
     * @param \Illuminate\Http\Request $request Contains the data for creating the provider.
     * @return \Illuminate\Http\RedirectResponse Redirects to the providers index route with a flash message or back with an error.
     */

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'min:3|max:120|required|unique:providers,name',
            'nif' => 'required|unique:providers,nif',
            'telephone' => 'min:9|max:9'
        ]);

        try {
            $provider = new Provider($request->all());
            $provider->save();
            flash('Provider ' . $provider->name . ' created successfully.')->success()->important();
            return redirect()->route('providers.index');
        } catch (Exception $e) {
            flash('Error creating the provider. ' . $e->getMessage())->error()->important();
            return redirect()->back();
        }
    }

    /**
     * Displays the form for editing an existing provider.
     *
     * Fetches the provider from the database based on its ID and displays
     * the provider edit view, allowing users to modify its information.
     * If the provider ID is 1, indicating it's a special provider that
     * cannot be updated, an error flash message is displayed, and the
     * user is redirected back. Otherwise, the provider edit view is
     * returned with the provider data for editing.
     *
     * @param int|string $id The ID of the provider to edit.
     * @return \Illuminate\View\View Returns a view for editing the provider or redirects back with an error.
     */

    public function edit($id)
    {
        if ($id != 1) {
            $provider = $this->getProvider($id);
            Cache::put('provider' . $id, $provider, 300);
            return view('providers.edit')
                ->with('provider', $provider);
        } else {
            flash('This Provider cannot be update')->error()->important();
            return redirect()->back();
        }
    }

    /**
     * Updates an existing provider in the database.
     *
     * Validates the incoming request data for updating a provider, ensuring it meets the
     * requirements for name uniqueness, NIF uniqueness, and telephone number format.
     * If the provider ID is 1, indicating it's a special provider that cannot be updated,
     * an error flash message is displayed, and the user is redirected back. Otherwise,
     * it updates the provider instance with the provided data and saves it to the database.
     * A success flash message indicating the successful update of the provider is displayed,
     * and the user is redirected to the providers index route. If any error occurs during the
     * update process, an error flash message is displayed, and the user is redirected back to
     * the previous page with a message indicating the error. This method ensures proper validation
     * and handling of provider updates.
     *
     * @param \Illuminate\Http\Request $request Contains the data for updating the provider.
     * @param int|string $id The ID of the provider to update.
     * @return \Illuminate\Http\RedirectResponse Redirects to the providers index route with a flash message or back with an error.
     */

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'min:3|max:120|required|unique:providers,name,' . $id,
            'nif' => 'min:3|max:120|required|unique:providers,nif,' . $id,
            'telephone' => 'min:9|max:9'
        ]);
        if ($id != 1) {
            try {
                $provider = $this->getProvider($id);
                $provider->update($request->all());
                $provider->save();
                Cache::forget('provider' . $id);
                flash('Provider ' . $provider->name . ' updated successfully.')->success()->important();
                return redirect()->route('providers.index');
            } catch (Exception $e) {
                flash('Error updating the provider' . $e->getMessage())->error()->important();
                return redirect()->back();
            }
        } else {
            flash('This Provider cannot be update')->error()->important();
            return redirect()->back();
        }
    }

    /**
     * Displays the form for editing the image of a provider.
     *
     * Fetches the provider from the database based on its ID and displays
     * the provider image edit view, allowing users to modify its image.
     * The provider image edit view is returned with the provider data for editing.
     *
     * @param int|string $id The ID of the provider whose image to edit.
     * @return \Illuminate\View\View Returns a view for editing the provider image.
     */


    public function editImage($id)
    {
        $provider = $this->getProvider($id);
        Cache::put('provider' . $id, $provider, 300);
        return view('providers.image')->with('provider', $provider);
    }

    /**
     * Updates the image of a provider.
     *
     * Validates the incoming request data to ensure it contains a valid image file.
     * If validation passes, it fetches the provider from the database based on its ID,
     * deletes the existing image file associated with the provider if it's not the default
     * image, uploads the new image file to the storage, updates the provider's image attribute
     * with the new file path, and saves the provider. The cache for the provider is cleared
     * to reflect the changes. A success flash message indicating the successful update of
     * the provider's image is displayed, and the user is redirected to the providers index route.
     * If any error occurs during the update process, an error flash message is displayed,
     * and the user is redirected back to the previous page with a message indicating the error.
     * This method ensures proper validation and handling of provider image updates.
     *
     * @param \Illuminate\Http\Request $request Contains the image file for updating the provider's image.
     * @param int|string $id The ID of the provider whose image to update.
     * @return \Illuminate\Http\RedirectResponse Redirects to the providers index route with a flash message or back with an error.
     */

    public function updateImage(Request $request, $id)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        try {
            $provider = $this->getProvider($id);
            if ($provider->image != Provider::$IMAGE_DEFAULT && Storage::exists('public/' . $provider->image)) {
                Storage::delete('public/' . $provider->image);
            }

            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $fileToSave = Str::uuid() . '.' . $extension;
            $provider->image = $image->storeAs('providers', $fileToSave, 'public');
            $provider->save();
            Cache::forget('provider' . $id);
            flash('Provider ' . $provider->name . ' updated successfully.')->warning()->important();
            return redirect()->route('providers.index');
        } catch (Exception $e) {
            flash('Error updating the provider' . $e->getMessage())->error()->important();
            return redirect()->back();
        }
    }

    /**
     * Deletes a provider.
     *
     * Validates the provider ID to ensure it's not the default provider ID (1).
     * If validation passes, it attempts to delete the provider and its associated products.
     * If the provider has a custom image (not the default image) stored in the storage,
     * the image file is deleted. After deletion, the cache for the provider is cleared,
     * and a success flash message indicating the successful deletion of the provider
     * is displayed. The user is then redirected to the providers index route.
     * If any error occurs during the deletion process, an error flash message is displayed,
     * and the user is redirected back to the previous page with a message indicating the error.
     * This method ensures proper validation and handling of provider deletion.
     *
     * @param int|string $id The ID of the provider to delete.
     * @return \Illuminate\Http\RedirectResponse Redirects to the providers index route with a flash message or back with an error.
     */


    public function destroy($id)
    {
        if ($id != 1) {
            try {
                $provider = $this->getProvider($id);
                Provider::changeProductsProviderToNotProvider($id);
                if ($provider->image != Provider::$IMAGE_DEFAULT && Storage::exists('public/' . $provider->image)) {
                    Storage::delete('public/' . $provider->image);
                }
                $provider->delete();
                Cache::forget('provider' . $id);
                flash('Provider ' . $provider->name . ' deleted successfully.')->error()->important();
                return redirect()->route('providers.index');
            } catch (Exception $e) {
                flash('Error deleting the provider' . $e->getMessage())->error()->important();
                return redirect()->back();
            }
        } else {
            flash('This Provider cannot be deleted')->error()->important();
            return redirect()->back();
        }
    }

    private function getProvider($id){
        return Cache::has('provider' . $id) ? Cache::get('provider' . $id) : Provider::find($id);
    }
}
