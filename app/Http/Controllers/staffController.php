<?php

namespace App\Http\Controllers;

use App\Models\staff;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class staffController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->input('search');
        $personal = staff::query();

        if ($search) {
            $personal = $personal->where('name', 'LIKE', "%$search%");
            if (in_array('descripcion', staff::getFillable())) {
                $personal = $personal->orWhere('descripcion', 'LIKE', "%$search%");
            }
        }
        if (Schema::hasColumn('staff', 'id')) {
            $personal = $personal->orderBy('id', 'asc');
        }
        $personal = $personal->paginate(3);

        return view('staff.index')->with('personal', $personal);
    }

    public function show($id)
    {
        $staff = staff::find($id);
        return view('staff.show')->with('staff', $staff);

    }

    public function destroy($id)
    {
        try {
            $staff = staff::find($id);

            if (!$staff) {
                Session::flash('error', 'Personal no encontrado.');
                return redirect()->back();
            }


            if ($staff->image != 'https://via.placeholder.com/150' && Storage::exists('public/' . $staff->image)) {
                Storage::delete('public/' . $staff->image);
            }

            $staff->isDelete = true;
            $staff->endDate = Carbon::now();
            $staff->save();
            Session::flash('success', 'Personnel successfully eliminated.');

        } catch (\Exception $e) {
            Session::flash('error', 'Error when deleting staff: ' . $e->getMessage());
            return redirect()->back();
        }

        return redirect()->route('staff.index');
    }

    public function update(Request $request, $id)
    {
        $staff = staff::find($id);
        if (!$staff) {
            return redirect()->back();

        }

        $validatedData = $request->validate([
            'name' => 'required|string',
            'dni' => 'required|string|unique:staff,dni',
            'email' => 'required|string|email|unique:staff,email',
            'lastname' => 'required|string',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'role' => 'required|string',
        ]);

        try {
            if ($request->hasFile('image')) {
                if ($staff->image != staff::$IMAGE_DEFAULT && Storage::exists('public/' . $staff->image)) {
                    Storage::delete('public/' . $staff->image);
                }
                $validatedData['image'] = $request->file('image')->store('public/staff');
            }

            $staff->update($validatedData);
            return redirect()->route('staff.index');

        } catch (Exception $e) {
            return redirect()->back();

        }
    }


    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string',
            'dni' => 'required|string|unique:staff,dni',
            'email' => 'required|string|email|unique:staff,email',
            'lastname' => 'required|string',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'role' => 'required|string',
        ]);


        $staff = new staff($request->all());
        $staff->id = (string)Str::uuid();
        $staff->startDate = Carbon::now();
        $staff->isDelete = false;
        $staff->endDate = null;
        if ($request->hasFile('image')) {
            $staff->image = $request->file('image')->store('public/staff');
        } else {
            
            $staff->image = staff::$IMAGE_DEFAULT;
        }

        $staff->save();
        Session::flash('success', 'Personal ' . $staff->name . ' successfully created');
        return redirect()->route('staff.index');
    }


    public function recover($id)
    {
        $staff = staff::find($id);
        $staff->isDelete = false;
        $staff->save();

        return redirect()->route('staff.index');
    }

    public function edit($id)
    {
        $staff = staff::findOrFail($id);
        return view('staff.edit')->with('staff', $staff);
    }

    public function create()
    {
        return view('staff.create');

    }

    public function editImage($id)
    {
        $staff = staff::find($id);
        return view('staff.image')->with('staff', $staff);
    }

    public function updateImage(Request $request, $id)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        try {
            $staff = staff::find($id);
            if ($staff->image != staff::$IMAGE_DEFAULT && Storage::exists('public/' . $staff->image)) {
                Storage::delete('public/' . $staff->image);
            }
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $fileToSave = Str::uuid() . '.' . $extension;
            $staff->image = $image->storeAs('staff', $fileToSave, 'public');
            $staff->save();
            flash('Personal ' . $staff->name . ' successfully updated
')->success()->important();
            return redirect()->route('staff.index');
        } catch (Exception $e) {
            flash('error', 'Error updating personnel' . $e->getMessage())->error()->important();
            return redirect()->back();
        }
    }
}
