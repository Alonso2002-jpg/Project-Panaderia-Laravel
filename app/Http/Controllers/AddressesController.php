<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressesController extends Controller
{
    public function getAddresses()
    {
        $addresses = Address::all();
        return view('addresses.index')->with('addresses', $addresses);
    }

    public function getMeAddresses()
    {
        $addresses = Address::where('user_id', Auth::id())->get();
        return view('addresses.index')->with('addresses', $addresses);
    }

    public function getAddressById($id)
    {
        $address = Address::find($id);
        return view('address.show')->with('address', $address);
    }

    public function getMeAddressById($id)
    {
        $address = Address::find($id)
            ->where('user_id', Auth::id())
            ->first();
        return view('address.show')->with('address', $address);
    }

    public function createAddress()
    {
        return view('addresses.create');
    }

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
            flash('New address created successfully.')->success()->important();
            return redirect()->route('addresses.index');
        } catch (Exception $e) {
            flash('Error creating the address. ' . $e->getMessage())->error()->important();
            return redirect()->back();
        }
    }


    public function editMeAddress($id)
    {
        $address = Address::find($id)->where('user_id', Auth::id())->first();
        return view('addresses.edit')->with('address', $address);
    }

    public function editAddress($id)
    {
        $address = Address::find($id)->first();
        return view('addresses.edit')->with('address', $address);
    }

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
            flash('Address updated successfully.')->warning()->important();
            return redirect()->route('addresses.index');
        } catch (Exception $e) {
            flash('Error updating the address' . $e->getMessage())->error()->important();
            return redirect()->back();
        }
    }

    public function destroyAddress($id)
    {
        try {
            $address = Address::find($id);
            $address->delete();
            flash('Address ' . $address->id . ' deleted successfully.')->error()->important();
            return redirect()->route('addresses.index');
        } catch (Exception $e) {
            flash('Error deleting the address' . $e->getMessage())->error()->important();
            return redirect()->back();
        }
    }

    public function destroyMeAddress($id)
    {
        try {
            $address = Address::find($id)
                ->where('user_id', Auth::id())
                ->first();
            $address->delete();
            flash('Address ' . $address->id . ' deleted successfully.')->error()->important();
            return redirect()->route('addresses.index');
        } catch (Exception $e) {
            flash('Error deleting the address' . $e->getMessage())->error()->important();
            return redirect()->back();
        }
    }
}
