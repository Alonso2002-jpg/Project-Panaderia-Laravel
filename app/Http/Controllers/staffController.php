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

        //    return view('personal.index')->with('personal', $personal);
        return response()->json(['personal' => $personal]);
    }

    public function show($id)
    {
        $staff = staff::find($id);
        //    return view('staff.show')->with('staff', $staff);
        return response()->json(['staff' => $staff]);

    }

    public function destroy($id)
    {
        try {
            $staff = Staff::find($id);

            if (!$staff) {
                Session::flash('error', 'Personal no encontrado.');
                //   return redirect()->back();
                return response()->json(['message' => 'Personal no encontrado'], 404);
            }


            if ($staff->image != 'ruta/a/imagen_por_defecto.jpg' && Storage::exists('public/' . $staff->image)) {
                Storage::delete('public/' . $staff->image);
            }

            $staff->isDelete = true;
            $staff->endDate = Carbon::now();
            $staff->save();
            Session::flash('success', 'Personal eliminado con éxito.');

        } catch (\Exception $e) {
            Session::flash('error', 'Error al eliminar el personal: ' . $e->getMessage());
            // return redirect()->back();
            return response()->json(['message' => 'Error al eliminar el personal: ' . $e->getMessage()], 400);
        }

        // return redirect()->route('staff.index');
        return response()->json(['staff' => $staff]);
    }

    public function update(Request $request, $id)
    {
        $staff = staff::find($id);
        if (!$staff) {
            // return redirect()->back();

            return response()->json(['message' => 'Personal no encontrado'], 404);
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
            //   return redirect()->route('staff.index');

            return response()->json(['staff' => $staff]);
        } catch (Exception $e) {
            // return redirect()->back();

            return response()->json(['message' => 'Error al actualizar el personal: ' . $e->getMessage()], 400);
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

        return response()->json([$staff]);
        //   return redirect()->route('staff.index');
    }


    // funcion para recuperar el personal el cual esta eliminado de manera  logica
    public function recover($id)
    {
        $staff = staff::find($id);
        $staff->isDelete = false;
        $staff->save();

        // return redirect()->route('staff.index');
        return response()->json(['staff' => $staff]);
    }

    public function edit($id)
    {
        $staff = staff::findOrFail($id);
        return view('staff.edit')->with('staff', $staff);
    }

    public function create()
    {
        // return view('staff.create');
        return response()->json(['staff' => new staff()]);
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
