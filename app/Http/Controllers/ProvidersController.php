<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use Exception;
use Illuminate\Http\Request;

class ProvidersController extends Controller
{
    public function index(Request $request){
        $providers = Provider::filtrarProvider($request->search)->orderBy('id', 'asc')->paginate(3);
        return view('providers.index')->with('providers', $providers);
    }

    public function show($id){
        $provider = Provider::find($id);
        return view('providers.show')->with('provider', $provider);
    }

    public function create(){
        return view('providers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'min:3|max:120|required|unique:providers,name',
            'nif' => 'required|unique:providers,nif|regex:/^[A-Zz-A]{8}\d{1}$/',
            'telephone' => 'required|regex:/^(6|7|8|9)\d{8}$/'
        ]);

        try{
            $provider = new Provider($request->all());
            $provider->save();
            flash('Provider ' . $provider->name . ' created successfully.')->success()->important();
            return redirect()->route('providers.index');
        } catch (Exception $e){
            flash('Error creating the provider. '. $e->getMessage())->error()->important();
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        if($id != 1){
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
            'nif' => 'required|regex:/^[A-Zz-A]{8}\d{1}$/|unique:providers,nif,' . $id,
            'telephone' => 'required|regex:/^(6|7|8|9)\d{8}$/'
        ]);
        if($id != 1){
            try {
                $provider = Provider::find($id);
                $provider->update($request->all());
                $provider->save();
                flash('Provider ' . $provider->name . ' updated successfully.')->warning()->important();
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


    public function destroy($id)
    {
        if ($id != 1) {
            try {
                $provider = Provider::find($id);
                Provider::changeProductsProviderToNotProvider($id);
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
