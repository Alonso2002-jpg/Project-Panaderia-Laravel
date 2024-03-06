<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    /**
     * Displays a paginated list of categories, optionally filtered by a search term.
     *
     * Retrieves categories from the database, applying a search filter if a search term
     * is provided in the request. Categories are ordered by their ID in ascending order
     * and paginated, with a limit of 3 categories per page. Returns the categories index
     * view, passing the paginated categories object for display.
     *
     * @param \Illuminate\Http\Request $request Contains the optional search term for filtering categories.
     * @return \Illuminate\View\View Returns a view displaying the paginated list of categories.
     */

    public function index(Request $request)
    {
        $categories = Category::search($request->search)->orderBy('id', 'asc')->paginate(3);
        return view('categories.index')->with('categories', $categories);
    }

    /**
     * Displays details of a specific category.
     *
     * Checks if the category details are already stored in cache. If not, it retrieves the
     * category from the database using its ID. The category is then cached for future requests
     * to reduce database load. Returns the category details view, passing the category object
     * for display.
     *
     * @param int|string $id The ID of the category to display.
     * @return \Illuminate\View\View Returns a view displaying the category details.
     */

    public function show($id)
    {
        if (Cache::has('category' . $id)) {
            $category = Cache::get('category' . $id);
        } else {
            $category = Category::find($id);
        }
        Cache::put('category' . $id, $category, 300);
        return view('categories.show')->with('category', $category);
    }

    /**
     * Displays the form for creating a new category.
     *
     * Returns the view that contains the form for creating a new category, enabling users to input
     * category details.
     *
     * @return \Illuminate\View\View Returns a view with the form to create a new category.
     */

    public function create()
    {
        return view('categories.create');
    }

    /**
     * Stores a new category in the database.
     *
     * Validates the incoming request to ensure the category name meets specified criteria
     * (minimum length, maximum length, required, and unique within the 'categories' table).
     * If validation passes, a new category instance is created, saved to the database, and
     * a success flash message is displayed. If the category name fails validation or an
     * exception occurs during save, an error flash message is shown and the user is redirected
     * back to the previous page.
     *
     * @param \Illuminate\Http\Request $request Contains the data needed to create a new category.
     * @return \Illuminate\Http\RedirectResponse Redirects to the appropriate view with a flash message.
     */

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'min:4|max:120|required|unique:categories,name',
        ]);
        try {
            $category = new Category();
            $category->name = strtoupper($request->name);
            $category->save();
            flash('Category ' . $category->name . ' successfully created.')->success()->important();
            return redirect()->route('categories.index');
        } catch (Exception $e) {
            flash('There is already another category with the same name')->error()->important();
            return redirect()->back();
        }

    }

    /**
     * Displays the edit form for a specific category.
     *
     * Attempts to find the category by its ID. If the category exists and the ID is not 0,
     * it returns the edit view with the category data for editing. If the category does not exist
     * or an invalid ID is provided, it redirects to the categories index route with an error flash
     * message indicating an invalid route. This ensures that only valid categories can be edited.
     *
     * @param int|string $id The ID of the category to be edited.
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse Returns a view for editing the category or a redirect response if the category cannot be found or the ID is invalid.
     */

    public function edit($id)
    {
        try {
            $category = Category::find($id);
            if ($category && $id != 0) {
                return view('categories.edit')->with('category', $category);
            } else {
                flash('Invalid route')->error()->important();
                return redirect()->route('categories.index');
            }
        } catch (Exception $e) {
            flash('Invalid route')->error()->important();
            return redirect()->route('categories.index');
        }
    }

    /**
     * Updates the specified category with new data.
     *
     * Validates the request data to ensure the category name is unique (except for the category
     * being updated), has a minimum length of 4 characters, and a maximum length of 120 characters.
     * If validation passes, it attempts to find the category by its ID and updates its name with
     * the provided value, converting it to uppercase. It then clears the category cache to reflect
     * the update and redirects to the categories index route with a success flash message. If the
     * category cannot be found or the name is not unique, it redirects back with an error flash message.
     *
     * @param \Illuminate\Http\Request $request Contains the data to update the category.
     * @param int|string $id The ID of the category to be updated.
     * @return \Illuminate\Http\RedirectResponse Redirects to the categories index route with a flash message or back with an error.
     */

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'min:4|max:120|required|unique:categories,name,' . $id,
        ]);
        try {
            $category = Category::find($id);
            $category->name = strtoupper($request->name);
            $category->save();
            Cache::forget('category' . $id);
            flash('Category ' . $category->name . ' successfully updated')->success()->important();
            return redirect()->route('categories.index');
        } catch (Exception $e) {
            flash('There is already another category with the same name')->error()->important();
            return redirect()->back();
        }
    }

    /**
     * Displays the form to edit the image of a specific category.
     *
     * Attempts to find the category by its ID. If the category exists, it returns the view
     * for editing the category's image, passing along the category object. If the category
     * does not exist, or if an error occurs, it redirects to the categories index route with
     * an error flash message indicating an invalid route. This method ensures that image edits
     * are attempted only on existing categories.
     *
     * @param int|string $id The ID of the category whose image is to be edited.
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse Returns a view for editing the category's image or a redirect response if the category cannot be found.
     */

    public function editImage($id)
    {
        try {
            $category = Category::find($id);
            if ($category) {
                return view('categories.image')->with('category', $category);
            } else {
                flash('Invalid route')->error()->important();
                return redirect()->route('categories.index');
            }
        } catch (Exception $e) {
            flash('Invalid route')->error()->important();
            return redirect()->route('categories.index');
        }
    }

    /**
     * Updates the image of a specific category.
     *
     * Validates the uploaded image to ensure it is of a valid type (jpeg, png, jpg, gif, svg) and does not exceed
     * the size limit of 2048 kilobytes. If validation passes, it attempts to find the category by its ID and updates
     * its image. If the category already has a non-default image, the existing image is deleted from the storage. The
     * new image is then saved in the 'category' directory of the public storage, and its path is saved to the category's
     * 'image' attribute. The category cache is cleared to reflect the update. Redirects to the categories index route
     * with a success flash message. If an error occurs during the process, redirects back with an error flash message.
     *
     * @param \Illuminate\Http\Request $request Contains the new image file.
     * @param int|string $id The ID of the category whose image is to be updated.
     * @return \Illuminate\Http\RedirectResponse Redirects to the categories index route with a flash message or back with an error.
     */

    public function updateImage(Request $request, $id)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        try {
            $category = Category::find($id);
            if ($category->image != Category::$IMAGE_DEFAULT && Storage::exists('public/' . $category->image)) {
                Storage::delete('public/' . $category->image);
            }

            $image = $request->file('image');
            $extension = $image->getClientOriginalExtension();
            $fileToSave = Str::uuid() . '.' . $extension;
            $category->image = $image->storeAs('category', $fileToSave, 'public');
            $category->save();
            Cache::forget('category' . $id);
            flash('Category ' . $category->name . ' successfully updated')->warning()->important();
            return redirect()->route('categories.index');
        } catch (Exception $e) {
            flash('Error updating Category ' . $e->getMessage())->error()->important();
            return redirect()->back();
        }
    }

    /**
     * Deletes a specific category from the database.
     *
     * Attempts to find the category by its ID. If the category exists and the ID is not 1, it updates all products
     * that are associated with the category to have no category. It then deletes the category from the database and
     * clears the category cache. Redirects to the categories index route with a success flash message. If the category
     * does not exist or the ID is invalid, it redirects back with an error flash message.
     *
     * @param int|string $id The ID of the category to be deleted.
     * @return \Illuminate\Http\RedirectResponse Redirects to the categories index route with a flash message or back with an error.
     */
    public function destroy($id)
    {
        if ($id != 1) {
            try {
                $category = Category::find($id);
                $category->updateProductWithOutCategory($id);
                $category->delete();
                Cache::forget('category' . $id);
                flash('Category ' . $category->name . ' successfully removed')->success()->important();
                return redirect()->route('categories.index');
            } catch (Exception $e) {
                flash('Error when deleting Category' . $e->getMessage())->error()->important();
                return redirect()->back();
            }
        } else {
            flash('Invalid route')->error()->important();
            return redirect()->back();
        }
    }

    /**
     * Displays a paginated list of deleted categories.
     *
     * Retrieves deleted categories from the database, ordered by their ID in ascending order and paginated,
     * with a limit of 3 categories per page. Returns the deleted categories index view, passing the paginated
     * categories object for display.
     *
     * @return \Illuminate\View\View Returns a view displaying the paginated list of deleted categories.
     */
    public function recover($id)
    {
        $category = Category::find($id);
        $category->isDelete = false;
        $category->save();
        Cache::forget('category' . $id);
        return redirect()->route('categories.index');
    }
}
