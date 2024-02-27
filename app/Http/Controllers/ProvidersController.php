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
            return redirect()->route('products.index');
        } catch (Exception $e){
            flash('Error creating the provider. '. $e->getMessage())->error()->important();
            return redirect()->back();
        }
    }


}
