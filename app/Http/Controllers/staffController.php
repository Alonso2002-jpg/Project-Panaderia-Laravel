<?php

namespace App\Http\Controllers;

use App\Http\Requests\staffRequest;
use App\Models\staff;
use Exception;
use Illuminate\Http\Request;
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

        return view('personal.index')->with('personal', $personal);
    }

    public function show($id)
    {
        $staff = staff::find($id);
        return vie('staff.show')->with('staff', $staff);
    }

    public function destroy(staff $staff)
    {
        if ($staff->staff()->exists()) {
            Session::flash('error', 'No se puede eliminar el personal');
        } else {
            try {
                $staff->update(['isDelete' => true]);
                Session::flash('success', 'Personal eliminado con éxito.');
            } catch (\Exception $e) {
                Session::flash('error', 'Error al eliminar el personal: ' . $e->getMessage());
            }
        }
        return redirect()->route('staff.index');
    }

    public function update(staffRequest $request, $id)
    {
        $staff = staff::find($id);
        if (!$staff) {
            return redirect()->back();
        }
        $validatedData = $request->validated([
            'uuid' => 'required|string',
            'name' => 'required|string',
            'dni' => 'required|string',
            'lastname' => 'required|string',
            'startDate' => 'required|date',
            'endDate' => 'required|date',
            'updateDate' => 'required|date',
            'creationDate' => 'required|date',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        try {
            if ($request->hasFile('image')) {
                if ($staff->image != staff::$IMAGE_DEFAULT && Storage::exists($staff->image)) {
                    Storage::delete($staff->image);
                }
                $staff->image = $request->file('image')->store('public/staff');
            }
            $staff->update($validatedData);
            return redirect()->route('staff.index');
        } catch (Exception $e) {
            return redirect()->back();
        }
    }

    public function store(staffRequest $request)
    {
        $validatedData = $request->validated([
            'uuid' => 'required|string',
            'name' => 'required|string',
            'dni' => 'required|string',
            'lastname' => 'required|string',
            'startDate' => 'required|date',
            'endDate' => 'required|date',
            'updateDate' => 'required|date',
            'creationDate' => 'required|date',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $staff = new staff($validatedData);
        if ($request->hasFile('image')) {
            $staff->image = $request->file('image')->store('public/staff');
        }
        $staff->save();
        return redirect()->route('staff.index');
    }


    // funcion para recuperar el personal el cual esta eliminado de manera  logica
    public function recover($id)
    {
        $staff = staff::findOrFail($id);
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
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        try {
            $staff = staff::find($id);
            if ($staff->image != staff::$IMAGE_DEFAULT && Storage::exists($staff->image)) {
                Storage::delete('public/' . $staff->image);
            }
            $imagen = $request->file('imagen');
            $extension = $imagen->getClientOriginalExtension();
            $fileToSave = Str::uuid() . '.' . $extension;
            $staff->image = $imagen->storeAs('staff', $fileToSave, 'public');
            $staff->save();
            flash('Personal ' . $staff->name . ' actualizado con éxito')->warning()->important();
            return redirect()->route('staff.index');
        } catch (Exception $e) {
            flash('error', 'Error al actualizar el personal' . $e->getMessage());
            return redirect()->back();
        }
    }
}
