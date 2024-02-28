<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function getAddresses(){
        $addresses = Address::all();
        return view('addresses.index')->with('addresses', $addresses);
    }

    public function getMeAddresses(){
        $addresses = Address::where('user_id', Auth::user()->id)->get();
        return view('addresses.index')->with('addresses', $addresses);
    }

    public function getAddressById($id){
        $address = Address::where('id', $id)->get();
        return view('address.show')->with('address', $address);
    }

    public function getMeAddressById($id){
        $address = Address::where('id', $id)
            ->where('user_id', Auth::user()->id)
            ->first();
        return view('address.show')->with('address', $address);
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
}
