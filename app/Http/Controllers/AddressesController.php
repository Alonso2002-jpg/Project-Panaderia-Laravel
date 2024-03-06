<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class AddressesController extends Controller
{
    /**
     * AddressesController constructor.
     * @param Address $address
     * @param Request $request
     * @param Auth $auth
     * @param Cache $cache
     * @return void
     * @throws Exception
     */
    public function getAddresses()
    {
        if (Cache::has('addresses')) {
            $addresses = Cache::get('addresses');
        } else {
            $addresses = Address::all();
        }
        Cache::put('addresses', $addresses, 300);
        return view('addresses.index')->with('addresses', $addresses);
    }

    /**
     * Retrieves the addresses associated with the authenticated user.
     *
     * This method fetches all the addresses linked to the currently authenticated user
     * in the system and passes them to the view for display. It utilizes the `Address`
     * model to search the database for addresses corresponding to the `user_id` of the
     * authenticated user.
     *
     * @return \Illuminate\View\View Returns a view with the user's addresses.
     */

    public function getMeAddresses()
    {
        $addresses = Address::where('user_id', Auth::id())->get();
        return view('addresses.index')->with('addresses', $addresses);
    }

    /**
     * Retrieves an address by its ID.
     *
     * This method checks if the address with the specified ID is already cached. If it is,
     * the cached address is retrieved. If not, it fetches the address from the database using
     * the Address model. After retrieving the address, it caches the address for future requests
     * for 300 seconds (5 minutes) to reduce database load. Finally, it returns a view displaying
     * the address.
     *
     * @param int|string $id The ID of the address to retrieve.
     * @return \Illuminate\View\View Returns a view with the address data.
     */
    public function getAddressById($id)
    {
        if (Cache::has('address' . $id)) {
            $address = Cache::get('address' . $id);
        } else {
            $address = Address::find($id);
        }
        Cache::put('address' . $id, $address, 300);
        return view('address.show')->with('address', $address);
    }

    /**
     * Retrieves the address of the authenticated user by address ID.
     *
     * @param int|string $id The ID of the address to be retrieved.
     * @return \Illuminate\View\View Returns a view displaying the specified address if it belongs to the authenticated user.
     */

    public function getMeAddressById($id)
    {
        $address = Address::find($id)
            ->where('user_id', Auth::id())
            ->first();
        return view('address.show')->with('address', $address);
    }

    /**
     * Displays the form for creating a new address.
     *
     * @return \Illuminate\View\View Returns a view with the form to create a new address.
     */
    public function createAddress()
    {
        return view('addresses.create');
    }

    /**
     * Stores a new address for the authenticated user.
     *
     * Validates the incoming request data for address creation. If the validation passes,
     * a new Address instance is created with the request data, associated with the authenticated
     * user's ID, and saved to the database. The addresses cache is then cleared to reflect the
     * new addition. On successful creation, redirects to the addresses index route with a success
     * flash message. If an error occurs during creation, redirects back with an error flash message.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse Redirects to the appropriate view with flash message.
     */
    public function storeMeAddress(Request $request)
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

        try {
            $address = new Address($request->all());
            $address->user_id = Auth::id();
            $address->save();
            Cache::forget('addresses');
            flash('New address created successfully.')->success()->important();
            return redirect()->route('addresses.index');
        } catch (Exception $e) {
            flash('Error creating the address. ' . $e->getMessage())->error()->important();
            return redirect()->back();
        }
    }

    /**
     * Displays the edit form for a specific address of the authenticated user.
     *
     * Finds the address by ID, ensuring it belongs to the currently authenticated user.
     * If found, returns the edit view with the address data for editing. This ensures that
     * users can only edit their own addresses.
     *
     * @param int|string $id The ID of the address to be edited.
     * @return \Illuminate\View\View Returns a view for editing the specified address.
     */
    public function editMeAddress($id)
    {
        $address = Address::find($id)->where('user_id', Auth::id())->first();
        return view('addresses.edit')->with('address', $address);
    }

    /**
     * Displays the edit form for a specific address.
     *
     * Finds the address by its ID and returns the edit view with the address data
     * for editing. This method does not restrict editing based on the user, so it should
     * be used with caution and proper authorization checks should be implemented elsewhere
     * to ensure data security.
     *
     * @param int|string $id The ID of the address to be edited.
     * @return \Illuminate\View\View Returns a view for editing the specified address.
     */

    public function editAddress($id)
    {
        $address = Address::find($id)->first();
        return view('addresses.edit')->with('address', $address);
    }

    /**
     * Updates the specified address of the authenticated user.
     *
     * Validates the incoming request data for address updating. If validation passes,
     * it attempts to find and update the address belonging to the authenticated user with
     * the provided ID. The method ensures that only the owner of the address can update it.
     * Upon successful update, it clears the relevant caches and redirects to the addresses index
     * route with a success flash message. If any error occurs during the update, it redirects back
     * with an error flash message.
     *
     * @param \Illuminate\Http\Request $request
     * @param int|string $id The ID of the address to be updated.
     * @return \Illuminate\Http\RedirectResponse Redirects to the appropriate view with flash message.
     */
    public function updateMeAddress(Request $request, $id)
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

        try {
            $address = Address::find($id)->where('user_id', Auth::id())->first();
            $address->update($request->all());
            Cache::forget('address' . $id);
            Cache::forget('addresses');
            flash('Address updated successfully.')->warning()->important();
            return redirect()->route('addresses.index');
        } catch (Exception $e) {
            flash('Error updating the address' . $e->getMessage())->error()->important();
            return redirect()->back();
        }
    }

    /**
     * Deletes a specific address.
     *
     * Attempts to find and delete the address with the provided ID. Upon successful deletion,
     * it clears the relevant caches to ensure the system reflects the absence of the deleted address.
     * Redirects to the addresses index route with a success flash message indicating the address has been
     * deleted. If an error occurs during the deletion process, redirects back with an error flash message.
     *
     * @param int|string $id The ID of the address to be deleted.
     * @return \Illuminate\Http\RedirectResponse Redirects to the appropriate view with flash message.
     */
    public function destroyAddress($id)
    {
        try {
            $address = Address::find($id);
            $address->delete();
            Cache::forget('address' . $id);
            Cache::forget('addresses');
            flash('Address ' . $address->id . ' deleted successfully.')->error()->important();
            return redirect()->route('addresses.index');
        } catch (Exception $e) {
            flash('Error deleting the address' . $e->getMessage())->error()->important();
            return redirect()->back();
        }
    }

    /**
     * Deletes a specific address belonging to the authenticated user.
     *
     * Finds and deletes the address with the provided ID that belongs to the authenticated user.
     * Upon successful deletion, it clears relevant caches to reflect the change. Redirects to the
     * addresses index route with a success flash message indicating the address has been deleted.
     * If an error occurs during the deletion process, or if the address does not belong to the authenticated
     * user, redirects back with an error flash message.
     *
     * @param int|string $id The ID of the address to be deleted.
     * @return \Illuminate\Http\RedirectResponse Redirects to the appropriate view with flash message.
     */
    public function destroyMeAddress($id)
    {
        try {
            $address = Address::find($id)
                ->where('user_id', Auth::id())
                ->first();
            $address->delete();
            Cache::forget('address' . $id);
            Cache::forget('addresses');
            flash('Address ' . $address->id . ' deleted successfully.')->error()->important();
            return redirect()->route('addresses.index');
        } catch (Exception $e) {
            flash('Error deleting the address' . $e->getMessage())->error()->important();
            return redirect()->back();
        }
    }
}
