<?php

namespace App\Http\Controllers;

use App\Models\staff;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class staffController extends Controller
{
    /**
     * Displays a paginated list of staff members based on search criteria.
     *
     * Retrieves the search query from the request input.
     * Constructs a query to search for staff members based on their name and description (if available).
     * If a search query is provided, filters the staff members by name or description containing the search query.
     * Orders the staff members by their ID in ascending order if the 'id' column exists in the 'staff' table schema.
     * Paginates the filtered staff members with a pagination limit of 3 records per page.
     * Renders the 'staff.index' view, passing the paginated staff members to the view.
     *
     * @param \Illuminate\Http\Request $request The HTTP request instance.
     * @return \Illuminate\View\View Renders the 'staff.index' view with paginated staff members.
     */

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

    /**
     * Displays the details of a specific staff member.
     *
     * Finds the staff member with the given ID.
     * Retrieves the staff member details.
     * Renders the 'staff.show' view, passing the staff member details to the view.
     *
     * @param int $id The ID of the staff member to display.
     * @return \Illuminate\View\View Renders the 'staff.show' view with the staff member details.
     */

    public function show($id)
    {
        $staff = $this->getStaff($id);
        Cache::put('staff' . $id, $staff, 300);
        return view('staff.show')->with('staff', $staff);
    }

    /**
     * Deletes a staff member.
     *
     * Attempts to find the staff member with the given ID.
     * Checks if the staff member exists.
     * Deletes the staff member's image if it exists and is not a placeholder image.
     * Marks the staff member as deleted by setting the 'isDelete' attribute to true and updating the 'endDate' attribute with the current date.
     * Saves the changes to the staff member.
     * Flashes a success message if the staff member is successfully deleted.
     * Catches any exceptions that occur during the process and flashes an error message.
     * Redirects back to the staff index page.
     *
     * @param int $id The ID of the staff member to delete.
     * @return \Illuminate\Http\RedirectResponse Redirects back to the staff index page.
     */

    public function destroy($id)
    {
        try {
            $staff = $this->getStaff($id);

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
            Cache::forget('provider' . $id);
            Session::flash('success', 'Personnel successfully eliminated.');

        } catch (\Exception $e) {
            Session::flash('error', 'Error when deleting staff: ' . $e->getMessage());
            return redirect()->back();
        }

        return redirect()->route('staff.index');
    }

    /**
     * Updates information about a staff member.
     *
     * Attempts to find the staff member with the given ID.
     * If the staff member doesn't exist, redirects back.
     * Validates the request data:
     *   - 'name', 'dni', 'email', 'lastname', and 'role' are required and must be strings.
     *   - 'dni' and 'email' must be unique in the 'staff' table.
     *   - 'image' is optional but if provided, must be an image file with allowed extensions and within size limits.
     * If the request contains a file for the 'image' field:
     *   - Deletes the existing staff member's image if it's not the default placeholder image and exists in storage.
     *   - Stores the new image in the 'public/staff' directory.
     * Updates the staff member's information with the validated data.
     * Redirects to the staff index page after successful update.
     * Catches any exceptions and redirects back.
     *
     * @param int $id The ID of the staff member to update.
     * @param \Illuminate\Http\Request $request The HTTP request containing the updated data.
     * @return \Illuminate\Http\RedirectResponse Redirects to the staff index page after successful update or back in case of errors.
     */

    public function update(Request $request, $id)
    {
        $staff = $this->getStaff($id);
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
            Cache::forget('provider' . $id);
            return redirect()->route('staff.index');

        } catch (Exception $e) {
            return redirect()->back();

        }
    }

    /**
     * Stores information about a new staff member.
     *
     * Validates the request data:
     *   - 'name', 'dni', 'email', 'lastname', and 'role' are required and must be strings.
     *   - 'dni' and 'email' must be unique in the 'staff' table.
     *   - 'image' is optional but if provided, must be an image file with allowed extensions and within size limits.
     * Creates a new staff member instance and sets its attributes with the validated data:
     *   - Generates a UUID for the staff member's ID.
     *   - Sets the start date to the current date and time.
     *   - Sets 'isDelete' to false and 'endDate' to null.
     * If the request contains a file for the 'image' field, stores the image in the 'public/staff' directory.
     * Otherwise, sets the staff member's image to the default placeholder image.
     * Saves the staff member to the database.
     * Flashes a success message and redirects to the staff index page after successful creation.
     * Catches any exceptions and redirects back.
     *
     * @param \Illuminate\Http\Request $request The HTTP request containing the new staff member's data.
     * @return \Illuminate\Http\RedirectResponse Redirects to the staff index page after successful creation or back in case of errors.
     */

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

    /**
     * Recovers a soft-deleted staff member.
     *
     * Finds the staff member with the given ID.
     * Sets the 'isDelete' attribute to false to mark the staff member as recovered.
     * Saves the updated staff member to the database.
     * Redirects to the staff index page.
     *
     * @param string $id The ID of the staff member to recover.
     * @return \Illuminate\Http\RedirectResponse Redirects to the staff index page after successful recovery.
     */

    public function recover($id)
    {
        $staff = $this->getStaff($id);
        $staff->isDelete = false;
        $staff->save();
        Cache::forget('provider' . $id);

        return redirect()->route('staff.index');
    }

    /**
     * Displays the form to edit a staff member.
     *
     * Finds the staff member with the given ID, or throws a 404 error if not found.
     * Passes the found staff member to the staff edit view.
     *
     * @param string $id The ID of the staff member to edit.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory The staff edit view with the staff member data.
     */

    public function edit($id)
    {
        $staff = $this->getStaff($id);
        Cache::put('staff' . $id, $staff, 300);
        return view('staff.edit')->with('staff', $staff);
    }

    /**
     * Displays the form to create a new staff member.
     *
     * Returns the staff create view.
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory The staff create view.
     */

    public function create()
    {
        return view('staff.create');

    }

    /**
     * Displays the form to edit the image of a staff member.
     *
     * @param int $id The ID of the staff member.
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory The staff image edit view.
     */

    public function editImage($id)
    {
        $staff = $this->getStaff($id);
        Cache::put('staff' . $id, $staff, 300);
        return view('staff.image')->with('staff', $staff);
    }

    public function updateImage(Request $request, $id)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        try {
            $staff = $this->getStaff($id);
            if ($staff->image != staff::$IMAGE_DEFAULT && Storage::exists('public/' . $staff->image)) {
                Storage::delete('public/' . $staff->image);
            }
            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $fileToSave = Str::uuid() . '.' . $extension;
            $staff->image = $image->storeAs('staff', $fileToSave, 'public');
            $staff->save();
            Cache::forget('staff' . $id);
            flash('Personal ' . $staff->name . ' successfully updated
')->success()->important();
            return redirect()->route('staff.index');
        } catch (Exception $e) {
            flash('error', 'Error updating personnel' . $e->getMessage())->error()->important();
            return redirect()->back();
        }
    }

    public function getStaff($id){
        return Cache::has('staff' . $id) ? Cache::get('staff' . $id) : staff::find($id);
    }
}
