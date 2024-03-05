<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProvidersController extends Controller
{
    public function index(Request $request)
    {
        $providers = Provider::filtrarProvider($request->search)->orderBy('id', 'asc')->paginate(3);
        return view('providers.index')->with('providers', $providers);
    }

    public function show($id)
    {
        $provider = Provider::find($id);
        return view('providers.show')->with('provider', $provider);
    }

    public function create()
    {
        return view('providers.create');
    }

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

    public function edit($id)
    {
        if ($id != 1) {
            $provider = Provider::find($id);
            return view('providers.edit')
                ->with('provider', $provider);
        } else {
            flash('This Provider cannot be update')->error()->important();
            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'min:3|max:120|required|unique:providers,name,' . $id,
            'nif' => 'min:3|max:120|required|unique:providers,nif,' . $id,
            'telephone' => 'min:9|max:9'
        ]);
        if ($id != 1) {
            try {
                $provider = Provider::find($id);
                $provider->update($request->all());
                $provider->save();
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


    public function editImage($id)
    {
        $provider = Provider::find($id);
        return view('providers.image')->with('provider', $provider);
    }

    public function updateImage(Request $request, $id)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        try {
            $provider = Provider::find($id);
            if ($provider->image != Provider::$IMAGE_DEFAULT && Storage::exists('public/' . $provider->image)) {
                Storage::delete('public/' . $provider->image);
            }

            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $fileToSave = Str::uuid() . '.' . $extension;
            $provider->image = $image->storeAs('providers', $fileToSave, 'public');
            $provider->save();
            flash('Provider ' . $provider->name . ' updated successfully.')->warning()->important();
            return redirect()->route('providers.index');
        } catch (Exception $e) {
            flash('Error updating the provider' . $e->getMessage())->error()->important();
            return redirect()->back();
        }
    }


    public function destroy($id)
    {
        if ($id != 1) {
            try {
                $provider = Provider::find($id);
                Provider::changeProductsProviderToNotProvider($id);
                if ($provider->image != Provider::$IMAGE_DEFAULT && Storage::exists('public/' . $provider->image)) {
                    Storage::delete('public/' . $provider->image);
                }
                $provider->delete();
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
}
